<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.marketverse._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'MarketVerse') . ' — Your World Of Shopping'])
</head>
<body class="bg-mv-cream text-mv-ink antialiased">

@include('store.themes.marketverse.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  $mvTicker = [
    'Wireless ANC Headphones', 'Ceramic Non-Stick Cookware Set', 'Organic Cold-Pressed Olive Oil',
    'Running Shoes — Trail Grip', 'Vitamin C Brightening Serum', '4K Smart Monitor 27"',
    'Linen Blend Blazer', 'Stainless Steel Yoga Mat Roller', 'Robot Vacuum with Mapping',
    'Cast Iron Dutch Oven', 'Bluetooth Fitness Tracker', 'Merino Wool Crew Socks 3-Pack',
    'Espresso Machine — 15 Bar', 'Retinol Night Repair Cream', 'Adjustable Dumbbell Set',
  ];
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-mv-ink">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1600&q=70"
           alt="" class="w-full h-full object-cover opacity-25">
      <div class="absolute inset-0 bg-gradient-to-r from-mv-inkDark via-mv-inkDark/92 to-mv-inkDark/50"></div>
    </div>
    <div class="relative max-w-[1600px] mx-auto px-4 py-14 lg:py-20 grid lg:grid-cols-2 gap-8 items-center">
      <div>
        <span class="eyebrow text-mv-accent text-xs font-bold mv-mono">MARKETPLACE.ALL_CATEGORIES</span>
        <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
          {{ $s->hero_title ?? 'Your world of shopping, in one cart.' }}
        </h1>
        <p class="mt-4 text-slate-300 max-w-lg">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and sports — thousands of listings from verified sellers, priced transparently and delivered fast.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-md bg-mv-accent text-white font-bold hover:bg-mv-accentDark transition-colors">
            Browse the grid
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-6 inline-flex items-center gap-2 rounded-md border-2 border-white/25 text-white font-bold hover:bg-white/10 transition-colors">
            Today's lowest prices
          </a>
        </div>
        <div class="mt-8 flex items-center gap-5 text-slate-300 text-xs flex-wrap">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-mv-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Verified seller network</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-mv-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Real-time stock data</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-mv-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection on every order</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-3 gap-3">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover shadow-tileHover" alt="Electronics">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover mt-6 shadow-tileHover" alt="Fashion">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover shadow-tileHover" alt="Beauty">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover -mt-4 shadow-tileHover" alt="Grocery">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover shadow-tileHover" alt="Home">
        <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=420&q=70" class="rounded-xl h-32 w-full object-cover mt-6 shadow-tileHover" alt="Sports">
      </div>
    </div>
  </section>

  {{-- ===== TRENDING NOW TICKER ===== --}}
  <section class="bg-mv-ink border-b-2 border-mv-accent overflow-hidden">
    <div class="flex items-center h-11">
      <span class="shrink-0 px-4 h-full inline-flex items-center bg-mv-accent text-white text-[11px] font-bold uppercase tracking-wider mv-mono z-10">🔥 Trending Now</span>
      <div class="relative flex-1 overflow-hidden no-scrollbar">
        <div class="flex items-center gap-6 whitespace-nowrap mv-ticker-track w-max">
          @for($r = 0; $r < 2; $r++)
            @foreach($mvTicker as $t)
              <span class="inline-flex items-center gap-2 text-xs text-slate-200 mv-mono">
                <span class="w-1 h-1 rounded-full bg-mv-accent"></span>{{ $t }}
              </span>
            @endforeach
          @endfor
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-[1600px] mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-lg overflow-hidden border border-mv-line shadow-tile hover:shadow-tileHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-lg overflow-hidden border border-mv-line shadow-tile hover:shadow-tileHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== MAIN: LEFT CATEGORY RAIL + CONTENT ===== --}}
  <div class="max-w-[1600px] mx-auto px-4 py-8 grid lg:grid-cols-[240px_1fr] gap-6">

    {{-- Persistent left category rail --}}
    <aside class="hidden lg:block">
      <div id="mv-rail-toggle-note" class="bg-white rounded-lg border-2 border-mv-line sticky top-24 overflow-hidden">
        <div class="bg-mv-ink text-white text-[11px] font-bold uppercase tracking-wider px-4 py-3 mv-mono">Browse Categories</div>
        <ul class="divide-y divide-mv-line max-h-[560px] overflow-y-auto">
          @forelse(($categories ?? collect()) as $cat)
            <li>
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="flex items-center justify-between gap-2 px-4 py-2.5 text-sm font-semibold text-mv-ink hover:bg-mv-accentSoft hover:text-mv-accentDark transition-colors">
                <span class="truncate">{{ $cat->name }}</span>
                <svg class="w-3.5 h-3.5 shrink-0 text-mv-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
              </a>
            </li>
          @empty
            <li class="px-4 py-3 text-sm text-mv-slate">No categories yet.</li>
          @endforelse
        </ul>
        <a href="{{ route('store.shop') }}" class="block text-center py-3 text-xs font-bold text-mv-accentDark border-t border-mv-line hover:bg-mv-accentSoft mv-mono">VIEW ALL PRODUCTS →</a>
      </div>
    </aside>

    <div class="min-w-0">
      {{-- ===== CATEGORY QUICK GRID ===== --}}
      @if(($categories ?? collect())->count())
        <section class="mb-10">
          <div class="flex items-end justify-between mb-4">
            <h2 class="text-xl font-black text-mv-ink">Shop by category</h2>
            <a href="{{ route('store.shop') }}" class="text-sm font-bold text-mv-accentDark hover:underline mv-mono">VIEW ALL →</a>
          </div>
          <div class="grid grid-cols-3 sm:grid-cols-4 xl:grid-cols-6 gap-2.5">
            @foreach($categories->take(12) as $cat)
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-3 rounded-lg bg-white border-2 border-mv-line hover:border-mv-accent hover:shadow-tile transition-all">
                <span class="w-10 h-10 rounded-md bg-mv-accentSoft text-mv-accentDark flex items-center justify-center font-black text-base group-hover:bg-mv-accent group-hover:text-white transition-colors">
                  {{ strtoupper(substr($cat->name, 0, 1)) }}
                </span>
                <span class="text-[11px] font-bold text-center text-mv-ink line-clamp-2 leading-tight">{{ $cat->name }}</span>
              </a>
            @endforeach
          </div>
        </section>
      @endif

      {{-- ===== TRUST STRIP ===== --}}
      <section class="mb-10 bg-white border-2 border-mv-line rounded-lg">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-5 text-center">
          @foreach([
            ['title' => 'Fast Dispatch', 'sub' => 'Most orders ship in 24h'],
            ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
            ['title' => 'Easy Returns', 'sub' => '30-day window'],
            ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
          ] as $item)
            <div>
              <div class="w-9 h-9 mx-auto rounded-md bg-mv-accentSoft text-mv-accentDark flex items-center justify-center mb-2">
                <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
              </div>
              <div class="text-sm font-bold text-mv-ink">{{ $item['title'] }}</div>
              <div class="text-xs text-mv-slate">{{ $item['sub'] }}</div>
            </div>
          @endforeach
        </div>
      </section>

      {{-- ===== CONTENT BLOCKS (collections from homepage_lineup) ===== --}}
      @foreach($blocks as $block)
        @if(($block['type'] ?? '') === 'collection')
          @php
            $mvProducts = collect($block['products'] ?? []);
            $mvCollection = $block['collection'] ?? null;
            $mvColTitle = $block['title'] ?? ($mvCollection->title ?? $mvCollection->name ?? 'Featured Picks');
            $mvProductVms = $mvProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
          @endphp
          @if($mvProductVms->count())
            <section class="mb-10">
              <div class="flex items-end justify-between mb-4">
                <h2 class="text-xl font-black text-mv-ink">{{ $mvColTitle }}</h2>
                @if($mvCollection && $mvCollection->slug)
                  <a href="{{ route('store.shop', ['collection' => $mvCollection->slug]) }}" class="text-sm font-bold text-mv-accentDark hover:underline mv-mono">VIEW ALL →</a>
                @endif
              </div>
              <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-3">
                @foreach($mvProductVms as $product)
                  @include('store.themes.marketverse.partials.product-card', ['product' => $product])
                @endforeach
              </div>
            </section>
          @endif
        @endif
      @endforeach

      {{-- ===== PROMO STRIP ===== --}}
      <section class="mb-10 grid md:grid-cols-2 gap-4">
        <div class="relative rounded-lg overflow-hidden h-48 flex items-end p-5 border-2 border-mv-line">
          <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
          <div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
          <div class="relative">
            <span class="text-mv-accent text-[11px] font-bold uppercase mv-mono">Fashion Edit</span>
            <h3 class="text-white text-lg font-black mt-1">New season styles across every size</h3>
            <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-white underline">Shop now →</a>
          </div>
        </div>
        <div class="relative rounded-lg overflow-hidden h-48 flex items-end p-5 border-2 border-mv-line">
          <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
          <div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
          <div class="relative">
            <span class="text-mv-accent text-[11px] font-bold uppercase mv-mono">Tech Deals</span>
            <h3 class="text-white text-lg font-black mt-1">Up to 40% off audio, wearables &amp; smart home</h3>
            <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-white underline">Shop now →</a>
          </div>
        </div>
      </section>

      {{-- ===== TESTIMONIALS ===== --}}
      <section class="mb-10 bg-white border-2 border-mv-line rounded-lg p-6">
        <h2 class="text-xl font-black text-mv-ink text-center mb-6">Trusted by shoppers across every category</h2>
        <div class="grid md:grid-cols-3 gap-4">
          @foreach([
            ['name' => 'Amara K.', 'quote' => 'I ordered a monitor, a set of dumbbells and a skincare kit in one checkout — every seller shipped on time. The stock counts on each card are refreshingly accurate.'],
            ['name' => 'Daniel R.', 'quote' => 'The category rail makes it fast to jump between departments. I found running shoes, a coffee maker and phone accessories in under five minutes.'],
            ['name' => 'Priya S.', 'quote' => 'Prices are listed with the SKU right on the card, which I appreciate as someone who compares specs before buying. Returns were genuinely painless too.'],
          ] as $t)
            <div class="p-4 rounded-lg bg-mv-cream border border-mv-line">
              <div class="flex gap-0.5 text-mv-accent mb-2">
                @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
              </div>
              <p class="text-sm text-mv-ink/80">"{{ $t['quote'] }}"</p>
              <div class="mt-3 text-sm font-bold text-mv-ink mv-mono">{{ $t['name'] }}</div>
            </div>
          @endforeach
        </div>
      </section>

      {{-- ===== NEWSLETTER ===== --}}
      <section class="mb-10">
        <div class="rounded-lg bg-mv-ink p-6 lg:p-8 grid lg:grid-cols-5 gap-6 items-center">
          <div class="lg:col-span-2">
            <h3 class="text-xl font-black text-white">Get restock alerts &amp; price drops first</h3>
            <p class="text-slate-300 text-sm mt-2">Join our list for early access to markdowns across every department — no spam, just data.</p>
          </div>
          <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
            @csrf
            <input type="email" required placeholder="you@example.com" class="flex-1 h-11 px-4 rounded-md border-0 text-sm">
            <button type="submit" class="h-11 px-6 rounded-md bg-mv-accent text-white font-bold hover:bg-mv-accentDark transition-colors">Subscribe</button>
          </form>
        </div>
      </section>

      {{-- ===== FOOTER BANNERS ===== --}}
      @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
        <section class="grid md:grid-cols-2 gap-4">
          @foreach($byPos['footer_left'] ?? collect() as $b)
            <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-lg overflow-hidden border border-mv-line shadow-tile"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
          @endforeach
          @foreach($byPos['footer_right'] ?? collect() as $b)
            <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-lg overflow-hidden border border-mv-line shadow-tile"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
          @endforeach
        </section>
      @endif
    </div>
  </div>

</main>

@include('store.themes.marketverse.partials.footer', ['categories' => $categories])
@include('store.themes.marketverse.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
