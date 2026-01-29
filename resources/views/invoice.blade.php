<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedai Cendana - Nota #{{ $order->external_id }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .invoice-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin: 3rem auto;
            max-width: 800px;
        }

        .invoice-header {
            background-color: #fff;
            padding: 3rem;
            border-bottom: 2px solid #f8f9fa;
        }

        .invoice-logo {
            max-width: 150px;
        }

        .invoice-body {
            padding: 3rem;
        }

        .table-invoice th {
            font-weight: 600;
            color: #6c757d;
            border-bottom: 2px solid #eee;
            padding-bottom: 1rem;
        }

        .table-invoice td {
            padding-top: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f8f9fa;
        }

        .total-section {
            background-color: #f8f9fa;
            padding: 2rem 3rem;
            border-top: 2px solid #eee;
        }

        .btn-print {
            background-color: #333;
            color: #fff;
            border: none;
        }

        .btn-print:hover {
            background-color: #000;
            color: #fff;
        }

        .text-orange {
            color: #e67e22 !important;
        }

        @media (max-width: 768px) {
            .invoice-header {
                padding: 1.5rem !important;
                flex-direction: column !important;
                text-align: center !important;
            }

            .invoice-header .text-end {
                text-align: center !important;
                margin-top: 1.5rem;
            }

            .invoice-body {
                padding: 1.5rem !important;
            }

            .total-section {
                padding: 1.5rem !important;
            }

            .table-invoice thead {
                display: none;
            }

            .table-invoice tr {
                display: block;
                margin-bottom: 2rem;
                border: 1px solid #f1f1f1;
                padding: 1rem;
                border-radius: 0.75rem;
            }

            .table-invoice td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right !important;
                padding: 0.75rem 0;
                border-bottom: 1px dashed #f1f1f1;
            }

            .table-invoice td:last-child {
                border-bottom: none;
            }

            .table-invoice td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
                text-align: left;
                margin-right: 1rem;
            }

            .table-invoice td .fw-bold.d-block {
                text-align: right;
            }
        }

        @media print {
            body {
                background: #fff;
            }

            .invoice-card {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
                border: none;
            }

            .no-print {
                display: none !important;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-card">
            <div class="invoice-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1">Kedai Cendana</h1>
                    <p class="text-secondary mb-0">Invoice Pembelian</p>
                </div>
                <div class="text-end">
                    <h2 class="h5 fw-bold text-secondary mb-1">#{{ $order->external_id }}</h2>
                    <p class="text-secondary small mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
                    <span
                        class="badge {{ $order->payment_status == 'PAID' ? 'bg-success' : 'bg-warning text-dark' }} mt-2">
                        {{ $order->payment_status == 'PAID' ? 'LUNAS' : $order->payment_status }}
                    </span>
                </div>
            </div>

            <div class="invoice-body">
                <div class="table-responsive">
                    <table class="table table-invoice w-100">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Item</th>
                                <th class="text-end" style="width: 20%;">Harga Satuan</th>
                                <th class="text-center" style="width: 10%;">Qty</th>
                                <th class="text-end" style="width: 20%;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td data-label="Item">
                                        <span class="fw-bold d-block">{{ $item->nama_produk }}</span>
                                        @if (str_contains($item->nama_produk, '(Reward)'))
                                            <small class="text-orange fst-italic">Ditukar dengan Poin</small>
                                        @endif
                                    </td>
                                    <td data-label="Harga Satuan" class="text-end">Rp
                                        {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td data-label="Qty" class="text-center">{{ $item->jumlah }}</td>
                                    <td data-label="Subtotal" class="text-end fw-bold">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="total-section mt-5">
                <div class="row g-4 align-items-end">
                    <div class="col-md-7">
                        <div class="p-4 bg-light rounded-4 border border-opacity-10 h-100 mb-0 text-start">
                            <h6 class="text-uppercase fw-bold small text-muted mb-3">Informasi Pelanggan & Pengiriman
                            </h6>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <p class="mb-1 fw-bold">{{ $order->user->nama_user }}</p>
                                    <p class="mb-1 text-secondary small">{{ $order->user->email }}</p>
                                    <p class="mb-0 text-secondary small">{{ $order->phone_number }}</p>
                                </div>
                                <div class="col-sm-6 mt-3 mt-sm-0">
                                    <div class="ps-sm-3 border-sm-start h-100">
                                        <p class="mb-0 text-secondary small lh-base">
                                            {{ $order->shipping_address }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="ps-md-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Subtotal</span>
                                @php
                                    $subtotalValue = $order->total_amount / 1.11;
                                    $ppnValue = $order->total_amount - $subtotalValue;
                                @endphp
                                <span class="fw-bold">Rp {{ number_format($subtotalValue, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom border-opacity-10">
                                <span class="text-secondary">Pajak (11%)</span>
                                <span class="fw-bold">Rp {{ number_format($ppnValue, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold mb-0">Total Bayar</span>
                                <div class="text-end">
                                    <span class="h3 fw-bold text-orange mb-0 d-block">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    <small class="text-secondary" style="font-size: 0.7rem;">*Sudah termasuk PPN</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="p-4 text-center no-print bg-white rounded-bottom-4 d-flex flex-wrap justify-content-center gap-2">
                <button onclick="window.print()" class="btn btn-print rounded-pill px-4 py-2">
                    <i class="bi bi-printer me-2"></i>Cetak Nota
                </button>
                <a href="{{ route('history.download', $order->id_order) }}"
                    class="btn btn-outline-secondary rounded-pill px-4 py-2">
                    <i class="bi bi-download me-2"></i>Download PDF
                </a>
                <a href="{{ route('history.index') }}" class="btn btn-light rounded-pill px-4 py-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</body>

</html>
