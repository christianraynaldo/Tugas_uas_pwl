@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Order</h3>

    {{-- Alert sukses --}}
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    @endif


    {{-- Filter Form --}}
    <form method="GET" action="{{ route('admin.order.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">-- Semua Status --</option>
                <option value="belum bayar" {{ request('status') == 'belum bayar' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="sudah bayar" {{ request('status') == 'sudah bayar' ? 'selected' : '' }}>Sudah Bayar</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Tombol Export --}}
    <div class="mb-3">
        <a href="{{ route('admin.order.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn btn-success btn-sm">Export Excel</a>
        <a href="{{ route('admin.order.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn btn-danger btn-sm">Export PDF</a>
    </div>

    {{-- Tabel Order --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Order</th>
                <th>Konsumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Ekspedisi</th>
                <th>Total + Ongkir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>{{ $order->kode_order }}</td>
                <td>{{ $order->konsumen->nama }}</td>
                <td>{{ $order->tanggal_order }}</td>
                <td>
                    @php
                    $status = strtolower($order->status);
                    $badgeClass = match($status) {
                    'belum bayar' => 'bg-secondary',
                    'sudah bayar' => 'bg-primary' ,
                    'pesanan dikirim' => 'bg-warning text-dark',
                    'pesanan diterima' => 'bg-info text-dark',
                    'selesai' => 'bg-success',
                    default => 'bg-light text-dark',
                    };
                    @endphp

                    <span class="badge rounded-pill {{ $badgeClass }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->ekspedisi }}</td>
                <td>Rp {{ number_format($order->total + $order->ongkir, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.order.show', $order) }}" class="btn btn-info btn-sm">Detail</a>

                    <!-- Tombol Buka Modal -->
                    @if($order->status === 'selesai')
                    <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                    @else
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $order->id }}">
                        Update Pesanan
                    </button>
                    @endif


                    <!-- Modal Update Status -->
                    <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.order.update-status', $order->id) }}" method="POST" class="form-update-status">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStatusModalLabel{{ $order->id }}">Update Status Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="statusSelect{{ $order->id }}" class="form-label">Pilih Status</label>
                                            <select class="form-select" id="statusSelect{{ $order->id }}" name="status" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="pesanan dikirim" {{ $order->status == 'pesanan dikirim' ? 'selected' : '' }}>Pesanan Dikirim</option>
                                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-update-status').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Hentikan submit dulu
                Swal.fire({
                    title: 'Yakin ingin menyimpan perubahan status?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection