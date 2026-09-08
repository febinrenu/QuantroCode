@extends('store.themes.voguelane-couture._shell')

@section('title', 'VogueLane — Wear Your Signature Style | Luxury Fashion & Apparel')

@section('content')

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $warehouseId = (int) ($s->default_warehouse_id ?: 1);

  // 1. Curated For You Products (6)
  $curatedCodes = ['VOG-DRS-001', 'VOG-BLZ-001', 'VOG-BAG-001', 'VOG-SHO-001', 'VOG-ACC-001', 'VOG-JWL-001'];
  $curatedProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $curatedCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $curatedCodes));

  // 2. Trending Products (6)
  $trendingCodes = ['VOG-DRS-002', 'VOG-SHO-002', 'VOG-SHT-001', 'VOG-BAG-002', 'VOG-BEA-001', 'VOG-TRS-001'];
  $trendingProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $trendingCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $trendingCodes));

  // 3. New Arrivals Products (6)
  $newArrivalCodes = ['VOG-DRS-001', 'VOG-BAG-001', 'VOG-TRS-001', 'VOG-MEN-001', 'VOG-MEN-002', 'VOG-JWL-002'];
  $newArrivalProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $newArrivalCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $newArrivalCodes));

  // 4. Top Rated Products (6)
  $topRatedCodes = ['VOG-DRS-001', 'VOG-BLZ-001', 'VOG-JWL-001', 'VOG-BEA-001', 'VOG-SHO-001', 'VOG-BAG-001'];
  $topRatedProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $topRatedCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $topRatedCodes));

  // Attach warehouse stock
  $allHomeProducts = $curatedProducts->concat($trendingProducts)->concat($newArrivalProducts)->concat($topRatedProducts);
  $homeProductIds = $allHomeProducts->pluck('id')->all();
  $warehouseStocks = \Illuminate\Support\Facades\DB::table('product_warehouse')
      ->where('warehouse_id', $warehouseId)
      ->whereIn('product_id', $homeProductIds)
      ->pluck('qte', 'product_id');

  foreach ($allHomeProducts as $p) {
      $p->stock = (int) ($warehouseStocks[$p->id] ?? 100);
  }

  $curatedVms = $curatedProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $trendingVms = $trendingProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $newArrivalVms = $newArrivalProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $topRatedVms = $topRatedProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<!-- ==================== 1. HERO SECTION ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-8">
  <div class="relative bg-[#F4EFEA] rounded-2xl sm:rounded-3xl overflow-hidden border border-black/5">
    <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[460px] sm:min-h-[540px] items-center">
      
      <!-- Left Editorial Copy (7 cols on desktop) -->
      <div class="lg:col-span-6 p-6 sm:p-10 lg:p-14 z-10 space-y-4 sm:space-y-6">
        <span class="inline-block text-[11px] sm:text-xs font-bold uppercase tracking-[0.2em] text-vog-tan">
          New Season 2024
        </span>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl lg:text-6xl font-normal text-slate-900 leading-[1.1] tracking-tight">
          Wear Your <br>
          <span class="font-bold italic">Signature Style</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 font-normal max-w-md leading-relaxed">
          Timeless pieces. Modern silhouettes. Made for every moment that matters.
        </p>
        
        <!-- Hero CTAs -->
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
          <a href="{{ $vogRoute('store.shop', ['collection' => 'new-in']) }}" 
             class="px-6 sm:px-8 py-3 bg-vog-black hover:bg-neutral-800 text-white text-xs sm:text-sm font-semibold rounded-full shadow-sm active:scale-95 transition-all">
            Shop New In
          </a>
          <a href="{{ $vogRoute('store.shop') }}" 
             class="px-6 sm:px-8 py-3 bg-white/80 hover:bg-white text-slate-900 border border-slate-300 text-xs sm:text-sm font-semibold rounded-full shadow-2xs active:scale-95 transition-all">
            Explore Collection
          </a>
        </div>

        <!-- Carousel Indicator Dots -->
        <div class="flex items-center gap-1.5 pt-4">
          <span class="w-5 h-1.5 rounded-full bg-vog-black"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
          <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
        </div>

      </div>

      <!-- Right Editorial Photography (5 cols on desktop) -->
      <div class="lg:col-span-6 relative h-72 sm:h-96 lg:h-full min-h-[380px] lg:min-h-[540px] overflow-hidden flex items-end justify-center">
        <img src="{{ global_asset('images/themes/voguelane/hero-model.jpg') }}" 
             alt="VogueLane High Fashion Model" 
             class="absolute inset-0 w-full h-full object-cover object-center">
        
        <!-- Floating Secondary Card: Summer Elegance Collection -->
        <div class="absolute bottom-6 left-6 z-20 bg-white/95 backdrop-blur-md p-3.5 sm:p-4 rounded-xl shadow-lg border border-black/5 flex items-center gap-3.5 max-w-[240px]">
          <div class="w-12 h-14 rounded-lg overflow-hidden bg-slate-100 shrink-0">
            <img src="{{ global_asset('images/themes/voguelane/hero-collection-card.jpg') }}" alt="Summer Elegance" class="w-full h-full object-cover">
          </div>
          <div class="space-y-1">
            <span class="block text-[11px] font-bold text-slate-900 leading-tight">Summer Elegance Collection</span>
            <a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-vog-tan hover:underline">
              <span>Explore</span> <span>&rarr;</span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- ==================== 2. CATEGORY STRIP (7 Round Cards) ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
  @php
    $categoriesStrip = [
      ['name' => 'Women', 'img' => global_asset('images/themes/voguelane/cat-women.jpg')],
      ['name' => 'Men', 'img' => global_asset('images/themes/voguelane/cat-men.jpg')],
      ['name' => 'Shoes', 'img' => global_asset('images/themes/voguelane/cat-shoes.jpg')],
      ['name' => 'Bags', 'img' => global_asset('images/themes/voguelane/cat-bags.jpg')],
      ['name' => 'Accessories', 'img' => global_asset('images/themes/voguelane/cat-accessories.jpg')],
      ['name' => 'Beauty', 'img' => global_asset('images/themes/voguelane/cat-beauty.jpg')],
      ['name' => 'Jewelry', 'img' => global_asset('images/themes/voguelane/cat-jewelry.jpg')],
    ];
  @endphp

  <div class="flex items-center justify-between sm:justify-around gap-4 overflow-x-auto no-scrollbar pb-2 pt-1">
    @foreach($categoriesStrip as $cat)
      <a href="{{ $vogRoute('store.shop', ['category' => $cat['name']]) }}" 
         class="group flex flex-col items-center text-center shrink-0 min-w-[72px] sm:min-w-[90px]">
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden border-2 border-transparent group-hover:border-vog-tan p-0.5 transition-all shadow-xs mb-2">
          <img src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-300">
        </div>
        <span class="text-xs font-semibold text-slate-800 group-hover:text-vog-tan transition-colors">
          {{ $cat['name'] }}
        </span>
      </a>
    @endforeach
  </div>
