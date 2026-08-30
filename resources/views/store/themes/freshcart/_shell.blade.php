{{-- FreshCart theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $fcTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'FreshCart');
  $fcHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $fcTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Fresh picks, delivered daily — shop electronics, fashion, home, beauty, grocery and more in one warm, friendly marketplace.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($fcHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            cream: '#FBF1D6',
            creamDark: '#F3E4B8',
            green: '#1F9D55',
            greenDark: '#167A42',
            greenDeep: '#14532D',
            greenLight: '#E4F5EA',
            orange: '#F0800F',
            orangeDark: '#C86608',
            orangeLight: '#FDEBD6',
            ink: '#20301F',
            inkSoft: '#5B6B54',
          }
        },
        fontFamily: {
          sans: ['Poppins', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(32,48,31,0.07), 0 1px 1px rgba(32,48,31,0.05)',
          cardHover: '0 16px 30px -10px rgba(20,83,45,0.22)',
          navUp: '0 -8px 24px -12px rgba(32,48,31,0.16)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #d9c98d transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #d9c98d; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Poppins', system-ui, sans-serif; background: #FBF1D6; }
  .fc-ticker { animation: fc-scroll 24s linear infinite; }
  @keyframes fc-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }

  /* Countdown chips (static, no JS timer) */
  .fc-countdown-chip {
    background: rgba(0,0,0,.32);
    backdrop-filter: blur(2px);
    border: 1px solid rgba(255,255,255,.25);
  }

  /* Aisle strip: horizontally scrollable chip row */
  .fc-aisle-scroll { scroll-snap-type: x proximity; }
  .fc-aisle-scroll > * { scroll-snap-align: start; }

  /* Tabs underline animation */
  .fc-tab-btn[aria-selected="true"] { color: #167A42; }
</style>
