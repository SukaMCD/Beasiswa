document.addEventListener("DOMContentLoaded", function () {
    // Guest Scan QR Click Handler
    const guestQrBtns = document.querySelectorAll(".btn-scan-qr-guest");
    guestQrBtns.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Wajib Login!",
                text: "Silakan login terlebih dahulu untuk mengakses fitur Scan QR.",
                icon: "warning",
                confirmButtonColor: "#ffd67c",
                confirmButtonText: "Login Sekarang",
                showCancelButton: true,
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/auth/login";
                }
            });
        });
    });

    // Handle scroll for navbar
    const navbar = document.getElementById("main-navbar");
    if (navbar) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    }

    // Active link handler
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");

    window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (scrollY >= sectionTop - 150) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach((link) => {
            link.classList.remove("active");
            const href = link.getAttribute("href");
            if (current && href && href.includes("#" + current)) {
                link.classList.add("active");
            }
        });
    });

    // Unified Navigation and Hash Cleaner
    const handleSmoothScroll = (targetId, preventDefault = true, e = null) => {
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            if (preventDefault && e) e.preventDefault();
            const headerOffset = 85;
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition =
                elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth",
            });

            // Clean URL without adding history entries
            if (window.history.replaceState) {
                window.history.replaceState(
                    null,
                    null,
                    window.location.pathname,
                );
            }

            // Close mobile menu
            const offcanvas = document.getElementById("offcanvasNavbar");
            if (offcanvas && offcanvas.classList.contains("show")) {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
                if (bsOffcanvas) bsOffcanvas.hide();
            }
            return true;
        }
        return false;
    };

    // 1. Handle On-Load Hash
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        // Delay a bit to ensure elements are rendered and browser's default scroll is finished
        setTimeout(() => handleSmoothScroll(hash, false), 100);
    }

    // 2. Handle Navbar Clicks
    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (!href) return;

            const url = new URL(href, window.location.origin);
            const isHomePage = url.pathname === "/" || url.pathname === "";
            const isCurrentPageHome =
                window.location.pathname === "/" ||
                window.location.pathname === "";

            if (isHomePage && isCurrentPageHome) {
                if (url.hash) {
                    const targetId = url.hash.substring(1);
                    handleSmoothScroll(targetId, true, e);
                } else {
                    // Beranda link (no hash)
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: "smooth" });
                    if (window.history.replaceState)
                        window.history.replaceState(null, null, "/");
                }
            }
        });
    });

    const productModal = document.getElementById("productModal");
    if (productModal) {
        const titleEl = productModal.querySelector("#modalProductTitle");
        const imageEl = productModal.querySelector("#modalProductImage");
        const priceEl = productModal.querySelector("#modalProductPrice");
        const descEl = productModal.querySelector("#modalProductDescription");
        const stockBadgeEl = productModal.querySelector(
            "#modalProductStockBadge",
        );
        const stockCountEl = productModal.querySelector(
            "#modalProductStockCount",
        );
        const qtyInput = productModal.querySelector("#modalQty");
        const btnDec = productModal.querySelector("#btnDecreaseModal");
        const btnInc = productModal.querySelector("#btnIncreaseModal");
        const totalEl = productModal.querySelector("#modalTotalPrice");
        const btnAddToCart = productModal.querySelector("#btnAddToCart");
        const btnBuyNow = productModal.querySelector("#btnBuyNowXendit");
        const csrf =
            document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content") || "";

        const updateStockBadge = (stok) => {
            stockBadgeEl.className = "stock-badge";
            if (stok > 10) {
                stockBadgeEl.classList.add("stock-available");
                stockBadgeEl.innerHTML =
                    '<i class="bi bi-check2-circle me-1"></i>Tersedia';
            } else if (stok > 0) {
                stockBadgeEl.classList.add("stock-limited");
                stockBadgeEl.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>Terbatas (${stok})`;
            } else {
                stockBadgeEl.classList.add("stock-out");
                stockBadgeEl.innerHTML =
                    '<i class="bi bi-x-circle me-1"></i>Habis';
            }
        };

        const updateCartBadge = (delta) => {
            const badge = document.querySelector(".cart-badge");
            if (!badge) return;
            const current = parseInt(badge.textContent || "0") || 0;
            badge.textContent = String(current + delta);
        };

        productModal.addEventListener("show.bs.modal", (event) => {
            const card = event.relatedTarget;
            const id = card.getAttribute("data-id");
            const nama = card.getAttribute("data-nama");
            const deskripsi = card.getAttribute("data-deskripsi");
            const harga = parseInt(card.getAttribute("data-harga")) || 0;
            const stok = parseInt(card.getAttribute("data-stok")) || 0;
            const gambarAttr = card.getAttribute("data-gambar");
            const gambar =
                gambarAttr ||
                (card.querySelector("img")
                    ? card.querySelector("img").src
                    : "");

            btnAddToCart.setAttribute("data-id", id);
            titleEl.textContent = nama || "";
            imageEl.src = gambar || "";
            imageEl.alt = nama || "";
            priceEl.textContent = `Rp ${harga.toLocaleString("id-ID")}`;
            descEl.textContent = deskripsi || "";
            stockCountEl.textContent = `${stok} Porsi`;

            let qty = 1;
            qtyInput.value = qty;
            const updateTotal = () => {
                totalEl.textContent = `Rp ${(qty * harga).toLocaleString("id-ID")}`;
            };
            updateTotal();
            updateStockBadge(stok);
            btnBuyNow.disabled = stok <= 0;
            btnAddToCart.disabled = stok <= 0;

            btnDec.onclick = () => {
                if (qty > 1) {
                    qty -= 1;
                    qtyInput.value = qty;
                    updateTotal();
                }
            };
            btnInc.onclick = () => {
                if (qty < stok) {
                    qty += 1;
                    qtyInput.value = qty;
                    updateTotal();
                }
            };

            btnAddToCart.onclick = async (e) => {
                e.preventDefault();
                const isAuth =
                    productModal.getAttribute("data-auth") === "true";
                if (!isAuth) {
                    Swal.fire({
                        title: "Wajib Login!",
                        text: "Silakan login terlebih dahulu untuk menambahkan ke keranjang.",
                        icon: "warning",
                        confirmButtonColor: "#ffd67c",
                        confirmButtonText: "Login Sekarang",
                        showCancelButton: true,
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/auth/login";
                        }
                    });
                    return;
                }
                try {
                    const res = await fetch("/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf,
                        },
                        body: JSON.stringify({ id_produk: id, jumlah: qty }),
                    });
                    if (!res.ok)
                        throw new Error("Gagal menambahkan ke keranjang");
                    updateCartBadge(qty);
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Produk ditambahkan ke keranjang",
                        confirmButtonColor: "#ffd67c",
                    });
                } catch (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan saat menambahkan ke keranjang",
                        confirmButtonColor: "#ffd67c",
                    });
                }
            };

            btnBuyNow.onclick = async (e) => {
                e.preventDefault();
                const isAuth =
                    productModal.getAttribute("data-auth") === "true";
                if (!isAuth) {
                    Swal.fire({
                        title: "Wajib Login!",
                        text: "Silakan login terlebih dahulu untuk membeli.",
                        icon: "warning",
                        confirmButtonColor: "#ffd67c",
                        confirmButtonText: "Login Sekarang",
                        showCancelButton: true,
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/auth/login";
                        }
                    });
                    return;
                }
                try {
                    const addRes = await fetch("/cart/add", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf,
                        },
                        body: JSON.stringify({ id_produk: id, jumlah: qty }),
                    });
                    if (!addRes.ok)
                        throw new Error("Gagal menambahkan ke keranjang");
                    window.location.href = "/cart";
                } catch (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Terjadi kesalahan saat proses beli",
                        confirmButtonColor: "#ffd67c",
                    });
                }
            };
        });
    }
});
