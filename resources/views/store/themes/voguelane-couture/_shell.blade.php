@php
  $activeThemeSlug = 'voguelane-couture';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#D4AF37';
  $accent600 = $themeTokens['color-accent-600'] ?? '#B8860B';
  $accent700 = $themeTokens['color-accent-700'] ?? '#111111';
  $accent800 = $themeTokens['color-accent-800'] ?? '#991B1B';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Bebas Neue\', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '38px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="currency" content="{{ $s->currency_code ?? '$' }}">
  <title>@yield('title', 'VogueLane — Wear Your Signature Style')</title>

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

  <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            vog: {
              black: '#111111',
              charcoal: '#222222',
              tan: '#B88E58',
              tanLight: '#D4B38C',
              sand: '#EFEAE2',
              ivory: '#F9F8F6',
              warm: '#F3EFEA',
              border: '#E8E5DF',
              muted: '#78746D',
              sale: '#D9534F',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
            serif: ['"Playfair Display"', 'Georgia', 'serif'],
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
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #FFFFFF;
      color: #1A1A1A;
      -webkit-font-smoothing: antialiased;
    }
    .font-serif-luxury {
      font-family: 'Playfair Display', Georgia, serif;
    }
    .vog-transition {
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .vog-card {
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .vog-card:hover {
      transform: translateY(-3px);
    }
    /* Hide scrollbar for category strip */
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
<body class="min-h-full flex flex-col antialiased selection:bg-black selection:text-white" x-data="{ mobileMenuOpen: false, searchOpen: false }">

  {{-- Global Header --}}
  @include('store.themes.voguelane-couture.partials.header')

  {{-- Mobile Navigation Drawer --}}
  @include('store.themes.voguelane-couture.partials.mobile-nav')

  {{-- Main Page Content --}}
  <main class="flex-1">
    @yield('content')
  </main>

  {{-- Global Footer --}}
  @include('store.themes.voguelane-couture.partials.footer')

  {{-- Toast notification container for stock/cart alerts --}}
  <div id="store-stock-toast" class="fixed bottom-5 right-5 z-50 pointer-events-none"></div>

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
