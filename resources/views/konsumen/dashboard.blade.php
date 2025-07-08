@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4 text-center fw-bold">🛍️ Daftar Produk Blangkis</h3>
<form action="{{ route('konsumen.dashboard') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="{{ request('q') }}">
        <button class="btn btn-outline-primary" type="submit">🔍 Cari</button>
    </div>
</form>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($produks as $produk)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('storage/'.$produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}" style="height: 180px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                    <h8>{{ $produk->deskripsi }}</h8>
                    <p class="text-success fw-semibold mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                    <form action="{{ route('cart.add', $produk->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <div class="input-group input-group-sm mb-2">
                            <input type="number" name="qty" value="1" min="1" class="form-control" />
                            <button class="btn btn-success" type="submit">+ Keranjang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
