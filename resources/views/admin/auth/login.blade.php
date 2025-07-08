@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
        background: linear-gradient(135deg, rgb(240, 240, 255), rgb(220, 225, 250));
        font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
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

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        padding: 2.5rem;
        border-radius: 1.5rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 420px;
        transition: transform 0.3s;
        margin-top: 80px;
    }

    .login-card:hover {
        transform: translateY(-3px);
    }

    .form-control:focus {
        border-color: rgb(200, 200, 255);
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
</style>

<div class="login-container">
    <div class="login-card">
        <h3 class="text-center mb-4 text-primary">Login Admin</h3>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Login</button>
            </div>
        </form>

        {{-- Register Link --}}
        <div class="register-link">
            <p>Belum punya akun? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register?</a></p>
        </div>
    </div>
</div>

<!-- Modal Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="registerModalLabel">Register Sebagai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <a href="{{ route('admin.register') }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="bi bi-person-plus"></i> Admin
                </a>
                <a href="{{ route('konsumen.register') }}" class="btn btn-outline-success w-100">
                    <i class="bi bi-person-plus-fill"></i> Konsumen
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
