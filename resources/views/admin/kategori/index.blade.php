@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Kategori</h3>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

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
        <tr>
            <th>#</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
        @foreach($kategoris as $key => $kategori)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $kategori->nama_kategori }}</td>
            <td>
                <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="form-delete" data-id="{{ $kategori->id }}" style="display:inline;">
                    @csrf 
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
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