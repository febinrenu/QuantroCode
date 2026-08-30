{{-- Monochra theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $mcTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Monochra');
  $mcHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $mcTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Nothing but the essentials — electronics, fashion, home, beauty and more.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($mcHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            black: '#0A0A0A',
            white: '#FFFFFF',
            red: '#E1231A',
            redDark: '#B81913',
            ink: '#0A0A0A',
            gray: '#6B6B6B',
            line: '#0A0A0A',
            fog: '#F2F2F2',
          }
        },
        fontFamily: {
          display: ['"Archivo Black"', 'sans-serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        borderRadius: {
          none: '0px',
          DEFAULT: '0px',
          lg: '0px',
          xl: '0px',
          '2xl': '0px',
          '3xl': '0px',
          full: '9999px',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #0A0A0A transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #0A0A0A; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #FFFFFF; }
  .mc-photo { filter: grayscale(100%) contrast(1.05); }
  .mc-star { color: #0A0A0A; }
</style>
