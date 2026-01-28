<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reward - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @include('layout.header')

    <main class="container py-5 mt-5">
        <nav aria-label="breadcrumb" class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}"
                        class="text-decoration-none text-secondary small">Beranda</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Reward Member</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between border-bottom pb-4 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Reward Member</h1>
                <p class="text-secondary mb-0">Tukarkan poin Anda dengan berbagai penawaran menarik.</p>
            </div>
            <div class="text-end mt-3 mt-md-0">
                <span class="badge bg-light text-dark px-4 py-2 rounded-pill border fw-bold">
                    Poin Kamu: {{ Auth::check() ? number_format(Auth::user()->points, 0, ',', '.') : 0 }}
                </span>
            </div>
        </div>

        <div class="d-flex flex-column align-items-center mb-5">
            {{-- <h1 class="h3 mb-4 fw-bold">Reward Member</h1> --}}

            <div class="d-flex gap-3 w-100 justify-content-center" style="max-width: 500px;">
                <button class="btn btn-warning fw-bold py-3 flex-fill shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#qrModal" data-mode="reward"
                    style="background-color: #ffd67c; border-color: #ffd67c; color: #222;">
                    <i class="bi bi-qr-code-scan me-2"></i>Claim Reward
                </button>
                <button class="btn btn-outline-warning fw-bold py-3 flex-fill shadow-sm"
                    onclick="window.location.href='{{ route('history.index') }}'"
                    style="border-color: #ffd67c; color: #dfa328;">
                    <i class="bi bi-clock-history me-2"></i>History Reward
                </button>
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($products as $product)
                <div class="col-6 col-md-3">
                    <div class="card product-card h-100 border-0 shadow-sm position-relative cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#rewardProductModal" data-id="{{ $product->id_produk }}"
                        data-nama="{{ $product->nama_produk }}" data-deskripsi="{{ $product->deskripsi }}"
                        data-stok="{{ $product->stok }}" data-poin="{{ (int) ($product->point_price ?? 1000) }}" <!--
                        Stock Badge -->
                        @if ($product->stok > 10)
                            <span class="stock-badge stock-available"><i
                                    class="bi bi-check2-circle me-1"></i>Tersedia</span>
                        @elseif($product->stok > 0)
                            <span class="stock-badge stock-limited"><i
                                    class="bi bi-exclamation-triangle me-1"></i>Terbatas ({{ $product->stok }})</span>
                        @else
                            <span class="stock-badge stock-out"><i class="bi bi-x-circle me-1"></i>Habis</span>
                        @endif

                        <div class="ratio ratio-4x3 overflow-hidden">
                            @php
                                $imgPath = $product->gambar;
                                if ($imgPath) {
                                    if (\Illuminate\Support\Str::startsWith($imgPath, ['http://', 'https://'])) {
                                        $finalImg = $imgPath;
                                    } else {
                                        $finalImg = asset('storage/' . $imgPath);
                                    }
                                } else {
                                    $finalImg = asset('images/image2.webp');
                                }
                            @endphp
                            <img src="{{ $finalImg }}" class="card-img-top object-fit-cover"
                                alt="{{ $product->nama_produk }}" data-gambar="{{ $finalImg }}">
                        </div>
                        <div class="card-body">
                            <h2 class="h6 product-title mb-1">{{ $product->nama_produk }}</h2>
                            <div class="text-secondary small mb-2"
                                style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ $product->deskripsi }}
                            </div>
                            <strong class="product-price text-warning">1.000 Poin</strong>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center">Belum ada reward tersedia.</div>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Reward Product Modal -->
    <div class="modal fade" id="rewardProductModal" tabindex="-1" aria-labelledby="rewardProductModalLabel"
        aria-hidden="true" data-auth="{{ Auth::check() ? 'true' : 'false' }}">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-light p-4">
                    <h5 class="modal-title fw-bold" id="rewardProductModalLabel">Detail Reward</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-lg-5">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="ratio ratio-1x1 rounded-4 overflow-hidden shadow-sm">
                                <img id="rewardModalImage" src="" class="object-fit-cover w-100 h-100"
                                    alt="">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="ps-md-3">
                                <h2 id="rewardModalTitle" class="h3 fw-bold mb-2"></h2>
                                <div class="d-flex align-items-center mb-3">
                                    <span id="rewardModalPrice" class="h4 fw-bold text-warning mb-0 me-3">1.000
                                        Poin</span>
                                    <span id="rewardModalStockBadge" class="stock-badge"></span>
                                </div>
                                <hr class="my-3 opacity-10">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div
                                        class="qty-selector d-flex align-items-center bg-light rounded-pill p-2 border">
                                        <span class="small text-secondary me-2">Jumlah</span>
                                        <input type="text" id="rewardModalQty"
                                            class="form-control form-control-sm border-0 bg-transparent text-center fw-bold"
                                            value="1" readonly style="width: 40px;">
                                    </div>
                                    <div class="text-end">
                                        <small class="text-secondary d-block">Subtotal</small>
                                        <span id="rewardModalTotal" class="fw-bold text-dark">1.000 Poin</span>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-2">Deskripsi</h6>
                                <div class="modal-description-scroll mb-4">
                                    <p id="rewardModalDesc" class="text-secondary mb-0"></p>
                                </div>
                                <div class="bg-light p-3 rounded-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-secondary small">Status Stok</span>
                                        <span id="rewardModalStockCount" class="fw-bold small"></span>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex">
                                    <button type="button" class="btn btn-primary rounded-pill px-4 flex-grow-1"
                                        id="btnRewardBuyNow">
                                        <span class="text-dark">Beli Sekarang</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
    <script>
        const rewardModal = document.getElementById('rewardProductModal');
        if (rewardModal) {
            const title = rewardModal.querySelector('#rewardModalTitle');
            const image = rewardModal.querySelector('#rewardModalImage');
            const price = rewardModal.querySelector('#rewardModalPrice');
            const desc = rewardModal.querySelector('#rewardModalDesc');
            const stockBadge = rewardModal.querySelector('#rewardModalStockBadge');
            const stockCount = rewardModal.querySelector('#rewardModalStockCount');
            const qtyInput = rewardModal.querySelector('#rewardModalQty');
            const totalEl = rewardModal.querySelector('#rewardModalTotal');
            const btnBuyNow = rewardModal.querySelector('#btnRewardBuyNow');

            rewardModal.addEventListener('show.bs.modal', function(event) {
                const card = event.relatedTarget;
                const id = card.getAttribute('data-id');
                const nama = card.getAttribute('data-nama');
                const deskripsi = card.getAttribute('data-deskripsi');
                const stok = card.getAttribute('data-stok');
                // Use product point price from server if available
                const poin = parseInt(card.getAttribute('data-poin')) || 1000;
                const gambar = card.querySelector('img').getAttribute('data-gambar');

                btnBuyNow.setAttribute('data-id', id);
                title.textContent = nama;
                image.src = gambar;
                image.alt = nama;
                price.textContent = `${poin.toLocaleString('id-ID')} Poin`;
                desc.textContent = deskripsi;
                stockCount.textContent = `${stok} Porsi`;
                qtyInput.value = 1;
                const updateTotal = () => {
                    const qty = 1;
                    qtyInput.value = 1;
                    totalEl.textContent = `${(qty * poin).toLocaleString('id-ID')} Poin`;
                };
                updateTotal();
                // Qty fixed to 1: no plus/minus handlers
                stockBadge.className = 'stock-badge';
                if (parseInt(stok) > 10) {
                    stockBadge.classList.add('stock-available');
                    stockBadge.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Tersedia';
                } else if (parseInt(stok) > 0) {
                    stockBadge.classList.add('stock-limited');
                    stockBadge.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>Terbatas (${stok})`;
                } else {
                    stockBadge.classList.add('stock-out');
                    stockBadge.innerHTML = '<i class="bi bi-x-circle me-1"></i>Habis';
                }
                btnBuyNow.disabled = parseInt(stok) <= 0;
                btnBuyNow.onclick = (e) => {
                    const isAuth = rewardModal.getAttribute('data-auth') === 'true';
                    if (!isAuth) {
                        e.preventDefault();
                        window.showLoginAlert("Klaim Reward",
                            "Yuk login dulu untuk menukarkan poin kamu dengan reward menarik!");
                        return;
                    }
                    const qty = 1;
                    window.location.href =
                        `{{ route('reward.claim') }}?id=${encodeURIComponent(id)}&qty=${encodeURIComponent(qty)}`;
                };
            });
        }
    </script>
</body>

</html>
