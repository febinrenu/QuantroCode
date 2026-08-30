<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.retropop._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Retropop') . ' — Shop Like It\'s The Best Decade Ever'])
</head>
<body class="bg-pop-cream text-pop-ink antialiased">

@include('store.themes.retropop.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $collectionBlocks = collect($blocks)->filter(fn($b) => ($b['type'] ?? '') === 'collection')->values();
@endphp

<main class="pb-24 lg:pb-0 overflow-x-hidden">

  {{-- ===== HERO — teal band with sunburst ===== --}}
  <section class="relative overflow-hidden bg-pop-teal">
    <svg class="absolute -top-20 -right-20 w-[520px] h-[520px] text-pop-tealDark/40 opacity-60" viewBox="0 0 200 200">
      <g fill="currentColor">
        @for($i=0;$i<16;$i++)
          <rect x="97" y="0" width="6" height="90" rx="3" transform="rotate({{ $i*22.5 }} 100 100)"/>
        @endfor
      </g>
    </svg>
    <svg class="absolute top-10 left-4 w-24 h-24 text-pop-mustard/50" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="eyebrow inline-flex items-center gap-2 bg-pop-mustard text-pop-ink text-xs font-extrabold px-4 py-1.5 rounded-full">🕺 One store, every category, all the vibes</span>
        <h1 class="mt-5 text-4xl sm:text-5xl lg:text-6xl font-heading font-extrabold text-white leading-[1.05]">
          {{ $s->hero_title ?? 'Shop like it\'s the best decade ever' }}
        </h1>
        <p class="mt-5 text-pop-cream/90 max-w-lg text-base leading-relaxed">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and sports — thousands of far-out finds, funky fast shipping, and prices that keep the good times rolling.' }}
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-14 px-8 inline-flex items-center gap-2 rounded-full bg-pop-orange text-white font-heading font-bold text-lg shadow-pop hover:shadow-popHover hover:-translate-y-0.5 active:translate-y-0 active:shadow-none transition-all">
            Shop the catalog
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-14 px-8 inline-flex items-center gap-2 rounded-full border-2 border-white/60 text-white font-heading font-bold text-lg hover:bg-white/10 transition-colors">
            Today's deals
          </a>
        </div>
        <div class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-2 text-pop-cream/90 text-xs font-semibold">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pop-mustard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pop-mustard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pop-mustard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4 relative z-10">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=500&q=70" class="rounded-groovy h-48 w-full object-cover border-4 border-pop-mustard shadow-pop" alt="">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="rounded-groovy h-48 w-full object-cover mt-8 border-4 border-pop-mustard shadow-pop" alt="">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="rounded-groovy h-48 w-full object-cover -mt-4 border-4 border-pop-mustard shadow-pop" alt="">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70" class="rounded-groovy h-48 w-full object-cover border-4 border-pop-mustard shadow-pop" alt="">
      </div>
    </div>
    <svg class="rp-wave" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#FFF8EC"/></svg>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-groovy overflow-hidden border-2 border-pop-ink/10 shadow-card hover:shadow-popHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-groovy overflow-hidden border-2 border-pop-ink/10 shadow-card hover:shadow-popHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== TRUST STRIP — mustard band ===== --}}
  <section class="bg-pop-mustard">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99', 'path' => 'M3 3h15v13H3zM16 8h4l2 4v4h-6z'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout', 'path' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z'],
        ['title' => 'Easy Returns', 'sub' => '30-day window', 'path' => 'M21 12a9 9 0 1 1-6-8.485'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always', 'path' => 'M3 11a9 9 0 0 1 18 0v6a2 2 0 0 1-2 2h-2v-8h4M3 11v8h4v-8H3'],
      ] as $item)
        <div>
          <div class="w-12 h-12 mx-auto rounded-full bg-pop-ink text-pop-mustard flex items-center justify-center mb-2.5 shadow-pop">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="{{ $item['path'] }}"/></svg>
          </div>
          <div class="text-sm font-heading font-bold text-pop-ink">{{ $item['title'] }}</div>
          <div class="text-xs text-pop-ink/70 font-medium">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
    <svg class="rp-wave" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C150,0 350,60 600,30 C850,0 1050,60 1200,30 L1200,60 L0,60 Z" fill="#FFF8EC"/></svg>
  </section>

  {{-- ===== CATEGORY GRID — cream band ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10">
      <div class="flex items-end justify-between mb-6">
        <div>
          <span class="eyebrow text-pop-teal text-xs font-extrabold">Browse the groove</span>
          <h2 class="text-3xl font-heading font-extrabold text-pop-ink mt-1">Shop by category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold text-pop-orange hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2.5 p-4 rounded-groovy bg-white border-2 border-pop-ink/10 hover:border-pop-orange hover:shadow-card transition-all">
            <span class="w-12 h-12 rounded-full bg-pop-teal/15 text-pop-teal flex items-center justify-center font-heading font-extrabold text-lg group-hover:bg-pop-orange group-hover:text-white transition-colors">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-bold text-center text-pop-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== DAY-GLOW PROMO BAND #1 — orange ===== --}}
  <section class="relative bg-pop-orange overflow-hidden">
    <svg class="absolute -bottom-16 -left-16 w-72 h-72 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 relative">
      <div class="text-center sm:text-left">
        <span class="text-white/80 text-xs font-extrabold uppercase tracking-widest">Weekend Flashback</span>
        <h3 class="text-2xl lg:text-3xl font-heading font-extrabold text-white mt-1">Up to 40% off — this weekend only, cats and kittens</h3>
      </div>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="shrink-0 h-12 px-7 inline-flex items-center rounded-full bg-white text-pop-orangeDark font-heading font-bold hover:-translate-y-0.5 transition-transform shadow-pop">Grab the deal →</a>
    </div>
  </section>

  {{-- ===== CONTENT BLOCKS (collections from homepage_lineup) — alternating bands ===== --}}
  @foreach($collectionBlocks as $bi => $block)
    @php
      $products = collect($block['products'] ?? []);
      $collection = $block['collection'] ?? null;
      $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Picks');
      $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      $bandClasses = $bi % 2 === 0 ? 'bg-pop-cream' : 'bg-white';
    @endphp
    @if($productVms->count())
      <section class="{{ $bandClasses }} py-10">
        <div class="max-w-7xl mx-auto px-4">
          <div class="flex items-end justify-between mb-6">
            <div>
              <span class="eyebrow text-pop-teal text-xs font-extrabold">Curated for you</span>
              <h2 class="text-3xl font-heading font-extrabold text-pop-ink mt-1">{{ $colTitle }}</h2>
            </div>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-bold text-pop-orange hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.retropop.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </div>
      </section>

      @if($bi === 0 && $collectionBlocks->count() > 1)
        {{-- ===== DAY-GLOW PROMO BAND #2 — teal ===== --}}
        <section class="relative bg-pop-teal overflow-hidden">
          <svg class="absolute -top-10 right-10 w-56 h-56 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 relative">
            <div class="text-center sm:text-left">
              <span class="text-white/80 text-xs font-extrabold uppercase tracking-widest">Free Shipping Alert</span>
              <h3 class="text-2xl lg:text-3xl font-heading font-extrabold text-white mt-1">Spend $99, ship for free — no strings, no jive</h3>
            </div>
            <a href="{{ route('store.shop') }}" class="shrink-0 h-12 px-7 inline-flex items-center rounded-full bg-pop-mustard text-pop-ink font-heading font-bold hover:-translate-y-0.5 transition-transform shadow-pop">Start shopping →</a>
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP — white band ===== --}}
  <section class="bg-white py-10">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-end justify-between mb-6">
        <span class="eyebrow text-pop-teal text-xs font-extrabold">Spotlight</span>
      </div>
      <div class="grid md:grid-cols-2 gap-5">
        <div class="relative rounded-groovy overflow-hidden h-64 flex items-end p-7 border-4 border-pop-mustard">
          <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
          <div class="absolute inset-0 bg-gradient-to-t from-pop-ink/85 via-pop-ink/20 to-transparent"></div>
          <div class="relative">
            <span class="inline-block bg-pop-orange text-white text-xs font-extrabold uppercase px-3 py-1 rounded-full">Fashion Edit</span>
            <h3 class="text-white text-2xl font-heading font-extrabold mt-2">New season, new swagger</h3>
            <a href="{{ route('store.shop') }}" class="mt-3 inline-flex h-10 px-5 items-center rounded-full bg-white text-pop-ink text-sm font-bold">Shop now →</a>
          </div>
        </div>
        <div class="relative rounded-groovy overflow-hidden h-64 flex items-end p-7 border-4 border-pop-teal">
          <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
          <div class="absolute inset-0 bg-gradient-to-t from-pop-ink/85 via-pop-ink/20 to-transparent"></div>
          <div class="relative">
            <span class="inline-block bg-pop-teal text-white text-xs font-extrabold uppercase px-3 py-1 rounded-full">Tech Deals</span>
            <h3 class="text-white text-2xl font-heading font-extrabold mt-2">Up to 40% off audio &amp; wearables</h3>
            <a href="{{ route('store.shop') }}" class="mt-3 inline-flex h-10 px-5 items-center rounded-full bg-white text-pop-ink text-sm font-bold">Shop now →</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS — mustard band ===== --}}
  <section class="relative bg-pop-mustard overflow-hidden">
    <svg class="absolute -top-16 -left-16 w-72 h-72 text-white/20" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    <div class="max-w-7xl mx-auto px-4 py-14 relative">
      <h2 class="text-3xl font-heading font-extrabold text-pop-ink text-center mb-9">Loved by shoppers everywhere, groovy or not</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. This place is my go-to now, no cap.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart and it all just worked.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. No hoops to jump through, just good vibes and fast delivery.'],
        ] as $t)
          <div class="p-6 rounded-groovy bg-white border-2 border-pop-ink/10 shadow-card">
            <div class="flex gap-0.5 text-pop-orange mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-pop-ink/80 leading-relaxed">"{{ $t['quote'] }}"</p>
            <div class="mt-4 text-sm font-heading font-bold text-pop-ink">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
    <svg class="rp-wave" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#FFF8EC"/></svg>
  </section>

  {{-- ===== DAY-GLOW PROMO BAND #3 — plum ===== --}}
  <section class="relative bg-pop-plum overflow-hidden">
    <svg class="absolute -bottom-10 right-0 w-64 h-64 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 relative">
      <div class="text-center sm:text-left">
        <span class="text-white/80 text-xs font-extrabold uppercase tracking-widest">Members-Only Groove</span>
        <h3 class="text-2xl lg:text-3xl font-heading font-extrabold text-white mt-1">Sign in for early access to the next flash sale</h3>
      </div>
      <a href="{{ url('/online_store/login') }}" class="shrink-0 h-12 px-7 inline-flex items-center rounded-full bg-pop-mustard text-pop-ink font-heading font-bold hover:-translate-y-0.5 transition-transform shadow-pop">Sign in →</a>
    </div>
  </section>

  {{-- ===== NEWSLETTER — teal band ===== --}}
  <section class="bg-pop-teal py-14">
    <div class="max-w-7xl mx-auto px-4">
      <div class="rounded-groovy bg-pop-ink p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center border-4 border-pop-mustard relative overflow-hidden">
        <svg class="absolute -top-10 -right-10 w-48 h-48 text-white/5" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
        <div class="lg:col-span-2 relative">
          <h3 class="text-2xl lg:text-3xl font-heading font-extrabold text-white">Get deals before anyone else, baby</h3>
          <p class="text-pop-cream/70 text-sm mt-2">Join the mailing list for early access to sales across every category — no spam, just good vibes.</p>
        </div>
        <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-3 relative">
          @csrf
          <input type="email" required placeholder="you@example.com" class="flex-1 h-14 px-5 rounded-full border-0 text-sm focus:outline-none focus:ring-2 focus:ring-pop-mustard">
          <button type="submit" class="h-14 px-8 rounded-full bg-pop-orange text-white font-heading font-bold hover:brightness-95 shadow-pop">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-groovy overflow-hidden border-2 border-pop-ink/10 shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-groovy overflow-hidden border-2 border-pop-ink/10 shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.retropop.partials.footer', ['categories' => $categories])
@include('store.themes.retropop.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
