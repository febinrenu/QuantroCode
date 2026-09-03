@php
  $activeThemeSlug = 'technova-audio';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#2563EB';
  $accent600 = $themeTokens['color-accent-600'] ?? '#1D4ED8';
  $accent700 = $themeTokens['color-accent-700'] ?? '#06B6D4';
  $accent800 = $themeTokens['color-accent-800'] ?? '#0F172A';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Outfit\', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '32px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', ($s->store_name ?? 'TechNova') . ' | Premium Electronics & Smart Devices')</title>
  <meta name="description" content="@yield('meta_description', 'Upgrade your tech lifestyle with TechNova. Shop the latest flagship smartphones, laptops, audio, gaming, and smart home innovation.')">

  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            technova: {
              blue: '#2563EB',
              blueHover: '#1D4ED8',
              blueLight: '#EFF6FF',
              cyan: '#06B6D4',
              dark: '#0F172A',
              slate: '#1E293B',
              muted: '#64748B',
              border: '#E2E8F0',
              bg: '#F8FAFC',
              card: '#FFFFFF',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
            heading: ['"Outfit"', 'system-ui', 'sans-serif'],
          },
          boxShadow: {
            'tech-sm': '0 1px 3px 0 rgba(15, 23, 42, 0.05)',
            'tech-md': '0 4px 14px 0 rgba(15, 23, 42, 0.07)',
            'tech-lg': '0 10px 25px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03)',
            'tech-hover': '0 14px 30px -4px rgba(37, 99, 235, 0.12), 0 6px 12px -2px rgba(15, 23, 42, 0.06)',
          }
        }
      }
    }
  </script>

  <style>
    [x-cloak] { display: none !important; }
    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
      background-color: #F8FAFC;
      color: #0F172A;
      -webkit-font-smoothing: antialiased;
    }
    h1, h2, h3, h4, h5, h6, .font-heading {
      font-family: 'Outfit', system-ui, sans-serif !important;
      letter-spacing: -0.02em;
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  </style>

  <!-- Global Storefront Flags -->
  <script>
    window.__STORE_CURRENCY__ = @json($s->currency_code ?? '$');
    window.__STORE_DECIMALS__ = @json((int) ($s->currency_decimals ?? 2));
    window.__DECIMAL_SEPARATOR__ = @json($s->decimal_separator ?? '.');
    window.__THOUSANDS_SEPARATOR__ = @json($s->thousands_separator ?? ',');
    window.__CURRENCY_POSITION__ = @json($s->currency_position ?? 'before');
    window.__LOGGED_IN__ = @json(auth('store')->check());
    window.__ALLOW_OVERSELLING__ = @json((bool) ($s->allow_overselling ?? true));
    window.__HIDE_PRICES__ = @json(!auth('store')->check() && ($s->hide_prices_for_guests ?? false));
    window.__SHOW_STOCK__ = @json((bool) ($s->show_stock ?? true));
    window.__ACTIVE_THEME__ = 'technova';
    window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
    window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
    window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
    window.__MSG_ADDED__        = @json(__('messages.Added'));
  </script>

  @stack('head')
</head>
<body class="min-h-full flex flex-col antialiased bg-slate-50 text-slate-900" x-data="{ mobileNavOpen: false }">

  <!-- Header -->
  @include('store.themes.technova-audio.partials.header')

  <!-- Mobile Drawer Navigation -->
  @include('store.themes.technova-audio.partials.mobile-nav')

  <!-- Main Content Area -->
  <main class="flex-1">
    @yield('content')
  </main>

  <!-- Footer -->
  @include('store.themes.technova-audio.partials.footer')

  <!-- Storefront Single Bundled Alpine Runtime -->
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
