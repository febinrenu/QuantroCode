{{-- MediSphere theme shell — Tailwind CDN + config + fonts --}}
@php
  $msTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'MediSphere');
  $msHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $msTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('medisphere-care', $s->theme_tokens ?? []);
  $msTeal = $msTokens['color-accent-500'] ?? '#0E9B8A';
  $msRed = $msTokens['color-accent-600'] ?? '#E23744';
  $msTealDeep = \App\Support\StorefrontThemeRegistry::shade($msTeal, -0.35);
  $msTealLight = \App\Support\StorefrontThemeRegistry::shade($msTeal, 0.92);
  $msFontHeading = $msTokens['font-heading'] ?? "'Manrope', sans-serif";
  $msFontBody = $msTokens['font-body'] ?? "'Inter', sans-serif";
  $msInk = $msTokens['color-accent-700'] ?? '#16302C';
  $msInkSoft = $msTokens['color-accent-800'] ?? '#6B7C79';
  $msFontSizeHeading = $msTokens['font-size-heading'] ?? '34px';
  $msFontSizeBody = $msTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $msTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Genuine medicines, expert guidance and fast delivery to your doorstep.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($msHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          ms: {
            teal: '{{ $msTeal }}',
            tealDeep: '{{ $msTealDeep }}',
            tealLight: '{{ $msTealLight }}',
            red: '{{ $msRed }}',
            cream: '#F7FAF9',
            creamDark: '#EEF4F3',
            ink: '{{ $msInk }}',
            inkSoft: '{{ $msInkSoft }}',
            gold: '#F5A623',
          }
        },
        fontFamily: {
          heading: [{!! json_encode($msFontHeading) !!}, 'sans-serif'],
          sans: [{!! json_encode($msFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(22,48,44,0.08), 0 1px 1px rgba(22,48,44,0.05)',
          cardHover: '0 18px 32px -12px rgba(22,48,44,0.2)',
        },
        borderRadius: {
          xl2: '1rem',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $msTeal }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $msTeal }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .04em; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $msFontBody }}, system-ui, sans-serif; background: #F7FAF9; color: {{ $msInk }}; font-size: {{ $msFontSizeBody }}; }
  h1, h2, h3, .font-heading { font-family: {{ $msFontHeading }}, sans-serif; }
  h1, .font-heading { font-size: {{ $msFontSizeHeading }}; }
</style>
