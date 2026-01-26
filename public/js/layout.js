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
        const btnBuyNowXendit = productModal.querySelector("#btnBuyNowXendit");
        const btnAddToCart = productModal.querySelector("#btnAddToCart");
        const modalQtyInput = productModal.querySelector("#modalQty");
        const modalTotalPrice = productModal.querySelector("#modalTotalPrice");

        // Auth Check
        const checkAuth = (e) => {
            const isAuth = productModal.getAttribute("data-auth") === "true";
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

        // Open Modal Handler
        productModal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;

            // Extract info
            const id = button.getAttribute("data-id");
            const nama = button.getAttribute("data-nama");
            const deskripsi = button.getAttribute("data-deskripsi");
            const harga = button.getAttribute("data-harga");
            const stok = button.getAttribute("data-stok");
            const gambar = button.getAttribute("data-gambar");

            // Update UI
            btnAddToCart.setAttribute("data-id", id);
            btnBuyNowXendit.setAttribute("data-id", id);

            modalTitle.textContent = nama;
            modalImage.src = gambar;
            modalImage.alt = nama;
            modalPrice.textContent = `Rp ${new Intl.NumberFormat("id-ID").format(harga)}`;
            modalDesc.textContent = deskripsi;
            modalStockCount.textContent = `${stok} Porsi`;
            modalQtyInput.value = 1;

            const updateTotalPrice = () => {
                const qty = parseInt(modalQtyInput.value);
                const total = qty * harga;
                modalTotalPrice.textContent = `Rp ${new Intl.NumberFormat("id-ID").format(total)}`;
            };
            updateTotalPrice();

            // Qty Logic
            const btnIncrease = productModal.querySelector("#btnIncreaseModal");
            const btnDecrease = productModal.querySelector("#btnDecreaseModal");

            btnIncrease.onclick = () => {
                if (parseInt(modalQtyInput.value) < parseInt(stok)) {
                    modalQtyInput.value = parseInt(modalQtyInput.value) + 1;
                    updateTotalPrice();
                }
            };
            btnDecrease.onclick = () => {
                if (parseInt(modalQtyInput.value) > 1) {
                    modalQtyInput.value = parseInt(modalQtyInput.value) - 1;
                    updateTotalPrice();
                }
            };

            // Stock Badge
            modalStockBadge.className = "stock-badge";
            if (parseInt(stok) > 10) {
                modalStockBadge.classList.add("stock-available");
                modalStockBadge.innerHTML =
                    '<i class="bi bi-check2-circle me-1"></i>Tersedia';
            } else if (parseInt(stok) > 0) {
                modalStockBadge.classList.add("stock-limited");
                modalStockBadge.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>Terbatas (${stok})`;
            } else {
                modalStockBadge.classList.add("stock-out");
                modalStockBadge.innerHTML =
                    '<i class="bi bi-x-circle me-1"></i>Habis';
            }

            // Disable buttons if no stock
            if (parseInt(stok) <= 0) {
                btnBuyNowXendit.disabled = true;
                btnAddToCart.disabled = true;
            } else {
                btnBuyNowXendit.disabled = false;
                btnAddToCart.disabled = false;
            }
        });

        // Add To Cart Listener
        btnAddToCart.addEventListener("click", function (e) {
            if (!checkAuth(e)) return;

            const idProduk = this.getAttribute("data-id");
            const jumlah = modalQtyInput.value;

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ id_produk: idProduk, jumlah: jumlah }),
            })
                .then((response) => response.json())
                .then((data) => {
                    Swal.fire({
                        title: "Berhasil!",
                        text: data.message,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false,
                        position: "top-end",
                        toast: true,
                    });
                    const badge = document.querySelector(".cart-badge");
                    if (badge) {
                        badge.textContent = parseInt(badge.textContent) + 1;
                        badge.classList.add("pulse-animation");
                        setTimeout(
                            () => badge.classList.remove("pulse-animation"),
                            500,
                        );
                    }
                });
        });

        // Buy Now Listener
        btnBuyNowXendit.addEventListener("click", function (e) {
            if (!checkAuth(e)) return;

            const idProduk = this.getAttribute("data-id");
            const jumlah = modalQtyInput.value;

            // Loading state
            const originalText = this.innerHTML;
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            this.disabled = true;

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ id_produk: idProduk, jumlah: jumlah }),
            })
                .then((response) => response.json())
                .then((data) => {
                    window.location.href = "/cart";
                })
                .catch((err) => {
                    console.error(err);
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
        });
    }

    // Cart Page logic (AJAX Updates)
    const cartItemsContainer = document.getElementById("cart-items-container");
    if (cartItemsContainer) {
        cartItemsContainer.addEventListener("click", function (e) {
            // Quantity buttons
            const btnQty = e.target.closest(".btn-qty");
            if (btnQty) {
                const id = btnQty.getAttribute("data-id");
                const action = btnQty.getAttribute("data-action");

                fetch("/cart/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ id_item: id, action: action }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.removed) {
                            const itemCard = document.getElementById(
                                `cart-item-${id}`,
                            );
                            if (itemCard) {
                                itemCard.style.opacity = "0";
                                itemCard.style.transform = "translateX(20px)";
                                setTimeout(() => {
                                    itemCard.remove();
                                    if (data.is_empty) {
                                        document.getElementById(
                                            "cart-content",
                                        ).style.display = "none";
                                        document.getElementById(
                                            "empty-state",
                                        ).style.display = "block";
                                    }
                                }, 300);
                            }
                        } else {
                            const card = document.getElementById(
                                `cart-item-${id}`,
                            );
                            const qtyInput =
                                card.querySelector(".qty-input-val");
                            const itemSubtotal = card.querySelector(
                                `#item-subtotal-${id}`,
                            );
                            const btnMinus = card.querySelector(
                                '[data-action="decrease"]',
                            );

                            qtyInput.value =
                                action === "increase"
                                    ? parseInt(qtyInput.value) + 1
                                    : parseInt(qtyInput.value) - 1;
                            itemSubtotal.textContent = `Rp ${data.item_subtotal[id]}`;
                            btnMinus.disabled = parseInt(qtyInput.value) <= 1;
                        }

                        document.getElementById("subtotal-amount").textContent =
                            `Rp ${data.subtotal}`;
                        document.getElementById("ppn-amount").textContent =
                            `Rp ${data.ppn}`;
                        document.getElementById("total-amount").textContent =
                            `Rp ${data.total}`;

                        const badge =
                            document.getElementById("cart-count-badge");
                        if (badge) badge.textContent = data.cart_count;

                        const headerBadge =
                            document.querySelector(".cart-badge");
                        if (headerBadge)
                            headerBadge.textContent = data.cart_count;

                        if (typeof updateWhatsAppLink === "function")
                            updateWhatsAppLink();
                    });
            }

            // Remove button
            const btnRemove = e.target.closest(".btn-remove");
            if (btnRemove) {
                const id = btnRemove.getAttribute("data-id");

                Swal.fire({
                    title: "Hapus Menu?",
                    text: "Menu ini akan dihapus dari keranjang belanja Anda.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffd67c",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-primary rounded-pill px-4",
                        cancelButton: "btn btn-light rounded-pill px-4",
                    },
                    buttonsStyling: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("/cart/remove", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                            body: JSON.stringify({ id_item: id }),
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                const itemCard = document.getElementById(
                                    `cart-item-${id}`,
                                );
                                itemCard.style.opacity = "0";
                                itemCard.style.transform = "translateY(10px)";
                                setTimeout(() => {
                                    itemCard.remove();
                                    if (data.is_empty) {
                                        document.getElementById(
                                            "cart-content",
                                        ).style.display = "none";
                                        document.getElementById(
                                            "empty-state",
                                        ).style.display = "block";
                                    }
                                }, 300);

                                document.getElementById(
                                    "subtotal-amount",
                                ).textContent = `Rp ${data.subtotal}`;
                                document.getElementById(
                                    "ppn-amount",
                                ).textContent = `Rp ${data.ppn}`;
                                document.getElementById(
                                    "total-amount",
                                ).textContent = `Rp ${data.total}`;

                                const badge =
                                    document.getElementById("cart-count-badge");
                                if (badge) badge.textContent = data.cart_count;

                                const headerBadge =
                                    document.querySelector(".cart-badge");
                                if (headerBadge)
                                    headerBadge.textContent = data.cart_count;

                                if (typeof updateWhatsAppLink === "function")
                                    updateWhatsAppLink();

                                Swal.fire({
                                    title: "Terhapus!",
                                    text: "Menu telah dihapus dari keranjang.",
                                    icon: "success",
                                    toast: true,
                                    position: "top-end",
                                    timer: 2000,
                                    showConfirmButton: false,
                                });
                            });
                    }
                });
            }
        });
    }
});
