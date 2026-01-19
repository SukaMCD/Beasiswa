document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');

    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href");

            if (targetId === "#") return;

            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                e.preventDefault();

                const navbarHeight =
                    document.querySelector(".navbar").offsetHeight;

                const elementPosition =
                    targetElement.getBoundingClientRect().top;
                const offsetPosition =
                    elementPosition + window.pageYOffset - (navbarHeight + 20);

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth",
                });

                const offcanvasElement =
                    document.getElementById("offcanvasNavbar");
                const offcanvas =
                    bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (offcanvas) {
                    offcanvas.hide();
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
            if (link.getAttribute("href") === `#${current}`) {
                link.classList.add("active");
            }
        });
    });
});
