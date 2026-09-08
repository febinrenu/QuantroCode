@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<header class="sticky top-0 z-40 bg-verde-bg/95 backdrop-blur-md border-b border-verde-borderLight transition-all">
    <!-- Top Announcement Bar -->
    <div class="bg-[#2D3A22] text-[#F3EFEA] text-xs font-medium py-2 px-4 sm:px-8 border-b border-[#3E4E30]">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-1.5 text-center md:text-left">
            <!-- Left Promo -->
            <div class="flex items-center justify-center md:justify-start gap-1.5 opacity-90">
                <svg class="w-3.5 h-3.5 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Free Shipping on Orders Over $75</span>
            </div>

            <!-- Center Mission Tagline -->
            <div class="hidden sm:flex items-center justify-center gap-1.5 text-emerald-200/90 font-serif italic text-sm">
                <span>🌱 Sustainable. Ethical. Yours.</span>
            </div>

            <!-- Right Quick Utilities -->
            <div class="hidden md:flex items-center justify-end gap-4 text-xs text-stone-300 opacity-90">
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-white transition-colors">Help</a>
                <span class="text-stone-500">|</span>
                <a href="{{ url('/online_store/account/orders' . $previewParam) }}" class="hover:text-white transition-colors">Track Order</a>
                <span class="text-stone-500">|</span>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-white transition-colors">Returns & Exchanges</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Left: Mobile Menu Toggle & Brand Logo -->
            <div class="flex items-center gap-4">
                <!-- Mobile Hamburger -->
                <button type="button" 
                        class="lg:hidden p-2 rounded-lg text-verde-primary hover:bg-verde-sand transition-colors"
                        @click="mobileMenu = true"
                        aria-label="Open navigation menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Brand Logo: Emblem + Typography -->
                <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-full border border-verde-primary/40 flex items-center justify-center group-hover:border-verde-primary transition-colors bg-white/80 shadow-xs">
                        <svg class="w-6 h-6 text-verde-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="1.2" stroke-dasharray="1 1" class="opacity-60"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 21V10M12 10C12 5.5 16 3 19 3C19 7 17 11 12 14C7 11 5 7 5 3C8 3 12 5.5 12 10z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-2xl tracking-[0.18em] font-bold text-verde-dark leading-none">VERDE</span>
                        <span class="text-[0.62rem] tracking-[0.3em] text-verde-muted font-bold mt-1 uppercase">L I V I N G</span>
                    </div>
                </a>
            </div>

            <!-- Center: Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-7 text-[0.88rem] font-medium text-stone-700">
                <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" 
                   class="hover:text-verde-primary transition-colors py-2 relative">
                    New In
                </a>

                <!-- Shop Dropdown -->
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                       class="hover:text-verde-primary transition-colors py-2 flex items-center gap-1">
                        <span>Shop</span>
                        <svg class="w-3.5 h-3.5 text-stone-400 group-hover:text-verde-primary transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-cloak x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 top-full mt-1 w-52 bg-white rounded-xl shadow-xl border border-verde-border p-2 z-50">
                        <a href="{{ url('/online_store/shop' . $previewParam) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors font-medium">All Products</a>
                        <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Best Sellers</a>
                        <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Home & Decor</a>
                        <a href="{{ url('/online_store/shop?category=cleaning-essentials' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Cleaning Essentials</a>
                        <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Bath & Body</a>
                        <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Kitchen & Dining</a>
                    </div>
                </div>

                <!-- Collections Dropdown -->
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" 
                       class="hover:text-verde-primary transition-colors py-2 flex items-center gap-1">
                        <span>Collections</span>
                        <svg class="w-3.5 h-3.5 text-stone-400 group-hover:text-verde-primary transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-cloak x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 top-full mt-1 w-56 bg-white rounded-xl shadow-xl border border-verde-border p-2 z-50">
                        <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors font-medium">Best Sellers</a>
                        <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">New Arrivals</a>
                        <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Sustainable Living</a>
                        <a href="{{ url('/online_store/shop?category=cleaning-essentials' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Zero-Waste Sets</a>
                    </div>
                </div>

                <!-- Home & Decor Dropdown -->
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" 
                       class="hover:text-verde-primary transition-colors py-2 flex items-center gap-1">
                        <span>Home & Decor</span>
                        <svg class="w-3.5 h-3.5 text-stone-400 group-hover:text-verde-primary transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div x-cloak x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 top-full mt-1 w-52 bg-white rounded-xl shadow-xl border border-verde-border p-2 z-50">
                        <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors font-medium">All Home Decor</a>
                        <a href="{{ url('/online_store/shop?q=cushion' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Cushions & Throws</a>
                        <a href="{{ url('/online_store/shop?q=candle' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Candles & Diffusers</a>
                        <a href="{{ url('/online_store/shop?q=vase' . $previewAmp) }}" class="block px-3 py-2 text-sm text-stone-700 hover:bg-verde-sand hover:text-verde-primary rounded-lg transition-colors">Vases & Ceramics</a>
                    </div>
                </div>

                <a href="{{ url('/online_store/shop?category=beauty' . $previewAmp) }}" 
                   class="hover:text-verde-primary transition-colors py-2">
                    Beauty
                </a>
                <a href="{{ url('/online_store/shop?category=gifts-sets' . $previewAmp) }}" 
                   class="hover:text-verde-primary transition-colors py-2">
                    Gifts
                </a>
                <a href="{{ url('/online_store/shop?collection=journal' . $previewAmp) }}" 
                   class="hover:text-verde-primary transition-colors py-2">
                    Journal
                </a>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" 
                   class="hover:text-verde-primary transition-colors py-2">
                    About Us
                </a>
            </nav>

            <!-- Right: Action Icons (Search, Account, Wishlist, Cart) -->
            <div class="flex items-center gap-3 sm:gap-4" x-data="miniCart()">
                <!-- Search Trigger -->
                <button type="button" 
                        class="p-2 text-stone-700 hover:text-verde-primary hover:bg-verde-sand rounded-full transition-colors"
                        @click="searchOpen = !searchOpen"
                        aria-label="Search store">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Account -->
                <a href="{{ url('/online_store/account' . $previewParam) }}" 
                   class="p-2 text-stone-700 hover:text-verde-primary hover:bg-verde-sand rounded-full transition-colors"
                   aria-label="My Account">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>

                <!-- Wishlist with reference badge "2" -->
                <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" 
                   class="relative p-2 text-stone-700 hover:text-verde-primary hover:bg-verde-sand rounded-full transition-colors"
                   aria-label="Wishlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-4 h-4 bg-verde-primary text-white text-[0.62rem] font-bold rounded-full flex items-center justify-center shadow-xs">
                        2
                    </span>
                </a>

                <!-- Cart / Bag with dynamic count -->
                <a href="{{ url('/online_store/cart' . $previewParam) }}" 
                   class="relative p-2 text-stone-700 hover:text-verde-primary hover:bg-verde-sand rounded-full transition-colors"
                   aria-label="Shopping Bag">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-4 h-4 bg-verde-primary text-white text-[0.62rem] font-bold rounded-full flex items-center justify-center shadow-xs"
                          x-text="count">
                        0
                    </span>
                </a>
            </div>
        </div>

        <!-- Search Bar Dropdown Overlay -->
        <div x-cloak x-show="searchOpen" 
             @click.away="searchOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="pb-4 pt-1">
            <form action="{{ url('/online_store/shop') }}" method="GET" class="relative max-w-2xl mx-auto">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                <div class="relative flex items-center">
                    <input type="text" 
                           name="q" 
                           placeholder="Search natural home, skincare, bath & body..." 
                           class="w-full bg-white text-stone-900 placeholder-stone-400 pl-11 pr-24 py-3 rounded-full border border-verde-border focus:outline-hidden focus:border-verde-primary focus:ring-2 focus:ring-verde-primary/10 text-sm shadow-xs transition-all">
                    <div class="absolute left-4 text-stone-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <button type="submit" 
                            class="absolute right-1.5 px-4 py-2 bg-verde-btn hover:bg-verde-btnHover text-white text-xs font-semibold rounded-full transition-colors">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
