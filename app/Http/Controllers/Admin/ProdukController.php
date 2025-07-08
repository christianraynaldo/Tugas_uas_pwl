<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        return view('admin.produk.index', compact('produks'));
    }

    private function fields()
    {
        return [
            'kategori_id' => [
                'label'   => 'Kategori',
                'type'    => 'select',
                'rules'   => 'required|exists:kategoris,id',
                'options' => Kategori::pluck('nama_kategori', 'id')->toArray(),
            ],
            'nama_produk' => ['label' => 'Nama Produk', 'type' => 'text', 'rules' => 'required'],
            'deskripsi'   => ['label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'required'],
            'harga'       => ['label' => 'Harga', 'type' => 'number', 'rules' => 'required|integer'],
            'stok'        => ['label' => 'Stok', 'type' => 'number', 'rules' => 'required|integer'],
            'berat'       => ['label' => 'Berat (gram)', 'type' => 'number', 'rules' => 'required|integer'],
            'gambar'      => ['label' => 'Gambar', 'type' => 'file', 'rules' => 'nullable|image'],
        ];
    }

    public function create()
    {
        return view('admin.form', [
            'fields' => $this->fields(),
            'title'  => 'Produk',
            'route'  => 'admin.produk',
        ]);
    }

    public function edit(Produk $produk)
    {
        return view('admin.form', [
            'fields' => $this->fields(),
            'title'  => 'Produk',
            'route'  => 'admin.produk',
            'data'   => $produk,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'required',
            'harga'       => 'required|integer',
            'stok'        => 'required|integer',
            'berat'       => 'required|integer',
            'gambar'      => 'required|image|max:2048',
        ]);

        $gambar = $request->file('gambar')->store('produk', 'public');

        Produk::create($request->only(['nama_produk', 'kategori_id', 'deskripsi', 'harga', 'stok', 'berat']) + ['gambar' => $gambar]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'required',
            'harga'       => 'required|integer',
            'stok'        => 'required|integer',
            'berat'       => 'required|integer',
            'gambar'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'kategori_id', 'deskripsi', 'harga', 'stok', 'berat']);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($produk->gambar);
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Produk $produk)
    {
        Storage::disk('public')->delete($produk->gambar);
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
