{{-- Elegance theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $elTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Elegance');
  $elHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $elTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Refined, for every room and every look — electronics, fashion, home, beauty, grocery and more.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($elHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,400;0,600;1,400;1,500&family=Inter:wght@400;500;600&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            cream: '#FBF6EE',
            paper: '#F4EDE0',
            charcoal: '#2A2622',
            charcoalSoft: '#645C52',
            gold: '#9C7A4A',
            goldDark: '#7C6039',
            hairline: '#DED4C2',
          }
        },
        fontFamily: {
          serif: ['Fraunces', 'ui-serif', 'Georgia', 'serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #DED4C2 transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #DED4C2; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #FBF6EE; color: #2A2622; }
  .el-caption { font-family: 'Fraunces', serif; font-style: italic; }
  .el-hairline { border-color: #DED4C2; }
</style>
