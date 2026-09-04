<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Nexora — Shop Different. Make Every Day Easier')</title>
    <meta name="description" content="@yield('meta_description', 'Discover trending products, exclusive deals, and new arrivals all in one place at Nexora.')">

    <!-- Google Fonts: Plus Jakarta Sans -->
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
                        nex: {
                            blue: '#2457D6',
                            bluedark: '#1D4ED8',
                            bluelight: '#EEF4FF',
                            navy: '#101A3A',
                            navydark: '#0B1126',
                            royal: '#2457D6',
                            purple: '#7C3AED',
                            indigo: '#4338CA',
                            coral: '#F97316',
                            orange: '#FB923C',
                            yellow: '#FBBF24',
                            pink: '#EC4899',
                            teal: '#0D9488',
                            bg: '#F8FAFC',
                            surface: '#FFFFFF',
                            border: '#E2E8F0',
                            text: '#101A3A',
                            muted: '#64748B'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                        heading: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #101A3A;
        }
        [x-cloak] { display: none !important; }

        .promo-deal-grad {
            background: linear-gradient(135deg, #7C3AED 0%, #9333EA 50%, #C026D3 100%);
        }
        .promo-trending-grad {
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        }
        .promo-summer-grad {
            background: linear-gradient(135deg, #CCFBF1 0%, #99F6E4 50%, #5EEAD4 100%);
        }
        .newsletter-grad {
            background: linear-gradient(90deg, #6D28D9 0%, #C026D3 45%, #F97316 100%);
        }
    </style>

    <!-- Global Storefront Flags for CartLS -->
    <script>
        window.__STORE_CURRENCY__ = @json($s->currency_code ?? '$');
        window.__STORE_DECIMALS__ = @json((int) ($s->currency_decimals ?? 2));
        window.__DECIMAL_SEPARATOR__ = @json($s->decimal_separator ?? '.');
        window.__THOUSANDS_SEPARATOR__ = @json($s->thousands_separator ?? ',');
        window.__CURRENCY_POSITION__ = @json($s->currency_position ?? 'before');
        window.__LOGGED_IN__ = @json(auth('store')->check());
        window.__ALLOW_OVERSELLING__ = @json((bool) ($s->allow_overselling ?? false));
        window.__HIDE_PRICES__ = @json(!auth('store')->check() && ($s->hide_prices_for_guests ?? false));
        window.__SHOW_STOCK__ = @json((bool) ($s->show_stock ?? true));
        window.__ACTIVE_THEME__ = 'nexora';
    </script>

    @stack('styles')
</head>
<body class="bg-nex-bg text-nex-text antialiased min-h-screen flex flex-col selection:bg-nex-blue selection:text-white"
      x-data="{ mobileMenuOpen: false }">

    <!-- Header -->
    @include('store.themes.nexora.partials.header')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.nexora.partials.mobile-nav')

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('store.themes.nexora.partials.footer')

    <!-- Single Bundled Storefront Alpine Runtime with CartLS & miniCart() -->
    <script src="{{ global_asset('js/storefront.min.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
