@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Produk</h3>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>

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
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        @foreach($produks as $produk)
        <tr>
            <td>{{ $produk->nama_produk }}</td>
            <td>{{ $produk->kategori->nama_kategori }}</td>
            <td>{{ number_format($produk->harga) }}</td>
            <td>{{ $produk->stok }}</td>
            <td><img src="{{ asset('storage/'.$produk->gambar) }}" width="80" /></td>
            <td>
                <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="form-delete" data-id="{{ $produk->id }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
                e.preventDefault(); // Stop submit dulu

                Swal.fire({
                    title: 'Yakin ingin menghapus produk ini?',
                    text: 'Data tidak bisa dikembalikan setelah dihapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit kalau setuju
                    }
                });
            });
        });
    });
</script>
@endsection