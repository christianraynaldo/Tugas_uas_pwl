@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Data Konsumen</h3>
    <a href="{{ route('admin.konsumen.create') }}" class="btn btn-primary mb-3">+ Tambah Konsumen</a>

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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Login Method</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($konsumens as $key => $konsumen)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $konsumen->nama }}</td>
                <td>{{ $konsumen->email }}</td>
                <td>{{ $konsumen->telepon }}</td>
                <td>{{ $konsumen->alamat }}</td>
                <td>{{ $konsumen->login_method ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.konsumen.destroy', $konsumen->id) }}" method="POST" class="form-delete" data-id="{{ $konsumen->id }}" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.form-delete').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Hentikan form submit

                Swal.fire({
                    title: 'Yakin ingin menghapus kategori ini?',
                    text: 'Data tidak bisa dikembalikan setelah dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Kirim form jika setuju
                    }
                });
            });
        });
    });
</script>
@endsection