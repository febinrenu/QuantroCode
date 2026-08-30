{{-- Retropop theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $rpTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Retropop');
  $rpHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $rpTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Shop like it\'s the best decade ever — electronics, fashion, home, beauty, grocery and more, all in one groovy place.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($rpHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          pop: {
            mustard: '#E8A33D',
            mustardDark: '#C77F1E',
            orange: '#D9622B',
            orangeDark: '#B8471E',
            teal: '#2A7F7E',
            tealDark: '#1D5C5B',
            cream: '#FFF8EC',
            ink: '#3A2317',
            plum: '#7A3B4E',
          }
        },
        fontFamily: {
          heading: ['"Baloo 2"', 'cursive'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        borderRadius: {
          groovy: '2rem',
        },
        boxShadow: {
          pop: '0 6px 0 rgba(58,35,23,0.15)',
          popHover: '0 10px 0 rgba(58,35,23,0.18)',
          card: '0 2px 10px rgba(58,35,23,0.08)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #D9622B transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #D9622B; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #FFF8EC; }
  h1, h2, h3, h4, .font-heading { font-family: '"Baloo 2"', 'Baloo 2', cursive; }
  .rp-ticker { animation: rp-scroll 24s linear infinite; }
  @keyframes rp-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .rp-wave { display: block; width: 100%; height: 32px; }
  @media (min-width: 1024px) { .rp-wave { height: 48px; } }
  .rp-sunburst { position: absolute; inset: 0; z-index: 0; }
</style>
