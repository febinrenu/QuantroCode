<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.freshcart._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'FreshCart') . ' — Fresh Picks, Delivered Daily'])
</head>
<body class="bg-brand-cream text-brand-ink antialiased">

@include('store.themes.freshcart.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  // Collect all VMs from collection blocks so we can weave them into the
  // tabbed module (section 11) and the 3-column dense lists (section 13).
  $collectionBlocks = collect($blocks)->filter(fn($b) => ($b['type'] ?? '') === 'collection')->values();
  $allBlockVms = $collectionBlocks->flatMap(function ($block) use ($currency, $hidePrices) {
      return collect($block['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  })->values();

  // Icon glyphs cycled across category tiles / aisle chips for visual variety.
  $catIcons = [
    '<path d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m14-6h2m-2 6h2M7 7h10v10H7z"/>', // electronics chip
    '<path d="M6 4h3l1 2h4l1-2h3v3l-2 2v11H8V9L6 7z"/>', // shirt
    '<path d="m3 11 9-7 9 7v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>', // home
    '<path d="M12 2v6m0 0-3 3m3-3 3 3M5 22c0-6 3-9 7-9s7 3 7 9"/>', // beauty/spa drop
    '<path d="M3 3h2l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>', // grocery cart
    '<circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/>', // sports ball
    '<path d="M4 4h16v4H4zM4 10h16v10H4z"/>', // books/boxes
    '<path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>', // general goods
  ];
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== 1. HERO WITH SIDEBAR ===== --}}
  <section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12 grid lg:grid-cols-3 gap-6">

      {{-- Hero (2/3) --}}
      <div class="lg:col-span-2 relative overflow-hidden rounded-3xl bg-brand-greenDeep">
        <div class="absolute inset-0">
          <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&w=1400&q=70" alt="" class="w-full h-full object-cover opacity-25">
          <div class="absolute inset-0 bg-gradient-to-r from-brand-greenDeep via-brand-greenDeep/90 to-brand-greenDeep/40"></div>
        </div>
        <div class="relative px-6 py-10 sm:px-10 sm:py-14 lg:py-20">
          <span class="eyebrow text-brand-orange text-xs font-bold">Fresh picks, delivered daily</span>
          <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight max-w-xl">
            {{ $s->hero_title ?? 'Everything your household needs, in one warm marketplace' }}
          </h1>
          <p class="mt-4 text-brand-cream/80 max-w-lg">
            {{ $s->hero_subtitle ?? 'From weekly groceries to gadgets, fashion, home essentials, beauty and sporting goods — shop it all with same-day dispatch and a friendly return policy.' }}
          </p>
          <div class="mt-7 flex flex-wrap gap-3">
            <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-full bg-brand-orange text-white font-semibold hover:bg-brand-orangeDark transition-colors">
              Start shopping
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-full border border-white/25 text-white font-semibold hover:bg-white/10 transition-colors">
              Today's deals
            </a>
          </div>
          <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-brand-cream/80 text-xs">
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free delivery over $59</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 30-day easy returns</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 24/7 real-human support</span>
          </div>
        </div>
      </div>

      {{-- Sidebar (1/3): Today's Categories / Quick Links --}}
      <aside class="rounded-3xl bg-white border border-brand-green/10 shadow-card p-5 flex flex-col">
        <h3 class="text-sm font-black text-brand-greenDeep uppercase tracking-wide mb-3">Today's Categories</h3>
        <ul class="space-y-1 flex-1">
          @forelse($categories->take(6) as $i => $cat)
            <li>
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="flex items-center gap-3 px-2 py-2.5 rounded-xl hover:bg-brand-greenLight transition-colors group">
                <span class="w-9 h-9 shrink-0 rounded-full bg-brand-greenLight text-brand-green flex items-center justify-center group-hover:bg-brand-green group-hover:text-white transition-colors">
                  <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $catIcons[$i % count($catIcons)] !!}</svg>
                </span>
                <span class="text-sm font-semibold text-brand-ink flex-1">{{ $cat->name }}</span>
                <svg class="w-4 h-4 text-brand-inkSoft/50 group-hover:text-brand-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
              </a>
            </li>
          @empty
            <li class="text-sm text-brand-inkSoft">Categories coming soon.</li>
          @endforelse
        </ul>
        <a href="{{ route('store.shop') }}" class="mt-3 inline-flex items-center justify-center h-11 rounded-full bg-brand-greenDeep text-white text-sm font-semibold hover:bg-brand-green transition-colors">
          Browse full catalog
        </a>
      </aside>
    </div>
  </section>

  {{-- ===== 4. TRUST FEATURES BAR ===== --}}
  <section class="bg-white border-y border-brand-green/10">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6 text-center">
      @foreach([
        ['icon' => '<path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="5.5" cy="18.5" r="1.5"/><circle cx="18.5" cy="18.5" r="1.5"/>', 'title' => 'Free Delivery', 'sub' => 'On orders over $59'],
        ['icon' => '<path d="M12 2 3 6v6c0 5 3.8 8.5 9 10 5.2-1.5 9-5 9-10V6z"/>', 'title' => 'Secure Payment', 'sub' => 'Encrypted checkout'],
        ['icon' => '<path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/>', 'title' => 'Easy Returns', 'sub' => '30-day window'],
        ['icon' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>', 'title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-11 h-11 mx-auto rounded-full bg-brand-orangeLight text-brand-orange flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $item['icon'] !!}</svg>
          </div>
          <div class="text-sm font-bold text-brand-greenDeep">{{ $item['title'] }}</div>
          <div class="text-xs text-brand-inkSoft">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== 5. SHOP BY CATEGORY (icon tile grid) ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10">
      <div class="flex items-end justify-between mb-5">
        <div>
          <span class="eyebrow text-brand-orange text-xs font-bold">Browse</span>
          <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Shop by Category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-brand-green hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(16) as $i => $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 rounded-2xl bg-white border border-brand-green/10 hover:border-brand-green hover:shadow-card transition-all">
            <span class="w-12 h-12 rounded-full bg-brand-greenLight text-brand-green flex items-center justify-center group-hover:bg-brand-green group-hover:text-white transition-colors">
              <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $catIcons[$i % count($catIcons)] !!}</svg>
            </span>
            <span class="text-xs font-semibold text-center text-brand-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== 6. TODAY'S DEALS COUNTDOWN BANNER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="relative overflow-hidden rounded-3xl bg-brand-orange">
      <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1400&q=70" class="w-full h-full object-cover opacity-20" alt="">
      </div>
      <div class="relative px-6 py-8 sm:px-10 sm:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="text-center md:text-left">
          <span class="eyebrow text-white/80 text-xs font-bold">Limited time</span>
          <h2 class="text-2xl sm:text-3xl font-black text-white mt-1">Today's Deals — Up to 50% Off</h2>
          <p class="text-white/85 text-sm mt-2 max-w-md">Across electronics, fashion, home &amp; grocery. Deals refresh every day, so grab yours before the clock runs out.</p>
        </div>
        <div class="flex flex-col items-center gap-3 shrink-0">
          <div class="flex items-center gap-2">
            <div class="fc-countdown-chip rounded-xl px-3 py-2 text-center min-w-[64px]">
              <div class="text-white text-xl font-black leading-none">04</div>
              <div class="text-white/70 text-[10px] uppercase tracking-wide mt-1">Hours</div>
            </div>
            <span class="text-white text-xl font-black">:</span>
            <div class="fc-countdown-chip rounded-xl px-3 py-2 text-center min-w-[64px]">
              <div class="text-white text-xl font-black leading-none">12</div>
              <div class="text-white/70 text-[10px] uppercase tracking-wide mt-1">Minutes</div>
            </div>
            <span class="text-white text-xl font-black">:</span>
            <div class="fc-countdown-chip rounded-xl px-3 py-2 text-center min-w-[64px]">
              <div class="text-white text-xl font-black leading-none">33</div>
              <div class="text-white/70 text-[10px] uppercase tracking-wide mt-1">Seconds</div>
            </div>
          </div>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-11 px-6 inline-flex items-center rounded-full bg-white text-brand-orangeDark font-bold hover:bg-brand-cream transition-colors">Shop the Deals →</a>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== 7. SHOP BY AISLE (horizontally scrollable chip strip) ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10">
      <div class="mb-5">
        <span class="eyebrow text-brand-orange text-xs font-bold">Quick browse</span>
        <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Shop by Aisle</h2>
      </div>
      <div class="fc-aisle-scroll flex gap-3 overflow-x-auto no-scrollbar pb-2">
        @foreach($categories as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="shrink-0 inline-flex items-center gap-2 pl-2 pr-4 py-2 rounded-full bg-white border border-brand-green/15 hover:border-brand-green hover:bg-brand-greenLight transition-colors shadow-card">
            <span class="w-8 h-8 rounded-full bg-brand-orangeLight text-brand-orange flex items-center justify-center text-xs font-black">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-4 h-4" />
            </span>
            <span class="text-sm font-semibold text-brand-ink whitespace-nowrap">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== 8/9/10. THREE PROMO BANNERS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6 space-y-4">

    {{-- Promo 1: Electronics --}}
    @php $topLeft = ($byPos['top_left'] ?? collect())->first(); @endphp
    <a href="{{ $topLeft ? ($topLeft->link ?: route('store.shop')) : route('store.shop') }}" class="relative block rounded-3xl overflow-hidden h-48 sm:h-56">
      @if($topLeft)
        <img src="{{ $bannerUrl($topLeft) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $topLeft->title }}">
      @else
        <img src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&w=1400&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      @endif
      <div class="absolute inset-0 bg-gradient-to-r from-brand-greenDeep/90 via-brand-greenDeep/50 to-transparent"></div>
      <div class="relative h-full flex flex-col justify-center px-8 max-w-md">
        <span class="text-brand-orange text-xs font-bold uppercase eyebrow">Tech Deals</span>
        <h3 class="text-white text-2xl font-black mt-1">Save big on audio, wearables &amp; smart home</h3>
        <span class="mt-3 inline-flex w-fit items-center gap-1 text-sm font-semibold text-white underline">Shop electronics →</span>
      </div>
    </a>

    {{-- Promo 2: Fashion --}}
    @php $topRight = ($byPos['top_right'] ?? collect())->first(); @endphp
    <a href="{{ $topRight ? ($topRight->link ?: route('store.shop')) : route('store.shop') }}" class="relative block rounded-3xl overflow-hidden h-48 sm:h-56">
      @if($topRight)
        <img src="{{ $bannerUrl($topRight) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $topRight->title }}">
      @else
        <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1400&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      @endif
      <div class="absolute inset-0 bg-gradient-to-r from-brand-orangeDark/90 via-brand-orangeDark/50 to-transparent"></div>
      <div class="relative h-full flex flex-col justify-center px-8 max-w-md">
        <span class="text-white text-xs font-bold uppercase eyebrow">Fashion Edit</span>
        <h3 class="text-white text-2xl font-black mt-1">New season styles for the whole family</h3>
        <span class="mt-3 inline-flex w-fit items-center gap-1 text-sm font-semibold text-white underline">Shop fashion →</span>
      </div>
    </a>

    {{-- Promo 3: Home & Beauty --}}
    @php $centerLeft = ($byPos['center_left'] ?? collect())->first(); @endphp
    <a href="{{ $centerLeft ? ($centerLeft->link ?: route('store.shop')) : route('store.shop') }}" class="relative block rounded-3xl overflow-hidden h-48 sm:h-56">
      @if($centerLeft)
        <img src="{{ $bannerUrl($centerLeft) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $centerLeft->title }}">
      @else
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      @endif
      <div class="absolute inset-0 bg-gradient-to-r from-brand-green/90 via-brand-green/50 to-transparent"></div>
      <div class="relative h-full flex flex-col justify-center px-8 max-w-md">
        <span class="text-brand-orangeLight text-xs font-bold uppercase eyebrow">Home &amp; Beauty</span>
        <h3 class="text-white text-2xl font-black mt-1">Refresh your space and your self-care routine</h3>
        <span class="mt-3 inline-flex w-fit items-center gap-1 text-sm font-semibold text-white underline">Shop home &amp; beauty →</span>
      </div>
    </a>
  </section>

  {{-- ===== 11. TABBED CONTENT MODULE ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10" x-data="{ tab: 'a' }">
    <div class="flex items-end justify-between mb-5 flex-wrap gap-3">
      <div>
        <span class="eyebrow text-brand-orange text-xs font-bold">Curated for you</span>
        <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Discover More</h2>
      </div>
      <div class="inline-flex bg-white rounded-full border border-brand-green/15 p-1 shadow-card">
        <button type="button" class="fc-tab-btn px-4 h-9 rounded-full text-sm font-semibold text-brand-inkSoft transition-colors" :class="tab === 'a' ? 'bg-brand-greenLight text-brand-green' : ''" @click="tab = 'a'" aria-selected="tab === 'a'" :aria-selected="tab === 'a'">New Arrivals</button>
        <button type="button" class="fc-tab-btn px-4 h-9 rounded-full text-sm font-semibold text-brand-inkSoft transition-colors" :class="tab === 'b' ? 'bg-brand-greenLight text-brand-green' : ''" @click="tab = 'b'" :aria-selected="tab === 'b'">Best Sellers</button>
        <button type="button" class="fc-tab-btn px-4 h-9 rounded-full text-sm font-semibold text-brand-inkSoft transition-colors" :class="tab === 'c' ? 'bg-brand-greenLight text-brand-green' : ''" @click="tab = 'c'" :aria-selected="tab === 'c'">On Sale</button>
      </div>
    </div>

    @if($allBlockVms->count())
      <div x-show="tab === 'a'">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          @foreach($allBlockVms->take(5) as $product)
            @include('store.themes.freshcart.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </div>
      <div x-show="tab === 'b'" x-cloak>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          @foreach($allBlockVms->slice(5, 5)->count() ? $allBlockVms->slice(5, 5) : $allBlockVms->take(5) as $product)
            @include('store.themes.freshcart.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </div>
      <div x-show="tab === 'c'" x-cloak>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          @foreach($allBlockVms->filter(fn($p) => $p['is_on_sale'])->count() ? $allBlockVms->filter(fn($p) => $p['is_on_sale'])->take(5) : $allBlockVms->take(5) as $product)
            @include('store.themes.freshcart.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </div>
    @else
      <div class="text-center py-14 bg-white rounded-2xl border border-brand-green/10">
        <p class="text-brand-inkSoft text-sm">New picks are being stocked — check back soon, or explore the full catalog.</p>
        <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-brand-green font-semibold text-sm underline">Browse the shop →</a>
      </div>
    @endif
  </section>

  {{-- ===== EXTRA COLLECTION GRID SECTIONS (from $blocks, dense) ===== --}}
  @foreach($collectionBlocks as $block)
    @php
      $blockProducts = collect($block['products'] ?? []);
      $collection = $block['collection'] ?? null;
      $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Picks');
      $productVms = $blockProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
    @endphp
    @if($productVms->count())
      <section class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex items-end justify-between mb-5">
          <h2 class="text-2xl font-black text-brand-greenDeep">{{ $colTitle }}</h2>
          @if($collection && $collection->slug)
            <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-brand-green hover:underline">View all →</a>
          @endif
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.freshcart.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </section>
    @endif
  @endforeach

  {{-- ===== 12. RECIPE / LIFESTYLE INSPIRATION ===== --}}
  <section class="bg-white border-y border-brand-green/10">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="mb-7">
        <span class="eyebrow text-brand-orange text-xs font-bold">Inspiration</span>
        <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Ideas Worth Sharing</h2>
        <p class="text-sm text-brand-inkSoft mt-1 max-w-xl">Recipes, routines and setup guides curated by our team — because a great store is about more than just checkout.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach([
          ['img' => '1495474472287-4d71bcdd2085', 'tag' => 'Breakfast', 'title' => "5-Minute Breakfast Ideas", 'blurb' => 'Quick, wholesome mornings using pantry staples you probably already have on hand.'],
          ['img' => '1504384308090-c894fdcc538d', 'tag' => 'Weekend', 'title' => 'Weekend Grill Guide', 'blurb' => 'Our favorite marinades, sides and tools for a backyard cookout that impresses.'],
          ['img' => '1540574163026-643ea20ade25', 'tag' => 'Meal Prep', 'title' => 'Meal Prep Made Simple', 'blurb' => 'Batch-cook smarter with containers, staples and a plan that saves you time all week.'],
          ['img' => '1542838132-92c53300491e', 'tag' => 'Fresh Finds', 'title' => 'Seasonal Produce Picks', 'blurb' => 'What to buy fresh this month and how to make the most of every bite.'],
        ] as $card)
          <a href="{{ route('store.shop') }}" class="group rounded-2xl overflow-hidden bg-brand-cream border border-brand-green/10 hover:shadow-cardHover transition-shadow">
            <div class="aspect-[4/3] overflow-hidden">
              <img src="https://images.unsplash.com/photo-{{ $card['img'] }}?auto=format&fit=crop&w=700&q=70" alt="{{ $card['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-4">
              <span class="text-[11px] font-bold uppercase tracking-wide text-brand-orange">{{ $card['tag'] }}</span>
              <h3 class="text-sm font-bold text-brand-greenDeep mt-1 leading-snug">{{ $card['title'] }}</h3>
              <p class="text-xs text-brand-inkSoft mt-1.5 leading-relaxed">{{ $card['blurb'] }}</p>
              <span class="mt-2 inline-flex text-xs font-semibold text-brand-green">Read more →</span>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== 13. THREE-COLUMN DENSE PRODUCT LISTS ===== --}}
  @php
    $col1 = $allBlockVms->slice(0, 5)->values();
    $col2 = $allBlockVms->slice(5, 5)->count() ? $allBlockVms->slice(5, 5)->values() : $allBlockVms->slice(0, 5)->reverse()->values();
    $col3 = $allBlockVms->filter(fn($p) => $p['is_on_sale'])->take(5)->values();
    if ($col3->isEmpty()) { $col3 = $allBlockVms->slice(0, 5)->shuffle()->values(); }
  @endphp
  @if($allBlockVms->count())
    <section class="max-w-7xl mx-auto px-4 py-10">
      <div class="mb-6">
        <span class="eyebrow text-brand-orange text-xs font-bold">Trending</span>
        <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Shoppers Are Loving</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['title' => 'Your Basket Favorites', 'items' => $col1],
          ['title' => 'Popular Near You', 'items' => $col2],
          ['title' => 'Best Sellers', 'items' => $col3],
        ] as $colBlock)
          <div class="bg-white rounded-2xl border border-brand-green/10 shadow-card p-4">
            <h3 class="text-sm font-black text-brand-greenDeep uppercase tracking-wide mb-3">{{ $colBlock['title'] }}</h3>
            <div class="divide-y divide-brand-green/10">
              @forelse($colBlock['items'] as $item)
                <a href="{{ $item['url'] }}" class="flex items-center gap-3 py-3 group">
                  <div class="w-12 h-12 rounded-lg overflow-hidden bg-brand-greenLight shrink-0 flex items-center justify-center" style="{{ !$item['image_url'] ? 'background:'.$item['placeholder_color'].'22' : '' }}">
                    @if($item['image_url'])
                      <img src="{{ $item['image_url'] }}" class="w-full h-full object-cover" alt="{{ $item['name'] }}">
                    @else
                      <span class="text-sm font-black" style="color: {{ $item['placeholder_color'] }}">{{ strtoupper(substr($item['name'],0,1)) }}</span>
                    @endif
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-brand-ink line-clamp-1 group-hover:text-brand-green">{{ $item['name'] }}</div>
                    @if(!$item['hide_prices'])
                      <div class="text-xs font-bold text-brand-greenDeep mt-0.5">{{ $item['final_price_formatted'] }}</div>
                    @endif
                  </div>
                </a>
              @empty
                <p class="text-xs text-brand-inkSoft py-3">Nothing here yet.</p>
              @endforelse
            </div>
          </div>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== 14. TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-brand-green/10">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="text-center mb-8">
        <span class="eyebrow text-brand-orange text-xs font-bold">Testimonials</span>
        <h2 class="text-2xl font-black text-brand-greenDeep mt-1">Loved by Shoppers Everywhere</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'role' => 'Verified Buyer', 'quote' => 'I ordered groceries, a blender and a pair of sneakers together — everything arrived fresh and on time. This is genuinely my go-to store now.'],
          ['name' => 'Daniel R.', 'role' => 'Verified Buyer', 'quote' => 'The category range is wild — electronics, skincare, and pantry staples all in one cart. Delivery was fast and the packaging was careful.'],
          ['name' => 'Priya S.', 'role' => 'Verified Buyer', 'quote' => 'Prices are honest and returns were genuinely easy. Customer support answered my question in minutes, no hoops to jump through.'],
        ] as $t)
          <div class="p-6 rounded-2xl bg-brand-cream border border-brand-green/10">
            <div class="flex gap-0.5 text-brand-orange mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-brand-ink/80 leading-relaxed">"{{ $t['quote'] }}"</p>
            <div class="mt-3 flex items-center gap-2">
              <span class="w-8 h-8 rounded-full bg-brand-greenLight text-brand-green flex items-center justify-center text-xs font-black">{{ strtoupper(substr($t['name'],0,1)) }}</span>
              <div>
                <div class="text-sm font-bold text-brand-greenDeep">{{ $t['name'] }}</div>
                <div class="text-[11px] text-brand-inkSoft">{{ $t['role'] }}</div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== 15. NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-3xl bg-brand-greenDeep p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center relative overflow-hidden">
      <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-brand-orange/20"></div>
      <div class="lg:col-span-2 relative">
        <h3 class="text-2xl font-black text-white">Get fresh deals before anyone else</h3>
        <p class="text-brand-cream/70 text-sm mt-2">Join our list for early access to sales, new arrivals and seasonal recipes — across every category, every week.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2 relative">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 rounded-full border-0 text-sm">
        <button type="submit" class="h-12 px-6 rounded-full bg-brand-orange text-white font-bold hover:bg-brand-orangeDark transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.freshcart.partials.footer', ['categories' => $categories])
@include('store.themes.freshcart.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
