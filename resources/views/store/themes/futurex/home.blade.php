<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.futurex._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'FutureX') . ' — The Store From Tomorrow'])
</head>
<body class="bg-fx-bg text-fx-ink antialiased">

@include('store.themes.futurex.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $tickerItems = ['ELECTRONICS', 'FASHION', 'HOME & LIVING', 'BEAUTY', 'GROCERY', 'SPORTS', 'UP TO 40% OFF', 'NEW DROPS DAILY', 'FREE SHIPPING $99+'];
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  @php $fxHeroSlides = $heroSlides ?? []; @endphp
  <section class="relative overflow-hidden fx-grid-bg"
           x-data="{ fxHero: 0, fxHeroCount: {{ count($fxHeroSlides) }} }"
           @if(count($fxHeroSlides) > 1) x-init="setInterval(() => { fxHero = (fxHero + 1) % fxHeroCount }, 6000)" @endif>
    <div class="absolute inset-0 bg-gradient-to-b from-fx-bg via-fx-bg/95 to-fx-bg"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-fx-violet/20 blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-fx-cyan/20 blur-3xl"></div>
    <div class="relative grid">
    @foreach($fxHeroSlides as $fxI => $fxSlide)
      <div x-show="fxHero === {{ $fxI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1">
        <div class="relative max-w-7xl mx-auto px-4 pt-14 lg:pt-20 grid lg:grid-cols-2 gap-10 items-center">
          <div>
            <span class="eyebrow text-fx-cyan text-xs font-bold">One store · Every category · Zero limits</span>
            <h1 class="mt-3 text-4xl sm:text-5xl lg:text-6xl font-black font-heading leading-[1.05] fx-grad-text">
              {{ ($fxSlide['title'] ?? '') !== '' ? $fxSlide['title'] : 'The store from tomorrow.' }}
            </h1>
            <p class="mt-5 text-fx-mute max-w-lg text-base">
              {{ ($fxSlide['subtitle'] ?? '') !== '' ? $fxSlide['subtitle'] : 'Electronics, fashion, home, beauty, grocery and sports — engineered into one seamless drop. Fast shipping, honest prices, always in stock.' }}
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
              <a href="{{ ($fxSlide['cta_link'] ?? '') !== '' ? $fxSlide['cta_link'] : route('store.shop') }}" class="fx-glow-btn h-12 px-7 inline-flex items-center gap-2 rounded-full fx-grad-btn text-[#0A0E1A] font-bold">
                {{ ($fxSlide['cta_text'] ?? '') !== '' ? $fxSlide['cta_text'] : 'Enter the catalog' }}
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
              </a>
              <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-7 inline-flex items-center gap-2 rounded-full border border-fx-border text-fx-ink font-semibold hover:border-fx-cyan/60 hover:text-fx-cyan transition-colors">
                Today's deals
              </a>
            </div>
            <div class="mt-8 flex items-center gap-6 text-fx-mute text-xs">
              <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
              <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
              <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> 24/7 support</span>
            </div>
          </div>
          <div class="hidden lg:grid grid-cols-2 gap-4">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover shadow-glow" alt="">
            <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover mt-8 shadow-glowCyan" alt="">
            <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover -mt-4 shadow-glowCyan" alt="">
            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=500&q=70" class="rounded-2xl h-48 w-full object-cover shadow-glow" alt="">
          </div>
        </div>
      </div>
    @endforeach

    @if(count($fxHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($fxHeroSlides as $fxI => $fxSlide)
          <button type="button" @click="fxHero = {{ $fxI }}" class="w-2 h-2 rounded-full transition-colors" :class="fxHero === {{ $fxI }} ? 'bg-white' : 'bg-white/40'" aria-label="Slide {{ $fxI + 1 }}"></button>
        @endforeach
      </div>
    @endif
    </div>

    {{-- ===== MARQUEE TICKER ===== --}}
    <div class="relative mt-12 border-y border-fx-border bg-[#0A0E1A]/80 overflow-hidden py-3">
      <div class="fx-marquee-track">
        @for($r = 0; $r < 2; $r++)
          @foreach($tickerItems as $item)
            <span class="flex items-center gap-3 px-6 shrink-0 text-sm font-heading font-bold uppercase tracking-widest text-fx-mute">
              {{ $item }}
              <svg class="w-3.5 h-3.5 text-fx-violet" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="5"/></svg>
            </span>
          @endforeach
        @endfor
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden border border-fx-border hover:border-fx-violet/60 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden border border-fx-border hover:border-fx-violet/60 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <h2 class="text-2xl lg:text-3xl font-black font-heading fx-grad-text">Shop by category</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-fx-cyan hover:underline">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-3 rounded-2xl bg-fx-panel border border-fx-border hover:border-fx-cyan/60 hover:shadow-glowCyan transition-all">
            <span class="w-11 h-11 rounded-full fx-grad-btn text-[#0A0E1A] flex items-center justify-center font-black text-lg">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-semibold text-center text-fx-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="border-y border-fx-border bg-fx-panel/40">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto rounded-full bg-fx-panel2 border border-fx-cyan/40 text-fx-cyan flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-fx-ink">{{ $item['title'] }}</div>
          <div class="text-xs text-fx-mute">{{ $item['sub'] }}</div>
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
            <h2 class="text-2xl lg:text-3xl font-black font-heading fx-grad-text">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-fx-cyan hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.futurex.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP (Tile 1 customizable via Banners; Tile 2 via Offers & Promotions) ===== --}}
  @if($offer['enabled'] ?? true)
  @php
    // A banner's own bg_color/bg_color_2/text_color (set in the Banners admin)
    // override this tile's fixed gradient/text color; absent -> theme default.
    $bannerOverlayStyle = function ($b) {
      if (!$b || empty($b->bg_color)) return null;
      $css = !empty($b->bg_color_2)
        ? "background:linear-gradient(to top, {$b->bg_color}e6, {$b->bg_color_2}80, transparent);"
        : "background:linear-gradient(to top, {$b->bg_color}e6, {$b->bg_color}80, transparent);";
      return $css;
    };
    $bannerTextStyle = function ($b) {
      return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
    };
    $centerLeft = ($byPos['center_left'] ?? collect())->first();
  @endphp
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6 border border-fx-border">
      @if($centerLeft)
        <img src="{{ $bannerUrl($centerLeft) }}" class="absolute inset-0 w-full h-full object-cover" alt="{{ $centerLeft->title }}">
      @else
        <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      @endif
      <div class="absolute inset-0 bg-gradient-to-t from-fx-bg via-fx-bg/50 to-transparent" @if($bannerOverlayStyle($centerLeft)) style="{{ $bannerOverlayStyle($centerLeft) }}" @endif></div>
      <div class="relative" @if($bannerTextStyle($centerLeft)) style="{{ $bannerTextStyle($centerLeft) }}" @endif>
        <span class="text-fx-pink text-xs font-bold uppercase tracking-widest" style="color:inherit;">{{ ($centerLeft->badge_text ?? null) ?: 'Fashion Edit' }}</span>
        <h3 class="text-white text-xl font-black font-heading mt-1" style="color:inherit;">{{ ($centerLeft->title ?? null) ?: 'New season styles' }}</h3>
        @if(!empty($centerLeft->subtitle ?? null))
          <p class="text-white/80 text-xs mt-1" style="color:inherit;">{{ $centerLeft->subtitle }}</p>
        @endif
        <a href="{{ $centerLeft ? ($centerLeft->link ?: route('store.shop')) : route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-fx-cyan underline" style="color:inherit;">{{ ($centerLeft->button_text ?? null) ?: 'Shop now' }} →</a>
      </div>
    </div>
    <div class="relative rounded-2xl overflow-hidden h-56 flex items-end p-6 border border-fx-border">
      <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : 'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70' }}" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-fx-bg via-fx-bg/50 to-transparent"></div>
      <div class="relative">
        <span class="text-fx-cyan text-xs font-bold uppercase tracking-widest">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'Tech Deals' }}</span>
        <h3 class="text-white text-xl font-black font-heading mt-1">{{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'Up to 40% off audio & wearables' }}</h3>
        @if(!empty($offer['discount_text']))
          <span class="mt-1 inline-flex text-xs font-bold text-white/80">{{ $offer['discount_text'] }}</span>
        @endif
        <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-fx-cyan underline">{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop now →' }}</a>
      </div>
    </div>
  </section>
  @endif

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="border-y border-fx-border bg-fx-panel/40">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="text-2xl lg:text-3xl font-black font-heading fx-grad-text text-center mb-8">Loved by shoppers everywhere</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. This is my go-to now.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. No hoops to jump through.'],
        ] as $t)
          <div class="p-6 rounded-2xl bg-fx-panel border border-fx-border">
            <div class="flex gap-0.5 text-fx-cyan mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-fx-mute">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-fx-ink">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="rounded-2xl bg-fx-panel border border-fx-border p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center relative overflow-hidden">
      <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-fx-violet/20 blur-3xl"></div>
      <div class="lg:col-span-2 relative">
        <h3 class="text-2xl font-black font-heading fx-grad-text">Get deals before anyone else</h3>
        <p class="text-fx-mute text-sm mt-2">Join our list for early access to sales across every category.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2 relative">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 rounded-full border border-fx-border bg-fx-panel2 text-sm text-fx-ink placeholder-fx-mute focus:outline-none focus:ring-2 focus:ring-fx-violet/50">
        <button type="submit" class="fx-glow-btn h-12 px-6 rounded-full fx-grad-btn text-[#0A0E1A] font-bold">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden border border-fx-border"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-2xl overflow-hidden border border-fx-border"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif
  @endif

</main>

@include('store.themes.futurex.partials.footer', ['categories' => $categories])
@include('store.themes.futurex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
