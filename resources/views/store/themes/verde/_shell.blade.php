@php
  $activeThemeSlug = 'verde';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#2D5A27';
  $accent600 = $themeTokens['color-accent-600'] ?? '#4E8752';
  $accent700 = $themeTokens['color-accent-700'] ?? '#8C6239';
  $accent800 = $themeTokens['color-accent-800'] ?? '#1A3A16';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Playfair Display\', serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Verde Living | Live Beautifully. Choose Consciously.')</title>
    <meta name="description" content="@yield('meta_description', 'Thoughtfully curated sustainable lifestyle and organic home decor for a cleaner home, a calmer mind, and a brighter planet.')">

    <!-- Google Fonts: Playfair Display + Plus Jakarta Sans + Cormorant Garamond -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        verde: {
                            bg: '#FBF9F5',
                            sand: '#F3EFEA',
                            sandDark: '#E8E2D8',
                            primary: '#3A472D',
                            dark: '#2D3A22',
                            btn: '#556844',
                            btnHover: '#435336',
                            accent: '#7D8C6C',
                            text: '#1F2818',
                            muted: '#687760',
                            border: '#E5DFD5',
                            borderLight: '#ECE6DC',
                            footer: '#182215',
                            footerDark: '#121B10'
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', '"Cormorant Garamond"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
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
            background-color: #FBF9F5;
            color: #1F2818;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .font-serif {
            font-family: 'Playfair Display', 'Cormorant Garamond', Georgia, serif;
        }

        /* Fixed Vertical Reviews Tab */
        .fixed-reviews-tab {
            position: fixed;
            left: 0;
            top: 40%;
            transform: translateY(-50%) rotate(-90deg);
            transform-origin: left bottom;
            z-index: 40;
            background-color: #4E5F3D;
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 7px 16px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .fixed-reviews-tab:hover {
            background-color: #3A472D;
            padding-bottom: 10px;
        }

        /* Smooth custom scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #FBF9F5;
        }
        ::-webkit-scrollbar-thumb {
            background: #D4CDBC;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #B5AD99;
        }
    </style>

    <!-- Global CartLS helper script -->
    <script>
        window.CartLS = {
            STORAGE_KEY: 'verde_cart_items',
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
            add(product, qty = 1, variant = null) {
                const items = this.get();
                const vId = variant ? (variant.id || variant.name) : null;
                const vName = variant ? (variant.name || '') : '';
                const code = product.code || product.id;
                
                const existingIndex = items.findIndex(i => i.id === product.id && i.variant_id === vId);
                
                if (existingIndex > -1) {
                    items[existingIndex].quantity += qty;
                } else {
                    const price = (variant && variant.price) ? Number(variant.price) : (Number(product.final_display_price) || Number(product.price) || 0);
                    items.push({
                        id: product.id,
                        code: code,
                        name: product.name,
                        price: price,
                        original_price: Number(product.base_price) || price,
                        image: product.image || '',
                        quantity: qty,
                        variant_id: vId,
                        variant_name: vName,
                        category: (product.category && product.category.name) ? product.category.name : 'Home & Decor'
                    });
                }
                this.save(items);

                // Dispatch toast event
                window.dispatchEvent(new CustomEvent('toast-notify', {
                    detail: {
                        message: `Added "${product.name}" to your cart.`,
                        image: product.image || '',
                        type: 'success'
                    }
                }));
            },
            updateQty(id, variantId, qty) {
                let items = this.get();
                if (qty <= 0) {
                    items = items.filter(i => !(i.id === id && i.variant_id === variantId));
                } else {
                    const index = items.findIndex(i => i.id === id && i.variant_id === variantId);
                    if (index > -1) {
                        items[index].quantity = qty;
                    }
                }
                this.save(items);
            },
            remove(id, variantId = null) {
                const items = this.get().filter(i => !(i.id === id && i.variant_id === variantId));
                this.save(items);
            },
            clear() {
                this.save([]);
            },
            count() {
                return this.get().reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
            },
            subtotal() {
                return this.get().reduce((sum, item) => sum + ((Number(item.price) || 0) * (Number(item.quantity) || 0)), 0);
            }
        };

        // Mini Cart Alpine Component
        function miniCart() {
            return {
                isOpen: false,
                items: [],
                freeShippingThreshold: 75.00,
                init() {
                    this.items = CartLS.get();
                    window.addEventListener('cart-updated', (e) => {
                        this.items = e.detail.items || CartLS.get();
                    });
                },
                get count() {
                    return this.items.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0);
                },
                get subtotal() {
                    return this.items.reduce((sum, item) => sum + ((Number(item.price) || 0) * (Number(item.quantity) || 0)), 0);
                },
                get progress() {
                    return Math.min(100, (this.subtotal / this.freeShippingThreshold) * 100);
                },
                get freeShippingRemaining() {
                    const rem = this.freeShippingThreshold - this.subtotal;
                    return rem > 0 ? rem.toFixed(2) : 0;
                },
                updateQty(id, variantId, qty) {
                    CartLS.updateQty(id, variantId, qty);
                },
                removeItem(id, variantId) {
                    CartLS.remove(id, variantId);
                }
            }
        }
    </script>
    @stack('head')
</head>
<body class="bg-verde-bg text-verde-text min-h-screen flex flex-col antialiased selection:bg-verde-btn selection:text-white"
      x-data="{ 
          mobileMenu: false, 
          searchOpen: false, 
          searchQuery: '',
          toast: { show: false, message: '', image: '', type: 'success' }
      }"
      @toast-notify.window="
          toast.message = $event.detail.message;
          toast.image = $event.detail.image || '';
          toast.type = $event.detail.type || 'success';
          toast.show = true;
          setTimeout(() => { toast.show = false; }, 4000);
      ">

    <!-- Fixed Left Vertical Reviews Tab -->
    <a href="{{ url('/online_store/shop?collection=best-sellers' . (request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '')) }}" 
       class="fixed-reviews-tab hidden sm:flex items-center gap-1.5" 
       title="Customer Reviews">
        <span>★ REVIEWS</span>
    </a>

    <!-- Top Announcement Bar & Main Header -->
    @include('store.themes.verde.partials.header')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.verde.partials.mobile-nav')

    <!-- Main Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Dark Verde Footer -->
    @include('store.themes.verde.partials.footer')

    <!-- Floating Toast Notification -->
    <div x-cloak
         x-show="toast.show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-white rounded-2xl p-4 shadow-2xl border border-verde-border flex items-center gap-3.5">
        <template x-if="toast.image">
            <img :src="'/images/themes/verde/' + toast.image" class="w-12 h-12 rounded-xl object-contain bg-verde-sand p-1" alt="Product thumbnail">
        </template>
        <div class="flex-grow">
            <p class="text-xs font-bold text-verde-primary tracking-wide uppercase">Bag Updated</p>
            <p class="text-sm text-stone-700 font-medium" x-text="toast.message"></p>
        </div>
        <a href="{{ url('/online_store/cart' . (request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '')) }}" 
           class="px-3 py-1.5 bg-verde-btn hover:bg-verde-btnHover text-white text-xs font-semibold rounded-lg transition-colors whitespace-nowrap">
            View Bag
        </a>
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
