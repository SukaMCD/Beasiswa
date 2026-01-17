<nav class="navbar navbar-light bg-light sticky-top py-3">
  <div class="container-fluid px-3 px-lg-5">
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="{{ asset('images/logo_cendana.png') }}" alt="Cendana Logo" class="navbar-logo" style="height: 36px; width: auto;" />
      <span class="ms-2 fw-semibold d-none d-sm-inline">Kedai Cendana</span>
    </a>

    <div class="d-flex align-items-center">
      <div class="d-none d-lg-flex align-items-center me-3">
        <div class="search-container d-none d-xl-flex align-items-center me-3">
          <i class="bi bi-search search-icon me-2"></i>
          <input type="text" class="form-control form-control-sm search-input" placeholder="Cari produk..." style="min-width: 260px;">
        </div>
        <a class="btn btn-link text-decoration-none position-relative me-2" href="#" title="Keranjang">
          <i class="bi bi-bag fs-5"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </a>
        @auth
        <div class="dropdown">
          <button class="btn btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person me-1"></i> Akun
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-heart me-2"></i>Wishlist</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-box-seam me-2"></i>Pesanan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
              </form>
            </li>
          </ul>
        </div>
        @endauth
        @guest
        <a href="{{ route('login') }}" class="btn btn-primary ms-2"><i class="bi bi-box-arrow-in-right me-1"></i> Masuk</a>
        @endguest
      </div>

      <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
        <i class="bi bi-list fs-4"></i>
      </button>
    </div>
  </div>

  <div class="d-none d-lg-block border-top">
    <div class="container-fluid px-3 px-lg-5">
      <ul class="nav py-2" style="--bs-nav-link-hover-color: var(--accent-color);">
        <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('articles') }}">Artikel</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('reviews') }}">Reviews</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column">
    <form class="d-flex mb-3" role="search">
      <input class="form-control me-2" type="search" placeholder="Cari produk..." aria-label="Search">
      <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <a class="btn btn-link text-start mb-2" href="/"><i class="bi bi-house me-2"></i>Beranda</a>
    <a class="btn btn-link text-start mb-2" href="{{ route('products') }}"><i class="bi bi-grid me-2"></i>Produk</a>
    <a class="btn btn-link text-start mb-2" href="#"><i class="bi bi-info-circle me-2"></i>Tentang</a>
    <a class="btn btn-link text-start mb-2" href="#"><i class="bi bi-envelope me-2"></i>Kontak</a>
    <a class="btn btn-link text-start mb-2" href="{{ route('articles') }}"><i class="bi bi-journal-text me-2"></i>Artikel</a>
    <a class="btn btn-link text-start mb-3" href="{{ route('reviews') }}"><i class="bi bi-chat-dots me-2"></i>Reviews</a>

    <div class="mt-auto">
      <a class="btn btn-outline-secondary w-100 mb-2" href="#"><i class="bi bi-bag me-2"></i>Keranjang</a>
      @auth
      <div class="d-grid gap-2">
        <a class="btn btn-light border" href="#"><i class="bi bi-person me-2"></i>Profil</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
        </form>
      </div>
      @endauth
      @guest
      <a href="{{ route('login') }}" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</a>
      @endguest
    </div>
  </div>
</div>