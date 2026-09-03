@php
  $activeThemeSlug = 'novatech-electronics';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#2563EB';
  $accent600 = $themeTokens['color-accent-600'] ?? '#06B6D4';
  $accent700 = $themeTokens['color-accent-700'] ?? '#0F172A';
  $accent800 = $themeTokens['color-accent-800'] ?? '#334155';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Outfit\', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '32px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NOVATECH — Smarter Everyday | Premium Tech Marketplace')</title>
    <meta name="description" content="@yield('meta_description', 'NOVATECH: Discover the latest tech, gadgets, laptops, smartphones, audio and electronics at the best prices with fast shipping and 24/7 support.')">

    <!-- Google Fonts: Inter + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        novatech: {
                            dark: '#0B0F19',
                            darker: '#060911',
                            cardDark: '#111827',
                            navy: '#0F172A',
                            primary: '#6366F1',
                            primaryDark: '#4F46E5',
                            purple: '#7C3AED',
                            purpleDark: '#6D28D9',
                            cyan: '#06B6D4',
                            blue: '#3B82F6',
                            bg: '#F8FAFC',
                            surface: '#FFFFFF',
                            text: '#0F172A',
                            muted: '#64748B',
                            border: '#E2E8F0',
                            borderLight: '#F1F5F9',
                            red: '#EF4444'
                        }
                    },
                    fontFamily: {
                        sans: ['"Inter"', '"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js Core & Collapse Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        body {
            background-color: #F8FAFC;
            color: #0F172A;
            font-family: 'Inter', 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        .neon-glow-cyan {
            box-shadow: 0 0 25px rgba(6, 182, 212, 0.45);
        }
        .neon-glow-purple {
            box-shadow: 0 0 25px rgba(124, 58, 237, 0.45);
        }
    </style>

    <!-- Global CartLS helper script -->
    <script>
        window.CartLS = {
            STORAGE_KEY: 'novatech_cart_items',
            get() {
                try {
                    const raw = localStorage.getItem(this.STORAGE_KEY);
                    return raw ? JSON.parse(raw) : [];
                } catch (e) {
                    console.error('Failed to read cart from localStorage', e);
                    return [];
                }
            },
            save(items) {
                try {
                    localStorage.setItem(this.STORAGE_KEY, JSON.stringify(items));
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { items } }));
                } catch (e) {
                    console.error('Failed to save cart to localStorage', e);
                }
            },
            add(product, qty = 1) {
                const items = this.get();
                const existing = items.find(i => i.id === product.id);
                if (existing) {
                    existing.quantity += qty;
                } else {
                    items.push({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price),
                        image: product.image,
                        code: product.code || '',
                        quantity: qty
                    });
                }
                this.save(items);
                this.showToast(`Added "${product.name}" to cart!`);
            },
            remove(id) {
                const items = this.get().filter(i => i.id !== id);
                this.save(items);
                this.showToast('Item removed from cart');
            },
            updateQty(id, qty) {
                const items = this.get();
                const item = items.find(i => i.id === id);
                if (item) {
                    item.quantity = Math.max(1, qty);
                    this.save(items);
                }
            },
            clear() {
                this.save([]);
            },
            count() {
                return this.get().reduce((sum, i) => sum + (i.quantity || 1), 0);
            },
            total() {
                return this.get().reduce((sum, i) => sum + (parseFloat(i.price) * (i.quantity || 1)), 0);
            },
            showToast(message, type = 'success') {
                window.dispatchEvent(new CustomEvent('toast-message', {
                    detail: { message, type }
                }));
            }
        };
    </script>
