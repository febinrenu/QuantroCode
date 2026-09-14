<!DOCTYPE html>
@php
    $generalSettings = \App\Models\Central\GeneralSetting::instance();
    $appName = 'Quantro';
    $quantroLockup   = asset('images/super/landing-design/quantro/quantro-lockup.png');
    $quantroLogoLight = asset('images/super/landing-design/quantro/quantro-h-logo.png');
    $quantroQ      = asset('images/super/landing-design/quantro/quantro-q.png');
    $heroSlides = [
        asset('images/super/landing-design/quantro/hero-slide-1.png'),
        asset('images/super/landing-design/quantro/hero-slide-2.png'),
        asset('images/super/landing-design/quantro/hero-slide-3.png'),
        asset('images/super/landing-design/quantro/hero-slide-4.png'),
        asset('images/super/landing-design/quantro/hero-slide-5.png'),
    ];
@endphp
<html lang="en" dir="ltr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if($seo)
        <title>{{ $seo->meta_title ?? ($appName . ' — Enterprise Business Platform') }}</title>
        <meta name="description" content="{{ $seo->meta_description ?? 'Run POS, inventory, e-commerce, HR and accounting from one intelligent platform.' }}">
        @if($seo->meta_keywords)
            <meta name="keywords" content="{{ $seo->meta_keywords }}">
        @endif
        <meta property="og:title" content="{{ $seo->meta_title ?? $appName }}">
        <meta property="og:description" content="{{ $seo->meta_description ?? '' }}">
        @if($seo->og_image)
            <meta property="og:image" content="{{ asset($seo->og_image) }}">
        @endif
        <link rel="icon" href="{{ $seo->favicon ? asset($seo->favicon) : $quantroQ }}">
    @else
        <title>{{ $appName }} — Enterprise Business Platform</title>
        <link rel="icon" href="{{ $quantroQ }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="{{ asset('assets_super/js/tailwindcss.js') }}"></script>
    <link href="{{ asset('assets_super/css/landing-six-page.css') }}" rel="stylesheet">
    @include('central.partials.landing-font')
