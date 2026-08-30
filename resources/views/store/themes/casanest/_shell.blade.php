{{-- Casanest theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $cnTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Casanest');
  $cnHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $cnTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Timeless pieces, thoughtfully chosen — electronics, fashion, home, beauty and more, curated with care.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($cnHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          cn: {
            emerald: '#0B3D2E',
            emeraldDark: '#062A20',
            emeraldLight: '#123F31',
            gold: '#C9A15B',
            goldLight: '#E4CB98',
            cream: '#F5F1E6',
            ink: '#161512',
            mute: '#6B6558',
          }
        },
        fontFamily: {
          serif: ['Cormorant Garamond', 'Georgia', 'serif'],
          sans: ['Montserrat', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 3px rgba(11,61,46,0.08)',
          cardHover: '0 20px 40px -16px rgba(11,61,46,0.35)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #C9A15B #F5F1E6; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #C9A15B; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Montserrat', system-ui, sans-serif; background: #F5F1E6; }
  h1, h2, h3, h4, .font-display { font-family: 'Cormorant Garamond', Georgia, serif; }
  .eyebrow { letter-spacing: .22em; text-transform: uppercase; }
  .cn-frame { position: relative; }
  .cn-frame::before, .cn-frame::after {
    content: ''; position: absolute; width: 26px; height: 26px; pointer-events: none;
    border-color: #C9A15B; border-style: solid;
  }
  .cn-frame::before { top: -1px; left: -1px; border-width: 2px 0 0 2px; }
  .cn-frame::after { bottom: -1px; right: -1px; border-width: 0 2px 2px 0; }
  .cn-frame-full::before, .cn-frame-full::after { content: none; }
  .cn-corner-tr { position: absolute; top: -1px; right: -1px; width: 26px; height: 26px; border-color: #C9A15B; border-style: solid; border-width: 2px 2px 0 0; }
  .cn-corner-bl { position: absolute; bottom: -1px; left: -1px; width: 26px; height: 26px; border-color: #C9A15B; border-style: solid; border-width: 0 0 2px 2px; }
  .cn-gold-rule { height: 1px; background: linear-gradient(90deg, transparent, #C9A15B, transparent); }
</style>
