@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<!-- Mobile Navigation Drawer -->
<div x-cloak
     x-show="mobileMenu"
     class="relative z-50 lg:hidden"
     role="dialog"
     aria-modal="true">

    <!-- Backdrop overlay -->
    <div x-show="mobileMenu"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 backdrop-blur-xs"
         @click="mobileMenu = false"></div>

    <div class="fixed inset-0 flex z-50">
        <!-- Drawer Panel -->
        <div x-show="mobileMenu"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative mr-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-zanova-navy text-white py-6 px-6 shadow-2xl border-r border-slate-800">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-zanova-yellow text-zanova-navy flex items-center justify-center font-black text-xl shadow-md">
                        Z
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-xl tracking-tight text-white leading-none">ZANOVA</span>
                        <span class="text-[0.55rem] font-bold text-amber-400 tracking-wider mt-0.5 uppercase">Shop Beyond Limits</span>
                    </div>
                </a>

                <button type="button"
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors"
                        @click="mobileMenu = false"
                        aria-label="Close navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Search -->
            <div class="mt-4">
                <form action="{{ url('/online_store/shop') }}" method="GET" class="relative">
                    @if(request('preview_theme'))
                        <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                    @endif
                    <input type="text"
                           name="q"
                           placeholder="Search products, brands..."
                           class="w-full bg-slate-900 text-white placeholder-slate-400 pl-9 pr-4 py-2.5 rounded-xl border border-slate-700 text-xs focus:outline-hidden focus:border-zanova-yellow shadow-inner">
                    <div class="absolute left-3 top-2.5 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Nav Links List -->
            <div class="mt-6 flex flex-col space-y-1 text-xs font-bold">
                <a href="{{ url('/online_store' . $previewParam) }}"
                   class="px-3 py-2 rounded-lg text-zanova-yellow bg-slate-800/80 transition-colors flex items-center justify-between">
                    <span>🏠 Home</span>
                </a>
                <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-white hover:bg-slate-800 transition-colors flex items-center justify-between">
                    <span>🔥 Mega Deals</span>
                    <span class="px-1.5 py-0.5 bg-zanova-purple text-white text-[0.6rem] font-black rounded-xs">HOT</span>
                </a>
                <a href="{{ url('/online_store/shop?collection=lightning-deals' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-white hover:bg-slate-800 transition-colors flex items-center justify-between">
                    <span>⚡ Lightning Deals</span>
                </a>
                <a href="{{ url('/online_store/shop' . $previewParam) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    Shop All Products
                </a>

                <div class="pt-3 pb-1 px-3 text-[0.65rem] font-black uppercase tracking-wider text-slate-400">
                    Categories
                </div>
                <a href="{{ url('/online_store/shop?category=electronics' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    💻 Electronics
                </a>
                <a href="{{ url('/online_store/shop?category=fashion-apparel' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    👕 Fashion & Apparel
                </a>
                <a href="{{ url('/online_store/shop?category=home-kitchen' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    🏠 Home & Kitchen
                </a>
                <a href="{{ url('/online_store/shop?category=beauty-personal-care' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    🧴 Beauty & Personal Care
                </a>
                <a href="{{ url('/online_store/shop?category=sports-outdoors' . $previewAmp) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    ⚽ Sports & Outdoors
                </a>
                <a href="{{ url('/online_store/contact' . $previewParam) }}"
                   class="px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors">
                    Contact Us
                </a>
            </div>

            <!-- Bottom Utilities -->
            <div class="mt-auto pt-6 border-t border-slate-800 space-y-2">
                <a href="{{ url('/online_store/account' . $previewParam) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold text-slate-300 hover:bg-slate-800">
                    <svg class="w-4 h-4 text-zanova-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>My Account</span>
                </a>
                <a href="{{ url('/online_store/cart' . $previewParam) }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-black bg-zanova-yellow text-zanova-navy hover:bg-zanova-yellowHover shadow-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>View Shopping Cart</span>
                    </div>
                    <span class="bg-zanova-navy text-white px-2 py-0.5 rounded-md text-[0.65rem] font-bold">Checkout</span>
                </a>
            </div>
        </div>
    </div>
</div>
