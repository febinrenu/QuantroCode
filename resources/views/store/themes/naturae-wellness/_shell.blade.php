@php
  $activeThemeSlug = 'naturae-wellness';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#4C6B52';
  $accent600 = $themeTokens['color-accent-600'] ?? '#38523D';
  $accent700 = $themeTokens['color-accent-700'] ?? '#253B2A';
  $accent800 = $themeTokens['color-accent-800'] ?? '#182E20';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Playfair Display\', serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Naturae — Clean. Conscious. Care. Pure Essentials for a Better You')</title>
    <meta name="description" content="@yield('meta_description', 'Thoughtfully crafted natural wellness and organic beauty products made with pure ingredients for your everyday lifestyle.')">

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
                        naturae: {
                            dark: '#14241a',
                            forest: '#1b3223',
                            green: '#24422e',
                            sage: '#4c6b52',
                            lightgreen: '#eaf0eb',
                            bg: '#f9f6f0',
                            sand: '#f4eee6',
                            card: '#ffffff',
                            border: '#e8e2d7',
                            muted: '#6b7b6e',
                            text: '#1a281e'
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Playfair Display"', 'Georgia', 'serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f9f6f0;
            color: #1a281e;
        }
        h1, h2, h3, .font-serif, .font-heading {
            font-family: 'Playfair Display', Georgia, serif;
        }
        [x-cloak] { display: none !important; }

        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
        window.__ACTIVE_THEME__ = 'naturae';
    </script>

    @stack('styles')
</head>
<body class="bg-naturae-bg text-naturae-text antialiased min-h-screen flex flex-col selection:bg-naturae-forest selection:text-white"
      x-data="{ mobileMenuOpen: false }">

    <!-- Header & Announcement Bar -->
    @include('store.themes.naturae-wellness.partials.header')

    <!-- Mobile Navigation Drawer -->
    @include('store.themes.naturae-wellness.partials.mobile-nav')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('store.themes.naturae-wellness.partials.footer')

    <!-- Storefront Single Bundled Alpine Runtime with CartLS & miniCart() -->
    <script src="{{ global_asset('js/storefront.min.js') }}" defer></script>

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
