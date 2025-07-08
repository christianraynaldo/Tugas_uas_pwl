@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Checkout</h3>

    {{-- Alamat Pengiriman --}}
    <div class="mb-4">
        <h5>Alamat Pengiriman</h5>
        <p>
            {{ $alamat->alamat_lengkap }}<br>
            <strong>{{ $alamat->kecamatan_nama }}, {{ $alamat->kota_nama }}, {{ $alamat->provinsi_nama }}, {{ $alamat->kode_pos ?? '-' }}<br></strong>
        </p>
        <a href="{{ route('alamat.index') }}" class="btn btn-sm btn-warning">Ganti Alamat</a>
    </div>

    {{-- List Produk di Keranjang --}}
    <h5>Produk di Keranjang</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
            <tr>
                <td>{{ $item->produk->nama_produk }}</td>
                <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Total --}}
    <div class="mt-4">
        <p><strong>Total Produk:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
        <p><strong>Ongkir:</strong> Rp {{ number_format($ongkir, 0, ',', '.') }}</p>
        <p><strong>Total Pembayaran:</strong> Rp {{ number_format($total + $ongkir, 0, ',', '.') }}</p>
    </div>

    {{-- Tombol Bayar --}}
    <form action="{{ route('cart.processCheckout') }}" method="POST">
        @csrf
        <button class="btn btn-success">Bayar Sekarang</button>
    </form>
</div>
@endsection
