@extends('store.themes.technova._shell')

@section('title', ($s->store_name ?? 'TechNova') . ' | Premium Electronics & Smart Devices')

@section('content')
@php
    $previewTheme = request('preview_theme', 'technova');
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };

    // Split or filter products for sections
    $allProds = $products ?? collect([]);

    // Top Picks / Best Sellers / New Arrivals
    $featuredTopPicks = $allProds->take(8);
    $bestSellers = $allProds->slice(2, 4);
    $newArrivals = $allProds->slice(6, 4);
@endphp

<div class="bg-slate-50 min-h-screen">
    <!-- 1. Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 rounded-3xl overflow-hidden shadow-2xl border border-slate-700/50 text-white relative">
            <!-- Background Glow Effects -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-8 p-8 sm:p-12 lg:p-16 relative z-10">
                <!-- Left Column: Copy & Actions -->
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-400 text-xs font-bold uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                        NEW ARRIVALS 2024
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] font-heading">
                        Upgrade Your <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-200">
                            Tech Lifestyle
                        </span>
                    </h1>

                    <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Latest electronics, flagship smart devices and precision accessories designed for unmatched performance and everyday innovation.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ $themeUrl('online_store/shop') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5 text-center text-sm uppercase tracking-wider">
                            Shop Now
                        </a>
                        <a href="{{ $themeUrl('online_store/shop', ['collection' => 'deals']) }}" class="w-full sm:w-auto px-8 py-4 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-600 text-white font-bold rounded-xl transition text-center text-sm uppercase tracking-wider">
                            Explore Deals
                        </a>
                    </div>

                    <!-- Micro Trust Metrics -->
                    <div class="pt-6 border-t border-slate-700/60 flex items-center justify-center lg:justify-start gap-8 text-xs text-slate-400">
                        <div>
                            <span class="block font-bold text-white text-base">15K+</span>
                            <span>Products</span>
                        </div>
                        <div class="w-px h-8 bg-slate-700"></div>
                        <div>
                            <span class="block font-bold text-white text-base">100%</span>
                            <span>Authentic</span>
                        </div>
                        <div class="w-px h-8 bg-slate-700"></div>
                        <div>
                            <span class="block font-bold text-white text-base">2-Year</span>
                            <span>Warranty</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Hero Still-Life Visual -->
                <div class="lg:col-span-6 flex justify-center">
                    <div class="relative w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl border border-slate-700/60 group">
                        <img src="{{ global_asset('images/themes/technova/technova-hero-main.jpg') }}"
                             alt="TechNova Premium Electronics Lineup"
                             class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700"
                             onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 bg-slate-900/80 backdrop-blur-md p-3.5 rounded-xl border border-slate-700/60 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
                                <span class="font-bold text-white">2024 Flagship Series In Stock</span>
                            </div>
                            <span class="text-cyan-400 font-bold">Express Shipping</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Trust / Benefit Bar (5 items) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-tech-sm">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center md:text-left">
                <!-- Benefit 1 -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                        🚚
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide font-heading">Free Shipping</h4>
                        <p class="text-[11px] text-slate-500">On all orders over $49</p>
                    </div>
                </div>

                <!-- Benefit 2 -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                        🔒
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide font-heading">Secure Payments</h4>
                        <p class="text-[11px] text-slate-500">256-Bit SSL encrypted</p>
                    </div>
                </div>

                <!-- Benefit 3 -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                        🛡️
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide font-heading">Official Warranty</h4>
                        <p class="text-[11px] text-slate-500">100% Genuine brand guarantee</p>
                    </div>
                </div>

                <!-- Benefit 4 -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                        ⚡
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide font-heading">Fast Delivery</h4>
                        <p class="text-[11px] text-slate-500">Express 2-3 day transit</p>
                    </div>
                </div>

                <!-- Benefit 5 -->
                <div class="flex items-center gap-3.5 col-span-2 md:col-span-1 justify-center md:justify-start">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 text-xl font-bold">
                        💬
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wide font-heading">24/7 Support</h4>
                        <p class="text-[11px] text-slate-500">Dedicated tech experts</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Shop by Category (8 Categories) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Explore Catalog</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                    Shop by Category
                </h2>
            </div>
            <a href="{{ $themeUrl('online_store/shop') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 uppercase tracking-wider group">
                <span>View All Categories</span>
                <span class="group-hover:translate-x-1 transition transform">&rarr;</span>
            </a>
        </div>

        @php
            $cats = [
                ['name' => 'Smartphones', 'img' => 'cat-smartphones.jpg', 'count' => '45+ Products'],
                ['name' => 'Laptops', 'img' => 'cat-laptops.jpg', 'count' => '30+ Models'],
                ['name' => 'Tablets', 'img' => 'cat-tablets.jpg', 'count' => '20+ Devices'],
                ['name' => 'Audio', 'img' => 'cat-audio.jpg', 'count' => '50+ Items'],
                ['name' => 'Gaming', 'img' => 'cat-gaming.jpg', 'count' => '40+ Consoles & Gear'],
                ['name' => 'Cameras', 'img' => 'cat-cameras.jpg', 'count' => '25+ Cameras'],
                ['name' => 'Smart Home', 'img' => 'cat-smarthome.jpg', 'count' => '35+ Innovations'],
                ['name' => 'Accessories', 'img' => 'cat-accessories.jpg', 'count' => '80+ Accessories'],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($cats as $c)
                <a href="{{ $themeUrl('online_store/shop', ['category' => $c['name']]) }}" class="group bg-white rounded-2xl border border-slate-200/80 p-3 hover:border-blue-500/50 hover:shadow-tech-hover transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-full pt-[100%] relative rounded-xl overflow-hidden bg-slate-100 mb-3">
                        <img src="{{ global_asset('images/themes/technova/' . $c['img']) }}"
                             alt="{{ $c['name'] }}"
                             loading="lazy"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                    </div>
                    <span class="font-bold text-slate-900 text-xs group-hover:text-blue-600 transition leading-snug">{{ $c['name'] }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $c['count'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- 4. Featured Products with Tabs -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16" x-data="{ activeTab: 'top-picks' }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Handpicked Selections</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                    Featured Products
                </h2>
            </div>

            <!-- Tab Buttons -->
            <div class="flex items-center bg-slate-200/80 p-1.5 rounded-xl text-xs font-bold">
                <button @click="activeTab = 'top-picks'"
                        :class="activeTab === 'top-picks' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition uppercase tracking-wider">
                    Top Picks
                </button>
                <button @click="activeTab = 'best-rated'"
                        :class="activeTab === 'best-rated' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition uppercase tracking-wider">
                    Best Rated
                </button>
                <button @click="activeTab = 'on-sale'"
                        :class="activeTab === 'on-sale' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                        class="px-4 py-2 rounded-lg transition uppercase tracking-wider">
                    On Sale
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredTopPicks as $p)
                @include('store.themes.technova.partials.product-card', ['p' => $p])
            @empty
                <div class="col-span-4 bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500">
                    No products found in this category.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Promotional Banners (3 Columns) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Banner 1: Gaming Gear -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-800 text-white min-h-[260px] flex flex-col justify-between p-6 bg-slate-900 group">
                <img src="{{ global_asset('images/themes/technova/promo-gaming-gear.jpg') }}"
                     alt="Gaming Gear Promotion"
                     class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition duration-700"
                     onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-transparent"></div>
                <div class="relative z-10">
                    <span class="inline-block px-2.5 py-1 bg-red-600 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-md mb-2">
                        Up to 35% OFF
                    </span>
                    <h3 class="text-xl font-extrabold font-heading text-white">Next-Gen Gaming Gear</h3>
                    <p class="text-xs text-slate-300 mt-1">Consoles, RGB mechanical keyboards & wireless headsets</p>
                </div>
                <div class="relative z-10 pt-4">
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Gaming']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-lg transition uppercase tracking-wider">
                        <span>Shop Gaming</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Banner 2: Smart Home -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-800 text-white min-h-[260px] flex flex-col justify-between p-6 bg-slate-900 group">
                <img src="{{ global_asset('images/themes/technova/promo-smart-home.jpg') }}"
                     alt="Smart Home Promotion"
                     class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition duration-700"
                     onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-transparent"></div>
                <div class="relative z-10">
                    <span class="inline-block px-2.5 py-1 bg-blue-600 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-md mb-2">
                        Up to 30% OFF
                    </span>
                    <h3 class="text-xl font-extrabold font-heading text-white">Smart Home Ecosystems</h3>
                    <p class="text-xs text-slate-300 mt-1">Intelligent cameras, ambiance lighting & voice hubs</p>
                </div>
                <div class="relative z-10 pt-4">
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Smart Home']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-slate-100 text-slate-900 text-xs font-bold rounded-lg transition uppercase tracking-wider">
                        <span>Explore Smart Home</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Banner 3: Audio Deals -->
            <div class="relative rounded-3xl overflow-hidden shadow-lg border border-slate-800 text-white min-h-[260px] flex flex-col justify-between p-6 bg-slate-900 group">
                <img src="{{ global_asset('images/themes/technova/promo-audio-deals.jpg') }}"
                     alt="Audio Deals Promotion"
                     class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition duration-700"
                     onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/50 to-transparent"></div>
                <div class="relative z-10">
                    <span class="inline-block px-2.5 py-1 bg-cyan-500 text-slate-950 text-[10px] font-extrabold uppercase tracking-wider rounded-md mb-2">
                        Up to 40% OFF
                    </span>
                    <h3 class="text-xl font-extrabold font-heading text-white">Studio Audio Deals</h3>
                    <p class="text-xs text-slate-300 mt-1">ANC headphones, spatial earbuds & high-res monitors</p>
                </div>
                <div class="relative z-10 pt-4">
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Audio']) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-lg transition uppercase tracking-wider">
                        <span>Shop Audio</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Best Sellers -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Customer Favorites</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                    Best Sellers
                </h2>
            </div>
            <a href="{{ $themeUrl('online_store/shop', ['collection' => 'bestsellers']) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 uppercase tracking-wider group">
                <span>View All Best Sellers</span>
                <span class="group-hover:translate-x-1 transition transform">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $p)
                @include('store.themes.technova.partials.product-card', ['p' => $p])
            @endforeach
        </div>
    </section>

    <!-- 7. New Arrivals -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Just Dropped</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                    New Arrivals
                </h2>
            </div>
            <a href="{{ $themeUrl('online_store/shop', ['collection' => 'new-arrivals']) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 uppercase tracking-wider group">
                <span>View All New Arrivals</span>
                <span class="group-hover:translate-x-1 transition transform">&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newArrivals as $p)
                @include('store.themes.technova.partials.product-card', ['p' => $p])
            @endforeach
        </div>
    </section>

    <!-- 8. Recognizable Brands Bar -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-8 shadow-tech-sm">
            <div class="text-center mb-6">
                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Authorized Retailer</span>
                <h3 class="text-lg font-bold text-slate-900 font-heading">Shop by Official Brand</h3>
            </div>
            @php
                $brandsList = [
                    'Apple' => 'brand-apple.png',
                    'Samsung' => 'brand-samsung.png',
                    'Sony' => 'brand-sony.png',
                    'Google' => 'brand-google.png',
                    'ASUS' => 'brand-asus.png',
                    'Razer' => 'brand-razer.png',
                    'Anker' => 'brand-anker.png',
                    'DJI' => 'brand-dji.png',
                ];
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4 items-center">
                @foreach($brandsList as $bName => $bLogo)
                    <a href="{{ $themeUrl('online_store/shop', ['brand' => $bName]) }}" class="group bg-slate-50 hover:bg-blue-50/50 border border-slate-100 hover:border-blue-200 rounded-xl p-4 flex flex-col items-center justify-center text-center transition h-20">
                        <img src="{{ global_asset('images/themes/technova/' . $bLogo) }}"
                             alt="{{ $bName }} Brand"
                             class="h-7 w-auto object-contain filter grayscale group-hover:grayscale-0 transition"
                             onerror="this.src='{{ global_asset('images/themes/technova/technova-logo.png') }}'" />
                        <span class="text-[10px] font-bold text-slate-500 group-hover:text-blue-600 mt-1.5 transition">{{ $bName }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 9. Customer Trust & Testimonials -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="text-center mb-10">
            <span class="text-xs font-extrabold text-blue-600 uppercase tracking-widest">Verified Reviews</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                What Our Customers Say
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Review 1 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-tech-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 text-sm mb-3">
                        <span>★★★★★</span>
                        <span class="text-xs font-bold text-slate-600 ml-2">Verified Purchase</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        "Ordered the MacBook Pro M3 Max and Sony WH-1000XM5. Delivery arrived in 48 hours, impeccably packaged with official manufacturer seals. The customer experience is phenomenal."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <img src="{{ global_asset('images/themes/technova/avatar-david.jpg') }}" alt="David Miller" class="w-10 h-10 rounded-full object-cover border border-slate-200" />
                    <div>
                        <div class="font-bold text-slate-900 text-xs">David Miller</div>
                        <div class="text-[10px] text-slate-400">Software Architect, San Francisco</div>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-tech-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 text-sm mb-3">
                        <span>★★★★★</span>
                        <span class="text-xs font-bold text-slate-600 ml-2">Verified Purchase</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        "TechNova is hands down the best place for genuine electronics. Got my Galaxy S24 Ultra with an exclusive bundle discount and registered the warranty directly on Samsung's portal."
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <img src="{{ global_asset('images/themes/technova/avatar-sarah.jpg') }}" alt="Sarah Jenkins" class="w-10 h-10 rounded-full object-cover border border-slate-200" />
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Sarah Jenkins</div>
                        <div class="text-[10px] text-slate-400">Content Creator, Austin</div>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-tech-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center text-amber-400 text-sm mb-3">
                        <span>★★★★★</span>
                        <span class="text-xs font-bold text-slate-600 ml-2">Verified Purchase</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        "Upgraded my entire smart home with the Google Nest setup and Hue kit. Everything synced flawlessly. Support team answered my technical questions in minutes!"
                    </p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <img src="{{ global_asset('images/themes/technova/avatar-marcus.jpg') }}" alt="Marcus Vance" class="w-10 h-10 rounded-full object-cover border border-slate-200" />
                    <div>
                        <div class="font-bold text-slate-900 text-xs">Marcus Vance</div>
                        <div class="text-[10px] text-slate-400">Gaming Enthusiast, Seattle</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. Newsletter Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
            <div class="max-w-2xl mx-auto text-center space-y-4 relative z-10">
                <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-cyan-300 text-xs font-bold uppercase tracking-wider">
                    Tech Insider Club
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading">
                    Stay Ahead with Tech
                </h2>
                <p class="text-sm text-blue-100 leading-relaxed">
                    Subscribe for exclusive member deals, early access to flagship product launches, and weekly tech reviews.
                </p>
                <form class="flex flex-col sm:flex-row gap-3 pt-2" onsubmit="event.preventDefault(); alert('Thank you for subscribing to TechNova Insider!');">
                    <input type="email" required placeholder="Enter your email address..." class="flex-1 px-5 py-3.5 rounded-xl bg-white text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-400" />
                    <button type="submit" class="px-8 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-sm uppercase tracking-wider transition">
                        Subscribe
                    </button>
                </form>
                <div class="text-[11px] text-blue-200">
                    No spam guaranteed. Unsubscribe anytime with one click.
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
