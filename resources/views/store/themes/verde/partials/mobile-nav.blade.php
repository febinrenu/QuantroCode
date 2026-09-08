@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<!-- Mobile Nav Slide-over Drawer -->
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
         class="fixed inset-0 bg-stone-900/60 backdrop-blur-xs"
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
             class="relative mr-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-verde-bg py-6 px-6 shadow-2xl border-r border-verde-border">
            
            <!-- Drawer Header -->
            <div class="flex items-center justify-between border-b border-verde-borderLight pb-4">
                <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full border border-verde-primary/40 flex items-center justify-center bg-white shadow-xs">
                        <svg class="w-5 h-5 text-verde-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="1.2" stroke-dasharray="1 1"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 21V10M12 10C12 5.5 16 3 19 3C19 7 17 11 12 14C7 11 5 7 5 3C8 3 12 5.5 12 10z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-lg tracking-widest font-bold text-verde-dark leading-none">VERDE</span>
                        <span class="text-[0.55rem] tracking-[0.25em] text-verde-muted font-bold mt-0.5">LIVING</span>
                    </div>
                </a>

                <button type="button" 
                        class="p-2 rounded-lg text-stone-500 hover:text-stone-900 hover:bg-white transition-colors"
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
                           placeholder="Search natural home & living..." 
                           class="w-full bg-white text-stone-800 placeholder-stone-400 pl-9 pr-4 py-2.5 rounded-xl border border-verde-border text-xs focus:outline-hidden focus:border-verde-primary shadow-xs">
                    <div class="absolute left-3 top-2.5 text-stone-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Nav Links List -->
            <div class="mt-6 flex flex-col space-y-1">
                <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-semibold text-verde-dark hover:bg-white transition-colors flex items-center justify-between">
                    <span>🌿 New In</span>
                    <span class="text-xs text-verde-muted">Latest</span>
                </a>
                <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Shop All Products
                </a>
                <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Home & Decor
                </a>
                <a href="{{ url('/online_store/shop?category=cleaning-essentials' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Cleaning Essentials
                </a>
                <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Bath & Body
                </a>
                <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Kitchen & Dining
                </a>
                <a href="{{ url('/online_store/shop?category=gifts-sets' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Gifts & Sets
                </a>
                <a href="{{ url('/online_store/shop?category=beauty' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Beauty & Skincare
                </a>
                <a href="{{ url('/online_store/shop?collection=journal' . $previewAmp) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    Journal & Stories
                </a>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium text-stone-700 hover:bg-white hover:text-verde-primary transition-colors">
                    About Us / Contact
                </a>
            </div>

            <!-- Bottom Utilities -->
            <div class="mt-auto pt-6 border-t border-verde-borderLight space-y-2">
                <a href="{{ url('/online_store/account' . $previewParam) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-semibold text-stone-700 hover:bg-white">
                    <svg class="w-4 h-4 text-verde-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>My Account</span>
                </a>
                <a href="{{ url('/online_store/cart' . $previewParam) }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-xs font-bold bg-verde-btn text-white hover:bg-verde-btnHover shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>View Shopping Bag</span>
                    </div>
                    <span class="bg-white/20 px-2 py-0.5 rounded-full text-[0.65rem]">Checkout</span>
                </a>
            </div>
        </div>
    </div>
</div>
