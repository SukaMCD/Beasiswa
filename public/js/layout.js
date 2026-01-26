document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".nav-anchor");

    function scrollToSection(targetId, smooth = true) {
        const id = targetId.startsWith("/#")
            ? targetId.substring(1)
            : targetId.startsWith("#")
              ? targetId
              : null;

        if (!id || id === "#") return false;

        const targetElement = document.querySelector(id);

        if (targetElement) {
            const navbarHeight = document.querySelector(".navbar").offsetHeight;
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition =
                elementPosition + window.pageYOffset - (navbarHeight + 20);

            window.scrollTo({
                top: offsetPosition,
                behavior: smooth ? "smooth" : "auto",
            });

            if (window.location.hash || targetId.includes("#")) {
                history.replaceState(null, null, window.location.pathname);
            }
            return true;
        }
        return false;
    }

    if (window.location.hash) {
        setTimeout(() => {
            scrollToSection(window.location.hash, false);
        }, 100);
    }

    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            if (
                window.location.pathname === "/" ||
                window.location.pathname === ""
            ) {
                const id = href.includes("#") ? "#" + href.split("#")[1] : null;

                if (id && scrollToSection(id)) {
                    e.preventDefault();

                    const offcanvasElement =
                        document.getElementById("offcanvasNavbar");
                    const offcanvas =
                        bootstrap.Offcanvas.getInstance(offcanvasElement);
                    if (offcanvas) {
                        offcanvas.hide();
                    }
                }
            }
        });
    });

    window.addEventListener("scroll", function () {
        let current = "";
        const sections = document.querySelectorAll("section[id]");
        const navbarHeight = document.querySelector(".navbar").offsetHeight;

        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - navbarHeight - 100) {
                current = section.getAttribute("id");
            }
        });

        navLinks.forEach((link) => {
            link.classList.remove("active");
            const href = link.getAttribute("href");
            if (href.endsWith(`#${current}`)) {
                link.classList.add("active");
            }
        });
    });

    // Product Modal Logic
    const productModal = document.getElementById("productModal");
    if (productModal) {
        productModal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;

            // Extract info from data-* attributes
            const nama = button.getAttribute("data-nama");
            const deskripsi = button.getAttribute("data-deskripsi");
            const harga = button.getAttribute("data-harga");
            const stok = button.getAttribute("data-stok");
            const gambar = button.getAttribute("data-gambar");

            // Update modal content
            const modalTitle = productModal.querySelector("#modalProductTitle");
            const modalImage = productModal.querySelector("#modalProductImage");
            const modalPrice = productModal.querySelector("#modalProductPrice");
            const modalDesc = productModal.querySelector(
                "#modalProductDescription",
            );
            const modalStockBadge = productModal.querySelector(
                "#modalProductStockBadge",
            );
            const modalStockCount = productModal.querySelector(
                "#modalProductStockCount",
            );
            const btnBuyNow = productModal.querySelector("#btnBuyNow");

            modalTitle.textContent = nama;
            modalImage.src = gambar;
            modalImage.alt = nama;
            modalPrice.textContent = `Rp ${new Intl.NumberFormat("id-ID").format(harga)}`;
            modalDesc.textContent = deskripsi;
            modalStockCount.textContent = `${stok} Porsi`;

            // Handle Stock Badge
            modalStockBadge.className = "stock-badge";
            if (parseInt(stok) > 10) {
                modalStockBadge.classList.add("stock-available");
                modalStockBadge.innerHTML =
                    '<i class="bi bi-check2-circle me-1"></i>Tersedia';
            } else if (parseInt(stok) > 0) {
                modalStockBadge.classList.add("stock-limited");
                modalStockBadge.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>Stok Terbatas (${stok})`;
            } else {
                modalStockBadge.classList.add("stock-out");
                modalStockBadge.innerHTML =
                    '<i class="bi bi-x-circle me-1"></i>Habis';
            }

            // WhatsApp link
            const waNumber = "6285770333245";
            const waMessage = `Halo Kedai Cendana, saya ingin memesan *${nama}*.\n\nHarga: Rp ${new Intl.NumberFormat("id-ID").format(harga)}\nStok: ${stok}\n\nTerima kasih.`;
            btnBuyNow.href = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMessage)}`;

            if (parseInt(stok) <= 0) {
                btnBuyNow.classList.add("disabled");
                btnBuyNow.style.pointerEvents = "none";
            } else {
                btnBuyNow.classList.remove("disabled");
                btnBuyNow.style.pointerEvents = "auto";
            }
        });

        // Auth Check for Buttons
        const productModalEl = document.getElementById("productModal");
        const btnAddToCart = productModalEl.querySelector("#btnAddToCart");
        const btnBuyNow = productModalEl.querySelector("#btnBuyNow");

        const checkAuth = (e) => {
            const isAuth = productModalEl.getAttribute("data-auth") === "true";
            if (!isAuth) {
                e.preventDefault();
                Swal.fire({
                    title: "Wajib Login!",
                    text: "Silakan login terlebih dahulu untuk melakukan pemesanan.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffd67c",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Login Sekarang",
                    cancelButtonText: "Nanti Saja",
                    confirmButtonTextColor: "#000",
                    customClass: {
                        confirmButton: "btn btn-primary rounded-pill px-4",
                        cancelButton: "btn btn-light rounded-pill px-4",
                    },
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/auth/login";
                    }
                });
                return false;
            }
            return true;
        };

        btnAddToCart.addEventListener("click", checkAuth);
        btnBuyNow.addEventListener("click", checkAuth);
    }
});
