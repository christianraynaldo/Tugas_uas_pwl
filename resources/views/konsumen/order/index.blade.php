@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Pesanan Saya</h3>

    {{-- Alert sukses --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif


    {{-- Filter Form --}}
    <form method="GET" action="{{ route('cart.orderKonsumen') }}" class="row g-3 mb-4">
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
            <a href="{{ route('cart.orderKonsumen') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>



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
                    {{-- <a href="#" class="btn btn-info btn-sm">Detail</a> --}}
                    <a href="{{ route('cart.showDetail', $order) }}" class="btn btn-info btn-sm">Detail</a>

                    @if($order->status === 'selesai')
                    <button class="btn btn-secondary btn-sm" disabled>Selesai</button>
                    @else
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $order->id }}">
                        Update Pesanan
                    </button>
                    @endif

                    <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1" aria-labelledby="updateStatusModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('cart.updateStatus', $order->id) }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStatusModalLabel{{ $order->id }}">Update Status Pesanan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="statusSelect{{ $order->id }}" class="form-label">Pilih Status</label>
                                            <select class="form-select status-select" id="statusSelect{{ $order->id }}" name="status" required data-order-id="{{ $order->id }}">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="sudah bayar" {{ $order->status == 'sudah bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                                                <option value="pesanan diterima" {{ $order->status == 'pesanan diterima' ? 'selected' : '' }}>Pesanan Diterima</option>
                                            </select>
                                        </div>

                                        <!-- Upload bukti bayar jika status 'sudah bayar' -->
                                        <div class="mb-3 upload-bukti" id="uploadBukti{{ $order->id }}" style="display: none;">
                                            <label for="buktiBayar{{ $order->id }}" class="form-label">Upload Bukti Bayar (jpg/png/pdf)</label>
                                            <input type="file" class="form-control" name="bukti_bayar" id="buktiBayar{{ $order->id }}">
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        // Tambahkan ini di bawah script jQuery-mu yang sudah ada
        $('form').on('submit', function(e) {
            var form = this;
            var selectedStatus = $(form).find('.status-select').val();
            var orderId = $(form).find('.status-select').data('order-id');
            var buktiInput = $('#buktiBayar' + orderId);
            var hasFile = buktiInput.length && buktiInput[0].files.length > 0;

            // Validasi jika status 'sudah bayar' tapi belum upload file
            if (selectedStatus === 'sudah bayar' && !hasFile) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti pembayaran belum diupload!',
                    text: 'Silakan unggah bukti pembayaran terlebih dahulu.',
                });
                return;
            }

            // Tampilkan konfirmasi sebelum submit
            e.preventDefault(); // Hentikan submit dulu
            Swal.fire({
                title: 'Yakin ingin menyimpan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit form jika user setuju
                }
            });
        });

        $('.status-select').on('change', function() {
            var orderId = $(this).data('order-id');
            var selected = $(this).val();

            if (selected === 'sudah bayar') {
                $('#uploadBukti' + orderId).show();
            } else {
                $('#uploadBukti' + orderId).hide();
            }
        });

        // Trigger saat halaman load jika status sudah dipilih
        $('.status-select').each(function() {
            var orderId = $(this).data('order-id');
            if ($(this).val() === 'sudah bayar') {
                $('#uploadBukti' + orderId).show();
            }
        });
    });
</script>
@endsection