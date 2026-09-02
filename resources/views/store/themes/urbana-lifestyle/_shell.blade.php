{{-- Urbana theme shell — Tailwind CDN + config + fonts --}}
@php
  $urbTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Urbana');
  $urbHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $urbTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('urbana-lifestyle', $s->theme_tokens ?? []);
  $urbGreen = $urbTokens['color-accent-500'] ?? '#1F3A2E';
  $urbGold = $urbTokens['color-accent-600'] ?? '#C9A876';
  $urbGreenDeep = \App\Support\StorefrontThemeRegistry::shade($urbGreen, -0.25);
  $urbGreenSoft = \App\Support\StorefrontThemeRegistry::shade($urbGreen, 0.35);
  $urbGoldSoft = \App\Support\StorefrontThemeRegistry::shade($urbGold, 0.5);
  $urbFontHeading = $urbTokens['font-heading'] ?? "'Playfair Display', serif";
  $urbFontBody = $urbTokens['font-body'] ?? "'Inter', sans-serif";
@endphp
<meta charset="utf-8" />
<title>{{ $urbTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Curated pieces for the modern lifestyle.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($urbHidePrices);</script>
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
          urb: {
            black: '#0E0E0E',
            green: '{{ $urbGreen }}',
            greenDeep: '{{ $urbGreenDeep }}',
            greenSoft: '{{ $urbGreenSoft }}',
            cream: '#F7F3EC',
            creamDark: '#EFE8DA',
            gold: '{{ $urbGold }}',
            goldSoft: '{{ $urbGoldSoft }}',
            ink: '#1A1A1A',
            inkSoft: '#6B6B63',
            orange: '#E08A3C',
            red: '#C24B3F',
          }
        },
        fontFamily: {
          serif: [{!! json_encode($urbFontHeading) !!}, 'serif'],
          sans: [{!! json_encode($urbFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(21,41,34,0.08), 0 1px 1px rgba(21,41,34,0.05)',
          cardHover: '0 18px 32px -12px rgba(21,41,34,0.25)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $urbGold }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $urbGold }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .14em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $urbFontBody }}, system-ui, sans-serif; background: #F7F3EC; color: #1A1A1A; }
  .urb-italic { font-style: italic; font-weight: 500; }
</style>
