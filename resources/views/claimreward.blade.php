<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Claim Reward - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
</head>
<body>
    @include('layout.header')

    <main class="container py-5 mt-5">
        <div class="row g-4 mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb" class="py-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('reward.index') }}" class="text-decoration-none text-secondary small">Reward</a></li>
                        <li class="breadcrumb-item active small" aria-current="page">Claim Reward</li>
                    </ol>
                </nav>
                <div class="d-flex align-items-end justify-content-between border-bottom pb-4">
                    <div>
                        <h1 class="h2 fw-bold mb-1">Konfirmasi Reward</h1>
                        <p class="text-secondary mb-0">Tukar poin untuk mendapatkan reward pilihanmu.</p>
                    </div>
                    <div class="text-end d-none d-md-block">
                        <span class="badge bg-light text-dark px-4 py-2 rounded-pill border fw-bold">
                            Poin Kamu: {{ number_format($userPoints, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center g-3">
                            <div class="col-4 col-md-2">
                                <div class="ratio ratio-1x1 rounded-3 overflow-hidden shadow-sm">
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
                                    <img src="{{ $finalImg }}" alt="{{ $product->nama_produk }}" class="object-fit-cover">
                                </div>
                            </div>
                            <div class="col-8 col-md-6">
                                <h6 class="fw-bold mb-1 fs-5">{{ $product->nama_produk }}</h6>
                                <p class="text-secondary small mb-2">Reward: {{ number_format($pointsPerItem, 0, ',', '.') }} Poin / item</p>
                                <div class="d-inline-flex align-items-center bg-light rounded-pill p-1 border">
                                    <span class="px-3 small text-secondary">Jumlah</span>
                                    <input type="text" class="form-control border-0 bg-transparent text-center fw-bold" value="{{ $qty }}" readonly style="width: 50px;">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 text-md-end">
                                <span class="text-secondary small d-block mb-1">Total Poin</span>
                                <span class="fw-bold fs-4 text-dark">{{ number_format($pointsRequired, 0, ',', '.') }} Poin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card summary-card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-xl-5">
                        <h4 class="fw-bold mb-4">Ringkasan Penukaran</h4>
                        <div class="summary-item d-flex justify-content-between">
                            <span class="text-secondary">Total Poin Dibutuhkan</span>
                            <span class="fw-bold fs-5">{{ number_format($pointsRequired, 0, ',', '.') }} Poin</span>
                        </div>
                        <div class="summary-item d-flex justify-content-between">
                            <span class="text-secondary">Poin Tersedia</span>
                            <span class="fw-bold fs-5">{{ number_format($userPoints, 0, ',', '.') }} Poin</span>
                        </div>
                        <div class="pt-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="h5 fw-bold mb-0">Sisa Poin</span>
                                <span class="h3 fw-bold mb-0 text-dark">
                                    {{ number_format(max(0, $userPoints - $pointsRequired), 0, ',', '.') }} Poin
                                </span>
                            </div>
                            <p class="text-muted small mb-0 font-italic">*Penukaran tidak dikenakan pajak.</p>
                        </div>
                        <form method="POST" action="{{ route('reward.checkout') }}" class="d-grid gap-3">
                            @csrf
                            <input type="hidden" name="id_produk" value="{{ $product->id_produk }}">
                            <input type="hidden" name="qty" value="{{ $qty }}">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold">
                                Bayar dengan Poin
                            </button>
                            <a href="{{ route('reward.index') }}" class="btn btn-light rounded-pill py-3 text-secondary fw-semibold border">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Reward
                            </a>
                        </form>
                        @error('points')
                        <div class="alert alert-warning mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>
</html>
