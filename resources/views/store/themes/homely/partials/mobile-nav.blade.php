@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<div x-cloak
     x-show="mobileMenuOpen"
     class="fixed inset-0 z-50 lg:hidden flex">
    
    <!-- Backdrop -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/40 backdrop-blur-xs"></div>

    <!-- Drawer Panel -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative w-full max-w-xs bg-homely-bg h-full flex flex-col shadow-2xl z-10 border-r border-homely-border">
        
        <!-- Header -->
        <div class="p-4 border-b border-homely-border bg-white flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-md border border-homely-primary/20 flex items-center justify-center text-homely-primary bg-homely-sand">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                        <path d="M12 18V12c0-2 2-3 4-3"/>
                        <path d="M12 14c-1.5 0-3-1-3-3"/>
                    </svg>
                </div>
                <span class="font-serif text-lg font-bold text-homely-primary">HOMELY</span>
            </div>
            <button @click="mobileMenuOpen = false" class="p-1.5 text-stone-500 hover:text-homely-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Search Input -->
        <div class="p-4 bg-white border-b border-homely-border">
            <form action="{{ url('/online_store/shop' . $previewParam) }}" method="GET" class="relative">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                <input type="text" 
                       name="q" 
                       placeholder="Search products..." 
                       class="w-full pl-4 pr-10 py-2 text-sm rounded-lg border border-homely-border bg-stone-50 focus:outline-none focus:border-homely-primary">
                <button type="submit" class="absolute right-2.5 top-2.5 text-homely-terracotta">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1 overflow-y-auto p-4 space-y-1 text-sm font-medium">
            <a href="{{ url('/online_store' . $previewParam) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Shop All
            </a>
            <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                New In
            </a>
            <a href="{{ url('/online_store/shop?category=home-living' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Home & Living
            </a>
            <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Kitchen & Dining
            </a>
            <a href="{{ url('/online_store/shop?category=furniture' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Furniture
            </a>
            <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Bath & Body
            </a>
            <a href="{{ url('/online_store/shop?category=decor' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Decor
            </a>
            <a href="{{ url('/online_store/shop?category=indoor-plants' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-homely-sand text-homely-text">
                Plants
            </a>
            <a href="{{ url('/online_store/shop?collection=sale' . $previewAmp) }}" 
               class="block px-3 py-2.5 rounded-md hover:bg-amber-50 text-homely-terracotta font-semibold">
                Sale
            </a>
        </div>

        <!-- Drawer Footer -->
        <div class="p-4 border-t border-homely-border bg-white text-xs text-stone-500 space-y-2">
            <div class="flex items-center gap-2 text-homely-primary font-medium">
                <span>🌿</span>
                <span>Sustainable Living & Better Choices</span>
            </div>
            <p>© {{ date('Y') }} Homely. All rights reserved.</p>
        </div>
    </div>
</div>
