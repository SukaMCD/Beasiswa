<!-- Product Detail Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true" data-auth="{{ Auth::check() ? 'true' : 'false' }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-light p-4">
                <h5 class="modal-title fw-bold" id="productModalLabel">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 p-lg-5">
                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="ratio ratio-1x1 rounded-4 overflow-hidden shadow-sm">
                            <img id="modalProductImage" src="" class="object-fit-cover w-100 h-100" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="ps-md-3">
                            <h2 id="modalProductTitle" class="h3 fw-bold mb-2"></h2>
                            <div class="d-flex align-items-center mb-3">
                                <span id="modalProductPrice" class="h4 fw-bold text-orange mb-0 me-3" style="color: #e67e22;"></span>
                                <span id="modalProductStockBadge" class="stock-badge"></span>
                            </div>
                            <hr class="my-4 opacity-10">
                            <h6 class="fw-bold mb-2">Deskripsi</h6>
                            <div class="modal-description-scroll mb-4">
                                <p id="modalProductDescription" class="text-secondary mb-0"></p>
                            </div>

                            <div class="bg-light p-3 rounded-3 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-secondary small">Status Stok</span>
                                    <span id="modalProductStockCount" class="fw-bold small"></span>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex">
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4 flex-grow-1" id="btnAddToCart">
                                    <i class="bi bi-cart-plus me-2"></i>Keranjang
                                </button>
                                <a href="" target="_blank" class="btn btn-primary rounded-pill px-4 flex-grow-1" id="btnBuyNow">
                                    <i class="bi bi-whatsapp me-2"></i>Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>