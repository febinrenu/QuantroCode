<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.naturae._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Naturia') . ' — Live naturally'])
</head>
<body class="bg-cream text-ink antialiased">

@include('store.themes.naturae.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-leaf-light">
    <button type="button" class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/80 items-center justify-center text-leaf-deep shadow-soft" aria-label="Previous">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
    </button>
    <button type="button" class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 rounded-full bg-white/80 items-center justify-center text-leaf-deep shadow-soft" aria-label="Next">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
    </button>
    <div class="relative max-w-7xl mx-auto px-4 py-14 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <h1 class="text-4xl sm:text-5xl lg:text-[3.4rem] font-display font-semibold text-leaf-deep leading-[1.08]">
          Pure Ingredients.<br>Better Living.
        </h1>
        <p class="mt-5 text-bark/80 max-w-lg leading-relaxed text-[15px]">
          Discover natural &amp; sustainable products for a healthier you and a greener planet.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 rounded-full bg-leaf-dark text-white font-semibold hover:bg-leaf-deep transition-colors shadow-soft">
            Shop Now
          </a>
          <a href="{{ route('store.contact') }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 rounded-full border-2 border-leaf-dark/30 text-leaf-deep font-semibold hover:bg-white/60 transition-colors">
            Learn More
          </a>
        </div>
        <div class="mt-9 flex flex-wrap items-center gap-x-7 gap-y-4 text-bark/70 text-xs font-medium">
          <span class="flex flex-col items-center gap-1.5 text-center w-20"><svg class="w-6 h-6 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg> 100% Natural Ingredients</span>
          <span class="flex flex-col items-center gap-1.5 text-center w-20"><svg class="w-6 h-6 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.5s-7-4.35-9.5-8.6C.87 8.6 2.2 5 5.6 5c1.9 0 3.3 1 4.4 2.5C11.1 6 12.5 5 14.4 5c3.4 0 4.73 3.6 3.1 6.9C19 16.15 12 20.5 12 20.5Z"/></svg> Cruelty Free &amp; Vegan</span>
          <span class="flex flex-col items-center gap-1.5 text-center w-20"><svg class="w-6 h-6 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12c1-4 5-7 9-7s8 3 9 7M3 12c1 4 5 7 9 7s8-3 9-7"/><path stroke-linecap="round" d="M9 12h6"/></svg> Eco Friendly Packaging</span>
        </div>
      </div>
      <div class="relative">
        <div class="absolute -top-3 -right-3 sm:top-2 sm:right-6 z-10 w-24 h-24 rounded-full bg-leaf-dark text-white flex flex-col items-center justify-center text-center shadow-softHover leading-tight">
          <span class="text-[10px] font-semibold uppercase">Up to</span>
          <span class="text-2xl font-display font-bold">35%</span>
          <span class="text-[10px] font-semibold uppercase">Off</span>
        </div>
        <img src="{{ global_asset('images/themes/naturae/hero-products.png') }}" class="rounded-4xl w-full h-auto object-cover shadow-softHover" alt="Natural skincare products">
      </div>
    </div>
    <div class="relative flex items-center justify-center gap-1.5 pb-5">
      <span class="w-6 h-1.5 rounded-full bg-leaf-dark"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-leaf-dark/30"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-leaf-dark/30"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-leaf-dark/30"></span>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft hover:shadow-softHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft hover:shadow-softHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY ICON ROW ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pt-10 pb-4">
      <div class="grid grid-cols-4 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(7) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="flex flex-col items-center justify-center gap-2.5 p-4 rounded-2xl bg-white border border-leaf-light hover:shadow-softHover hover:border-leaf/40 transition-all text-center">
            <x-store.icon :name="category_icon_name($cat->name)" class="w-6 h-6 text-leaf-dark" />
            <span class="text-[11px] font-semibold text-ink/80 leading-snug">{{ $cat->name }}</span>
          </a>
        @endforeach
        <a href="{{ route('store.shop') }}" class="flex flex-col items-center justify-center gap-2.5 p-4 rounded-2xl bg-white border border-leaf-light hover:shadow-softHover hover:border-leaf/40 transition-all text-center">
          <svg class="w-6 h-6 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
          <span class="text-[11px] font-semibold text-ink/80 leading-snug">All Categories</span>
        </a>
      </div>
    </section>
  @endif

  {{-- ===== FEATURE / BENEFIT STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-4">
    <div class="rounded-3xl bg-leaf-light/60 grid grid-cols-2 md:grid-cols-4 divide-x divide-leaf-dark/10">
      @foreach([
        ['icon' => 'truck', 'title' => 'Free Shipping', 'sub' => 'On orders over $60'],
        ['icon' => 'shield', 'title' => 'Secure Payments', 'sub' => '100% safe & secure'],
        ['icon' => 'loop', 'title' => 'Easy Returns', 'sub' => '30 days return policy'],
        ['icon' => 'support', 'title' => 'Customer Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="p-5 flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0">
            @if($item['icon']==='truck')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v9H3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4l3 3v3h-7z"/><circle cx="7" cy="18" r="1.6"/><circle cx="17.5" cy="18" r="1.6"/></svg>
            @elseif($item['icon']==='shield')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
            @elseif($item['icon']==='loop')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12c1-4 5-7 9-7s8 3 9 7M3 12c1 4 5 7 9 7s8-3 9-7"/><path stroke-linecap="round" d="M9 12h6"/></svg>
            @else
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 15v-3a8 8 0 0 1 16 0v3"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 15a2 2 0 0 1 2-2h1v5H6a2 2 0 0 1-2-2Zm16 0a2 2 0 0 0-2-2h-1v5h1a2 2 0 0 0 2-2Z"/></svg>
            @endif
          </div>
          <div>
            <div class="text-sm font-bold text-leaf-deep font-display">{{ $item['title'] }}</div>
            <div class="text-xs text-bark/60">{{ $item['sub'] }}</div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CONTENT BLOCKS (collections from homepage_lineup) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Best Sellers');
        $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      @endphp
      @if($productVms->count())
        <section class="max-w-7xl mx-auto px-4 py-10">
          <div class="flex items-end justify-between mb-6">
            <div>
              <h2 class="text-2xl lg:text-3xl font-display font-bold text-ink">{{ $colTitle }}</h2>
            </div>
            <a href="{{ $collection && $collection->slug ? route('store.shop', ['collection' => $collection->slug]) : route('store.shop') }}" class="text-sm font-semibold text-leaf-dark flex items-center gap-1">
              View All Products
              <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.naturae.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== BEST SELLERS FALLBACK — only when the merchant hasn't curated a
       homepage collection block (homepage_lineup has no 'collection' entry),
       so the storefront never shows an empty gap where products belong. ===== --}}
  @php
    $ntHasCollectionBlock = collect($blocks)->contains(fn ($block) => ($block['type'] ?? '') === 'collection' && ! empty($block['products']));
  @endphp
  @if(!$ntHasCollectionBlock)
    @php
      // Naturia is styled as a natural/wellness storefront, so its Best
      // Sellers teaser is scoped to wellness-relevant categories only —
      // unlike the Shop page, which intentionally stays unrestricted since
      // this theme's own product_category_keywords are empty by design.
      $ntWellnessKeywords = ['beauty', 'cosmetic', 'pharmacy', 'medical', 'grocery', 'fitness', 'home'];
      $ntWellnessCategoryIds = \App\Models\Category::query()->where(function ($q) use ($ntWellnessKeywords) {
        foreach ($ntWellnessKeywords as $kw) {
          $q->orWhereRaw('LOWER(name) LIKE ?', ['%'.$kw.'%']);
        }
      })->pluck('id');
      $ntBestSellers = \App\Models\Product::query()
        ->where('is_active', 1)
        ->where('hide_from_online_store', 0)
        ->whereIn('category_id', $ntWellnessCategoryIds)
        ->with(['variants:id,product_id,name,price,image', 'images:id,product_id,image_path,is_main,sort_order'])
        ->latest('created_at')
        ->take(6)
        ->get();
      $ntStockByProduct = $s->default_warehouse_id
        ? DB::table('product_warehouse')
            ->where('warehouse_id', $s->default_warehouse_id)
            ->whereNull('product_variant_id')
            ->whereIn('product_id', $ntBestSellers->pluck('id'))
            ->pluck('qte', 'product_id')
        : collect();
      foreach ($ntBestSellers as $ntP) {
        $ntP->stock = (float) ($ntStockByProduct[$ntP->id] ?? 0);
      }
      $ntBestSellerVms = $ntBestSellers->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
    @endphp
    @if($ntBestSellerVms->count())
      <section class="max-w-7xl mx-auto px-4 py-10">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl lg:text-3xl font-display font-bold text-ink">Best Sellers</h2>
          <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-leaf-dark flex items-center gap-1">
            View All Products
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
          @foreach($ntBestSellerVms as $product)
            @include('store.themes.naturae.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </section>
    @endif
  @endif

  {{-- ===== SUSTAINABILITY — "SMALL CHOICES, BIG IMPACT" ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-4">
    <div class="relative rounded-3xl overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-cream via-cream/70 to-transparent z-10"></div>
      <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1400&q=70" class="absolute inset-0 w-full h-full object-cover" alt="Forest landscape">
      <div class="relative z-20 grid lg:grid-cols-5 gap-6 items-center p-8 lg:p-10">
        <div class="lg:col-span-2">
          <h2 class="text-2xl lg:text-3xl font-display font-bold text-ink leading-tight">Small Choices,<br>Big Impact</h2>
          <p class="mt-3 text-bark/75 text-sm leading-relaxed max-w-xs">Every purchase supports a healthier you and a healthier planet.</p>
          <a href="{{ route('store.contact') }}" class="mt-5 inline-flex items-center h-11 px-6 rounded-full bg-leaf-dark text-white text-sm font-bold hover:bg-leaf-deep transition-colors">Discover Our Story</a>
        </div>
        <div class="lg:col-span-3 grid grid-cols-2 sm:grid-cols-4 gap-4">
          @foreach([
            ['stat' => '10K+', 'label' => 'Happy Customers'],
            ['stat' => '500+', 'label' => 'Organic Products'],
            ['stat' => '50+', 'label' => 'Countries Served'],
            ['stat' => '100%', 'label' => 'Satisfaction'],
          ] as $stat)
            <div class="text-center bg-white/70 backdrop-blur-sm rounded-2xl py-4 px-2">
              <div class="text-2xl font-display font-bold text-ink">{{ $stat['stat'] }}</div>
              <div class="text-xs text-bark/70 mt-1">{{ $stat['label'] }}</div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- ===== PROMO / COLLECTION CARDS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-5">
    <div class="relative rounded-3xl overflow-hidden h-52 flex items-center justify-between p-6" style="background:#F1E4D2">
      <div class="relative max-w-[55%]">
        <h3 class="text-ink text-xl font-display font-bold leading-snug">Wellness Essentials</h3>
        <p class="text-bark/70 text-xs mt-2 leading-relaxed">Boost your daily wellness routine</p>
        <a href="{{ route('store.shop') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-leaf-dark">Shop Now <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
      </div>
      <img src="{{ global_asset('images/themes/naturae/promo-wellness.png') }}" class="absolute right-3 bottom-0 h-[92%] object-contain" alt="Wellness Essentials">
    </div>
    <div class="relative rounded-3xl overflow-hidden h-52 flex items-center justify-between p-6" style="background:#E7ECDD">
      <div class="relative max-w-[55%]">
        <h3 class="text-leaf-deep text-xl font-display font-bold leading-snug">Glow Naturally</h3>
        <p class="text-bark/70 text-xs mt-2 leading-relaxed">Clean beauty for radiant skin</p>
        <a href="{{ route('store.shop') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-leaf-dark">Shop Now <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
      </div>
      <img src="{{ global_asset('images/themes/naturae/promo-glow.png') }}" class="absolute right-4 bottom-0 h-[92%] object-contain" alt="Glow Naturally">
    </div>
    <div class="relative rounded-3xl overflow-hidden h-52 flex items-center justify-between p-6" style="background:#F3DFCB">
      <div class="relative max-w-[55%]">
        <h3 class="text-ink text-xl font-display font-bold leading-snug">Healthy Inside Out</h3>
        <p class="text-bark/70 text-xs mt-2 leading-relaxed">Organic foods for a better you</p>
        <a href="{{ route('store.shop') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-leaf-dark">Shop Now <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
      </div>
      <img src="{{ global_asset('images/themes/naturae/promo-healthy.png') }}" class="absolute right-3 bottom-2 h-[80%] object-contain" alt="Healthy Inside Out">
    </div>
  </section>

  {{-- ===== NEWSLETTER / COMMUNITY ===== --}}
  <section class="bg-leaf-deep">
    <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col lg:flex-row items-center gap-6 justify-between">
      <div class="flex items-center gap-4 text-cream">
        <span class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center shrink-0">
          <svg class="w-6 h-6 text-terracotta-light" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
        </span>
        <div>
          <h3 class="text-lg font-display font-bold">Join Our Natural Living Community</h3>
          <p class="text-cream/65 text-sm mt-0.5">Subscribe for exclusive offers, tips &amp; new arrivals.</p>
        </div>
      </div>
      <form action="#" method="post" class="w-full lg:w-auto flex gap-3">
        @csrf
        <input type="email" required placeholder="Enter your email address" class="w-full lg:w-72 h-12 px-5 rounded-full border-0 text-sm">
        <button type="submit" class="shrink-0 h-12 px-6 rounded-full bg-terracotta-light text-leaf-deep font-bold text-sm hover:brightness-95 transition-all">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.naturae.partials.footer', ['categories' => $categories])
@include('store.themes.naturae.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
