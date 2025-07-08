@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Produk Blangkon</h3>
    <form method="GET" action="{{ route('home') }}" class="mb-3">
    <input type="text" name="search" placeholder="Cari produk..." class="form-control">
</form>
    <div class="row">
        @foreach($produks as $produk)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('storage/' . $produk->foto) }}" class="card-img-top">
                <div class="card-body">
                    <h5>{{ $produk->nama_produk }}</h5>
                    <p>Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('produk.show', $produk->id) }}" class="btn btn-info btn-sm">Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
