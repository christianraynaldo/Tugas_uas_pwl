<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
    protected $fillable = [
        'order_id',
        'produk_id',
        'harga',
        'jumlah',
        'subtotal',
    ];
}
