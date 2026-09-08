{{-- Nexora theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $nxTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Nexora');
  $nxHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $nxTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'The future of shopping, unlocked — electronics, fashion, home, beauty and more, all in one holographic catalog.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($nxHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          nx: {
            bg: '#F4F6F8',
            surface: '#FFFFFF',
            ink: '#1B1730',
            mute: '#736F8A',
            pink: '#FF6EC7',
            cyan: '#6EE7FF',
            violet: '#A78BFA',
            chrome1: '#C7CBD1',
            chrome2: '#F4F6F8',
          }
        },
        fontFamily: {
          sans: ['Poppins', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          card: '0 2px 10px rgba(167,139,250,0.10)',
          cardHover: '0 20px 40px -12px rgba(255,110,199,0.35)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #A78BFA #F4F6F8; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: linear-gradient(180deg,#FF6EC7,#6EE7FF); border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Poppins', system-ui, sans-serif; background: #F4F6F8; }

  .nx-chrome {
    background: linear-gradient(180deg, #EDEFF2 0%, #C7CBD1 22%, #F4F6F8 45%, #C7CBD1 68%, #FFFFFF 100%);
  }
  .nx-holo-text {
    background: linear-gradient(90deg, #FF6EC7, #6EE7FF, #A78BFA, #FF6EC7);
    background-size: 300% auto;
    -webkit-background-clip: text; background-clip: text; color: transparent;
    animation: nx-holo-move 6s linear infinite;
  }
  .nx-holo-bg {
    background: linear-gradient(90deg, #FF6EC7, #A78BFA, #6EE7FF, #FF6EC7);
    background-size: 300% auto;
    animation: nx-holo-move 6s linear infinite;
  }
  @keyframes nx-holo-move { to { background-position: 300% center; } }

  .nx-shine { position: relative; overflow: hidden; }
  .nx-shine::after {
    content: ''; position: absolute; top: 0; left: -60%; width: 45%; height: 100%;
    background: linear-gradient(115deg, transparent 0%, rgba(255,255,255,0.65) 50%, transparent 100%);
    transform: skewX(-20deg);
    transition: left 0.55s ease;
  }
  .nx-shine:hover::after { left: 130%; }

  .nx-pill { border-radius: 9999px; }
  .nx-sticker {
    background: linear-gradient(180deg, #FFFFFF, #C7CBD1);
    border: 1px solid rgba(255,255,255,0.8);
    box-shadow: 0 2px 6px rgba(27,23,48,0.25), inset 0 1px 0 rgba(255,255,255,0.9);
  }
</style>
