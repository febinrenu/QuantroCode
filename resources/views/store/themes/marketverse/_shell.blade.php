{{-- MarketVerse theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'MarketVerse');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'marketverse';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '{{ $accent500 }}';
  $accent600 = $themeTokens['color-accent-600'] ?? '{{ $accent600 }}';
  $accent700 = $themeTokens['color-accent-700'] ?? '{{ $accent700 }}';
  $accent800 = $themeTokens['color-accent-800'] ?? '{{ $accent800 }}';
  $fontHeading = $themeTokens['font-heading'] ?? "'Inter', sans-serif";
  $fontBody = $themeTokens['font-body'] ?? "'Inter', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '32px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Your world of shopping, in one cart — electronics, fashion, home, beauty, grocery and sports, all in dense marketplace grids.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          mv: {
            ink: '{{ $accent700 }}',
            inkDark: '#111827',
            accent: '{{ $accent500 }}',
            accentDark: '{{ $accent600 }}',
            accentLight: '{{ $accent800 }}',
            accentSoft: '#FFF3E6',
            cream: '#F7F5F2',
            line: '#E7E2DB',
            slate: '#6B7280',
          }
        },
        fontFamily: {
          sans: ['Inter', 'system-ui', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
        },
        boxShadow: {
          tile: '0 1px 2px rgba(31,41,55,0.06), 0 1px 1px rgba(31,41,55,0.05)',
          tileHover: '0 10px 22px -10px rgba(31,41,55,0.28)',
          railUp: '0 -8px 20px -12px rgba(31,41,55,0.18)',
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

  * { scrollbar-width: thin; scrollbar-color: #D8CFC2 transparent; }
  ::-webkit-scrollbar { height: 7px; width: 7px; }
  ::-webkit-scrollbar-thumb { background: #D8CFC2; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #F7F5F2; }
  .mv-mono { font-family: '"JetBrains Mono"', ui-monospace, monospace; }
  .mv-ticker-track { animation: mv-scroll 32s linear infinite; }
  .mv-ticker-track:hover { animation-play-state: paused; }
  @keyframes mv-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .mv-chip { font-family: '"JetBrains Mono"', ui-monospace, monospace; letter-spacing: .01em; }
  .mv-grid-dense { display: grid; gap: 0.75rem; }
</style>
