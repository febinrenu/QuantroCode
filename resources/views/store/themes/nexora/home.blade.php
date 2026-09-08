<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.nexora._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Nexora') . ' — The future of shopping, unlocked'])
</head>
<body class="bg-nx-bg text-nx-ink antialiased">

@include('store.themes.nexora.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-28 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden nx-chrome">
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full nx-holo-bg opacity-30 blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full nx-holo-bg opacity-20 blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 nx-pill nx-sticker text-xs font-bold text-nx-ink">✨ One store, every category</span>
        <h1 class="mt-4 text-4xl sm:text-5xl lg:text-6xl font-black leading-tight nx-holo-text">
          {{ $s->hero_title ?? 'The future of shopping, unlocked.' }}
        </h1>
        <p class="mt-4 text-nx-mute max-w-lg text-lg">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and more — thousands of trusted products wrapped in chrome, shipped fast, priced fair.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="nx-shine h-14 px-8 inline-flex items-center gap-2 nx-pill nx-holo-bg text-white font-bold text-base shadow-cardHover">
            Shop the catalog
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="nx-shine h-14 px-8 inline-flex items-center gap-2 nx-pill nx-chrome border border-nx-chrome1 text-nx-ink font-bold text-base shadow-card">
            Today's deals
          </a>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-nx-mute text-xs font-semibold">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nx-pink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-nx-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover shadow-cardHover border-4 border-white" alt="">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover mt-8 shadow-cardHover border-4 border-white" alt="">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover -mt-4 shadow-cardHover border-4 border-white" alt="">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover shadow-cardHover border-4 border-white" alt="">
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-card hover:shadow-cardHover transition-shadow border border-nx-chrome1">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-card hover:shadow-cardHover transition-shadow border border-nx-chrome1">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <h2 class="text-2xl font-black nx-holo-text">Shop by category</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold text-nx-pink hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 rounded-3xl bg-white border border-nx-chrome1 hover:shadow-cardHover transition-all">
            <span class="w-12 h-12 rounded-full nx-holo-bg text-white flex items-center justify-center font-black text-lg shadow-card group-hover:scale-110 transition-transform">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-bold text-center text-nx-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-white border-y border-nx-chrome1">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-11 h-11 mx-auto rounded-full nx-sticker flex items-center justify-center mb-2">
            <svg class="w-5 h-5 text-nx-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-nx-ink">{{ $item['title'] }}</div>
          <div class="text-xs text-nx-mute">{{ $item['sub'] }}</div>
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
            <h2 class="text-2xl font-black nx-holo-text">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-bold text-nx-pink hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.nexora.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative rounded-3xl overflow-hidden h-56 flex items-end p-6 border border-nx-chrome1">
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
      <div class="relative">
        <span class="text-nx-cyan text-xs font-black uppercase">Fashion Edit</span>
        <h3 class="text-white text-xl font-black mt-1">New season styles just dropped</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-white underline">Shop now →</a>
      </div>
    </div>
    <div class="relative rounded-3xl overflow-hidden h-56 flex items-end p-6 border border-nx-chrome1">
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
      <div class="relative">
        <span class="text-nx-pink text-xs font-black uppercase">Tech Deals</span>
        <h3 class="text-white text-xl font-black mt-1">Up to 40% off audio &amp; wearables</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-white underline">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-nx-chrome1">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-black nx-holo-text text-center mb-8">Loved by shoppers everywhere</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. This is my go-to now.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. Total 2000s-web nostalgia in the best way.'],
        ] as $t)
          <div class="p-6 rounded-3xl nx-chrome border border-nx-chrome1">
            <div class="flex gap-0.5 text-nx-pink mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-nx-mute">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-black text-nx-ink">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-3xl nx-holo-bg p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center shadow-cardHover">
      <div class="lg:col-span-2">
        <h3 class="text-2xl font-black text-white">Get deals before anyone else</h3>
        <p class="text-white/85 text-sm mt-2">Join our list for early access to sales across every category.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-5 nx-pill border-0 text-sm">
        <button type="submit" class="nx-shine h-12 px-8 nx-pill nx-chrome text-nx-ink font-black shadow-card">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-card border border-nx-chrome1"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-card border border-nx-chrome1"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.nexora.partials.footer', ['categories' => $categories])
@include('store.themes.nexora.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
