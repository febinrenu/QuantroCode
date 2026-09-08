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

<!-- Mobile Navigation Drawer -->
<div x-show="mobileMenuOpen"
     x-cloak
     class="fixed inset-0 z-50 lg:hidden"
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
         class="fixed inset-0 bg-black/60 backdrop-blur-xs"
         @click="mobileMenuOpen = false"></div>

    <!-- Drawer Panel -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative max-w-xs w-full bg-white h-full shadow-2xl flex flex-col justify-between overflow-y-auto">

        <!-- Header in Drawer -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ $storeUrl }}" class="flex flex-col">
                <span class="text-2xl font-black tracking-tight text-urb-dark">
                    URBANIC
                </span>
                <span class="text-[9px] font-extrabold tracking-[0.2em] text-slate-500 uppercase">
                    Stay Stylish
                </span>
            </a>

            <button type="button"
                    @click="mobileMenuOpen = false"
                    class="p-2 rounded-lg text-slate-400 hover:text-urb-dark hover:bg-slate-100"
                    aria-label="Close menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="p-5 space-y-6 flex-grow">

            <div class="space-y-1">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    Main Categories
                </h4>
                <a href="{{ $womenUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>👗</span> <span>Women</span>
                </a>
                <a href="{{ $menUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>👔</span> <span>Men</span>
                </a>
                <a href="{{ $kidsUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>🧒</span> <span>Kids</span>
                </a>
                <a href="{{ $shoesUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>👟</span> <span>Shoes</span>
                </a>
                <a href="{{ $bagsUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>👜</span> <span>Bags</span>
                </a>
                <a href="{{ $accUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>⌚</span> <span>Accessories</span>
                </a>
            </div>

            <div class="border-t border-slate-100 pt-4 space-y-1">
                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    Highlights
                </h4>
                <a href="{{ $newArrivalsUrl }}" class="flex items-center gap-3 py-2 text-sm font-bold text-slate-800 hover:text-orange-500">
                    <span>⭐</span> <span>New Arrivals</span>
                </a>
                <a href="{{ $saleUrl }}" class="flex items-center gap-3 py-2 text-sm font-black text-orange-600">
                    <span>🔥</span> <span>Hot Summer Sale (50% OFF)</span>
                </a>
            </div>

        </div>

        <!-- Footer in Drawer -->
        <div class="p-5 border-t border-slate-100 bg-slate-50 space-y-3">
            <a href="{{ $cartUrl }}" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-md flex items-center justify-center gap-2">
                <span>View Shopping Bag</span>
                <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px]" x-text="cartCount"></span>
            </a>
            <a href="{{ $shopUrl }}" class="block text-center text-xs font-bold text-slate-600 hover:text-urb-dark py-1">
                Explore All Products →
            </a>
        </div>

    </div>
</div>
