{{-- CrystalGlass theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'CrystalGlass');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'crystalglass';
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
<meta name="description" content="{{ $s->seo_meta_description ?? 'Shopping, reimagined — electronics, fashion, home, beauty, grocery and more.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            blue: '{{ $accent700 }}',
            purple: '#A78BFA',
            pink: '{{ $accent800 }}',
            violet: '{{ $accent500 }}',
            violetDark: '{{ $accent600 }}',
            ink: '#1E1B2E',
            mist: '#F1EEFC',
          }
        },
        fontFamily: {
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          glass: '0 8px 32px 0 rgba(109,90,230,0.16)',
          glassHover: '0 16px 48px -8px rgba(109,90,230,0.28)',
          navUp: '0 -8px 32px -12px rgba(109,90,230,0.2)',
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

  * { scrollbar-width: thin; scrollbar-color: #c4b5fd transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #c4b5fd; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .16em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body {
    font-family: 'Inter', system-ui, sans-serif;
    background: #F1EEFC;
    color: #1E1B2E;
    position: relative;
  }

  /* ===== Gradient mesh background — fixed, visible behind every page ===== */
  .cg-mesh { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
  .cg-blob { position: absolute; border-radius: 9999px; filter: blur(80px); opacity: .55; }
  .cg-blob-1 { top: -12%; left: -10%; width: 46vw; height: 46vw; background: radial-gradient(circle, #6D8CFF 0%, rgba(109,140,255,0) 72%); }
  .cg-blob-2 { top: 30%; right: -14%; width: 50vw; height: 50vw; background: radial-gradient(circle, #A78BFA 0%, rgba(167,139,250,0) 72%); }
  .cg-blob-3 { bottom: -18%; left: 22%; width: 48vw; height: 48vw; background: radial-gradient(circle, #F9A8D4 0%, rgba(249,168,212,0) 72%); }

  /* ===== Reusable glass utilities ===== */
  .glass {
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.55);
  }
  .glass-dark {
    background: rgba(30,27,46,0.62);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.08);
  }
  .glass-strong {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.6);
  }
  .cg-ticker { animation: cg-scroll 24s linear infinite; }
  @keyframes cg-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
</style>
