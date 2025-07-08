@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Order</h2>
    <p><strong>Kode Order:</strong> {{ $order->kode_order }}</p>
    <p><strong>Konsumen:</strong> {{ $order->konsumen->nama }} ({{ $order->konsumen->email }})</p>
    <p><strong>Tanggal:</strong> {{ $order->tanggal_order }}</p>
    <p><strong>Ekspedisi:</strong> {{ $order->ekspedisi }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    @if ($order->bukti_bayar)
        <p><strong>Bukti Bayar:</strong> <a href="{{ asset('storage/' . $order->bukti_bayar) }}" target="_blank">Lihat</a></p>
    @endif

    <h4>Item Pesanan</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->details as $detail)
            <tr>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Produk:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
    <p><strong>Ongkir:</strong> Rp {{ number_format($order->ongkir, 0, ',', '.') }}</p>
    <p><strong>Total Bayar:</strong> Rp {{ number_format($order->total + $order->ongkir, 0, ',', '.') }}</p>

    {{-- Tombol Export PDF --}}
    <a href="{{ route('cart.exportPdf', $order->id) }}" class="btn btn-danger mt-3">Download Invoice PDF</a>
</div>
@endsection