</section>

<!-- ==================== 3. CURATED FOR YOU (6 Product Cards) ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
  
  <!-- Section Header -->
  <div class="flex items-end justify-between mb-6 sm:mb-8">
    <div>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
        Curated For You
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
        Handpicked styles for every part of your life.
      </p>
    </div>
    <a href="{{ $vogRoute('store.shop', ['collection' => 'featured']) }}" class="text-xs sm:text-sm font-semibold text-slate-900 hover:text-vog-tan underline transition-colors">
      View All
    </a>
  </div>

  <!-- 6 Product Cards Grid -->
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
    @foreach($curatedVms as $product)
      @include('store.themes.voguelane-couture.partials.product-card', ['product' => $product])
    @endforeach
  </div>

</section>

<!-- ==================== 4. SERVICE / TRUST STRIP ==================== -->
<section class="border-y border-vog-border bg-vog-ivory py-6 sm:py-8 my-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
      
      <!-- 1. Easy Returns -->
      <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-900 border border-vog-border shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Easy Returns</h4>
          <p class="text-[11px] text-slate-500 font-normal">30-day return policy</p>
        </div>
      </div>

      <!-- 2. Secure Checkout -->
      <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-900 border border-vog-border shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Secure Checkout</h4>
          <p class="text-[11px] text-slate-500 font-normal">100% secure payments</p>
        </div>
      </div>

      <!-- 3. Worldwide Shipping -->
      <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-900 border border-vog-border shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-.778.099-1.533.284-2.253" /></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Worldwide Shipping</h4>
          <p class="text-[11px] text-slate-500 font-normal">Fast delivery worldwide</p>
        </div>
      </div>

      <!-- 4. Customer Support -->
      <div class="flex items-center gap-3.5">
        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-900 border border-vog-border shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Customer Support</h4>
          <p class="text-[11px] text-slate-500 font-normal">Mon–Sun 9am – 9pm</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ==================== 5. EDITORIAL / PROMOTIONAL GRID ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6">
    
    <!-- Large Left Card: Effortless Looks For Sunny Days (6 cols) -->
    <div class="lg:col-span-6 relative bg-[#EFEAE3] rounded-2xl overflow-hidden min-h-[380px] sm:min-h-[460px] flex flex-col justify-between p-6 sm:p-10 group">
      <div class="relative z-10 space-y-3 max-w-[65%]">
        <span class="text-[11px] font-bold uppercase tracking-widest text-slate-500">New Season</span>
        <h3 class="font-serif-luxury text-2xl sm:text-4xl font-bold text-slate-900 leading-tight">
          Effortless Looks <br>For Sunny Days
        </h3>
        <div class="pt-2">
          <a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" 
             class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-900 hover:text-vog-tan underline transition-colors">
            <span>Shop Now</span> <span>&rarr;</span>
          </a>
        </div>
      </div>
      <div class="absolute right-0 bottom-0 top-0 w-3/5 overflow-hidden pointer-events-none">
        <img src="{{ global_asset('images/themes/voguelane/effortless-sunny-days.jpg') }}" 
             alt="Effortless Looks For Sunny Days" 
             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
      </div>
    </div>

    <!-- 4-Card Right Grid (6 cols) -->
    <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
      
      <!-- Card 1: Minimal Essentials -->
      <div class="relative bg-vog-warm rounded-2xl p-5 flex flex-col justify-between overflow-hidden group min-h-[200px]">
        <div class="relative z-10 space-y-1 max-w-[60%]">
          <h4 class="font-serif-luxury text-base sm:text-lg font-bold text-slate-900 leading-snug">Minimal Essentials</h4>
          <p class="text-[11px] text-slate-500">Clean. Chic. Timeless.</p>
          <div class="pt-3">
            <a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" class="text-[11px] font-bold uppercase tracking-wider text-slate-900 hover:text-vog-tan underline">
              Shop Now &rarr;
            </a>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          <img src="{{ global_asset('images/themes/voguelane/minimal-essentials.jpg') }}" alt="Minimal Essentials" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <!-- Card 2: Street Style -->
      <div class="relative bg-vog-warm rounded-2xl p-5 flex flex-col justify-between overflow-hidden group min-h-[200px]">
        <div class="relative z-10 space-y-1 max-w-[60%]">
          <h4 class="font-serif-luxury text-base sm:text-lg font-bold text-slate-900 leading-snug">Street Style</h4>
          <p class="text-[11px] text-slate-500">Bold fits. Real moments.</p>
          <div class="pt-3">
            <a href="{{ $vogRoute('store.shop', ['category' => 'Men']) }}" class="text-[11px] font-bold uppercase tracking-wider text-slate-900 hover:text-vog-tan underline">
              Shop Now &rarr;
            </a>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          <img src="{{ global_asset('images/themes/voguelane/street-style.jpg') }}" alt="Street Style" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <!-- Card 3: Luxury Bags -->
      <div class="relative bg-vog-warm rounded-2xl p-5 flex flex-col justify-between overflow-hidden group min-h-[200px]">
        <div class="relative z-10 space-y-1 max-w-[60%]">
          <h4 class="font-serif-luxury text-base sm:text-lg font-bold text-slate-900 leading-snug">Luxury Bags</h4>
          <p class="text-[11px] text-slate-500">Iconic pieces. Lasting value.</p>
          <div class="pt-3">
            <a href="{{ $vogRoute('store.shop', ['category' => 'Bags']) }}" class="text-[11px] font-bold uppercase tracking-wider text-slate-900 hover:text-vog-tan underline">
              Shop Now &rarr;
            </a>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          <img src="{{ global_asset('images/themes/voguelane/luxury-bags.jpg') }}" alt="Luxury Bags" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <!-- Card 4: Beauty Edit -->
      <div class="relative bg-vog-warm rounded-2xl p-5 flex flex-col justify-between overflow-hidden group min-h-[200px]">
        <div class="relative z-10 space-y-1 max-w-[60%]">
          <h4 class="font-serif-luxury text-base sm:text-lg font-bold text-slate-900 leading-snug">Beauty Edit</h4>
          <p class="text-[11px] text-slate-500">Your glow. Your way.</p>
          <div class="pt-3">
            <a href="{{ $vogRoute('store.shop', ['category' => 'Beauty']) }}" class="text-[11px] font-bold uppercase tracking-wider text-slate-900 hover:text-vog-tan underline">
              Shop Now &rarr;
            </a>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          <img src="{{ global_asset('images/themes/voguelane/beauty-edit.jpg') }}" alt="Beauty Edit" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ==================== 6. TRENDING NOW (Tabs: Best Sellers, New Arrivals, Top Rated) ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" x-data="{ currentTab: 'bestsellers' }">
  
  <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 sm:mb-8 border-b border-vog-border pb-4">
    <div>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
        Trending Now
      </h2>
    </div>

    <!-- Tab Buttons -->
    <div class="flex items-center gap-6 text-xs sm:text-sm font-semibold tracking-wide">
      <button type="button" 
              @click="currentTab = 'bestsellers'"
              :class="currentTab === 'bestsellers' ? 'text-slate-900 border-b-2 border-slate-900 pb-1' : 'text-slate-400 hover:text-slate-700'"
              class="transition-all">
        Best Sellers
      </button>
      <button type="button" 
              @click="currentTab = 'newarrivals'"
              :class="currentTab === 'newarrivals' ? 'text-slate-900 border-b-2 border-slate-900 pb-1' : 'text-slate-400 hover:text-slate-700'"
              class="transition-all">
        New Arrivals
      </button>
      <button type="button" 
              @click="currentTab = 'toprated'"
              :class="currentTab === 'toprated' ? 'text-slate-900 border-b-2 border-slate-900 pb-1' : 'text-slate-400 hover:text-slate-700'"
              class="transition-all">
        Top Rated
      </button>
    </div>

    <a href="{{ $vogRoute('store.shop') }}" class="hidden sm:inline-block text-xs font-semibold text-slate-900 hover:text-vog-tan underline transition-colors">
      View All
    </a>
  </div>

  <!-- Tab 1: Best Sellers -->
  <div x-show="currentTab === 'bestsellers'" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
    @foreach($trendingVms as $product)
      @include('store.themes.voguelane-couture.partials.product-card', ['product' => $product])
    @endforeach
  </div>

  <!-- Tab 2: New Arrivals -->
  <div x-show="currentTab === 'newarrivals'" x-cloak class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
    @foreach($newArrivalVms as $product)
      @include('store.themes.voguelane-couture.partials.product-card', ['product' => $product])
    @endforeach
  </div>

  <!-- Tab 3: Top Rated -->
  <div x-show="currentTab === 'toprated'" x-cloak class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
    @foreach($topRatedVms as $product)
      @include('store.themes.voguelane-couture.partials.product-card', ['product' => $product])
    @endforeach
  </div>

