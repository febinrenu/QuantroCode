<!doctype html>
<html lang="en">
<head>
@include('store.themes.zanova._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Zanova') . ' — Shop the Future'])
</head>
<body class="bg-zn-bg text-slate-100 antialiased">

@include('store.themes.zanova.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-zn-bg zn-noise-grid">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1550928431-ee0ec6db30d3?auto=format&fit=crop&w=1600&q=70"
           alt="" class="w-full h-full object-cover opacity-25">
      <div class="absolute inset-0 bg-gradient-to-b from-zn-bg via-zn-bg/85 to-zn-bg"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-zn-bg via-transparent to-zn-bg/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-20 lg:py-28 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="eyebrow text-zn-cyan text-xs font-bold">Every category, one neon marketplace</span>
        <h1 class="mt-3 text-4xl sm:text-5xl lg:text-6xl font-black leading-tight text-gradient font-heading">
          {{ $s->hero_title ?? 'Shop the future.' }}
        </h1>
        <p class="mt-4 text-slate-300 max-w-lg text-base">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and sports — thousands of curated products delivered fast, wrapped in a shopping experience that actually feels exciting.' }}
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="btn-glass h-12 px-6 inline-flex items-center gap-2 rounded-lg text-white font-semibold">
            Enter the marketplace
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="btn-outline-glow h-12 px-6 inline-flex items-center gap-2 rounded-lg text-slate-100 font-semibold">
            Today's deals
          </a>
        </div>
        <div class="mt-9 flex flex-wrap items-center gap-6 text-slate-400 text-xs">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-zn-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-zn-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-zn-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4">
        <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover shadow-glow border border-violet-500/20" alt="">
        <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover mt-8 shadow-glow border border-violet-500/20" alt="">
        <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover -mt-4 shadow-glow border border-violet-500/20" alt="">
        <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover shadow-glow border border-violet-500/20" alt="">
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="glow-card block rounded-xl overflow-hidden border border-violet-500/20">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="glow-card block rounded-xl overflow-hidden border border-violet-500/20">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <h2 class="text-2xl font-black font-heading text-gradient">Shop by category</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-zn-cyan hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="glow-card group flex flex-col items-center gap-2 p-3 rounded-xl bg-zn-surface border border-violet-500/20 transition-all">
            <span class="w-11 h-11 rounded-full bg-gradient-to-br from-zn-violet to-zn-cyan text-white flex items-center justify-center font-black text-lg font-heading">
              {{ strtoupper(substr($cat->name, 0, 1)) }}
            </span>
            <span class="text-xs font-semibold text-center text-slate-200 line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-zn-surface border-y border-violet-500/20">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99', 'icon' => '<path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/>'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout', 'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>'],
        ['title' => 'Easy Returns', 'sub' => '30-day window', 'icon' => '<path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/>'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always', 'icon' => '<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto rounded-full bg-white/5 text-zn-cyan flex items-center justify-center mb-2 border border-violet-500/20">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $item['icon'] !!}</svg>
          </div>
          <div class="text-sm font-bold text-slate-100">{{ $item['title'] }}</div>
          <div class="text-xs text-zn-mist">{{ $item['sub'] }}</div>
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
            <h2 class="text-2xl font-black font-heading text-gradient">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-zn-cyan hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.zanova.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="glow-card relative rounded-2xl overflow-hidden h-56 flex items-end p-6 border border-violet-500/20">
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-zn-bg via-zn-bg/60 to-transparent"></div>
      <div class="relative">
        <span class="text-zn-cyan text-xs font-bold uppercase">Fashion Edit</span>
        <h3 class="text-white text-xl font-black mt-1 font-heading">New season styles</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline decoration-zn-cyan">Shop now →</a>
      </div>
    </div>
    <div class="glow-card relative rounded-2xl overflow-hidden h-56 flex items-end p-6 border border-violet-500/20">
      <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-zn-bg via-zn-bg/60 to-transparent"></div>
      <div class="relative">
        <span class="text-zn-pink text-xs font-bold uppercase">Tech Deals</span>
        <h3 class="text-white text-xl font-black mt-1 font-heading">Up to 40% off audio &amp; wearables</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline decoration-zn-pink">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== SECOND PROMO ROW (home/grocery/sports mix) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-4 grid md:grid-cols-3 gap-4">
    <div class="glow-card relative rounded-2xl overflow-hidden h-40 flex items-end p-4 border border-violet-500/20">
      <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-zn-bg via-zn-bg/50 to-transparent"></div>
      <div class="relative">
        <span class="text-zn-cyan text-[11px] font-bold uppercase">Home &amp; Living</span>
        <h3 class="text-white text-sm font-black font-heading">Refresh your space</h3>
      </div>
    </div>
    <div class="glow-card relative rounded-2xl overflow-hidden h-40 flex items-end p-4 border border-violet-500/20">
      <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-zn-bg via-zn-bg/50 to-transparent"></div>
      <div class="relative">
        <span class="text-zn-cyan text-[11px] font-bold uppercase">Grocery</span>
        <h3 class="text-white text-sm font-black font-heading">Fresh essentials, daily</h3>
      </div>
    </div>
    <div class="glow-card relative rounded-2xl overflow-hidden h-40 flex items-end p-4 border border-violet-500/20">
      <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-zn-bg via-zn-bg/50 to-transparent"></div>
      <div class="relative">
        <span class="text-zn-cyan text-[11px] font-bold uppercase">Sports</span>
        <h3 class="text-white text-sm font-black font-heading">Gear up for the season</h3>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-zn-surface border-y border-violet-500/20">
    <div class="max-w-7xl mx-auto px-4 py-14">
      <h2 class="text-2xl font-black font-heading text-gradient text-center mb-9">Loved by shoppers everywhere</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. The whole site feels like it belongs in the future.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart, and the checkout was effortless.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. The neon design is a nice touch too — shopping here doesn\'t feel boring.'],
        ] as $t)
          <div class="glow-card p-6 rounded-xl bg-zn-surface2 border border-violet-500/20">
            <div class="flex gap-0.5 text-zn-cyan mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-slate-300">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-slate-100">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="relative rounded-2xl bg-zn-surface border border-violet-500/25 p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center overflow-hidden shadow-glowLg">
      <div class="absolute inset-0 bg-gradient-to-br from-zn-violet/10 via-transparent to-zn-cyan/10 pointer-events-none"></div>
      <div class="relative lg:col-span-2">
        <h3 class="text-2xl font-black font-heading text-gradient">Get deals before anyone else</h3>
        <p class="text-slate-300 text-sm mt-2">Join our list for early access to sales across every category — no spam, just neon-worthy discounts.</p>
      </div>
      <form action="#" method="post" class="relative lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 rounded-lg border border-violet-500/20 bg-zn-bg text-slate-100 placeholder-zn-mist text-sm focus:outline-none focus:ring-2 focus:ring-zn-cyan/50">
        <button type="submit" class="btn-glass h-12 px-6 rounded-lg text-white font-bold">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="glow-card block rounded-xl overflow-hidden border border-violet-500/20"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="glow-card block rounded-xl overflow-hidden border border-violet-500/20"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.zanova.partials.footer', ['categories' => $categories])
@include('store.themes.zanova.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
