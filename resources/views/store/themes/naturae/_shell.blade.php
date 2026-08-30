{{-- Naturae theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $ntTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Naturae');
  $ntHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $ntTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Thoughtfully sourced electronics, fashion, home, beauty, grocery and sporting goods — good for you, good for the planet.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($ntHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          leaf: {
            DEFAULT: '#8A9A5B',
            dark: '#4B5D3A',
            deep: '#3A4930',
            light: '#E7ECD9',
          },
          terracotta: {
            DEFAULT: '#C17A4E',
            dark: '#A05F38',
            light: '#F3DCC9',
          },
          cream: {
            DEFAULT: '#F5F0E6',
            deep: '#EDE4D3',
          },
          bark: '#4A4032',
          ink: '#2E2A22',
        },
        fontFamily: {
          serif: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        borderRadius: {
          '3xl': '1.75rem',
          '4xl': '2.25rem',
        },
        boxShadow: {
          soft: '0 2px 10px -2px rgba(74,64,50,0.10)',
          softHover: '0 18px 34px -14px rgba(74,64,50,0.28)',
          navUp: '0 -8px 24px -12px rgba(74,64,50,0.15)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #C4B79E transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #C4B79E; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #F5F0E6; }
  h1, h2, h3, .font-display { font-family: 'Fraunces', ui-serif, Georgia, serif; }
  .nt-wiggle-underline { text-decoration: underline; text-decoration-color: #C17A4E; text-decoration-thickness: 2px; text-underline-offset: 4px; }
  .nt-ticker { animation: nt-scroll 26s linear infinite; }
  @keyframes nt-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
</style>