</section>

<!-- ==================== 7. LOOKBOOK (5 Editorial Cards) ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
  
  <div class="flex items-end justify-between mb-6">
    <div>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
        Lookbook
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
        Style inspiration for every mood.
      </p>
    </div>
    <a href="{{ $vogRoute('store.shop') }}" class="text-xs sm:text-sm font-semibold text-slate-900 hover:text-vog-tan underline transition-colors">
      View More
    </a>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
    
    @php
      $lookbooks = [
        ['title' => 'City Chic', 'img' => global_asset('images/themes/voguelane/lookbook-city-chic.jpg'), 'cat' => 'Women'],
        ['title' => 'Vacation Mood', 'img' => global_asset('images/themes/voguelane/lookbook-vacation.jpg'), 'cat' => 'Women'],
        ['title' => 'Neutral Tones', 'img' => global_asset('images/themes/voguelane/lookbook-neutral.jpg'), 'cat' => 'Women'],
        ['title' => 'Night Out', 'img' => global_asset('images/themes/voguelane/lookbook-night-out.jpg'), 'cat' => 'Women'],
        ['title' => 'Weekend Vibes', 'img' => global_asset('images/themes/voguelane/lookbook-weekend.jpg'), 'cat' => 'Women'],
      ];
    @endphp

    @foreach($lookbooks as $item)
      <a href="{{ $vogRoute('store.shop', ['category' => $item['cat']]) }}" 
         class="group relative aspect-[3/4] rounded-xl overflow-hidden bg-slate-100 shadow-xs flex items-end p-3 sm:p-4">
        <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="relative z-10">
          <span class="text-xs sm:text-sm font-serif-luxury font-bold text-white tracking-wide block group-hover:text-amber-300 transition-colors">
            {{ $item['title'] }}
          </span>
        </div>
      </a>
    @endforeach

  </div>

