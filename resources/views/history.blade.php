<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
    <link href="{{ asset('css/history-custom.css?v=1.0') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
</head>

<body class="bg-light">
    @include('layout.header')

    <main class="container py-5 mt-5">
        <nav aria-label="breadcrumb" class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}"
                        class="text-decoration-none text-secondary small">Beranda</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Riwayat Aktivitas</li>
            </ol>
        </nav>

        <div class="d-flex align-items-end justify-content-between border-bottom pb-4 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Riwayat Aktivitas</h1>
                <p class="text-secondary mb-0">Pantau pesanan dan riwayat poin Kedai Cendana Anda.</p>
            </div>
        </div>

        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4" id="pills-orders-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders"
                    aria-selected="true">Pesanan</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4" id="pills-points-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-points" type="button" role="tab" aria-controls="pills-points"
                    aria-selected="false">Riwayat Poin</button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!-- Tab Pesanan -->
            <div class="tab-pane fade show active" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab"
                tabindex="0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-4 border-0 rounded-top-start">ID Pesanan</th>
                                        <th class="p-4 border-0">Tanggal</th>
                                        <th class="p-4 border-0">Total</th>
                                        <th class="p-4 border-0 text-center">Status Pembayaran</th>
                                        <th class="p-4 border-0 text-center">Status Pengiriman</th>
                                        <th class="p-4 border-0 text-end rounded-top-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="p-4 fw-bold">#{{ $order->id_order }}</td>
                                            <td class="p-4 text-secondary">{{ $order->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="p-4 fw-bold">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="p-4 text-center">
                                                @if ($order->payment_status == 'PAID')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill badge-modern">Lunas</span>
                                                @elseif($order->payment_status == 'PENDING')
                                                    <span
                                                        class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill badge-modern">Menunggu</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill badge-modern">{{ $order->payment_status }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 text-center">
                                                @php
                                                    $shipStatus = $order->shipping_status ?? 'PENDING';
                                                    $shipBadgeClass = match ($shipStatus) {
                                                        'PENDING' => 'bg-secondary',
                                                        'PROCESSING' => 'bg-info',
                                                        'SHIPPED' => 'bg-warning',
                                                        'DELIVERED' => 'bg-success',
                                                        'CANCELLED' => 'bg-danger',
                                                        default => 'bg-secondary',
                                                    };
                                                    $shipLabel = match ($shipStatus) {
                                                        'PENDING' => 'Menunggu',
                                                        'PROCESSING' => 'Diproses',
                                                        'SHIPPED' => 'Dikirim',
                                                        'DELIVERED' => 'Sampai',
                                                        'CANCELLED' => 'Dibatalkan',
                                                        default => $shipStatus,
                                                    };
                                                @endphp
                                                <span
                                                    class="badge {{ $shipBadgeClass }} bg-opacity-10 {{ str_replace('bg-', 'text-', $shipBadgeClass) }} px-3 py-2 rounded-pill badge-modern">
                                                    {{ $shipLabel }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-end">
                                                @if ($order->payment_status == 'PENDING' && $order->payment_url)
                                                    <a href="{{ $order->payment_url }}"
                                                        class="btn btn-sm btn-primary rounded-pill px-3 me-2">Bayar</a>
                                                @endif
                                                <a href="{{ route('history.show', $order->id_order) }}"
                                                    class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                                    <i class="bi bi-receipt me-1"></i> Nota
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-5 text-center text-secondary">Belum ada riwayat
                                                pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Riwayat Poin -->
            <div class="tab-pane fade" id="pills-points" role="tabpanel" aria-labelledby="pills-points-tab"
                tabindex="0">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="p-4 border-0 rounded-top-start">Tanggal</th>
                                        <th class="p-4 border-0">Keterangan</th>
                                        <th class="p-4 border-0">Tipe</th>
                                        <th class="p-4 border-0 text-end rounded-top-end">Jumlah Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pointTransactions as $trx)
                                        <tr>
                                            <td class="p-4 text-secondary">{{ $trx->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="p-4">{{ $trx->description }}</td>
                                            <td class="p-4">
                                                @if ($trx->type == 'IN')
                                                    <span
                                                        class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i
                                                            class="bi bi-arrow-down-left me-1"></i>Masuk</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i
                                                            class="bi bi-arrow-up-right me-1"></i>Keluar</span>
                                                @endif
                                            </td>
                                            <td
                                                class="p-4 text-end fw-bold {{ $trx->type == 'IN' ? 'text-success' : 'text-danger' }}">
                                                {{ $trx->type == 'IN' ? '+' : '-' }}{{ number_format($trx->points, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-5 text-center text-secondary">Belum ada
                                                riwayat
                                                poin.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
