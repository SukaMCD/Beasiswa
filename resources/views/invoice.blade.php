<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->external_id }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        table td {
            padding: 5px;
            vertical-align: top;
        }

        table tr td:nth-child(2) {
            text-align: right;
        }

        .heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .item td {
            border-bottom: 1px solid #eee;
        }

        .total td {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background: #2c3e50;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .btn-print {
            background: #95a5a6;
            margin-right: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }

            .invoice-box {
                box-shadow: none;
                border: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <div>
                <h1 style="margin: 0;">Kedai Cendana</h1>
                <p>Invoice #: {{ $order->external_id }}<br>
                    Tanggal: {{ $order->created_at->format('d M Y') }}<br>
                    Status: {{ $order->payment_status }}</p>
            </div>
        </div>

        <table>
            <tr class="heading">
                <td>Item</td>
                <td>Harga</td>
            </tr>

            @foreach($order->items as $item)
            <tr class="item">
                <td>{{ $item->nama_produk }} x {{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="no-print" style="margin-top: 40px; text-align: center;">
            <button onclick="window.print()" class="btn btn-print" style="border:none; cursor:pointer;">Cetak Nota</button>
            <a href="{{ route('history.download', $order->id_order) }}" class="btn">Download PDF</a>
            <br><br>
            <br><br>
            <a href="{{ route('homepage') }}" class="btn" style="background: #3498db; margin-right: 10px;">Kembali ke Beranda</a>
            <a href="{{ route('history.index') }}" style="color: #666; text-decoration: none;">Kembali ke Riwayat</a>
        </div>
    </div>
</body>

</html>