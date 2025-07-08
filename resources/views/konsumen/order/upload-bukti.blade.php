@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Upload Bukti Pembayaran</h3>

    <p>Kode Order: <strong>{{ $order->kode_order }}</strong></p>
    <p>Total Pembayaran: <strong>Rp {{ number_format($order->total + $order->ongkir, 0, ',', '.') }}</strong></p>

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


    <form action="{{ route('order.uploadBukti.store', $order->id) }}" method="POST" enctype="multipart/form-data" id="formUploadBukti">
        @csrf
        <div class="mb-3">
            <label for="bukti_bayar" class="form-label">Upload Bukti (jpg/png/pdf)</label>
            <input type="file" name="bukti_bayar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formUploadBukti');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const fileInput = form.querySelector('input[name="bukti_bayar"]');
            if (!fileInput.files.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti belum dipilih!',
                    text: 'Silakan unggah file bukti pembayaran terlebih dahulu.'
                });
                return;
            }

            Swal.fire({
                title: 'Yakin ingin mengunggah bukti ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Upload',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection