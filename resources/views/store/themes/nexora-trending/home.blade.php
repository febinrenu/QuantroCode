@extends('store.themes.nexora-trending._shell')

@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $dealsUrl = url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $bestsellersUrl = url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));

    // Resolve products for Best Sellers
    $prodList = $products ?? collect();
    $bestSellers = $prodList->take(6);
@endphp

@section('content')

<!-- Main Container with Standard Max Width -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-10 sm:space-y-12">

    <!-- 1. HERO SECTION (With Original Nexora Hero Artwork & HTML Overlays) -->
    <section class="relative rounded-3xl overflow-hidden shadow-xl min-h-[380px] sm:min-h-[460px] lg:min-h-[520px] flex items-center bg-cover bg-center"
             style="background-image: url('{{ global_asset('images/themes/nexora/nexora-hero-original.png') }}');">

        <!-- Left & Right Carousel Navigation Arrows -->
        <button type="button"
                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white items-center justify-center transition z-20"
                aria-label="Previous Slide">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <button type="button"
                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white items-center justify-center transition z-20"
                aria-label="Next Slide">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Content Overlay Container -->
        <div class="relative z-10 w-full p-6 sm:p-10 lg:p-14">
            <div class="max-w-xl space-y-5 sm:space-y-6 text-center sm:text-left">

                <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-white leading-[1.08] tracking-tight">
                    Make Every<br>Day Easier
                </h1>

                <p class="text-xs sm:text-sm lg:text-base text-white/90 font-medium leading-relaxed max-w-md mx-auto sm:mx-0">
                    Discover trending products, exclusive deals and new arrivals – all in one place.
                </p>

                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 sm:gap-4 pt-2">
                    <a href="{{ $shopUrl }}"
                       class="px-7 sm:px-8 py-3 sm:py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-xs uppercase tracking-widest rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2">
                        <span>Shop Now</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>

                    <a href="{{ $bestsellersUrl }}"
                       class="px-7 sm:px-8 py-3 sm:py-3.5 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-extrabold text-xs uppercase tracking-widest rounded-full border border-white/30 transition-all hover:scale-105">
                        Explore More
                    </a>
                </div>

            </div>
        </div>

        <!-- Carousel Pagination Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center space-x-2 z-20">
            <span class="w-6 h-2 rounded-full bg-orange-500"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
        </div>

    </section>

    <!-- 2. TRUST / BENEFITS 4-COLUMN STRIP -->
    <section class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-xs">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">

            <!-- Item 1: Free Shipping -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-nex-blue flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-nex-navy leading-snug">Free Shipping</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">On orders over $99</p>
                </div>
            </div>

            <!-- Item 2: Secure Payment -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-nex-navy leading-snug">Secure Payment</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">100% secure checkout</p>
                </div>
            </div>

            <!-- Item 3: Easy Returns -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-nex-navy leading-snug">Easy Returns</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">30 days return policy</p>
                </div>
            </div>

            <!-- Item 4: 24/7 Support -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-nex-navy leading-snug">24/7 Support</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Dedicated support</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. CATEGORY DISCOVERY (8 Circular Items) -->
    <section class="py-2">
        <div class="grid grid-cols-4 sm:grid-cols-8 gap-4 sm:gap-6 text-center">

            @php
                $catItems = [
                    ['name' => 'Electronics', 'slug' => 'Electronics', 'icon' => 'cat-electronics.svg', 'bg' => 'bg-indigo-50 hover:bg-indigo-100'],
                    ['name' => 'Fashion', 'slug' => 'Fashion', 'icon' => 'cat-fashion.svg', 'bg' => 'bg-pink-50 hover:bg-pink-100'],
                    ['name' => 'Home & Living', 'slug' => 'Home & Living', 'icon' => 'cat-homeliving.svg', 'bg' => 'bg-amber-50 hover:bg-amber-100'],
                    ['name' => 'Beauty', 'slug' => 'Beauty', 'icon' => 'cat-beauty.svg', 'bg' => 'bg-emerald-50 hover:bg-emerald-100'],
                    ['name' => 'Sports', 'slug' => 'Sports', 'icon' => 'cat-sports.svg', 'bg' => 'bg-purple-50 hover:bg-purple-100'],
                    ['name' => 'Toys & Games', 'slug' => 'Toys & Games', 'icon' => 'cat-toysgames.svg', 'bg' => 'bg-orange-50 hover:bg-orange-100'],
                    ['name' => 'Automotive', 'slug' => 'Automotive', 'icon' => 'cat-automotive.svg', 'bg' => 'bg-sky-50 hover:bg-sky-100'],
                    ['name' => 'More', 'slug' => '', 'icon' => 'cat-more.svg', 'bg' => 'bg-slate-100 hover:bg-slate-200']
                ];
            @endphp

            @foreach($catItems as $c)
                @php
                    $catLink = $c['slug']
                        ? url('online_store/shop?category=' . urlencode($c['slug']) . ($previewTheme ? '&preview_theme=' . $previewTheme : ''))
                        : $shopUrl;
                @endphp
                <a href="{{ $catLink }}" class="group flex flex-col items-center gap-2.5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center p-3.5 transition-transform duration-300 group-hover:scale-110 shadow-xs border border-slate-100 {{ $c['bg'] }}">
                        <img src="{{ global_asset('images/themes/nexora/' . $c['icon']) }}"
                             alt="{{ $c['name'] }}"
                             class="w-full h-full object-contain">
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-nex-blue transition leading-tight">
                        {{ $c['name'] }}
                    </span>
                </a>
            @endforeach

        </div>
    </section>

    <!-- 4. THREE PROMOTIONAL CARDS ROW -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card 1: Deal of the Day -->
        <div class="rounded-3xl p-6 sm:p-7 promo-deal-grad text-white relative overflow-hidden flex flex-col justify-between min-h-[220px] shadow-lg">
            <div class="relative z-10 space-y-2 max-w-[60%]">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-300">
                    Deal of the Day
                </span>
                <h3 class="text-lg font-black leading-tight text-white">
                    Smartwatch Series 8
                </h3>
                <div class="flex items-baseline gap-2 font-black text-xl text-white">
                    <span>$129.99</span>
                    <span class="text-xs text-white/60 line-through font-normal">$199.99</span>
                </div>

                <!-- Live Countdown Timer -->
                <div class="flex items-center gap-1.5 pt-1 text-[10px] font-extrabold">
                    <div class="bg-black/30 backdrop-blur-xs px-2 py-1 rounded-lg text-center">
                        <span>08</span> <span class="text-[8px] block text-white/70">HRS</span>
                    </div>
                    <span>:</span>
                    <div class="bg-black/30 backdrop-blur-xs px-2 py-1 rounded-lg text-center">
                        <span>32</span> <span class="text-[8px] block text-white/70">MINS</span>
                    </div>
                    <span>:</span>
                    <div class="bg-black/30 backdrop-blur-xs px-2 py-1 rounded-lg text-center">
                        <span>45</span> <span class="text-[8px] block text-white/70">SECS</span>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ $shopUrl }}" class="inline-flex items-center gap-1 text-xs font-extrabold uppercase tracking-wider text-amber-300 hover:text-white transition">
                        <span>Shop Now</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Card Background Image Overlay -->
            <img src="{{ global_asset('images/themes/nexora/promo-deal-smartwatch.jpg') }}"
                 alt="Deal of the Day"
                 class="absolute right-0 bottom-0 w-1/2 h-full object-contain pointer-events-none">
        </div>

        <!-- Card 2: Trending Now (Sneakers) -->
        <div class="rounded-3xl p-6 sm:p-7 promo-trending-grad text-slate-900 relative overflow-hidden flex flex-col justify-between min-h-[220px] shadow-lg border border-amber-200/50">
            <div class="relative z-10 space-y-2 max-w-[60%]">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-700">
                    Trending Now
                </span>
                <h3 class="text-lg font-black leading-tight text-slate-900">
                    Sneakers Collection
                </h3>
                <p class="text-xs text-slate-600 font-medium">
                    New Styles Added
                </p>

                <div class="pt-6">
                    <a href="{{ $shopUrl }}" class="inline-block px-4 py-2 bg-slate-900 hover:bg-black text-white text-[11px] font-extrabold uppercase tracking-wider rounded-xl transition shadow-md">
                        Shop Collection
                    </a>
                </div>
            </div>

            <!-- Card Background Image Overlay -->
            <img src="{{ global_asset('images/themes/nexora/promo-trending-sneakers.jpg') }}"
                 alt="Trending Sneakers"
                 class="absolute right-0 bottom-0 w-1/2 h-full object-contain pointer-events-none">
        </div>

        <!-- Card 3: Summer Essentials -->
        <div class="rounded-3xl p-6 sm:p-7 promo-summer-grad text-teal-950 relative overflow-hidden flex flex-col justify-between min-h-[220px] shadow-lg border border-teal-200/50">
            <div class="relative z-10 space-y-2 max-w-[60%]">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-teal-800">
                    Summer Essentials
                </span>
                <h3 class="text-lg font-black leading-tight text-teal-950">
                    Up to 30% OFF
                </h3>
                <p class="text-xs text-teal-800 font-medium">
                    On selected items
                </p>

                <div class="pt-6">
                    <a href="{{ $shopUrl }}" class="inline-block px-4 py-2 bg-teal-900 hover:bg-teal-950 text-white text-[11px] font-extrabold uppercase tracking-wider rounded-xl transition shadow-md">
                        Shop Now
                    </a>
                </div>
            </div>

            <!-- Card Background Image Overlay -->
            <img src="{{ global_asset('images/themes/nexora/promo-summer-sunglasses.jpg') }}"
                 alt="Summer Essentials"
                 class="absolute right-0 bottom-0 w-1/2 h-full object-contain pointer-events-none">
        </div>

    </section>

    <!-- 5. BEST SELLERS SECTION (With Large Prominent Product Cards) -->
    <section class="space-y-6">

        <!-- Section Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-black tracking-tight text-nex-navy uppercase">
                Best Sellers
            </h2>

            <a href="{{ $shopUrl }}" class="text-xs font-bold text-nex-blue hover:text-nex-bluedark transition flex items-center gap-1">
                <span>View All Products</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <!-- 6 Best Seller Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
            @forelse($bestSellers as $prod)
                @include('store.themes.nexora-trending.partials.product-card', ['product' => $prod])
            @empty
                <div class="col-span-full py-12 text-center text-slate-400">
                    No products found.
                </div>
            @endforelse
        </div>

    </section>

    <!-- 6. DARK NAVY CUSTOMER TRUST STRIP -->
    <section class="bg-nex-navy text-white rounded-3xl p-6 sm:p-8 shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">

            <!-- 1. Trusted by 100K+ Customers -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-white leading-snug">Trusted by</h3>
                    <p class="text-xs text-slate-400 font-medium">100K+ Customers</p>
                </div>
            </div>

            <!-- 2. Top Quality Guaranteed -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 01-3.138 3.138z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-white leading-snug">Top Quality</h3>
                    <p class="text-xs text-slate-400 font-medium">Guaranteed</p>
                </div>
            </div>

            <!-- 3. Pay in 4 with No Interest -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-white leading-snug">Pay in 4 with</h3>
                    <p class="text-xs text-slate-400 font-medium">No Interest</p>
                </div>
            </div>

            <!-- 4. Exclusive Offers For Members -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-white flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-extrabold text-sm text-white leading-snug">Exclusive Offers</h3>
                    <p class="text-xs text-slate-400 font-medium">For Members</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 7. NEWSLETTER SECTION -->
    <section class="rounded-3xl p-8 sm:p-10 newsletter-grad text-white shadow-xl relative overflow-hidden">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 sm:gap-8 relative z-10">

            <!-- Envelope Icon & Text -->
            <div class="flex items-center gap-5 text-center md:text-left">
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-3xl shrink-0 shadow-inner">
                    ✉️
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-white">
                        Stay in the Loop
                    </h3>
                    <p class="text-xs sm:text-sm text-white/90 font-medium mt-1">
                        Subscribe to get special offers, free giveaways, and exclusive deals.
                    </p>
                </div>
            </div>

            <!-- Email Input Field + SUBSCRIBE Button -->
            <form action="{{ $shopUrl }}" method="GET" class="w-full md:w-auto flex-1 max-w-md flex items-center bg-white rounded-full p-1.5 shadow-xl">
                <input type="email"
                       placeholder="Enter your email address"
                       class="flex-1 bg-transparent px-4 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none"
                       required>
                <button type="submit"
                        class="px-6 py-2.5 bg-nex-navy hover:bg-black text-white text-xs font-black uppercase tracking-wider rounded-full transition shadow-md shrink-0">
                    Subscribe
                </button>
            </form>

        </div>
    </section>

</div>

@endsection
