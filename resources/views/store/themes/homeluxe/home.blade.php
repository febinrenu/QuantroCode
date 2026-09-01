<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.homeluxe._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'HomeLuxe') . ' — Bring Nature Into Your Home'])
</head>
<body class="bg-hl-cream text-hl-ink antialiased">

@include('store.themes.homeluxe.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $featured = collect($blocks)->where('type','collection')->flatMap(fn($b) => $b['products'] ?? [])->unique('id')->take(6)
      ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  $categoryTiles = [
    ['Living Room', 'Comfort meets elegance.', global_asset('images/themes/homeluxe/cat-living-room-photo.png')],
    ['Bedroom', 'Rest well, wake better.', global_asset('images/themes/homeluxe/cat-bedroom-photo.png')],
    ['Dining Room', 'Gather in style, dine in comfort.', global_asset('images/themes/homeluxe/cat-dining-room-photo.png')],
    ['Outdoor', 'Enjoy the outdoors like never before.', global_asset('images/themes/homeluxe/cat-outdoor-photo.png')],
    ['Decor & Lighting', 'The little details make a big impact.', 'https://images.unsplash.com/photo-1513161455079-7dc1de15ef3e?auto=format&fit=crop&w=500&q=80'],
  ];

  $rooms = [
    ['Living Room', global_asset('images/themes/homeluxe/cat-living-room-photo.png')],
    ['Bedroom', global_asset('images/themes/homeluxe/cat-bedroom-photo.png')],
    ['Dining Room', global_asset('images/themes/homeluxe/cat-dining-room-photo.png')],
    ['Home Office', 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=420&q=80'],
    ['Outdoor', global_asset('images/themes/homeluxe/cat-outdoor-photo.png')],
    ['Entryway', 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?auto=format&fit=crop&w=420&q=80'],
  ];
@endphp

<main>
  {{-- ===== HERO ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 pt-5">
    <div class="hl-hero relative rounded-3xl min-h-[420px] md:min-h-[500px] overflow-hidden flex items-center">
      <div class="absolute inset-0 bg-gradient-to-r from-hl-cream via-hl-cream/70 to-transparent"></div>
      <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow-card grid place-items-center hover:bg-hl-cream" aria-label="Previous">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
      </button>
      <div class="relative ml-8 md:ml-16 max-w-[460px]">
        <h1 class="font-display text-[42px] md:text-[58px] leading-[1.02] text-hl-ink">Bring Nature<br>Into <i class="text-hl-forest">Your Home</i></h1>
        <p class="mt-5 leading-6 text-[15px] text-hl-mute">Sustainable materials. Timeless designs.<br>Better for your home and the planet.</p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="bg-hl-forest text-white px-6 py-3.5 rounded-lg text-[12px] font-bold tracking-wide hover:bg-hl-deep transition-colors">SHOP NOW</a>
          <a href="{{ route('store.shop') }}" class="bg-white border border-hl-ink/20 px-6 py-3.5 rounded-lg text-[12px] font-bold tracking-wide hover:bg-hl-cream transition-colors">DISCOVER INSPIRATION</a>
        </div>
      </div>
      <div class="absolute top-8 right-8 rounded-full w-28 h-28 bg-white border-2 border-hl-forest grid place-items-center text-center leading-tight">
        <span class="text-[10px] font-bold text-hl-ink">UP TO</span>
        <b class="text-2xl text-hl-forest -my-0.5">45%</b>
        <span class="text-[10px] font-bold text-hl-ink">OFF</span>
      </div>
      <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow-card grid place-items-center hover:bg-hl-cream" aria-label="Next">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
      </button>
      <div class="absolute bottom-5 left-8 flex gap-1.5">
        @for($i=0;$i<5;$i++)<span class="w-1.5 h-1.5 rounded-full {{ $i===0 ? 'bg-hl-forest' : 'bg-hl-ink/25' }}"></span>@endfor
      </div>
    </div>
  </section>

  {{-- ===== TRUST BAR ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 mt-6">
    <div class="bg-white rounded-2xl border border-hl-line grid grid-cols-2 lg:grid-cols-5 divide-x divide-hl-line">
      @foreach([
        ['icon' => 'truck', 'title' => 'Free Delivery', 'sub' => 'On orders over $99'],
        ['icon' => 'shield', 'title' => 'Secure Checkout', 'sub' => '100% secure payments'],
        ['icon' => 'refresh', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'leaf', 'title' => 'Sustainable Choice', 'sub' => 'Eco-friendly products'],
        ['icon' => 'headset', 'title' => 'Customer Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="p-5 flex items-center gap-3">
          <span class="text-hl-forest shrink-0">
            @switch($item['icon'])
              @case('truck')
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
                @break
              @case('shield')
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                @break
              @case('refresh')
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
                @break
              @case('leaf')
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
                @break
              @default
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 11a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1v-6h3M3 11h3v6H5a2 2 0 0 1-2-2z"/></svg>
            @endswitch
          </span>
          <span class="text-[11px] leading-tight">
            <b class="block text-hl-ink font-bold">{{ $item['title'] }}</b>
            <small class="text-hl-mute">{{ $item['sub'] }}</small>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY GRID ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
    @foreach($categoryTiles as $tile)
      <a href="{{ route('store.shop') }}" class="group">
        <div class="rounded-2xl overflow-hidden h-40 bg-hl-goldLight">
          <img src="{{ $tile[2] }}" alt="{{ $tile[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        </div>
        <div class="mt-3">
          <div class="font-display text-lg text-hl-ink">{{ $tile[0] }}</div>
          <p class="text-[11px] text-hl-mute italic mt-0.5">{{ $tile[1] }}</p>
          <span class="inline-flex items-center gap-1 text-[11px] font-bold text-hl-forest mt-1">SHOP NOW <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></span>
        </div>
      </a>
    @endforeach
  </section>

  {{-- ===== FEATURED PRODUCTS ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-2xl text-hl-ink">Featured Products</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-hl-forest flex items-center gap-1">View All Products <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    @if($featured->isNotEmpty())
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($featured as $product)
          @include('store.themes.homeluxe.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    @else
      <div class="rounded-2xl bg-white border border-hl-line p-10 text-center text-sm text-hl-mute">Add products to your Home &amp; Furniture category to display your collection here.</div>
    @endif
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 mt-10">
    <div class="hl-news relative rounded-3xl overflow-hidden px-8 py-9 md:py-11 text-white grid md:grid-cols-[1fr_1.3fr] gap-6 items-center">
      <svg class="absolute -bottom-8 -left-8 w-44 h-44 text-white/10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8"><path d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
      <div class="relative">
        <h2 class="font-display text-2xl md:text-3xl leading-tight">Join Our Green<br>Living Journey</h2>
        <p class="text-xs mt-2 text-white/75">Subscribe for exclusive offers, new arrivals,<br>and eco-friendly living tips.</p>
      </div>
      <div class="relative">
        <form class="flex max-w-md" onsubmit="return false;">
          <input type="email" placeholder="Enter your email address" class="h-12 flex-1 min-w-0 px-4 text-xs text-hl-ink rounded-l-lg outline-none">
          <button class="bg-hl-gold text-hl-deep px-6 rounded-r-lg text-[11px] font-bold tracking-wide hover:brightness-95 transition">SUBSCRIBE</button>
        </form>
      </div>
    </div>
  </section>

  {{-- ===== SHOP BY ROOM ===== --}}
  <section class="max-w-[1440px] mx-auto px-5 mt-10 mb-12">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-2xl text-hl-ink">Shop by Room</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-hl-forest flex items-center gap-1">View All Rooms <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
      @foreach($rooms as $room)
        <a href="{{ route('store.shop') }}" class="group text-center">
          <div class="rounded-2xl overflow-hidden aspect-square bg-hl-goldLight">
            <img src="{{ $room[1] }}" alt="{{ $room[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
          </div>
          <div class="mt-2 text-xs font-semibold text-hl-ink">{{ $room[0] }}</div>
        </a>
      @endforeach
    </div>
  </section>
</main>

@include('store.themes.homeluxe.partials.footer', ['categories' => $categories])
@include('store.themes.homeluxe.partials.mobile-nav')
<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
