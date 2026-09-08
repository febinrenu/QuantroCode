{{-- Technova theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $tnTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'Technova');
  $tnHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $tnTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Shop the terminal — electronics, fashion, home, beauty and more, compiled into one catalog.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($tnHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          tn: {
            bg: '#050505',
            panel: '#0D0D0D',
            panel2: '#111111',
            border: '#1F2A22',
            border2: '#2A2318',
            green: '#39FF88',
            greenDim: '#1F8F52',
            amber: '#FFB000',
            amberDim: '#8F6300',
            ink: '#D7F5E3',
            mute: '#5F7A69',
          }
        },
        fontFamily: {
          mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
        },
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #39FF88 #050505; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: #39FF88; border-radius: 0; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'JetBrains Mono', ui-monospace, monospace; background: #050505; }
  .tn-scanlines {
    position: fixed; inset: 0; pointer-events: none; z-index: 60;
    background: repeating-linear-gradient(180deg, rgba(57,255,136,0.035) 0px, rgba(57,255,136,0.035) 1px, transparent 1px, transparent 3px);
    mix-blend-mode: overlay;
  }
  .tn-window { position: relative; border: 1px solid #1F2A22; background: #0D0D0D; }
  .tn-window::before {
    content: ''; position: absolute; top: 10px; left: 12px; width: 8px; height: 8px; border-radius: 9999px;
    background: #39FF88; box-shadow: 14px 0 0 #FFB000, 28px 0 0 #1F2A22;
  }
  .tn-window-pad { padding-top: 2rem; }
  .tn-cursor::after { content: '_'; animation: tn-blink 1s step-end infinite; color: #39FF88; }
  @keyframes tn-blink { 50% { opacity: 0; } }
  .tn-glow-btn { transition: box-shadow .2s ease, transform .2s ease; }
  .tn-glow-btn:hover { box-shadow: 0 0 0 1px #39FF88, 0 0 18px -2px rgba(57,255,136,0.6); transform: translateY(-1px); }
  .tn-bracket::before { content: '['; color: #39FF88; margin-right: 2px; }
  .tn-bracket::after { content: ']'; color: #39FF88; margin-left: 2px; }
</style>
