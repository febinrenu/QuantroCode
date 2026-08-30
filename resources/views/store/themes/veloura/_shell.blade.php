{{-- Veloura theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $vlTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Veloura');
  $vlHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $vlTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'A curated assortment across electronics, fashion, home and beauty — chosen with care, presented without noise.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          vel: {
            black: '#0F0D0A',
            charcoal: '#1A1613',
            panel: '#17130F',
            line: '#2E2822',
            gold: '#C9A15B',
            goldDark: '#B08947',
            goldSoft: '#E4CE9D',
            burgundy: '#3D1A24',
            burgundyLight: '#5A2534',
            cream: '#F5F1E8',
            ink: '#EDE7DA',
            mute: '#9C9385',
          }
        },
        fontFamily: {
          serif: ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          vlCard: '0 1px 2px rgba(0,0,0,0.4), 0 1px 1px rgba(0,0,0,0.3)',
          vlHover: '0 24px 48px -16px rgba(0,0,0,0.6)',
          vlUp: '0 -8px 24px -12px rgba(0,0,0,0.5)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #3D3730 transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #3D3730; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .22em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #0F0D0A; }
  .vl-rule { height: 1px; background: linear-gradient(90deg, transparent, rgba(201,161,91,0.55), transparent); }
  .vl-rule-solid { height: 1px; background: rgba(201,161,91,0.28); }
  .vl-quote-mark { font-family: 'Playfair Display', serif; line-height: 0.6; }
  .vl-hairline { border-color: rgba(201,161,91,0.18); }
  [x-cloak] { display: none !important; }
</style>
