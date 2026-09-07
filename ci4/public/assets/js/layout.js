document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar-custom');
    const navbarCollapse = document.getElementById('navbarNav');
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function updateNavbar() {
        if (navbar) {
            navbar.classList.toggle('is-scrolled', window.scrollY > 24);
        }
    }

    updateNavbar();
    window.addEventListener('scroll', updateNavbar, { passive: true });

    document.querySelectorAll('.navbar-custom .nav-link').forEach(function (link) {
        const linkUrl = new URL(link.href, window.location.origin);
        const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';
        const linkPath = linkUrl.pathname.replace(/\/+$/, '') || '/';
        const isActive = linkUrl.hash ? window.location.hash === linkUrl.hash : currentPath === linkPath;
        link.classList.toggle('active', isActive);

        link.addEventListener('click', function () {
            if (navbarCollapse && navbarCollapse.classList.contains('show') && window.bootstrap) {
                bootstrap.Collapse.getOrCreateInstance(navbarCollapse).hide();
            }
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (event) {
            const target = document.querySelector(anchor.getAttribute('href'));
            if (!target) return;
            event.preventDefault();
            target.scrollIntoView({ behavior: prefersReducedMotion ? 'auto' : 'smooth', block: 'start' });
        });
    });

    const backToTop = document.createElement('button');
    backToTop.type = 'button';
    backToTop.className = 'back-to-top';
    backToTop.setAttribute('aria-label', 'Kembali ke atas');
    backToTop.innerHTML = '<i class="fas fa-arrow-up" aria-hidden="true"></i>';
    document.body.appendChild(backToTop);

    function updateBackToTop() {
        backToTop.classList.toggle('visible', window.scrollY > 500);
    }

    updateBackToTop();
    window.addEventListener('scroll', updateBackToTop, { passive: true });
    backToTop.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    });

    const revealElements = document.querySelectorAll('.reveal');
    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        revealElements.forEach(function (element) { element.classList.add('is-visible'); });
    } else {
        const revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -24px 0px' });

        revealElements.forEach(function (element) { revealObserver.observe(element); });
    }
});