</section>

<!-- ==================== 8. TESTIMONIALS (3 Luxury Reviews) ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Testimonial 1 -->
    <div class="bg-vog-ivory p-6 sm:p-7 rounded-2xl border border-vog-border space-y-4">
      <div class="flex items-center text-amber-400 text-sm tracking-wider">
        ★★★★★
      </div>
      <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
        &ldquo;The quality is amazing and the fit is perfect. VogueLane is my new go-to for everything!&rdquo;
      </p>
      <div class="flex items-center gap-3 pt-2">
        <div class="w-9 h-9 rounded-full overflow-hidden bg-slate-200">
          <img src="{{ global_asset('images/themes/voguelane/avatar-emma.jpg') }}" alt="Emma R." class="w-full h-full object-cover">
        </div>
        <div>
          <span class="block text-xs font-bold text-slate-900">Emma R.</span>
          <span class="block text-[10px] text-slate-400 font-medium">Verified Buyer</span>
        </div>
      </div>
    </div>

    <!-- Testimonial 2 -->
    <div class="bg-vog-ivory p-6 sm:p-7 rounded-2xl border border-vog-border space-y-4">
      <div class="flex items-center text-amber-400 text-sm tracking-wider">
        ★★★★★
      </div>
      <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
        &ldquo;Fast delivery, beautiful packaging, and the clothes are even better in person.&rdquo;
      </p>
      <div class="flex items-center gap-3 pt-2">
        <div class="w-9 h-9 rounded-full overflow-hidden bg-slate-200">
          <img src="{{ global_asset('images/themes/voguelane/avatar-sophia.jpg') }}" alt="Sophia L." class="w-full h-full object-cover">
        </div>
        <div>
          <span class="block text-xs font-bold text-slate-900">Sophia L.</span>
          <span class="block text-[10px] text-slate-400 font-medium">Verified Buyer</span>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="bg-vog-ivory p-6 sm:p-7 rounded-2xl border border-vog-border space-y-4">
      <div class="flex items-center text-amber-400 text-sm tracking-wider">
        ★★★★★
      </div>
      <p class="text-xs sm:text-sm text-slate-700 leading-relaxed italic">
        &ldquo;Love the minimal aesthetic and timeless pieces. Highly recommend!&rdquo;
      </p>
      <div class="flex items-center gap-3 pt-2">
        <div class="w-9 h-9 rounded-full overflow-hidden bg-slate-200">
          <img src="{{ global_asset('images/themes/voguelane/avatar-chloe.jpg') }}" alt="Chloe M." class="w-full h-full object-cover">
        </div>
        <div>
          <span class="block text-xs font-bold text-slate-900">Chloe M.</span>
          <span class="block text-[10px] text-slate-400 font-medium">Verified Buyer</span>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- ==================== 9. NEWSLETTER / SIGNUP BANNER ==================== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  <div class="relative bg-[#EFEAE3] rounded-2xl sm:rounded-3xl p-6 sm:p-10 lg:p-12 overflow-hidden border border-black/5">
    <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
      
      <!-- Left: Model + Copy -->
      <div class="flex items-center gap-5 sm:gap-6">
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full overflow-hidden bg-slate-200 shrink-0 border-2 border-white shadow-md">
          <img src="{{ global_asset('images/themes/voguelane/newsletter-model.jpg') }}" alt="Join VogueLane" class="w-full h-full object-cover">
        </div>
        <div>
          <h3 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
            Be the first to know
          </h3>
          <p class="text-xs sm:text-sm text-slate-600 font-normal mt-1">
            New arrivals, exclusive offers and style tips straight to your inbox.
          </p>
        </div>
      </div>

      <!-- Right: Subscription Form -->
      <div class="w-full lg:max-w-md">
        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex items-center bg-white rounded-full p-1.5 shadow-sm border border-vog-border">
          @csrf
          <input type="email" 
                 name="email" 
                 required 
                 placeholder="Enter your email address" 
                 class="w-full text-xs sm:text-sm text-slate-900 placeholder-slate-400 px-4 py-2 bg-transparent outline-none">
          <button type="submit" class="bg-vog-black hover:bg-neutral-800 text-white text-xs sm:text-sm font-semibold px-6 py-2.5 rounded-full shrink-0 transition-colors">
            Subscribe
          </button>
        </form>
        <span class="block text-[11px] text-slate-400 mt-2 pl-4">
          No spam, unsubscribe anytime.
        </span>
      </div>

    </div>
  </div>
</section>

@endsection
