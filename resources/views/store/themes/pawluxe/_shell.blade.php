{{-- PawLuxe theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'PawLuxe');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'pawluxe';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#3E8C74';
  $accent600 = $themeTokens['color-accent-600'] ?? '#22201D';
  $accent700 = $themeTokens['color-accent-700'] ?? '#F0725F';
  $accent800 = $themeTokens['color-accent-800'] ?? '#DDEFE6';
  $fontHeading = $themeTokens['font-heading'] ?? "'Baloo 2', cursive";
  $fontBody = $themeTokens['font-body'] ?? "'Nunito Sans', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '34px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '14px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Premium products for every tail wag, purr and tiny paw.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito+Sans:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          pl: {
            teal: '{{ $accent500 }}',
            ink: '{{ $accent600 }}',
            coral: '{{ $accent700 }}',
            mint: '{{ $accent800 }}',
            cream: '#F7FBF9',
            mute: '#6B756F',
            line: '#E3EFE9',
          },
        },
        fontFamily: {
          display: ["Baloo 2", 'cursive'],
          sans: ["Nunito Sans", 'sans-serif'],
        },
        boxShadow: {
          card: '0 2px 14px rgba(34,32,29,.07)',
          lift: '0 16px 32px rgba(34,32,29,.14)',
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
    background: #F7FBF9;
    color: #22201D;
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
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
</style>
