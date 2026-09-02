{{-- FutureX theme shell — Tailwind CDN + config + fonts --}}
@php
  $fxTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'FutureX');
  $fxHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $fxTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('futurex-tech', $s->theme_tokens ?? []);
  $fxPurple = $fxTokens['color-accent-500'] ?? '#7B3FE4';
  $fxBlue = $fxTokens['color-accent-600'] ?? '#3F8CFF';
  $fxPurpleDeep = \App\Support\StorefrontThemeRegistry::shade($fxPurple, -0.35);
  $fxFontHeading = $fxTokens['font-heading'] ?? "'Poppins', sans-serif";
  $fxFontBody = $fxTokens['font-body'] ?? "'Inter', sans-serif";
@endphp
<meta charset="utf-8" />
<title>{{ $fxTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'For work, play and everything in between.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($fxHidePrices);</script>
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
          fx: {
            black: '#0B0B14',
            navy: '#161329',
            purple: '{{ $fxPurple }}',
            purpleDeep: '{{ $fxPurpleDeep }}',
            blue: '{{ $fxBlue }}',
            cyan: '#3FE0FF',
            ink: '#12101F',
            inkSoft: '#6B6478',
            cream: '#F4F5FA',
            creamDark: '#EAEBF5',
          }
        },
        fontFamily: {
          heading: [{!! json_encode($fxFontHeading) !!}, 'sans-serif'],
          sans: [{!! json_encode($fxFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(18,16,31,0.08), 0 1px 1px rgba(18,16,31,0.05)',
          cardHover: '0 18px 32px -12px rgba(18,16,31,0.3)',
        },
        backgroundImage: {
          'fx-hero': 'linear-gradient(120deg, #0B0B14 0%, #211B4A 55%, {{ $fxPurpleDeep }} 100%)',
          'fx-badge': 'linear-gradient(135deg, {{ $fxBlue }} 0%, {{ $fxPurple }} 100%)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $fxPurple }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $fxPurple }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .1em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $fxFontBody }}, system-ui, sans-serif; background: #F4F5FA; color: #12101F; }
</style>
