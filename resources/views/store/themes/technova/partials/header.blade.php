@php
    $previewTheme = request('preview_theme', 'technova');
    $currentCategory = request('category', '');
    $cartCount = count($cart ?? []);

    // Helper function for appending preview_theme
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };
@endphp

<!-- Top Promotional Bar -->
<div class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-2">
        <div class="flex items-center space-x-3 text-center md:text-left">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white uppercase tracking-wider">
                Summer Tech Sale
            </span>
            <span class="text-white font-medium">Up to 40% OFF</span>
            <span class="hidden sm:inline text-slate-500">|</span>
            <span class="hidden sm:inline text-slate-400">Free Express Shipping on Orders $49+</span>
        </div>
        <div class="flex items-center space-x-6 text-slate-400">
            <a href="{{ $themeUrl('online_store/shop', ['collection' => 'deals']) }}" class="hover:text-white transition">Track Order</a>
            <a href="{{ $themeUrl('online_store/shop', ['collection' => 'support']) }}" class="hover:text-white transition">Help Center</a>
            <div class="flex items-center space-x-1 cursor-pointer hover:text-white transition">
                <span>🇺🇸 English ($ USD)</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm" x-data="{ catMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4 md:gap-8">
            <!-- Mobile Menu Toggle Button -->
            <button @click="$dispatch('toggle-mobile-nav')" class="lg:hidden p-2 rounded-lg text-slate-600 hover:text-blue-600 hover:bg-slate-100 focus:outline-none" aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Brand Logo -->
            <a href="{{ $themeUrl('online_store') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight font-heading flex items-center">
                        Tech<span class="text-blue-600">Nova</span>
                    </span>
                    <span class="block text-[10px] font-semibold text-slate-400 tracking-widest uppercase -mt-1">
                        Electronics
                    </span>
                </div>
            </a>

            <!-- Search Bar + Category Dropdown -->
            <div class="hidden md:flex flex-1 max-w-2xl">
                <form action="{{ url('online_store/shop') }}" method="GET" class="w-full flex items-center bg-slate-100 rounded-xl border border-slate-200 focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-100 transition">
                    @if($previewTheme)
                        <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                    @endif
                    <div class="relative flex-shrink-0 border-r border-slate-200">
                        <select name="category" class="appearance-none bg-transparent pl-4 pr-8 py-2.5 text-xs font-semibold text-slate-700 focus:outline-none cursor-pointer">
                            <option value="">All Categories</option>
                            <option value="Smartphones" {{ request('category') === 'Smartphones' ? 'selected' : '' }}>Smartphones</option>
                            <option value="Laptops" {{ request('category') === 'Laptops' ? 'selected' : '' }}>Laptops</option>
                            <option value="Tablets" {{ request('category') === 'Tablets' ? 'selected' : '' }}>Tablets</option>
                            <option value="Audio" {{ request('category') === 'Audio' ? 'selected' : '' }}>Audio</option>
                            <option value="Gaming" {{ request('category') === 'Gaming' ? 'selected' : '' }}>Gaming</option>
                            <option value="Cameras" {{ request('category') === 'Cameras' ? 'selected' : '' }}>Cameras</option>
                            <option value="Smart Home" {{ request('category') === 'Smart Home' ? 'selected' : '' }}>Smart Home</option>
                            <option value="Accessories" {{ request('category') === 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                    <input type="text" name="q" value="{{ request('q', '') }}" placeholder="Search 15,000+ tech products, brands, models..." class="w-full bg-transparent px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none" />
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-r-xl transition flex items-center justify-center font-medium" aria-label="Search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Action Icons (Account, Wishlist, Cart) -->
            <div class="flex items-center space-x-4 sm:space-x-6">
                <!-- Account -->
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'account']) }}" class="flex items-center gap-2 text-slate-700 hover:text-blue-600 transition group">
                    <div class="w-9 h-9 rounded-full bg-slate-100 group-hover:bg-blue-50 flex items-center justify-center text-slate-600 group-hover:text-blue-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="hidden xl:block text-left">
                        <span class="block text-[11px] text-slate-400 leading-tight">Welcome</span>
                        <span class="block text-xs font-bold text-slate-800 group-hover:text-blue-600 leading-tight">Sign In / Account</span>
                    </div>
                </a>

                <!-- Wishlist -->
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'wishlist']) }}" class="hidden sm:flex items-center gap-2 text-slate-700 hover:text-blue-600 transition group" title="Wishlist">
                    <div class="w-9 h-9 rounded-full bg-slate-100 group-hover:bg-blue-50 flex items-center justify-center text-slate-600 group-hover:text-blue-600 transition relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </a>

                <!-- Cart -->
                <a href="{{ $themeUrl('online_store/cart') }}" class="flex items-center gap-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 px-3.5 py-2 rounded-xl border border-blue-200 transition group">
                    <div class="relative">
                        <svg class="w-5 h-5 text-blue-600 group-hover:scale-110 transition transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm" x-text="$store?.cart?.count ?? {{ $cartCount }}">
                            {{ $cartCount }}
                        </span>
                    </div>
                    <div class="hidden sm:block text-left">
                        <span class="block text-[10px] text-blue-500 font-medium leading-none">Cart</span>
                        <span class="block text-xs font-bold text-blue-900 leading-tight">View Bag</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Primary Navigation Strip -->
    <div class="bg-slate-50 border-t border-slate-200 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center space-x-1 py-1">
                <!-- All Categories Mega Trigger -->
                <div class="relative" @click.away="catMenuOpen = false">
                    <button @click="catMenuOpen = !catMenuOpen" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span>Browse Categories</span>
                        <svg class="w-3.5 h-3.5 ml-1 transition transform" :class="catMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <!-- Categories Dropdown Menu -->
                    <div x-show="catMenuOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-full left-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-slate-200 py-2 z-50">
                        @php
                            $catItems = [
                                'Smartphones' => ['icon' => '📱', 'desc' => 'iOS, Android & Flagships'],
                                'Laptops' => ['icon' => '💻', 'desc' => 'MacBooks & Gaming PCs'],
                                'Tablets' => ['icon' => '📋', 'desc' => 'iPads, Galaxy & Surface'],
                                'Audio' => ['icon' => '🎧', 'desc' => 'Headphones & ANC Earbuds'],
                                'Gaming' => ['icon' => '🎮', 'desc' => 'Consoles, Keyboards & Gear'],
                                'Cameras' => ['icon' => '📷', 'desc' => 'Mirrorless & 4K Action'],
                                'Smart Home' => ['icon' => '🏠', 'desc' => 'Speakers, Cams & Lighting'],
                                'Accessories' => ['icon' => '⚡', 'desc' => 'Cables, Chargers & Hubs'],
                            ];
                        @endphp
                        @foreach($catItems as $cName => $cInfo)
                            <a href="{{ $themeUrl('online_store/shop', ['category' => $cName]) }}" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition group">
                                <span class="text-base mr-3">{{ $cInfo['icon'] }}</span>
                                <div>
                                    <span class="block font-semibold text-slate-800 group-hover:text-blue-600 leading-tight">{{ $cName }}</span>
                                    <span class="block text-[11px] text-slate-400 leading-tight">{{ $cInfo['desc'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Primary Nav Links -->
                <nav class="flex items-center space-x-1 pl-4">
                    <a href="{{ $themeUrl('online_store') }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request()->routeIs('store.index') && !request('category') && !request('collection') ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Home
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Smartphones']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Smartphones' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Smartphones
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Laptops']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Laptops' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Laptops
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Audio']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Audio' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Audio
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Gaming']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Gaming' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Gaming
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Smart Home']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Smart Home' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Smart Home
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['category' => 'Accessories']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider {{ request('category') === 'Accessories' ? 'text-blue-600' : 'text-slate-700 hover:text-blue-600' }} transition">
                        Accessories
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['collection' => 'deals']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-red-600 hover:text-red-700 transition flex items-center gap-1">
                        <span>🔥</span>
                        <span>Deals</span>
                    </a>
                    <a href="{{ $themeUrl('online_store/shop', ['collection' => 'support']) }}" class="px-3 py-2 text-xs font-bold uppercase tracking-wider text-slate-700 hover:text-blue-600 transition">
                        Support
                    </a>
                </nav>
            </div>

            <!-- Hotline / Support Banner -->
            <div class="hidden xl:flex items-center text-xs font-medium text-slate-600">
                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                <span>Live Support: </span>
                <span class="font-bold text-slate-900 ml-1">+1 (800) 832-4668</span>
            </div>
        </div>
    </div>
</header>
