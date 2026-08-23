<!DOCTYPE html>
@php
    $isRtl = in_array(app()->getLocale(), ['ar', 'he', 'fa', 'ur']);
    $generalSettings = \App\Models\Central\GeneralSetting::instance();
    $appName = $generalSettings->app_name ?: 'Quantro';
    $logoUrl = $generalSettings->getLogoUrl();
    $curLocale = $currentLocale ?? app()->getLocale();
    // Accent palette rotation for icon tiles.
    $q7Colors = ['c-blue', 'c-teal', 'c-orange', 'c-purple', 'c-cyan', 'c-pink'];
    $q7Trans = fn ($key, $fallback) => trans()->has($key) ? __($key) : $fallback;
@endphp
<html lang="{{ app()->getLocale() }}" @if($isRtl) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if($seo)
        <title>{{ $seo->meta_title ?? $appName }}</title>
        <meta name="description" content="{{ $seo->meta_description ?? '' }}">
        @if($seo->meta_keywords)<meta name="keywords" content="{{ $seo->meta_keywords }}">@endif
        <meta property="og:title" content="{{ $seo->meta_title ?? $appName }}">
        <meta property="og:description" content="{{ $seo->meta_description ?? '' }}">
        @if($seo->og_image)<meta property="og:image" content="{{ asset($seo->og_image) }}">@endif
        @if($seo->favicon)<link rel="icon" href="{{ asset($seo->favicon) }}">@endif
    @else
        <title>{{ $appName }}</title>
        <link rel="icon" href="{{ asset('images/super/settings/favicon.ico') }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets_super/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets_super/css/landing-seven.css') }}" rel="stylesheet">
    @include('central.partials.landing-font')
