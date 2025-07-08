<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $key;
    protected $baseUrl;

    public function __construct()
    {
        $this->key = env('RAJAONGKIR_API_KEY'); // simpan di .env
        $this->baseUrl = 'https://api.rajaongkir.com/starter'; // untuk akun Starter
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->get("{$this->baseUrl}/province");

        return $response->json()['rajaongkir']['results'];
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->get("{$this->baseUrl}/city", [
            'province' => $provinceId
        ]);

        return $response->json()['rajaongkir']['results'];
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->post("{$this->baseUrl}/cost", [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight, // dalam gram
            'courier' => $courier // jne, tiki, pos
        ]);

        return $response->json()['rajaongkir']['results'][0]['costs'];
    }
}
