<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedai Cendana - Menu Kami</title>
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
                <li class="breadcrumb-item active small" aria-current="page">Menu Kami</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between border-bottom pb-4 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Menu Kami</h1>
                <p class="text-secondary mb-0">Jelajahi berbagai hidangan lezat khas Kedai Cendana.</p>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
                @php
                    $currentCat = $categories->firstWhere('id_kategori', request('category'));
                @endphp
                <div class="dropdown">
                    <button
                        class="btn btn-outline-secondary dropdown-toggle rounded-pill px-3 py-2 border shadow-sm bg-white d-flex align-items-center"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-filter me-2"></i>
                        <span class="small">{{ $currentCat->nama_kategori ?? 'Semua Menu' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 animate slideIn">
                        <li>
                            <a class="dropdown-item rounded-3 {{ !request('category') ? 'active bg-primary text-dark' : '' }}"
                                href="{{ route('products', request()->only('search')) }}">
                                Semua Menu
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider opacity-10">
                        </li>
                        @foreach ($categories as $cat)
                            <li>
                                <a class="dropdown-item rounded-3 {{ request('category') == $cat->id_kategori ? 'active bg-primary text-dark' : '' }}"
                                    href="{{ route('products', array_merge(request()->only('search'), ['category' => $cat->id_kategori])) }}">
                                    {{ $cat->nama_kategori }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form action="{{ route('products') }}" method="GET" class="input-group" style="max-width: 300px;">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3 shadow-sm"><i
                            class="bi bi-search text-secondary"></i></span>
                    <input type="text" name="search"
                        class="form-control border-start-0 rounded-end-pill py-2 shadow-sm" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                </form>
            </div>
        </div>



        <div class="row g-3 g-lg-4">
            @forelse($products as $product)
                <div class="col-6 col-md-3">
                    <div class="card product-card h-100 border-0 shadow-sm position-relative cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#productModal" data-id="{{ $product->id_produk }}"
                        data-nama="{{ $product->nama_produk }}" data-deskripsi="{{ $product->deskripsi }}"
                        data-harga="{{ $product->harga }}" data-stok="{{ $product->stok }}"
                        @php
$imgPath=$product->gambar;
                    if ($imgPath) {
                    if (Str::startsWith($imgPath, ['http://', 'https://'])) {
                    $finalImg = $imgPath;
                    } else {
                    $finalImg = Storage::url($imgPath);
                    }
                    } else {
                    $finalImg = asset('images/image2.webp');
                    } @endphp
                        data-gambar="{{ $finalImg }}">
                        <!-- Stock Badge -->
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
                            <img src="{{ $finalImg }}" class="card-img-top object-fit-cover"
                                alt="{{ $product->nama_produk }}">
                        </div>
                        <div class="card-body">
                            <h2 class="h6 product-title mb-1">{{ $product->nama_produk }}</h2>
                            <div class="text-secondary small mb-2"
                                style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
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
