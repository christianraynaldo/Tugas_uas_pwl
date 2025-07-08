<?php

namespace App\Http\Controllers\Konsumen;

use App\Http\Controllers\Controller;
use App\Models\AlamatKonsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alamats = Auth::guard('konsumen')->user()->alamats;
        return view('konsumen.alamat.create', compact('alamats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konsumen.alamat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'provinsi_id'    => 'required',
            'provinsi_nama'  => 'required',
            'kota_id'        => 'required',
            'kota_nama'      => 'required',
            'kecamatan_id'   => 'required', 
            'kecamatan_nama' => 'required', 
            'alamat_lengkap' => 'required',
        ]);
Log::info('Alamat Konsumen: ' . json_encode($request->all()));

        AlamatKonsumen::create([
            'konsumen_id'    => Auth::guard('konsumen')->id(),
            'provinsi_id'    => $request->provinsi_id,
            'provinsi_nama'  => $request->provinsi_nama,
            'kota_id'        => $request->kota_id,
            'kota_nama'      => $request->kota_nama,
            'kecamatan_nama' => $request->kecamatan_nama,
            'kecamatan_id'   => $request->kecamatan_id,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kode_pos'       => $request->kode_pos,
        ]);

        return redirect()->route('cart.index')->with('success', 'Alamat berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
