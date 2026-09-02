@php
    $previewTheme = request('preview_theme', 'naturae');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $cartUrl = url('online_store/cart') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<!-- Top Announcement Bar -->
<div class="bg-naturae-dark text-naturae-bg text-xs py-2 px-4 border-b border-white/5">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="hidden md:block w-1/4"></div>
        <div class="flex-1 text-center font-medium tracking-widest text-[11px] uppercase">
            Free Shipping on Orders Over $99
        </div>
        <div class="w-auto md:w-1/4 text-right flex items-center justify-end gap-1 text-[11px] text-naturae-bg/80 hover:text-white cursor-pointer transition">
            <span>Ship to: <strong class="text-white">United States</strong></span>
            <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>

<!-- Main Sticky Header -->
<header class="bg-white/95 backdrop-blur-md sticky top-0 z-40 border-b border-naturae-border/70 transition-all duration-300 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Mobile Menu Toggle -->
            <div class="flex items-center lg:hidden">
                <button type="button"
                        @click="mobileMenuOpen = true"
                        class="p-2 -ml-2 text-naturae-forest hover:text-naturae-sage transition focus:outline-none"
                        aria-label="Open menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Brand Logo -->
            <div class="flex items-center">
                <a href="{{ $storeUrl }}" class="flex items-center gap-2.5 group">
                    <!-- Clean Leaf Mark -->
                    <div class="w-8 h-8 rounded-full bg-naturae-forest text-white flex items-center justify-center transition-transform group-hover:scale-105 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A9.49 9.49 0 0 0 12 21a10 10 0 0 0 10-10c0-1.5-.32-2.92-.88-4.21A10.74 10.74 0 0 0 17 8zm-4.32 10.94a7.51 7.51 0 0 1-3.68-1.57C11.39 12.87 13.9 9.5 17 8.2a8 8 0 0 1-4.32 10.74z" />
                        </svg>
                    </div>
                    <!-- Brand Name -->
                    <span class="font-serif text-2xl font-bold tracking-[0.2em] text-naturae-forest uppercase group-hover:text-naturae-green transition">
                        NATURAE
                    </span>
                </a>
            </div>

            <!-- Desktop Centered Navigation -->
            <nav class="hidden lg:flex items-center space-x-7 xl:space-x-8 text-[13px] font-medium tracking-widest uppercase text-naturae-text/90">
                <a href="{{ $shopUrl }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    Shop All
                </a>
                <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    New Arrivals
                </a>
                <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    Best Sellers
                </a>
                <a href="{{ url('online_store/shop?category=Wellness' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    Wellness
                </a>
                <a href="{{ url('online_store/shop?category=Home+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    Home & Living
                </a>
                <a href="{{ url('online_store/shop?category=Skincare' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-sage transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-forest after:absolute after:bottom-0 after:left-0 after:w-0">
                    Beauty
                </a>
                <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="text-naturae-sage hover:text-naturae-forest font-semibold transition py-2 relative hover:after:w-full after:transition-all after:h-[1.5px] after:bg-naturae-sage after:absolute after:bottom-0 after:left-0 after:w-0">
                    Sale
                </a>
            </nav>

            <!-- Right Utility Actions -->
            <div class="flex items-center space-x-4 sm:space-x-5 text-naturae-forest">

                <!-- Search Toggle -->
                <div x-data="{ searchOpen: false }" class="relative">
                    <button type="button"
                            @click="searchOpen = !searchOpen"
                            class="p-2 text-naturae-forest hover:text-naturae-sage transition focus:outline-none"
                            title="Search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Search Popup Input -->
                    <div x-cloak
                         x-show="searchOpen"
                         @click.away="searchOpen = false"
                         x-transition
                         class="absolute right-0 mt-3 w-80 bg-white border border-naturae-border rounded-xl shadow-xl p-3 z-50">
                        <form action="{{ url('online_store/shop') }}" method="GET" class="relative">
                            @if($previewTheme)
                                <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                            @endif
                            <input type="text"
                                   name="q"
                                   placeholder="Search organic botanicals..."
                                   class="w-full bg-naturae-bg/80 border border-naturae-border rounded-lg pl-3.5 pr-9 py-2 text-xs text-naturae-text focus:outline-none focus:border-naturae-forest focus:bg-white transition"
                                   autofocus>
                            <button type="submit" class="absolute right-2.5 top-2.5 text-naturae-muted hover:text-naturae-forest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Account Icon -->
                <a href="{{ $shopUrl }}" class="p-2 text-naturae-forest hover:text-naturae-sage transition hidden sm:block" title="My Account">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>

                <!-- Shopping Bag / Cart with reactive cart-count -->
                <a href="{{ $cartUrl }}"
                   class="p-2 text-naturae-forest hover:text-naturae-sage transition relative flex items-center group"
                   title="Shopping Bag"
                   x-data="{ count: 0 }"
                   x-init="count = (window.CartLS ? window.CartLS.count() : 0); window.addEventListener('cart:changed', () => { count = window.CartLS ? window.CartLS.count() : 0 })">
                    <svg class="w-5 h-5 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="cart-count absolute top-1 right-1 bg-naturae-forest text-white text-[10px] font-bold min-w-[16px] h-4 px-1 rounded-full flex items-center justify-center leading-none shadow-sm"
                          x-text="count"
                          x-show="count > 0">
                        0
                    </span>
                </a>

            </div>
        </div>
    </div>
</header>
