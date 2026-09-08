@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $cartUrl = url('online_store/cart') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<!-- Top Promotional Announcement Strip -->
<div x-data="{ bannerOpen: true }"
     x-show="bannerOpen"
     class="bg-gradient-to-r from-amber-500 via-orange-500 to-amber-500 text-white text-xs font-semibold py-2 px-4 shadow-xs relative z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="hidden sm:block w-8"></div>
        <div class="flex-1 text-center flex items-center justify-center gap-3">
            <span>🔥 Summer Sale is Live! Up to 40% OFF on selected items</span>
            <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
               class="inline-block bg-nex-navy hover:bg-black text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider transition">
                Shop Now
            </a>
        </div>
        <button type="button"
                @click="bannerOpen = false"
                class="text-white/80 hover:text-white transition p-1 text-sm font-bold leading-none"
                aria-label="Close banner">
            ✕
        </button>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white border-b border-slate-200/80 sticky top-0 z-40 shadow-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4 lg:gap-8">

            <!-- Left: Mobile Menu Toggle & Brand Logo -->
            <div class="flex items-center gap-3">
                <button type="button"
                        @click="mobileMenuOpen = true"
                        class="p-2 -ml-2 text-nex-navy hover:text-nex-blue transition lg:hidden"
                        aria-label="Open menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Nexora Brand Logo -->
                <a href="{{ $storeUrl }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-orange-500 to-rose-500 text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3H9c0-1.66 1.34-3 3-3zm7 17H5V8h14v12z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-tight text-nex-navy uppercase leading-none">
                            NEXORA
                        </span>
                        <span class="text-[9px] font-extrabold tracking-[0.25em] text-nex-blue uppercase mt-0.5">
                            Shop Different
                        </span>
                    </div>
                </a>
            </div>

            <!-- Middle: Search Bar with Category Dropdown (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-2xl mx-auto" x-data="{ catDropdown: false, selectedCat: 'All Categories' }">
                <form action="{{ url('online_store/shop') }}" method="GET" class="w-full flex items-center bg-slate-100/90 border border-slate-200 rounded-full p-1.5 focus-within:border-nex-blue focus-within:bg-white focus-within:ring-2 focus-within:ring-nex-blue/10 transition-all shadow-inner">
                    @if($previewTheme)
                        <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                    @endif

                    <!-- Category Selector Dropdown -->
                    <div class="relative">
                        <button type="button"
                                @click="catDropdown = !catDropdown"
                                class="px-4 py-1.5 text-xs font-bold text-nex-navy flex items-center gap-1.5 border-r border-slate-300 hover:text-nex-blue transition shrink-0">
                            <span x-text="selectedCat">All Categories</span>
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-cloak
                             x-show="catDropdown"
                             @click.away="catDropdown = false"
                             x-transition
                             class="absolute left-0 mt-2 w-48 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 text-xs">
                            <a href="#" @click.prevent="selectedCat = 'All Categories'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">All Categories</a>
                            <a href="#" @click.prevent="selectedCat = 'Electronics'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Electronics</a>
                            <a href="#" @click.prevent="selectedCat = 'Fashion'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Fashion</a>
                            <a href="#" @click.prevent="selectedCat = 'Home & Living'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Home & Living</a>
                            <a href="#" @click.prevent="selectedCat = 'Beauty'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Beauty</a>
                            <a href="#" @click.prevent="selectedCat = 'Sports'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Sports</a>
                            <a href="#" @click.prevent="selectedCat = 'Toys & Games'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Toys & Games</a>
                            <a href="#" @click.prevent="selectedCat = 'Automotive'; catDropdown = false" class="block px-4 py-2 hover:bg-slate-50 font-medium text-slate-700">Automotive</a>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <input type="text"
                           name="q"
                           placeholder="Search for products, brands and more..."
                           class="flex-1 bg-transparent border-0 px-4 py-1.5 text-xs text-nex-navy placeholder-slate-400 focus:outline-none">

                    <!-- Search Submit Button (Royal Blue / Orange) -->
                    <button type="submit"
                            class="w-9 h-9 rounded-full bg-gradient-to-tr from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white flex items-center justify-center transition shadow-md shrink-0"
                            title="Search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right: Action Icons (Track Order, Wishlist, Cart) -->
            <div class="flex items-center space-x-5 lg:space-x-7 text-nex-navy">

                <!-- Track Order -->
                <a href="{{ $shopUrl }}" class="hidden lg:flex flex-col items-center group text-center" title="Track Order">
                    <div class="relative text-nex-navy group-hover:text-nex-blue transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-slate-700 group-hover:text-nex-blue transition mt-0.5">Track Order</span>
                </a>

                <!-- Wishlist with Badge (3) -->
                <a href="{{ $shopUrl }}" class="flex flex-col items-center group relative text-center" title="Wishlist">
                    <div class="relative text-nex-navy group-hover:text-nex-blue transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2 bg-rose-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-xs">
                            3
                        </span>
                    </div>
                    <span class="hidden sm:block text-[11px] font-bold text-slate-700 group-hover:text-nex-blue transition mt-0.5">Wishlist</span>
                </a>

                <!-- Cart / Shopping Bag with reactive CartLS count -->
                <a href="{{ $cartUrl }}"
                   class="flex flex-col items-center group relative text-center"
                   title="Cart"
                   x-data="{ count: 0 }"
                   x-init="count = (window.CartLS ? window.CartLS.count() : 0); window.addEventListener('cart:changed', () => { count = window.CartLS ? window.CartLS.count() : 0 })">
                    <div class="relative text-nex-navy group-hover:text-nex-blue transition">
                        <svg class="w-6 h-6 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="cart-count absolute -top-1.5 -right-2 bg-orange-500 text-white text-[10px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center shadow-xs leading-none"
                              x-text="count"
                              x-show="count > 0">
                            0
                        </span>
                    </div>
                    <span class="hidden sm:block text-[11px] font-bold text-slate-700 group-hover:text-nex-blue transition mt-0.5">Cart</span>
                </a>

            </div>

        </div>
    </div>

    <!-- Primary Navigation Bar (Deep Navy with Blue hover/active) -->
    <nav class="bg-nex-navy text-white text-xs font-bold tracking-wider uppercase border-t border-white/10 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-12">

                <!-- Left Nav Links with Outline Icons -->
                <div class="flex items-center space-x-7">
                    <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="flex items-center gap-1.5 hover:text-blue-300 transition py-3">
                        <span>☆</span>
                        <span>New In</span>
                    </a>

                    <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="flex items-center gap-1.5 hover:text-blue-300 transition py-3">
                        <span>☆</span>
                        <span>Best Sellers</span>
                    </a>

                    <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="flex items-center gap-1.5 hover:text-amber-400 transition py-3 text-amber-300">
                        <span>◇</span>
                        <span>Deals</span>
                    </a>

                    <a href="{{ $shopUrl }}" class="hover:text-blue-300 transition py-3">
                        Brands
                    </a>

                    <a href="{{ $shopUrl }}" class="flex items-center gap-1.5 hover:text-blue-300 transition py-3">
                        <span>◫</span>
                        <span>Collections</span>
                    </a>

                    <a href="{{ $shopUrl }}" class="hover:text-blue-300 transition py-3">
                        Blog
                    </a>

                    <a href="{{ $shopUrl }}" class="hover:text-blue-300 transition py-3">
                        Contact Us
                    </a>
                </div>

                <!-- Right Nav CTA: Flash Deals -->
                <div class="flex items-center">
                    <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-xs px-4 py-1.5 rounded-full flex items-center gap-1.5 shadow-md uppercase tracking-wider transition">
                        <span>⚡</span>
                        <span>Flash Deals</span>
                    </a>
                </div>

            </div>
        </div>
    </nav>
</header>
