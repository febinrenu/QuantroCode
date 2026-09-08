@extends('store.themes.zanova._shell')

@section('title', 'ZANOVA — Shop Beyond Limits | Modern Marketplace')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

@section('content')
<div class="space-y-10 pb-16">

    <!-- 1. Main Hero Area with Left Category Sidebar & Large Dark Tech Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch">

            <!-- Left Category Sidebar (Desktop Only) -->
            <div class="hidden lg:flex flex-col w-64 shrink-0 bg-white rounded-2xl border border-zanova-border shadow-xs overflow-hidden">
                <div class="p-3.5 divide-y divide-slate-100 flex-grow flex flex-col justify-between text-xs font-semibold text-slate-700">
                    <div class="space-y-0.5">
                        <a href="{{ url('/online_store/shop?category=electronics' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">💻</span>
                            <span>Electronics</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=fashion-apparel' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">👕</span>
                            <span>Fashion & Apparel</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=home-kitchen' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🏠</span>
                            <span>Home & Kitchen</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=beauty-personal-care' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🧴</span>
                            <span>Beauty & Personal Care</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=toys-games' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🎲</span>
                            <span>Toys & Games</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=sports-outdoors' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">⚽</span>
                            <span>Sports & Outdoors</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=automotive' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🚗</span>
                            <span>Automotive</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=books-stationery' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">📚</span>
                            <span>Books & Stationery</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=pet-supplies' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🐾</span>
                            <span>Pet Supplies</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=groceries-essentials' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🛒</span>
                            <span>Groceries & Essentials</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=health-wellness' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">❤️</span>
                            <span>Health & Wellness</span>
                        </a>
                        <a href="{{ url('/online_store/shop?category=gift-ideas' . $previewAmp) }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 hover:text-zanova-navy transition-colors">
                            <span class="text-base">🎁</span>
                            <span>Gift Ideas</span>
                        </a>
                    </div>

                    <div class="pt-2">
                        <a href="{{ url('/online_store/shop' . $previewParam) }}" class="w-full py-2 px-4 bg-zanova-navy hover:bg-slate-800 text-white font-bold text-center text-xs rounded-xl flex items-center justify-center gap-2 transition-colors">
                            <span>View All Categories</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Hero Tech Lifestyle Banner -->
            <div class="relative flex-grow rounded-2xl overflow-hidden bg-zanova-navy text-white min-h-[460px] lg:min-h-[500px] flex items-center shadow-xl border border-slate-800"
                 x-data="{ currentSlide: 0 }">

                <!-- Background Image with Overlay -->
                <div class="absolute inset-0 z-0">
                    <img src="/images/themes/zanova/zanova-hero-tech.jpg"
                         alt="Tech That Matches Your Lifestyle"
                         class="w-full h-full object-cover object-right sm:object-center lg:object-right">
                    <div class="absolute inset-0 bg-gradient-to-r from-zanova-navy/90 via-zanova-navy/50 to-transparent lg:w-1/2 pointer-events-none"></div>
                </div>

                <!-- Text & Action Content Overlay (Left Side) -->
                <div class="relative z-10 p-8 sm:p-12 lg:p-14 max-w-xl">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight text-white">
                        Tech That Matches Your <span class="text-zanova-yellow">Lifestyle</span>
                    </h1>
                    <p class="mt-4 text-sm sm:text-base font-medium text-slate-300">
                        Innovative gadgets. Unbeatable prices.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <!-- Yellow CTA Button -->
                        <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
                           class="px-7 py-3.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs uppercase tracking-wider rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            Shop Smart
                        </a>

                        <!-- Watch Video Glass Button -->
                        <button type="button"
                                class="px-5 py-3.5 bg-black/40 hover:bg-black/60 backdrop-blur-md text-white font-bold text-xs rounded-xl border border-white/20 flex items-center gap-2 transition-all">
                            <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[0.65rem]">▶</span>
                            <span>Watch Video</span>
                        </button>
                    </div>
                </div>

                <!-- Top-Right 70% OFF Promotional Badge -->
                <div class="absolute top-6 right-6 z-20">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-zanova-navy/90 backdrop-blur-md border-2 border-dashed border-zanova-yellow flex flex-col items-center justify-center shadow-2xl transform rotate-6 hover:rotate-0 transition-transform">
                        <span class="text-[0.62rem] font-bold text-slate-300 uppercase tracking-widest leading-none">UP TO</span>
                        <span class="text-xl sm:text-2xl font-black text-zanova-yellow leading-none my-0.5">70%</span>
                        <span class="text-[0.62rem] font-black text-white uppercase tracking-wider leading-none">OFF</span>
                    </div>
                </div>

                <!-- Carousel Left & Right Arrow Buttons -->
                <button type="button"
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center border border-white/20 transition-all shadow-md"
                        aria-label="Previous slide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button"
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-md text-white flex items-center justify-center border border-white/20 transition-all shadow-md"
                        aria-label="Next slide">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Bottom Carousel Dots -->
                <div class="absolute bottom-4 left-8 z-20 flex items-center gap-2">
                    <span class="w-6 h-2 rounded-full bg-zanova-yellow transition-all"></span>
                    <span class="w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all cursor-pointer"></span>
                    <span class="w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all cursor-pointer"></span>
                    <span class="w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all cursor-pointer"></span>
                    <span class="w-2 h-2 rounded-full bg-white/40 hover:bg-white/70 transition-all cursor-pointer"></span>
                </div>

            </div>

        </div>
    </section>

    <!-- 2. Five Benefit Cards -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-6 border border-zanova-border shadow-xs grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

            <!-- Benefit 1: Free Shipping -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Free Shipping</h4>
                    <p class="text-[0.7rem] text-slate-500 font-medium">On orders over $59</p>
                </div>
            </div>

            <!-- Benefit 2: Secure Payment -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Secure Payment</h4>
                    <p class="text-[0.7rem] text-slate-500 font-medium">100% safe & secure</p>
                </div>
            </div>

            <!-- Benefit 3: Easy Returns -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Easy Returns</h4>
                    <p class="text-[0.7rem] text-slate-500 font-medium">30-day return policy</p>
                </div>
            </div>

            <!-- Benefit 4: 24/7 Support -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">24/7 Support</h4>
                    <p class="text-[0.7rem] text-slate-500 font-medium">We're here to help</p>
                </div>
            </div>

            <!-- Benefit 5: Best Prices -->
            <div class="flex items-center gap-3.5 col-span-2 md:col-span-1">
                <div class="w-11 h-11 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Best Prices</h4>
                    <p class="text-[0.7rem] text-slate-500 font-medium">Guaranteed value</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. Five Category Cards -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">

            <!-- Card 1: Smartphones -->
            <div class="group bg-[#EBF2FA] rounded-2xl p-5 border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Smartphones</h3>
                    <p class="text-[0.72rem] text-slate-600 mt-0.5">Latest models & top brands</p>
                </div>
                <div class="my-4 aspect-square rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="/images/themes/zanova/cat-smartphones.jpg" alt="Smartphones" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300">
                </div>
                <a href="{{ url('/online_store/shop?category=electronics' . $previewAmp) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:text-zanova-purple transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Card 2: Fashion -->
            <div class="group bg-[#FFF8E7] rounded-2xl p-5 border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Fashion</h3>
                    <p class="text-[0.72rem] text-slate-600 mt-0.5">Trendy looks for everyone</p>
                </div>
                <div class="my-4 aspect-square rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="/images/themes/zanova/cat-fashion.jpg" alt="Fashion" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300">
                </div>
                <a href="{{ url('/online_store/shop?category=fashion-apparel' . $previewAmp) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:text-zanova-purple transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Card 3: Home Essentials -->
            <div class="group bg-[#EAF7EE] rounded-2xl p-5 border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Home Essentials</h3>
                    <p class="text-[0.72rem] text-slate-600 mt-0.5">For a better everyday life</p>
                </div>
                <div class="my-4 aspect-square rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="/images/themes/zanova/cat-home-essentials.jpg" alt="Home Essentials" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300">
                </div>
                <a href="{{ url('/online_store/shop?category=home-kitchen' . $previewAmp) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:text-zanova-purple transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Card 4: Beauty -->
            <div class="group bg-[#FDF0ED] rounded-2xl p-5 border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Beauty</h3>
                    <p class="text-[0.72rem] text-slate-600 mt-0.5">Care that makes you glow</p>
                </div>
                <div class="my-4 aspect-square rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="/images/themes/zanova/cat-beauty.jpg" alt="Beauty" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300">
                </div>
                <a href="{{ url('/online_store/shop?category=beauty-personal-care' . $previewAmp) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:text-zanova-purple transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Card 5: Sports -->
            <div class="group bg-[#F4F1FA] rounded-2xl p-5 border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Sports</h3>
                    <p class="text-[0.72rem] text-slate-600 mt-0.5">Gear up & stay active</p>
                </div>
                <div class="my-4 aspect-square rounded-xl overflow-hidden flex items-center justify-center">
                    <img src="/images/themes/zanova/cat-sports.jpg" alt="Sports" class="w-full h-full object-contain transform group-hover:scale-105 transition-transform duration-300">
                </div>
                <a href="{{ url('/online_store/shop?category=sports-outdoors' . $previewAmp) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:text-zanova-purple transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

        </div>
    </section>

    <!-- 4. Deal Of The Day Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header with Countdown Timer -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-2 border-b border-slate-200">
            <div class="flex flex-wrap items-center gap-4">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                    Deal Of The Day
                </h2>

                <!-- Countdown Timer Pills -->
                <div class="flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                    <span class="text-slate-500 font-medium">Ends In:</span>
                    <span class="bg-zanova-navy text-white px-2 py-0.5 rounded-md font-mono text-xs">08</span>
                    <span>:</span>
                    <span class="bg-zanova-navy text-white px-2 py-0.5 rounded-md font-mono text-xs">36</span>
                    <span>:</span>
                    <span class="bg-zanova-navy text-white px-2 py-0.5 rounded-md font-mono text-xs">45</span>
                </div>
            </div>

            <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
               class="inline-flex items-center gap-1 text-xs font-bold text-zanova-purple hover:text-zanova-purpleDark transition-colors">
                <span>View All Deals</span>
                <span>→</span>
            </a>
        </div>

        <!-- 6 Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @forelse($products->take(6) as $product)
                @include('store.themes.zanova.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-12 text-center text-slate-400 font-semibold text-sm">
                    No deals currently available. Check back soon!
                </div>
            @endforelse
        </div>

    </section>

    <!-- 5. Promotional Newsletter Banner (Extra 10% OFF) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-purple-900 via-indigo-950 to-zanova-navy text-white p-8 sm:p-10 shadow-xl border border-purple-800 flex flex-col lg:flex-row items-center justify-between gap-8">

            <!-- Left Info & Discount Badge -->
            <div class="flex items-center gap-6">
                <!-- Floating Discount Icon -->
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-rose-500 to-pink-500 text-white flex items-center justify-center font-black text-2xl shadow-lg transform -rotate-12 shrink-0">
                    %
                </div>
                <div>
                    <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Extra 10% OFF
                    </h3>
                    <div class="mt-1.5 flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-300">
                        <span>On your first order. Use code:</span>
                        <span class="px-2.5 py-1 bg-white/15 border border-dashed border-white/40 text-amber-300 font-mono font-black rounded-md tracking-wider">
                            WELCOME10
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Email Subscription Form -->
            <div class="w-full lg:max-w-md">
                <form class="flex items-center bg-white rounded-xl overflow-hidden p-1 shadow-inner" onsubmit="event.preventDefault(); alert('Subscribed! Use code WELCOME10 for 10% off.');">
                    <input type="email"
                           placeholder="Enter your email address"
                           required
                           class="flex-grow px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-hidden font-medium">
                    <button type="submit"
                            class="px-6 py-2.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs rounded-lg transition-colors shadow-xs">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>
    </section>

    <!-- 6. Top Brands Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-black text-slate-900 tracking-tight">Top Brands</h2>
            <a href="{{ url('/online_store/shop?collection=top-brands' . $previewAmp) }}" class="text-xs font-bold text-zanova-purple hover:text-zanova-purpleDark transition-colors">
                View All Brands →
            </a>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-7 gap-3 items-center">
            <!-- Apple -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-base text-slate-900 tracking-tight flex items-center gap-1">
                    <span></span>
                    <span>Apple</span>
                </span>
            </div>

            <!-- Samsung -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-sm text-[#1428A0] tracking-widest uppercase">
                    SAMSUNG
                </span>
            </div>

            <!-- Sony -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-base text-slate-900 tracking-wider uppercase">
                    SONY
                </span>
            </div>

            <!-- Nike -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-lg italic text-slate-900 tracking-tighter uppercase">
                    NIKE
                </span>
            </div>

            <!-- Adidas -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-sm text-slate-900 tracking-normal lowercase">
                    adidas
                </span>
            </div>

            <!-- Philips -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-black text-sm text-[#0B5ED7] tracking-widest uppercase">
                    PHILIPS
                </span>
            </div>

            <!-- Dyson -->
            <div class="bg-white rounded-xl p-4 border border-slate-200 flex items-center justify-center h-16 hover:border-slate-400 hover:shadow-xs transition-all">
                <span class="font-bold text-sm text-slate-800 tracking-widest lowercase">
                    dyson
                </span>
            </div>
        </div>
    </section>

</div>
@endsection
