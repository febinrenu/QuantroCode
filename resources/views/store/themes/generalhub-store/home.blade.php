<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.generalhub-store._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'GeneralHub') . ' — Everything You Need, All in One Place'])
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-hub-blue selection:text-white">

@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@include('store.themes.generalhub-store.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.generalhub-store.partials.mobile-nav')

@php
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  // Collection blocks (merchant-managed via Collections) get woven into the
  // Featured / Best Sellers / New Arrivals grids below when configured, with
  // the theme's original hardcoded product picks kept as a fallback so the
  // page looks identical until a merchant sets up Collections.
  $collectionBlocks = collect($blocks)->filter(fn($b) => ($b['type'] ?? '') === 'collection')->values();
  $allBlockVms = $collectionBlocks->flatMap(function ($block) use ($currency, $hidePrices) {
      return collect($block['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  })->values();

  // 1. Featured Products (4)
  $featuredCodes = ['GEN-EAR-001', 'GEN-WAT-001', 'GEN-BAG-001', 'GEN-SOF-001'];
  $featuredProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $featuredCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $featuredCodes));

  $featuredVms = $featuredProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  // 2. Best Sellers (6)
  $bestsellerCodes = ['GEN-PRF-001', 'GEN-SUN-001', 'GEN-FRY-001', 'GEN-SNK-001', 'GEN-VAC-001', 'GEN-WLT-001'];
  $bestsellerProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $bestsellerCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $bestsellerCodes));

  $bestsellerVms = $bestsellerProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  // 3. New Arrivals (6)
  $newArrivalCodes = ['GEN-HOD-001', 'GEN-KEY-001', 'GEN-LMP-001', 'GEN-BOX-001', 'GEN-CRM-001', 'GEN-YOG-001'];
  $newArrivalProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $newArrivalCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $newArrivalCodes));

  // Attach warehouse stock to all home products
  $warehouseId = (int) ($s->default_warehouse_id ?: 1);
  $allHomeProducts = $featuredProducts->concat($bestsellerProducts)->concat($newArrivalProducts);
  $homeProductIds = $allHomeProducts->pluck('id')->all();
  $warehouseStocks = \Illuminate\Support\Facades\DB::table('product_warehouse')
      ->where('warehouse_id', $warehouseId)
      ->whereIn('product_id', $homeProductIds)
      ->pluck('qte', 'product_id');

  foreach ($allHomeProducts as $p) {
      $p->stock = (int) ($warehouseStocks[$p->id] ?? 100);
  }

  $featuredVms = $featuredProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $bestsellerVms = $bestsellerProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $newArrivalVms = $newArrivalProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  // When merchants configure Collections blocks, weave real collection
  // products into these three grids (in order) instead of the theme's
  // hardcoded picks; fall back to the hardcoded picks when no blocks exist
  // so the page is unchanged for merchants who haven't touched Collections.
  if ($allBlockVms->count()) {
      $featuredVms = $allBlockVms->slice(0, 4)->values();
      $bestsellerVms = $allBlockVms->slice(4, 6)->count() ? $allBlockVms->slice(4, 6)->values() : $allBlockVms->take(6)->values();
      $newArrivalVms = $allBlockVms->slice(10, 6)->count() ? $allBlockVms->slice(10, 6)->values() : $allBlockVms->take(6)->values();
  }

  // Role-tagged Collections (Best Sellers / New Arrivals) -- when a merchant
  // has assigned one, its own curated products win over the generic/hardcoded
  // picks above for that named section.
  $roleVms = collect($collectionsByRole ?? [])->map(function ($r) use ($currency, $hidePrices) {
      return collect($r['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices))->values();
  });
  $bestsellerVms = ($roleVms['best_sellers'] ?? collect())->count() ? $roleVms['best_sellers'] : $bestsellerVms;
  $newArrivalVms = ($roleVms['new_arrivals'] ?? collect())->count() ? $roleVms['new_arrivals'] : $newArrivalVms;
@endphp

<main class="overflow-x-hidden">

  <!-- ==================== 1. HERO SECTION (auto-rotating carousel; add slides via Store Settings > Hero Slides) ==================== -->
  @php $ghsHeroSlides = $heroSlides ?? []; @endphp
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8 sm:py-8">
    <div class="relative bg-gradient-to-br from-[#EBF3FE] via-[#F1F6FF] to-[#E5EFFE] rounded-2xl lg:rounded-3xl border border-blue-100 p-6 sm:p-10 lg:p-14 overflow-hidden shadow-sm grid"
         x-data="{ ghsHero: 0, ghsHeroCount: {{ count($ghsHeroSlides) }} }"
         @if(count($ghsHeroSlides) > 1) x-init="setInterval(() => { ghsHero = (ghsHero + 1) % ghsHeroCount }, 6000)" @endif>

      <!-- Ambient Soft Glow -->
      <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-300/20 rounded-full blur-3xl pointer-events-none"></div>

      @foreach($ghsHeroSlides as $ghsI => $ghsSlide)
        <div x-show="ghsHero === {{ $ghsI }}" @if(!$loop->first) x-cloak @endif
             x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="col-start-1 row-start-1">
          <div class="grid lg:grid-cols-12 gap-8 lg:gap-6 items-center">

            <!-- Left Column: Copy & Actions -->
            <div class="lg:col-span-6 space-y-5 sm:space-y-6 z-10">

              <!-- Trust Badge Pill -->
              <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur-sm border border-blue-200/80 shadow-xs text-xs font-semibold text-hub-blue">
                <span>✦</span>
                <span>Trusted by Thousands of Happy Customers</span>
              </div>

              <!-- Main Heading -->
              <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-[54px] font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                @if(($ghsSlide['title'] ?? '') !== '')
                  {{ $ghsSlide['title'] }}
                @else
                  Everything You Need,<br>
                  All in <span class="text-hub-blue">One Place</span>
                @endif
              </h1>

              <!-- Subtitle -->
              <p class="text-xs sm:text-sm lg:text-base text-slate-600 font-normal leading-relaxed max-w-md">
                {{ ($ghsSlide['subtitle'] ?? '') !== '' ? $ghsSlide['subtitle'] : 'Shop from a wide range of products across electronics, fashion, home, beauty & more.' }}
              </p>

              <!-- CTAs -->
              <div class="flex flex-wrap items-center gap-3.5 pt-2">
                <a href="{{ ($ghsSlide['cta_link'] ?? '') !== '' ? $ghsSlide['cta_link'] : $hubRoute('store.shop') }}" class="h-11 sm:h-12 px-7 sm:px-8 inline-flex items-center justify-center bg-hub-blue hover:bg-hub-blueHover text-white text-xs sm:text-sm font-bold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95">
                  {{ ($ghsSlide['cta_text'] ?? '') !== '' ? $ghsSlide['cta_text'] : 'Shop Now' }}
                </a>
                <a href="{{ $hubRoute('store.shop', ['collection' => 'deals']) }}" class="h-11 sm:h-12 px-6 sm:px-7 inline-flex items-center justify-center bg-white hover:bg-slate-50 text-slate-700 hover:text-hub-blue text-xs sm:text-sm font-semibold rounded-xl border border-slate-300 transition-all shadow-xs">
                  Explore Deals
                </a>
              </div>

            </div>

            <!-- Right Column: Hero Product Composition Imagery Matching Reference -->
            <div class="lg:col-span-6 relative">
              <div class="relative mx-auto max-w-md lg:max-w-none">
                <img src="{{ !empty($ghsSlide['image_url']) ? $ghsSlide['image_url'] : global_asset('images/themes/generalhub/hero-products.jpg') }}"
                     alt="Everything You Need, All in One Place"
                     class="w-full h-auto object-contain filter drop-shadow-xl rounded-2xl">
              </div>
            </div>

          </div>
        </div>
      @endforeach

      <!-- Carousel Pagination Dots -->
      @if(count($ghsHeroSlides) > 1)
        <div class="relative flex items-center justify-center gap-2 mt-4 pt-2">
          @foreach($ghsHeroSlides as $ghsI => $ghsSlide)
            <button type="button" @click="ghsHero = {{ $ghsI }}" class="rounded-full transition-colors" :class="ghsHero === {{ $ghsI }} ? 'w-2.5 h-2.5 bg-hub-blue' : 'w-2 h-2 bg-slate-300'" aria-label="Slide {{ $ghsI + 1 }}"></button>
          @endforeach
        </div>
      @else
        <div class="relative flex items-center justify-center gap-2 mt-4 pt-2">
          <span class="w-2.5 h-2.5 rounded-full bg-hub-blue"></span>
          <span class="w-2 h-2 rounded-full bg-slate-300"></span>
          <span class="w-2 h-2 rounded-full bg-slate-300"></span>
        </div>
      @endif

    </div>
  </section>

  <!-- ==================== 2. VALUE PROPOSITIONS STRIP ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm">
      
      <!-- Feature 1: Free Shipping -->
      <div class="flex items-center gap-3.5 p-2">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-hub-blue flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><rect x="1" y="3" width="15" height="13" rx="1"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Free Shipping</h4>
          <p class="text-[11px] text-slate-500 font-normal">On orders over $49</p>
        </div>
      </div>

      <!-- Feature 2: 30-Day Returns -->
      <div class="flex items-center gap-3.5 p-2">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-hub-blue flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">30-Day Returns</h4>
          <p class="text-[11px] text-slate-500 font-normal">Hassle-free returns</p>
        </div>
      </div>

      <!-- Feature 3: Secure Payments -->
      <div class="flex items-center gap-3.5 p-2">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-hub-blue flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">Secure Payments</h4>
          <p class="text-[11px] text-slate-500 font-normal">100% secure checkout</p>
        </div>
      </div>

      <!-- Feature 4: 24/7 Support -->
      <div class="flex items-center gap-3.5 p-2">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-hub-blue flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
        </div>
        <div>
          <h4 class="text-xs sm:text-sm font-bold text-slate-900">24/7 Support</h4>
          <p class="text-[11px] text-slate-500 font-normal">We're here to help</p>
        </div>
      </div>

    </div>
  </section>

  <!-- ==================== 3. SHOP BY CATEGORY ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
        Shop by Category
      </h2>
      <a href="{{ $hubRoute('store.shop') }}" class="text-xs sm:text-sm font-semibold text-hub-blue hover:underline flex items-center gap-1">
        <span>View All Categories</span>
        <span>&rarr;</span>
      </a>
    </div>

    <!-- 8 Rounded Category Cards Grid -->
    @php
      $categoriesGrid = [
        ['name' => 'Electronics', 'q' => 'electronics', 'img' => global_asset('images/themes/generalhub/cat-electronics.jpg'), 'bg' => 'bg-blue-50/70'],
        ['name' => 'Fashion', 'q' => 'fashion', 'img' => global_asset('images/themes/generalhub/cat-fashion.jpg'), 'bg' => 'bg-pink-50/70'],
        ['name' => 'Home & Living', 'q' => 'home', 'img' => global_asset('images/themes/generalhub/cat-home.jpg'), 'bg' => 'bg-emerald-50/70'],
        ['name' => 'Beauty', 'q' => 'beauty', 'img' => global_asset('images/themes/generalhub/cat-beauty.jpg'), 'bg' => 'bg-orange-50/70'],
        ['name' => 'Accessories', 'q' => 'accessories', 'img' => global_asset('images/themes/generalhub/cat-accessories.jpg'), 'bg' => 'bg-amber-50/70'],
        ['name' => 'Sports', 'q' => 'sports', 'img' => global_asset('images/themes/generalhub/cat-sports.jpg'), 'bg' => 'bg-slate-100/70'],
        ['name' => 'Toys & Games', 'q' => 'toys', 'img' => global_asset('images/themes/generalhub/cat-toys.jpg'), 'bg' => 'bg-yellow-50/70'],
        ['name' => 'Daily Essentials', 'q' => 'essentials', 'img' => global_asset('images/themes/generalhub/cat-essentials.jpg'), 'bg' => 'bg-cyan-50/70'],
      ];
    @endphp

    <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
      @foreach($categoriesGrid as $cat)
        <a href="{{ $hubRoute('store.shop', ['category' => $cat['name']]) }}" class="hub-card group flex flex-col items-center text-center p-3 sm:p-4 bg-white border border-slate-200 rounded-2xl shadow-xs hover:border-hub-blue transition-all">
          <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full {{ $cat['bg'] }} p-2.5 flex items-center justify-center overflow-hidden mb-2.5">
            <img src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
          </div>
          <span class="text-xs font-semibold text-slate-800 group-hover:text-hub-blue transition-colors line-clamp-1">
            {{ $cat['name'] }}
          </span>
        </a>
      @endforeach
    </div>

  </section>

  <!-- ==================== 4. FEATURED PRODUCTS (4 Prominent Cards) ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
        Featured Products
      </h2>
      <a href="{{ $hubRoute('store.shop', ['collection' => 'featured']) }}" class="text-xs sm:text-sm font-semibold text-hub-blue hover:underline flex items-center gap-1">
        <span>View All Products</span>
        <span>&rarr;</span>
      </a>
    </div>

    <!-- 4 Product Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
      @foreach($featuredVms as $product)
        @include('store.themes.generalhub-store.partials.product-card', ['product' => $product])
      @endforeach
    </div>

  </section>

  <!-- ==================== 5. PROMOTIONAL BANNERS (3 Cards) ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
      
      <!-- Promo 1: Summer Sale (customizable via Offers & Promotions) -->
      @if($offer['enabled'] ?? true)
      <div class="relative bg-[#FDEAE2] rounded-2xl border border-orange-200/80 p-6 flex flex-col justify-between overflow-hidden shadow-xs group">
        <div class="relative z-10 space-y-2 max-w-[65%]">
          <span class="text-xs font-bold uppercase tracking-wider text-rose-600">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'Summer Sale' }}</span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
            {{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'Up to 50% Off' }}
          </h3>
          <p class="text-xs text-slate-600 font-normal">{{ ($offer['subtitle'] ?? '') !== '' ? $offer['subtitle'] : 'On Fashion & Accessories' }}</p>
          @if(!empty($offer['discount_text']))
            <span class="inline-flex items-center rounded-full bg-white/70 px-2.5 py-0.5 text-[11px] font-bold text-rose-700">{{ $offer['discount_text'] }}</span>
          @endif
          <div class="pt-2">
            <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : $hubRoute('store.shop', ['category' => 'Fashion']) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
              <span>{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop Now' }}</span> <span>&rarr;</span>
            </a>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : global_asset('images/themes/generalhub/promo-summer-sale.jpg') }}" alt="Summer Sale" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
        </div>
      </div>
      @endif

      <!-- Promo 2: Smart Home Devices (fully customizable via Banners: image, badge, headline, subtitle, button, colors) -->
      @if($bannerGridEnabled ?? true)
      @php $topLeft = ($byPos['top_left'] ?? collect())->first(); @endphp
      <a href="{{ $topLeft ? ($topLeft->link ?: $hubRoute('store.shop', ['category' => 'Home & Living'])) : $hubRoute('store.shop', ['category' => 'Home & Living']) }}" class="relative bg-[#E8F3FE] rounded-2xl border border-blue-200/80 p-6 flex flex-col justify-between overflow-hidden shadow-xs group">
        <div class="relative z-10 space-y-2 max-w-[65%]" @if($topLeft && !empty($topLeft->text_color)) style="color:{{ $topLeft->text_color }};" @endif>
          <span class="text-xs font-bold uppercase tracking-wider text-hub-blue" style="color:inherit;">{{ ($topLeft->badge_text ?? null) ?: 'Smart Home Devices' }}</span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight" style="color:inherit;">
            {{ ($topLeft->title ?? null) ?: 'Make life easier' }}
          </h3>
          @if(!empty($topLeft->subtitle ?? null))
            <p class="text-xs text-slate-600 font-normal" style="color:inherit;">{{ $topLeft->subtitle }}</p>
          @endif
          <div class="pt-4">
            <span class="inline-flex items-center gap-1 px-4 py-2 bg-hub-blue hover:bg-hub-blueHover text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
              <span>{{ ($topLeft->button_text ?? null) ?: 'Shop Now' }}</span> <span>&rarr;</span>
            </span>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          @if($topLeft)
            <img src="{{ $bannerUrl($topLeft) }}" alt="{{ $topLeft->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
          @else
            <img src="{{ global_asset('images/themes/generalhub/promo-smart-home.jpg') }}" alt="Smart Home Devices" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
          @endif
        </div>
      </a>

      <!-- Promo 3: Beauty Picks For You (fully customizable via Banners: image, badge, headline, subtitle, button, colors) -->
      @php $topRight = ($byPos['top_right'] ?? collect())->first(); @endphp
      <a href="{{ $topRight ? ($topRight->link ?: $hubRoute('store.shop', ['category' => 'Beauty'])) : $hubRoute('store.shop', ['category' => 'Beauty']) }}" class="relative bg-[#EAF5EC] rounded-2xl border border-emerald-200/80 p-6 flex flex-col justify-between overflow-hidden shadow-xs group">
        <div class="relative z-10 space-y-2 max-w-[65%]" @if($topRight && !empty($topRight->text_color)) style="color:{{ $topRight->text_color }};" @endif>
          <span class="text-xs font-bold uppercase tracking-wider text-emerald-700" style="color:inherit;">{{ ($topRight->badge_text ?? null) ?: 'Beauty Picks' }}</span>
          <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight" style="color:inherit;">
            {{ ($topRight->title ?? null) ?: 'For You' }}
          </h3>
          <p class="text-xs text-slate-600 font-normal" style="color:inherit;">{{ ($topRight->subtitle ?? null) ?: 'Up to 30% Off' }}</p>
          <div class="pt-2">
            <span class="inline-flex items-center gap-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">
              <span>{{ ($topRight->button_text ?? null) ?: 'Shop Now' }}</span> <span>&rarr;</span>
            </span>
          </div>
        </div>
        <div class="absolute right-0 bottom-0 top-0 w-1/2 overflow-hidden pointer-events-none">
          @if($topRight)
            <img src="{{ $bannerUrl($topRight) }}" alt="{{ $topRight->title }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
          @else
            <img src="{{ global_asset('images/themes/generalhub/promo-beauty-picks.jpg') }}" alt="Beauty Picks" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
          @endif
        </div>
      </a>
      @endif

    </div>
  </section>

  <!-- ==================== 6. BEST SELLERS (6 Cards) ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
        Best Sellers
      </h2>
      <a href="{{ $hubRoute('store.shop', ['collection' => 'bestselling']) }}" class="text-xs sm:text-sm font-semibold text-hub-blue hover:underline flex items-center gap-1">
        <span>View All Best Sellers</span>
        <span>&rarr;</span>
      </a>
    </div>

    <!-- 6 Product Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-5">
      @foreach($bestsellerVms as $product)
        @include('store.themes.generalhub-store.partials.product-card', ['product' => $product])
      @endforeach
    </div>

  </section>

  <!-- ==================== 7. NEW ARRIVALS (6 Cards) ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    
    <!-- Section Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
        New Arrivals
      </h2>
      <a href="{{ $hubRoute('store.shop', ['sort' => 'latest']) }}" class="text-xs sm:text-sm font-semibold text-hub-blue hover:underline flex items-center gap-1">
        <span>View All New Arrivals</span>
        <span>&rarr;</span>
      </a>
    </div>

    <!-- 6 Product Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5 sm:gap-5">
      @foreach($newArrivalVms as $product)
        @include('store.themes.generalhub-store.partials.product-card', ['product' => $product])
      @endforeach
    </div>

  </section>

  <!-- ==================== 8. TRUSTED BY THOUSANDS (Statistics Strip) ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 flex flex-col lg:flex-row items-center justify-between gap-6">
      
      <!-- Left Heading -->
      <div class="text-center lg:text-left max-w-sm">
        <h3 class="text-lg sm:text-xl font-bold text-slate-900">
          Trusted by Thousands
        </h3>
        <p class="text-xs text-slate-500 font-normal mt-1">
          Quality products, secure shopping, and happy customers.
        </p>
      </div>

      <!-- Right 4 Metrics Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 sm:gap-10 text-center">
        
        <div class="flex flex-col items-center gap-1">
          <div class="flex items-center gap-2">
            <span class="text-hub-blue text-lg">📦</span>
            <span class="text-2xl font-extrabold text-slate-900">10K+</span>
          </div>
          <span class="text-xs text-slate-500 font-medium">Products</span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="flex items-center gap-2">
            <span class="text-hub-blue text-lg">👥</span>
            <span class="text-2xl font-extrabold text-slate-900">50K+</span>
          </div>
          <span class="text-xs text-slate-500 font-medium">Happy Customers</span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="flex items-center gap-2">
            <span class="text-hub-blue text-lg">🛡️</span>
            <span class="text-2xl font-extrabold text-slate-900">99.9%</span>
          </div>
          <span class="text-xs text-slate-500 font-medium">Positive Reviews</span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="flex items-center gap-2">
            <span class="text-amber-500 text-lg">★</span>
            <span class="text-2xl font-extrabold text-slate-900">4.8</span>
          </div>
          <span class="text-xs text-slate-500 font-medium">Average Rating</span>
        </div>

      </div>

    </div>
  </section>

  <!-- ==================== 9. WHAT OUR CUSTOMERS SAY ==================== -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    
    <div class="text-center mb-8">
      <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
        What Our Customers Say
      </h2>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
      
      <!-- Review 1 -->
      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-hub-blue text-2xl font-serif leading-none">&ldquo;</div>
          <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
            Amazing product quality and super fast delivery. GeneralHub is my go-to store for everything!
          </p>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/generalhub/avatar-sarah.jpg') }}" alt="Sarah J." class="w-10 h-10 rounded-full object-cover">
            <div>
              <div class="text-xs font-bold text-slate-900">Sarah J.</div>
              <div class="text-[10px] text-emerald-600 font-semibold">Verified Buyer</div>
            </div>
          </div>
          <div class="text-amber-400 text-xs font-bold">★★★★★</div>
        </div>
      </div>

      <!-- Review 2 -->
      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-hub-blue text-2xl font-serif leading-none">&ldquo;</div>
          <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
            Great variety of products and excellent customer service. Highly recommended!
          </p>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/generalhub/avatar-michael.jpg') }}" alt="Michael T." class="w-10 h-10 rounded-full object-cover">
            <div>
              <div class="text-xs font-bold text-slate-900">Michael T.</div>
              <div class="text-[10px] text-emerald-600 font-semibold">Verified Buyer</div>
            </div>
          </div>
          <div class="text-amber-400 text-xs font-bold">★★★★★</div>
        </div>
      </div>

      <!-- Review 3 -->
      <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-hub-blue text-2xl font-serif leading-none">&ldquo;</div>
          <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
            I love the deals and discounts. Saved so much on my recent purchase!
          </p>
        </div>
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/generalhub/avatar-emily.jpg') }}" alt="Emily R." class="w-10 h-10 rounded-full object-cover">
            <div>
              <div class="text-xs font-bold text-slate-900">Emily R.</div>
              <div class="text-[10px] text-emerald-600 font-semibold">Verified Buyer</div>
            </div>
          </div>
          <div class="text-amber-400 text-xs font-bold">★★★★★</div>
        </div>
      </div>

    </div>

    <!-- Review Dots -->
    <div class="flex items-center justify-center gap-2 mt-6">
      <span class="w-2.5 h-2.5 rounded-full bg-hub-blue"></span>
      <span class="w-2 h-2 rounded-full bg-slate-300"></span>
      <span class="w-2 h-2 rounded-full bg-slate-300"></span>
    </div>

  </section>

</main>

@include('store.themes.generalhub-store.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
