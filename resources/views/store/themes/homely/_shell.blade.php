@php
  $activeThemeSlug = 'homely';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#C86A4B';
  $accent600 = $themeTokens['color-accent-600'] ?? '#7A9A78';
  $accent700 = $themeTokens['color-accent-700'] ?? '#2C332D';
  $accent800 = $themeTokens['color-accent-800'] ?? '#EFE9DF';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Playfair Display\', serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homely — Live Beautifully | Home, Decor & Living')</title>
    <meta name="description" content="@yield('meta_description', 'Thoughtfully designed pieces for a calm, cozy and conscious living. Sustainably sourced home decor, kitchenware, furniture and botanical plants.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        homely: {
                            bg: '#FBF9F5',
                            sand: '#F4F0E8',
                            surface: '#FFFFFF',
                            card: '#F6F2EB',
                            primary: '#263E2B',
                            primaryDark: '#1E3524',
                            forest: '#263E2B',
                            terracotta: '#B36B39',
                            terracottaHover: '#9A5B2F',
                            sage: '#768A6F',
                            sageLight: '#E8ECE6',
                            text: '#1F2421',
                            muted: '#6B7280',
                            border: '#E8E2D8',
                            borderLight: '#F0EBE3'
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js & CartLS Integration -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #FBF9F5;
            color: #1F2421;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .organic-leaf-bg {
            background-image: radial-gradient(circle at 10% 20%, rgba(38, 62, 43, 0.03) 0%, transparent 40%),
                              radial-gradient(circle at 90% 80%, rgba(179, 107, 57, 0.03) 0%, transparent 40%);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #F4F0E8; }
        ::-webkit-scrollbar-thumb { background: #D5CCC0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #B36B39; }
    </style>

    @stack('styles')
</head>
<body class="min-h-full flex flex-col antialiased selection:bg-homely-terracotta selection:text-white"
      x-data="homelyApp()"
      x-init="initCart()">

    <!-- Header Section -->
    @include('store.themes.homely.partials.header')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Section -->
    @include('store.themes.homely.partials.footer')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.homely.partials.mobile-nav')

    <!-- Toast Notification -->
    <div x-cloak
         x-show="toast.show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-homely-primary text-white px-5 py-3.5 rounded-full shadow-2xl border border-white/10">
        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-sm font-medium" x-text="toast.message"></span>
    </div>

    <!-- Core Storefront & CartLS Script -->
    <script>
        function homelyApp() {
            return {
                mobileMenuOpen: false,
                cart: {
                    items: [],
                    totalCount: 0,
                    subtotal: 0
                },
                toast: {
                    show: false,
                    message: '',
                    timeout: null
                },

                initCart() {
                    this.loadCart();
                    window.addEventListener('storage', () => this.loadCart());
                    window.addEventListener('cart-updated', () => this.loadCart());
                },

                loadCart() {
                    try {
                        const raw = localStorage.getItem('cart_items') || localStorage.getItem('cart') || '[]';
                        const items = JSON.parse(raw);
                        this.cart.items = Array.isArray(items) ? items : [];
                        this.recalc();
                    } catch (e) {
                        this.cart.items = [];
                        this.recalc();
                    }
                },

                saveCart() {
                    localStorage.setItem('cart_items', JSON.stringify(this.cart.items));
                    localStorage.setItem('cart', JSON.stringify(this.cart.items));
                    window.dispatchEvent(new Event('cart-updated'));
                    this.recalc();
                },

                recalc() {
                    let count = 0;
                    let sum = 0;
                    this.cart.items.forEach(item => {
                        const q = parseInt(item.quantity || item.qty || 1, 10);
                        const p = parseFloat(item.price || 0);
                        count += q;
                        sum += (q * p);
                    });
                    this.cart.totalCount = count;
                    this.cart.subtotal = sum;
                },

                addToCart(product, qty = 1) {
                    const id = product.id || product.code || ('prod_' + Date.now());
                    const existing = this.cart.items.find(i => (i.id == id || i.code == product.code));
                    
                    if (existing) {
                        existing.quantity = (parseInt(existing.quantity || 1, 10)) + parseInt(qty, 10);
                    } else {
                        this.cart.items.push({
                            id: id,
                            code: product.code || '',
                            name: product.name || 'Homely Product',
                            price: parseFloat(product.price || product.final_display_price || 0),
                            original_price: parseFloat(product.original_price || product.price || 0),
                            image: product.image || '/images/themes/homely/hom-glass-bud-vase.jpg',
                            quantity: parseInt(qty, 10),
                            category: product.category ? (product.category.name || product.category) : 'Home & Living'
                        });
                    }

                    this.saveCart();
                    this.showToast(`Added "${product.name || 'Item'}" to your cart`);
                },

                updateQuantity(index, newQty) {
                    if (newQty <= 0) {
                        this.cart.items.splice(index, 1);
                    } else {
                        this.cart.items[index].quantity = newQty;
                    }
                    this.saveCart();
                },

                removeFromCart(index) {
                    const name = this.cart.items[index]?.name || 'Item';
                    this.cart.items.splice(index, 1);
                    this.saveCart();
                    this.showToast(`Removed "${name}" from your cart`);
                },

                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.show = true;
                    if (this.toast.timeout) clearTimeout(this.toast.timeout);
                    this.toast.timeout = setTimeout(() => {
                        this.toast.show = false;
                    }, 2800);
                }
            }
        }
    </script>

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
