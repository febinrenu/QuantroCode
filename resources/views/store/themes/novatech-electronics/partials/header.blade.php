<header class="w-full bg-white sticky top-0 z-40 shadow-sm" x-data="{ browseCategoriesOpen: false, searchCat: 'All Categories' }">
    <!-- 1. Top Announcement Bar -->
    <div class="bg-gradient-to-r from-[#1E1B4B] via-[#4338CA] to-[#6366F1] text-white text-xs py-2 px-4 sm:px-6 lg:px-8 border-b border-indigo-900/40">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center space-x-3 text-center sm:text-left">
                <span class="flex items-center gap-1.5 font-medium text-slate-100">
                    <span class="text-amber-300">🔥</span>
                    <strong>TECH WEEK SALE:</strong> Up to 30% OFF on selected items!
                </span>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-white text-indigo-900 font-bold text-[11px] hover:bg-indigo-50 transition-colors shadow-sm">
                    Shop Deals
                </a>
            </div>
            <div class="flex items-center space-x-6 text-slate-200 text-[11px]">
                <a href="#" class="hover:text-white transition-colors">Support</a>
                <span class="text-indigo-300/40">|</span>
                <a href="#" class="hover:text-white transition-colors">Store Locator</a>
                <span class="text-indigo-300/40">|</span>
                <div class="flex items-center space-x-1 cursor-pointer hover:text-white transition-colors">
                    <span>Eng</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Header (Logo, Search, Actions) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between gap-4 lg:gap-8">
            <!-- Mobile Menu Toggle Button -->
            <button @click="mobileNavOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors" aria-label="Open mobile menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Brand Logo -->
            <a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="flex items-center space-x-3 flex-shrink-0 group">
                <!-- Geometric Stylized Gradient N Logo -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 via-blue-600 to-cyan-400 p-0.5 shadow-md shadow-indigo-500/20 flex items-center justify-center">
                    <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center p-1.5">
                        <svg class="w-full h-full" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 22V6L13 18V6H17V22L9 10V22H5Z" fill="url(#novatech_logo_grad)" />
                            <path d="M19 6H23V22H19V6Z" fill="#06B6D4" opacity="0.9" />
                            <defs>
                                <linearGradient id="novatech_logo_grad" x1="5" y1="6" x2="23" y2="22" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#818CF8" />
                                    <stop offset="0.5" stop-color="#6366F1" />
                                    <stop offset="1" stop-color="#06B6D4" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors leading-none">NOVATECH</span>
                    <span class="text-[9px] font-bold tracking-widest text-slate-400 uppercase mt-0.5">SMARTER EVERYDAY</span>
                </div>
            </a>

            <!-- Search Bar with Category Dropdown -->
            <div class="hidden md:flex flex-1 max-w-2xl relative">
                <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-center rounded-full border-2 border-slate-200 hover:border-indigo-400 focus-within:border-indigo-600 transition-all bg-white p-1 shadow-sm">
                    <input type="hidden" name="preview_theme" value="novatech">

                    <!-- Category Selector Dropdown -->
                    <div class="relative flex-shrink-0" x-data="{ open: false }">
                        <button type="button" @click="open = !open" @click.away="open = false" class="flex items-center space-x-1.5 text-xs font-bold text-slate-800 bg-slate-100 hover:bg-slate-200 py-2 px-3.5 rounded-full transition-colors">
                            <span x-text="searchCat">All Categories</span>
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" x-cloak class="absolute left-0 top-full mt-2 w-52 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50 text-xs font-medium">
                            <a href="#" @click.prevent="searchCat = 'All Categories'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">All Categories</a>
                            <a href="#" @click.prevent="searchCat = 'Laptops'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Laptops</a>
                            <a href="#" @click.prevent="searchCat = 'Smartphones'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Smartphones</a>
                            <a href="#" @click.prevent="searchCat = 'Wearables'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Wearables</a>
                            <a href="#" @click.prevent="searchCat = 'Audio'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Audio</a>
                            <a href="#" @click.prevent="searchCat = 'Gaming'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Gaming</a>
                            <a href="#" @click.prevent="searchCat = 'Cameras'; open = false" class="block px-4 py-2 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600">Cameras</a>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search for products, brands..." class="flex-1 px-4 py-2 text-xs text-slate-900 placeholder-slate-400 bg-transparent border-none focus:outline-none">

                    <!-- Search Submit Button -->
                    <button type="submit" class="w-9 h-9 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white flex items-center justify-center flex-shrink-0 transition-colors shadow-sm" aria-label="Search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Header Actions: Compare, Wishlist, Cart -->
            <div class="flex items-center space-x-5 sm:space-x-7">
                <!-- Compare -->
                <a href="#" class="hidden sm:flex flex-col items-center text-slate-700 hover:text-indigo-600 transition-colors group">
                    <svg class="w-6 h-6 text-slate-700 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    <span class="text-[11px] font-semibold mt-1">Compare</span>
                </a>

                <!-- Wishlist -->
                <a href="#" class="flex flex-col items-center text-slate-700 hover:text-indigo-600 transition-colors relative group">
                    <div class="relative">
                        <svg class="w-6 h-6 text-slate-700 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2 w-4 h-4 rounded-full bg-indigo-600 text-white text-[10px] font-bold flex items-center justify-center">3</span>
                    </div>
                    <span class="text-[11px] font-semibold mt-1 hidden sm:inline">Wishlist</span>
                </a>

                <!-- Cart -->
                <button @click="miniCartOpen = true" class="flex flex-col items-center text-slate-700 hover:text-indigo-600 transition-colors relative group">
                    <div class="relative">
                        <svg class="w-6 h-6 text-slate-700 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-1.5 -right-2 w-4 h-4 rounded-full bg-indigo-600 text-white text-[10px] font-bold flex items-center justify-center" x-text="cartCount > 0 ? cartCount : 2"></span>
                    </div>
                    <span class="text-[11px] font-semibold mt-1 hidden sm:inline">Cart</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 3. Navigation Bar -->
    <div class="border-t border-slate-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-12">
                <!-- Left: Browse Categories Button -->
                <div class="relative" x-data="{ catOpen: false }">
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="flex items-center space-x-2.5 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-t-lg font-bold text-xs uppercase tracking-wider transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Browse Categories</span>
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center space-x-8 text-xs font-bold tracking-wider text-slate-800 uppercase">
                    <a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="text-indigo-600 hover:text-indigo-700 transition-colors py-3 border-b-2 border-indigo-600">HOME</a>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="hover:text-indigo-600 transition-colors py-3">SHOP</a>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'new-arrivals']) }}" class="hover:text-indigo-600 transition-colors py-3">NEW ARRIVALS</a>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'best-sellers']) }}" class="hover:text-indigo-600 transition-colors py-3">BEST SELLERS</a>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="hover:text-indigo-600 transition-colors py-3">BRANDS</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors py-3">BLOG</a>
                </nav>

                <!-- Right: Today's Deals Pill Button -->
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'deals']) }}" class="hidden sm:inline-flex items-center space-x-1.5 px-4 py-2 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md shadow-purple-500/20">
                    <span class="text-amber-300">⚡</span>
                    <span>TODAY'S DEALS</span>
                </a>
            </div>
        </div>
    </div>
</header>
