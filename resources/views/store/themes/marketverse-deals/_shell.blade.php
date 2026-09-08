@php
  $activeThemeSlug = 'marketverse-deals';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#4F28D9';
  $accent600 = $themeTokens['color-accent-600'] ?? '#FF5722';
  $accent700 = $themeTokens['color-accent-700'] ?? '#FFB800';
  $accent800 = $themeTokens['color-accent-800'] ?? '#0F172A';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Inter\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '32px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="currency" content="{{ $s->currency_code ?? '$' }}">
  <title>@yield('title', 'MarketVerse — Everything from Every Store, All in One Marketplace')</title>

  <!-- Global Storefront State Initialization -->
  <script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
  <script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
  <script>window.__HIDE_PRICES__ = @json(!Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false));</script>
  <script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
  <script>
    window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
    window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
    window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
    window.__MSG_ADDED__        = @json(__('messages.Added'));
  </script>

  <!-- Google Fonts: Inter & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            mv: {
              purple: '#4F28D9',
              purpleDark: '#371B97',
              purpleDeep: '#220F63',
              purpleLight: '#F3EFFF',
              purpleBadge: '#7C3AED',
              orange: '#FF5722',
              orangeHover: '#E64A19',
              gold: '#FFB800',
              goldDark: '#D97706',
              bg: '#F4F6F8',
              card: '#FFFFFF',
              border: '#E2E8F0',
              borderLight: '#EDF2F7',
              slateDark: '#0F172A',
              slateMuted: '#64748B',
            }
          },
          fontFamily: {
            sans: ['"Inter"', '"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- Storefront Core JS (bundles Alpine.js, CartLS, and UI components) -->
  <script src="{{ global_asset('js/storefront.min.js') }}" defer></script>

  <style>
    [x-cloak] { display: none !important; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #F4F6F8;
      color: #0F172A;
      -webkit-font-smoothing: antialiased;
    }
    .mv-transition {
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .mv-card {
      transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .mv-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -5px rgba(79, 40, 217, 0.1);
    }
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>

  @stack('styles')
</head>
<body class="min-h-full flex flex-col antialiased selection:bg-[#4F28D9] selection:text-white" x-data="{ mobileMenuOpen: false, searchOpen: false }">

  <!-- Header -->
  @include('store.themes.marketverse-deals.partials.header')

  <!-- Mobile Drawer -->
  @include('store.themes.marketverse-deals.partials.mobile-nav')

  <!-- Main Content -->
  <main class="flex-1 w-full">
    @yield('content')
  </main>

  <!-- Footer -->
  @include('store.themes.marketverse-deals.partials.footer')

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
