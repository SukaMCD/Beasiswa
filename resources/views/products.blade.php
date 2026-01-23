<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>

<body>
    @include('layout.header')

    <main class="container py-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <h1 class="h3 mb-2 mb-md-0">Produk</h1>
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Cari produk...">
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($products as $product)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100 border-0 shadow-sm position-relative">
                    <!-- Stock Badge -->
                    @if($product->stok > 10)
                    <span class="stock-badge stock-available"><i class="bi bi-check2-circle me-1"></i>Tersedia</span>
                    @elseif($product->stok > 0)
                    <span class="stock-badge stock-limited"><i class="bi bi-exclamation-triangle me-1"></i>Terbatas ({{ $product->stok }})</span>
                    @else
                    <span class="stock-badge stock-out"><i class="bi bi-x-circle me-1"></i>Habis</span>
                    @endif

                    <div class="ratio ratio-4x3 overflow-hidden">
                        @php
                        $imgPath = $product->gambar;
                        if ($imgPath) {
                        if (Str::startsWith($imgPath, ['http://', 'https://'])) {
                        $finalImg = $imgPath;
                        } else {
                        $finalImg = asset('storage/' . $imgPath);
                        }
                        } else {
                        $finalImg = asset('images/image2.webp');
                        }
                        @endphp
                        <img src="{{ $finalImg }}" class="card-img-top object-fit-cover" alt="{{ $product->nama_produk }}">
                    </div>
                    <div class="card-body">
                        <h2 class="h6 product-title mb-1">{{ $product->nama_produk }}</h2>
                        <div class="text-secondary small mb-2" style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $product->deskripsi }}
                        </div>
                        <strong class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light border">Belum ada produk.</div>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>

</html>