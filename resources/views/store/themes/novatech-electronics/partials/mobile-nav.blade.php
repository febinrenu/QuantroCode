<div x-show="mobileNavOpen" class="fixed inset-0 z-50 overflow-hidden lg:hidden" x-cloak>
    <!-- Backdrop -->
    <div x-show="mobileNavOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileNavOpen = false"
         class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-y-0 left-0 max-w-full flex pr-10">
        <div x-show="mobileNavOpen"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="w-screen max-w-xs bg-slate-900 text-white shadow-2xl flex flex-col">

            <!-- Mobile Drawer Header -->
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-600 to-cyan-400 p-0.5 flex items-center justify-center">
                        <div class="w-full h-full bg-slate-950 rounded-[6px] flex items-center justify-center p-1">
                            <span class="font-black text-indigo-400 text-xs">N</span>
                        </div>
                    </div>
                    <span class="text-base font-black tracking-tight text-white">NOVATECH</span>
                </a>
                <button @click="mobileNavOpen = false" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Search -->
            <div class="p-4 border-b border-slate-800">
                <form action="{{ route('store.shop') }}" method="GET" class="relative">
                    <input type="hidden" name="preview_theme" value="novatech">
                    <input type="text" name="q" placeholder="Search tech & gadgets..." class="w-full bg-slate-800 border border-slate-700 rounded-xl py-2 pl-3 pr-10 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                    <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Mobile Nav Links -->
            <div class="flex-1 overflow-y-auto p-4 space-y-6">
                <div>
                    <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Navigation</h5>
                    <ul class="space-y-1 text-sm font-semibold text-slate-200">
                        <li><a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 text-indigo-400">Home</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">Shop All</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'new-arrivals']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">New Arrivals</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'best-sellers']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">Best Sellers</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'filter' => 'deals']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800 text-purple-400">⚡ Today's Deals</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Categories</h5>
                    <ul class="space-y-1 text-xs text-slate-300">
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'laptops']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">💻 Laptops</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'smartphones']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">📱 Smartphones</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'wearables']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">⌚ Wearables</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'audio']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">🎧 Audio & Headphones</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'gaming']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">🎮 Gaming</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'accessories']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">🔌 Accessories</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'cameras']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">📷 Cameras</a></li>
                        <li><a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => 'smart-home']) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-800">🏠 Smart Home</a></li>
                    </ul>
                </div>
            </div>

            <!-- Drawer Footer -->
            <div class="p-4 border-t border-slate-800 bg-slate-950 text-center">
                <a href="{{ route('store.cart', ['preview_theme' => 'novatech']) }}" class="w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>View Cart (<span x-text="cartCount"></span>)</span>
                </a>
            </div>
        </div>
    </div>
</div>
