@php
    $previewTheme = request('preview_theme', 'technova');
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };
@endphp

<!-- Off-Canvas Mobile Navigation Drawer -->
<div x-data="{ mobileNavOpen: false }"
     @toggle-mobile-nav.window="mobileNavOpen = !mobileNavOpen"
     @keydown.escape.window="mobileNavOpen = false"
     class="lg:hidden">

    <!-- Backdrop Overlay -->
    <div x-show="mobileNavOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileNavOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50"></div>

    <!-- Slide-in Drawer -->
    <div x-show="mobileNavOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-2xl z-50 flex flex-col justify-between overflow-y-auto">

        <!-- Header -->
        <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-slate-900 text-white">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-xl font-bold font-heading">Tech<span class="text-blue-400">Nova</span></span>
            </div>
            <button @click="mobileNavOpen = false" class="p-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <!-- Search in Mobile Menu -->
        <div class="p-4 border-b border-slate-100 bg-slate-50">
            <form action="{{ url('online_store/shop') }}" method="GET" class="relative">
                @if($previewTheme)
                    <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                @endif
                <input type="text" name="q" placeholder="Search electronics..." class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-lg focus:outline-none focus:border-blue-600" />
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 py-4 px-4 space-y-1">
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Shop by Category</div>
            @php
                $mobileCats = [
                    'Smartphones' => '📱',
                    'Laptops' => '💻',
                    'Tablets' => '📋',
                    'Audio' => '🎧',
                    'Gaming' => '🎮',
                    'Cameras' => '📷',
                    'Smart Home' => '🏠',
                    'Accessories' => '⚡',
                ];
            @endphp
            @foreach($mobileCats as $mCat => $mIcon)
                <a href="{{ $themeUrl('online_store/shop', ['category' => $mCat]) }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition">
                    <span class="mr-3 text-base">{{ $mIcon }}</span>
                    <span>{{ $mCat }}</span>
                </a>
            @endforeach

            <div class="pt-4 border-t border-slate-100 my-3">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-2">Quick Links</div>
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'deals']) }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-red-600 hover:bg-red-50 transition">
                    <span class="mr-3">🔥</span>
                    <span>Exclusive Deals (Up to 40% OFF)</span>
                </a>
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'new-arrivals']) }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    <span class="mr-3">✨</span>
                    <span>New Arrivals 2024</span>
                </a>
                <a href="{{ $themeUrl('online_store/cart') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-semibold text-blue-600 hover:bg-blue-50 transition">
                    <span class="mr-3">🛒</span>
                    <span>Shopping Cart</span>
                </a>
            </div>
        </div>

        <!-- Footer / Contact Info -->
        <div class="p-4 border-t border-slate-200 bg-slate-50 text-xs text-slate-500">
            <div class="font-semibold text-slate-700 mb-1">Need Assistance?</div>
            <div>Phone: +1 (800) 832-4668</div>
            <div>Email: support@technova.com</div>
        </div>
    </div>
</div>
