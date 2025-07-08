@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Keranjang Belanja</h3>

    {{-- Alamat Pengiriman (Hanya tampil jika login & punya alamat) --}}
    @if(Auth::guard('konsumen')->check())
    @php $user = Auth::guard('konsumen')->user(); @endphp
    @if($user->alamats->isNotEmpty())
    @php $alamat = $user->alamats->last(); @endphp
    <div class="mb-3">
        <h5>Alamat Pengiriman</h5>
        <p>
            {{ $alamat->alamat_lengkap }}<br>
            {{ $alamat->kecamatan_nama }}, {{ $alamat->kota_nama }}, {{ $alamat->provinsi_nama }}, {{ $alamat->kode_pos ?? '-' }}<br>
        </p>
    </div>
    @else
    <div class="alert alert-warning">
        Anda belum memiliki alamat. <a href="{{ route('alamat.create') }}" class="btn btn-sm btn-primary">+ Tambah Alamat</a>
    </div>
    @endif
    @endif

    {{-- Pesan sukses --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tampilkan isi keranjang --}}
    @if(!empty($cart))
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
            @php
            $qty = $item['qty'] ?? $item['jumlah'] ?? 0;
            $subtotal = $item['harga'] * $qty;
            $total += $subtotal;
            @endphp

            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                <td>
                    @auth('konsumen')
                    <form action="{{ route('cart.update', $id) }}" method="POST">
                        @csrf
                        <input type="number" name="qty" value="{{ $item['qty'] ?? 0 }}" min="1" class="form-control d-inline-block" style="width: 80px;">
                        <button class="btn btn-sm btn-primary">Update</button>
                    </form>
                    @else
                    {{ $item['qty'] ?? 0 }} item
                    @endauth
                </td>

                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- Tombol Checkout hanya untuk user yang login --}}
    @auth('konsumen')
    <a href="{{ route('cart.checkout') }}" class="btn btn-success">Checkout</a>
    @else
    <div class="alert alert-info">
        <strong>Login untuk melanjutkan proses checkout.</strong><br>
        <a href="{{ route('konsumen.login') }}" class="btn btn-primary mt-2">Login Sekarang</a>
    </div>
    @endauth

    @else
    <p>Keranjang kamu kosong.</p>
    @endif
</div>
@endsection