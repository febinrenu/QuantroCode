{{-- GeneralHub Theme Shell & Layout Engine --}}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $pageTitle ?? ($s->store_name ?? 'GeneralHub — Everything You Need, All in One Place') }}</title>

@if(!empty($s->favicon))
  <link rel="icon" type="image/x-icon" href="{{ global_asset(upload_path('favicon').'/'.$s->favicon) }}">
@endif

<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Tailwind Play CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
        },
        colors: {
          hub: {
            blue: '#1E60D0',
            blueHover: '#1650B0',
            blueLight: '#EBF3FE',
            blueSoft: '#F0F6FF',
            navy: '#0B286D',
            navyDark: '#081D52',
            dark: '#0F172A',
            text: '#1E293B',
            muted: '#64748B',
            border: '#E2E8F0',
            borderLight: '#EDF2F7',
            bg: '#F8FAFC',
            sale: '#EF4444',
            best: '#F97316',
            new: '#10B981',
          }
        },
        boxShadow: {
          'card': '0 2px 8px -2px rgba(0, 0, 0, 0.05), 0 1px 4px -1px rgba(0, 0, 0, 0.03)',
          'card-hover': '0 12px 24px -6px rgba(30, 96, 208, 0.12), 0 4px 12px -2px rgba(0, 0, 0, 0.04)',
          'blue-glow': '0 4px 20px -2px rgba(30, 96, 208, 0.35)',
        }
      }
    }
  }
</script>

<meta name="currency" content="{{ $s->currency_code ?? '$' }}">
<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>

<style>
  :root {
    --hub-blue: #1E60D0;
    --hub-navy: #0B286D;
  }

  body {
    font-family: 'Plus Jakarta Sans', Inter, sans-serif;
    color: #1E293B;
    background-color: #FFFFFF;
  }

  .hub-card {
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }
  
  .hub-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px -6px rgba(30, 96, 208, 0.1), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
  }

  /* Custom scrollbars */
  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
  ::-webkit-scrollbar-track {
    background: #F1F5F9;
  }
  ::-webkit-scrollbar-thumb {
    background: #CBD5E1;
    border-radius: 9999px;
  }
  ::-webkit-scrollbar-thumb:hover {
    background: #94A3B8;
  }
</style>
<div id="store-stock-toast" class="hidden fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-medium"></div>
