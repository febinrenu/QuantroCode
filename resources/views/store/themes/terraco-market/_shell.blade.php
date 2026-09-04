{{-- Terra & Co. theme shell — Tailwind CDN + config + fonts --}}
@php
  $tcTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Terra & Co.');
  $tcHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $tcTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('terraco-market', $s->theme_tokens ?? []);
  $tcGreen = $tcTokens['color-accent-500'] ?? '#24331D';
  $tcGold = $tcTokens['color-accent-600'] ?? '#C9A15B';
  $tcGreenDeep = \App\Support\StorefrontThemeRegistry::shade($tcGreen, -0.25);
  $tcGreenSoft = \App\Support\StorefrontThemeRegistry::shade($tcGreen, 0.35);
  $tcGoldSoft = \App\Support\StorefrontThemeRegistry::shade($tcGold, 0.55);
  $tcFontHeading = $tcTokens['font-heading'] ?? "'Playfair Display', serif";
  $tcFontBody = $tcTokens['font-body'] ?? "'Inter', sans-serif";
@endphp
<meta charset="utf-8" />
<title>{{ $tcTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Premium ingredients sourced from the finest producers around the world.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($tcHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          tc: {
            cream: '#F8F4EA',
            creamDark: '#EFE7D3',
            green: '{{ $tcGreen }}',
            greenDeep: '{{ $tcGreenDeep }}',
            greenSoft: '{{ $tcGreenSoft }}',
            gold: '{{ $tcGold }}',
            goldSoft: '{{ $tcGoldSoft }}',
            ink: '#23281F',
            inkSoft: '#5F6857',
          }
        },
        fontFamily: {
          serif: [{!! json_encode($tcFontHeading) !!}, 'serif'],
          sans: [{!! json_encode($tcFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(26,36,21,0.08), 0 1px 1px rgba(26,36,21,0.05)',
          cardHover: '0 18px 32px -12px rgba(26,36,21,0.28)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #C9A15B transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #C9A15B; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $tcFontBody }}, system-ui, sans-serif; background: #F8F4EA; color: #23281F; }
  .tc-hero-italic { font-style: italic; font-weight: 500; }
</style>
