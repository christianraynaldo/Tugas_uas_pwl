<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatKonsumen extends Model
{
    protected $fillable = [
        'konsumen_id',
        'provinsi_id',
        'provinsi_nama',
        'kota_id',
        'kota_nama',
        'kecamatan_id',
        'kecamatan_nama',
        'alamat_lengkap',
        'kode_pos',
    ];


    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }
}
