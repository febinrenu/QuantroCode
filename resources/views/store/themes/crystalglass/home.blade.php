<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.crystalglass._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'CrystalGlass') . ' — Shopping, Reimagined'])
</head>
<body class="text-brand-ink antialiased">
<div class="cg-mesh"><div class="cg-blob cg-blob-1"></div><div class="cg-blob cg-blob-2"></div><div class="cg-blob cg-blob-3"></div></div>

@include('store.themes.crystalglass.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0 relative z-10">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
      <div class="glass-strong rounded-[2.5rem] shadow-glassHover p-8 lg:p-10">
        <span class="eyebrow text-brand-violetDark text-xs font-bold">Shopping, reimagined</span>
        <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-black text-brand-ink leading-tight tracking-tight">
          {{ $s->hero_title ?? 'Everything you love, in one beautifully clear place' }}
        </h1>
        <p class="mt-4 text-brand-ink/60 max-w-lg tracking-wide">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and sports — curated together, presented clearly, delivered fast.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white font-semibold tracking-wide hover:brightness-105 transition">
            Shop the catalog
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-7 inline-flex items-center gap-2 rounded-full border border-brand-ink/15 text-brand-ink font-semibold tracking-wide hover:bg-white/50 transition">
            Today's deals
          </a>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-4 text-brand-ink/60 text-xs tracking-wide">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-violetDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-violetDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-violetDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4">
        <div class="glass rounded-3xl overflow-hidden shadow-glass"><img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=500&q=70" class="h-48 w-full object-cover" alt=""></div>
        <div class="glass rounded-3xl overflow-hidden shadow-glass mt-8"><img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=500&q=70" class="h-48 w-full object-cover" alt=""></div>
        <div class="glass rounded-3xl overflow-hidden shadow-glass -mt-4"><img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=500&q=70" class="h-48 w-full object-cover" alt=""></div>
        <div class="glass rounded-3xl overflow-hidden shadow-glass"><img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=500&q=70" class="h-48 w-full object-cover" alt=""></div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block glass rounded-3xl overflow-hidden shadow-glass hover:shadow-glassHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block glass rounded-3xl overflow-hidden shadow-glass hover:shadow-glassHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <h2 class="text-2xl font-black text-brand-ink tracking-tight">Shop by category</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold tracking-wide text-brand-violetDark hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 rounded-3xl glass hover:shadow-glassHover transition-all">
            <span class="w-11 h-11 rounded-full bg-gradient-to-br from-brand-blue via-brand-violet to-brand-pink text-white flex items-center justify-center font-black text-lg">
              {{ strtoupper(substr($cat->name, 0, 1)) }}
            </span>
            <span class="text-xs font-semibold text-center text-brand-ink tracking-wide line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP (glass pills) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="glass rounded-full flex flex-wrap items-center justify-center gap-2 px-4 py-3 shadow-glass">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'Orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/50">
          <svg class="w-4 h-4 text-brand-violetDark shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          <span class="text-xs font-bold text-brand-ink tracking-wide">{{ $item['title'] }}</span>
          <span class="text-xs text-brand-ink/50 hidden sm:inline">· {{ $item['sub'] }}</span>
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
            <h2 class="text-2xl font-black text-brand-ink tracking-tight">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold tracking-wide text-brand-violetDark hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.crystalglass.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative rounded-3xl overflow-hidden h-56">
      <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
      <div class="absolute bottom-4 left-4 right-4 glass-strong rounded-2xl p-4">
        <span class="text-brand-violetDark text-xs font-bold uppercase tracking-widest">Fashion Edit</span>
        <h3 class="text-brand-ink text-xl font-black mt-1 tracking-tight">New season styles, curated</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-brand-violetDark underline tracking-wide">Shop now →</a>
      </div>
    </div>
    <div class="relative rounded-3xl overflow-hidden h-56">
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
      <div class="absolute bottom-4 left-4 right-4 glass-strong rounded-2xl p-4">
        <span class="text-brand-violetDark text-xs font-bold uppercase tracking-widest">Tech Deals</span>
        <h3 class="text-brand-ink text-xl font-black mt-1 tracking-tight">Up to 40% off audio &amp; wearables</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-brand-violetDark underline tracking-wide">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <h2 class="text-2xl font-black text-brand-ink text-center mb-8 tracking-tight">Loved by shoppers everywhere</h2>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach([
        ['name' => 'Amara K.', 'quote' => 'The glass cards make browsing feel effortless — I bought a laptop stand and a skincare set together in minutes.'],
        ['name' => 'Daniel R.', 'quote' => 'Every category lives in one clean cart — running shoes, groceries and a phone case, no friction at all.'],
        ['name' => 'Priya S.', 'quote' => 'It genuinely feels like shopping got a software update. Fast, clear, and the design just works.'],
      ] as $t)
        <div class="p-6 rounded-3xl glass shadow-glass">
          <div class="flex gap-0.5 text-brand-pink mb-3">
            @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
          </div>
          <p class="text-sm text-brand-ink/70 tracking-wide">"{{ $t['quote'] }}"</p>
          <div class="mt-3 text-sm font-bold text-brand-ink tracking-wide">{{ $t['name'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-[2.5rem] glass-dark p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center shadow-glassHover">
      <div class="lg:col-span-2">
        <h3 class="text-2xl font-black text-white tracking-tight">Get deals before anyone else</h3>
        <p class="text-white/60 text-sm mt-2 tracking-wide">Join our list for early access to sales across every category.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-5 rounded-full border-0 text-sm bg-white/90 tracking-wide">
        <button type="submit" class="h-12 px-7 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white font-bold tracking-wide hover:brightness-105 transition">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block glass rounded-3xl overflow-hidden shadow-glass"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block glass rounded-3xl overflow-hidden shadow-glass"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.crystalglass.partials.footer', ['categories' => $categories])
@include('store.themes.crystalglass.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
