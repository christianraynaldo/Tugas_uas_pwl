<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }
    private function fields()
    {
        return [
            'nama_kategori' => [
                'label' => 'Nama Kategori',
                'type'  => 'text',
                'rules' => 'required|string|max:100',
            ],
        ];
    }

    public function create()
    {
        return view('admin.form', [
            'fields' => $this->fields(),
            'title'  => 'Kategori',
            'route'  => 'admin.kategori', // nama resource route
        ]);
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.form', [
            'fields' => $this->fields(),
            'title'  => 'Kategori',
            'route'  => 'admin.kategori',
            'data'   => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        Kategori::create($request->only('nama_kategori'));

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
