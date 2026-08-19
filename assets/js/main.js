/**
 * SiJurusan - Main JavaScript
 * Loading screen, Dark Mode toggle, Navbar scroll, Back to top, AOS init
 */

document.addEventListener('DOMContentLoaded', function () {

    // ==== Loading Screen ====
    const loadingScreen = document.getElementById('loading-screen');
    window.addEventListener('load', function () {
        setTimeout(() => loadingScreen?.classList.add('hide'), 300);
    });

    // ==== AOS Scroll Animation ====
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 700, once: true, offset: 60 });
    }

    // ==== Dark Mode Toggle ====
    const darkToggle = document.getElementById('darkModeToggle');
    const htmlEl = document.documentElement;
    const savedTheme = localStorage.getItem('sijurusan-theme');

    if (savedTheme) {
        htmlEl.setAttribute('data-bs-theme', savedTheme);
        updateDarkIcon(savedTheme);
    }

    darkToggle?.addEventListener('click', function () {
        const current = htmlEl.getAttribute('data-bs-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        htmlEl.setAttribute('data-bs-theme', next);
        localStorage.setItem('sijurusan-theme', next);
        updateDarkIcon(next);
    });

    function updateDarkIcon(theme) {
        const icon = darkToggle?.querySelector('i');
        if (!icon) return;
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }

    // ==== Navbar Shadow on Scroll ====
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 20) {
            navbar?.classList.add('shadow-lg');
        } else {
            navbar?.classList.remove('shadow-lg');
        }

        // ==== Back To Top ====
        const backToTop = document.getElementById('backToTop');
        if (window.scrollY > 400) {
            backToTop?.classList.add('show');
        } else {
            backToTop?.classList.remove('show');
        }
    });

    document.getElementById('backToTop')?.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // ==== Auto-dismiss alert setelah 5 detik ====
    document.querySelectorAll('.alert-auto-dismiss').forEach(alertEl => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
            bsAlert.close();
        }, 5000);
    });
});
