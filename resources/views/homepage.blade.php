<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/filament/filament/app.css') }}" rel="stylesheet">
</head>

<body>
    @include('layout.header')

    <main>
        <!-- Carousel besar full-width -->
        <section class="container-fluid px-0 hero-offset">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner" style="height: clamp(280px, 55vh, 640px);">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/image1.webp') }}" class="d-block w-100 h-100 object-fit-cover" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/image2.webp') }}" class="d-block w-100 h-100 object-fit-cover" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/image1.webp') }}" class="d-block w-100 h-100 object-fit-cover" alt="Slide 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded-circle p-3" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Menu Favorit (Produk) -->
        <section class="container py-5">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Menu Favorit</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
            <div class="row g-3 g-lg-4">
                @forelse($products as $product)
                <div class="col-6 col-md-3">
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
                            <h3 class="h6 mb-1">{{ $product->nama_produk }}</h3>
                            <div class="text-secondary small mb-2">{{ \Illuminate\Support\Str::limit($product->deskripsi, 60) }}</div>
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
        </section>

        <!-- Tombol Menu lainnya -->
        <div class="container pb-5 text-center">
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg rounded-pill px-4">Menu lainnya</a>
        </div>

        <!-- Tentang Kami & Kontak (digabung) -->
        <section class="container pb-5">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Tentang Kami</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
            <div class="row align-items-center g-4 text-center text-lg-start">
                <div class="col-12 col-lg-6">
                    <img src="{{ asset('images/logo_cendana.png') }}" alt="Logo Kedai Cendana" class="img-fluid rounded shadow-sm" style="max-width: 60%; height: auto;">
                </div>
                <div class="col-12 col-lg-6">
                    <h3 class="h4 fw-bold mb-3">Kedai Cendana</h3>
                    <p class="lead text-secondary">Kedai Cendana adalah kedai kontemporer yang menghadirkan cita rasa autentik dengan sentuhan modern. Kami berkomitmen menyajikan hidangan berkualitas tinggi dari bahan-bahan pilihan.</p>
                    <p class="text-secondary">Dengan semangat inovasi, kami menghadirkan menu favorit untuk menemani momen spesial Anda. Bagi kami, makanan bukan sekadar santapan—tetapi pengalaman.</p>
                    <ul class="list-unstyled mb-3 text-secondary">
                        <li class="mb-1"><i class="bi bi-envelope me-2"></i>hello@kedai-cendana.test</li>
                        <li class="mb-1"><i class="bi bi-telephone me-2"></i>+62 812-1234-5678</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Bandung, Indonesia</li>
                    </ul>
                    <a href="#" class="btn btn-primary rounded-pill px-4">Selengkapnya</a>
                </div>
            </div>
        </section>

        <!-- Tulis ulasan + Lihat ulasan -->
        <section class="container pb-4">
            <div class="p-4 p-lg-5 rounded-4 border">
                <h3 class="h5 mb-3 text-center">Tulis Ulasanmu</h3>
                <form method="post" action="#">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama kamu" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="email@contoh.com" />
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ulasan</label>
                            <textarea class="form-control" rows="4" placeholder="Ceritakan pengalamanmu..."></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Rating</label>
                            <select class="form-select">
                                <option value="5">★★★★★ - Sangat Baik</option>
                                <option value="4">★★★★☆ - Baik</option>
                                <option value="3">★★★☆☆ - Cukup</option>
                                <option value="2">★★☆☆☆ - Buruk</option>
                                <option value="1">★☆☆☆☆ - Sangat Buruk</option>
                            </select>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-primary rounded-pill px-4" type="submit">Kirim Ulasan</button>
                            <a href="{{ route('reviews') }}" class="btn btn-outline-primary rounded-pill px-4 ms-2">Lihat Ulasan</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>

</html>