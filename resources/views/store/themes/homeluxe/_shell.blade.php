{{-- HomeLuxe theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'HomeLuxe');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'homeluxe';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#1F3D30';
  $accent600 = $themeTokens['color-accent-600'] ?? '#16281F';
  $accent700 = $themeTokens['color-accent-700'] ?? '#C9A876';
  $accent800 = $themeTokens['color-accent-800'] ?? '#EFE6D3';
  $fontHeading = $themeTokens['font-heading'] ?? "'Playfair Display', serif";
  $fontBody = $themeTokens['font-body'] ?? "'DM Sans', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '36px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '14px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Furniture and home decor to live beautifully.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          hl: {
            forest: '{{ $accent500 }}',
            deep: '{{ $accent600 }}',
            gold: '{{ $accent700 }}',
            goldLight: '{{ $accent800 }}',
            cream: '#F8F5EE',
            ink: '#1C201C',
            mute: '#6B6F68',
            line: '#E7E1D4',
          },
        },
        fontFamily: {
          display: ["Playfair Display", 'serif'],
          serif: ["Playfair Display", 'serif'],
          sans: ["DM Sans", 'sans-serif'],
        },
        boxShadow: {
          card: '0 2px 14px rgba(22,40,31,.08)',
          lift: '0 16px 32px rgba(22,40,31,.16)',
        },
        borderRadius: {
          '4xl': '2rem',
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
    background: #F8F5EE;
    color: #1C201C;
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
  .eyebrow { letter-spacing: .16em; text-transform: uppercase; }
  .hl-hero {
    background: url('{{ global_asset('images/themes/homeluxe/hero-photo.png') }}') center/cover;
  }
  .hl-news {
    background: linear-gradient(120deg, rgba(22,40,31,.97), rgba(31,61,48,.9));
  }
</style>
