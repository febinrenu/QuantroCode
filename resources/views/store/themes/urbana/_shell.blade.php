{{-- Urbana theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Urbana');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'urbana';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '{{ $accent500 }}';
  $accent600 = $themeTokens['color-accent-600'] ?? '{{ $accent600 }}';
  $accent700 = $themeTokens['color-accent-700'] ?? '{{ $accent700 }}';
  $accent800 = $themeTokens['color-accent-800'] ?? '{{ $accent800 }}';
  $fontHeading = $themeTokens['font-heading'] ?? "'Quicksand', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "'Inter', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '32px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Shopping that feels like home — electronics, fashion, home, beauty, grocery and sports, all in one friendly place.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            blue: '{{ $accent500 }}',
            blueDark: '{{ $accent600 }}',
            blueLight: '#EAF1FF',
            coral: '{{ $accent700 }}',
            coralDark: '{{ $accent800 }}',
            coralLight: '#FFE9E6',
            cream: '#FBFAF8',
            ink: '#2B2B2B',
            sub: '#6B7280',
          }
        },
        fontFamily: {
          heading: ['Quicksand', 'sans-serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        borderRadius: {
          '4xl': '2rem',
          '5xl': '2.5rem',
        },
        boxShadow: {
          soft: '0 20px 40px -12px rgba(91,141,239,0.25)',
          softCoral: '0 20px 40px -12px rgba(255,111,97,0.28)',
          softHover: '0 28px 56px -14px rgba(91,141,239,0.34)',
          navUp: '0 -12px 30px -14px rgba(91,141,239,0.25)',
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
    font-size: {{ $fontSizeBody }} !important;
  }
  h1, .hero-title, [class*="-hero"] h1, .font-display, .font-head, .font-serif {
    font-size: {{ $fontSizeHeading }};
    font-family: {!! $fontHeading !!};
  }

  * { scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #FBFAF8; }
  h1,h2,h3,h4,h5,h6,.font-heading { font-family: 'Quicksand', sans-serif; }
  .ur-blob { animation: ur-float 9s ease-in-out infinite; }
  .ur-blob-slow { animation: ur-float 13s ease-in-out infinite; }
  @keyframes ur-float { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-16px) scale(1.03); } }
</style>
