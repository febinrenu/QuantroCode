@extends('store.themes.urbanic._shell')

@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $womenUrl = url('online_store/shop?category=Women' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $menUrl = url('online_store/shop?category=Men' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $kidsUrl = url('online_store/shop?category=Kids' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $shoesUrl = url('online_store/shop?category=Shoes' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $bagsUrl = url('online_store/shop?category=Bags' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $dealsUrl = url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $bestsellersUrl = url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));

    // Best Sellers: 6 products
    $prodList = $products ?? collect();
    $bestSellers = $prodList->take(6);
@endphp

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-10 sm:space-y-12">

    <!-- 1. HERO AREA WITH LEFT TOP CATEGORIES SIDEBAR -->
    <section class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Left Sidebar: Top Categories (Hidden on Mobile/Tablet) -->
        <div class="hidden lg:block lg:col-span-1 bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-black uppercase tracking-wider text-orange-600 mb-3 px-2">
                    Top Categories
                </h3>

                @php
                    $sidebarCats = [
                        ['name' => 'T-Shirts', 'icon' => '👕', 'slug' => 'T-Shirts'],
                        ['name' => 'Shirts', 'icon' => '👔', 'slug' => 'Shirts'],
                        ['name' => 'Dresses', 'icon' => '👗', 'slug' => 'Dresses'],
                        ['name' => 'Jeans', 'icon' => '👖', 'slug' => 'Jeans'],
                        ['name' => 'Jackets', 'icon' => '🧥', 'slug' => 'Jackets'],
                        ['name' => 'Footwear', 'icon' => '👟', 'slug' => 'Footwear'],
                        ['name' => 'Bags', 'icon' => '👜', 'slug' => 'Bags'],
                        ['name' => 'Watches', 'icon' => '⌚', 'slug' => 'Watches'],
                        ['name' => 'Sunglasses', 'icon' => '🕶️', 'slug' => 'Sunglasses'],
                        ['name' => 'Activewear', 'icon' => '🏃', 'slug' => 'Activewear']
                    ];
                @endphp

                <ul class="space-y-1 text-xs font-bold text-slate-700">
                    @foreach($sidebarCats as $sc)
                        @php
                            $catLink = url('online_store/shop?category=' . urlencode($sc['slug']) . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
                        @endphp
                        <li>
                            <a href="{{ $catLink }}"
                               class="flex items-center justify-between px-2.5 py-2 rounded-xl hover:bg-orange-50 hover:text-orange-600 transition group">
                                <span class="flex items-center gap-2.5">
                                    <span class="text-sm">{{ $sc['icon'] }}</span>
                                    <span>{{ $sc['name'] }}</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-orange-500 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- View All Categories Link -->
            <div class="pt-3 border-t border-slate-100 mt-2 px-2">
                <a href="{{ $shopUrl }}" class="text-xs font-black text-orange-600 hover:text-orange-700 transition flex items-center gap-1">
                    <span>View All Categories</span>
                    <span>→</span>
                </a>
            </div>
        </div>

        <!-- Right Hero Banner -->
        <div class="lg:col-span-3 relative rounded-3xl overflow-hidden shadow-xl min-h-[380px] sm:min-h-[440px] flex items-center bg-cover bg-center"
             style="background-image: url('{{ global_asset('images/themes/urbanic/urbanic-hero-banner.png') }}');">

            <!-- Left Carousel Arrow -->
            <button type="button"
                    class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/30 hover:bg-white/50 backdrop-blur-md text-white items-center justify-center transition z-20"
                    aria-label="Previous Slide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Carousel Arrow -->
            <button type="button"
                    class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/30 hover:bg-white/50 backdrop-blur-md text-white items-center justify-center transition z-20"
                    aria-label="Next Slide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Content Container -->
            <div class="relative z-10 w-full p-6 sm:p-10 lg:p-12">
                <div class="max-w-md space-y-4 text-center sm:text-left">

                    <span class="inline-block text-[11px] font-black uppercase tracking-widest text-urb-dark bg-amber-300/60 px-3 py-1 rounded-md">
                        New Season
                    </span>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-urb-dark leading-[1.08] tracking-tight">
                        Summer<br>
                        Looks Good<br>
                        On <span class="font-script font-bold text-white drop-shadow-sm">You</span>
                    </h1>

                    <p class="text-xs sm:text-sm text-urb-dark/90 font-medium leading-relaxed max-w-sm">
                        Fresh styles. Bright vibes. Endless possibilities.
                    </p>

                    <!-- CTA Buttons: SHOP WOMEN & SHOP MEN -->
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 pt-2">
                        <a href="{{ $womenUrl }}"
                           class="px-6 py-3 bg-urb-dark hover:bg-black text-white font-black text-xs uppercase tracking-wider rounded-full shadow-lg hover:scale-105 transition-all">
                            Shop Women
                        </a>

                        <a href="{{ $menUrl }}"
                           class="px-6 py-3 bg-white hover:bg-slate-50 text-urb-dark font-black text-xs uppercase tracking-wider rounded-full shadow-lg hover:scale-105 transition-all">
                            Shop Men
                        </a>
                    </div>

                </div>
            </div>

            <!-- Pagination Dots -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center space-x-2 z-20">
                <span class="w-6 h-2 rounded-full bg-white"></span>
                <span class="w-2 h-2 rounded-full bg-white/50"></span>
                <span class="w-2 h-2 rounded-full bg-white/50"></span>
                <span class="w-2 h-2 rounded-full bg-white/50"></span>
            </div>

        </div>

    </section>

    <!-- 2. TRUST / BENEFITS 5-COLUMN STRIP -->
    <section class="bg-white rounded-2xl border border-slate-200/80 p-5 sm:p-6 shadow-xs">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 sm:gap-4 text-center sm:text-left">

            <!-- Item 1: Free Shipping -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark leading-snug">Free Shipping</h4>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">On orders over $75</p>
                </div>
            </div>

            <!-- Item 2: Secure Payment -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark leading-snug">Secure Payment</h4>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">100% safe & secure</p>
                </div>
            </div>

            <!-- Item 3: Easy Returns -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark leading-snug">Easy Returns</h4>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">30 days return policy</p>
                </div>
            </div>

            <!-- Item 4: Exclusive Offers -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark leading-snug">Exclusive Offers</h4>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">On top brands</p>
                </div>
            </div>

            <!-- Item 5: 24/7 Support -->
            <div class="flex items-center gap-3 col-span-2 md:col-span-1 justify-center md:justify-start">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark leading-snug">24/7 Support</h4>
                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">We're here for you</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. FIVE CATEGORY COLLECTION CARDS -->
    <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">

        <!-- Card 1: WOMEN -->
        <a href="{{ $womenUrl }}" class="group rounded-3xl p-5 bg-[#FEEDE6] overflow-hidden flex flex-col justify-between min-h-[260px] relative hover:shadow-lg transition-all duration-300">
            <div class="relative z-10">
                <h3 class="text-base font-black text-urb-dark uppercase tracking-tight">
                    Women
                </h3>
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block mt-0.5">
                    Collection
                </span>
                <span class="text-xs font-bold text-urb-dark group-hover:text-orange-600 mt-2 inline-flex items-center gap-1 transition">
                    <span>Shop Now</span>
                    <span>→</span>
                </span>
            </div>
            <img src="{{ global_asset('images/themes/urbanic/collection-women.jpg') }}"
                 alt="Women Collection"
                 class="absolute right-0 bottom-0 w-3/4 h-3/4 object-contain group-hover:scale-105 transition-transform duration-500 pointer-events-none">
        </a>

        <!-- Card 2: MEN -->
        <a href="{{ $menUrl }}" class="group rounded-3xl p-5 bg-[#E1EEFC] overflow-hidden flex flex-col justify-between min-h-[260px] relative hover:shadow-lg transition-all duration-300">
            <div class="relative z-10">
                <h3 class="text-base font-black text-urb-dark uppercase tracking-tight">
                    Men
                </h3>
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block mt-0.5">
                    Collection
                </span>
                <span class="text-xs font-bold text-urb-dark group-hover:text-orange-600 mt-2 inline-flex items-center gap-1 transition">
                    <span>Shop Now</span>
                    <span>→</span>
                </span>
            </div>
            <img src="{{ global_asset('images/themes/urbanic/collection-men.jpg') }}"
                 alt="Men Collection"
                 class="absolute right-0 bottom-0 w-3/4 h-3/4 object-contain group-hover:scale-105 transition-transform duration-500 pointer-events-none">
        </a>

        <!-- Card 3: KIDS -->
        <a href="{{ $kidsUrl }}" class="group rounded-3xl p-5 bg-[#FEF3C7] overflow-hidden flex flex-col justify-between min-h-[260px] relative hover:shadow-lg transition-all duration-300">
            <div class="relative z-10">
                <h3 class="text-base font-black text-urb-dark uppercase tracking-tight">
                    Kids
                </h3>
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block mt-0.5">
                    Collection
                </span>
                <span class="text-xs font-bold text-urb-dark group-hover:text-orange-600 mt-2 inline-flex items-center gap-1 transition">
                    <span>Shop Now</span>
                    <span>→</span>
                </span>
            </div>
            <img src="{{ global_asset('images/themes/urbanic/collection-kids.jpg') }}"
                 alt="Kids Collection"
                 class="absolute right-0 bottom-0 w-3/4 h-3/4 object-contain group-hover:scale-105 transition-transform duration-500 pointer-events-none">
        </a>

        <!-- Card 4: SHOES -->
        <a href="{{ $shoesUrl }}" class="group rounded-3xl p-5 bg-[#EDE9FE] overflow-hidden flex flex-col justify-between min-h-[260px] relative hover:shadow-lg transition-all duration-300">
            <div class="relative z-10">
                <h3 class="text-base font-black text-urb-dark uppercase tracking-tight">
                    Shoes
                </h3>
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block mt-0.5">
                    Collection
                </span>
                <span class="text-xs font-bold text-urb-dark group-hover:text-orange-600 mt-2 inline-flex items-center gap-1 transition">
                    <span>Shop Now</span>
                    <span>→</span>
                </span>
            </div>
            <img src="{{ global_asset('images/themes/urbanic/collection-shoes.jpg') }}"
                 alt="Shoes Collection"
                 class="absolute right-0 bottom-0 w-3/4 h-3/4 object-contain group-hover:scale-105 transition-transform duration-500 pointer-events-none">
        </a>

        <!-- Card 5: BAGS -->
        <a href="{{ $bagsUrl }}" class="group rounded-3xl p-5 bg-[#DCFCE7] overflow-hidden flex flex-col justify-between min-h-[260px] relative hover:shadow-lg transition-all duration-300 col-span-2 sm:col-span-1">
            <div class="relative z-10">
                <h3 class="text-base font-black text-urb-dark uppercase tracking-tight">
                    Bags
                </h3>
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider block mt-0.5">
                    Collection
                </span>
                <span class="text-xs font-bold text-urb-dark group-hover:text-orange-600 mt-2 inline-flex items-center gap-1 transition">
                    <span>Shop Now</span>
                    <span>→</span>
                </span>
            </div>
            <img src="{{ global_asset('images/themes/urbanic/collection-bags.jpg') }}"
                 alt="Bags Collection"
                 class="absolute right-0 bottom-0 w-3/4 h-3/4 object-contain group-hover:scale-105 transition-transform duration-500 pointer-events-none">
        </a>

    </section>

    <!-- 4. DEAL OF THE DAY BANNER WITH LIVE COUNTDOWN -->
    <section class="deal-dark-grad rounded-3xl p-6 sm:p-8 text-white shadow-xl">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">

            <!-- Left: Icon & Text -->
            <div class="flex items-center gap-4 text-center md:text-left">
                <div class="w-14 h-14 rounded-2xl bg-orange-500 text-white flex items-center justify-center text-2xl font-black shrink-0 shadow-lg">
                    %
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-black uppercase tracking-tight text-white">
                        Deal of the Day
                    </h3>
                    <p class="text-xs text-slate-300 font-medium mt-0.5">
                        New deals every day. Don't miss out!
                    </p>
                </div>
            </div>

            <!-- Center: Countdown Boxes -->
            <div class="flex flex-col items-center gap-1.5">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-400">
                    Hurry Up!
                </span>
                <div class="flex items-center gap-2 text-xs font-black">
                    <div class="bg-white/10 px-3 py-2 rounded-xl text-center min-w-[52px]">
                        <span class="text-base block">10</span>
                        <span class="text-[9px] block text-slate-400 font-bold">HRS</span>
                    </div>
                    <span>:</span>
                    <div class="bg-white/10 px-3 py-2 rounded-xl text-center min-w-[52px]">
                        <span class="text-base block">23</span>
                        <span class="text-[9px] block text-slate-400 font-bold">MINS</span>
                    </div>
                    <span>:</span>
                    <div class="bg-white/10 px-3 py-2 rounded-xl text-center min-w-[52px]">
                        <span class="text-base block">45</span>
                        <span class="text-[9px] block text-slate-400 font-bold">SECS</span>
                    </div>
                </div>
            </div>

            <!-- Right: SHOP DEALS Button -->
            <div>
                <a href="{{ $dealsUrl }}"
                   class="px-8 py-3.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase tracking-wider rounded-full shadow-lg hover:scale-105 transition-all inline-block">
                    Shop Deals
                </a>
            </div>

        </div>
    </section>

    <!-- 5. BEST SELLERS SECTION -->
    <section class="space-y-6">

        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-black tracking-tight text-urb-dark uppercase">
                Best Sellers
            </h2>

            <a href="{{ $shopUrl }}" class="text-xs font-bold text-orange-600 hover:text-orange-700 transition flex items-center gap-1">
                <span>View All Products</span>
                <span>→</span>
            </a>
        </div>

        <!-- 6 Best Seller Product Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
            @forelse($bestSellers as $prod)
                @include('store.themes.urbanic.partials.product-card', ['product' => $prod])
            @empty
                <div class="col-span-full py-12 text-center text-slate-400">
                    No products found.
                </div>
            @endforelse
        </div>

    </section>

    <!-- 6. VALUE STRIP (4 Columns) -->
    <section class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200/80">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center sm:text-left">

            <!-- Trending Styles -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-orange-500 flex items-center justify-center text-xl shrink-0 shadow-xs border border-slate-200">
                    🔥
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark uppercase tracking-tight">Trending Styles</h4>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Stay ahead of the fashion</p>
                </div>
            </div>

            <!-- Premium Quality -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-orange-500 flex items-center justify-center text-xl shrink-0 shadow-xs border border-slate-200">
                    🏅
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark uppercase tracking-tight">Premium Quality</h4>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Handpicked with care</p>
                </div>
            </div>

            <!-- Easy Exchanges -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-orange-500 flex items-center justify-center text-xl shrink-0 shadow-xs border border-slate-200">
                    📦
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark uppercase tracking-tight">Easy Exchanges</h4>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Hassle-free process</p>
                </div>
            </div>

            <!-- Member Rewards -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white text-orange-500 flex items-center justify-center text-xl shrink-0 shadow-xs border border-slate-200">
                    👑
                </div>
                <div>
                    <h4 class="font-extrabold text-xs text-urb-dark uppercase tracking-tight">Member Rewards</h4>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Earn points & save more</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 7. URBANIC CLUB NEWSLETTER SECTION -->
    <section class="club-teal-grad rounded-3xl p-8 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 sm:gap-8 relative z-10">

            <!-- Left: Envelope Icon & Copy -->
            <div class="flex items-center gap-5 text-center md:text-left">
                <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl shrink-0 shadow-inner">
                    ✉️
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-white">
                        Join The Urbanic Club
                    </h3>
                    <p class="text-xs sm:text-sm text-teal-100 font-medium mt-1">
                        Sign up and get 10% OFF your first order
                    </p>
                </div>
            </div>

            <!-- Right: Subscription Form -->
            <form action="{{ $shopUrl }}" method="GET" class="w-full md:w-auto flex-1 max-w-md flex items-center bg-white rounded-full p-1.5 shadow-xl">
                <input type="email"
                       placeholder="Enter your email address"
                       class="flex-1 bg-transparent px-4 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none"
                       required>
                <button type="submit"
                        class="px-6 py-2.5 bg-urb-dark hover:bg-black text-white text-xs font-black uppercase tracking-wider rounded-full transition shadow-md shrink-0">
                    Subscribe
                </button>
            </form>

        </div>
    </section>

</div>

@endsection