</head>
<body>
<div class="landing-v7" @if($isRtl) dir="rtl" @endif>

    {{-- ── Navbar ─────────────────────────────────────────── --}}
    <nav class="q7-nav">
        <a class="q7-brand" href="{{ route('central.welcome') }}">
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $appName }}">
            @else
                <span class="q7-brand-mark">{{ strtoupper(substr($appName, 0, 1)) }}</span>
            @endif
            <span>
                @if($generalSettings->show_site_name ?? true)
                    <span class="q7-brand-name d-block">{{ strtoupper($appName) }}</span>
                @endif
                <span class="q7-brand-sub">{{ $q7Trans('landing.enterprise_platform', 'ENTERPRISE PLATFORM') }}</span>
            </span>
        </a>

        <div class="q7-nav-spacer"></div>

        <div class="q7-nav-links" id="q7NavLinks">
            @if(!empty($features['is_active']))
                <a href="#features">{{ __('landing.features') }}</a>
            @endif
            <a href="#industries">{{ $q7Trans('landing.industries', 'Industries') }}</a>
            @if(!empty($pricing['is_active']))
                <a href="#pricing">{{ __('landing.pricing') }}</a>
            @endif
            @if(!empty($testimonials))
                <a href="#testimonials">{{ __('landing.testimonials') }}</a>
            @endif
            @if(!empty($faqs))
                <a href="#faq">{{ __('landing.faq') }}</a>
            @endif
        </div>

        @if(isset($languages) && $languages->count() > 1)
        <div class="q7-lang">
            @foreach($languages as $lang)
            <form method="POST" action="{{ route('central.locale', $lang->locale) }}">
                @csrf
                <button type="submit" class="{{ $curLocale === $lang->locale ? 'is-active' : '' }}">{{ strtoupper($lang->locale) }}</button>
            </form>
            @endforeach
        </div>
        @endif

        <button type="button" class="q7-theme" id="q7ThemeToggle" aria-label="Toggle theme">
            <svg class="icon-moon" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20.5 14.5A8.5 8.5 0 0 1 9.5 3.5a8.5 8.5 0 1 0 11 11Z"></path></svg>
            <svg class="icon-sun" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4.2"></circle><path d="M12 2.5v2.4M12 19.1v2.4M2.5 12h2.4M19.1 12h2.4M5 5l1.7 1.7M17.3 17.3 19 19M19 5l-1.7 1.7M6.7 17.3 5 19"></path></svg>
        </button>

        @if($footer->show_admin_login ?? false)
            <a class="q7-login" href="{{ route('central.login') }}">{{ __('landing.admin_login') }}</a>
        @endif
        <a class="q7-btn-primary" href="{{ route('central.register') }}">{{ __('landing.sign_up_free') }}</a>
    </nav>

    {{-- ── Hero ───────────────────────────────────────────── --}}
    @if($hero)
    @php
        // Rotating hero slides — image + headline (with gradient part) + subtitle.
        // Bilingual; the correct language is emitted per current locale.
        $q7Slides = [
            [
                'img'  => 'images/super/landing-design/quantro/hero-slide-1.png',
                'pre'  => ['en' => 'Run Your Entire Business from', 'ar' => 'شغّل أعمالك بالكامل من خلال'],
                'grad' => ['en' => 'One Intelligent Platform', 'ar' => 'منصة ذكية واحدة'],
                'sub'  => ['en' => 'Quantro connects your operations, teams, sales, customers, and insights in one powerful business ecosystem.', 'ar' => 'يربط كوانترو بين العمليات والمبيعات والفرق والعملاء والتحليلات ضمن نظام أعمال موحد واحترافي.'],
            ],
            [
                'img'  => 'images/super/landing-design/quantro/hero-slide-2.png',
                'pre'  => ['en' => 'Sell Faster with', 'ar' => 'بِع بشكل أسرع مع'],
                'grad' => ['en' => 'Smart POS', 'ar' => 'نظام نقاط بيع ذكي'],
                'sub'  => ['en' => 'Empower your retail operations with fast checkout, barcode scanning, payment flexibility, and complete point-of-sale control.', 'ar' => 'طوّر تجربة البيع لديك عبر الدفع السريع، ومسح الباركود، ومرونة وسائل الدفع، وتحكم كامل بنقطة البيع.'],
            ],
            [
                'img'  => 'images/super/landing-design/quantro/hero-slide-3.png',
                'pre'  => ['en' => 'Launch Your Store.', 'ar' => 'أطلق متجرك.'],
                'grad' => ['en' => 'Grow Everywhere.', 'ar' => 'ووسّع انتشارك في كل مكان.'],
                'sub'  => ['en' => 'Manage products, orders, promotions, and online selling across multiple channels from one seamless commerce experience.', 'ar' => 'قم بإدارة المنتجات والطلبات والعروض والبيع الإلكتروني عبر قنوات متعددة من خلال تجربة تجارة متكاملة.'],
            ],
            [
                'img'  => 'images/super/landing-design/quantro/hero-slide-4.png',
                'pre'  => ['en' => 'Master Inventory Across', 'ar' => 'تحكّم بالمخزون عبر'],
                'grad' => ['en' => 'Every Warehouse', 'ar' => 'جميع المستودعات'],
                'sub'  => ['en' => 'Track stock, monitor low inventory, manage transfers, and gain real-time visibility across all warehouse operations.', 'ar' => 'تابع المخزون، وراقب النواقص، وأدر عمليات النقل، واحصل على رؤية لحظية وشاملة لكل عمليات المستودعات.'],
            ],
            [
                'img'  => 'images/super/landing-design/quantro/hero-slide-5.png',
                'pre'  => ['en' => 'Manage People, Operations,', 'ar' => 'أدر الموظفين والعمليات'],
                'grad' => ['en' => 'and Growth', 'ar' => 'والنمو بكفاءة'],
                'sub'  => ['en' => 'Streamline employees, workflows, reporting, and operational planning with a connected management experience.', 'ar' => 'نظّم شؤون الموظفين وسير العمل والتقارير والتخطيط التشغيلي من خلال تجربة إدارية مترابطة واحترافية.'],
            ],
        ];
        $q7Lang = $isRtl ? 'ar' : 'en';
        // JS payload: text swapped in sync with the image.
        $q7SlideJs = collect($q7Slides)->map(fn ($s) => [
            'pre'  => $s['pre'][$q7Lang],
            'grad' => $s['grad'][$q7Lang],
            'sub'  => $s['sub'][$q7Lang],
        ])->values();
    @endphp
    <section class="q7-hero" id="hero">
        {{-- Full-hero background image slider --}}
        <div class="q7-hero__visual">
            <div class="q7-hero__slider" id="q7HeroSlider" data-interval="6000" data-slides='@json($q7SlideJs)'>
                <div class="q7-hero__track">
                    @foreach($q7Slides as $i => $slide)
                        <img src="{{ asset($slide['img']) }}" alt="{{ $slide['pre'][$q7Lang] }} {{ $slide['grad'][$q7Lang] }}"
                             class="q7-hero__slide {{ $i === 0 ? 'is-active' : '' }}"
                             loading="{{ $i === 0 ? 'eager' : 'lazy' }}" decoding="async">
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Readability scrim over the copy side --}}
        <div class="q7-hero__scrim" aria-hidden="true"></div>
        <div class="q7-hero__inner">
            <div>
                <h1 class="q7-hero__title">
                    <span id="q7HeroPre">{{ $q7Slides[0]['pre'][$q7Lang] }}</span>
                    <span class="grad" id="q7HeroGrad">{{ $q7Slides[0]['grad'][$q7Lang] }}</span>
                </h1>
                <p class="q7-hero__lead" id="q7HeroSub">{{ $q7Slides[0]['sub'][$q7Lang] }}</p>
                <div class="q7-hero__actions">
                    @if($hero->primary_button_text)
                        <a href="{{ $hero->primary_button_url ?? route('central.register') }}" class="q7-cta-lg solid">
                            {{ $hero->primary_button_text }}
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                        </a>
                    @endif
                    @if($hero->secondary_button_text)
                        <a href="{{ $hero->secondary_button_url ?? route('central.register') }}" class="q7-cta-lg ghost">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M8 5.5v13l11-6.5-11-6.5Z"></path></svg>
                            {{ $hero->secondary_button_text }}
                        </a>
                    @endif
                </div>
                <div class="q7-hero__trust">
                    <span><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>{{ $q7Trans('landing.no_credit_card', 'No credit card required') }}</span>
                    <span><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3.5 2"></path></svg>{{ $q7Trans('landing.trial_14_day', '14-day free trial') }}</span>
                    <span><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 3 4 7v5c0 4.5 3.2 7.9 8 9 4.8-1.1 8-4.5 8-9V7l-8-4Z"></path></svg>{{ $q7Trans('landing.bilingual_builtin', 'Arabic & English built-in') }}</span>
                </div>
            </div>
        </div>
        <div class="q7-hero__nav">
            <button type="button" class="q7-hero__arrow" data-dir="prev" aria-label="Previous">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="m15 6-6 6 6 6"></path></svg>
            </button>
            <div class="q7-hero__dots">
                @foreach($q7Slides as $i => $slide)
                    <button type="button" class="q7-hero__dot {{ $i === 0 ? 'is-active' : '' }}" data-slide="{{ $i }}" aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
            <button type="button" class="q7-hero__arrow" data-dir="next" aria-label="Next">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="m9 6 6 6-6 6"></path></svg>
            </button>
        </div>
        @if(session('success') && session('tenant_url'))
            <div class="q7-container" style="padding:0 5% 20px">
                <div class="alert alert-success text-center">
                    {{ session('message') }}<br>
                    <a href="{{ session('tenant_url') }}">{{ session('tenant_url') }}</a>
                </div>
            </div>
        @endif
    </section>
    @endif

    {{-- ── Stats bar ──────────────────────────────────────── --}}
    @if(!empty($stats) && $stats->isNotEmpty())
    <div class="q7-stats-wrap">
        <div class="q7-stats">
            @foreach($stats as $stat)
            <div class="q7-stat">
                <div class="q7-stat__value">{!! $stat->value !!}</div>
                <div class="q7-stat__label">{{ $stat->label }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Features ───────────────────────────────────────── --}}
    @if(!empty($features['is_active']) && $features['items']->isNotEmpty())
    <section class="q7-section q7-section--features" id="features">
        <div class="q7-head">
            <p class="q7-eyebrow">{{ __('landing.features') }}</p>
            @if($features['section'])
                <h2>{{ $features['section']->section_title }}</h2>
                <p>{{ $features['section']->section_subtitle }}</p>
            @endif
        </div>
        <div class="q7-features-grid">
            @foreach($features['items'] as $i => $feature)
            <div class="q7-feature">
                <span class="q7-icon {{ $q7Colors[$i % count($q7Colors)] }}">
                    @if($feature->image)
                        <img src="{{ asset($feature->image) }}" alt="" style="width:20px;height:20px;object-fit:contain">
                    @else
                        <i class="{{ $feature->icon ?: 'bi bi-star' }}" style="font-size:17px"></i>
                    @endif
                </span>
                <div class="q7-feature__title">{{ $feature->title }}</div>
                @if($feature->description)
                    <div class="q7-feature__desc">{{ $feature->description }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── Fair / How-it-works band ───────────────────────── --}}
    <div class="q7-band-wrap">
        <div class="q7-band">
            <div class="q7-band__blob a"></div>
            <div class="q7-band__blob b"></div>
            <div class="q7-band__body">
                <h3 class="q7-band__title">{{ $q7Trans('landing.transparent_fair', 'Transparent & Fair for Every Customer') }}</h3>
                <div class="q7-band__points">
                    @foreach([
                        $q7Trans('landing.fair_no_hidden', 'No hidden fees'),
                        $q7Trans('landing.fair_cancel', 'Cancel anytime'),
                        $q7Trans('landing.fair_secure', 'Secure & reliable'),
                        $q7Trans('landing.fair_updates', 'Regular updates'),
                        $q7Trans('landing.fair_support', 'Dedicated support'),
                        $q7Trans('landing.fair_data', 'Your data is yours'),
                    ] as $point)
                    <div class="q7-band__point">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                        <span>{{ $point }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="q7-band__card">
                <div class="q7-band__eyebrow">{{ __('landing.how_it_works') }}</div>
                <div class="q7-band__lead">{{ $q7Trans('landing.start_trial_line', 'Start your 14-day free trial. No credit card required.') }}</div>
                <a href="#pricing" class="q7-band__btn">
                    {{ $q7Trans('landing.get_started_now', 'Get Started Now') }}
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14m-6-6 6 6-6 6"></path></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- ── Industries ─────────────────────────────────────── --}}
    <section class="q7-section" id="industries">
        <div class="q7-head q7-head--sm">
            <p class="q7-eyebrow">{{ $q7Trans('landing.industries', 'Industries') }}</p>
            <h2>{{ $q7Trans('landing.built_for_business', 'Built for the Way You Do Business') }}</h2>
        </div>
        <div class="q7-industries-grid">
            @foreach([
                ['icon' => 'bi-shop', 'label' => $q7Trans('landing.retail', 'Retail'), 'c' => 'c-blue'],
                ['icon' => 'bi-cup-hot', 'label' => $q7Trans('landing.restaurants', 'Restaurants'), 'c' => 'c-teal'],
                ['icon' => 'bi-box-seam', 'label' => $q7Trans('landing.wholesale', 'Wholesale'), 'c' => 'c-orange'],
                ['icon' => 'bi-buildings', 'label' => $q7Trans('landing.manufacturing', 'Manufacturing'), 'c' => 'c-purple'],
                ['icon' => 'bi-tools', 'label' => $q7Trans('landing.services', 'Services'), 'c' => 'c-cyan'],
                ['icon' => 'bi-cart3', 'label' => $q7Trans('landing.ecommerce', 'E-Commerce'), 'c' => 'c-pink'],
            ] as $ind)
            <div class="q7-industry">
                <span class="q7-icon {{ $ind['c'] }}"><i class="bi {{ $ind['icon'] }}" style="font-size:17px"></i></span>
                <div class="q7-industry__title">{{ $ind['label'] }}</div>
            </div>
            @endforeach
        </div>
    </section>

    {{-- ── Pricing ────────────────────────────────────────── --}}
    @if(!empty($pricing['is_active']) && !empty($pricing['plans']))
    <section class="q7-section" id="pricing">
        <div class="q7-head q7-head--sm">
            <p class="q7-eyebrow">{{ __('landing.pricing') }}</p>
            @if($pricing['settings'])
                <h2>{{ $pricing['settings']->section_title }}</h2>
            @endif
            @php $anyYearly = collect($pricing['plans'])->contains(fn ($p) => ($p->yearly_price ?? 0) > 0); @endphp
            @if($anyYearly)
            <div class="q7-billing-toggle">
                <button type="button" id="q7Monthly" class="is-active">{{ $q7Trans('landing.monthly', 'Monthly') }}</button>
                <button type="button" id="q7Yearly">{{ $q7Trans('landing.yearly_save', 'Yearly · save 20%') }}</button>
            </div>
            @endif
        </div>
        <div class="q7-pricing-grid">
            @foreach($pricing['plans'] as $i => $plan)
            @php
                $isPop = $i === 1 && count($pricing['plans']) > 1;
                $fmt = fn ($n) => $n == floor($n) ? number_format($n, 0) : number_format($n, 2);
                $isCustom = $plan->price == 0 && ($plan->yearly_price ?? 0) == 0 && ! $plan->isFree();
                $monthlyLabel = $plan->isFree() ? __('landing.free') : $currencySymbol . $fmt($plan->price);
                $yearlyLabel = ($plan->yearly_price ?? 0) > 0 ? $currencySymbol . $fmt($plan->yearly_price) : $monthlyLabel;
                $limits = $plan->limits ?? [];
                $planFeatures = $plan->features ?? [];
            @endphp
            <div class="q7-plan {{ $isPop ? 'q7-plan--pop' : '' }}">
                @if($isPop)<div class="q7-plan__flag">{{ __('landing.most_popular') }}</div>@endif
                <div class="q7-plan__name">{{ $plan->name }}</div>
                <div class="q7-plan__tagline">{{ $plan->isFree() ? ($q7Trans('landing.perfect_to_start', 'Perfect to get started')) : ($q7Trans('landing.for_growing_teams', 'For growing teams')) }}</div>
                <div class="q7-plan__price-row">
                    @if($plan->isFree())
                        <span class="q7-plan__price">{{ __('landing.free') }}</span>
                    @else
                        <span class="q7-plan__price" data-price-monthly="{{ $monthlyLabel }}" data-price-yearly="{{ $yearlyLabel }}">{{ $monthlyLabel }}</span>
                        <span class="q7-plan__per" data-per-monthly="/ {{ __('landing.mo') }}" data-per-yearly="/ {{ __('landing.yr') }}">/ {{ __('landing.mo') }}</span>
                    @endif
                </div>
                <a href="{{ route('central.register', ['plan' => $plan->id]) }}" class="q7-plan__btn {{ $isPop ? 'solid' : 'outline' }}">
                    {{ $plan->isFree() ? __('landing.get_started') : ($plan->hasTrial() ? __('landing.start_free_trial') : __('landing.choose_plan')) }}
                </a>
                <ul class="q7-plan__feats">
                    @foreach($limits as $key => $value)
                        @php $meta = \App\Models\Central\Plan::AVAILABLE_LIMITS[$key] ?? null; @endphp
                        @if($meta)
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                            <span>{{ $value == -1 ? __('landing.unlimited') : $value }} {{ $meta['label'] }}</span>
                        </li>
                        @endif
                    @endforeach
                    @foreach($planFeatures as $fKey)
                        @php $fMeta = \App\Models\Central\Plan::AVAILABLE_FEATURES[$fKey] ?? null; @endphp
                        @if($fMeta)
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m4.5 12.5 5 5 10-11"></path></svg>
                            <span>{{ $fMeta['label'] }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── Testimonials ───────────────────────────────────── --}}
    @if(!empty($testimonials))
    <section class="q7-section" id="testimonials">
        <div class="q7-head q7-head--sm">
            <h2>{{ $q7Trans('landing.loved_by_businesses', 'Loved by Businesses Worldwide') }}</h2>
        </div>
        <div class="q7-tst-grid">
            @php $tstBg = ['#2563EB', '#00A882', '#8B5CF6', '#E8618C', '#0EA5C9', '#E88A00']; @endphp
            @foreach($testimonials as $i => $t)
            <div class="q7-tst">
                <div class="q7-tst__stars">
                    @for($s = 1; $s <= 5; $s++){{ $s <= ($t->rating ?? 5) ? '★' : '☆' }}@endfor
                </div>
                <div class="q7-tst__quote">“{{ $t->review }}”</div>
                <div class="q7-tst__author">
                    <span class="q7-tst__avatar" style="background:{{ $tstBg[$i % count($tstBg)] }}">
                        @if($t->avatar)
                            <img src="{{ asset($t->avatar) }}" alt="">
                        @else
                            {{ strtoupper(mb_substr($t->client_name, 0, 1)) }}
                        @endif
                    </span>
                    <div>
                        <div class="q7-tst__name">{{ $t->client_name }}</div>
                        @if($t->company_name)<div class="q7-tst__role">{{ $t->company_name }}</div>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── FAQ ────────────────────────────────────────────── --}}
    @if(!empty($faqs))
    <section class="q7-section q7-section--faq" id="faq">
        <div class="q7-head q7-head--sm">
            <h2>{{ $q7Trans('landing.faq_title', 'Frequently Asked Questions') }}</h2>
        </div>
        <div class="q7-faq-list">
            @foreach($faqs as $i => $faq)
            <details class="q7-faq" {{ $i === 0 ? 'open' : '' }}>
                <summary>
                    <span class="q7-faq__q">{{ $faq->question }}</span>
                    <svg class="q7-faq__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="m6 9 6 6 6-6"></path></svg>
                </summary>
                <div class="q7-faq__a">{!! nl2br(e($faq->answer)) !!}</div>
            </details>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── Final CTA ──────────────────────────────────────── --}}
    @if($cta)
    <div class="q7-cta-wrap" id="cta">
        <div class="q7-cta">
            <div class="q7-cta__blob a"></div>
            <div class="q7-cta__blob b"></div>
            <div class="q7-cta__body">
