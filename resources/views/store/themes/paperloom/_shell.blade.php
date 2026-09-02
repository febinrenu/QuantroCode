<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="currency" content="{{ $s->currency_code ?? '$' }}">
  <title>@yield('title', 'PaperLoom — Books, Study & Stationery')</title>

  <!-- Global Storefront State Initialization -->
  <script>window.__LOGGED_IN__ = @json(Auth::guard('store')->check());</script>
  <script>window.__ALLOW_OVERSELLING__ = @json($s->allow_overselling ?? true);</script>
  <script>window.__HIDE_PRICES__ = @json(!Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false));</script>
  <script>window.__SHOW_STOCK__ = @json($s->show_stock ?? true);</script>
  <script>
    window.__MSG_ONLY_X_STOCK__ = @json(__('messages.Only_x_available_in_stock'));
    window.__MSG_MAX_ADDED__    = @json(__('messages.Max_stock_added_to_cart'));
    window.__MSG_ALREADY_MAX__  = @json(__('messages.Already_max_in_cart'));
    window.__MSG_ADDED__        = @json(__('messages.Added'));
  </script>

  <!-- Google Fonts: Newsreader (Editorial Serif) & Plus Jakarta Sans (Clean UI) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,400;1,6..72,600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            pl: {
              cream: '#F8F5EE',
              creamLight: '#FAF8F5',
              creamDark: '#F1ECE1',
              sand: '#EAE4D8',
              border: '#E5DFD5',
              borderSubtle: '#EDE8E0',
              terracotta: '#C45D3E',
              terracottaHover: '#AF4E31',
              terracottaDark: '#8F381F',
              forest: '#1E3A34',
              forestDark: '#16282E',
              forestLight: '#2D524A',
              ink: '#1A202C',
              muted: '#718096',
              gold: '#D97706',
              sale: '#D9534F',
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'system-ui', '-apple-system', 'sans-serif'],
            serif: ['"Newsreader"', '"Playfair Display"', 'Georgia', 'serif'],
          }
        }
      }
    }
  </script>

  <!-- Storefront Core JS (bundles Alpine.js, CartLS, and UI components) -->
  <script src="{{ global_asset('js/storefront.min.js') }}" defer></script>

  <style>
    [x-cloak] { display: none !important; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #F8F5EE;
      color: #1A202C;
      -webkit-font-smoothing: antialiased;
    }
    .font-serif-book {
      font-family: 'Newsreader', 'Playfair Display', Georgia, serif;
    }
    .pl-transition {
      transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .pl-card {
      transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .pl-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -5px rgba(30, 58, 52, 0.08);
    }
    /* Hide scrollbar */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>

  @stack('styles')
</head>
<body class="min-h-full flex flex-col antialiased selection:bg-[#C45D3E] selection:text-white" x-data="{ mobileMenuOpen: false, searchOpen: false }">

  {{-- Global Header --}}
  @include('store.themes.paperloom.partials.header')

  {{-- Mobile Navigation Drawer --}}
  @include('store.themes.paperloom.partials.mobile-nav')

  {{-- Main Page Content --}}
  <main class="flex-1">
    @yield('content')
  </main>

  {{-- Global Footer --}}
  @include('store.themes.paperloom.partials.footer')

  {{-- Toast notification container for stock/cart alerts --}}
  <div id="store-stock-toast" class="fixed bottom-5 right-5 z-50 pointer-events-none"></div>

  @stack('scripts')
</body>
</html>
