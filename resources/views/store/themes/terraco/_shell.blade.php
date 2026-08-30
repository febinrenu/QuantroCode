{{-- Terraco theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $trTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Terraco');
  $trHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $trTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Less noise, better choices — general merchandise across every category.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($trHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=IBM+Plex+Sans:wght@400;500&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          terra: {
            bg: '#FAFAF8',
            surface: '#FFFFFF',
            ink: '#2E3742',
            inkSoft: '#5B6672',
            slate: '#4A5A6A',
            slateDark: '#2E3742',
            line: '#E4E1D9',
            lineStrong: '#C9C4B7',
            sand: '#D8CFC2',
            rust: '#B0714F',
          }
        },
        fontFamily: {
          heading: ['Inter', 'system-ui', 'sans-serif'],
          sans: ['IBM Plex Sans', 'system-ui', 'sans-serif'],
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #C9C4B7 transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #C9C4B7; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'IBM Plex Sans', system-ui, sans-serif; background: #FAFAF8; color: #2E3742; }
  h1, h2, h3, h4, .font-heading { font-family: 'Inter', system-ui, sans-serif; }
  /* Terraco is flat by design — no drop shadows anywhere, thin 1px borders only */
  .no-shadow, * { box-shadow: none !important; }
</style>
