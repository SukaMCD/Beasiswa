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
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
</head>

<body>
    @include('layout.header')
    @include('layout.hero')

    <main>

        <!-- Menu Favorit (Produk) -->
        <section class="container py-5" id="menu">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Menu Favorit</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
            <div class="row g-3 g-lg-4">
                @forelse($products as $product)
                <div class="col-6 col-md-3">
                    <div class="card product-card h-100 border-0 shadow-sm position-relative">
                        <!-- Stock Badge -->
                        @if($product->stok > 10)
                        <span class="stock-badge stock-available"><i class="bi bi-check2-circle me-1"></i>Tersedia</span>
                        @elseif($product->stok > 0)
                        <span class="stock-badge stock-limited"><i class="bi bi-exclamation-triangle me-1"></i>Stok Terbatas ({{ $product->stok }})</span>
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
                            // Handle Filament storage path
                            $finalImg = Storage::url($imgPath);
                            }
                            } else {
                            $finalImg = asset('images/image2.webp');
                            }
                            @endphp
                            <img src="{{ $finalImg }}" class="card-img-top object-fit-cover" alt="{{ $product->nama_produk }}">
                        </div>
                        <div class="card-body">
                            <h3 class="h6 product-title mb-1">{{ $product->nama_produk }}</h3>
                            <div class="text-secondary small mb-2" style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ $product->deskripsi }}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <strong class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
                                <div class="d-flex align-items-center bg-light px-2 py-1 rounded-pill border">
                                    <i class="bi bi-box-seam text-secondary me-1" style="font-size: 0.8rem;"></i>
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">{{ $product->stok }}</span>
                                </div>
                            </div>
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

        <!-- pocer -->
        <section class="container pb-5" id="voucher">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Voucher</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
        </section>

        <!-- Tentang Kami & Kontak (digabung) -->
        <section class="container pb-5" id="about">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Tentang Kami</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
            <div class="row align-items-center g-4 text-center text-lg-start">
                <div class="col-12 col-lg-6">
                    <img src="{{ asset('images/logo_cendana.webp') }}" alt="Logo Kedai Cendana" class="img-fluid rounded shadow-sm" style="max-width: 60%; height: auto;">
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

        <!-- sec kontak cuyy -->
        <section class="container pb-5" id="contact">
            <div class="p-4 p-lg-5 rounded-4 border bg-white shadow-sm">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold mb-2">Kontak Kami</h2>
                    <p class="text-secondary">Punya pertanyaan? Kirim pesan kepada kami dan kami akan segera membalasnya.</p>
                </div>
                <form id="contact-form">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="user_name" class="form-control py-2 px-3 rounded-3" placeholder="Nama lengkap Anda" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="user_email" class="form-control py-2 px-3 rounded-3" placeholder="email@contoh.com" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Pesan</label>
                            <textarea name="message" class="form-control py-2 px-3 rounded-3" rows="4" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button class="btn btn-primary rounded-pill px-5 py-2 fw-bold" type="submit" id="submit-btn">
                                <span id="btn-text">Kirim Pesan</span>
                                <span id="btn-loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
                <div id="form-feedback" class="mt-3 text-center d-none"></div>
            </div>
        </section>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
        <script type="text/javascript">
            (function() {
                emailjs.init("U85vb-TLi4QCplmwy");
            })();

            document.getElementById('contact-form').addEventListener('submit', function(event) {
                event.preventDefault();

                const btn = document.getElementById('submit-btn');
                const btnText = document.getElementById('btn-text');
                const btnLoader = document.getElementById('btn-loader');
                const feedback = document.getElementById('form-feedback');

                btn.disabled = true;
                btnText.classList.add('d-none');
                btnLoader.classList.remove('d-none');

                emailjs.sendForm('service_i0zo3zo', 'template_m8ajqzd', this)
                setTimeout(() => {
                    feedback.classList.remove('d-none', 'alert-danger');
                    feedback.classList.add('alert', 'alert-success');
                    feedback.innerHTML = '<i class="bi bi-check-circle me-2"></i>Pesan Anda telah terkirim! Terima kasih.';

                    document.getElementById('contact-form').reset();

                    btn.disabled = false;
                    btnText.classList.remove('d-none');
                    btnLoader.classList.add('d-none');
                }, 1500);

                emailjs.sendForm('service_i0zo3zo', 'template_m8ajqzd', this)
                    .then(function() {
                        feedback.classList.remove('d-none', 'alert-danger');
                        feedback.classList.add('alert', 'alert-success');
                        feedback.innerHTML = 'Pesan terkirim!';
                        document.getElementById('contact-form').reset();
                        btn.disabled = false;
                        btnText.classList.remove('d-none');
                        btnLoader.classList.add('d-none');
                    }, function(error) {
                        feedback.classList.remove('d-none', 'alert-success');
                        feedback.classList.add('alert', 'alert-danger');
                        feedback.innerHTML = 'Gagal mengirim pesan. Silakan coba lagi.';
                        btn.disabled = false;
                        btnText.classList.remove('d-none');
                        btnLoader.classList.add('d-none');
                    });
            });
        </script>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>

</html>