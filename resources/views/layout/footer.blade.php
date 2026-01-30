<footer class="main-footer">
    <div class="container footer-content">
        <div class="footer-grid">
            <div class="footer-brand-col">
                <a href="/" class="footer-logo">
                    <img src="{{ asset('images/kedai-cendana-rounded.webp') }}" alt="Logo Kedai Cendana" draggable="false">
                    <span>Kedai Cendana</span>
                </a>
                <p class="footer-description">
                    Menghadirkan cita rasa autentik dengan sentuhan modern. Kami berkomitmen menyajikan hidangan
                    berkualitas tinggi untuk pengalaman kuliner terbaik Anda.
                </p>
                <div class="footer-social-links">
                    <a href="mailto:support@kedaicendana.my.id" aria-label="Gmail" target="_blank"><i
                            class="bi bi-envelope"></i></a>
                    <a href="https://www.instagram.com/cendana_pempekbakmi" aria-label="Instagram" target="_blank"><i
                            class="bi bi-instagram"></i></a>
                    <a href="https://wa.me/6285770333245" aria-label="WhatsApp" target="_blank"><i
                            class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="footer-links-col">
                <h4 class="footer-heading">Menu Cepat</h4>
                <ul class="footer-link-list">
                    <li><a href="/#home" class="nav-anchor">Beranda</a></li>
                    <li><a href="/#menu" class="nav-anchor">Menu</a></li>
                    <li><a href="/#contact" class="nav-anchor">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4 class="footer-heading">Jam Operasional</h4>
                <ul class="footer-link-list">
                    <li><a href="#">Senin - Jumat: 17:00 - 00:00</a></li>
                    <li><a href="#">Sabtu - Minggu: 17:00 - 01:00</a></li>
                    <li><a href="#">Melayani Delivery & Pick Up</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h4 class="footer-heading">Lokasi</h4>
                <div class="footer-map-container mt-3">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d731.8602353753331!2d106.69589340188884!3d-6.206972301661459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f993922a73ff%3A0x4f7de683e865ee2e!2sJl.%20Cendana%20II%20Blok%20S%20No.27%2C%20RT.006%2FRW.006%2C%20Pd.%20Bahar%2C%20Kec.%20Karang%20Tengah%2C%20Kota%20Tangerang%2C%20Banten%2015159!5e0!3m2!1sid!2sid!4v1768810188040!5m2!1sid!2sid"
                        width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-3 shadow-sm border border-light border-opacity-10">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-flex">
                <p class="copyright">&copy; {{ date('Y') }} Kedai Cendana. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
    </div>
</footer>

@include('components.product-modal')
@include('components.qr-modal')

<!-- App Download Banner (Mobile Only) -->
<div id="app-banner" class="app-banner d-none">
    <div class="banner-content">
        <button id="close-banner" class="close-banner" aria-label="Tutup">
            <i class="bi bi-x"></i>
        </button>
        <div class="banner-info">
            <img src="{{ asset('images/kedai-cendana-rounded.webp') }}" alt="App Icon" class="app-icon">
            <div class="app-text">
                <h5 class="app-title">Kedai Cendana App</h5>
                <p class="app-subtitle">Pesan lebih cepat di aplikasi</p>
            </div>
        </div>
        <a href="{{ asset('app/Kedai-Cendana.apk') }}" class="btn-download">Unduh</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('app-banner');
        const menuPromo = document.getElementById('app-menu-promo');
        const closeBtn = document.getElementById('close-banner');

        // Cek apakah user pernah menutup banner di sesi ini
        const isBannerClosed = sessionStorage.getItem('appBannerClosed');

        // Deteksi WebView yang lebih kuat (termasuk Android WebView, iOS WebView, FB, IG, dan App Kita)
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        const isWebView = /wv|WebView|FBAN|FBAV|Instagram|KedaiCendanaApp/i.test(userAgent) ||
            (/iPhone|iPad|iPod/i.test(userAgent) && !/Safari/i.test(userAgent));

        // Jika di WebView, hapus elemen download agar tidak muncul sama sekali
        if (isWebView) {
            if (banner) banner.remove();
            if (menuPromo) menuPromo.remove();
            return;
        }

        // Hanya tampilkan di mobile (Bootstrap breakpoint MD) jika belum ditutup
        function checkBanner() {
            if (window.innerWidth < 768 && !isBannerClosed) {
                if (banner) banner.classList.remove('d-none');
            } else {
                if (banner) banner.classList.add('d-none');
            }
        }

        checkBanner();
        window.addEventListener('resize', checkBanner);

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                if (banner) banner.classList.add('d-none');
                sessionStorage.setItem('appBannerClosed', 'true');
            });
        }
    });
</script>
