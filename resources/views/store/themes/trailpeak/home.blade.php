<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.trailpeak._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'TrailPeak') . ' — Gear Up For The Wild'])
</head>
<body class="bg-tp-cream text-tp-ink antialiased">

@include('store.themes.trailpeak.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $featured = collect($blocks)->where('type','collection')->flatMap(fn($b) => $b['products'] ?? [])->unique('id')->take(6)
      ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  $sidebarCats = ['Hiking','Camping','Backpacking','Climbing','Cycling','Water Sports','Winter Sports','Travel Essentials'];

  $categoryTiles = [
    ['Hiking', 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=420&q=80'],
    ['Camping', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=420&q=80'],
    ['Backpacking', 'https://images.unsplash.com/photo-1516939884455-1445c8652f83?auto=format&fit=crop&w=420&q=80'],
    ['Climbing', 'https://images.unsplash.com/photo-1522163182402-834f871fd851?auto=format&fit=crop&w=420&q=80'],
    ['Travel Gear', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=420&q=80'],
  ];

  $articles = [
    ['7 Epic Hikes You Need to Do This Summer', 'Emma Walker', 'May 12, 2024', 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=200&q=80'],
    ['Camping Meals That Hit Different Outdoors', 'TrailPeak Team', 'May 8, 2024', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=200&q=80'],
    ['How to Stay Safe on Mountain Trails', 'Alex Johnson', 'May 4, 2024', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=200&q=80'],
  ];

  $brands = ['The North Face', 'Patagonia', "Arc'teryx", 'Salomon', 'MSR', 'YETI', 'Merrell', 'Black Diamond'];

  $activities = [
    ['Trekking', 'M13 10V3L4 14h7v7l9-11h-7z'],
    ['Camping', 'M3 20h18M12 4 3 20h18L12 4Z'],
    ['Cycling', 'M5 18a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm14 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM5 15l4-7h4l3 7M9 8h4'],
    ['Trail Running', 'M13 3 4 14h6l-1 7 9-11h-6l1-7Z'],
    ['Fishing', 'M2 12s4-6 10-6 10 6 10 6-4 6-10 6S2 12 2 12Zm10 0h.01'],
    ['Travel', 'M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2.5 1.5V22L12 21l3.5 1.5v-1.5L13 19v-5.5Z'],
  ];
@endphp

<main>
  {{-- ===== HERO ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 pt-5 grid lg:grid-cols-[220px_1fr] gap-5">
    <aside class="hidden lg:block rounded-xl bg-tp-ink text-white overflow-hidden self-start">
      <div class="bg-tp-orange px-5 h-12 flex items-center gap-2 font-bold text-xs">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3v2m0 14v2m9-9h-2M5 12H3"/></svg>
        FIND YOUR GEAR
      </div>
      <div class="py-2">
        @foreach($sidebarCats as $cat)
          <a href="{{ route('store.shop') }}" class="flex justify-between items-center px-5 py-2.5 text-xs hover:text-tp-orange hover:bg-white/5">{{ $cat }} <span>›</span></a>
        @endforeach
      </div>
      <a href="{{ route('store.shop') }}" class="block m-3 text-center bg-tp-orange text-white text-[11px] font-bold py-2.5 rounded">VIEW ALL CATEGORIES</a>
    </aside>

    <div class="tp-hero relative rounded-xl min-h-[420px] overflow-hidden flex items-center bg-tp-sand">
      <div class="absolute inset-0 bg-gradient-to-r from-tp-sand via-tp-sand/75 to-transparent"></div>
      <div class="relative ml-8 md:ml-12 max-w-[440px]">
        <span class="eyebrow text-tp-orange text-xs font-bold">Explore. Equip. Conquer.</span>
        <h1 class="font-display text-[38px] md:text-[48px] leading-[1.05] mt-2 text-tp-ink">GEAR UP<br>FOR THE WILD</h1>
        <p class="mt-4 text-sm text-tp-ink/70">Premium outdoor gear for every adventure.<br>Built tough. Tested wild. Trusted by explorers.</p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="bg-tp-orange text-white px-6 py-3.5 rounded text-xs font-bold hover:brightness-95 transition">SHOP BESTSELLERS</a>
          <a href="{{ route('store.shop') }}" class="bg-white border border-tp-ink/20 px-6 py-3.5 rounded text-xs font-bold hover:bg-tp-cream transition">EXPLORE COLLECTIONS</a>
        </div>
        <div class="mt-7 flex items-center gap-2 text-xs font-semibold text-tp-ink/80">
          <span class="flex items-center gap-1"><svg class="w-4 h-4 text-tp-orange" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>4.9 (2.3k Reviews)</span>
          <span class="text-tp-mute">· Trusted by 50,000+ Adventurers</span>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRUST BAR ===== --}}
  <section class="bg-tp-forest text-white mt-6">
    <div class="max-w-[1400px] mx-auto px-5 grid grid-cols-2 lg:grid-cols-4 divide-x divide-white/10">
      @foreach([
        ['truck','Free Shipping','On orders $75+'],
        ['shield','Adventure Warranty',"Gear that's built to last"],
        ['box','Easy Returns','30-day hassle free'],
        ['headset','Expert Support',"We're outdoor pros"],
      ] as $item)
        <div class="p-5 flex items-center gap-3">
          <span class="text-tp-orange shrink-0">
            @switch($item[0])
              @case('truck')<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>@break
              @case('shield')<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>@break
              @case('box')<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 8 12 3 3 8v8l9 5 9-5V8Zm0 0-9 5-9-5m9 5v9"/></svg>@break
              @default<svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 11a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1v-6h3M3 11h3v6H5a2 2 0 0 1-2-2z"/></svg>
            @endswitch
          </span>
          <span class="text-[11px] leading-tight"><b class="block font-bold">{{ $item[1] }}</b><small class="text-white/60">{{ $item[2] }}</small></span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY GRID ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-8 grid grid-cols-2 md:grid-cols-5 gap-4">
    @foreach($categoryTiles as $tile)
      <a href="{{ route('store.shop') }}" class="group relative rounded-lg overflow-hidden h-40 bg-tp-ink">
        <img src="{{ $tile[1] }}" alt="{{ $tile[0] }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 group-hover:opacity-100 transition duration-500">
        <span class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></span>
        <span class="absolute bottom-3 left-3 text-white font-display text-sm">{{ strtoupper($tile[0]) }}<br><small class="font-sans font-semibold text-[10px] flex items-center gap-1">SHOP NOW <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></small></span>
      </a>
    @endforeach
  </section>

  {{-- ===== FEATURED GEAR ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-xl text-tp-ink flex items-center gap-2">
        <svg class="w-5 h-5 text-tp-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 20 12 4l9 16H3Z"/></svg>
        FEATURED GEAR
      </h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-tp-forest flex items-center gap-1">VIEW ALL PRODUCTS <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    @if($featured->isNotEmpty())
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($featured as $product)
          @include('store.themes.trailpeak.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    @else
      <div class="rounded-lg bg-white border border-tp-line p-10 text-center text-sm text-tp-mute">Add products to your Outdoor &amp; Adventure Gear category to display your collection here.</div>
    @endif
  </section>

  {{-- ===== PROMO ROW ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10 grid lg:grid-cols-3 gap-5">
    <a href="{{ route('store.shop') }}" class="relative lg:col-span-1 rounded-lg overflow-hidden min-h-[260px] flex items-end p-6">
      <img src="https://images.unsplash.com/photo-1533240332313-0db49b459ad6?auto=format&fit=crop&w=700&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Summer adventure sale">
      <span class="absolute inset-0 bg-gradient-to-t from-black/80 to-black/10"></span>
      <div class="relative text-white">
        <h3 class="font-display text-xl leading-tight">SUMMER ADVENTURE SALE</h3>
        <div class="font-display text-3xl text-tp-orange mt-1">UP TO 30% OFF</div>
        <p class="text-xs mt-1">SELECT GEAR</p>
        <span class="inline-block mt-3 bg-tp-orange text-white text-[11px] font-bold px-4 py-2 rounded">SHOP THE SALE</span>
      </div>
    </a>
    <div class="grid grid-rows-2 gap-5">
      <a href="{{ route('store.shop') }}" class="relative rounded-lg overflow-hidden min-h-[118px] flex items-end p-5">
        <img src="https://images.unsplash.com/photo-1516939884455-1445c8652f83?auto=format&fit=crop&w=500&q=80" class="absolute inset-0 w-full h-full object-cover" alt="Gear guide">
        <span class="absolute inset-0 bg-black/50"></span>
        <div class="relative text-white text-xs">
          <b class="text-sm">GEAR GUIDE</b><br>How to Choose the Right Backpack<br>
          <span class="font-bold text-tp-orange">READ GUIDE →</span>
        </div>
      </a>
      <a href="{{ route('store.shop') }}" class="relative rounded-lg overflow-hidden min-h-[118px] flex items-end p-5">
        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=500&q=80" class="absolute inset-0 w-full h-full object-cover" alt="New arrivals">
        <span class="absolute inset-0 bg-black/50"></span>
        <div class="relative text-white text-xs">
          <b class="text-sm">NEW ARRIVALS</b><br>Check Out the Latest Gear<br>
          <span class="font-bold text-tp-orange">SHOP NEW →</span>
        </div>
      </a>
    </div>
    <div class="bg-white border border-tp-line rounded-lg p-5">
      <div class="flex justify-between items-center mb-3">
        <h3 class="font-display text-sm text-tp-ink">ADVENTURE STORIES</h3>
        <a href="{{ route('store.shop') }}" class="text-[11px] font-bold text-tp-forest">VIEW ALL STORIES →</a>
      </div>
      <div class="space-y-3">
        @foreach($articles as $a)
          <a href="{{ route('store.shop') }}" class="flex gap-3 items-center">
            <img src="{{ $a[3] }}" class="w-14 h-14 rounded object-cover shrink-0" alt="">
            <div class="min-w-0">
              <div class="text-xs font-bold text-tp-ink leading-snug">{{ $a[0] }}</div>
              <div class="text-[10px] text-tp-mute mt-0.5">By {{ $a[1] }} · {{ $a[2] }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== BRAND STRIP ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10">
    <div class="flex flex-wrap justify-center gap-x-10 gap-y-3">
      @foreach($brands as $brand)
        <span class="text-sm font-bold text-tp-ink/50 tracking-wide">{{ strtoupper($brand) }}</span>
      @endforeach
    </div>
  </section>

  {{-- ===== SHOP BY ACTIVITY ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10">
    <h2 class="font-display text-lg text-center text-tp-ink mb-5 flex items-center justify-center gap-2">
      <svg class="w-5 h-5 text-tp-forest" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 20 12 4l9 16H3Z"/></svg>
      SHOP BY ACTIVITY
    </h2>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
      @foreach($activities as $act)
        <a href="{{ route('store.shop') }}" class="bg-white border border-tp-line rounded-lg p-5 flex flex-col items-center gap-2 text-center hover:border-tp-forest transition-colors">
          <svg class="w-7 h-7 text-tp-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $act[1] }}"/></svg>
          <span class="text-[11px] font-bold text-tp-ink">{{ strtoupper($act[0]) }}</span>
          <span class="text-[10px] font-bold text-tp-forest">SHOP NOW →</span>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== COMMUNITY / NEWSLETTER ===== --}}
  <section class="mt-12">
    <div class="relative bg-tp-ink text-white px-5 py-12 overflow-hidden">
      <svg class="absolute right-8 top-1/2 -translate-y-1/2 w-32 h-32 text-white/10 hidden md:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.6"><circle cx="12" cy="12" r="10"/><path d="M12 2v2m0 16v2m10-10h-2M4 12H2m14.5-6.5-1.5 1.5m-6 6-1.5 1.5m0-9 1.5 1.5m6 6 1.5 1.5"/></svg>
      <div class="max-w-[1400px] mx-auto relative text-center">
        <h2 class="font-display text-2xl">JOIN THE TRAILPEAK COMMUNITY</h2>
        <p class="text-sm text-white/70 mt-2 max-w-lg mx-auto">Get adventure inspiration, gear tips, exclusive offers and early access to new arrivals.</p>
        <form class="flex max-w-md mx-auto mt-6" onsubmit="return false;">
          <input type="email" placeholder="Enter your email address" class="h-12 flex-1 min-w-0 px-4 text-xs text-tp-ink rounded-l outline-none">
          <button class="bg-tp-orange text-white px-6 rounded-r text-[11px] font-bold hover:brightness-95 transition">SIGN ME UP</button>
        </form>
        <div class="flex flex-wrap justify-center gap-x-6 gap-y-1 mt-4 text-[11px] text-white/60">
          <span>✓ Exclusive Deals</span><span>✓ Gear Guides</span><span>✓ Trail Stories</span>
        </div>
      </div>
    </div>
  </section>
</main>

@include('store.themes.trailpeak.partials.footer', ['categories' => $categories])
@include('store.themes.trailpeak.partials.mobile-nav')
<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
