<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $order->kode_order }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h3>Invoice - {{ $order->kode_order }}</h3>
    <p><strong>Konsumen:</strong> {{ $order->konsumen->nama }} ({{ $order->konsumen->email }})</p>
    <p><strong>Tanggal Order:</strong> {{ $order->tanggal_order }}</p>
    <p><strong>Ekspedisi:</strong> {{ $order->ekspedisi }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

    <h4>Detail Pesanan</h4>
    <table>
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
    <p><strong>Grand Total:</strong> Rp {{ number_format($order->total + $order->ongkir, 0, ',', '.') }}</p>
</body>
</html>
