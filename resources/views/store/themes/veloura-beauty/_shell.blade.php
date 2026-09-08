@php
  $activeThemeSlug = 'veloura-beauty';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#C99A82';
  $accent600 = $themeTokens['color-accent-600'] ?? '#A36D55';
  $accent700 = $themeTokens['color-accent-700'] ?? '#CBA135';
  $accent800 = $themeTokens['color-accent-800'] ?? '#2D2426';
  $fontHeading = $themeTokens['font-heading'] ?? "\'Playfair Display\', serif";
  $fontBody = $themeTokens['font-body'] ?? "\'Plus Jakarta Sans\', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', ($s->store_name ?? 'Veloura Beauty') . ' — Scent. Glow. Indulge.')</title>
  <meta name="description" content="@yield('meta_description', 'Discover luxurious fragrances, clean skincare, and effortless beauty rituals at Veloura Beauty.')">

  <!-- Google Fonts: Playfair Display & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            vel: {
              rose: '#C99A82',
              roseDark: '#A36D55',
              roseDeep: '#87513C',
              roseLight: '#F7EDE6',
              blush: '#FAF3ED',
              cream: '#FAF6F0',
              creamWarm: '#F5ECE3',
              sand: '#EFE4D8',
              charcoal: '#2D2426',
              espresso: '#3D3134',
              gold: '#CBA135',
              border: '#EBE0D5',
              borderLight: '#F5ECE4',
              muted: '#7D726D',
            }
          },
          fontFamily: {
            heading: ['"Playfair Display"', 'Georgia', 'serif'],
            sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    [x-cloak] { display: none !important; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #FAF6F0;
      color: #2D2426;
    }
    .font-serif-luxury {
      font-family: 'Playfair Display', Georgia, serif;
    }
    .vel-card {
      transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
    }
    .vel-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 32px -8px rgba(163, 109, 85, 0.14);
      border-color: #C99A82;
    }
    .vel-gradient-hero {
      background: linear-gradient(135deg, #F8EEE6 0%, #F3E3D5 50%, #EBD8CA 100%);
    }
    .vel-gradient-card {
      background: linear-gradient(180deg, #FFFFFF 0%, #FAF6F0 100%);
    }
    .vel-gradient-gold {
      background: linear-gradient(135deg, #DFBA48 0%, #C89928 100%);
    }
  </style>

  <!-- Global Storefront Flags -->
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
    window.__ACTIVE_THEME__ = 'veloura';
  </script>

  @stack('head')
</head>
<body class="min-h-full flex flex-col antialiased bg-vel-blush text-vel-charcoal" x-data="{ mobileNavOpen: false, searchOpen: false }">

  <!-- Top Announcement Bar -->
  <div class="bg-vel-espresso text-white text-[11px] font-medium py-2 px-4 border-b border-vel-espresso/50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="hidden md:flex items-center gap-6">
        <span class="flex items-center gap-1.5 text-rose-200">
          <span>✨</span> Free Luxury Samples on Every Order
        </span>
        <span class="text-white/40">|</span>
        <span class="flex items-center gap-1.5 text-slate-300">
          <span>🌿</span> 100% Clean Beauty Promise
        </span>
      </div>
      <div class="text-center md:text-left mx-auto md:mx-0 font-semibold tracking-wide text-rose-100">
        Complimentary Express Delivery on Orders Over $75
      </div>
      <div class="hidden lg:flex items-center gap-5 text-slate-300">
        <a href="#store-locator" class="hover:text-rose-200 transition-colors">Store Locator</a>
        <span>•</span>
        <a href="#veloura-club" class="hover:text-rose-200 transition-colors">Veloura Rewards</a>
        <span>•</span>
        <span class="text-white font-bold">USD ($)</span>
      </div>
    </div>
  </div>

  <!-- Header -->
  @include('store.themes.veloura-beauty.partials.header')

  <!-- Mobile Drawer Navigation -->
  @include('store.themes.veloura-beauty.partials.mobile-nav')

  <!-- Main Content Area -->
  <main class="flex-1">
    @yield('content')
  </main>

  <!-- Footer -->
  @include('store.themes.veloura-beauty.partials.footer')

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
