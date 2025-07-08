@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Alamat</h3>
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

    <form action="{{ route('alamat.store') }}" id="formAlamat" method="POST">
        @csrf

        <div class="mb-3">
            <label>Provinsi</label>
            <select id="provinsi" name="provinsi_id" class="form-control" required>
                <option value="">-- Pilih Provinsi --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kabupaten/Kota</label>
            <select id="kota" name="kota_id" class="form-control" required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kecamatan</label>
            <select id="kecamatan" name="kecamatan_id" class="form-control" required>
                <option value="">-- Pilih Kecamatan --</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Kode Pos</label>
            <input type="text" name="kode_pos" class="form-control">
        </div>

        <!-- Hidden inputs untuk menyimpan nama -->
        <input type="hidden" name="provinsi_nama" id="provinsi_nama">
        <input type="hidden" name="kota_nama" id="kota_nama">
        <input type="hidden" name="kecamatan_nama" id="kecamatan_nama">

        <button class="btn btn-primary">Simpan Alamat</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Load Provinsi
        $.get('/api/provinsi', function(data) {
            data.forEach(function(provinsi) {
                $('#provinsi').append(`<option value="${provinsi.id}">${provinsi.name}</option>`);
            });
        });

        // Saat Provinsi dipilih
        $('#provinsi').on('change', function() {
            var provinsiId = $(this).val();
            var provinsiNama = $('#provinsi option:selected').text();
            $('#provinsi_nama').val(provinsiNama);

            $('#kota').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');

            if (provinsiId) {
                $.get(`/api/kota/${provinsiId}`, function(data) {
                    data.forEach(function(kota) {
                        $('#kota').append(`<option value="${kota.id}">${kota.name}</option>`);
                    });
                });
            }
        });

        // Saat Kota dipilih
        $('#kota').on('change', function() {
            var kotaId = $(this).val();
            var kotaNama = $('#kota option:selected').text();
            $('#kota_nama').val(kotaNama);

            $('#kecamatan').html('<option value="">-- Pilih Kecamatan --</option>');

            if (kotaId) {
                $.get(`/api/kecamatan/${kotaId}`, function(data) {
                    data.forEach(function(kec) {
                        $('#kecamatan').append(`<option value="${kec.id}">${kec.name}</option>`);
                    });
                });
            }
        });

        // Saat Kecamatan dipilih
        $('#kecamatan').on('change', function() {
            var kecamatanNama = $('#kecamatan option:selected').text();
            $('#kecamatan_nama').val(kecamatanNama);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // ... semua AJAX kamu tetap sama ...

        // SweetAlert konfirmasi submit form
        $('#formAlamat').on('submit', function(e) {
            e.preventDefault(); // Stop dulu

            Swal.fire({
                title: 'Simpan alamat ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit(); // submit jika setuju
                }
            });
        });
    });
</script>

@endsection