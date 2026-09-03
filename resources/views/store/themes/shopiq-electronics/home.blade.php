<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.shopiq-electronics._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'ShopIQ') . ' — New Season New Style'])
</head>
<body class="bg-iq-cream text-iq-navy antialiased">

@include('store.themes.shopiq-electronics.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $featured = collect($blocks)->where('type','collection')->flatMap(fn($b) => $b['products'] ?? [])->unique('id')->take(6)
      ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  $sidebarCats = ['Headphones & Audio','Wearables','Drones & Cameras','Keyboards & Accessories','Speakers','Smart Home','Cables & Chargers','Cases & Covers'];

  $categoryTiles = [
    ['Headphones & Audio', 'Immersive sound, anywhere', '#EDEBFC', 'text-iq-purple'],
    ['Wearables', 'Track every step', '#FCE7F3', 'text-rose-600'],
    ['Drones & Cameras', 'Capture it all', '#DCFCE7', 'text-emerald-600'],
    ['Keyboards & Accessories', 'Type in comfort', '#FEF3C7', 'text-amber-600'],
    ['Speakers', 'Fill the room', '#DBEAFE', 'text-sky-600'],
  ];

  $brands = ['Apple', 'Samsung', 'Sony', 'JBL', 'Bose', 'Garmin', 'DJI', 'Philips'];
@endphp

<main>
  {{-- ===== HERO ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 pt-5 grid lg:grid-cols-[240px_1fr] gap-5">
    <aside class="hidden lg:block rounded-2xl bg-white border border-iq-line overflow-hidden self-start">
      <div class="bg-iq-purple px-5 h-12 flex items-center gap-2 font-bold text-xs text-white">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        BROWSE CATEGORIES
      </div>
      <div class="py-2">
        @foreach($sidebarCats as $cat)
          <a href="{{ route('store.shop') }}" class="flex justify-between items-center px-5 py-2.5 text-xs hover:text-iq-purple hover:bg-iq-lav/40">{{ $cat }} <span>›</span></a>
        @endforeach
      </div>
      <a href="{{ route('store.shop') }}" class="block m-3 text-center bg-iq-lav text-iq-purple text-[11px] font-bold py-2.5 rounded-lg">VIEW ALL CATEGORIES →</a>
    </aside>

    <div class="relative rounded-2xl min-h-[420px] overflow-hidden flex items-center" style="background:radial-gradient(circle at 80% 20%, #ec4899 0%, transparent 45%), linear-gradient(120deg,#0d9488,#0891b2);">
      <button class="absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 grid place-items-center text-iq-navy" aria-label="Previous">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
      </button>
      <div class="relative ml-8 md:ml-12 max-w-[440px] text-white">
        <span class="eyebrow text-iq-gold text-xs font-bold">Super Sale</span>
        <h1 class="font-display text-[38px] md:text-[46px] leading-[1.08] mt-1">New Season<br>New Style</h1>
        <p class="mt-3 text-sm text-white/85">Up to 50% OFF on top picks!</p>
        <a href="{{ route('store.shop') }}" class="inline-block mt-6 bg-iq-gold text-iq-navy px-7 py-3.5 rounded-full text-xs font-bold hover:brightness-95 transition">SHOP NOW</a>
      </div>
      <button class="absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 grid place-items-center text-iq-navy" aria-label="Next">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
      </button>
      <div class="absolute bottom-4 inset-x-0 flex justify-center gap-1.5">
        @for($i=0;$i<3;$i++)<span class="w-1.5 h-1.5 rounded-full {{ $i===0 ? 'bg-white' : 'bg-white/40' }}"></span>@endfor
      </div>
    </div>
  </section>

  {{-- ===== TRUST BAR ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-8">
    <div class="bg-white rounded-2xl border border-iq-line grid grid-cols-2 lg:grid-cols-4 divide-x divide-iq-line">
      @foreach([
        ['truck','bg-iq-lav text-iq-purple','Free Shipping','On orders over $59'],
        ['refresh','bg-emerald-100 text-emerald-600','Easy Returns','30-day return policy'],
        ['shield','bg-amber-100 text-amber-600','Secure Payments','100% secure checkout'],
        ['headset','bg-rose-100 text-rose-600','24/7 Support',"We're here to help"],
      ] as $item)
        <div class="p-5 flex items-center gap-3">
          <span class="w-11 h-11 rounded-full grid place-items-center shrink-0 {{ $item[1] }}">
            @switch($item[0])
              @case('truck')<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>@break
              @case('refresh')<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>@break
              @case('shield')<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>@break
              @default<svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 11a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1v-6h3M3 11h3v6H5a2 2 0 0 1-2-2z"/></svg>
            @endswitch
          </span>
          <span class="text-[11px] leading-tight"><b class="block font-bold text-iq-navy">{{ $item[2] }}</b><small class="text-iq-mute">{{ $item[3] }}</small></span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY GRID ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-8 grid grid-cols-2 md:grid-cols-5 gap-4">
    @foreach($categoryTiles as $tile)
      <a href="{{ route('store.shop') }}" class="rounded-2xl p-5 flex flex-col justify-between min-h-[150px]" style="background:{{ $tile[2] }}">
        <div>
          <div class="font-display font-bold text-sm {{ $tile[3] }}">{{ $tile[0] }}</div>
          <div class="text-[11px] text-iq-mute mt-1">{{ $tile[1] }}</div>
        </div>
        <span class="text-[11px] font-bold {{ $tile[3] }} flex items-center gap-1">SHOP NOW <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></span>
      </a>
    @endforeach
  </section>

  {{-- ===== TOP PICKS ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-xl text-iq-navy">Top Picks For You</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-iq-purple flex items-center gap-1">View All Products <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    @if($featured->isNotEmpty())
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($featured as $product)
          @include('store.themes.shopiq-electronics.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    @else
      <div class="rounded-2xl bg-white border border-iq-line p-10 text-center text-sm text-iq-mute">Add products to your Electronics &amp; Gadgets category to display your collection here.</div>
    @endif
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10">
    <div class="rounded-2xl bg-iq-gold px-6 py-8 md:px-10 flex flex-col md:flex-row items-center gap-6">
      <svg class="w-10 h-10 text-iq-navy shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="2" y="4" width="20" height="16" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m2 6 10 7 10-7"/></svg>
      <div class="flex-1 text-center md:text-left">
        <h2 class="font-display text-xl text-iq-navy">Don't Miss Out!</h2>
        <p class="text-xs text-iq-navy/70 mt-1">Subscribe to get exclusive offers, new arrivals, and shopping inspiration.</p>
      </div>
      <form class="flex w-full md:w-auto max-w-md" onsubmit="return false;">
        <input type="email" placeholder="Enter your email address" class="h-12 flex-1 min-w-0 px-4 text-xs text-iq-navy rounded-l-lg outline-none">
        <button class="bg-iq-purple text-white px-6 rounded-r-lg text-[11px] font-bold hover:brightness-95 transition">SUBSCRIBE</button>
      </form>
    </div>
  </section>

  {{-- ===== SHOP BY BRAND ===== --}}
  <section class="max-w-[1400px] mx-auto px-5 mt-10 mb-12">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-lg text-iq-navy">Shop by Brand</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-iq-purple">View All Brands →</a>
    </div>
    <div class="flex flex-wrap items-center gap-4">
      @foreach($brands as $brand)
        <span class="flex-1 min-w-[110px] text-center bg-white border border-iq-line rounded-xl py-4 font-display font-bold text-sm text-iq-navy/70">{{ strtoupper($brand) }}</span>
      @endforeach
    </div>
  </section>
</main>

@include('store.themes.shopiq-electronics.partials.footer', ['categories' => $categories])
@include('store.themes.shopiq-electronics.partials.mobile-nav')
<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
