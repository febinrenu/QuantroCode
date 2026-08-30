{{-- FutureX theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $fxTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'FutureX');
  $fxHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $fxTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'The store from tomorrow — electronics, fashion, home, beauty and more, all in one drop.' }}" />
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
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800;900&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          fx: {
            bg: '#0A0E1A',
            panel: '#11162A',
            panel2: '#161C36',
            border: '#252C4A',
            violet: '#8B5CF6',
            cyan: '#22D3EE',
            pink: '#F472B6',
            ink: '#E7E9F5',
            mute: '#8B90B3',
          }
        },
        fontFamily: {
          heading: ['Space Grotesk', 'sans-serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          glow: '0 0 0 1px rgba(139,92,246,0.4), 0 0 30px -5px rgba(139,92,246,0.55)',
          glowCyan: '0 0 0 1px rgba(34,211,238,0.4), 0 0 30px -5px rgba(34,211,238,0.55)',
          panel: '0 1px 1px rgba(0,0,0,0.4), 0 20px 40px -20px rgba(0,0,0,0.6)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #8B5CF6 #0A0E1A; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #8B5CF6; border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .18em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #0A0E1A; }
  .fx-grad-text {
    background: linear-gradient(90deg, #8B5CF6 0%, #22D3EE 100%);
    -webkit-background-clip: text; background-clip: text; color: transparent;
  }
  .fx-grad-btn { background: linear-gradient(90deg, #8B5CF6 0%, #22D3EE 100%); }
  .fx-glow-btn { transition: box-shadow .25s ease, transform .25s ease; }
  .fx-glow-btn:hover { box-shadow: 0 0 0 1px rgba(139,92,246,.5), 0 0 40px -6px rgba(34,211,238,.75); transform: translateY(-1px); }
  .fx-marquee-track { display: flex; width: max-content; animation: fx-scroll 26s linear infinite; }
  .fx-marquee-track:hover { animation-play-state: paused; }
  @keyframes fx-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .fx-grid-bg {
    background-image: linear-gradient(rgba(139,92,246,0.10) 1px, transparent 1px), linear-gradient(90deg, rgba(139,92,246,0.10) 1px, transparent 1px);
    background-size: 36px 36px;
  }
</style>
