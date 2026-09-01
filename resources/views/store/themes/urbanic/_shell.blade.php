<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $s->store_name ?? 'URBANIC' }} — Stay Stylish</title>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&family=Playfair+Display:ital,wght@1,600;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'urb-orange': '#F97316',
                        'urb-orangedark': '#EA580C',
                        'urb-coral': '#FB923C',
                        'urb-dark': '#111827',
                        'urb-dark2': '#0F172A',
                        'urb-border': '#E5E7EB',
                        'urb-muted': '#6B7280'
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        .font-script {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        /* Summer radiant background */
        .hero-summer-grad {
            background: linear-gradient(135deg, #FDE68A 0%, #F59E0B 40%, #F97316 80%, #EF4444 100%);
        }

        /* Deal of the Day dark gradient */
        .deal-dark-grad {
            background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        }

        /* Urbanic Club teal gradient */
        .club-teal-grad {
            background: linear-gradient(135deg, #0D9488 0%, #0F766E 50%, #115E59 100%);
        }

        /* Back to top pulse button */
        .btn-top-pulse {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-top-pulse:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-white text-urb-dark font-sans antialiased selection:bg-orange-500 selection:text-white"
      x-data="urbanicApp()">

    <!-- 1. Header Partial -->
    @include('store.themes.urbanic.partials.header')

    <!-- 2. Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 3. Footer Partial -->
    @include('store.themes.urbanic.partials.footer')

    <!-- 4. Mobile Navigation Drawer Partial -->
    @include('store.themes.urbanic.partials.mobile-nav')

    <!-- 5. Floating Back To Top Button -->
    <button type="button"
            @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            x-data="{ showTop: false }"
            @scroll.window="showTop = (window.pageYOffset > 400)"
            x-show="showTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-10"
            class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-orange-500 hover:bg-orange-600 text-white shadow-xl flex items-center justify-center btn-top-pulse"
            aria-label="Back to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- 6. Cart Notification Toast -->
    <div x-data="{ showToast: false, toastMsg: '' }"
         @cart-added.window="toastMsg = $event.detail.name + ' added to bag!'; showToast = true; setTimeout(() => showToast = false, 3000)"
         x-show="showToast"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-5 right-5 sm:bottom-8 sm:right-8 z-50 flex items-center gap-3 bg-urb-dark text-white px-5 py-3.5 rounded-2xl shadow-2xl border border-white/10">
        <div class="w-7 h-7 rounded-full bg-orange-500 text-white flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="text-xs font-bold text-white tracking-wide" x-text="toastMsg"></div>
    </div>

    <!-- Storefront Core Runtime Assets -->
    <script>
        window.tenantDomain = "{{ request()->getHost() }}";
        window.cartCurrency = "$";
    </script>
    <script src="{{ global_asset('js/storefront.min.js') }}"></script>

    <script>
        function urbanicApp() {
            return {
                mobileMenuOpen: false,
                searchQuery: '',
                cartCount: 0,

                init() {
                    this.updateCartCount();
                    window.addEventListener('storage', () => this.updateCartCount());
                    window.addEventListener('cart-updated', () => this.updateCartCount());
                    window.addEventListener('cart-added', () => this.updateCartCount());
                },

                updateCartCount() {
                    if (window.CartLS) {
                        this.cartCount = window.CartLS.count();
                    } else {
                        try {
                            const raw = localStorage.getItem('cart_' + (window.tenantDomain || window.location.hostname));
                            const items = raw ? JSON.parse(raw) : [];
                            this.cartCount = Array.isArray(items) ? items.reduce((sum, item) => sum + (item.quantity || 1), 0) : 0;
                        } catch (e) {
                            this.cartCount = 0;
                        }
                    }
                }
            };
        }
    </script>

</body>
</html>
