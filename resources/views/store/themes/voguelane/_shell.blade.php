{{-- Voguelane theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $vlTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Voguelane');
  $vlHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $vlTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Bold style across electronics, fashion, home, beauty, grocery and sports — all in one lane.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($vlHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            black: '#111111',
            ink: '#0A0A0A',
            white: '#FFFFFF',
            magenta: '#E4006F',
            magentaDark: '#B8005A',
            paper: '#F5F5F5',
            line: '#E5E5E5',
          }
        },
        fontFamily: {
          display: ['"Bebas Neue"', 'Impact', 'sans-serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        clipPath: {},
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #E4006F transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #E4006F; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #FFFFFF; }
  .font-display { font-family: 'Bebas Neue', Impact, sans-serif; letter-spacing: .01em; }
  .vl-clip-left { clip-path: polygon(0 0, 100% 0, 82% 100%, 0% 100%); }
  .vl-clip-right { clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%); }
  @media (max-width: 1023px) {
    .vl-clip-left, .vl-clip-right { clip-path: none; }
  }
  .vl-scroll-strip { scroll-snap-type: x mandatory; }
  .vl-scroll-strip > * { scroll-snap-align: start; }
</style>
