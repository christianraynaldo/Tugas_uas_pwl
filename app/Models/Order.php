<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'konsumen_id',
        'kode_order',
        'tanggal_order',
        'total',
        'ongkir',
        'ekspedisi',
        'bukti_bayar',
        'invoice_pdf',
        'status',
    ];
    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
