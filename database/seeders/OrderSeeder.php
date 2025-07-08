<?php
namespace Database\Seeders;

use App\Models\Konsumen;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $konsumen = Konsumen::first() ?? Konsumen::factory()->create();
        $produk   = Produk::first() ?? Produk::factory()->create([
            'nama_produk' => 'Blangkon Coklat',
            'harga'       => 75000,
        ]);

        $kodeOrder = 'ORD-' . now()->format('YmdHis');

        $totalProduk = $produk->harga * 2;
        $ongkir      = 10000;

        $order = Order::create([
            'konsumen_id'   => $konsumen->id,
            'kode_order'    => $kodeOrder,
            'tanggal_order' => now(),
            'total'         => $totalProduk,
            'ongkir'        => $ongkir,
            'ekspedisi'     => 'JNE',
            'status'        => 'belum bayar',
        ]);

        OrderDetail::create([
            'order_id'  => $order->id,
            'produk_id' => $produk->id,
            'harga'     => $produk->harga,
            'jumlah'    => 2,
            'subtotal'  => $totalProduk,
        ]);
    }
}
