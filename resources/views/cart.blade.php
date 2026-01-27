<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang Belanja - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-soft: rgba(44, 62, 80, 0.05);
            --accent-soft: rgba(255, 214, 124, 0.15);
        }

        body {
            background-color: #f8fafc;
            color: #334155;
        }

        .cart-item-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.02) !important;
        }

        .cart-item-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06) !important;
        }

        .qty-controls {
            background: #f1f5f9;
            border-radius: 50px;
            padding: 2px;
            display: inline-flex;
            align-items: center;
            border: 1px solid #e2e8f0;
        }

        .btn-qty-cart {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border-radius: 50%;
            border: none;
            color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .btn-qty-cart:hover:not(:disabled) {
            background: var(--accent-color);
            color: #000;
            transform: scale(1.1);
        }

        .btn-qty-cart:active:not(:disabled) {
            transform: scale(0.95);
        }

        .btn-qty-cart:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .summary-card {
            border: none;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04) !important;
        }

        .summary-item {
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .summary-item:last-of-type {
            border-bottom: none;
        }

        .whatsapp-btn {
            background: #25D366;
            color: #fff;
            border: none;
            transition: all 0.3s;
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.2);
        }

        .empty-state-container {
            padding: 4rem 1rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "\2192";
            color: #94a3b8;
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
        }

        .product-img-wrapper::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.05), transparent);
        }

        .animate-price {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    @include('layout.header')

    <main class="container py-5 mt-5">
        <div class="row g-4 mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="py-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('homepage') }}" class="text-decoration-none text-secondary small">Beranda</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">Keranjang Belanja</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-end justify-content-between border-bottom pb-4">
                    <div>
                        <h1 class="h2 fw-bold mb-1">Keranjang Saya</h1>
                        <p class="text-secondary mb-0">Kelola pesanan Anda sebelum lanjut ke pembayaran.</p>
                    </div>
                    <div class="text-end d-none d-md-block">
                        <span class="badge bg-primary-soft text-dark px-4 py-2 rounded-pill border border-primary border-opacity-10 fw-bold">
                            <i class="bi bi-cart3 me-2"></i><span id="cart-count-badge">{{ count($cartItems) }}</span> Menu Terpilih
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4" id="cart-content" style="{{ count($cartItems) == 0 ? 'display:none;' : '' }}">
            <div class="col-lg-8" id="cart-items-container">
                @foreach($cartItems as $item)
                <div class="card cart-item-card border-0 shadow-sm mb-3 rounded-4" id="cart-item-{{ $item->id_item }}">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center g-3">
                            <div class="col-4 col-md-2">
                                <div class="product-img-wrapper ratio ratio-1x1 shadow-sm">
                                    @php
                                    $imgPath = $item->product->gambar;
                                    if ($imgPath) {
                                    if (Str::startsWith($imgPath, ['http://', 'https://'])) {
                                    $finalImg = $imgPath;
                                    } else {
                                    $finalImg = Storage::url($imgPath);
                                    }
                                    } else {
                                    $finalImg = asset('images/image2.webp');
                                    }
                                    @endphp
                                    <img src="{{ $finalImg }}" class="object-fit-cover" alt="{{ $item->product->nama_produk }}">
                                </div>
                            </div>
                            <div class="col-8 col-md-4">
                                <span class="badge bg-light text-secondary mb-2 border">Food & Beverage</span>
                                <h6 class="fw-bold mb-1 fs-5">{{ $item->product->nama_produk }}</h6>
                                <p class="text-secondary small mb-3">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} <span class="text-muted">/ Pcs</span></p>
                                <button class="btn btn-sm btn-link text-danger p-0 text-decoration-none fw-semibold btn-remove" data-id="{{ $item->id_item }}">
                                    <i class="bi bi-trash-fill me-1"></i>Hapus Menu
                                </button>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="d-flex flex-column align-items-md-center">
                                    <label class="text-secondary small mb-2 d-md-none">Jumlah Pesanan:</label>
                                    <div class="qty-controls shadow-sm">
                                        <button class="btn btn-qty-cart btn-qty" data-id="{{ $item->id_item }}" data-action="decrease" {{ $item->jumlah <= 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <input type="text" class="form-control border-0 text-center bg-transparent fw-bold fs-5 qty-input-val" value="{{ $item->jumlah }}" readonly style="width: 50px;">
                                        <button class="btn btn-qty-cart btn-qty" data-id="{{ $item->id_item }}" data-action="increase">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 text-end">
                                <span class="text-secondary small d-block mb-1">Total Harga</span>
                                <span class="fw-bold fs-4 text-dark animate-price" id="item-subtotal-{{ $item->id_item }}">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="col-lg-4">
                <div class="card summary-card sticky-top" style="top: 100px;">
                    <div class="card-body p-4 p-xl-5">
                        <h4 class="fw-bold mb-4">Detail Pembayaran</h4>

                        <div class="summary-item d-flex justify-content-between">
                            <span class="text-secondary">Subtotal Pesanan</span>
                            <span class="fw-bold fs-5" id="subtotal-amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="summary-item d-flex justify-content-between">
                            <span class="text-secondary">Pajak (PPN 11%)</span>
                            <span class="fw-bold text-dark fs-5" id="ppn-amount">Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="h5 fw-bold mb-0">Total Akhir</span>
                                <span class="h3 fw-bold mb-0 text-dark animate-price" id="total-amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-muted small mb-0 font-italic">*Sudah termasuk pajak restoran.</p>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="button" id="btn-process-payment" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold">
                                Bayar Sekarang
                            </button>
                            <a href="{{ route('homepage') }}#menu" class="btn btn-light rounded-pill py-3 text-secondary fw-semibold border">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Menu Lain
                            </a>
                        </div>

                        <div class="mt-5 p-3 rounded-4 bg-light border border-opacity-10 text-center">
                            <p class="small text-secondary mb-0">
                                <i class="bi bi-info-circle-fill me-1 text-orange"></i>
                                Pesanan akan langsung kami proses setelah pembayaran berhasil.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="row justify-content-center" style="{{ count($cartItems) > 0 ? 'display:none;' : '' }}">
            <div class="col-md-6 col-lg-5 text-center empty-state-container">
                <div class="mb-4">
                    <div class="bg-white shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 140px; height: 140px;">
                        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    </div>
                </div>
                <h3 class="fw-bold">Keranjang Anda Kosong</h3>
                <p class="text-secondary mb-5">Sepertinya Anda belum memilih menu lezat kami. Yuk, jelajahi menu spesial Kedai Cendana sekarang!</p>
                <a href="{{ route('homepage') }}#menu" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                    Mulai Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
    <script>
        // Formatted WhatsApp message generator
        // Payment Process
        document.getElementById('btn-process-payment').addEventListener('click', function() {
            const btn = this;
            const originalContent = btn.innerHTML;

            // Loading State
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            btn.disabled = true;

            fetch('{{ route("payment.checkout") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(async response => {
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const data = await response.json();
                        if (!response.ok) {
                            throw new Error(data.message || 'Server returned error ' + response.status);
                        }
                        return data;
                    } else {
                        const text = await response.text();
                        console.error("Non-JSON Response:", text);
                        // Extract title from HTML if possible
                        const match = text.match(/<title>(.*?)<\/title>/i);
                        const title = match ? match[1] : 'Unknown Server Error (' + response.status + ')';
                        throw new Error('Server Error: ' + title);
                    }
                })
                .then(data => {
                    if (data.invoice_url) {
                        window.location.href = data.invoice_url;
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan tanpa pesan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memproses Pembayaran',
                        text: error.message,
                        confirmButtonColor: '#2c3e50'
                    });
                    // Reset Button
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                });
        });

        // Initial call
        // Initialize tooltips/popovers if any
    </script>
</body>

</html>