<img src="{{ asset('images/super/landing-design/quantro/quantro-lockup.png') }}" alt="{{ $appName }}" class="q7-cta__logo">
                <h2 class="q7-cta__title">{{ $cta->title }}</h2>
                @if($cta->subtitle)<p class="q7-cta__lead">{{ $cta->subtitle }}</p>@endif
                <div class="q7-cta__actions">
                    @if($cta->button_text)
                        <a href="{{ $cta->button_url ?? route('central.register') }}" class="q7-cta__btn teal">{{ $cta->button_text }}</a>
                    @endif
                    <a href="{{ route('central.register') }}" class="q7-cta__btn glass">{{ $q7Trans('landing.talk_to_sales', 'Talk to Sales') }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Footer ─────────────────────────────────────────── --}}
    <footer class="q7-footer">
        <div class="q7-footer__grid">
            <div>
                <a class="q7-footer__brand" href="{{ route('central.welcome') }}">
                    @if($logoUrl)<img src="{{ $logoUrl }}" alt="{{ $appName }}">@else<span class="q7-brand-mark">{{ strtoupper(substr($appName, 0, 1)) }}</span>@endif
                    <span>{{ strtoupper($appName) }}</span>
                </a>
                @if($footer && $footer->footer_about)
                    <p class="q7-footer__about">{{ $footer->footer_about }}</p>
                @endif
                @if($footer && $footer->contact_email)
                    <div class="q7-footer__site">{{ $footer->contact_email }}</div>
                @endif
            </div>
            <div>
                <div class="q7-footer__col-title">{{ $q7Trans('landing.product', 'Product') }}</div>
                <div class="q7-footer__links">
                    <a href="#features">{{ __('landing.features') }}</a>
                    <a href="#pricing">{{ __('landing.pricing') }}</a>
                    <a href="#industries">{{ $q7Trans('landing.industries', 'Industries') }}</a>
                    <a href="{{ route('central.register') }}">{{ __('landing.sign_up') }}</a>
                </div>
            </div>
            <div>
                <div class="q7-footer__col-title">{{ $q7Trans('landing.company', 'Company') }}</div>
                <div class="q7-footer__links">
                    <a href="#testimonials">{{ __('landing.testimonials') }}</a>
                    <a href="#faq">{{ __('landing.faq') }}</a>
                    @if($footer && $footer->contact_phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $footer->contact_phone) }}">{{ $footer->contact_phone }}</a>@endif
                </div>
            </div>
            <div>
                <div class="q7-footer__col-title">{{ $q7Trans('landing.resources', 'Resources') }}</div>
                <div class="q7-footer__links">
                    <a href="{{ route('central.privacy-policy') }}">{{ __('landing.privacy_policy') }}</a>
                    <a href="{{ route('central.terms-conditions') }}">{{ __('landing.terms_and_conditions') }}</a>
                    @if($footer->show_admin_login ?? false)<a href="{{ route('central.login') }}">{{ __('landing.admin_login') }}</a>@endif
                </div>
            </div>
            <div>
                <div class="q7-footer__col-title">{{ $q7Trans('landing.legal', 'Legal') }}</div>
                <div class="q7-footer__links">
                    <a href="{{ route('central.privacy-policy') }}">{{ __('landing.privacy_policy') }}</a>
                    <a href="{{ route('central.terms-conditions') }}">{{ __('landing.terms_and_conditions') }}</a>
                </div>
            </div>
        </div>
        <div class="q7-footer__bottom">
            <span>{{ $footer->copyright_text ?? '© ' . date('Y') . ' ' . $appName . '. ' . __('landing.all_rights_reserved') }}</span>
            <div class="q7-footer__bottom-spacer"></div>
            @if(isset($languages) && $languages->count() > 1)
            <span class="q7-footer__langs">
                <i class="bi bi-globe2"></i>
                @foreach($languages as $lang)
                    <form method="POST" action="{{ route('central.locale', $lang->locale) }}"><button type="submit" class="{{ $curLocale === $lang->locale ? 'is-active' : '' }}">{{ $lang->name }}</button></form>@if(!$loop->last)<span>·</span>@endif
                @endforeach
            </span>
            @endif
        </div>
    </footer>

    {{-- ── Cookie consent ─────────────────────────────────── --}}
    <div class="q7-cookie" id="q7Cookie">
        <h4>{{ __('landing.cookie_banner_title') }}</h4>
        <p>
            {{ __('landing.cookie_banner_text') }}
            <a href="{{ route('central.privacy-policy') }}#cookies">{{ __('landing.privacy_policy') }}</a>
        </p>
        <div class="q7-cookie__actions">
            <button type="button" class="q7-cookie__btn accept" id="q7CookieAccept">{{ __('landing.cookie_accept_all') }}</button>
            <button type="button" class="q7-cookie__btn reject" id="q7CookieReject">{{ __('landing.cookie_reject_all') }}</button>
        </div>
    </div>

</div>
<script src="{{ asset('assets_super/js/landing-seven.js') }}"></script>
</body>
</html>
