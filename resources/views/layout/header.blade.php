<nav id="main-navbar" class="navbar navbar-expand-lg fixed-top">
  {{-- <style>
    @media (max-width: 576px) {
      .header-logo { max-width: 90px; }
      .header-actions { flex-wrap: wrap; gap: 0.5rem; }
      .header-actions .text-secondary, .header-actions .login-button { display: none !important; }
      .header-actions .cart-button { margin-right: 0.5rem !important; }
      .header-actions .dropdown-toggle { padding: 0.25rem 0.5rem !important; font-size: 0.95rem; }
      .header-actions .btn-link { font-size: 1.2rem; }
      .header-actions .cart-badge { font-size: 0.8rem; }
    }
    .header-actions { display: flex; align-items: center; }
  </style> --}}
  <div class="container">
    <a class="navbar-brand me-auto" href="/">
      <img src="{{ asset('images/logo_cendana.webp') }}" alt="Kedai Cendana" class="header-logo" draggable="false">
    </a>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        @auth
        <div class="mb-3 text-left d-lg-none">
          <span class="badge bg-warning text-dark fw-bold" style="font-size:1rem;">{{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }} Poin</span>
        </div>
        @endauth
        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" aria-current="page" href="/#home">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" href="/#menu">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" href="/#about">Tentang</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" href="/#voucher">Voucher</a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" href="/#contact">Kontak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-anchor mx-lg-2" href="#qr" data-bs-toggle="modal" data-bs-target="#qrModal">QR Code</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="header-actions">
      @auth
      <div class="d-inline-flex align-items-center me-3">
        <span class="text-secondary me-2 small fw-bold">{{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }} Poin</span>
        <button type="button" class="btn btn-link p-0 text-dark" data-bs-toggle="modal" data-bs-target="#qrModal">
          <i class="bi bi-qr-code-scan fs-5"></i>
        </button>
      </div>

      <a href="{{ route('cart.index') }}" class="cart-button me-3">
        <i class="bi bi-cart"></i>
        <span class="cart-badge">0</span>
      </a>
      <div class="dropdown">
        <a href="#" class="login-button dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          Profil
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 rounded-4 animate slideIn">
          <li><a class="dropdown-item py-2 px-4" href="#"><i class="bi bi-person me-2"></i>Akun Saya</a></li>
          <li><a class="dropdown-item py-2 px-4" href="{{ route('history.index') }}"><i class="bi bi-bag-check me-2"></i>Pesanan</a></li>
          <li>
            <hr class="dropdown-divider mx-3">
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item py-2 px-4 text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
      @endauth
      @guest
      <a href="{{ route('login') }}" class="login-button">Login</a>
      @endguest
    </div>

    <button class="navbar-toggler pe-0 ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>