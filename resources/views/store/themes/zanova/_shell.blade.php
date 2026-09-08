{{-- Zanova theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $znTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Zanova');
  $znHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $znTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Shop the future — electronics, fashion, home, beauty, grocery and more, curated in one neon-lit marketplace.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($znHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          zn: {
            bg: '#0B0B12',
            surface: '#12121C',
            surface2: '#181826',
            violet: '#8B5CF6',
            violetDark: '#6D28D9',
            cyan: '#22D3EE',
            pink: '#F472B6',
            ink: '#0B0B12',
            mist: '#A1A1AE',
          }
        },
        fontFamily: {
          heading: ['Space Grotesk', 'sans-serif'],
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          glow: '0 0 24px -4px rgba(139,92,246,.5), 0 0 8px rgba(34,211,238,.3)',
          glowLg: '0 0 48px -8px rgba(139,92,246,.55), 0 0 16px rgba(34,211,238,.35)',
          navUp: '0 -8px 24px -12px rgba(0,0,0,0.6)',
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #8B5CF6 #12121C; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-track { background: #12121C; }
  ::-webkit-scrollbar-thumb { background: linear-gradient(#8B5CF6, #22D3EE); border-radius: 9999px; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .16em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #0B0B12; }
  h1, h2, h3, h4, .font-heading { font-family: 'Space Grotesk', sans-serif; }

  .text-gradient {
    background-image: linear-gradient(90deg, #8B5CF6 0%, #22D3EE 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .glow-card {
    box-shadow: 0 0 0 1px rgba(139,92,246,0.12);
    transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
  }
  .glow-card:hover {
    box-shadow: 0 0 24px -4px rgba(139,92,246,.5), 0 0 8px rgba(34,211,238,.3);
    transform: translateY(-2px);
  }

  .btn-glass {
    position: relative;
    background: linear-gradient(135deg, rgba(139,92,246,0.95), rgba(34,211,238,0.85));
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.25), 0 0 24px -6px rgba(139,92,246,.6);
    transition: box-shadow .25s ease, transform .15s ease, filter .2s ease;
  }
  .btn-glass:hover { filter: brightness(1.08); box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 0 32px -4px rgba(34,211,238,.7); transform: translateY(-1px); }
  .btn-glass:active { transform: translateY(0); }

  .btn-outline-glow {
    background: rgba(139,92,246,0.06);
    border: 1px solid rgba(139,92,246,0.4);
    transition: all .2s ease;
  }
  .btn-outline-glow:hover {
    border-color: rgba(34,211,238,0.7);
    box-shadow: 0 0 16px -4px rgba(34,211,238,.5);
    background: rgba(34,211,238,0.08);
  }

  /* Marquee ticker */
  .zn-marquee-track {
    display: flex;
    width: max-content;
    animation: zn-scroll 28s linear infinite;
  }
  .zn-marquee-track:hover { animation-play-state: paused; }
  @keyframes zn-scroll {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
  }

  .zn-noise-grid {
    background-image:
      linear-gradient(rgba(139,92,246,0.07) 1px, transparent 1px),
      linear-gradient(90deg, rgba(139,92,246,0.07) 1px, transparent 1px);
    background-size: 40px 40px;
  }
</style>
