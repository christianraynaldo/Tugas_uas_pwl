<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .navbar-custom {
        background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%);
        border-bottom: 1px solid #dee2e6;
    }

    .badge-position {
        top: -5px;
        right: -10px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-4">
    <div class="container">
        <a href="{{ url('/dashboard') }}" class="navbar-brand fw-bold">
            <i class="bi bi-house-door-fill"></i> Blangkis
        </a>

        <div class="d-flex align-items-center">
            {{-- Tampilkan Keranjang hanya jika login sebagai konsumen atau belum login --}}
            @if(Auth::guard('konsumen')->check() || (!Auth::guard('konsumen')->check() && !Auth::guard('admin')->check()))
            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary position-relative me-2">
                <i class="bi bi-cart3"></i> Keranjang
                <span class="position-absolute badge rounded-pill bg-danger badge-position">
                    {{ $cartCount ?? 0 }}
                </span>
            </a>
            @endif


            @auth('konsumen')
            <a href="{{ route('cart.orderKonsumen') }}" class="btn btn-outline-success me-2">
                <i class="bi bi-bag-check"></i> Order
            </a>
            <span class="me-2 fw-semibold text-dark">
                👋 Hai, {{ Auth::guard('konsumen')->user()->nama }}
            </span>
            <form action="{{ route('konsumen.logout') }}" method="POST" class="d-inline" id="logoutFormKonsumen">
                @csrf
                <button class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>

            @elseif (Auth::guard('admin')->check())
            <span class="me-2 fw-semibold text-dark">
                👋 Hai, {{ Auth::guard('admin')->user()->name }}
            </span>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline" id="logoutFormAdmin">
                @csrf
                <button class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>

            @else
            <!-- Tombol Login & Register -->
            <button class="btn btn-outline-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#registerModal">
                <i class="bi bi-person-plus"></i> Register
            </button>
            @endauth
        </div>
    </div>
</nav>

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

<script>
    document.getElementById('logoutFormAdmin')?.addEventListener('submit', function(e) {
        setTimeout(() => {
            window.location.href = "{{ route('admin.dashboard') }}";
        }, 500);
    });
    document.getElementById('logoutFormKonsumen')?.addEventListener('submit', function(e) {
        setTimeout(() => {
            window.location.href = "{{ route('konsumen.dashboard') }}";
        }, 500);
    });
</script>