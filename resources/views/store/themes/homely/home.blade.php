@extends('store.themes.homely._shell')

@section('title', 'Homely — Bring Nature Into Your Home | Home, Living & Decor')

@section('content')
@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
    $byPos = collect($banners ?? [])->groupBy('position');

    // Role-tagged Collection (Best Sellers) -- when a merchant has assigned a
    // dedicated "Best Sellers" Collection, its curated products win over the
    // generic $products slice for that section.
    $homelyBestSellers = ($collectionsByRole['best_sellers']['products'] ?? collect())->count()
        ? $collectionsByRole['best_sellers']['products']
        : $products->take(6);
@endphp

<div class="space-y-12 sm:space-y-16 pb-16">
    <!-- 1. HERO SECTION (auto-rotating carousel; add slides via Store Settings > Hero Slides) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-8 pt-4 sm:pt-6">
        @php $hmHeroSlides = $heroSlides ?? []; @endphp
        <div class="relative grid rounded-3xl overflow-hidden shadow-sm border border-homely-borderLight bg-homely-sand"
             x-data="{ hmHero: 0, hmHeroCount: {{ count($hmHeroSlides) }} }"
             @if(count($hmHeroSlides) > 1) x-init="setInterval(() => { hmHero = (hmHero + 1) % hmHeroCount }, 6000)" @endif>
        @foreach($hmHeroSlides as $hmI => $hmSlide)
        <div x-show="hmHero === {{ $hmI }}" @if(!$loop->first) x-cloak @endif
             x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="col-start-1 row-start-1">
        <div class="grid grid-cols-1 lg:grid-cols-12">
            <!-- Left Hero Content (7 cols) -->
            <div class="lg:col-span-5 p-8 sm:p-12 lg:p-14 flex flex-col justify-between relative">
                <!-- Botanical watermark leaf -->
                <div class="absolute top-6 left-6 opacity-10 pointer-events-none">
                    <svg class="w-24 h-24 text-homely-primary" viewBox="0 0 100 100" fill="currentColor">
                        <path d="M50 0C50 50 100 50 100 100C50 100 50 50 0 50C50 50 50 0 50 0Z"/>
                    </svg>
                </div>

                <div class="relative z-10 space-y-5">
                    <span class="inline-block text-xs font-semibold tracking-wider text-homely-muted uppercase">
                        New Collection
                    </span>
                    <h1 class="font-serif text-4xl sm:text-5xl lg:text-5xl font-bold text-homely-primary leading-[1.15]">
                        @if(($hmSlide['title'] ?? '') !== '')
                            {{ $hmSlide['title'] }}
                        @else
                            Bring Nature <br>Into Your Home
                        @endif
                    </h1>
                    <p class="text-sm sm:text-base text-stone-600 max-w-sm leading-relaxed">
                        {{ ($hmSlide['subtitle'] ?? '') !== '' ? $hmSlide['subtitle'] : 'Thoughtfully designed pieces for a calm, cozy and conscious living.' }}
                    </p>

                    <div class="pt-2">
                        <a href="{{ ($hmSlide['cta_link'] ?? '') !== '' ? $hmSlide['cta_link'] : url('/online_store/shop' . $previewParam) }}"
                           class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-homely-primary hover:bg-homely-primaryDark text-white text-xs font-bold tracking-wider uppercase transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <span>{{ ($hmSlide['cta_text'] ?? '') !== '' ? $hmSlide['cta_text'] : 'SHOP THE COLLECTION' }}</span>
                            <span class="text-sm">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- 3 Hero Benefits & Carousel Indicator -->
                <div class="mt-10 pt-8 border-t border-homely-border/60 relative z-10 space-y-6">
                    <div class="grid grid-cols-3 gap-3 text-center sm:text-left">
                        <div class="space-y-1">
                            <div class="text-homely-primary text-lg">🌿</div>
                            <h4 class="text-xs font-bold text-homely-text">Natural</h4>
                            <p class="text-[11px] text-stone-500">Materials</p>
                        </div>
                        <div class="space-y-1">
                            <div class="text-homely-primary text-lg">✋</div>
                            <h4 class="text-xs font-bold text-homely-text">Handmade</h4>
                            <p class="text-[11px] text-stone-500">with Care</p>
                        </div>
                        <div class="space-y-1">
                            <div class="text-homely-primary text-lg">🌍</div>
                            <h4 class="text-xs font-bold text-homely-text">Good for You</h4>
                            <p class="text-[11px] text-stone-500">& the Planet</p>
                        </div>
                    </div>

                    <!-- Carousel Dots -->
                    @if(count($hmHeroSlides) > 1)
                        <div class="flex items-center gap-2">
                            @foreach($hmHeroSlides as $hmDotI => $hmDotSlide)
                                <button type="button" @click="hmHero = {{ $hmDotI }}" class="w-2.5 h-2.5 rounded-full transition-colors" :class="hmHero === {{ $hmDotI }} ? 'bg-homely-primary' : 'bg-stone-300'" aria-label="Slide {{ $hmDotI + 1 }}"></button>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-homely-primary"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-stone-300"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-stone-300"></span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Hero Image (7 cols) -->
            <div class="lg:col-span-7 relative min-h-[380px] sm:min-h-[460px] lg:min-h-full">
                <img src="{{ !empty($hmSlide['image_url']) ? $hmSlide['image_url'] : '/images/themes/homely/homely-hero-livingroom.jpg' }}"
                     alt="Homely Living Room Interior"
                     class="w-full h-full object-cover object-center"
                     loading="eager">

                <!-- Sustainable Living Round Badge (Top Right) -->
                <div class="absolute top-6 right-6 w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-homely-primaryDark/90 backdrop-blur-xs text-white p-2.5 flex flex-col items-center justify-center text-center shadow-xl border border-white/20">
                    <span class="text-[8px] sm:text-[9px] font-bold tracking-widest text-emerald-300 uppercase">SUSTAINABLE</span>
                    <span class="text-[9px] sm:text-[10px] font-bold tracking-widest uppercase">LIVING</span>
                    <span class="font-serif text-[11px] sm:text-xs font-bold text-stone-200 mt-0.5">BETTER</span>
                    <span class="text-[8px] sm:text-[9px] tracking-wider text-emerald-200">CHOICES 🌿</span>
                </div>
            </div>
        </div>
        </div>
        @endforeach
        </div>
    </section>

    <!-- 2. TRUST & BENEFITS 4-COLUMN STRIP -->
    <section class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 px-6 sm:px-10 rounded-2xl bg-white border border-homely-borderLight shadow-2xs divide-y md:divide-y-0 md:divide-x divide-homely-borderLight">
            <!-- Free Shipping -->
            <div class="flex items-center gap-3.5 pt-4 md:pt-0">
                <div class="w-10 h-10 rounded-full bg-homely-sand flex items-center justify-center text-homely-terracotta flex-shrink-0 text-xl">
                    🚚
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Free Shipping</h4>
                    <p class="text-[11px] text-stone-500">On orders over $69</p>
                </div>
            </div>

            <!-- Secure Checkout -->
            <div class="flex items-center gap-3.5 pt-4 md:pt-0 md:pl-6">
                <div class="w-10 h-10 rounded-full bg-homely-sand flex items-center justify-center text-homely-primary flex-shrink-0 text-xl">
                    🛡️
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Secure Checkout</h4>
                    <p class="text-[11px] text-stone-500">100% secure payments</p>
                </div>
            </div>

            <!-- Easy Returns -->
            <div class="flex items-center gap-3.5 pt-4 md:pt-0 md:pl-6">
                <div class="w-10 h-10 rounded-full bg-homely-sand flex items-center justify-center text-homely-terracotta flex-shrink-0 text-xl">
                    🔄
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Easy Returns</h4>
                    <p class="text-[11px] text-stone-500">30 days return policy</p>
                </div>
            </div>

            <!-- Dedicated Support -->
            <div class="flex items-center gap-3.5 pt-4 md:pt-0 md:pl-6">
                <div class="w-10 h-10 rounded-full bg-homely-sand flex items-center justify-center text-homely-primary flex-shrink-0 text-xl">
                    🎧
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Dedicated Support</h4>
                    <p class="text-[11px] text-stone-500">We're here to help</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FIVE CATEGORY CARDS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">
            <!-- 1. Living Room Essentials -->
            <a href="{{ url('/online_store/shop?category=living-room' . $previewAmp) }}" 
               class="group relative bg-homely-card rounded-2xl p-5 border border-homely-borderLight hover:border-homely-border hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                <div class="space-y-1">
                    <h3 class="font-serif text-base sm:text-lg font-bold text-homely-primary group-hover:text-homely-terracotta transition-colors leading-tight">
                        Living Room<br>Essentials
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-500 group-hover:text-homely-primary transition-colors">
                        <span>SHOP NOW</span>
                        <span>&rarr;</span>
                    </span>
                </div>
                <div class="mt-4 aspect-4/3 rounded-xl overflow-hidden bg-white/60">
                    <img src="/images/themes/homely/cat-living-room.jpg" 
                         alt="Living Room Essentials" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            </a>

            <!-- 2. Kitchen & Dining -->
            <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
               class="group relative bg-homely-card rounded-2xl p-5 border border-homely-borderLight hover:border-homely-border hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                <div class="space-y-1">
                    <h3 class="font-serif text-base sm:text-lg font-bold text-homely-primary group-hover:text-homely-terracotta transition-colors leading-tight">
                        Kitchen &<br>Dining
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-500 group-hover:text-homely-primary transition-colors">
                        <span>SHOP NOW</span>
                        <span>&rarr;</span>
                    </span>
                </div>
                <div class="mt-4 aspect-4/3 rounded-xl overflow-hidden bg-white/60">
                    <img src="/images/themes/homely/cat-kitchen-dining.jpg" 
                         alt="Kitchen and Dining" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            </a>

            <!-- 3. Bedroom Comfort -->
            <a href="{{ url('/online_store/shop?category=bedroom' . $previewAmp) }}" 
               class="group relative bg-homely-card rounded-2xl p-5 border border-homely-borderLight hover:border-homely-border hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                <div class="space-y-1">
                    <h3 class="font-serif text-base sm:text-lg font-bold text-homely-primary group-hover:text-homely-terracotta transition-colors leading-tight">
                        Bedroom<br>Comfort
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-500 group-hover:text-homely-primary transition-colors">
                        <span>SHOP NOW</span>
                        <span>&rarr;</span>
                    </span>
                </div>
                <div class="mt-4 aspect-4/3 rounded-xl overflow-hidden bg-white/60">
                    <img src="/images/themes/homely/cat-bedroom-comfort.jpg" 
                         alt="Bedroom Comfort" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            </a>

            <!-- 4. Bathroom Refresh -->
            <a href="{{ url('/online_store/shop?category=bathroom' . $previewAmp) }}" 
               class="group relative bg-homely-card rounded-2xl p-5 border border-homely-borderLight hover:border-homely-border hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
                <div class="space-y-1">
                    <h3 class="font-serif text-base sm:text-lg font-bold text-homely-primary group-hover:text-homely-terracotta transition-colors leading-tight">
                        Bathroom<br>Refresh
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-500 group-hover:text-homely-primary transition-colors">
                        <span>SHOP NOW</span>
                        <span>&rarr;</span>
                    </span>
                </div>
                <div class="mt-4 aspect-4/3 rounded-xl overflow-hidden bg-white/60">
                    <img src="/images/themes/homely/cat-bathroom-refresh.jpg" 
                         alt="Bathroom Refresh" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            </a>

            <!-- 5. Indoor Plants -->
            <a href="{{ url('/online_store/shop?category=indoor-plants' . $previewAmp) }}" 
               class="group relative bg-homely-card rounded-2xl p-5 border border-homely-borderLight hover:border-homely-border hover:shadow-md transition-all flex flex-col justify-between overflow-hidden col-span-2 sm:col-span-1">
                <div class="space-y-1">
                    <h3 class="font-serif text-base sm:text-lg font-bold text-homely-primary group-hover:text-homely-terracotta transition-colors leading-tight">
                        Indoor<br>Plants
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-stone-500 group-hover:text-homely-primary transition-colors">
                        <span>SHOP NOW</span>
                        <span>&rarr;</span>
                    </span>
                </div>
                <div class="mt-4 aspect-4/3 rounded-xl overflow-hidden bg-white/60">
                    <img src="/images/themes/homely/cat-indoor-plants.jpg" 
                         alt="Indoor Plants" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
            </a>
        </div>
    </section>

    <!-- 4. BEST SELLERS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="flex items-end justify-between mb-8 pb-3 border-b border-homely-borderLight">
            <div>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-homely-primary">
                    Best Sellers
                </h2>
            </div>
            <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" 
               class="text-xs sm:text-sm font-semibold text-homely-terracotta hover:text-homely-terracottaHover transition-colors flex items-center gap-1">
                <span>View all products</span>
                <span>&rarr;</span>
            </a>
        </div>

        <!-- 6 Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
            @forelse($homelyBestSellers as $product)
                @include('store.themes.homely.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-12 text-center text-stone-500">
                    No home products found.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. THREE PROMOTIONAL HIGHLIGHT CARDS -->
    @if($bannerGridEnabled ?? true)
    <section class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- 1. Earth Friendly Card -->
            @php $topLeft = ($byPos['top_left'] ?? collect())->first(); @endphp
            <div class="rounded-3xl p-8 bg-homely-primary text-white flex flex-col justify-between relative overflow-hidden min-h-[220px]"
                 @if(!empty($topLeft->bg_color ?? null))
                 style="background:{{ !empty($topLeft->bg_color_2 ?? null) ? 'linear-gradient(135deg, '.$topLeft->bg_color.', '.$topLeft->bg_color_2.')' : $topLeft->bg_color }};"
                 @endif>
                <div class="space-y-2 relative z-10" @if(!empty($topLeft->text_color ?? null)) style="color:{{ $topLeft->text_color }};" @endif>
                    <div class="w-8 h-8 text-emerald-300 text-2xl mb-1">
                        🌿
                    </div>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold leading-tight" style="color:inherit;">
                        {{ ($topLeft->title ?? null) ?: 'Earth Friendly' }}
                    </h3>
                    <p class="text-xs text-stone-300 font-medium" style="color:inherit;">
                        {{ ($topLeft->subtitle ?? null) ?: 'Every Choice Matters' }}
                    </p>
                </div>
                <div class="pt-6 relative z-10">
                    <a href="{{ $topLeft ? ($topLeft->link ?: url('/online_store/shop' . $previewParam)) : url('/online_store/shop' . $previewParam) }}"
                       class="inline-flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-white hover:text-emerald-300 transition-colors" style="color:inherit;">
                        <span>{{ ($topLeft->button_text ?? null) ?: 'SHOP SUSTAINABLE' }}</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- 2. Join Our Community Card -->
            <div class="rounded-3xl p-8 bg-homely-sand border border-homely-border text-homely-text flex flex-col justify-between min-h-[220px]">
                <div class="space-y-2">
                    <div class="w-8 h-8 text-homely-terracotta text-2xl mb-1">
                        📬
                    </div>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-homely-primary leading-tight">
                        Join Our Community
                    </h3>
                    <p class="text-xs text-stone-600">
                        Get exclusive offers & green living tips.
                    </p>
                </div>
                <div class="pt-5">
                    <form @submit.prevent="showToast('Thank you for subscribing!')" class="flex gap-2">
                        <input type="email" 
                               placeholder="Enter your email address" 
                               required
                               class="w-full px-4 py-2 text-xs rounded-full border border-homely-border bg-white text-homely-text placeholder-stone-400 focus:outline-none focus:border-homely-primary">
                        <button type="submit" 
                                class="px-5 py-2 rounded-full bg-homely-terracotta hover:bg-homely-terracottaHover text-white text-xs font-bold uppercase transition-colors shadow-xs">
                            SUBSCRIBE
                        </button>
                    </form>
                </div>
            </div>

            <!-- 3. Gift With Meaning Card -->
            @php $topRight = ($byPos['top_right'] ?? collect())->first(); @endphp
            <div class="rounded-3xl p-8 bg-homely-sage text-white flex flex-col justify-between min-h-[220px]"
                 @if(!empty($topRight->bg_color ?? null))
                 style="background:{{ !empty($topRight->bg_color_2 ?? null) ? 'linear-gradient(135deg, '.$topRight->bg_color.', '.$topRight->bg_color_2.')' : $topRight->bg_color }};"
                 @endif>
                <div class="space-y-2" @if(!empty($topRight->text_color ?? null)) style="color:{{ $topRight->text_color }};" @endif>
                    <div class="w-8 h-8 text-stone-100 text-2xl mb-1">
                        🎁
                    </div>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold leading-tight" style="color:inherit;">
                        {{ ($topRight->title ?? null) ?: 'Gift With Meaning' }}
                    </h3>
                    <p class="text-xs text-stone-100" style="color:inherit;">
                        {{ ($topRight->subtitle ?? null) ?: 'Thoughtful gifts for every occasion.' }}
                    </p>
                </div>
                <div class="pt-6">
                    <a href="{{ $topRight ? ($topRight->link ?: url('/online_store/shop?category=decor' . $previewAmp)) : url('/online_store/shop?category=decor' . $previewAmp) }}"
                       class="inline-flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-white hover:text-stone-200 transition-colors" style="color:inherit;">
                        <span>{{ ($topRight->button_text ?? null) ?: 'SHOP GIFT GUIDE' }}</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 6. VALUE GUARANTEE STRIP -->
    <section class="max-w-7xl mx-auto px-4 sm:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 px-6 sm:px-10 rounded-2xl bg-white border border-homely-borderLight shadow-2xs divide-y md:divide-y-0 md:divide-x divide-homely-borderLight">
            <div class="flex items-center gap-3 pt-3 md:pt-0">
                <div class="text-2xl text-homely-primary">🌍</div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Sustainable</h4>
                    <p class="text-[11px] text-stone-500">We care for the planet</p>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-3 md:pt-0 md:pl-6">
                <div class="text-2xl text-homely-terracotta">✨</div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Quality You Can Trust</h4>
                    <p class="text-[11px] text-stone-500">Durable & long lasting</p>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-3 md:pt-0 md:pl-6">
                <div class="text-2xl text-homely-primary">🤲</div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Small Business</h4>
                    <p class="text-[11px] text-stone-500">Made with passion</p>
                </div>
            </div>
            <div class="flex items-center gap-3 pt-3 md:pt-0 md:pl-6">
                <div class="text-2xl text-homely-terracotta">💳</div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-homely-text">Secure Payments</h4>
                    <p class="text-[11px] text-stone-500">Multiple safe options</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
