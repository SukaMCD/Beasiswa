<footer class="main-footer">
  <div class="container footer-content">
    <div class="footer-grid">
      <div class="footer-brand-col">
        <a href="/" class="footer-logo">
          <img src="{{ asset('images/kedai-cendana-rounded.webp') }}" alt="Logo Kedai Cendana" draggable="false">
          <span>Kedai Cendana</span>
        </a>
        <p class="footer-description">
          Menghadirkan cita rasa autentik dengan sentuhan modern. Kami berkomitmen menyajikan hidangan berkualitas tinggi untuk pengalaman kuliner terbaik Anda.
        </p>
        <div class="footer-social-links">
          <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <div class="footer-links-col">
        <h4 class="footer-heading">Menu Cepat</h4>
        <ul class="footer-link-list">
          <li><a href="/#home" class="nav-anchor">Beranda</a></li>
          <li><a href="{{ route('products') }}">Menu</a></li>
          <li><a href="/#contact" class="nav-anchor">Kontak</a></li>
          <!-- <li><a href="#">Artikel</a></li> -->
        </ul>
      </div>

      <div class="footer-links-col">
        <h4 class="footer-heading">Kontak</h4>
        <ul class="footer-link-list">
          <li><a href="#">cendana@gmail.com</a></li>
          <li><a href="#">08123456789</a></li>
          <li><a href="#">www.kedaicendana.com</a></li>
        </ul>
      </div>

      <div class="footer-links-col">
        <h4 class="footer-heading">Lokasi</h4>
        <div class="footer-map-container mt-3">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d731.8602353753331!2d106.69589340188884!3d-6.206972301661459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f993922a73ff%3A0x4f7de683e865ee2e!2sJl.%20Cendana%20II%20Blok%20S%20No.27%2C%20RT.006%2FRW.006%2C%20Pd.%20Bahar%2C%20Kec.%20Karang%20Tengah%2C%20Kota%20Tangerang%2C%20Banten%2015159!5e0!3m2!1sid!2sid!4v1768810188040!5m2!1sid!2sid"
            width="100%"
            height="150"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
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