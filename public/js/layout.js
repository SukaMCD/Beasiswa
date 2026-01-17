// Fix navbar collapse behavior
document.addEventListener('DOMContentLoaded', function() {
    const navbarCollapse = document.getElementById('navbarNav');
    const navbarToggler = document.querySelector('.navbar-toggler');
    
    // Close navbar when clicking on nav links (mobile)
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link:not(.dropdown-toggle)');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                    toggle: false
                });
                bsCollapse.hide();
            }
        });
    });
    
    // Close navbar when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideNav = navbarCollapse.contains(event.target) || navbarToggler.contains(event.target);
        if (!isClickInsideNav && navbarCollapse.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                toggle: false
            });
            bsCollapse.hide();
        }
    });

    // Handle active menu state
    const menuLinks = document.querySelectorAll('.navbar-nav .nav-link');
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            menuLinks.forEach(function(otherLink) {
                otherLink.classList.remove('active');
            });
            
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
});

// Add some interactivity
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
});

// Simulate cart update
document.addEventListener('DOMContentLoaded', function() {
    const cartButtons = document.querySelectorAll('.icon-btn[title="Cart"]');
    cartButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const badge = this.querySelector('.cart-badge');
            if (badge) {
                let count = parseInt(badge.textContent);
                badge.textContent = count + 1;
                
                // Add a little animation
                badge.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                }, 200);
            }
        });
    });
});