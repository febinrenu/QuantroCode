@extends('store.themes.verde._shell')

@section('title', 'Verde Living | Live Beautifully. Choose Consciously.')
@section('meta_description', 'Thoughtfully curated products for a cleaner home, a calmer mind, and a brighter planet. Sustainable lifestyle and organic home decor.')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';

    // $banners/$blocks/$offer/$bannerGridEnabled are fed by the controller but
    // this theme didn't previously reference $banners -- wire up the same
    // Banners-admin plumbing every other theme uses (image/badge/subtitle/
    // button/colors), matching the freshcart reference implementation.
    $byPos = collect($banners ?? [])->groupBy('position');
    $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
    $bannerOverlayStyle = function ($b) {
        if (!$b || empty($b->bg_color)) return null;
        $css = !empty($b->bg_color_2)
            ? "background:linear-gradient(135deg, {$b->bg_color}, {$b->bg_color_2});"
            : "background:{$b->bg_color};";
        return $css;
    };
    $bannerTextStyle = function ($b) {
        return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
    };

    // Merchant-tagged "Best Sellers" collection (if any) takes priority over the
    // generic catalog listing used below, so a role assignment always wins.
    $verdeBestSellersProducts = collect(($collectionsByRole['best_sellers']['products'] ?? []))->values();
@endphp

