@php
    $previewTheme = request('preview_theme', 'naturae');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<!-- Mobile Nav Drawer -->
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
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"
         @click="mobileMenuOpen = false"></div>

    <!-- Drawer Panel -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative max-w-xs w-full bg-naturae-bg h-full shadow-2xl flex flex-col justify-between overflow-y-auto z-10 border-r border-naturae-border">

        <!-- Top Header & Close -->
        <div>
            <div class="p-5 flex items-center justify-between border-b border-naturae-border bg-white">
                <a href="{{ $storeUrl }}" class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-naturae-forest text-white flex items-center justify-center">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A9.49 9.49 0 0 0 12 21a10 10 0 0 0 10-10c0-1.5-.32-2.92-.88-4.21A10.74 10.74 0 0 0 17 8zm-4.32 10.94a7.51 7.51 0 0 1-3.68-1.57C11.39 12.87 13.9 9.5 17 8.2a8 8 0 0 1-4.32 10.74z" />
                        </svg>
                    </div>
                    <span class="font-serif text-lg font-bold tracking-widest text-naturae-forest uppercase">
                        NATURAE
                    </span>
                </a>
                <button type="button"
                        @click="mobileMenuOpen = false"
                        class="p-2 text-naturae-muted hover:text-naturae-forest focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Search Form -->
            <div class="p-4 border-b border-naturae-border bg-white/50">
                <form action="{{ url('online_store/shop') }}" method="GET" class="relative">
                    @if($previewTheme)
                        <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                    @endif
                    <input type="text"
                           name="q"
                           placeholder="Search organic catalog..."
                           class="w-full bg-white border border-naturae-border rounded-lg pl-3 pr-8 py-2 text-xs text-naturae-text focus:outline-none focus:border-naturae-forest">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-naturae-muted hover:text-naturae-forest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-sm font-medium tracking-wider uppercase text-naturae-forest">
                <a href="{{ $shopUrl }}" class="block px-3 py-2.5 rounded-lg hover:bg-naturae-sand transition">
                    Shop All
                </a>
                <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2.5 rounded-lg hover:bg-naturae-sand transition">
                    New Arrivals
                </a>
                <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2.5 rounded-lg hover:bg-naturae-sand transition">
                    Best Sellers
                </a>

                <div class="pt-3 pb-1 px-3 text-[11px] font-semibold text-naturae-muted uppercase tracking-widest">
                    Categories
                </div>

                <a href="{{ url('online_store/shop?category=Skincare' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Skincare
                </a>
                <a href="{{ url('online_store/shop?category=Hair+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Hair Care
                </a>
                <a href="{{ url('online_store/shop?category=Bath+%26+Body' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Bath & Body
                </a>
                <a href="{{ url('online_store/shop?category=Wellness' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Wellness
                </a>
                <a href="{{ url('online_store/shop?category=Home+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Home Care
                </a>
                <a href="{{ url('online_store/shop?category=Organic+Tea' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Organic Tea
                </a>
                <a href="{{ url('online_store/shop?category=Gift+Sets' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Gift Sets
                </a>
                <a href="{{ url('online_store/shop?category=Accessories' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block px-3 py-2 rounded-lg text-xs hover:bg-naturae-sand transition">
                    Accessories
                </a>
            </nav>
        </div>

        <!-- Bottom Actions -->
        <div class="p-4 border-t border-naturae-border bg-white">
            <a href="{{ url('online_store/cart' . ($previewTheme ? '?preview_theme=' . $previewTheme : '')) }}"
               class="w-full bg-naturae-forest hover:bg-naturae-green text-white py-2.5 rounded-lg flex items-center justify-center gap-2 text-xs font-semibold uppercase tracking-wider transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                View Shopping Bag (<span x-text="cartCount">0</span>)
            </a>
        </div>

    </div>
</div>
