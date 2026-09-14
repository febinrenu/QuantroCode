(function () {
    var root = document.documentElement;

    /* ---------- header shadow on scroll ---------- */
    var header = document.getElementById('l6Header');
    if (header) {
        function onScroll() { header.classList.toggle('shadow-md', window.scrollY > 8); }
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ---------- mobile drawer ---------- */
    var drawer = document.getElementById('l6Drawer');
    var panel = document.getElementById('l6DrawerPanel');
    var openBtn = document.getElementById('l6OpenMenu');
    var closeBtn = document.getElementById('l6CloseMenu');
    function dt() { return root.getAttribute('dir') === 'rtl' ? 'translateX(-100%)' : 'translateX(100%)'; }
    function openDrawer() {
        if (!drawer || !panel) return;
        panel.style.transform = dt();
        drawer.classList.remove('hidden');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(function () { panel.style.transform = 'translateX(0)'; });
        if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
    }
    function closeDrawer() {
        if (!drawer || !panel) return;
        panel.style.transform = dt();
        if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        setTimeout(function () { drawer.classList.add('hidden'); drawer.setAttribute('aria-hidden', 'true'); }, 280);
    }
    if (openBtn && drawer) openBtn.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    if (drawer) {
        drawer.querySelectorAll('[data-l6-drawer-backdrop], a').forEach(function (el) {
            el.addEventListener('click', function () { closeDrawer(); });
        });
    }
    window.addEventListener('resize', function () { if (window.innerWidth >= 1024 && drawer && !drawer.classList.contains('hidden')) closeDrawer(); });

    /* ---------- theme toggle (light/dark) ---------- */
    var themeBtn = document.getElementById('l6ThemeBtn');
    var THEME_KEY = 'quantro_landing_theme';
    function applyTheme(theme) {
        if (theme === 'dark') { root.setAttribute('data-theme', 'dark'); }
        else { root.removeAttribute('data-theme'); }
    }
    var savedTheme = null;
    try { savedTheme = localStorage.getItem(THEME_KEY); } catch (e) {}
    if (savedTheme) applyTheme(savedTheme);
    if (themeBtn) {
        themeBtn.addEventListener('click', function () {
            var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            try { localStorage.setItem(THEME_KEY, next); } catch (e) {}
        });
    }

    /* ---------- language toggle (EN/AR) ---------- */
    var LANG_KEY = 'quantro_landing_lang';
    var enBtn = document.getElementById('l6LangEn');
    var arBtn = document.getElementById('l6LangAr');
    function applyLang(lang) {
        if (lang === 'ar') { root.setAttribute('dir', 'rtl'); root.setAttribute('lang', 'ar'); }
        else { root.setAttribute('dir', 'ltr'); root.setAttribute('lang', 'en'); }
        if (enBtn) enBtn.classList.toggle('is-active', lang !== 'ar');
        if (arBtn) arBtn.classList.toggle('is-active', lang === 'ar');
    }
    var savedLang = null;
    try { savedLang = localStorage.getItem(LANG_KEY); } catch (e) {}
    applyLang(savedLang === 'ar' ? 'ar' : 'en');
    if (enBtn) enBtn.addEventListener('click', function () { applyLang('en'); try { localStorage.setItem(LANG_KEY, 'en'); } catch (e) {} });
    if (arBtn) arBtn.addEventListener('click', function () { applyLang('ar'); try { localStorage.setItem(LANG_KEY, 'ar'); } catch (e) {} });

    /* ---------- pricing monthly / yearly toggle ---------- */
    var priceTabs = document.querySelectorAll('.l6-price-tab');
    if (priceTabs.length) {
        priceTabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var cycle = btn.getAttribute('data-cycle');
                var wrap = btn.closest('.l6-price-tab-wrap') || btn.parentElement;
                if (wrap) {
                    wrap.querySelectorAll('.l6-price-tab').forEach(function (b) {
                        b.classList.toggle('is-active', b.getAttribute('data-cycle') === cycle);
                    });
                }
                document.querySelectorAll('.l6-plan-card').forEach(function (card) {
                    card.classList.toggle('show-yearly', cycle === 'yearly');
                });
            });
        });
    }

    /* ---------- FAQ accordion (single-open) ---------- */
    var faqItems = document.querySelectorAll('.l6-faq-item');
    faqItems.forEach(function (item) {
        var q = item.querySelector('.l6-faq-q');
        if (!q) return;
        q.addEventListener('click', function () {
            var wasOpen = item.classList.contains('is-open');
            faqItems.forEach(function (i) { i.classList.remove('is-open'); });
            if (!wasOpen) item.classList.add('is-open');
        });
    });

    /* ---------- hero slideshow ---------- */
    var slideStage = document.getElementById('l6HeroSlides');
    if (slideStage) {
        var slideImgs = Array.prototype.slice.call(slideStage.querySelectorAll('.l6-hero-slide-img'));
        var dotsWrap = document.getElementById('l6HeroDots');
        var dots = dotsWrap ? Array.prototype.slice.call(dotsWrap.querySelectorAll('.l6-hero-dot')) : [];
        var prevBtn = document.getElementById('l6HeroPrev');
        var nextBtn = document.getElementById('l6HeroNext');
        var current = 0;
        var timer = null;

        function goTo(i) {
            var n = slideImgs.length;
            current = ((i % n) + n) % n;
            slideImgs.forEach(function (img, idx) { img.classList.toggle('is-active', idx === current); });
            dots.forEach(function (d, idx) { d.classList.toggle('is-active', idx === current); });
            document.querySelectorAll('[data-slide-text]').forEach(function (el) {
                el.querySelectorAll('[data-slide-index]').forEach(function (span) {
                    span.style.display = (parseInt(span.getAttribute('data-slide-index'), 10) === current) ? '' : 'none';
                });
            });
        }
        function start() {
            clearInterval(timer);
            timer = setInterval(function () { goTo(current + 1); }, 6000);
        }
        if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); start(); });
        if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); start(); });
        dots.forEach(function (d, idx) {
            d.addEventListener('click', function () { goTo(idx); start(); });
        });
        goTo(0);
        start();
    }

    /* ---------- cookie consent ---------- */
    var banner = document.getElementById('cookieConsent');
    if (banner) {
        function show() {
            banner.classList.remove('translate-y-[120%]', 'opacity-0', 'pointer-events-none');
            banner.classList.add('translate-y-0', 'opacity-100');
        }
        if (!localStorage.getItem('cookie_consent')) setTimeout(show, 600);
        function hide() { banner.classList.add('translate-y-[120%]', 'opacity-0', 'pointer-events-none'); }
        var a = document.getElementById('cookieAcceptBtn');
        var r = document.getElementById('cookieRejectBtn');
        var c = document.getElementById('cookieCustomizeBtn');
        var s = document.getElementById('cookieSaveBtn');
        if (a) a.addEventListener('click', function () { localStorage.setItem('cookie_consent', JSON.stringify({ necessary: true, analytics: true, marketing: true, timestamp: Date.now() })); hide(); });
        if (r) r.addEventListener('click', function () { localStorage.setItem('cookie_consent', JSON.stringify({ necessary: true, analytics: false, marketing: false, timestamp: Date.now() })); hide(); });
        if (c) c.addEventListener('click', function () { var p = document.getElementById('cookieCustomize'); if (p) p.classList.toggle('hidden'); });
        if (s) s.addEventListener('click', function () {
            var ca = document.getElementById('cookieAnalytics');
            var cm = document.getElementById('cookieMarketing');
            localStorage.setItem('cookie_consent', JSON.stringify({ necessary: true, analytics: ca && ca.checked, marketing: cm && cm.checked, timestamp: Date.now() }));
            hide();
        });
        window.reopenCookieConsent = function () {
            localStorage.removeItem('cookie_consent');
            var p = document.getElementById('cookieCustomize');
            if (p) p.classList.add('hidden');
            show();
        };
        var prefLink = document.getElementById('cookiePreferencesLink');
        if (prefLink) prefLink.addEventListener('click', function (e) { e.preventDefault(); window.reopenCookieConsent(); });
    }
})();
