{{-- CasaNest theme shell — Tailwind CDN + config + fonts --}}
@php
  $cnTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'CasaNest');
  $cnHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $cnTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('casanest-furniture', $s->theme_tokens ?? []);
  $cnOlive = $cnTokens['color-accent-500'] ?? '#3E4A32';
  $cnTan = $cnTokens['color-accent-600'] ?? '#B08B5A';
  $cnOliveDeep = \App\Support\StorefrontThemeRegistry::shade($cnOlive, -0.3);
  $cnTanSoft = \App\Support\StorefrontThemeRegistry::shade($cnTan, 0.55);
  $cnFontHeading = $cnTokens['font-heading'] ?? "'Fraunces', serif";
  $cnFontBody = $cnTokens['font-body'] ?? "'Inter', sans-serif";
  $cnInk = $cnTokens['color-accent-700'] ?? '#2B2A25';
  $cnInkSoft = $cnTokens['color-accent-800'] ?? '#7C7566';
  $cnFontSizeHeading = $cnTokens['font-size-heading'] ?? '34px';
  $cnFontSizeBody = $cnTokens['font-size-body'] ?? '15px';
@endphp
<meta charset="utf-8" />
<title>{{ $cnTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Thoughtful furniture. Beautiful spaces. Made for the way you live.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,500;0,600;0,700;1,500&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          cn: {
            olive: '{{ $cnOlive }}',
            oliveDeep: '{{ $cnOliveDeep }}',
            tan: '{{ $cnTan }}',
            tanSoft: '{{ $cnTanSoft }}',
            cream: '#F6F1E7',
            creamDark: '#EDE6D6',
            ink: '{{ $cnInk }}',
            inkSoft: '{{ $cnInkSoft }}',
            sale: '#B3402A',
          }
        },
        fontFamily: {
          serif: [{!! json_encode($cnFontHeading) !!}, 'serif'],
          sans: [{!! json_encode($cnFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(43,42,37,0.08), 0 1px 1px rgba(43,42,37,0.05)',
          cardHover: '0 18px 32px -12px rgba(43,42,37,0.25)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $cnOlive }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $cnOlive }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .1em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $cnFontBody }}, system-ui, sans-serif; background: #F6F1E7; color: {{ $cnInk }}; font-size: {{ $cnFontSizeBody }}; }
  h1, .font-serif { font-size: {{ $cnFontSizeHeading }}; }
</style>
