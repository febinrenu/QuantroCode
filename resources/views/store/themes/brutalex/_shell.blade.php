{{-- Brutalex theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $bxTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'BRUTALEX');
  $bxHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $bxTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'No fluff. Just the goods. Electronics, fashion, home, beauty, grocery and sports — one raw storefront.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($bxHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=JetBrains+Mono:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ink: {
            black: '#0A0A0A',
            red: '#E5303A',
            redDark: '#B7212A',
            paper: '#FFFFFF',
            fog: '#F2F2F2',
            steel: '#D8D8D8',
          }
        },
        fontFamily: {
          head: ['"Archivo Black"', 'Impact', 'sans-serif'],
          mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
          sans: ['system-ui', '-apple-system', 'Segoe UI', 'Arial', 'sans-serif'],
        },
        borderRadius: {
          none: '0px',
          DEFAULT: '0px',
          full: '9999px',
        },
      }
    }
  }
</script>

<style>
  * { border-radius: 0 !important; scrollbar-width: thin; scrollbar-color: #0A0A0A transparent; }
  ::-webkit-scrollbar { height: 10px; width: 10px; }
  ::-webkit-scrollbar-thumb { background: #0A0A0A; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'JetBrains Mono', ui-monospace, monospace; background: #FFFFFF; color: #0A0A0A; }
  h1,h2,h3,h4,h5,h6,.bx-head { font-family: '"Archivo Black"', 'Archivo Black', Impact, sans-serif; letter-spacing: -0.01em; text-transform: uppercase; }
  .bx-copy { font-family: system-ui, -apple-system, 'Segoe UI', Arial, sans-serif; }
  .bx-shadow { box-shadow: 6px 6px 0 #0A0A0A; }
  .bx-shadow-sm { box-shadow: 4px 4px 0 #0A0A0A; }
  .bx-shadow-red { box-shadow: 6px 6px 0 #E5303A; }
  .bx-shadow-hover:hover { box-shadow: 9px 9px 0 #0A0A0A; transform: translate(-2px,-2px); }
  .bx-shadow-hover { transition: box-shadow .12s ease, transform .12s ease; }
  .bx-marquee { animation: bx-scroll 24s linear infinite; }
  @keyframes bx-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
</style>
