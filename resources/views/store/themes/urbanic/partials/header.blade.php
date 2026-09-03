@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $cartUrl = url('online_store/cart') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $womenUrl = url('online_store/shop?category=Women' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $menUrl = url('online_store/shop?category=Men' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $kidsUrl = url('online_store/shop?category=Kids' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $shoesUrl = url('online_store/shop?category=Shoes' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $bagsUrl = url('online_store/shop?category=Bags' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $accUrl = url('online_store/shop?category=Accessories' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $newArrivalsUrl = url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $saleUrl = url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
@endphp

<header class="w-full bg-white z-40 border-b border-slate-200/80">

    <!-- 1. Top Announcement Bar (Dark Bar) -->
    <div class="bg-urb-dark text-white text-[11px] sm:text-xs py-2 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            <!-- Left Announcement & CTA -->
            <div class="flex items-center gap-2.5">
                <span class="font-medium text-slate-200">
                    🔥 Hot Summer Sale! Up to 50% OFF on selected styles
                </span>
                <a href="{{ $saleUrl }}"
                   class="inline-flex items-center gap-1 px-3 py-0.5 bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-[10px] uppercase tracking-wider rounded-full transition shadow-xs">
                    <span>Shop Now</span>
                    <span>🔥</span>
                </a>
            </div>

            <!-- Right Utility Links -->
            <div class="hidden md:flex items-center space-x-5 text-slate-300 text-[11px]">
                <a href="{{ $shopUrl }}" class="hover:text-white transition">Store Locator</a>
                <span class="text-slate-600">|</span>
                <a href="{{ $shopUrl }}" class="hover:text-white transition">Help & Support</a>
                <span class="text-slate-600">|</span>
                <div class="flex items-center gap-1 cursor-pointer hover:text-white transition">
                    <span>EN</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. Main Middle Header Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4">
        <div class="flex items-center justify-between gap-4 sm:gap-8">

            <!-- Left: Mobile Menu Toggle & Brand Logo -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Hamburger Button (Mobile) -->
                <button type="button"
                        @click="mobileMenuOpen = true"
                        class="p-2 -ml-2 rounded-lg text-slate-700 hover:text-orange-500 hover:bg-slate-100 transition lg:hidden"
                        aria-label="Open Navigation Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Brand Logo: URBANIC STAY STYLISH -->
                <a href="{{ $storeUrl }}" class="flex flex-col group shrink-0">
                    <span class="text-2xl sm:text-3xl font-black tracking-tight text-urb-dark leading-none group-hover:text-orange-500 transition-colors">
                        URBANIC
                    </span>
                    <span class="text-[9px] sm:text-[10px] font-extrabold tracking-[0.25em] text-slate-500 uppercase mt-0.5">
                        Stay Stylish
                    </span>
                </a>
            </div>

            <!-- Center: Search Input Bar -->
            <div class="flex-1 max-w-2xl hidden sm:block">
                <form action="{{ $shopUrl }}" method="GET" class="relative flex items-center">
                    @if($previewTheme)
                        <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                    @endif
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Search for products, brands and more..."
                           class="w-full bg-slate-100/90 hover:bg-slate-100 focus:bg-white text-xs sm:text-sm text-urb-dark placeholder-slate-400 rounded-full pl-5 pr-14 py-2.5 sm:py-3 border border-slate-200 focus:border-orange-500 focus:outline-none transition shadow-xs">

                    <button type="submit"
                            class="absolute right-1.5 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-orange-500 hover:bg-orange-600 text-white flex items-center justify-center transition shadow-xs"
                            aria-label="Search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right Actions: Sign In, Wishlist, Cart -->
            <div class="flex items-center space-x-4 sm:space-x-6 shrink-0">

                <!-- Sign In / Register -->
                <a href="{{ $shopUrl }}" class="hidden md:flex flex-col items-center group text-slate-700 hover:text-orange-500 transition">
                    <svg class="w-5 h-5 text-slate-600 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-[10px] font-bold mt-1 text-slate-600 group-hover:text-orange-500">Sign In / Register</span>
                </a>

                <!-- Wishlist -->
                <a href="{{ $shopUrl }}" class="hidden sm:flex flex-col items-center group text-slate-700 hover:text-orange-500 transition relative">
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-600 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2.5 w-4 h-4 rounded-full bg-orange-500 text-white text-[9px] font-black flex items-center justify-center">2</span>
                    </div>
                    <span class="text-[10px] font-bold mt-1 text-slate-600 group-hover:text-orange-500">Wishlist</span>
                </a>

                <!-- Cart / Bag with Live Alpine Badge -->
                <a href="{{ $cartUrl }}" class="flex flex-col items-center group text-slate-700 hover:text-orange-500 transition relative">
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-600 group-hover:text-orange-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2.5 w-4 h-4 rounded-full bg-orange-500 text-white text-[9px] font-black flex items-center justify-center"
                              x-text="cartCount"></span>
                    </div>
                    <span class="text-[10px] font-bold mt-1 text-slate-600 group-hover:text-orange-500">Cart</span>
                </a>

            </div>

        </div>

        <!-- Mobile Search Bar (Below Logo on Small Devices) -->
        <div class="mt-3 sm:hidden">
            <form action="{{ $shopUrl }}" method="GET" class="relative flex items-center">
                @if($previewTheme)
                    <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                @endif
                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Search products..."
                       class="w-full bg-slate-100 text-xs text-urb-dark placeholder-slate-400 rounded-full pl-4 pr-10 py-2 border border-slate-200 focus:outline-none">
                <button type="submit"
                        class="absolute right-1 w-7 h-7 rounded-full bg-orange-500 text-white flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- 3. Primary Category Navigation Bar (White Bar with Icons) -->
    <div class="hidden lg:block border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center justify-center space-x-7 py-2.5 text-xs font-bold text-slate-700 tracking-wide">

                <!-- Women -->
                <a href="{{ $womenUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>👗</span>
                    <span>WOMEN</span>
                </a>

                <!-- Men -->
                <a href="{{ $menUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>👔</span>
                    <span>MEN</span>
                </a>

                <!-- Kids -->
                <a href="{{ $kidsUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>🧒</span>
                    <span>KIDS</span>
                </a>

                <!-- Shoes -->
                <a href="{{ $shoesUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>👟</span>
                    <span>SHOES</span>
                </a>

                <!-- Bags -->
                <a href="{{ $bagsUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>👜</span>
                    <span>BAGS</span>
                </a>

                <!-- Accessories -->
                <a href="{{ $accUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>⌚</span>
                    <span>ACCESSORIES</span>
                </a>

                <!-- Brands -->
                <a href="{{ $shopUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>🏷️</span>
                    <span>BRANDS</span>
                </a>

                <!-- New Arrivals -->
                <a href="{{ $newArrivalsUrl }}" class="flex items-center gap-1.5 hover:text-orange-500 transition-colors">
                    <span>⭐</span>
                    <span>NEW ARRIVALS</span>
                </a>

                <!-- SALE Badge -->
                <a href="{{ $saleUrl }}" class="flex items-center gap-1 px-3 py-1 bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-[11px] rounded-full transition shadow-xs">
                    <span>⭐</span>
                    <span>SALE</span>
                </a>

            </nav>
        </div>
    </div>

</header>
