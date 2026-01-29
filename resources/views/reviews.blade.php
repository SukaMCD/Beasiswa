<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layout.seo', [
        'title' => 'Kedai Cendana - Ulasan',
    ])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
</head>

<body>
    @include('layout.header')

    <main class="container py-5 mt-5">
        <nav aria-label="breadcrumb" class="py-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}"
                        class="text-decoration-none text-secondary small">Beranda</a></li>
                <li class="breadcrumb-item active small" aria-current="page">Ulasan</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between border-bottom pb-4 mb-5">
            <div>
                <h1 class="h2 fw-bold mb-1">Ulasan Pelanggan</h1>
                <p class="text-secondary mb-0">Apa kata mereka tentang pengalaman di Kedai Cendana.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="#" class="btn btn-primary rounded-pill px-4"><i class="bi bi-plus-circle me-2"></i>Tulis
                    Ulasan</a>
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            <div class="col-12 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <img src="https://i.pravatar.cc/48?img=1" class="rounded-circle me-3" alt="avatar"
                                width="40" height="40">
                            <div>
                                <strong>Raka</strong>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-secondary mb-0">Makanannya enak, pelayanan cepat. UI websitenya juga nyaman
                            dipakai di HP!</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <img src="https://i.pravatar.cc/48?img=2" class="rounded-circle me-3" alt="avatar"
                                width="40" height="40">
                            <div>
                                <strong>Intan</strong>
                                <div class="text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="text-secondary mb-0">Layoutnya simpel tapi modern. Offcanvas menunya smooth dan mudah
                            diakses.</p>
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
