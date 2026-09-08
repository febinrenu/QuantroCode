{{-- FreshCart theme shell — Tailwind CDN + config + fonts --}}
@php
  $fcTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'FreshCart');
  $fcHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $fcTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('freshcart-daily', $s->theme_tokens ?? []);
  $fcGreen = $fcTokens['color-accent-500'] ?? '#2E8B4E';
  $fcOrange = $fcTokens['color-accent-600'] ?? '#F2811D';
  $fcGreenDeep = \App\Support\StorefrontThemeRegistry::shade($fcGreen, -0.4);
  $fcGreenLight = \App\Support\StorefrontThemeRegistry::shade($fcGreen, 0.9);
  $fcOrangeSoft = \App\Support\StorefrontThemeRegistry::shade($fcOrange, 0.85);
  $fcFontHeading = $fcTokens['font-heading'] ?? "'Nunito', sans-serif";
  $fcFontBody = $fcTokens['font-body'] ?? "'Inter', sans-serif";
  $fcInk = $fcTokens['color-accent-700'] ?? '#1E2A22';
  $fcInkSoft = $fcTokens['color-accent-800'] ?? '#6B7A70';
  $fcFontSizeHeading = $fcTokens['font-size-heading'] ?? '34px';
  $fcFontSizeBody = $fcTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $fcTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Farm fresh quality, daily essentials and everything in between.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          fc: {
            green: '{{ $fcGreen }}',
            greenDeep: '{{ $fcGreenDeep }}',
            greenLight: '{{ $fcGreenLight }}',
            orange: '{{ $fcOrange }}',
            orangeSoft: '{{ $fcOrangeSoft }}',
            cream: '#FAFAF7',
            creamDark: '#F1EFE6',
            ink: '{{ $fcInk }}',
            inkSoft: '{{ $fcInkSoft }}',
            gold: '#F5A623',
            red: '#E4572E',
          }
        },
        fontFamily: {
          heading: [{!! json_encode($fcFontHeading) !!}, 'sans-serif'],
          sans: [{!! json_encode($fcFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(30,42,34,0.08), 0 1px 1px rgba(30,42,34,0.05)',
          cardHover: '0 18px 32px -12px rgba(30,42,34,0.22)',
        },
        borderRadius: {
          xl2: '1rem',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $fcGreen }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $fcGreen }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .04em; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $fcFontBody }}, system-ui, sans-serif; background: #FAFAF7; color: {{ $fcInk }}; font-size: {{ $fcFontSizeBody }}; }
  h1, h2, h3, .font-heading { font-family: {{ $fcFontHeading }}, sans-serif; }
  h1, .font-heading { font-size: {{ $fcFontSizeHeading }}; }
</style>
