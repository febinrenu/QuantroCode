@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'ShopIQ');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'shopiq-electronics';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#5B4FE0';
  $accent600 = $themeTokens['color-accent-600'] ?? '#16213E';
  $accent700 = $themeTokens['color-accent-700'] ?? '#F5A623';
  $accent800 = $themeTokens['color-accent-800'] ?? '#EDEBFC';
  $fontHeading = $themeTokens['font-heading'] ?? "'Poppins', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "'Inter', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '14px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Latest tech and top brands, delivered fast.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($themeHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          iq: {
            purple: '{{ $accent500 }}',
            navy: '{{ $accent600 }}',
            gold: '{{ $accent700 }}',
            lav: '{{ $accent800 }}',
            cream: '#F7F7FB',
            mute: '#6B7280',
            line: '#E7E6F5',
          },
        },
        fontFamily: {
          display: ["Poppins", 'sans-serif'],
          sans: ["Inter", 'sans-serif'],
        },
        boxShadow: {
          card: '0 2px 14px rgba(22,33,62,.08)',
          lift: '0 16px 32px rgba(22,33,62,.16)',
        },
      }
    }
  }
</script>

<style>
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
  body {
    font-family: {!! $fontBody !!} !important;
    background: #F7F7FB;
    color: #16213E;
    font-size: {{ $fontSizeBody }} !important;
  }
  h1, h2, h3, .font-display {
    font-family: {!! $fontHeading !!};
  }
  [x-cloak] { display: none !important; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { scrollbar-width: none; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  .eyebrow { letter-spacing: .12em; text-transform: uppercase; }
</style>
