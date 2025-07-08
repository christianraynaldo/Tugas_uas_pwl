<!DOCTYPE html>
<html>
<head>
    <title>Daftar Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        thead {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        th {
            color: #444;
            font-weight: bold;
        }

        td {
            color: #555;
        }
    </style>
</head>
<body>
    <h3>Daftar Order</h3>

    <table>
        <thead>
            <tr>
                <th>Kode Order</th>
                <th>Konsumen</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Ekspedisi</th>
                <th>Total + Ongkir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->kode_order }}</td>
                <td>{{ $order->konsumen->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->ekspedisi }}</td>
                <td>Rp {{ number_format($order->total + $order->ongkir, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