</head>
<body class="quantro-l6 antialiased overflow-x-hidden" style="font-size:14px">

    <nav id="l6Header" class="sticky top-0 z-50 flex items-center gap-4 px-5 py-3">
        <a href="{{ route('central.welcome') }}" class="flex items-center shrink-0">
            <img src="{{ $quantroLogoLight }}" alt="{{ $appName }}" class="l6-logo-light h-9 md:h-10 w-auto">
            <img src="{{ $quantroLockup }}" alt="{{ $appName }}" class="l6-logo-dark h-9 md:h-10 w-auto">
        </a>
        <div class="flex-1"></div>
        <div class="hidden lg:flex items-center gap-0.5 flex-wrap min-w-0">
            <a href="#features" class="l6-nav-link"><span class="i18n-en">Features</span><span class="i18n-ar">المميزات</span></a>
            <a href="#industries" class="l6-nav-link"><span class="i18n-en">Industries</span><span class="i18n-ar">القطاعات</span></a>
            <a href="#pricing" class="l6-nav-link"><span class="i18n-en">Pricing</span><span class="i18n-ar">الأسعار</span></a>
            <a href="#testimonials" class="l6-nav-link"><span class="i18n-en">Customers</span><span class="i18n-ar">العملاء</span></a>
            <a href="#faq" class="l6-nav-link"><span class="i18n-en">FAQ</span><span class="i18n-ar">الأسئلة</span></a>
        </div>
        <div class="hidden sm:flex l6-lang-toggle">
            <button type="button" id="l6LangEn" class="l6-lang-btn is-active">EN</button>
            <button type="button" id="l6LangAr" class="l6-lang-btn" style="font-family:'IBM Plex Sans Arabic',sans-serif">العربية</button>
        </div>
        <button type="button" id="l6ThemeBtn" class="l6-theme-btn" aria-label="Toggle theme">
            <svg class="l6-icon-light" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a8.5 8.5 0 1 0 11 11Z"></path></svg>
            <svg class="l6-icon-dark" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4.2"></circle><path d="M12 2.5v2.4M12 19.1v2.4M2.5 12h2.4M19.1 12h2.4M5 5l1.7 1.7M17.3 17.3 19 19M19 5l-1.7 1.7M6.7 17.3 5 19"></path></svg>
        </button>
        <a href="{{ route('central.login') }}" class="hidden md:inline font-semibold text-[12.5px] px-1.5 py-2 whitespace-nowrap" style="color:var(--ink)"><span class="i18n-en">Login</span><span class="i18n-ar">تسجيل الدخول</span></a>
        <a href="{{ route('central.register') }}" class="hidden sm:inline-flex items-center justify-center l6-btn-primary px-[18px] py-2.5 text-[12.5px] whitespace-nowrap"><span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة المجانية</span></a>
        <button type="button" id="l6OpenMenu" class="lg:hidden p-2 rounded-xl" style="color:var(--ink)" aria-expanded="false" aria-controls="l6Drawer" aria-label="Menu">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"></path></svg>
        </button>
    </nav>

    <div class="fixed inset-0 z-[60] lg:hidden hidden" id="l6Drawer" aria-hidden="true">
        <div class="absolute inset-0" style="background:rgba(10,20,40,.45);backdrop-filter:blur(2px)" data-l6-drawer-backdrop></div>
        <div class="absolute top-0 end-0 h-full w-[min(20rem,100%)] flex flex-col p-6 l6-card" id="l6DrawerPanel" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="flex justify-end mb-6">
                <button type="button" class="p-2 rounded-xl" id="l6CloseMenu" aria-label="Close" style="color:var(--ink)">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"></path></svg>
                </button>
            </div>
            <nav class="flex flex-col gap-1 font-semibold" style="color:var(--ink)">
                <a href="#features" class="py-3 px-3 rounded-xl" style="color:var(--ink)"><span class="i18n-en">Features</span><span class="i18n-ar">المميزات</span></a>
                <a href="#industries" class="py-3 px-3 rounded-xl" style="color:var(--ink)"><span class="i18n-en">Industries</span><span class="i18n-ar">القطاعات</span></a>
                <a href="#pricing" class="py-3 px-3 rounded-xl" style="color:var(--ink)"><span class="i18n-en">Pricing</span><span class="i18n-ar">الأسعار</span></a>
                <a href="#testimonials" class="py-3 px-3 rounded-xl" style="color:var(--ink)"><span class="i18n-en">Customers</span><span class="i18n-ar">العملاء</span></a>
                <a href="#faq" class="py-3 px-3 rounded-xl" style="color:var(--ink)"><span class="i18n-en">FAQ</span><span class="i18n-ar">الأسئلة</span></a>
            </nav>
            <div class="mt-auto pt-8 flex flex-col gap-3 border-t" style="border-color:var(--bd)">
                <a href="{{ route('central.login') }}" class="py-3 text-center rounded-full border-2 font-semibold" style="border-color:var(--ink);color:var(--ink)"><span class="i18n-en">Login</span><span class="i18n-ar">تسجيل الدخول</span></a>
                <a href="{{ route('central.register') }}" class="py-3 text-center l6-btn-primary font-bold"><span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة المجانية</span></a>
            </div>
        </div>
    </div>

    <main id="main">
    {{-- ============ HERO ============ --}}
    <section id="top" class="relative overflow-hidden" style="background:var(--bg)">
        <div class="l6-hero-glow-a" aria-hidden="true"></div>
        <div class="l6-hero-glow-b" aria-hidden="true"></div>
        <div class="l6-hero-grid grid lg:grid-cols-[0.92fr_1.08fr] gap-10 lg:gap-12 max-w-[1360px] mx-auto px-5 py-11 md:py-16 items-center">
            <div class="max-w-[560px] mx-auto lg:mx-0 text-center lg:text-start">
                <div class="text-[12px] font-bold uppercase tracking-[1.6px]" style="color:#00A882">
                    <span class="i18n-en">All-in-one Business Management Platform</span><span class="i18n-ar" style="letter-spacing:0;font-size:13px;text-transform:none">منصة متكاملة لإدارة الأعمال</span>
                </div>

                <h1 class="font-display font-extrabold mt-4" style="font-size:clamp(1.9rem,4.4vw,2.7rem);line-height:1.14;letter-spacing:-1.1px;color:var(--ink);min-height:112px" data-slide-text>
                    <span data-slide-index="0"><span class="i18n-en">Run Your Entire Business from <span class="grad-text">One Intelligent Platform</span></span><span class="i18n-ar" style="letter-spacing:0">شغّل أعمالك بالكامل من خلال <span class="grad-text">منصة ذكية واحدة</span></span></span>
                    <span data-slide-index="1" style="display:none"><span class="i18n-en">Sell Faster with <span class="grad-text">Smart POS</span></span><span class="i18n-ar" style="letter-spacing:0">بِع بشكل أسرع مع <span class="grad-text">نظام نقاط بيع ذكي</span></span></span>
                    <span data-slide-index="2" style="display:none"><span class="i18n-en">Launch Your Store. <span class="grad-text">Grow Everywhere.</span></span><span class="i18n-ar" style="letter-spacing:0">أطلق متجرك. <span class="grad-text">ووسّع انتشارك في كل مكان.</span></span></span>
                    <span data-slide-index="3" style="display:none"><span class="i18n-en">Master Inventory Across <span class="grad-text">Every Warehouse</span></span><span class="i18n-ar" style="letter-spacing:0">تحكّم بالمخزون عبر <span class="grad-text">جميع المستودعات</span></span></span>
                    <span data-slide-index="4" style="display:none"><span class="i18n-en">Manage People, Operations, <span class="grad-text">and Growth</span></span><span class="i18n-ar" style="letter-spacing:0">أدر الموظفين والعمليات <span class="grad-text">والنمو بكفاءة</span></span></span>
                </h1>

                <p class="mt-[18px] max-w-[480px] mx-auto lg:mx-0" style="color:var(--ink2);font-size:15.5px;line-height:1.65;min-height:72px" data-slide-text>
                    <span data-slide-index="0"><span class="i18n-en">Quantro connects your operations, teams, sales, customers, and insights in one powerful business ecosystem.</span><span class="i18n-ar">يربط كوانترو بين العمليات والمبيعات والفرق والعملاء والتحليلات ضمن نظام أعمال موحد واحترافي.</span></span>
                    <span data-slide-index="1" style="display:none"><span class="i18n-en">Empower your retail operations with fast checkout, barcode scanning, payment flexibility, and complete point-of-sale control.</span><span class="i18n-ar">طوّر تجربة البيع لديك عبر الدفع السريع، ومسح الباركود، ومرونة وسائل الدفع، وتحكم كامل بنقطة البيع.</span></span>
                    <span data-slide-index="2" style="display:none"><span class="i18n-en">Manage products, orders, promotions, and online selling across multiple channels from one seamless commerce experience.</span><span class="i18n-ar">قم بإدارة المنتجات والطلبات والعروض والبيع الإلكتروني عبر قنوات متعددة من خلال تجربة تجارة متكاملة.</span></span>
                    <span data-slide-index="3" style="display:none"><span class="i18n-en">Track stock, monitor low inventory, manage transfers, and gain real-time visibility across all warehouse operations.</span><span class="i18n-ar">تابع المخزون، وراقب النواقص، وأدر عمليات النقل، واحصل على رؤية لحظية وشاملة لكل عمليات المستودعات.</span></span>
                    <span data-slide-index="4" style="display:none"><span class="i18n-en">Streamline employees, workflows, reporting, and operational planning with a connected management experience.</span><span class="i18n-ar">نظّم شؤون الموظفين وسير العمل والتقارير والتخطيط التشغيلي من خلال تجربة إدارية مترابطة واحترافية.</span></span>
                </p>

                <div class="flex justify-center lg:justify-start gap-3 mt-[26px] flex-wrap">
                    <a href="{{ route('central.register') }}" class="l6-btn-primary inline-flex items-center gap-[9px] px-[26px] py-[14px] text-sm">
                        <span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة المجانية</span>
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                    </a>
                    <a href="#cta" class="l6-btn-outline inline-flex items-center gap-[9px] px-[26px] py-[14px] text-sm">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M8 5.5v13l11-6.5-11-6.5Z"></path></svg>
                        <span class="i18n-en">Book a Demo</span><span class="i18n-ar">احجز عرضاً توضيحياً</span>
                    </a>
                </div>

                <div class="l6-check-row flex justify-center lg:justify-start gap-5 mt-5 text-xs flex-wrap" style="color:var(--ink3)">
                    <span class="flex items-center gap-[6px]"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg><span class="i18n-en">No credit card required</span><span class="i18n-ar">بدون بطاقة ائتمان</span></span>
                    <span class="flex items-center gap-[6px]"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3.5 2"></path></svg><span class="i18n-en">14-day free trial</span><span class="i18n-ar">تجربة مجانية ١٤ يوماً</span></span>
                    <span class="flex items-center gap-[6px]"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3 4 7v5c0 4.5 3.2 7.9 8 9 4.8-1.1 8-4.5 8-9V7l-8-4Z"></path></svg><span class="i18n-en">Arabic &amp; English built-in</span><span class="i18n-ar">العربية والإنجليزية مدمجتان</span></span>
                </div>

                <div class="l6-card l6-stats-row rounded-2xl mt-7 flex flex-wrap items-center justify-between gap-y-4 px-5 py-4">
                    @php
                        $heroStats = [
                            ['#2563EB', '<path d="M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M2.7 19c.6-3 2.8-4.6 6.3-4.6s5.7 1.6 6.3 4.6"/><circle cx="17" cy="8.5" r="2.2"/><path d="M15.6 13.4c2.1.3 3.5 1.7 4 4"/>', '10K+', 'Businesses', 'شركة'],
                            ['#00A882', '<path d="M4 20V10M12 20V4M20 20v-7"/>', '50M+', 'Transactions', 'معاملة'],
                            ['#2563EB', '<path d="M12 3 4 7v5c0 4.5 3.2 7.9 8 9 4.8-1.1 8-4.5 8-9V7l-8-4Z"/><path d="m9 12 2 2 4-4"/>', '99.9%', 'Uptime', 'وقت التشغيل'],
                            ['#00A882', '<path d="M4 13v-1a8 8 0 0 1 16 0v1"/><rect x="2.6" y="13" width="4" height="6" rx="1.4"/><rect x="17.4" y="13" width="4" height="6" rx="1.4"/><path d="M19.4 19v.4a3 3 0 0 1-3 3H13"/>', '24/7', 'Support', 'دعم فني'],
                            ['#E8A100', '<path d="m12 3 2.6 5.9 6.4.6-4.8 4.3 1.4 6.3L12 17l-5.6 3.1 1.4-6.3-4.8-4.3 6.4-.6L12 3Z"/>', '4.8/5', 'User Rating', 'تقييم المستخدمين'],
                        ];
                    @endphp
                    @foreach($heroStats as [$iconColor, $iconPaths, $value, $label, $labelAr])
                    <div class="flex items-center gap-[9px]">
                        <svg viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $iconPaths !!}</svg>
                        <div>
                            <div class="font-display font-extrabold text-[16px] md:text-[18px] leading-none" style="color:var(--ink)">{{ $value }}</div>
                            <div class="text-[10.5px] mt-[3px]" style="color:var(--ink3)"><span class="i18n-en">{{ $label }}</span><span class="i18n-ar">{{ $labelAr }}</span></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <p class="text-center lg:text-start text-[11px] font-semibold uppercase tracking-[1px] mt-6 mb-3" style="color:var(--ink3)"><span class="i18n-en">Trusted by businesses worldwide</span><span class="i18n-ar" style="text-transform:none;letter-spacing:0">موثوق به من الشركات حول العالم</span></p>
                <div class="flex items-center justify-center lg:justify-start gap-6 flex-wrap opacity-75">
                    <span class="l6-partner-logo text-[15px]" style="color:#635BFF">stripe</span>
                    <span class="font-bold text-[15px] italic" style="color:#00457C">PayPal</span>
                    <span class="l6-partner-logo text-[15px]" style="color:var(--ink)">mollie</span>
                    <span class="font-bold text-sm italic" style="color:#0C2451">▰Razorpay</span>
                    <span class="font-bold text-sm" style="color:var(--ink)">◈ Shippo</span>
                    <span class="font-bold text-[15px]" style="color:#F22F46">twilio</span>
                    <span class="text-xs" style="color:var(--ink3)"><span class="i18n-en">and more…</span><span class="i18n-ar">والمزيد…</span></span>
                </div>
            </div>

            <div class="l6-hero-stage-col relative flex flex-col items-center">
                <div class="l6-hero-slide-stage" id="l6HeroSlides">
                    @foreach($heroSlides as $i => $src)
                        <img src="{{ $src }}" alt="Quantro platform preview {{ $i + 1 }}" class="l6-hero-slide-img @if($i === 0) is-active @endif" decoding="async">
                    @endforeach
                </div>
            </div>
        </div>

        <div class="l6-hero-nav relative flex items-center justify-center gap-3 max-w-[1360px] mx-auto px-5 pb-11 md:pb-16 -mt-2">
            <button type="button" id="l6HeroPrev" class="l6-hero-arrow" aria-label="Previous slide">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="m15 6-6 6 6 6"></path></svg>
            </button>
            <div id="l6HeroDots" class="flex items-center gap-[9px]">
                @for($i = 0; $i < 5; $i++)
                    <button type="button" class="l6-hero-dot @if($i === 0) is-active @endif" aria-label="Go to slide {{ $i + 1 }}"></button>
                @endfor
            </div>
            <button type="button" id="l6HeroNext" class="l6-hero-arrow" aria-label="Next slide">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="m9 6 6 6-6 6"></path></svg>
            </button>
        </div>
    </section>

    {{-- ============ FEATURES ============ --}}
    <section id="features" class="px-5 pt-16 pb-6 max-w-[1180px] mx-auto scroll-mt-24">
        <div class="text-center max-w-[620px] mx-auto">
            <div class="text-[11px] font-bold uppercase tracking-[1.8px]" style="color:#00A882"><span class="i18n-en">Powerful Features</span><span class="i18n-ar" style="letter-spacing:0;font-size:13px">مميزات قوية</span></div>
            <h2 class="font-display font-extrabold mt-[10px]" style="font-size:clamp(1.6rem,3.4vw,1.95rem);letter-spacing:-.8px;color:var(--ink)"><span class="i18n-en">Everything You Need to Manage &amp; Grow Your Business</span><span class="i18n-ar" style="letter-spacing:0">كل ما تحتاجه لإدارة وتنمية أعمالك</span></h2>
            <p class="mt-3 text-sm" style="color:var(--ink2)"><span class="i18n-en">Ten integrated modules that share one database, one design and one login.</span><span class="i18n-ar">عشر وحدات متكاملة تتشارك قاعدة بيانات واحدة وتصميماً واحداً وتسجيل دخول واحداً.</span></p>
        </div>
        <div class="l6-features-grid grid grid-cols-5 gap-3 mt-9">
            @php
                $features = [
                    ['B','rgba(37,99,235,.1)','Multi-Warehouse','مستودعات متعددة','Manage multiple warehouses and track stock in real-time.','أدر عدة مستودعات وتتبع المخزون لحظياً.',['M12 2 20.5 7v10L12 22 3.5 17V7L12 2Z','M3.5 7 12 12l8.5-5']],
                    ['T','rgba(0,196,154,.12)','Point of Sale','نقاط البيع','Fast, touch-first POS for in-store and online sales.','نقاط بيع سريعة للمتاجر والمبيعات الإلكترونية.',['M3 5h18v11H3z','M8 21h8M12 16v5']],
                    ['O','rgba(255,159,28,.14)','Purchases &amp; Sales','المشتريات والمبيعات','Complete control over purchases, sales, returns and invoices.','تحكم كامل بالمشتريات والمبيعات والمرتجعات والفواتير.',['M3 3h2l2.6 12.5a2 2 0 0 0 2 1.5h7.9a2 2 0 0 0 2-1.6L21 8H6']],
                    ['P','rgba(139,92,246,.12)','Real-time Reports','تقارير لحظية','Beautiful dashboards and reports for smarter decisions.','لوحات وتقارير جميلة لقرارات أذكى.',['M3 21h18','M7 21V10','M12 21V4','M17 21v-8']],
                    ['C','rgba(14,165,201,.12)','Users &amp; Permissions','المستخدمون والصلاحيات','Granular roles and permissions across every module.','أدوار وصلاحيات دقيقة عبر كل الوحدات.',['M9 11a3.4 3.4 0 1 0 0-6.8A3.4 3.4 0 0 0 9 11Z','M2.8 20c.7-3.4 3.2-5.2 6.2-5.2s5.5 1.8 6.2 5.2','M17.5 12.1a2.6 2.6 0 1 0-2.4-4.2']],
                    ['PK','rgba(232,97,140,.12)','E-Commerce','التجارة الإلكترونية','Integrate with online sales channels and marketplaces.','تكامل مع قنوات البيع الإلكترونية والأسواق.',['M12 2l2.4 6.4L21 9.6l-5 4.5 1.4 6.9-5.4-3.6L6.6 21 8 14.1l-5-4.5 6.6-1.2L12 2Z']],
                    ['T','rgba(0,196,154,.12)','Online Store','المتجر الإلكتروني','Build your own storefront with full commerce features.','أنشئ متجرك الخاص بمميزات تجارية كاملة.',['M4 4h16v4a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2 2 2 0 0 1-4 0 2 2 0 0 1-4 0 2 2 0 0 1-2 2H4V4Z','M5 10v10h14V10']],
                    ['B','rgba(37,99,235,.1)','Client Portal','بوابة العملاء','Self-service portal for your customers and partners.','بوابة خدمة ذاتية لعملائك وشركائك.',['M4 4h16v13H4z','M8 21h8','M9 8h6M9 12h4']],
                    ['P','rgba(139,92,246,.12)','HRM &amp; Payroll','الموارد البشرية والرواتب','Attendance, shifts, leave and payroll in one place.','الحضور والورديات والإجازات والرواتب في مكان واحد.',['M12 11a3.4 3.4 0 1 0 0-6.8A3.4 3.4 0 0 0 12 11Z','M5 20c.8-3.8 3.6-5.8 7-5.8s6.2 2 7 5.8']],
                    ['O','rgba(255,159,28,.14)','24+ Languages','٢٤+ لغة','Fully multilingual including Arabic RTL, English and more.','تعدد لغات كامل يشمل العربية والإنجليزية والمزيد.',['M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z','M3 12h18','M12 3c2.5 2.6 3.8 5.7 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.7-3.8-9S9.5 5.6 12 3Z']],
                ];
                $colorMap = ['B' => '#2563EB', 'T' => '#00A882', 'O' => '#E88A00', 'P' => '#8B5CF6', 'C' => '#0EA5C9', 'PK' => '#E8618C'];
            @endphp
            @foreach($features as [$colorKey, $bg, $title, $titleAr, $desc, $descAr, $paths])
            <article class="l6-feature-card p-4">
                <span class="l6-icon-wrap" style="background:{{ $bg }}">
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="{{ $colorMap[$colorKey] }}" stroke-width="2" stroke-linecap="round">
                        @foreach($paths as $d)<path d="{{ $d }}"></path>@endforeach
                    </svg>
                </span>
                <div class="font-bold text-[13px] mt-[11px]" style="color:var(--ink)"><span class="i18n-en">{!! $title !!}</span><span class="i18n-ar">{{ $titleAr }}</span></div>
                <div class="text-[11.5px] leading-[1.5] mt-[5px]" style="color:var(--ink3)"><span class="i18n-en">{!! $desc !!}</span><span class="i18n-ar">{{ $descAr }}</span></div>
            </article>
            @endforeach
        </div>
    </section>

    {{-- ============ TRANSPARENT & FAIR ============ --}}
    <section class="px-5 py-8 max-w-[1180px] mx-auto">
        <div class="l6-fair-banner l6-fair-grid grid lg:grid-cols-[1.2fr_1fr] gap-8 items-center p-9 md:p-10">
            <div class="relative">
                <h3 class="font-display font-extrabold text-white text-xl md:text-2xl" style="letter-spacing:-.4px"><span class="i18n-en">Transparent &amp; Fair for Every Customer</span><span class="i18n-ar" style="letter-spacing:0">شفافية وعدالة لكل عميل</span></h3>
                <div class="l6-fair-points grid grid-cols-2 gap-x-6 gap-y-[10px] mt-5">
                    @php
                        $fairPoints = [
                            ['No hidden fees', 'لا رسوم خفية'], ['Cancel anytime', 'ألغِ في أي وقت'],
                            ['Secure &amp; reliable', 'آمن وموثوق'], ['Regular updates', 'تحديثات منتظمة'],
                            ['Dedicated support', 'دعم مخصص'], ['Your data is yours', 'بياناتك ملك لك'],
                        ];
                    @endphp
                    @foreach($fairPoints as [$en, $ar])
                    <div class="flex items-center gap-[9px] text-[13px]" style="color:#C6D6EC">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#39E0B8" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                        <span class="i18n-en">{!! $en !!}</span><span class="i18n-ar">{{ $ar }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="relative rounded-2xl p-6" style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12)">
                <div class="text-[10.5px] font-bold uppercase tracking-[1.6px]" style="color:#39E0B8"><span class="i18n-en">How it works</span><span class="i18n-ar" style="letter-spacing:0;font-size:12px">كيف تبدأ</span></div>
                <div class="font-display font-bold text-white text-[17px] mt-[9px]" style="line-height:1.4"><span class="i18n-en">Start your 14-day free trial. No credit card required.</span><span class="i18n-ar">ابدأ تجربتك المجانية لمدة ١٤ يوماً. بدون بطاقة ائتمان.</span></div>
                <a href="{{ route('central.register') }}" class="l6-btn-teal inline-flex items-center gap-2 mt-4 px-5 py-[11px] text-[13px]">
                    <span class="i18n-en">Get Started Now</span><span class="i18n-ar">ابدأ الآن</span>
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ============ INDUSTRIES ============ --}}
    <section id="industries" class="px-5 pt-12 pb-6 max-w-[1180px] mx-auto scroll-mt-24">
        <div class="text-center max-w-[560px] mx-auto">
            <div class="text-[11px] font-bold uppercase tracking-[1.8px]" style="color:#00A882"><span class="i18n-en">Industries</span><span class="i18n-ar" style="letter-spacing:0;font-size:13px">القطاعات</span></div>
            <h2 class="font-display font-extrabold mt-[10px]" style="font-size:clamp(1.5rem,3vw,1.8rem);letter-spacing:-.7px;color:var(--ink)"><span class="i18n-en">Built for the Way You Do Business</span><span class="i18n-ar" style="letter-spacing:0">مصمم لطريقة عملك</span></h2>
        </div>
        <div class="l6-industries-grid grid grid-cols-6 gap-3 mt-[30px]">
            @php
                $industries = [
                    ['B','rgba(37,99,235,.1)','Retail','التجزئة',['M4 4h16v4a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2 2 2 0 0 1-4 0 2 2 0 0 1-4 0 2 2 0 0 1-2 2H4V4Z','M5 10v10h14V10']],
                    ['T','rgba(0,196,154,.12)','Restaurants','المطاعم',['M7 2v9a2 2 0 0 0 2 2v9','M11 2v6M7 2v6','M17 2c-2 2-2.5 5-2.5 8H17v12']],
                    ['O','rgba(255,159,28,.14)','Wholesale','الجملة',['M12 2 20.5 7v10L12 22 3.5 17V7L12 2Z','M3.5 7 12 12l8.5-5','M12 12v10']],
                    ['P','rgba(139,92,246,.12)','Manufacturing','التصنيع',['M2 20h20','M4 20V9l6 4V9l6 4V4h4v16']],
                    ['C','rgba(14,165,201,.12)','Services','الخدمات',['M14.7 6.3a4.5 4.5 0 0 0-6 6L3 18v3h3l5.7-5.7a4.5 4.5 0 0 0 6-6L14 13l-3-3 3.7-3.7Z']],
                    ['PK','rgba(232,97,140,.12)','E-Commerce','المتاجر الإلكترونية',['M3 3h2l2.6 12.5a2 2 0 0 0 2 1.5h7.9a2 2 0 0 0 2-1.6L21 8H6']],
                ];
            @endphp
            @foreach($industries as [$colorKey, $bg, $title, $titleAr, $paths])
            <article class="l6-industry-card p-[18px_12px] text-center">
                <span class="l6-icon-wrap mx-auto" style="background:{{ $bg }}">
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="{{ $colorMap[$colorKey] }}" stroke-width="2" stroke-linecap="round">
                        @foreach($paths as $d)<path d="{{ $d }}"></path>@endforeach
                    </svg>
                </span>
                <div class="font-bold text-[12.5px] mt-[10px]" style="color:var(--ink)"><span class="i18n-en">{{ $title }}</span><span class="i18n-ar">{{ $titleAr }}</span></div>
            </article>
            @endforeach
        </div>
    </section>

    {{-- ============ PRICING ============ --}}
    <section id="pricing" class="px-5 pt-12 pb-6 max-w-[1180px] mx-auto scroll-mt-24">
        <div class="text-center max-w-[560px] mx-auto">
            <div class="text-[11px] font-bold uppercase tracking-[1.8px]" style="color:#00A882"><span class="i18n-en">Pricing</span><span class="i18n-ar" style="letter-spacing:0;font-size:13px">الأسعار</span></div>
            <h2 class="font-display font-extrabold mt-[10px]" style="font-size:clamp(1.5rem,3vw,1.8rem);letter-spacing:-.7px;color:var(--ink)"><span class="i18n-en">Simple Plans that Scale with You</span><span class="i18n-ar" style="letter-spacing:0">خطط بسيطة تنمو معك</span></h2>
            <div class="l6-price-tab-wrap mt-[18px]">
                <button type="button" class="l6-price-tab is-active" data-cycle="monthly"><span class="i18n-en">Monthly</span><span class="i18n-ar">شهري</span></button>
                <button type="button" class="l6-price-tab" data-cycle="yearly"><span class="i18n-en">Yearly · save 20%</span><span class="i18n-ar">سنوي · وفّر ٢٠٪</span></button>
            </div>
        </div>
        <div class="l6-pricing-grid grid grid-cols-3 gap-4 mt-[30px] items-stretch">
            <div class="l6-plan-card">
                <div class="font-bold text-[14.5px]" style="color:var(--ink)"><span class="i18n-en">Starter</span><span class="i18n-ar">الأساسية</span></div>
                <div class="text-[11.5px] mt-[3px]" style="color:var(--ink3)"><span class="i18n-en">For small shops getting started</span><span class="i18n-ar">للمتاجر الصغيرة في بدايتها</span></div>
                <div class="mt-4 flex items-baseline gap-[6px] l6-plan-price" data-period="monthly">
                    <span class="font-display font-extrabold text-[34px]" style="letter-spacing:-1.5px;color:var(--ink)">$29</span>
                    <span class="text-xs" style="color:var(--ink3)">/mo</span>
                </div>
                <div class="mt-4 items-baseline gap-[6px] l6-plan-price" data-period="yearly">
                    <span class="font-display font-extrabold text-[34px]" style="letter-spacing:-1.5px;color:var(--ink)">$23</span>
                    <span class="text-xs" style="color:var(--ink3)">/mo · <span class="i18n-en">billed yearly</span><span class="i18n-ar">دفع سنوي</span></span>
                </div>
                <a href="{{ route('central.register') }}" class="l6-plan-btn-outline"><span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة</span></a>
                <div class="flex flex-col gap-[9px] mt-[18px]">
                    @foreach([['1 warehouse · 2 registers','مستودع واحد · سجلان'],['POS, sales &amp; inventory','نقاط بيع ومبيعات ومخزون'],['Up to 5 users','حتى ٥ مستخدمين'],['Standard reports','تقارير قياسية'],['Email support','دعم عبر البريد']] as [$en,$ar])
                    <div class="flex items-center gap-2 text-[12.5px]" style="color:var(--ink2)">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#00A882" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                        <span class="i18n-en">{!! $en !!}</span><span class="i18n-ar">{{ $ar }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="l6-plan-card is-popular">
                <div class="l6-plan-flag"><span class="i18n-en">Most Popular</span><span class="i18n-ar">الأكثر شيوعاً</span></div>
                <div class="font-bold text-[14.5px]" style="color:var(--ink)"><span class="i18n-en">Growth</span><span class="i18n-ar">النمو</span></div>
                <div class="text-[11.5px] mt-[3px]" style="color:var(--ink3)"><span class="i18n-en">For growing multi-branch businesses</span><span class="i18n-ar">للأعمال متعددة الفروع</span></div>
                <div class="mt-4 flex items-baseline gap-[6px] l6-plan-price" data-period="monthly">
                    <span class="font-display font-extrabold text-[34px]" style="letter-spacing:-1.5px;color:var(--ink)">$79</span>
                    <span class="text-xs" style="color:var(--ink3)">/mo</span>
                </div>
                <div class="mt-4 items-baseline gap-[6px] l6-plan-price" data-period="yearly">
                    <span class="font-display font-extrabold text-[34px]" style="letter-spacing:-1.5px;color:var(--ink)">$63</span>
                    <span class="text-xs" style="color:var(--ink3)">/mo · <span class="i18n-en">billed yearly</span><span class="i18n-ar">دفع سنوي</span></span>
                </div>
                <a href="{{ route('central.register') }}" class="l6-plan-btn-solid"><span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة</span></a>
                <div class="flex flex-col gap-[9px] mt-[18px]">
                    @foreach([['Unlimited warehouses &amp; registers','مستودعات وسجلات غير محدودة'],['E-commerce + online store','تجارة إلكترونية ومتجر'],['HRM, payroll &amp; accounting','موارد بشرية ورواتب ومحاسبة'],['AI reports &amp; analytics','تقارير وتحليلات ذكية'],['Priority support','دعم ذو أولوية']] as [$en,$ar])
                    <div class="flex items-center gap-2 text-[12.5px]" style="color:var(--ink2)">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#00A882" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                        <span class="i18n-en">{!! $en !!}</span><span class="i18n-ar">{{ $ar }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="l6-plan-card">
                <div class="font-bold text-[14.5px]" style="color:var(--ink)"><span class="i18n-en">Enterprise</span><span class="i18n-ar">المؤسسات</span></div>
                <div class="text-[11.5px] mt-[3px]" style="color:var(--ink3)"><span class="i18n-en">For large operations and chains</span><span class="i18n-ar">للعمليات الكبيرة والسلاسل</span></div>
                <div class="mt-4 flex items-baseline gap-[6px]">
                    <span class="font-display font-extrabold text-[34px]" style="letter-spacing:-1.5px;color:var(--ink)"><span class="i18n-en">Custom</span><span class="i18n-ar">مخصص</span></span>
                </div>
                <a href="{{ route('central.register') }}" class="l6-plan-btn-outline"><span class="i18n-en">Talk to Sales</span><span class="i18n-ar">تحدث مع المبيعات</span></a>
                <div class="flex flex-col gap-[9px] mt-[18px]">
                    @foreach([['Everything in Growth','كل مميزات خطة النمو'],['Dedicated success manager','مدير نجاح مخصص'],['Custom integrations &amp; API','تكاملات مخصصة وAPI'],['SLA &amp; advanced security','اتفاقية مستوى خدمة وأمان متقدم'],['On-boarding &amp; training','تهيئة وتدريب']] as [$en,$ar])
                    <div class="flex items-center gap-2 text-[12.5px]" style="color:var(--ink2)">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#00A882" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                        <span class="i18n-en">{!! $en !!}</span><span class="i18n-ar">{{ $ar }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ============ TESTIMONIALS ============ --}}
    <section id="testimonials" class="px-5 pt-12 pb-6 max-w-[1180px] mx-auto scroll-mt-24">
        <div class="text-center">
            <h2 class="font-display font-extrabold" style="font-size:clamp(1.4rem,2.8vw,1.7rem);letter-spacing:-.7px;color:var(--ink)"><span class="i18n-en">Loved by Businesses Worldwide</span><span class="i18n-ar" style="letter-spacing:0">محبوب من الشركات حول العالم</span></h2>
        </div>
        <div class="l6-testimonials-grid grid grid-cols-4 gap-[14px] mt-7">
            @php
                $testimonials = [
                    ['Quantro has transformed the way we manage our inventory and sales across all branches.','غيّر كوانترو طريقة إدارتنا للمخزون والمبيعات في جميع الفروع.','Sarah Johnson','Retail Store','متجر تجزئة','S','#2563EB'],
                    ['The reporting and analytics help us make data-driven decisions every day.','تساعدنا التقارير والتحليلات على اتخاذ قرارات مبنية على البيانات يومياً.','Ahmed Al-Hassan','Wholesale Business','تجارة جملة','A','#00A882'],
                    ['Easy to use, powerful, and the support team is excellent!','سهل الاستخدام وقوي، وفريق الدعم ممتاز!','Maria Garcia','E-Commerce Store','متجر إلكتروني','M','#8B5CF6'],
                    ['All our operations in one platform. Highly recommended!','كل عملياتنا في منصة واحدة. أنصح به بشدة!','David Brown','Manufacturing','التصنيع','D','#E8618C'],
                ];
            @endphp
            @foreach($testimonials as [$quote, $quoteAr, $name, $role, $roleAr, $initial, $bg])
            <article class="l6-testimonial-card p-[19px] flex flex-col gap-3">
                <div style="color:#F5B301;font-size:13px;letter-spacing:2px">★★★★★</div>
                <div class="text-[13px] font-medium flex-1" style="line-height:1.6;color:var(--ink)">
                    <span class="i18n-en">"{{ $quote }}"</span><span class="i18n-ar">"{{ $quoteAr }}"</span>
                </div>
                <div class="flex items-center gap-[10px]">
                    <span class="w-8 h-8 rounded-full inline-flex items-center justify-center font-bold text-xs text-white" style="background:{{ $bg }}">{{ $initial }}</span>
                    <div>
                        <div class="font-bold text-xs" style="color:var(--ink)">{{ $name }}</div>
                        <div class="text-[10.5px]" style="color:var(--ink3)"><span class="i18n-en">{{ $role }}</span><span class="i18n-ar">{{ $roleAr }}</span></div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        <div class="flex items-center justify-center gap-8 mt-9 flex-wrap opacity-75">
            <span class="l6-partner-logo text-base" style="color:#635BFF">stripe</span>
            <span class="font-bold text-base italic" style="color:#00457C">PayPal</span>
            <span class="l6-partner-logo text-base" style="color:var(--ink)">mollie</span>
            <span class="font-bold text-[15px] italic" style="color:#0C2451">▰Razorpay</span>
            <span class="font-bold text-[15px]" style="color:var(--ink)">◈ Shippo</span>
            <span class="font-bold text-base" style="color:#F22F46">twilio</span>
            <span class="text-xs" style="color:var(--ink3)"><span class="i18n-en">and more…</span><span class="i18n-ar">والمزيد…</span></span>
        </div>
    </section>

    {{-- ============ FAQ ============ --}}
    <section id="faq" class="px-5 pt-12 pb-6 max-w-[840px] mx-auto scroll-mt-24">
        <div class="text-center">
            <h2 class="font-display font-extrabold" style="font-size:clamp(1.4rem,2.8vw,1.7rem);letter-spacing:-.7px;color:var(--ink)"><span class="i18n-en">Frequently Asked Questions</span><span class="i18n-ar" style="letter-spacing:0">الأسئلة الشائعة</span></h2>
        </div>
        <div class="flex flex-col gap-[9px] mt-[26px]">
            @php
                $faqs = [
                    ['How does the 14-day free trial work?','كيف تعمل التجربة المجانية لمدة ١٤ يوماً؟','You get full access to every module for 14 days — no credit card required. At the end of the trial, pick a plan or export your data.','تحصل على وصول كامل لجميع الوحدات لمدة ١٤ يوماً — دون بطاقة ائتمان. في نهاية التجربة اختر خطة أو صدّر بياناتك.'],
                    ['Does Quantro fully support Arabic and RTL?','هل يدعم كوانترو العربية والاتجاه من اليمين لليسار بالكامل؟','Yes. Every screen — dashboards, POS, reports, invoices — ships in Arabic and English with complete RTL mirroring, and you can switch languages live.','نعم. كل شاشة — لوحات التحكم ونقاط البيع والتقارير والفواتير — متوفرة بالعربية والإنجليزية مع انعكاس كامل للاتجاه، ويمكنك تبديل اللغة فورياً.'],
                    ['Can I migrate my existing data?','هل يمكنني نقل بياناتي الحالية؟','Yes — import products, customers, suppliers and opening stock from Excel/CSV, and our team assists with migrations from other systems on Growth and Enterprise plans.','نعم — استورد المنتجات والعملاء والموردين والمخزون الافتتاحي من Excel/CSV، ويساعدك فريقنا في الانتقال من الأنظمة الأخرى في خطتي النمو والمؤسسات.'],
                    ['Does the POS work offline?','هل تعمل نقاط البيع دون إنترنت؟','Yes. The POS keeps selling when the connection drops and syncs automatically once you are back online.','نعم. تستمر نقاط البيع في العمل عند انقطاع الاتصال وتتزامن تلقائياً عند عودته.'],
                    ['Can I cancel or change plans anytime?','هل يمكنني الإلغاء أو تغيير الخطة في أي وقت؟','Absolutely. Upgrade, downgrade or cancel from your billing page at any time — no hidden fees, and your data stays exportable.','بالتأكيد. يمكنك الترقية أو التخفيض أو الإلغاء من صفحة الفوترة في أي وقت — دون رسوم خفية وتبقى بياناتك قابلة للتصدير.'],
                ];
            @endphp
            @foreach($faqs as [$q, $qAr, $a, $aAr])
            <div class="l6-faq-item">
                <div class="l6-faq-q">
                    <span class="flex-1"><span class="i18n-en">{{ $q }}</span><span class="i18n-ar">{{ $qAr }}</span></span>
                    <svg class="l6-faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m6 9 6 6 6-6"></path></svg>
                </div>
                <div class="l6-faq-body"><span class="i18n-en">{{ $a }}</span><span class="i18n-ar">{{ $aAr }}</span></div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ============ FINAL CTA ============ --}}
    <section id="cta" class="px-5 pt-12 pb-16 max-w-[1180px] mx-auto scroll-mt-24">
        <div class="l6-cta-banner text-center p-10 md:p-[52px_40px]">
            <div class="relative">
                <img src="{{ $quantroLockup }}" alt="Quantro" class="mx-auto mb-[18px]" style="width:220px">
                <h2 class="font-display font-extrabold text-white" style="font-size:clamp(1.6rem,3.6vw,1.9rem);letter-spacing:-.7px"><span class="i18n-en">One Platform. Every Business.</span><span class="i18n-ar" style="letter-spacing:0">منصة واحدة. لكل الأعمال.</span></h2>
                <p class="mx-auto mt-[14px]" style="color:#A9BCD8;font-size:14px;max-width:440px;line-height:1.6"><span class="i18n-en">Join 10,000+ businesses running their operations on Quantro. Set up in minutes, in English or Arabic.</span><span class="i18n-ar">انضم إلى أكثر من ١٠٬٠٠٠ شركة تدير عملياتها عبر كوانترو. جهّز نظامك خلال دقائق، بالعربية أو الإنجليزية.</span></p>
                <div class="flex justify-center gap-3 mt-[26px] flex-wrap">
                    <a href="{{ route('central.register') }}" class="l6-btn-teal px-7 py-[14px] text-sm"><span class="i18n-en">Start Free Trial</span><span class="i18n-ar">ابدأ التجربة المجانية</span></a>
                    <a href="#" class="l6-btn-ghost-dark px-7 py-[14px] text-sm"><span class="i18n-en">Talk to Sales</span><span class="i18n-ar">تحدث مع المبيعات</span></a>
                </div>
            </div>
        </div>
    </section>
    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="pt-11 pb-6 px-5" style="border-top:1px solid var(--bd);background:var(--card2)">
        <div class="l6-footer-grid max-w-[1180px] mx-auto grid grid-cols-5 gap-7">
            <div class="col-span-5 md:col-span-1">
                <div class="flex items-center gap-[9px]">
                    <img src="{{ $quantroQ }}" alt="Q" class="w-8 h-8">
                    <div class="font-display font-extrabold text-sm" style="letter-spacing:1.2px;color:var(--ink)">QUANTRO</div>
                </div>
                <p class="text-xs mt-3 max-w-[250px]" style="color:var(--ink3);line-height:1.6"><span class="i18n-en">The all-in-one enterprise platform for POS, inventory, e-commerce, HR and accounting.</span><span class="i18n-ar">المنصة المتكاملة لنقاط البيع والمخزون والتجارة الإلكترونية والموارد البشرية والمحاسبة.</span></p>
                <div class="text-xs mt-3" style="color:var(--ink3)">quantrocore.com</div>
            </div>
            <div>
                <div class="font-bold text-xs uppercase tracking-[.8px]" style="color:var(--ink3)"><span class="i18n-en">Product</span><span class="i18n-ar" style="letter-spacing:0">المنتج</span></div>
                <div class="flex flex-col gap-[9px] mt-[13px] text-[12.5px]">
                    <a href="#features" style="color:var(--ink2)"><span class="i18n-en">Features</span><span class="i18n-ar">المميزات</span></a>
                    <a href="#pricing" style="color:var(--ink2)"><span class="i18n-en">Pricing</span><span class="i18n-ar">الأسعار</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">POS</span><span class="i18n-ar">نقاط البيع</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">E-Commerce</span><span class="i18n-ar">التجارة الإلكترونية</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">HRM &amp; Payroll</span><span class="i18n-ar">الموارد البشرية</span></a>
                </div>
            </div>
            <div>
                <div class="font-bold text-xs uppercase tracking-[.8px]" style="color:var(--ink3)"><span class="i18n-en">Company</span><span class="i18n-ar" style="letter-spacing:0">الشركة</span></div>
                <div class="flex flex-col gap-[9px] mt-[13px] text-[12.5px]">
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">About Us</span><span class="i18n-ar">من نحن</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Careers</span><span class="i18n-ar">الوظائف</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Partners</span><span class="i18n-ar">الشركاء</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Contact</span><span class="i18n-ar">اتصل بنا</span></a>
                </div>
            </div>
            <div>
                <div class="font-bold text-xs uppercase tracking-[.8px]" style="color:var(--ink3)"><span class="i18n-en">Resources</span><span class="i18n-ar" style="letter-spacing:0">الموارد</span></div>
                <div class="flex flex-col gap-[9px] mt-[13px] text-[12.5px]">
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Help Center</span><span class="i18n-ar">مركز المساعدة</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Knowledge Base</span><span class="i18n-ar">قاعدة المعرفة</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">API Docs</span><span class="i18n-ar">وثائق API</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">System Status</span><span class="i18n-ar">حالة النظام</span></a>
                </div>
            </div>
            <div>
                <div class="font-bold text-xs uppercase tracking-[.8px]" style="color:var(--ink3)"><span class="i18n-en">Legal</span><span class="i18n-ar" style="letter-spacing:0">قانوني</span></div>
                <div class="flex flex-col gap-[9px] mt-[13px] text-[12.5px]">
                    <a href="{{ route('central.privacy-policy') }}" style="color:var(--ink2)"><span class="i18n-en">Privacy Policy</span><span class="i18n-ar">سياسة الخصوصية</span></a>
                    <a href="{{ route('central.terms-conditions') }}" style="color:var(--ink2)"><span class="i18n-en">Terms &amp; Conditions</span><span class="i18n-ar">الشروط والأحكام</span></a>
                    <a href="#" style="color:var(--ink2)"><span class="i18n-en">Security</span><span class="i18n-ar">الأمان</span></a>
                </div>
            </div>
        </div>
        <div class="max-w-[1180px] mx-auto mt-[30px] pt-[18px] flex items-center gap-3 text-[11.5px] flex-wrap" style="border-top:1px solid var(--bd);color:var(--ink3)">
            <span>© 2026 Quantro. <span class="i18n-en">All rights reserved.</span><span class="i18n-ar">جميع الحقوق محفوظة.</span></span>
            <div class="flex-1"></div>
            <span class="flex items-center gap-[6px]">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3c2.5 2.6 3.8 5.7 3.8 9S14.5 18.4 12 21c-2.5-2.6-3.8-5.7-3.8-9S9.5 5.6 12 3Z"></path></svg>
                <span class="i18n-en">English · العربية</span><span class="i18n-ar">العربية · English</span>
            </span>
        </div>
    </footer>

    <div class="fixed bottom-4 left-4 right-4 max-w-lg mx-auto z-[60] p-4 rounded-2xl l6-card translate-y-[120%] opacity-0 transition-all duration-300 pointer-events-none" id="cookieConsent">
        <h4 class="text-sm font-bold mb-1" style="color:var(--ink)"><span class="i18n-en">We value your privacy</span><span class="i18n-ar">نحن نقدر خصوصيتك</span></h4>
        <p class="text-xs mb-3" style="color:var(--ink2)"><span class="i18n-en">We use cookies to improve your experience. Read our</span><span class="i18n-ar">نستخدم ملفات تعريف الارتباط لتحسين تجربتك. اقرأ</span> <a href="{{ route('central.privacy-policy') }}#cookies" class="font-semibold underline" style="color:var(--ink)"><span class="i18n-en">Privacy Policy</span><span class="i18n-ar">سياسة الخصوصية</span></a></p>
        <div class="flex flex-wrap gap-2">
            <button type="button" class="px-3 py-[6px] rounded-full text-xs font-bold text-white" style="background:var(--ink)" id="cookieAcceptBtn"><span class="i18n-en">Accept All</span><span class="i18n-ar">قبول الكل</span></button>
            <button type="button" class="px-3 py-[6px] rounded-full text-xs font-semibold" style="border:1px solid var(--bd2);color:var(--ink2)" id="cookieRejectBtn"><span class="i18n-en">Reject All</span><span class="i18n-ar">رفض الكل</span></button>
            <button type="button" class="px-3 py-[6px] text-xs font-semibold" style="color:#00A882" id="cookieCustomizeBtn"><span class="i18n-en">Customize</span><span class="i18n-ar">تخصيص</span></button>
        </div>
        <div id="cookieCustomize" class="hidden mt-3 pt-3" style="border-top:1px solid var(--bd)">
            <label class="flex items-center gap-2 text-xs mb-2" style="color:var(--ink2)"><input type="checkbox" id="cookieAnalytics"> <span class="i18n-en">Analytics cookies</span><span class="i18n-ar">ملفات التحليلات</span></label>
            <label class="flex items-center gap-2 text-xs mb-2" style="color:var(--ink2)"><input type="checkbox" id="cookieMarketing"> <span class="i18n-en">Marketing cookies</span><span class="i18n-ar">ملفات التسويق</span></label>
            <button type="button" class="px-3 py-[6px] rounded-full text-xs font-bold text-white" style="background:#00A882" id="cookieSaveBtn"><span class="i18n-en">Save Preferences</span><span class="i18n-ar">حفظ التفضيلات</span></button>
        </div>
    </div>

    <script src="{{ asset('assets_super/js/landing-six.js') }}"></script>
</body>
</html>
