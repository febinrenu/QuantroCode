<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.monochra._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Monochra') . ' — Nothing But The Essentials'])
</head>
<body class="bg-brand-white text-brand-black antialiased">

@include('store.themes.monochra.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-brand-black border-b-2 border-brand-black">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1600&q=70"
           alt="" class="mc-photo w-full h-full object-cover opacity-40">
      <div class="absolute inset-0 bg-gradient-to-r from-brand-black via-brand-black/85 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-28 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="eyebrow text-brand-red text-xs font-bold">One store. No distractions.</span>
        <h1 class="mt-3 font-display text-4xl sm:text-5xl lg:text-6xl text-brand-white leading-[0.95] uppercase">
          {{ $s->hero_title ?? 'Nothing but the essentials' }}
        </h1>
        <p class="mt-4 text-white/70 max-w-lg">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery, sports. No clutter, no gimmicks — just the products people actually buy, at prices that make sense.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 bg-brand-red text-brand-white font-bold uppercase hover:bg-brand-redDark transition-colors">
            Shop Now
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-6 inline-flex items-center gap-2 border-2 border-white/40 text-brand-white font-bold uppercase hover:border-brand-white transition-colors">
            Today's Deals
          </a>
        </div>
        <div class="mt-8 flex items-center gap-6 text-white/70 text-xs uppercase font-semibold">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer Protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free Returns</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-3">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=70" class="mc-photo h-48 w-full object-cover border-2 border-white/20" alt="">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="mc-photo h-48 w-full object-cover border-2 border-white/20" alt="">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="mc-photo h-48 w-full object-cover border-2 border-white/20" alt="">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70" class="mc-photo h-48 w-full object-cover border-2 border-white/20" alt="">
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border-2 border-brand-black overflow-hidden">
          <img src="{{ $bannerUrl($b) }}" class="mc-photo w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border-2 border-brand-black overflow-hidden">
          <img src="{{ $bannerUrl($b) }}" class="mc-photo w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-display text-2xl text-brand-black uppercase">Shop By Category</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold uppercase text-brand-red hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-3 border-2 border-brand-black hover:bg-brand-black transition-colors">
            <span class="w-11 h-11 border-2 border-brand-black bg-brand-white text-brand-black group-hover:bg-brand-white flex items-center justify-center font-display text-lg">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-bold uppercase text-center text-brand-black group-hover:text-brand-white line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-brand-white border-y-2 border-brand-black">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto border-2 border-brand-black text-brand-black flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold uppercase text-brand-black">{{ $item['title'] }}</div>
          <div class="text-xs text-brand-gray">{{ $item['sub'] }}</div>
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
            <h2 class="font-display text-2xl text-brand-black uppercase">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-bold uppercase text-brand-red hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.monochra.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative overflow-hidden h-56 flex items-end p-6 border-2 border-brand-black">
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="mc-photo absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-red text-xs font-bold uppercase">Fashion Edit</span>
        <h3 class="text-brand-white font-display text-xl mt-1 uppercase">New Season Styles</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-brand-white underline uppercase">Shop now →</a>
      </div>
    </div>
    <div class="relative overflow-hidden h-56 flex items-end p-6 border-2 border-brand-black">
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="mc-photo absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-red text-xs font-bold uppercase">Tech Deals</span>
        <h3 class="text-brand-white font-display text-xl mt-1 uppercase">Up To 40% Off Audio</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-bold text-brand-white underline uppercase">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-brand-white border-y-2 border-brand-black">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="font-display text-2xl text-brand-black text-center mb-8 uppercase">Trusted By Shoppers Who Want Less Noise</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. No fuss, no upsells.'],
          ['name' => 'Daniel R.', 'quote' => 'The range is wide but the site never feels cluttered. I bought shoes, groceries and a phone case in one cart.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are stated plainly and returns were genuinely easy. Exactly what it says on the tin.'],
        ] as $t)
          <div class="p-6 border-2 border-brand-black">
            <div class="flex gap-0.5 mc-star mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-brand-black">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold uppercase text-brand-black">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="bg-brand-black p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center border-2 border-brand-black">
      <div class="lg:col-span-2">
        <h3 class="font-display text-2xl text-brand-white uppercase">Get Deals. Skip The Noise.</h3>
        <p class="text-white/60 text-sm mt-2">One email a week. Real discounts, every category, no spam.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 border-2 border-brand-white bg-brand-white text-sm text-brand-black">
        <button type="submit" class="h-12 px-6 bg-brand-red text-brand-white font-bold uppercase hover:bg-brand-redDark">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border-2 border-brand-black"><img src="{{ $bannerUrl($b) }}" class="mc-photo w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border-2 border-brand-black"><img src="{{ $bannerUrl($b) }}" class="mc-photo w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.monochra.partials.footer', ['categories' => $categories])
@include('store.themes.monochra.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
