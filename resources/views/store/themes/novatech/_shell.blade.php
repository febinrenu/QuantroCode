{{-- NovaTech theme shell — Tailwind CDN + config + fonts, included once per page --}}
@php
  $ntTitle = $pageTitle ?? ($s->seo_meta_title ?? $s->store_name ?? 'NovaTech');
  $ntHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
@endphp
<meta charset="utf-8" />
<title>{{ $ntTitle }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $s->seo_meta_description ?? 'Tomorrow\'s essentials, today — electronics, fashion, home, beauty, grocery and sports in one premium store.' }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
<script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
<script>window.__HIDE_PRICES__ = @json($ntHidePrices);</script>
<script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
<script>
  window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
  window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
  window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
  window.__MSG_ADDED__        = @json(__('messages.Added'));
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap">

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          nova: {
            bg: '#141327',
            bgDeep: '#0B0A1A',
            surface: '#1B1934',
            violet: '#7C4DFF',
            violetDark: '#6432E0',
            violetLight: '#B69CFF',
            cyan: '#5EEAD4',
            amber: '#FCC419',
            ink: '#0B0A1A',
          }
        },
        fontFamily: {
          sans: ['Inter', 'system-ui', 'sans-serif'],
        },
        boxShadow: {
          glow: '0 0 0 1px rgba(124,77,255,0.25), 0 8px 30px -8px rgba(124,77,255,0.35)',
          glowLg: '0 20px 60px -15px rgba(124,77,255,0.45)',
          glass: '0 1px 1px rgba(255,255,255,0.06) inset, 0 12px 40px -12px rgba(0,0,0,0.55)',
        },
        backgroundImage: {
          'nova-radial': 'radial-gradient(circle at 20% 20%, rgba(124,77,255,0.25), transparent 55%), radial-gradient(circle at 85% 0%, rgba(94,234,212,0.12), transparent 45%)',
        }
      }
    }
  }
</script>

<style>
  * { scrollbar-width: thin; scrollbar-color: #7C4DFF33 transparent; }
  ::-webkit-scrollbar { height: 8px; width: 8px; }
  ::-webkit-scrollbar-thumb { background: rgba(124,77,255,0.35); border-radius: 9999px; }
  ::-webkit-scrollbar-track { background: transparent; }
  .no-scrollbar::-webkit-scrollbar { display: none; }
  .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
  .eyebrow { letter-spacing: .16em; text-transform: uppercase; }
  details > summary { list-style: none; cursor: pointer; }
  details > summary::-webkit-details-marker { display: none; }
  body { font-family: 'Inter', system-ui, sans-serif; background: #141327; }
  .nt-glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.10); }
  .nt-glass-strong { background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.14); }
  .nt-ticker { animation: nt-scroll 24s linear infinite; }
  @keyframes nt-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
  .nt-gradient-text { background: linear-gradient(90deg, #B69CFF, #7C4DFF 55%, #5EEAD4); -webkit-background-clip: text; background-clip: text; color: transparent; }
</style>
