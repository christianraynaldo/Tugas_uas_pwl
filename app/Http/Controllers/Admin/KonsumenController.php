<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KonsumenController extends Controller
{
    private function fields()
    {
        return [
            'nama' => ['label' => 'Nama', 'type' => 'text', 'rules' => 'required|string|max:100'],
            'email' => ['label' => 'Email', 'type' => 'email', 'rules' => 'required|email|unique:konsumens,email'],
            'password' => ['label' => 'Password', 'type' => 'password', 'rules' => 'nullable|min:6'],
            'telepon' => ['label' => 'Telepon', 'type' => 'text', 'rules' => 'nullable'],
            'alamat' => ['label' => 'Alamat', 'type' => 'textarea', 'rules' => 'nullable'],
            'login_method' => ['label' => 'Login Method', 'type' => 'text', 'rules' => 'nullable'],
        ];
    }

    public function index()
    {
        $konsumens = Konsumen::latest()->get();
        return view('admin.konsumen.index', compact('konsumens'));
    }

    public function create()
    {
        return view('admin.form', [
            'fields' => $this->fields(),
            'title' => 'Konsumen',
            'route' => 'admin.konsumen'
        ]);
    }

    public function store(Request $request)
    {
        $fields = $this->fields();
        $rules = [];

        foreach ($fields as $key => $val) {
            if ($key == 'password') {
                $rules[$key] = 'required|min:6';
            } else {
                $rules[$key] = $val['rules'];
            }
        }

        $data = $request->validate($rules);
        $data['password'] = Hash::make($data['password']);
        Konsumen::create($data);

        return redirect()->route('admin.konsumen.index')->with('success', 'Konsumen berhasil ditambahkan.');
    }

    public function edit(Konsumen $konsumen)
    {
        $fields = $this->fields();
        $fields['email']['rules'] .= ','.$konsumen->id;
        $fields['password']['rules'] = 'nullable|min:6';

        return view('admin.form', [
            'fields' => $fields,
            'data' => $konsumen,
            'title' => 'Konsumen',
            'route' => 'admin.konsumen'
        ]);
    }

    public function update(Request $request, Konsumen $konsumen)
    {
        $fields = $this->fields();
        $rules = [];

        foreach ($fields as $key => $val) {
            if ($key == 'email') {
                $rules[$key] = $val['rules'] . ',' . $konsumen->id;
            } elseif ($key == 'password') {
                $rules[$key] = 'nullable|min:6';
            } else {
                $rules[$key] = $val['rules'];
            }
        }

        $data = $request->validate($rules);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $konsumen->update($data);

        return redirect()->route('admin.konsumen.index')->with('success', 'Konsumen berhasil diupdate.');
    }

    public function destroy(Konsumen $konsumen)
    {
        $konsumen->delete();
        return redirect()->route('admin.konsumen.index')->with('success', 'Konsumen berhasil dihapus.');
    }
}
