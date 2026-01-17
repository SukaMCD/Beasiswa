<footer class="bg-dark text-light mt-5">
  <div class="container py-4 py-lg-5">
    <div class="row gy-4 align-items-start">
      <div class="col-12 col-lg-4">
        <div class="d-flex align-items-center mb-3">
          <img src="{{ asset('images/logo_cendana.png') }}" alt="Cendana Logo" style="height: 32px; width: auto;" />
          <span class="ms-2 fw-semibold">Kedai Cendana</span>
        </div>
        <p class="text-secondary mb-3">Kuliner favorit, pengalaman modern. Simple, cepat, dan menyenangkan.</p>
        <div class="d-flex gap-3">
          <a href="https://www.instagram.com/cendana_pempekbakmi" target="_blank" class="text-secondary text-decoration-none"><i class="bi bi-instagram"></i> Instagram</a>
          <!-- <a href="#" class="text-secondary text-decoration-none"><i class="bi bi-facebook"></i></a> -->
          <!-- <a href="#" class="text-secondary text-decoration-none"><i class="bi bi-twitter-x"></i></a> -->
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <h6 class="text-uppercase text-secondary">Menu</h6>
        <ul class="list-unstyled small">
          <li><a href="/" class="link-light link-underline-opacity-0 link-underline-opacity-50-hover">Beranda</a></li>
          <li><a href="{{ route('articles') }}" class="link-light link-underline-opacity-0 link-underline-opacity-50-hover">Artikel</a></li>
          <li><a href="{{ route('reviews') }}" class="link-light link-underline-opacity-0 link-underline-opacity-50-hover">Reviews</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-3">
        <h6 class="text-uppercase text-secondary">Kontak</h6>
        <ul class="list-unstyled small mb-0">
          <li>Email: hello@kedai-cendana.test</li>
          <li>Telp: +62 812-1234-5678</li>
          <li>Alamat: Bandung, Indonesia</li>
        </ul>
      </div>
      
    </div>
    <hr class="border-secondary-subtle my-4" />
    <div class="d-flex flex-column flex-sm-row justify-content-between small text-secondary">
      <span>© {{ date('Y') }} Kedai Cendana. All rights reserved.</span>
      <div class="d-flex gap-3">
        <a href="#" class="link-secondary link-underline-opacity-0 link-underline-opacity-50-hover">Privasi</a>
        <a href="#" class="link-secondary link-underline-opacity-0 link-underline-opacity-50-hover">Syarat</a>
      </div>
    </div>
  </div>
</footer>

