{{-- AurumÉclat theme shell — Fine Jewelry Luxury Maison --}}
@php
  $themeTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'AurumÉclat — Fine Jewelry');
  $themeHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $activeThemeSlug = 'aurumeclat';
  $themeTokens = \App\Support\StorefrontThemeRegistry::resolveTokens($activeThemeSlug, $s->theme_tokens ?? []);
  $accent500 = $themeTokens['color-accent-500'] ?? '#D4AF37';
  $accent600 = $themeTokens['color-accent-600'] ?? '#B8860B';
  $accent700 = $themeTokens['color-accent-700'] ?? '#0E0D0B';
  $accent800 = $themeTokens['color-accent-800'] ?? '#8C6D23';
  $fontHeading = $themeTokens['font-heading'] ?? "'Cormorant Garamond', serif";
  $fontBody = $themeTokens['font-body'] ?? "'Montserrat', sans-serif";
  $fontSizeHeading = $themeTokens['font-size-heading'] ?? '38px';
  $fontSizeBody = $themeTokens['font-size-body'] ?? '14px';
@endphp
<meta charset="utf-8" />
<title>{{ $themeTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'AurumÉclat Fine Jewelry — Crafted to Be Treasured. High-jewelry rings, necklaces, earrings, bracelets, bridal sets, and certified diamonds.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($themeHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          aurum: {
            black: '#090807',
            obsidian: '#0E0D0B',
            darkCard: '#151310',
            darkHover: '#1D1A15',
            border: '#2C2720',
            borderLight: '#3D362C',
            gold: '{{ $accent500 }}',
            goldLight: '#E8D5B5',
            goldDark: '{{ $accent600 }}',
            goldDeep: '{{ $accent800 }}',
            goldMuted: '#9E8552',
            sand: '#F7F3EC',
            sandLight: '#FAF8F5',
            sandDark: '#EFE8DC',
            sandBorder: '#E2D7C5',
            textDark: '#1A1815',
            textMuted: '#8A8275',
            wine: '#3D1520',
            wineDark: '#260B12',
          }
        },
        fontFamily: {
          serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
          sans: ['"Montserrat"', 'system-ui', 'sans-serif'],
        },
      }
    }
  }
</script>

<style>
  :root {
    --color-accent-500: {{ $accent500 }};
    --color-accent-600: {{ $accent600 }};
    --color-accent-700: {{ $accent700 }};
    --color-accent-800: {{ $accent800 }};
    --font-heading: {!! $fontHeading !!};
    --font-body: {!! $fontBody !!};
    --font-size-heading: {{ $fontSizeHeading }};
    --font-size-body: {{ $fontSizeBody }};
  }
  body {
    font-family: {!! $fontBody !!} !important;
    font-size: {{ $fontSizeBody }} !important;
    background-color: #0E0D0B;
    color: #E8D5B5;
  }
  h1, h2, h3, .font-serif, .font-heading, .brand-title {
    font-family: {!! $fontHeading !!};
  }

  /* Custom Luxury Scrollbar */
  * { scrollbar-width: thin; scrollbar-color: #3D362C transparent; }
  ::-webkit-scrollbar { height: 6px; width: 6px; }
  ::-webkit-scrollbar-thumb { background: #3D362C; border-radius: 9999px; }
  ::-webkit-scrollbar-track { background: transparent; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

  .tracking-widest-luxury { letter-spacing: 0.22em; }
  .tracking-wide-luxury { letter-spacing: 0.15em; }

  /* Gold Shimmer & Glow */
  .gold-gradient-text {
    background: linear-gradient(135deg, #FFF1D0 0%, #D4AF37 50%, #AA7C11 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .gold-border-glow {
    box-shadow: 0 0 20px -5px rgba(212, 175, 55, 0.2);
  }
  .luxury-card-hover {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .luxury-card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px -10px rgba(0, 0, 0, 0.7), 0 0 15px rgba(212, 175, 55, 0.15);
    border-color: rgba(212, 175, 55, 0.4);
  }
</style>
