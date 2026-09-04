{{-- Marketly theme shell — Tailwind CDN + config + fonts --}}
@php
  $mktTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Marketly');
  $mktHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $mktTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('marketly-shop', $s->theme_tokens ?? []);
  $mktPurple = $mktTokens['color-accent-500'] ?? '#5B3FD9';
  $mktGold = $mktTokens['color-accent-600'] ?? '#F5B301';
  $mktPurpleDeep = \App\Support\StorefrontThemeRegistry::shade($mktPurple, -0.35);
  $mktFontHeading = $mktTokens['font-heading'] ?? "'Poppins', sans-serif";
  $mktFontBody = $mktTokens['font-body'] ?? "'Inter', sans-serif";
@endphp
<meta charset="utf-8" />
<title>{{ $mktTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Top brands at unbeatable prices.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($mktHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          mkt: {
            purple: '{{ $mktPurple }}',
            purpleDeep: '{{ $mktPurpleDeep }}',
            pink: '#D63FD1',
            coral: '#FF3E6C',
            gold: '{{ $mktGold }}',
            ink: '#1B1533',
            inkSoft: '#6B6478',
            cream: '#F7F6FB',
            creamDark: '#EFEDF7',
          }
        },
        fontFamily: {
          heading: [{!! json_encode($mktFontHeading) !!}, 'sans-serif'],
          sans: [{!! json_encode($mktFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(27,21,51,0.08), 0 1px 1px rgba(27,21,51,0.05)',
          cardHover: '0 18px 32px -12px rgba(27,21,51,0.25)',
        },
        backgroundImage: {
          'mkt-hero': 'linear-gradient(120deg, {{ $mktPurpleDeep }} 0%, {{ $mktPurple }} 45%, #D63FD1 100%)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $mktPurple }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $mktPurple }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .1em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $mktFontBody }}, system-ui, sans-serif; background: #F7F6FB; color: #1B1533; }
</style>