@section('content')
<div class="space-y-16 sm:space-y-20 pb-20">

    <!-- 1. Hero Section (auto-rotating carousel; add slides via Store Settings > Hero Slides) -->
    @php $vdHeroSlides = $heroSlides ?? []; @endphp
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-10">
        <div class="relative bg-white rounded-3xl p-6 sm:p-10 lg:p-14 border border-verde-borderLight shadow-sm grid"
             x-data="{ vdHero: 0, vdHeroCount: {{ count($vdHeroSlides) }} }"
             @if(count($vdHeroSlides) > 1) x-init="setInterval(() => { vdHero = (vdHero + 1) % vdHeroCount }, 6000)" @endif>
        @foreach($vdHeroSlides as $vdI => $vdSlide)
            <div x-show="vdHero === {{ $vdI }}" @if(!$loop->first) x-cloak @endif
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="col-start-1 row-start-1 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

            <!-- Left Editorial Text Content -->
            <div class="lg:col-span-6 flex flex-col justify-center space-y-6 sm:space-y-8 pr-0 lg:pr-6">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-verde-btn">
                    <span>🌿</span>
                    <span>Natural by Nature</span>
                </div>

                <!-- Headline -->
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-verde-dark font-medium leading-[1.15] tracking-tight">
                    @if(!empty($vdSlide['title']))
                        {{ $vdSlide['title'] }}
                    @else
                        Live Beautifully.<br>
                        <span class="italic font-normal">Choose Consciously.</span>
                    @endif
                </h1>

                <!-- Supporting Copy -->
                <p class="text-stone-600 text-base sm:text-lg leading-relaxed max-w-lg font-light">
                    {{ ($vdSlide['subtitle'] ?? '') !== '' ? $vdSlide['subtitle'] : 'Thoughtfully curated products for a cleaner home, a calmer mind, and a brighter planet.' }}
                </p>

                <!-- CTA Button -->
                <div class="pt-2">
                    <a href="{{ ($vdSlide['cta_link'] ?? '') !== '' ? $vdSlide['cta_link'] : url('/online_store/shop' . $previewParam) }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-verde-btn hover:bg-verde-btnHover text-white font-bold text-xs uppercase tracking-[0.18em] rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        {{ ($vdSlide['cta_text'] ?? '') !== '' ? $vdSlide['cta_text'] : 'Shop the Collection' }}
                    </a>
                </div>

                <!-- Carousel Indicators -->
                @if(count($vdHeroSlides) > 1)
                    <div class="flex items-center gap-2 pt-6">
                        @foreach($vdHeroSlides as $vdDotI => $vdDotSlide)
                            <button type="button" @click="vdHero = {{ $vdDotI }}" class="h-2 rounded-full transition-all"
                                    :class="vdHero === {{ $vdDotI }} ? 'w-6 bg-verde-dark' : 'w-2 bg-stone-300 hover:bg-stone-400'"
                                    aria-label="Slide {{ $vdDotI + 1 }}"></button>
                        @endforeach
                    </div>
                @else
                    <div class="flex items-center gap-2 pt-6">
                        <span class="w-6 h-2 rounded-full bg-verde-dark transition-all"></span>
                        <span class="w-2 h-2 rounded-full bg-stone-300 hover:bg-stone-400 cursor-pointer transition-all"></span>
                        <span class="w-2 h-2 rounded-full bg-stone-300 hover:bg-stone-400 cursor-pointer transition-all"></span>
                    </div>
                @endif
            </div>

            <!-- Right Hero Photography with Overlaid Badge -->
            <div class="lg:col-span-6 relative">
                <div class="relative w-full aspect-[4/3] sm:aspect-[16/11] rounded-2xl overflow-hidden shadow-lg bg-verde-sand">
                    <img src="{{ !empty($vdSlide['image_url']) ? $vdSlide['image_url'] : '/images/themes/verde/verde-hero-lifestyle.jpg' }}"
                         alt="Verde Living Natural Lifestyle Interior"
                         class="w-full h-full object-cover object-center transform hover:scale-102 transition-transform duration-700">

                    <!-- Circular Eco Badge Overlay (Top Right) -->
                    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-[#4E5F3D]/95 text-white backdrop-blur-xs flex flex-col items-center justify-center text-center p-2 shadow-xl border border-white/20">
                        <div class="w-full h-full rounded-full border border-dashed border-white/40 flex flex-col items-center justify-center">
                            <span class="text-[0.6rem] sm:text-[0.68rem] font-bold uppercase tracking-widest leading-tight">ECO<br>FRIENDLY<br>PRODUCTS</span>
                            <span class="text-xs sm:text-sm mt-0.5">🌿</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
        </div>
    </section>

    <!-- 2. Five Trust & Benefit Items -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 lg:gap-8 py-8 px-6 bg-white/70 rounded-2xl border border-verde-borderLight">
            
            <!-- Benefit 1: Planet Friendly -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3.5">
                <div class="w-10 h-10 rounded-full bg-verde-sand flex items-center justify-center flex-shrink-0 text-verde-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-verde-dark uppercase tracking-wider">Planet Friendly</h4>
                    <p class="text-xs text-stone-500 mt-0.5">Sustainable Materials</p>
                </div>
            </div>

            <!-- Benefit 2: Cruelty Free -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3.5">
                <div class="w-10 h-10 rounded-full bg-verde-sand flex items-center justify-center flex-shrink-0 text-verde-primary">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2C8 2 6 4 6 7c0 2 1 3 2 4l-1 4c-1 3 0 5 3 5h4c3 0 4-2 3-5l-1-4c1-1 2-2 2-4 0-3-2-5-6-5z"/>
                        <circle cx="9.5" cy="6.5" r="1" fill="currentColor"/>
                        <circle cx="14.5" cy="6.5" r="1" fill="currentColor"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-verde-dark uppercase tracking-wider">Cruelty Free</h4>
                    <p class="text-xs text-stone-500 mt-0.5">Never Tested on Animals</p>
                </div>
            </div>

            <!-- Benefit 3: Secure Payments -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3.5">
                <div class="w-10 h-10 rounded-full bg-verde-sand flex items-center justify-center flex-shrink-0 text-verde-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-verde-dark uppercase tracking-wider">Secure Payments</h4>
                    <p class="text-xs text-stone-500 mt-0.5">256-bit SSL Encrypted</p>
                </div>
            </div>

            <!-- Benefit 4: Easy Returns -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3.5">
                <div class="w-10 h-10 rounded-full bg-verde-sand flex items-center justify-center flex-shrink-0 text-verde-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-verde-dark uppercase tracking-wider">Easy Returns</h4>
                    <p class="text-xs text-stone-500 mt-0.5">30-Day Return Policy</p>
                </div>
            </div>

            <!-- Benefit 5: Customer Support -->
            <div class="col-span-2 md:col-span-1 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-3.5">
                <div class="w-10 h-10 rounded-full bg-verde-sand flex items-center justify-center flex-shrink-0 text-verde-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-verde-dark uppercase tracking-wider">Customer Support</h4>
                    <p class="text-xs text-stone-500 mt-0.5">We're Here to Help</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. Five Category Cards (fully customizable via Banners: image, badge, headline, subtitle, button, colors) -->
    @if($bannerGridEnabled ?? true)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $verdeCategoryTiles = [
                ['pos' => 'top_right', 'title' => 'Home & Decor', 'img' => 'cat-home-decor.jpg', 'href' => url('/online_store/shop?category=home-decor' . $previewAmp)],
                ['pos' => 'center_left', 'title' => 'Cleaning Essentials', 'img' => 'cat-cleaning-essentials.jpg', 'href' => url('/online_store/shop?category=cleaning-essentials' . $previewAmp)],
                ['pos' => 'center_right', 'title' => 'Bath & Body', 'img' => 'cat-bath-body.jpg', 'href' => url('/online_store/shop?category=bath-body' . $previewAmp)],
                ['pos' => 'footer_left', 'title' => 'Kitchen & Dining', 'img' => 'cat-kitchen-dining.jpg', 'href' => url('/online_store/shop?category=kitchen-dining' . $previewAmp)],
                ['pos' => 'footer_right', 'title' => 'Gifts & Sets', 'img' => 'cat-gifts-sets.jpg', 'href' => url('/online_store/shop?category=gifts-sets' . $previewAmp)],
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 sm:gap-6">

            @foreach($verdeCategoryTiles as $tile)
                @php $verdeTileBanner = ($byPos[$tile['pos']] ?? collect())->first(); @endphp
                <a href="{{ $verdeTileBanner ? ($verdeTileBanner->link ?: $tile['href']) : $tile['href'] }}"
                   class="group relative bg-[#F3EFEA] rounded-2xl p-5 border border-verde-borderLight hover:border-verde-border transition-all duration-300 hover:shadow-md flex flex-col justify-between"
                   @if($bannerOverlayStyle($verdeTileBanner)) style="{{ $bannerOverlayStyle($verdeTileBanner) }}" @endif>
                    <div @if($bannerTextStyle($verdeTileBanner)) style="{{ $bannerTextStyle($verdeTileBanner) }}" @endif>
                        <h3 class="text-xs font-bold text-verde-dark uppercase tracking-widest" @if($bannerTextStyle($verdeTileBanner)) style="color:inherit;" @endif>{{ ($verdeTileBanner->title ?? null) ?: $tile['title'] }}</h3>
                        @if(!empty($verdeTileBanner->subtitle ?? null))
                            <p class="text-[11px] text-stone-500 mt-1" @if($bannerTextStyle($verdeTileBanner)) style="color:inherit;" @endif>{{ $verdeTileBanner->subtitle }}</p>
                        @endif
                        <p class="text-xs text-verde-btn group-hover:text-verde-dark mt-1 font-semibold inline-flex items-center gap-1 transition-colors" @if($bannerTextStyle($verdeTileBanner)) style="color:inherit;" @endif>
                            <span>{{ ($verdeTileBanner->button_text ?? null) ?: 'Shop Now' }}</span>
                            <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                        </p>
                    </div>
                    <div class="mt-4 aspect-square rounded-xl overflow-hidden bg-white/60 p-2 flex items-center justify-center">
                        <img src="{{ $verdeTileBanner ? $bannerUrl($verdeTileBanner) : '/images/themes/verde/' . $tile['img'] }}"
                             alt="{{ ($verdeTileBanner->title ?? null) ?: $tile['title'] }}"
                             class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                </a>
            @endforeach

        </div>
    </section>
    @endif

    <!-- 4. BEST SELLERS Product Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex items-center justify-between border-b border-verde-borderLight pb-4 mb-8">
            <h2 class="font-serif text-2xl sm:text-3xl font-medium text-verde-dark tracking-tight">
                Best Sellers
            </h2>
            <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" 
               class="text-xs font-bold uppercase tracking-widest text-verde-btn hover:text-verde-dark inline-flex items-center gap-1.5 transition-colors">
                <span>View All Products</span>
                <span>→</span>
            </a>
        </div>

        <!-- 6 Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
            @forelse(($verdeBestSellersProducts->count() ? $verdeBestSellersProducts : $products)->take(6) as $product)
                @include('store.themes.verde.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-12 text-center text-stone-500">
                    No products found in the catalog.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Two Promotional Banners -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">

            <!-- Left Banner: Better for you. Better for the planet. (Dark Olive)
                 (fully customizable via Banners: badge, headline, subtitle, button, colors) -->
            @if($bannerGridEnabled ?? true)
            @php $verdeLeftBanner = ($byPos['top_left'] ?? collect())->first(); @endphp
            <a href="{{ $verdeLeftBanner ? ($verdeLeftBanner->link ?: url('/online_store/contact' . $previewParam)) : url('/online_store/contact' . $previewParam) }}"
               class="block bg-[#4E5F3D] text-white rounded-3xl p-8 sm:p-12 flex flex-col justify-between relative overflow-hidden shadow-md"
               @if($bannerOverlayStyle($verdeLeftBanner)) style="{{ $bannerOverlayStyle($verdeLeftBanner) }}" @endif>
                <div class="space-y-4 max-w-md z-10" @if($bannerTextStyle($verdeLeftBanner)) style="{{ $bannerTextStyle($verdeLeftBanner) }}" @endif>
                    <!-- Tree Emblem -->
                    <div class="w-12 h-12 rounded-full border border-white/40 flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-emerald-200" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 22V10M12 10C12 5.5 16 3 19 3C19 7 17 11 12 14C7 11 5 7 5 3C8 3 12 5.5 12 10z"/>
                        </svg>
                    </div>

                    @if(!empty($verdeLeftBanner->badge_text))
                        <span class="text-xs font-bold uppercase tracking-widest text-emerald-200 block" style="color:inherit;">{{ $verdeLeftBanner->badge_text }}</span>
                    @endif

                    <h3 class="font-serif text-3xl sm:text-4xl font-normal leading-tight" style="color:inherit;">
                        @if(!empty($verdeLeftBanner->title))
                            {{ $verdeLeftBanner->title }}
                        @else
                            Better for you.<br>
                            <span class="italic font-light">Better for the planet.</span>
                        @endif
                    </h3>
                    <p class="text-sm text-emerald-100/90 leading-relaxed font-light pt-1" style="color:inherit;">
                        {{ ($verdeLeftBanner->subtitle ?? null) ?: 'Join thousands of customers making mindful choices every day.' }}
                    </p>
                </div>

                <div class="pt-8 z-10">
                    <span class="inline-block px-7 py-3 bg-white hover:bg-emerald-50 text-verde-dark font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-sm">
                        {{ ($verdeLeftBanner->button_text ?? null) ?: 'Learn More' }}
                    </span>
                </div>
            </a>
            @endif

            <!-- Right Banner: Bundle & Save (Light Sand) (customizable via Offers & Promotions) -->
            @if($offer['enabled'] ?? true)
            <div class="bg-[#F3EFEA] text-verde-dark rounded-3xl p-8 sm:p-12 flex flex-col sm:flex-row items-center justify-between gap-6 border border-verde-borderLight shadow-sm overflow-hidden">
                <div class="space-y-4 sm:max-w-xs text-center sm:text-left">
                    <span class="text-xs font-bold uppercase tracking-[0.16em] text-verde-btn">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'Bundle & Save' }}</span>
                    <h3 class="font-serif text-2xl sm:text-3xl font-medium leading-snug">
                        {{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'Save up to 25%' }}<br>
                        <span class="font-light text-stone-600 text-lg sm:text-xl">{{ ($offer['subtitle'] ?? '') !== '' ? $offer['subtitle'] : 'on our eco-friendly bundles.' }}</span>
                    </h3>
                    @if(!empty($offer['discount_text']))
                        <span class="inline-flex items-center rounded-full bg-verde-btn/10 px-3 py-1 text-xs font-bold text-verde-btn">{{ $offer['discount_text'] }}</span>
                    @endif
                    <div class="pt-2">
                        <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : url('/online_store/shop?category=gifts-sets' . $previewAmp) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-verde-btn hover:text-verde-dark transition-colors">
                            <span>{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop Bundles' }}</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Bundle Image -->
                <div class="w-48 sm:w-56 aspect-square rounded-2xl overflow-hidden bg-white/70 p-2 shadow-xs flex-shrink-0">
                    <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : '/images/themes/verde/verde-promo-bundle.jpg' }}"
                         alt="Eco-Friendly Bundles"
                         class="w-full h-full object-cover object-center rounded-xl">
                </div>
            </div>
            @endif

        </div>
    </section>

    <!-- 6. Brand / Partner Logo Strip -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
        <div class="border-t border-b border-verde-borderLight py-8 px-4 flex items-center justify-between flex-wrap gap-8 opacity-70">
            <span class="font-serif text-xl sm:text-2xl font-bold tracking-wider text-stone-700">meraki</span>
            <span class="font-sans text-lg sm:text-xl font-black tracking-[0.25em] text-stone-700">KINTO</span>
            <span class="font-serif text-xl sm:text-2xl font-semibold tracking-normal text-stone-700">Aēsop.</span>
            <span class="font-sans text-xl sm:text-2xl font-bold tracking-widest text-stone-700">pura.</span>
            <span class="font-sans text-lg sm:text-xl font-black tracking-[0.3em] text-stone-700">SELK</span>
            <span class="font-sans text-lg sm:text-xl font-bold tracking-tight text-stone-700">IRON<sup class="text-[0.6rem]">®</sup>FLASK</span>
        </div>
    </section>

</div>
@endsection
