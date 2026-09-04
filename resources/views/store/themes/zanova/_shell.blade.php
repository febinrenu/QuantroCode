<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZANOVA — Shop Beyond Limits | Modern Marketplace')</title>
    <meta name="description" content="@yield('meta_description', 'ZANOVA: Discover top tech, fashion, home essentials, beauty, and sports at unbeatable prices with mega deals and fast shipping.')">

    <!-- Google Fonts: Plus Jakarta Sans + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        zanova: {
                            navy: '#0B111E',
                            dark: '#0F172A',
                            slate: '#1E293B',
                            yellow: '#FFCC00',
                            yellowDark: '#E6B800',
                            yellowHover: '#F5C200',
                            purple: '#7C3AED',
                            purpleDark: '#5B21B6',
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
            background-color: #F8FAFC;
            color: #0F172A;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Smooth custom scrollbars */
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
    </style>

    <!-- Global CartLS helper script -->
    <script>
        window.CartLS = {
            STORAGE_KEY: 'zanova_cart_items',
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
                        category: (product.category && product.category.name) ? product.category.name : 'Electronics'
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
                freeShippingThreshold: 59.00,
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
<body class="bg-zanova-bg text-zanova-text min-h-screen flex flex-col antialiased selection:bg-zanova-yellow selection:text-zanova-navy"
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

    <!-- Top Yellow Announcement Bar & Main Dark Navy Header -->
    @include('store.themes.zanova.partials.header')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.zanova.partials.mobile-nav')

    <!-- Main Content Container -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Dark Navy Footer -->
    @include('store.themes.zanova.partials.footer')

    <!-- Floating Toast Notification -->
    <div x-cloak
         x-show="toast.show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-white rounded-2xl p-4 shadow-2xl border border-zanova-border flex items-center gap-3.5">
        <template x-if="toast.image">
            <img :src="'/images/themes/zanova/' + toast.image" class="w-12 h-12 rounded-xl object-contain bg-slate-50 p-1" alt="Product thumbnail">
        </template>
        <div class="flex-grow">
            <p class="text-xs font-bold text-emerald-600 tracking-wide uppercase">Cart Updated</p>
            <p class="text-sm text-slate-800 font-semibold line-clamp-1" x-text="toast.message"></p>
        </div>
        <a href="{{ url('/online_store/cart' . (request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '')) }}"
           class="px-3 py-1.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy text-xs font-black rounded-lg transition-colors whitespace-nowrap shadow-xs">
            View Cart
        </a>
    </div>

    @stack('scripts')
</body>
</html>
