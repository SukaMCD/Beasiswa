<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pesanan - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>

<body class="bg-light">
    @include('layout.header')

    <main class="container py-5 mt-5">
        <h2 class="fw-bold mb-4">Riwayat Pesanan</h2>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-4 border-0 rounded-top-start">ID Pesanan</th>
                                <th class="p-4 border-0">Tanggal</th>
                                <th class="p-4 border-0">Total</th>
                                <th class="p-4 border-0">Status</th>
                                <th class="p-4 border-0 text-end rounded-top-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="p-4 fw-bold">#{{ $order->id_order }}</td>
                                <td class="p-4 text-secondary">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="p-4 fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @if($order->payment_status == 'PAID')
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Lunas</span>
                                    @elseif($order->payment_status == 'PENDING')
                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
                                    @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">{{ $order->payment_status }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-end">
                                    @if($order->payment_status == 'PENDING' && $order->payment_url)
                                    <a href="{{ $order->payment_url }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">Bayar</a>
                                    @endif
                                    <a href="{{ route('history.show', $order->id_order) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-receipt me-1"></i> Nota
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-5 text-center text-secondary">Belum ada riwayat pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')
</body>

</html>