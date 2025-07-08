<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Konsumen extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'telepon',
        'foto',
        'login_method',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function alamats()
    {
        return $this->hasMany(AlamatKonsumen::class);
    }
}
