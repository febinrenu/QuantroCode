<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.novatech._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'NovaTech') . ' — Tomorrow\'s Essentials, Today'])
</head>
<body class="bg-nova-bg text-slate-100 antialiased bg-nova-radial bg-no-repeat">

@include('store.themes.novatech.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  // Bento tile layout config: size classes cycle across the first N categories.
  $bentoSizes = [
    'col-span-2 row-span-2', // 0: large featured
    'col-span-2 row-span-1', // 1: wide
    'col-span-2 row-span-1', // 2: wide
    'col-span-1 row-span-1', // 3: small
    'col-span-1 row-span-1', // 4: small
    'col-span-1 row-span-1', // 5: small
    'col-span-1 row-span-1', // 6: small
  ];
  $bentoImages = [
    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=900&q=70',
    'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=900&q=70',
    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=900&q=70',
    'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70',
    'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70',
    'https://images.unsplash.com/photo-1519744792095-2f2205e87b6f?auto=format&fit=crop&w=500&q=70',
    'https://images.unsplash.com/photo-1524592094714-0f0654e20314?auto=format&fit=crop&w=500&q=70',
  ];
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1550928431-ee0ec6db30d3?auto=format&fit=crop&w=1600&q=70"
           alt="" class="w-full h-full object-cover opacity-40">
      <div class="absolute inset-0 bg-gradient-to-r from-nova-bg via-nova-bg/85 to-nova-bg/50"></div>
      <div class="absolute inset-0 bg-nova-radial"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-28 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="eyebrow text-nova-violetLight text-xs font-bold inline-flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-nova-cyan animate-pulse"></span>
          Every category. One premium store.
        </span>
        <h1 class="mt-3 text-3xl sm:text-4xl lg:text-6xl font-black text-white leading-[1.05]">
          Tomorrow's <span class="nt-gradient-text">essentials</span>,<br class="hidden sm:block"> today.
        </h1>
        <p class="mt-4 text-slate-300 max-w-lg">
          {{ $s->hero_subtitle ?? 'From next-gen electronics to everyday fashion, home, beauty, grocery and sports — NovaTech curates it all with fast delivery and a checkout you can trust.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-full bg-nova-violet text-white font-semibold hover:bg-nova-violetDark shadow-glow transition-colors">
            Shop the catalog
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-full nt-glass text-white font-semibold hover:bg-white/10 transition-colors">
            Today's deals
          </a>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-slate-300 text-xs">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4">
        <div class="nt-glass rounded-2xl h-48 overflow-hidden shadow-glass">
          <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=500&q=70" class="w-full h-full object-cover" alt="Electronics">
        </div>
        <div class="nt-glass rounded-2xl h-48 overflow-hidden mt-8 shadow-glass">
          <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=500&q=70" class="w-full h-full object-cover" alt="Fashion">
        </div>
        <div class="nt-glass rounded-2xl h-48 overflow-hidden -mt-4 shadow-glass">
          <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=500&q=70" class="w-full h-full object-cover" alt="Grocery">
        </div>
        <div class="nt-glass rounded-2xl h-48 overflow-hidden shadow-glass">
          <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=500&q=70" class="w-full h-full object-cover" alt="Beauty">
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden nt-glass hover:shadow-glow transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden nt-glass hover:shadow-glow transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY BENTO GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10">
      <div class="flex items-end justify-between mb-5">
        <div>
          <span class="eyebrow text-nova-violetLight text-xs font-bold">Explore</span>
          <h2 class="text-2xl lg:text-3xl font-black text-white mt-1">Shop by category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-nova-violetLight hover:text-white">View all →</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-4 auto-rows-[140px] gap-4">
        @foreach($categories->take(7) as $i => $cat)
          @php
            $size = $bentoSizes[$i] ?? 'col-span-1 row-span-1';
            $img = $bentoImages[$i] ?? $bentoImages[$i % count($bentoImages)];
            $isLarge = $i === 0;
          @endphp
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}"
             class="group relative {{ $size }} rounded-2xl overflow-hidden nt-glass hover:shadow-glowLg hover:border-nova-violet/50 transition-all">
            <img src="{{ $img }}" alt="{{ $cat->name }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-65 group-hover:scale-105 transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-nova-bgDeep/90 via-nova-bgDeep/20 to-transparent"></div>
            <div class="relative h-full flex flex-col justify-end p-4">
              @if($isLarge)
                <span class="eyebrow text-nova-cyan text-[10px] font-bold mb-1">Featured</span>
                <span class="text-white font-black text-xl lg:text-2xl leading-tight">{{ $cat->name }}</span>
                <span class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-nova-violetLight">
                  Shop now
                  <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </span>
              @else
                <span class="text-white font-bold text-sm lg:text-base leading-tight line-clamp-2">{{ $cat->name }}</span>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="border-y border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div class="nt-glass rounded-2xl p-5">
          <div class="w-10 h-10 mx-auto rounded-full bg-nova-violet/20 text-nova-violetLight flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-white">{{ $item['title'] }}</div>
          <div class="text-xs text-slate-400">{{ $item['sub'] }}</div>
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
            <h2 class="text-2xl font-black text-white">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-nova-violetLight hover:text-white">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.novatech.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6 nt-glass">
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover opacity-70" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-nova-bgDeep/90 to-transparent"></div>
      <div class="relative">
        <span class="text-nova-cyan text-xs font-bold uppercase eyebrow">Fashion Edit</span>
        <h3 class="text-white text-xl font-black mt-1">New season styles</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6 nt-glass">
      <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover opacity-70" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-nova-bgDeep/90 to-transparent"></div>
      <div class="relative">
        <span class="text-nova-violetLight text-xs font-bold uppercase eyebrow">Tech Deals</span>
        <h3 class="text-white text-xl font-black mt-1">Up to 40% off audio &amp; wearables</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="border-y border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <div class="text-center mb-8">
        <span class="eyebrow text-nova-violetLight text-xs font-bold">Reviews</span>
        <h2 class="text-2xl lg:text-3xl font-black text-white mt-1">Loved by shoppers everywhere</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a pair of wireless earbuds and a skincare set together — both arrived in two days, beautifully packaged. This is my go-to now.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart, and the site felt genuinely premium the whole time.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. No hoops to jump through, and the dark theme is just gorgeous on the eyes at night.'],
        ] as $t)
          <div class="p-6 rounded-2xl nt-glass">
            <div class="flex gap-0.5 text-nova-amber mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-slate-300">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-white">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-2xl nt-glass-strong p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center shadow-glowLg">
      <div class="lg:col-span-2">
        <h3 class="text-2xl font-black text-white">Get deals before anyone else</h3>
        <p class="text-slate-300 text-sm mt-2">Join our list for early access to sales across every category — electronics, fashion, home, beauty, grocery and sports.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 rounded-full nt-glass text-sm text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-nova-violet/50">
        <button type="submit" class="h-12 px-6 rounded-full bg-nova-violet text-white font-bold hover:bg-nova-violetDark shadow-glow transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden nt-glass"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden nt-glass"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.novatech.partials.footer', ['categories' => $categories])
@include('store.themes.novatech.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
