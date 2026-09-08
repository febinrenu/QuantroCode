@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<header class="w-full bg-white sticky top-0 z-40 shadow-sm border-b border-homely-borderLight">
    <!-- 1. Top Announcement Bar -->
    <div class="bg-homely-primaryDark text-stone-200 text-xs py-2 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2 font-medium tracking-wide">
                <span>🌿</span>
                <span>10% OFF your first order | Use code: <strong class="text-white">WELCOME10</strong></span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-stone-300 text-xs">
                <span>Sustainably sourced</span>
                <span>•</span>
                <span>Plastic free packaging</span>
                <span>•</span>
                <span>Ethically made</span>
                <div class="flex items-center gap-1.5 ml-2 text-stone-400">
                    <button class="hover:text-white transition-colors" aria-label="Previous promo">&lsaquo;</button>
                    <button class="hover:text-white transition-colors" aria-label="Next promo">&rsaquo;</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Header Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3.5 flex items-center justify-between gap-4 md:gap-8">
        <!-- Mobile Menu Trigger -->
        <button type="button" 
                class="lg:hidden p-2 text-homely-text hover:text-homely-primary focus:outline-none"
                @click="mobileMenuOpen = true"
                aria-label="Open mobile menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Brand Logo -->
        <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-3 group flex-shrink-0">
            <!-- Leaf in House Emblem -->
            <div class="w-10 h-10 rounded-lg border border-homely-primary/20 flex items-center justify-center text-homely-primary bg-homely-sand group-hover:bg-homely-primary group-hover:text-white transition-colors">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 18V12c0-2 2-3 4-3" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 14c-1.5 0-3-1-3-3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="font-serif text-2xl font-bold tracking-wider text-homely-primary leading-tight">HOMELY</span>
                <span class="text-[9px] font-semibold tracking-[0.25em] text-homely-muted uppercase">LIVE BEAUTIFULLY</span>
            </div>
        </a>

        <!-- Search Bar (Center) -->
        <div class="flex-1 max-w-xl mx-auto hidden md:block">
            <form action="{{ url('/online_store/shop' . $previewParam) }}" method="GET" class="relative flex items-center">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}"
                       placeholder="Search for products, categories..." 
                       class="w-full pl-5 pr-14 py-2.5 rounded-full border border-homely-border bg-stone-50/70 text-sm text-homely-text placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-homely-primary/20 focus:border-homely-primary transition-all">
                <button type="submit" 
                        class="absolute right-1.5 w-9 h-9 rounded-full bg-homely-terracotta hover:bg-homely-terracottaHover text-white flex items-center justify-center transition-colors shadow-sm"
                        aria-label="Submit search">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Header Actions (Right) -->
        <div class="flex items-center gap-5 sm:gap-7 flex-shrink-0 text-homely-text">
            <!-- Account -->
            <a href="#" class="hidden sm:flex flex-col items-center gap-0.5 text-xs text-stone-600 hover:text-homely-primary transition-colors">
                <svg class="w-5 h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-[11px] font-medium">Account</span>
            </a>

            <!-- Wishlist -->
            <a href="#" class="hidden sm:flex flex-col items-center gap-0.5 text-xs text-stone-600 hover:text-homely-primary transition-colors relative">
                <div class="relative">
                    <svg class="w-5 h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="absolute -top-1.5 -right-2 w-4 h-4 bg-homely-terracotta text-white rounded-full text-[9px] font-bold flex items-center justify-center">2</span>
                </div>
                <span class="text-[11px] font-medium">Wishlist</span>
            </a>

            <!-- Cart Bag -->
            <a href="{{ url('/online_store/cart' . $previewParam) }}" class="flex flex-col items-center gap-0.5 text-xs text-stone-600 hover:text-homely-primary transition-colors relative">
                <div class="relative">
                    <svg class="w-5 h-5 text-stone-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="absolute -top-1.5 -right-2.5 w-4 h-4 bg-homely-terracotta text-white rounded-full text-[9px] font-bold flex items-center justify-center"
                          x-text="cart.totalCount">3</span>
                </div>
                <span class="text-[11px] font-medium">Cart</span>
            </a>
        </div>
    </div>

    <!-- 3. Navigation Bar (Desktop) -->
    <nav class="hidden lg:block border-t border-homely-borderLight bg-white">
        <div class="max-w-7xl mx-auto px-8 flex items-center justify-center gap-8 text-sm font-medium">
            <a href="{{ url('/online_store' . $previewParam) }}" 
               class="py-3 border-b-2 font-semibold transition-colors {{ request()->is('online_store') && !request('category') && !request('collection') ? 'border-homely-terracotta text-homely-primary' : 'border-transparent text-stone-700 hover:text-homely-primary' }}">
                Shop All
            </a>
            <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                New In
            </a>
            <a href="{{ url('/online_store/shop?category=home-living' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Home & Living
            </a>
            <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Kitchen & Dining
            </a>
            <a href="{{ url('/online_store/shop?category=furniture' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Furniture
            </a>
            <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Bath & Body
            </a>
            <a href="{{ url('/online_store/shop?category=decor' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Decor
            </a>
            <a href="{{ url('/online_store/shop?category=indoor-plants' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-stone-700 hover:text-homely-primary transition-colors">
                Plants
            </a>
            <a href="{{ url('/online_store/shop?collection=sale' . $previewAmp) }}" 
               class="py-3 border-b-2 border-transparent text-homely-terracotta hover:text-homely-terracottaHover font-semibold transition-colors">
                Sale
            </a>
        </div>
    </nav>
</header>
