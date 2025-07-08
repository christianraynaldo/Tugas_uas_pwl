<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\AlamatKonsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = [];

        if (Auth::guard('konsumen')->check()) {
            $konsumen = Auth::guard('konsumen')->user();

            // Ambil cart dari database
            $cartDb = Cart::with('produk')->where('konsumen_id', $konsumen->id)->get();

            // Format cart
            foreach ($cartDb as $item) {
                $cart[$item->produk_id] = [
                    'nama'  => $item->produk->nama_produk,
                    'harga' => $item->produk->harga,
                    'qty'   => $item->jumlah,
                ];
            }
        } else {
            $cartSession = session('cart', []);

            // Konversi agar semua item pakai 'qty'
            foreach ($cartSession as $key => $item) {
                $cart[$key] = [
                    'nama'  => $item['nama'],
                    'harga' => $item['harga'],
                    'qty'   => $item['qty'] ?? ($item['jumlah'] ?? 0),
                ];
            }
        }


        return view('konsumen.cart.index', compact('cart'));
    }


    public function add(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $qty = $request->input('qty', 1);

        if (Auth::guard('konsumen')->check()) {
            // Jika sudah login, simpan ke database
            $konsumen = Auth::guard('konsumen')->user();

            $cart = Cart::where('konsumen_id', $konsumen->id)
                ->where('produk_id', $id)
                ->first();

            if ($cart) {
                $cart->jumlah += $qty;
                $cart->save();
            } else {
                Cart::create([
                    'konsumen_id' => $konsumen->id,
                    'produk_id'   => $id,
                    'jumlah'      => $qty,
                ]);
            }
        } else {
            // Jika belum login, simpan ke session
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['jumlah'] += $qty;
            } else {
                $cart[$id] = [
                    'id'        => $produk->id,
                    'nama'      => $produk->nama_produk, // sesuaikan nama kolom
                    'harga'     => $produk->harga,
                    'jumlah'    => $qty,
                    'gambar'    => $produk->gambar,      // opsional, jika ingin ditampilkan
                ];
            }

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    public function remove($id)
    {
        $cartItem = Cart::where('konsumen_id', Auth::guard('konsumen')->id())
            ->where('id', $id)
            ->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('konsumen_id', Auth::guard('konsumen')->id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->jumlah = $request->qty;
        $cartItem->save();
        dd($cartItem);

        dd(Cart::where('konsumen_id', Auth::guard('konsumen')->id())->get());

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkout()
    {
        $konsumen = Auth::guard('konsumen')->user();

        $alamat = $konsumen->alamats()->latest()->first();

        if (! $alamat) {
            return redirect()->route('alamat.create')->with('error', 'Silakan tambahkan alamat terlebih dahulu.');
        }

        $kotaId = $alamat->kota_id;

        // 🔥 Ambil cart items milik konsumen
        $cartItems = Cart::with('produk')
            ->where('konsumen_id', $konsumen->id)
            ->get();

        // 🔥 Hitung total
        $total = $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah);

        // Ongkir sementara dummy (bisa diganti pakai RajaOngkir)
        $ongkir = 10000;

        return view('konsumen.cart.checkout', compact('alamat', 'kotaId', 'cartItems', 'total', 'ongkir'));
    }

    public function processCheckout(Request $request)
    {
        $konsumen  = Auth::guard('konsumen')->user();
        $alamat    = $konsumen->alamats()->latest()->first();
        $cartItems = Cart::with('produk')->where('konsumen_id', $konsumen->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total  = $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah);
        $ongkir = 10000;

        DB::beginTransaction();
        try {
            \Log::info('Checkout mulai');

            $order = Order::create([
                'konsumen_id'   => $konsumen->id,
                'kode_order'    => 'ORD-' . strtoupper(\Illuminate\Support\Str::random(6)),
                'tanggal_order' => now(),
                'total'         => $total,
                'ongkir'        => $ongkir,
                'ekspedisi'     => 'JNE',
                'status'        => 'belum bayar',
            ]);
            \Log::info('Order dibuat', ['id' => $order->id]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id'  => $order->id,
                    'produk_id' => $item->produk_id,
                    'harga'     => $item->produk->harga,
                    'jumlah'    => $item->jumlah,
                    'subtotal'  => $item->produk->harga * $item->jumlah,
                ]);
            }

            Cart::where('konsumen_id', $konsumen->id)->delete();

            DB::commit();

            return redirect()->route('order.uploadBukti', $order->id)
                ->with('success', 'Order berhasil dibuat. Silakan upload bukti pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal checkout: ' . $e->getMessage());

            return back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }

    public function uploadBuktiForm($id)
    {
        $order = Order::where('konsumen_id', Auth::guard('konsumen')->id())->findOrFail($id);
        return view('konsumen.order.upload-bukti', compact('order'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $order = Order::where('konsumen_id', Auth::guard('konsumen')->id())->findOrFail($id);

        $request->validate([
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $file     = $request->file('bukti_bayar');
        $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('bukti-bayar', $filename, 'public');

        $order->update([
            'bukti_bayar' => $path,
            'status'      => 'sudah bayar',
        ]);

        return redirect()->route('konsumen.dashboard')->with('success', 'Bukti bayar berhasil diupload. Terima kasih!');
    }

    public function orderKonsumen(Request $request)
    {
        $konsumen = Auth::guard('konsumen')->user();

        $query = Order::with('konsumen')->where('konsumen_id', $konsumen->id);

        // Filter by date
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_order', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_order', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        return view('konsumen.order.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'status' => 'required|in:belum bayar,sudah bayar,pesanan dikirim,selesai,pesanan diterima',
            'bukti_bayar' => $request->status === 'sudah bayar' ? 'required|file|mimes:jpg,jpeg,png,pdf|max:2048' : 'nullable',
        ]);

        $order = Order::findOrFail($id);

        if ($request->status === 'sudah bayar' && $request->hasFile('bukti_bayar')) {
            $file     = $request->file('bukti_bayar');
            $filename = 'bukti_' . time() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('bukti-bayar', $filename, 'public');

            $order->update([
                'status' => 'sudah bayar',
                'bukti_bayar' => $path,
            ]);
        } else {
            $order->update([
                'status' => $request->status,
            ]);
        }

        return redirect()->route('cart.orderKonsumen')->with('success', 'Status pesanan diperbarui.');
    }


   public function showDetail($id)
{
    $order = Order::with(['konsumen', 'details.produk'])->findOrFail($id);

    // Cek apakah user adalah pemilik order
    if (auth('konsumen')->id() !== $order->konsumen_id) {
        abort(403, 'Akses tidak diizinkan');
    }

    return view('konsumen.order.show', compact('order'));
}


public function exportPdf($id)
{
    $order = Order::with(['konsumen', 'details.produk'])->findOrFail($id);

    // Cek apakah user adalah pemilik order
    if (auth('konsumen')->id() !== $order->konsumen_id) {
        abort(403, 'Akses tidak diizinkan');
    }

   $pdf = Pdf::loadView('konsumen.cart.invoice', compact('order'));


    return $pdf->download('invoice-' . $order->kode_order . '.pdf');
    
}

}
