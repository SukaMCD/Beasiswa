<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artikel - Kedai Cendana</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link href="{{ asset('css/layout.css?v=1.0') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/kedai-cendana-rounded.webp') }}" type="image/x-icon">
</head>

<body>
    @include('layout.header')

    <main class="container py-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <h1 class="h3 mb-2 mb-md-0">Artikel</h1>
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Cari artikel...">
            </div>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($articles as $article)
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-4x3">
                            @php
                                $thumbUrl = asset('images/image2.webp');

                                if ($article->thumbnail) {
                                    if (Str::startsWith($article->thumbnail, ['http://', 'https://'])) {
                                        $thumbUrl = $article->thumbnail;
                                    } else {
                                        $thumbUrl = asset('storage/' . $article->thumbnail);
                                    }
                                }
                            @endphp
                            <img src="{{ $thumbUrl }}" class="card-img-top object-fit-cover"
                                alt="{{ $article->judul }}">
                        </div>
                        <div class="card-body">
                            <h2 class="h6 mb-1">{{ $article->judul }}</h2>
                            <p class="text-secondary small mb-3">{{ Str::limit(strip_tags($article->isi), 100) }}</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Belum ada artikel.</div>
                </div>
            @endforelse
        </div>
    </main>

    @include('layout.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/layout.js') }}"></script>
</body>

</html>
