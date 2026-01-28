<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 ">
    <title>Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/filament/filament/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @include('layout.header')
    @include('layout.hero')

    <main>

        <!-- Menu Favorit (Produk) -->
        <section class="container py-5" id="menu">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Menu Favorit</h2>
                <hr class="mx-auto"
                    style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
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
                                        class="bi bi-exclamation-triangle me-1"></i>Stok Terbatas
                                    ({{ $product->stok }})
                                </span>
                            @else
                                <span class="stock-badge stock-out"><i class="bi bi-x-circle me-1"></i>Habis</span>
                            @endif

                            <div class="ratio ratio-4x3 overflow-hidden">
                                <img src="{{ $finalImg }}" class="card-img-top object-fit-cover"
                                    alt="{{ $product->nama_produk }}">
                            </div>
                            <div class="card-body">
                                <h3 class="h6 product-title mb-1">{{ $product->nama_produk }}</h3>
                                <div class="text-secondary small mb-2"
                                    style="height: 2.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ $product->deskripsi }}
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <strong class="product-price">Rp
                                        {{ number_format($product->harga, 0, ',', '.') }}</strong>
                                    {{-- <div class="d-flex align-items-center bg-light px-2 py-1 rounded-pill border">
                                    <span class="text-secondary fw-semibold" style="font-size: 0.8rem;">Stok: {{ $product->stok }}</span>
                                </div> --}}
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
            <a href="{{ route('products') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">Menu Lainnya
                <i class="bi bi-arrow-right ms-2"></i></a>
        </div>

        <!-- voucher nunggu ada ide implementasiinya
        <section class="container pb-5" id="voucher">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Voucher</h2>
                <hr class="mx-auto" style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
        </section> -->

        <!-- abot as -->
        <section class="container py-5" id="about">
            <div class="text-center mb-4">
                <h2 class="display-6 fw-bold mb-2">Tentang Kami</h2>
                <hr class="mx-auto"
                    style="width: 70px; height: 3px; background-color: var(--accent-color); border-radius: 3px;">
            </div>
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <div class="about-image-wrapper position-relative">
                        <div class="about-image-shape"></div>
                        <img src="{{ asset('images/logo_cendana.webp') }}" alt="Logo Kedai Cendana"
                            class="img-fluid rounded-4 shadow-lg position-relative z-1"
                            style="max-width: 80%; height: auto;" draggable="false">
                        <div class="about-experience-badge">
                            <span class="fs-3 fw-bold">125</span>
                            <span class="small d-block">Porsi Tersaji</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="ps-lg-4">
                        <h2 class="display-5 fw-bold mb-4">Kedai Cendana: <span class="text-primary">Pempek & Bakmi
                                Ayam</span></h2>
                        <p class="lead text-secondary mb-4">Kedai Cendana adalah kedai kontemporer yang menghadirkan
                            cita rasa autentik dengan sentuhan modern. Kami berkomitmen menyajikan hidangan berkualitas
                            tinggi dari bahan-bahan pilihan.</p>

                        <div class="row g-4 mb-5">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="about-icon-box me-3">
                                        <i class="bi bi-award"></i>
                                    </div>
                                    <div>
                                        <h4 class="h6 fw-bold mb-0">Kualitas</h4>
                                        <small class="text-muted">Bahan Premium</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="about-icon-box me-3">
                                        <i class="bi bi-stopwatch"></i>
                                    </div>
                                    <div>
                                        <h4 class="h6 fw-bold mb-0">Tanpa Pengawet</h4>
                                        <small class="text-muted">Bahan alami</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#aboutModal">
                            Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header border-0 bg-light p-4">
                        <h5 class="modal-title fw-bold" id="aboutModalLabel">Kisah Kedai Cendana</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 p-lg-5">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <img src="{{ asset('images/kedai-cendana-rounded.webp') }}"
                                    class="img-fluid rounded-4 mb-3" alt="Kedai Cendana" draggable="false">
                                <div class="bg-light p-3 rounded-3">
                                    <h6 class="fw-bold mb-2">Kontak Kami</h6>
                                    <ul class="list-unstyled small mb-0 text-secondary">
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="bi bi-envelope me-2 mt-1"></i>
                                            <span>support@kedaicendana.my.id</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="bi bi-telephone me-2"></i>
                                            <span>+62 857-7033-3245</span>
                                        </li>
                                        <li class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt me-2"></i>
                                            <span>Tangerang, Indonesia</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h3 class="fw-bold mb-3">Visi & Misi Kami</h3>
                                <p class="text-secondary">Dengan semangat inovasi, kami menghadirkan menu favorit untuk
                                    menemani momen spesial Anda. Bagi kami, makanan bukan sekadar santapan—tetapi
                                    pengalaman yang menghubungkan orang.</p>
                                <p class="text-secondary">Kedai kami bermula dari sebuah garasi kecil di tahun 2014,
                                    dengan semangat untuk melestarikan kuliner tradisional dalam balutan gaya hidup masa
                                    kini. Kini, kami bangga menjadi bagian dari keseharian ribuan pelanggan setia kami.
                                </p>
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Kenapa Memilih Kami?</h6>
                                    <div class="d-flex mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span class="text-secondary">Bahan selalu segar setiap hari</span>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span class="text-secondary">Tanpa bahan pengawet buatan</span>
                                    </div>
                                    <div class="d-flex">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span class="text-secondary">Layanan yang hangat dan kekeluargaan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Tutup</button>
                        <a href="#menu" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Lihat
                            Menu</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- sec kontak cuyy -->
        <section class="container pb-5" id="contact">
            <div class="p-4 p-lg-5 rounded-4 border bg-white shadow-sm">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold mb-2">Kontak Kami</h2>
                    <p class="text-secondary">Punya pertanyaan? Kirim pesan kepada kami dan kami akan segera
                        membalasnya.</p>
                </div>
                <form id="contact-form">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="user_name" class="form-control py-2 px-3 rounded-3"
                                placeholder="Nama lengkap" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="user_email" class="form-control py-2 px-3 rounded-3"
                                placeholder="Alamat email" required />
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Pesan</label>
                            <textarea name="message" class="form-control py-2 px-3 rounded-3" rows="4"
                                placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button class="btn btn-primary rounded-pill px-5 py-2 fw-bold" type="submit"
                                id="submit-btn">
                                <span id="btn-text">Kirim Pesan</span>
                                <span id="btn-loader" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
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

                emailjs.sendForm('service_i0zo3zo', 'template_wsi4hne', this)
                    .then(function() {
                        feedback.classList.remove('d-none', 'alert-danger');
                        feedback.classList.add('alert', 'alert-success');
                        feedback.innerHTML = '<i class="bi bi-check-circle me-2"></i>Pesan Anda telah terkirim!';

                        document.getElementById('contact-form').reset();
                    })
                    .catch(function() {
                        feedback.classList.remove('d-none', 'alert-success');
                        feedback.classList.add('alert', 'alert-danger');
                        feedback.innerHTML = 'Gagal mengirim pesan. Silakan coba lagi.';
                    })
                    .finally(function() {
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
