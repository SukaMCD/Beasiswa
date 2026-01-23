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
});
