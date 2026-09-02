{{-- LittleJoy theme shell — Tailwind CDN + config + fonts --}}
@php
  $ljTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'LittleJoy');
  $ljHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $ljTokens = \App\Support\StorefrontThemeRegistry::resolveTokens('littlejoy-kids', $s->theme_tokens ?? []);
  $ljPurple = $ljTokens['color-accent-500'] ?? '#6C63E0';
  $ljPink = $ljTokens['color-accent-600'] ?? '#F76C8A';
  $ljPurpleDeep = \App\Support\StorefrontThemeRegistry::shade($ljPurple, -0.3);
  $ljFontHeading = $ljTokens['font-heading'] ?? "'Baloo 2', sans-serif";
  $ljFontBody = $ljTokens['font-body'] ?? "'Inter', sans-serif";
@endphp
<meta charset="utf-8" />
<title>{{ $ljTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Safe, quality products for every stage of your child\'s journey.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($ljHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          lj: {
            purple: '{{ $ljPurple }}',
            purpleDeep: '{{ $ljPurpleDeep }}',
            pink: '{{ $ljPink }}',
            gold: '#FFD166',
            mint: '#8FD9C4',
            lavender: '#EDEBFB',
            cream: '#FFF6F2',
            creamDark: '#FDEAE1',
            ink: '#2B2640',
            inkSoft: '#726C8C',
          }
        },
        fontFamily: {
          heading: [{!! json_encode($ljFontHeading) !!}, 'sans-serif'],
          sans: [{!! json_encode($ljFontBody) !!}, 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 1px 2px rgba(43,38,64,0.08), 0 1px 1px rgba(43,38,64,0.05)',
          cardHover: '0 18px 32px -12px rgba(43,38,64,0.25)',
        },
        borderRadius: {
          xl2: '1.25rem',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: {{ $ljPurple }} transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: {{ $ljPurple }}; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .08em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: {{ $ljFontBody }}, system-ui, sans-serif; background: #FFF6F2; color: #2B2640; }
  .lj-rainbow span:nth-child(6n+1) { color: #F76C8A; }
  .lj-rainbow span:nth-child(6n+2) { color: #FF9F5A; }
  .lj-rainbow span:nth-child(6n+3) { color: #FFD166; }
  .lj-rainbow span:nth-child(6n+4) { color: #8FD9C4; }
  .lj-rainbow span:nth-child(6n+5) { color: #5AB0E0; }
  .lj-rainbow span:nth-child(6n+0) { color: #6C63E0; }
</style>