</head>
<body class="min-h-screen flex flex-col antialiased text-slate-900 bg-[#F8FAFC]" x-data="{ mobileNavOpen: false, miniCartOpen: false, cartCount: 0 }" x-init="cartCount = CartLS.count(); window.addEventListener('cart-updated', () => { cartCount = CartLS.count(); })">

    <!-- Header Partial -->
    @include('store.themes.novatech-electronics.partials.header')

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Partial -->
    @include('store.themes.novatech-electronics.partials.footer')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.novatech-electronics.partials.mobile-nav')

    <!-- Toast Notification Banner Component -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         @toast-message.window="message = $event.detail.message; type = $event.detail.type || 'success'; show = true; setTimeout(() => show = false, 3200)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-4 opacity-0 scale-95"
         x-transition:enter-end="translate-y-0 opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100 scale-100"
         x-transition:leave-end="translate-y-4 opacity-0 scale-95"
         class="fixed bottom-6 right-6 z-50 flex items-center space-x-3 px-5 py-3.5 rounded-xl shadow-2xl text-white text-sm font-medium border"
         :class="type === 'success' ? 'bg-slate-900 border-indigo-500/40 text-white' : 'bg-rose-600 border-rose-400 text-white'"
         x-cloak>
        <div class="flex items-center justify-center w-6 h-6 rounded-full"
             :class="type === 'success' ? 'bg-indigo-600 text-white' : 'bg-white/20 text-white'">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <span x-text="message"></span>
    </div>

    <!-- Mini Cart Side Drawer -->
    <div x-show="miniCartOpen" class="fixed inset-0 z-50 overflow-hidden" x-cloak>
        <!-- Backdrop -->
        <div x-show="miniCartOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="miniCartOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div x-show="miniCartOpen"
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md bg-white shadow-2xl flex flex-col">

                <!-- Drawer Header -->
                <div class="px-6 py-5 bg-slate-900 text-white flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h2 class="text-base font-bold tracking-tight">Shopping Cart (<span x-text="cartCount"></span>)</h2>
                    </div>
                    <button @click="miniCartOpen = false" class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Drawer Cart Content -->
                <div class="flex-1 overflow-y-auto px-6 py-6" x-data="{ items: [], total: 0 }" x-init="items = CartLS.get(); total = CartLS.total(); window.addEventListener('cart-updated', () => { items = CartLS.get(); total = CartLS.total(); })">
                    <template x-if="items.length === 0">
                        <div class="h-full flex flex-col items-center justify-center text-center py-12">
                            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Your cart is empty</h3>
                            <p class="text-xs text-slate-500 mb-6">Discover our latest electronics and tech gear.</p>
                            <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" @click="miniCartOpen = false" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all shadow-md">
                                Start Shopping
                            </a>
                        </div>
                    </template>

                    <div class="space-y-4" x-show="items.length > 0">
                        <template x-for="item in items" :key="item.id">
                            <div class="flex items-center space-x-4 p-3 rounded-xl border border-slate-100 bg-slate-50/50 hover:bg-slate-50 transition-colors">
                                <div class="w-14 h-14 rounded-lg bg-white p-1 border border-slate-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                    <img :src="item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/images/themes/novatech/' + item.image" :alt="item.name" class="w-full h-full object-contain">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-slate-900 truncate" x-text="item.name"></h4>
                                    <p class="text-xs font-bold text-indigo-600 mt-0.5" x-text="'$' + parseFloat(item.price).toFixed(2)"></p>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <button @click="CartLS.updateQty(item.id, item.quantity - 1)" class="w-5 h-5 rounded bg-white border border-slate-200 text-slate-600 flex items-center justify-center text-xs hover:bg-slate-100 font-bold">-</button>
                                        <span class="text-xs font-bold text-slate-800 w-4 text-center" x-text="item.quantity"></span>
                                        <button @click="CartLS.updateQty(item.id, item.quantity + 1)" class="w-5 h-5 rounded bg-white border border-slate-200 text-slate-600 flex items-center justify-center text-xs hover:bg-slate-100 font-bold">+</button>
                                    </div>
                                </div>
                                <button @click="CartLS.remove(item.id)" class="text-slate-400 hover:text-rose-500 p-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Drawer Footer Checkout -->
                <div class="p-6 border-t border-slate-100 bg-slate-50 space-y-4" x-data="{ total: 0 }" x-init="total = CartLS.total(); window.addEventListener('cart-updated', () => { total = CartLS.total(); })" x-show="CartLS.get().length > 0">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-600">Subtotal</span>
                        <span class="font-extrabold text-slate-900 text-lg" x-text="'$' + parseFloat(total).toFixed(2)"></span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ url('/online_store/cart?preview_theme=novatech') }}" class="w-full py-3 px-4 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-800 text-xs font-bold text-center transition-all">
                            View Cart
                        </a>
                        <a href="{{ url('/online_store/checkout?preview_theme=novatech') }}" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-xs font-bold text-center transition-all shadow-md shadow-indigo-500/20">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

<style id="theme-tokens">
:root {
  --color-accent-500: {{ $accent500 }};
  --color-accent-600: {{ $accent600 }};
  --color-accent-700: {{ $accent700 }};
  --color-accent-800: {{ $accent800 }};
  --font-heading: {!! $fontHeading !!};
  --font-body: {!! $fontBody !!};
  --font-size-heading: {{ $fontSizeHeading }};
  --font-size-body: {{ $fontSizeBody }};
}
</style>
