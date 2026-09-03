@extends('store.themes.novatech-electronics._shell')

@section('title', 'NOVATECH — Smarter Everyday | Leading Tech & Electronics Marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-12">

    <!-- 1. Hero Section (Sidebar + Tech Showcase Banner) -->
    <section class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-stretch">
        <!-- Left Categories Sidebar -->
        <div class="hidden lg:block lg:col-span-1 bg-[#0F172A] rounded-2xl shadow-sm border border-slate-800 overflow-hidden flex flex-col justify-between py-2">
            <div class="divide-y divide-slate-800/60">
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'electronics']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Electronics
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'laptops']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Computers & Laptops
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'smartphones']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Mobiles & Tablets
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'wearables']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Smart Watch
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'audio']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6a7 7 0 00-7 7v4a2 2 0 002 2h2a2 2 0 002-2v-4a2 2 0 00-2-2 5 5 0 015-5z"/></svg>
                        Audio & Headphones
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'cameras']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                        Camera & Photo
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'gaming']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                        Gaming
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'accessories']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Accessories
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'software']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        Software
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'home-appliances']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-slate-200 hover:bg-slate-800 hover:text-indigo-400 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Home Appliances
                    </span>
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="flex items-center justify-between px-5 py-3 text-xs font-semibold text-indigo-400 hover:bg-slate-800 transition-colors">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        More Categories
                    </span>
                    <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Center/Right Main Hero Showcase -->
        <div class="lg:col-span-3 relative rounded-2xl overflow-hidden bg-[#070A13] shadow-2xl min-h-[460px] lg:min-h-[500px] flex items-center">
            <!-- Hero Background Art -->
            <img src="/images/themes/novatech/novatech-hero-tech.jpg"
                 alt="NovaTech Upgrade Perform Enjoy"
                 class="absolute inset-0 w-full h-full object-cover object-right lg:object-center"
                 onerror="this.onerror=null; this.src='/images/products/novatech-hero-tech.jpg';">

            <!-- Gradient Overlays for perfect typography contrast -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#070A13] via-[#070A13]/85 to-transparent lg:via-[#070A13]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#070A13]/90 via-transparent to-transparent"></div>

            <!-- Discount Badge top right -->
            <div class="absolute top-6 right-6 z-20 flex items-center justify-center">
                <div class="w-20 h-20 rounded-full border border-indigo-500/40 bg-slate-950/80 backdrop-blur-md flex flex-col items-center justify-center text-center p-2 shadow-lg shadow-indigo-500/20">
                    <span class="text-[9px] uppercase tracking-wider font-bold text-slate-300 leading-none">UP TO</span>
                    <span class="text-xl font-black text-white leading-none my-0.5">30%</span>
                    <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest leading-none">OFF</span>
                </div>
            </div>

            <!-- Left & Right Carousel Arrows -->
            <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/60 hover:bg-slate-900 border border-slate-700/60 text-white flex items-center justify-center transition-all shadow-md backdrop-blur-sm" aria-label="Previous Slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-slate-950/60 hover:bg-slate-900 border border-slate-700/60 text-white flex items-center justify-center transition-all shadow-md backdrop-blur-sm" aria-label="Next Slide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Hero Text Content -->
            <div class="relative z-10 p-8 sm:p-12 lg:p-14 max-w-xl">
                <span class="inline-block text-[11px] font-extrabold uppercase tracking-widest text-indigo-400 mb-3">
                    NEW TECHNOLOGY
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-[1.1] mb-4">
                    Upgrade.<br>
                    Perform.<br>
                    <span class="text-sky-400">Enjoy.</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-300 mb-8 max-w-md font-normal leading-relaxed">
                    Discover the latest tech and gadgets at the best prices.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="inline-flex items-center space-x-2 px-7 py-3.5 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-indigo-600/30">
                        <span>SHOP NOW</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'new-arrivals']) }}" class="inline-flex items-center px-6 py-3.5 rounded-full bg-slate-950/80 hover:bg-slate-900 border border-slate-700 text-white font-bold text-xs uppercase tracking-wider transition-all backdrop-blur-sm">
                        EXPLORE MORE
                    </a>
                </div>
            </div>

            <!-- Bottom Pagination Dots -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-20 flex items-center space-x-2">
                <span class="w-6 h-2 rounded-full bg-indigo-500 transition-all"></span>
                <span class="w-2 h-2 rounded-full bg-slate-600 hover:bg-slate-400 cursor-pointer transition-colors"></span>
                <span class="w-2 h-2 rounded-full bg-slate-600 hover:bg-slate-400 cursor-pointer transition-colors"></span>
                <span class="w-2 h-2 rounded-full bg-slate-600 hover:bg-slate-400 cursor-pointer transition-colors"></span>
            </div>
        </div>
    </section>

    <!-- 2. Circular Category Icons Strip (9 items) -->
    <section class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
        <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-9 gap-4 text-center">
            <!-- 1. Laptops -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'laptops']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50/60 border border-indigo-100 group-hover:border-indigo-500 group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">Laptops</span>
            </a>

            <!-- 2. Smartphones -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'smartphones']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-cyan-50/60 border border-cyan-100 group-hover:border-cyan-500 group-hover:bg-cyan-500 text-cyan-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-cyan-600 transition-colors">Smartphones</span>
            </a>

            <!-- 3. Wearables -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'wearables']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-purple-50/60 border border-purple-100 group-hover:border-purple-500 group-hover:bg-purple-600 text-purple-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-purple-600 transition-colors">Wearables</span>
            </a>

            <!-- 4. Audio -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'audio']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-rose-50/60 border border-rose-100 group-hover:border-rose-500 group-hover:bg-rose-500 text-rose-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.536 8.464a5 5 0 010 7.072M12 6a7 7 0 00-7 7v4a2 2 0 002 2h2a2 2 0 002-2v-4a2 2 0 00-2-2 5 5 0 015-5z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-rose-600 transition-colors">Audio</span>
            </a>

            <!-- 5. Gaming -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'gaming']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50/60 border border-emerald-100 group-hover:border-emerald-500 group-hover:bg-emerald-600 text-emerald-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Gaming</span>
            </a>

            <!-- 6. Accessories -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'accessories']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-violet-50/60 border border-violet-100 group-hover:border-violet-500 group-hover:bg-violet-600 text-violet-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-violet-600 transition-colors">Accessories</span>
            </a>

            <!-- 7. Cameras -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'cameras']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-50/60 border border-blue-100 group-hover:border-blue-500 group-hover:bg-blue-600 text-blue-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition-colors">Cameras</span>
            </a>

            <!-- 8. Smart Home -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'smart-home']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-teal-50/60 border border-teal-100 group-hover:border-teal-500 group-hover:bg-teal-600 text-teal-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Smart Home</span>
            </a>

            <!-- 9. More -->
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="group flex flex-col items-center">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 group-hover:border-slate-800 group-hover:bg-slate-900 text-slate-600 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md mb-2.5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-slate-900 transition-colors">More</span>
            </a>
        </div>
    </section>

    <!-- 3. Three Promotional Cards -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Promo 1: Sound That Moves You (Purple Gradient) -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#4338CA] to-[#6D28D9] text-white p-7 flex flex-col justify-between min-h-[220px] shadow-lg">
            <div class="relative z-10 max-w-[60%]">
                <h3 class="text-lg font-black tracking-tight leading-snug mb-1">
                    Sound That<br>Moves You
                </h3>
                <p class="text-xs text-indigo-100 mb-5 font-medium">
                    Premium audio for every moment.
                </p>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'audio']) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-full bg-purple-600 hover:bg-purple-700 text-white font-bold text-[11px] uppercase tracking-wider transition-colors shadow-md">
                    <span>SHOP AUDIO</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
            <!-- Promo 1 Image -->
            <img src="/images/themes/novatech/nvt-promo-headphones.jpg"
                 alt="Sound That Moves You"
                 class="absolute -right-4 -bottom-4 w-44 h-44 object-contain transition-transform duration-300 hover:scale-105"
                 onerror="this.onerror=null; this.src='/images/products/nvt-noise-headphones.jpg';">
        </div>

        <!-- Promo 2: Light. Fast. Powerful. (Sky/Cyan Gradient) -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#BAE6FD] to-[#E0F2FE] text-slate-900 p-7 flex flex-col justify-between min-h-[220px] shadow-lg">
            <div class="relative z-10 max-w-[60%]">
                <h3 class="text-lg font-black tracking-tight leading-snug mb-1 text-slate-900">
                    Light. Fast.<br>Powerful.
                </h3>
                <p class="text-xs text-slate-600 mb-5 font-medium">
                    Laptops built for speed and performance.
                </p>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'laptops']) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-full bg-sky-600 hover:bg-sky-700 text-white font-bold text-[11px] uppercase tracking-wider transition-colors shadow-md">
                    <span>SHOP LAPTOPS</span>
                </a>
            </div>
            <!-- Promo 2 Image -->
            <img src="/images/themes/novatech/nvt-promo-laptop.jpg"
                 alt="Light Fast Powerful Laptop"
                 class="absolute -right-6 -bottom-6 w-48 h-48 object-contain transition-transform duration-300 hover:scale-105"
                 onerror="this.onerror=null; this.src='/images/products/nvt-ultrabook.jpg';">
        </div>

        <!-- Promo 3: Stay Connected. Stay Ahead. (Indigo/Purple Gradient) -->
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-[#312E81] to-[#4338CA] text-white p-7 flex flex-col justify-between min-h-[220px] shadow-lg">
            <div class="relative z-10 max-w-[60%]">
                <h3 class="text-lg font-black tracking-tight leading-snug mb-1">
                    Stay Connected.<br>Stay Ahead.
                </h3>
                <p class="text-xs text-indigo-200 mb-5 font-medium">
                    Smartwatches for a smarter you.
                </p>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'wearables']) }}" class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[11px] uppercase tracking-wider transition-colors shadow-md">
                    <span>SHOP SMART WATCHES</span>
                </a>
            </div>
            <!-- Promo 3 Image -->
            <img src="/images/themes/novatech/nvt-smart-watch.jpg"
                 alt="Stay Connected Smartwatch"
                 class="absolute -right-4 -bottom-4 w-44 h-44 object-contain transition-transform duration-300 hover:scale-105"
                 onerror="this.onerror=null; this.src='/images/products/nvt-smart-watch.jpg';">
        </div>
    </section>

    <!-- 4. Best Sellers Section -->
    <section>
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight uppercase">
                BEST SELLERS
            </h2>
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'best-sellers']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center space-x-1">
                <span>View All Products</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <!-- 6 Best Sellers Grid Matching Reference -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
            @forelse($products->take(6) as $product)
                @include('store.themes.novatech-electronics.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full py-12 text-center text-slate-400">
                    No products found in Best Sellers.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Trust Strip / Feature Highlights -->
    <section class="bg-[#0B0F19] rounded-2xl border border-slate-800/80 p-6 sm:p-8 text-white shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 divide-y sm:divide-y-0 sm:divide-x divide-slate-800/80">
            <!-- Feature 1 -->
            <div class="flex items-center space-x-4 pt-4 sm:pt-0 sm:pl-4 first:pl-0">
                <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-indigo-400 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 18H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-4a2 2 0 00-2-2h-3m-7 8a2 2 0 100-4 2 2 0 000 4zm10 0a2 2 0 100-4 2 2 0 000 4z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">Free Shipping</h4>
                    <p class="text-xs text-slate-400">On orders over $75</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="flex items-center space-x-4 pt-4 sm:pt-0 sm:pl-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-cyan-400 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">Secure Payment</h4>
                    <p class="text-xs text-slate-400">100% secure checkout</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="flex items-center space-x-4 pt-4 sm:pt-0 sm:pl-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-purple-400 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">Easy Returns</h4>
                    <p class="text-xs text-slate-400">30-day return policy</p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="flex items-center space-x-4 pt-4 sm:pt-0 sm:pl-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-sky-400 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white">24/7 Support</h4>
                    <p class="text-xs text-slate-400">We're here to help</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Newsletter Banner -->
    <section class="rounded-2xl bg-[#0B0F19] border border-slate-800 p-8 sm:p-10 shadow-xl relative overflow-hidden" x-data="{ email: '', submitted: false }">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-6 relative z-10">
            <!-- Left: Icon & Headline -->
            <div class="flex items-center space-x-5 text-center lg:text-left">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 border border-indigo-500/40 neon-glow-cyan flex items-center justify-center text-cyan-400 flex-shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-white tracking-tight uppercase">GET EXCLUSIVE OFFERS</h3>
                    <p class="text-xs text-slate-400 mt-1">Subscribe to get updates on new arrivals, special offers and tech news.</p>
                </div>
            </div>

            <!-- Right: Subscription Form -->
            <div class="w-full lg:w-auto flex-1 max-w-md">
                <form @submit.prevent="submitted = true; CartLS.showToast('Thank you for subscribing to NovaTech updates!'); email = ''" class="flex flex-col sm:flex-row gap-2">
                    <input type="email"
                           x-model="email"
                           required
                           placeholder="Enter your email address"
                           class="flex-1 bg-white text-slate-900 px-4 py-3 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-colors shadow-md">
                        SUBSCRIBE
                    </button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
