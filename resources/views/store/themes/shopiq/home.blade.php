<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.shopiq._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'ShopIQ') . ' — Shop Smarter'])
</head>
<body class="bg-brand-bg text-brand-ink antialiased">

@include('store.themes.shopiq.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  // Find the first collection block with products to power the hero's "Trending Now" mini carousel.
  $iqFirstCollectionBlock = collect($blocks)->first(function ($block) {
      return ($block['type'] ?? '') === 'collection' && collect($block['products'] ?? [])->isNotEmpty();
  });
  $iqTrendingVms = $iqFirstCollectionBlock
      ? collect($iqFirstCollectionBlock['products'])->take(4)->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices))
      : collect();
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== SPLIT-SCREEN HERO ===== --}}
  <section class="relative overflow-hidden bg-brand-navy">
    <div class="absolute inset-0 iq-grid-lines opacity-40"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-14 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">

      {{-- Left: headline / subcopy / CTA --}}
      <div>
        <span class="eyebrow text-brand-teal text-xs font-bold inline-flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
          Data-driven shopping
        </span>
        <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
          {{ $s->hero_title ?? 'Shop smarter, not harder.' }}
        </h1>
        <p class="mt-4 text-slate-300 max-w-lg">
          {{ $s->hero_subtitle ?? 'We track prices and compare options across electronics, fashion, home, beauty, grocery and sports — so every product you see here is already a smart pick.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-lg bg-brand-teal text-white font-semibold hover:bg-brand-tealDark transition-colors">
            Start comparing
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-lg border border-white/25 text-white font-semibold hover:bg-white/10 transition-colors">
            See best value
          </a>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-slate-300 text-xs">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Prices verified daily</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Rated 4.8/5</span>
        </div>
      </div>

      {{-- Right: "Trending Now" mini product carousel --}}
      <div class="relative">
        <div class="flex items-center justify-between mb-3 px-1">
          <span class="text-white text-sm font-bold inline-flex items-center gap-1.5">
            <svg class="w-4 h-4 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>
            Trending Now
          </span>
          <span class="text-[11px] text-slate-400">Updated live</span>
        </div>

        @if($iqTrendingVms->isNotEmpty())
          <div class="no-scrollbar flex lg:grid lg:grid-cols-2 gap-3 overflow-x-auto pb-2">
            @foreach($iqTrendingVms as $tp)
              <a href="{{ $tp['url'] }}" class="shrink-0 w-40 lg:w-auto bg-white/95 rounded-xl p-2.5 shadow-cardHover flex flex-col gap-2 hover:-translate-y-0.5 transition-transform">
                <div class="relative aspect-square rounded-lg overflow-hidden" style="{{ !$tp['image_url'] ? 'background:'.$tp['placeholder_color'].'22' : '' }}">
                  @if($tp['image_url'])
                    <img src="{{ $tp['image_url'] }}" alt="{{ $tp['name'] }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full flex items-center justify-center text-xl font-black" style="color: {{ $tp['placeholder_color'] }}">{{ strtoupper(substr($tp['name'],0,1)) }}</div>
                  @endif
                  <span class="absolute top-1 left-1 bg-brand-violet text-white text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-full">Trending</span>
                </div>
                <div class="text-xs font-semibold text-brand-navy line-clamp-1">{{ $tp['name'] }}</div>
                @if(!$tp['hide_prices'])
                  <div class="text-sm font-bold text-brand-teal">{{ $tp['final_price_formatted'] }}</div>
                @endif
              </a>
            @endforeach
          </div>
        @else
          <div class="grid grid-cols-2 gap-3">
            @php
              $iqFallback = [
                ['img' => '1441986300917-64674bd600d8', 'name' => 'Wireless Noise-Cancelling Headphones', 'price' => '$89.00', 'badge' => 'Best Value'],
                ['img' => '1523381210434-271e8be1f52b', 'name' => 'Everyday Cotton Sneakers', 'price' => '$54.00', 'badge' => 'Trending'],
                ['img' => '1583743814966-8936f5b7be1a', 'name' => 'Pantry Essentials Bundle', 'price' => '$21.00', 'badge' => 'Staff Pick'],
                ['img' => '1571781926291-c477ebfd024b', 'name' => 'Daily Hydration Skincare Set', 'price' => '$32.00', 'badge' => 'Best Value'],
              ];
              $iqBadgeColors = ['Best Value' => 'bg-brand-amber', 'Trending' => 'bg-brand-violet', 'Staff Pick' => 'bg-brand-teal'];
            @endphp
            @foreach($iqFallback as $fp)
              <div class="bg-white/95 rounded-xl p-2.5 shadow-cardHover flex flex-col gap-2">
                <div class="relative aspect-square rounded-lg overflow-hidden">
                  <img src="https://images.unsplash.com/photo-{{ $fp['img'] }}?auto=format&fit=crop&w=400&q=70" alt="{{ $fp['name'] }}" class="w-full h-full object-cover">
                  <span class="absolute top-1 left-1 {{ $iqBadgeColors[$fp['badge']] }} text-white text-[9px] font-bold uppercase px-1.5 py-0.5 rounded-full">{{ $fp['badge'] }}</span>
                </div>
                <div class="text-xs font-semibold text-brand-navy line-clamp-1">{{ $fp['name'] }}</div>
                <div class="text-sm font-bold text-brand-teal">{{ $fp['price'] }}</div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-xl overflow-hidden shadow-card hover:shadow-cardHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-xl overflow-hidden shadow-card hover:shadow-cardHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <div>
          <span class="eyebrow text-brand-teal text-xs font-bold">Browse smart</span>
          <h2 class="text-2xl font-black text-brand-navy mt-1">Shop by category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-brand-teal hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-3 rounded-xl bg-white border border-brand-line hover:border-brand-teal hover:shadow-card transition-all">
            <span class="w-11 h-11 rounded-full bg-brand-tealLight text-brand-tealDark flex items-center justify-center font-black text-lg group-hover:bg-brand-teal group-hover:text-white transition-colors">
              {{ strtoupper(substr($cat->name, 0, 1)) }}
            </span>
            <span class="text-xs font-semibold text-center text-brand-navy line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-white border-y border-brand-line">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Smart Price Match', 'sub' => 'We compare so you save'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto rounded-full bg-brand-tealLight text-brand-tealDark flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-brand-navy">{{ $item['title'] }}</div>
          <div class="text-xs text-slate-500">{{ $item['sub'] }}</div>
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Picks');
        $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      @endphp
      @if($productVms->count())
        <section class="max-w-7xl mx-auto px-4 py-8">
          <div class="flex items-end justify-between mb-5">
            <h2 class="text-2xl font-black text-brand-navy">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-brand-teal hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $iqI => $product)
              @include('store.themes.shopiq.partials.product-card', ['product' => $product, 'idx' => $iqI])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-3 gap-4">
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6 md:col-span-2">
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-brand-ink/80 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-amber text-xs font-bold uppercase">Fashion Edit</span>
        <h3 class="text-white text-xl font-black mt-1">New season styles, smart prices</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6">
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-brand-ink/80 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-teal text-xs font-bold uppercase">Tech Deals</span>
        <h3 class="text-white text-lg font-black mt-1">Compare audio &amp; wearables</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-brand-line">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-black text-brand-navy text-center mb-8">Shoppers who compare, save</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'The Best Value badges genuinely saved me money — I bought a laptop stand and a skincare set knowing both were priced right.'],
          ['name' => 'Daniel R.', 'quote' => 'I like that it feels analytical, not pushy. Running shoes, groceries and a phone case, all with clear comparisons.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and the trending panel actually reflects what people are buying. Returns were painless too.'],
        ] as $t)
          <div class="p-6 rounded-xl bg-brand-bg border border-brand-line">
            <div class="flex gap-0.5 text-brand-amber mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-slate-600">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-brand-navy">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-2xl bg-brand-navy p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center">
      <div class="lg:col-span-2">
        <h3 class="text-2xl font-black text-white">Get the smart-price alert</h3>
        <p class="text-slate-300 text-sm mt-2">Join our list and we'll flag the best-value drops across every category before anyone else does.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 rounded-lg border-0 text-sm">
        <button type="submit" class="h-12 px-6 rounded-lg bg-brand-teal text-white font-bold hover:bg-brand-tealDark">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-xl overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-xl overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.shopiq.partials.footer', ['categories' => $categories])
@include('store.themes.shopiq.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
