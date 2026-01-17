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
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="ratio ratio-4x3">
                        @php
                            $imgPath = $product->gambar;
                            if ($imgPath && !Str::startsWith($imgPath, ['http://', 'https://'])) {
                                $imgPath = '/'.ltrim($imgPath, '/');
                            }
                        @endphp
                        <img src="{{ $product->gambar ? asset($imgPath) : asset('images/image2.webp') }}" class="card-img-top object-fit-cover" alt="{{ $product->nama_produk }}">
                    </div>
                    <div class="card-body">
                        <h2 class="h6 mb-1">{{ $product->nama_produk }}</h2>
                        <div class="text-secondary small mb-2">{{ Str::limit($product->deskripsi, 60) }}</div>
                        <strong>Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
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

