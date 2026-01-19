<!-- hero section carousel -->
<section id="heroCarousel" class="carousel slide hero-section" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner h-100">
        <div class="carousel-item active h-100">
            <div class="hero-image h-100" style="background-image: url('{{ asset('images/image1.webp') }}');"></div>
        </div>
        <div class="carousel-item h-100">
            <div class="hero-image h-100" style="background-image: url('{{ asset('images/image2.webp') }}');"></div>
        </div>
        <div class="carousel-item h-100">
            <div class="hero-image h-100" style="background-image: url('{{ asset('images/image1.webp') }}');"></div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</section>