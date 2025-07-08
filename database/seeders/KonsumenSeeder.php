<?php

namespace Database\Seeders;

use App\Models\Konsumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KonsumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Konsumen::create([
            'nama' => 'Konsumen Uji Coba',
            'email' => 'konsumen@example.com',
            'password' => Hash::make('password'),
            'alamat' => 'Jl. Pelanggan No. 9',
            'telepon' => '082112223333',
            'login_method' => 'manual',
        ]);
    }
}
