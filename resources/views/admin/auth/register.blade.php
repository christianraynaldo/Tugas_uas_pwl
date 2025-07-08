@extends('layouts.app')

@section('content')
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff, #e9e3ff);
        font-family: 'Segoe UI', sans-serif;
        overflow-y: auto;

    }

    .register-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 60px;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        padding: 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 500px;
        transition: transform 0.3s;
        margin-top: 20px;
    }

    .register-card:hover {
        transform: translateY(-3px);
    }

    .form-control:focus {
        border-color: #a3b2ff;
        box-shadow: 0 0 0 0.2rem rgba(105, 122, 148, 0.25);
    }

    .form-label {
        font-weight: 600;
    }

    .btn-primary {
        border-radius: 50px;
        font-weight: 600;
    }

    .register-link {
        text-align: center;
        margin-top: 1rem;
    }

    .register-link a {
        text-decoration: none;
        color: #0d6efd;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
    .register-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 20px;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <h3 class="text-center mb-4 text-primary">Register Admin</h3>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.register') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email aktif" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Daftar</button>
            </div>
        </form>
        <div class="register-link">
            <p>Sudah punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login?</a></p>
        </div>
    </div>
</div>

<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="loginModalLabel">Login Sebagai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <a href="{{ route('admin.login') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-person-badge"></i> Admin
                </a>
                <a href="{{ route('konsumen.login') }}" class="btn btn-outline-success w-100">
                    <i class="bi bi-person-circle"></i> Konsumen
                </a>
            </div>
        </div>
    </div>
</div>
@endsection