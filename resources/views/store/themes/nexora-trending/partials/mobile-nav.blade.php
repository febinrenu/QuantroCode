@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $cartUrl = url('online_store/cart') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<!-- Mobile Navigation Drawer -->
<div x-cloak
     x-show="mobileMenuOpen"
     class="fixed inset-0 z-50 lg:hidden flex"
     role="dialog"
     aria-modal="true">

    <!-- Backdrop -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

    <!-- Drawer Panel -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative max-w-xs w-full bg-white h-full shadow-2xl flex flex-col justify-between overflow-y-auto">

        <div>
            <!-- Header with Close -->
            <div class="p-5 border-b border-slate-200 flex items-center justify-between bg-nex-navydark text-white">
                <a href="{{ $storeUrl }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center font-bold">
                        N
                    </div>
                    <span class="font-black text-lg tracking-tight uppercase">Nexora</span>
                </a>

                <button type="button"
                        @click="mobileMenuOpen = false"
                        class="p-2 text-slate-300 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Field -->
            <div class="p-4 bg-slate-50 border-b border-slate-200">
                <form action="{{ url('online_store/shop') }}" method="GET" class="relative">
                    @if($previewTheme)
                        <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                    @endif
                    <input type="text"
                           name="q"
                           placeholder="Search products..."
                           class="w-full bg-white border border-slate-300 rounded-xl pl-3.5 pr-10 py-2 text-xs focus:outline-none focus:border-nex-indigo">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-slate-400 hover:text-nex-navy">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Navigation Links -->
            <div class="p-4 space-y-1 text-xs font-bold uppercase tracking-wider text-nex-navy">
                <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    <span>☆ New In</span>
                </a>
                <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    <span>☆ Best Sellers</span>
                </a>
                <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-slate-100 transition text-amber-600">
                    <span>◇ Deals</span>
                </a>
                <a href="{{ $shopUrl }}" class="block px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    All Categories
                </a>
                <a href="{{ $shopUrl }}" class="block px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    Brands
                </a>
                <a href="{{ $shopUrl }}" class="block px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    Collections
                </a>
                <a href="{{ $cartUrl }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-slate-100 transition">
                    <span>Shopping Cart</span>
                    <span class="cart-count bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">0</span>
                </a>
            </div>

            <!-- Categories Accordion / List -->
            <div class="px-4 py-2 border-t border-slate-200">
                <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 px-3 mb-2">
                    Popular Categories
                </p>
                <div class="space-y-1 text-xs text-slate-700">
                    <a href="{{ url('online_store/shop?category=Electronics' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Electronics</a>
                    <a href="{{ url('online_store/shop?category=Fashion' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Fashion</a>
                    <a href="{{ url('online_store/shop?category=Home+%26+Living' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Home & Living</a>
                    <a href="{{ url('online_store/shop?category=Beauty' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Beauty</a>
                    <a href="{{ url('online_store/shop?category=Sports' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Sports</a>
                    <a href="{{ url('online_store/shop?category=Toys+%26+Games' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Toys & Games</a>
                    <a href="{{ url('online_store/shop?category=Automotive' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100">Automotive</a>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Bottom CTA -->
        <div class="p-4 border-t border-slate-200 bg-slate-50 space-y-2">
            <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
               class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold py-2.5 rounded-xl uppercase tracking-wider flex items-center justify-center gap-1.5 shadow-md">
                <span>⚡ Flash Deals</span>
            </a>
        </div>

    </div>
</div>
