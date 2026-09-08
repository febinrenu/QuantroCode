{{-- Naturia theme shell — Tailwind CDN + config + fonts --}}
@php
  $ntTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Naturia');
  $ntHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $ntTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('naturia-living', $s->theme_tokens ?? []);
  $ntGreen = $ntTokens['color-accent-500'] ?? '#3A5A38';
  $ntTan = $ntTokens['color-accent-600'] ?? '#B08B5A';
  $ntGreenDeep = \App\Support\StorefrontThemeRegistry::shade($ntGreen, -0.3);
  $ntGreenLight = \App\Support\StorefrontThemeRegistry::shade($ntGreen, 0.9);
  $ntFontHeading = $ntTokens['font-heading'] ?? "'Fraunces', serif";
  $ntFontBody = $ntTokens['font-body'] ?? "'Inter', sans-serif";
  $ntInk = $ntTokens['color-accent-700'] ?? '#233021';
  $ntInkSoft = $ntTokens['color-accent-800'] ?? '#6E7568';
  $ntFontSizeHeading = $ntTokens['font-size-heading'] ?? '34px';
  $ntFontSizeBody = $ntTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $ntTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Discover natural & sustainable products for a healthier you and a greener planet.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,500;0,600;0,700;1,500&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          nt: {
            green: '{{ $ntGreen }}',
            greenDeep: '{{ $ntGreenDeep }}',
            greenLight: '{{ $ntGreenLight }}',
            tan: '{{ $ntTan }}',
            cream: '#F7F2E8',
            creamDark: '#EFE7D6',
            ink: '{{ $ntInk }}',
            inkSoft: '{{ $ntInkSoft }}',
            gold: '#C9A15B',
          }
        },
        fontFamily: {
          serif: [{!! json_encode($ntFontHeading) !!}, 'serif'],
          sans: [{!! json_encode($ntFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(35,48,33,0.08), 0 1px 1px rgba(35,48,33,0.05)',
          cardHover: '0 18px 32px -12px rgba(35,48,33,0.22)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $ntGreen }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $ntGreen }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .1em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $ntFontBody }}, system-ui, sans-serif; background: #F7F2E8; color: {{ $ntInk }}; font-size: {{ $ntFontSizeBody }}; }
  h1, .font-serif { font-size: {{ $ntFontSizeHeading }}; }
</style>
