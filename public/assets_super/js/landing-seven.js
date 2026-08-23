/* Quantro Landing (landing-seven) — interactions */
(function () {
    'use strict';

    var root = document.querySelector('.landing-v7');
    if (!root) return;

    /* ── Theme (dark / light) with persistence ───────────── */
    var THEME_KEY = 'q7-theme';
    function applyTheme(theme) {
        if (theme === 'dark') {
            root.setAttribute('data-theme', 'dark');
        } else {
            root.removeAttribute('data-theme');
        }
    }
    // Default is always light. Dark only when the user explicitly chose it.
    try {
        var saved = localStorage.getItem(THEME_KEY);
        applyTheme(saved === 'dark' ? 'dark' : 'light');
    } catch (e) {
        applyTheme('light');
    }

    var themeBtn = document.getElementById('q7ThemeToggle');
    if (themeBtn) {
        themeBtn.addEventListener('click', function () {
            var isDark = root.getAttribute('data-theme') === 'dark';
            var next = isDark ? 'light' : 'dark';
            applyTheme(next);
            try { localStorage.setItem(THEME_KEY, next); } catch (e) {}
        });
    }

    /* ── Hero slider ─────────────────────────────────────── */
    var slider = document.getElementById('q7HeroSlider');
    if (slider) {
        var slides = slider.querySelectorAll('.q7-hero__slide');
        // Nav lives outside the slider (sibling), so scope the lookup to the hero.
        var hero = slider.closest('.q7-hero') || document;
        var dots = hero.querySelectorAll('.q7-hero__dot');
        var arrows = hero.querySelectorAll('.q7-hero__arrow');
        var current = 0;
        var interval = parseInt(slider.getAttribute('data-interval'), 10) || 6000;
        var timer = null;

        // Per-slide headline/subtitle text (bilingual, resolved server-side).
        var texts = [];
        try { texts = JSON.parse(slider.getAttribute('data-slides') || '[]'); } catch (e) {}
        var elPre = document.getElementById('q7HeroPre');
        var elGrad = document.getElementById('q7HeroGrad');
        var elSub = document.getElementById('q7HeroSub');

        function show(n) {
            current = (n + slides.length) % slides.length;
            slides.forEach(function (s, i) { s.classList.toggle('is-active', i === current); });
            dots.forEach(function (d, i) { d.classList.toggle('is-active', i === current); });
            var t = texts[current];
            if (t) {
                // Cross-fade the copy in sync with the image.
                var copy = [elPre, elGrad, elSub];
                copy.forEach(function (el) { if (el) el.style.opacity = '0'; });
                setTimeout(function () {
                    if (elPre) elPre.textContent = t.pre;
                    if (elGrad) elGrad.textContent = t.grad;
                    if (elSub) elSub.textContent = t.sub;
                    copy.forEach(function (el) { if (el) el.style.opacity = ''; });
                }, 180);
            }
        }
        function start() { stop(); if (slides.length > 1) timer = setInterval(function () { show(current + 1); }, interval); }
        function stop() { if (timer) clearInterval(timer); }

        dots.forEach(function (d) {
            d.addEventListener('click', function () { show(parseInt(d.getAttribute('data-slide'), 10)); start(); });
        });
        arrows.forEach(function (a) {
            a.addEventListener('click', function () { show(current + (a.getAttribute('data-dir') === 'next' ? 1 : -1)); start(); });
        });
        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
        start();
    }

    /* ── Pricing: monthly / yearly toggle ────────────────── */
    var monthlyBtn = document.getElementById('q7Monthly');
    var yearlyBtn = document.getElementById('q7Yearly');
    function setBilling(yearly) {
        if (monthlyBtn) monthlyBtn.classList.toggle('is-active', !yearly);
        if (yearlyBtn) yearlyBtn.classList.toggle('is-active', yearly);
        document.querySelectorAll('[data-price-monthly]').forEach(function (el) {
            var m = el.getAttribute('data-price-monthly');
            var y = el.getAttribute('data-price-yearly');
            el.textContent = yearly && y ? y : m;
        });
        document.querySelectorAll('[data-per-monthly]').forEach(function (el) {
            var m = el.getAttribute('data-per-monthly');
            var y = el.getAttribute('data-per-yearly');
            el.textContent = yearly && y ? y : m;
        });
    }
    if (monthlyBtn) monthlyBtn.addEventListener('click', function () { setBilling(false); });
    if (yearlyBtn) yearlyBtn.addEventListener('click', function () { setBilling(true); });

    /* ── FAQ: keep one open at a time ────────────────────── */
    var faqs = document.querySelectorAll('.q7-faq');
    faqs.forEach(function (d) {
        d.addEventListener('toggle', function () {
            if (d.open) {
                faqs.forEach(function (o) { if (o !== d) o.open = false; });
            }
        });
    });

    /* ── Mobile nav toggle ───────────────────────────────── */
    var navToggle = document.getElementById('q7NavToggle');
    var navLinks = document.querySelector('.q7-nav-links');
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function () {
            var open = navLinks.style.display === 'flex';
            navLinks.style.display = open ? '' : 'flex';
        });
    }

    /* ── Cookie consent ──────────────────────────────────── */
    var COOKIE_KEY = 'q7-cookie-consent';
    var banner = document.getElementById('q7Cookie');
    if (banner) {
        var decided = false;
        try { decided = !!localStorage.getItem(COOKIE_KEY); } catch (e) {}
        if (!decided) {
            setTimeout(function () { banner.classList.add('show'); }, 700);
        }
        function decide(value) {
            try { localStorage.setItem(COOKIE_KEY, value); } catch (e) {}
            banner.classList.remove('show');
        }
        var accept = document.getElementById('q7CookieAccept');
        var reject = document.getElementById('q7CookieReject');
        if (accept) accept.addEventListener('click', function () { decide('all'); });
        if (reject) reject.addEventListener('click', function () { decide('necessary'); });
    }
})();
