@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        @if (Auth::guard('admin')->check())
        <h1 class="fw-bold">🎉 Selamat Datang, {{ Auth::guard('admin')->user()->nama }}!</h1>
        @endif
        <p class="lead text-muted">Ini adalah <strong>Dashboard Admin</strong> Blangkis. Kelola data dengan mudah dan cepat.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">📒 Kategori</h5>
                    <p class="card-text text-muted">Kelola daftar kategori yang ditampilkan di toko.</p>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-success">Kelola Kategori</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">📦 Produk</h5>
                    <p class="card-text text-muted">Kelola daftar produk yang ditampilkan di toko.</p>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-primary">Kelola Produk</a>
                </div>
            </div>
        </div>



        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">📈 Order</h5>
                    <p class="card-text text-muted">Lihat order dan status transaksi oleh konsumen.</p>
                    <a href="{{ route('admin.order.index') }}" class="btn btn-outline-success">Kelola Order</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title mb-3">👥 Konsumen</h5>
                    <p class="card-text text-muted">Kelola daftar konsumen yang sudah daftar akun.</p>
                    <a href="{{ route('admin.konsumen.index') }}" class="btn btn-outline-success">Kelola Konsumen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection