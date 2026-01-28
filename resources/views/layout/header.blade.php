<nav id="main-navbar" class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <!-- LOGO (Kiri) -->
        <a class="navbar-brand me-lg-auto" href="/">
            <img src="{{ asset('images/logo_cendana.webp') }}" alt="Kedai Cendana" class="header-logo" draggable="false">
        </a>

        <!-- MENU TENGAH (Desktop) & SIDEBAR (Mobile) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Kedai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                @auth
                    <!-- Info Poin Khusus Mobile -->
                    <div class="mb-3 d-lg-none">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Poin Kamu:</small>
                            <span class="fw-bold text-dark" style="font-size:1.1rem;">
                                {{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }} Poin
                            </span>
                        </div>
                    </div>
                @endauth

                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="{{ url('/#menu') }}">Menu</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="{{ url('/#about') }}">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link mx-lg-2" href="{{ url('/#contact') }}">Kontak</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link mx-lg-2" href="/#qr" data-bs-toggle="modal"
                                data-bs-target="#qrModal">QR Code</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link mx-lg-2 btn-scan-qr-guest" href="#"
                                style="cursor: pointer;">QR Code</a></li>
                    @endauth

                    @auth
                        <!-- Menu Akun Khusus Sidebar Mobile -->
                        <li class="nav-item d-lg-none mt-4 pt-3 border-top">
                            <h6 class="text-uppercase fw-bold small text-muted mb-3">Akun Saya</h6>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link py-2" href="#" data-bs-toggle="modal" data-bs-target="#profileModal"><i
                                    class="bi bi-person me-2"></i>Profil Saya</a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link py-2" href="{{ route('history.index') }}"><i
                                    class="bi bi-bag-check me-2"></i>Pesanan</a>
                        </li>
                        <li class="nav-item d-lg-none mt-3">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100 py-2 rounded-3 text-white">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item d-lg-none mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 py-2 rounded-3 text-white">Login
                                Sekarang</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>

        <!-- ACTIONS KANAN (Cart, Profile Desktop, Toggler) -->
        <div class="header-actions ms-lg-auto d-flex align-items-center">
            @auth
                <a href="{{ route('cart.index') }}" class="cart-button me-3">
                    <i class="bi bi-cart"></i>
                </a>

                <!-- Dropdown Profil Desktop -->
                <div class="dropdown d-none d-lg-block">
                    <a href="#" class="login-button dropdown-toggle shadow-sm" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Profil
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 rounded-4 animate slideIn">
                        <li class="px-4 py-2 bg-light rounded-top-4">
                            <small class="text-muted d-block">Poin:</small>
                            <div class="fw-bold text-dark">{{ number_format(Auth::user()->points ?? 0, 0, ',', '.') }}
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider m-0">
                        </li>
                        <li><a class="dropdown-item py-2 px-4 mt-2" href="#" data-bs-toggle="modal"
                                data-bs-target="#profileModal"><i class="bi bi-person me-2"></i>Akun Saya</a></li>
                        <li><a class="dropdown-item py-2 px-4" href="{{ route('history.index') }}"><i
                                    class="bi bi-bag-check me-2"></i>Pesanan</a></li>
                        <li>
                            <hr class="dropdown-divider mx-3">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 px-4 text-danger mb-2">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="login-button d-none d-lg-block">Login</a>
            @endguest

            <!-- Toggler Mobile -->
            <button class="navbar-toggler pe-0 ms-2 border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

@include('components.profile-modal')
