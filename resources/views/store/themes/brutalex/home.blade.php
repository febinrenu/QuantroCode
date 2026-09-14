<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.brutalex._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'BRUTALEX') . ' — No Fluff. Just The Goods.'])
</head>
<body class="bg-white text-ink-black antialiased">

@include('store.themes.brutalex.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO — raw split slab (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  @php $bxHeroSlides = $heroSlides ?? []; @endphp
  <section class="border-b-4 border-ink-black relative overflow-hidden grid"
           x-data="{ bxHero: 0, bxHeroCount: {{ count($bxHeroSlides) }} }"
           @if(count($bxHeroSlides) > 1) x-init="setInterval(() => { bxHero = (bxHero + 1) % bxHeroCount }, 6000)" @endif>
    @foreach($bxHeroSlides as $bxI => $bxSlide)
      <div x-show="bxHero === {{ $bxI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1 grid lg:grid-cols-[1.1fr_0.9fr] divide-y-4 lg:divide-y-0 lg:divide-x-4 divide-ink-black">
        <div class="px-6 py-14 lg:py-20 flex flex-col justify-center">
          <span class="inline-block w-fit eyebrow bg-ink-red text-white text-xs font-bold px-3 py-1 mb-5">General Merchandise. Zero Nonsense.</span>
          <h1 class="text-4xl sm:text-5xl lg:text-6xl leading-[0.95] text-ink-black">
            {{ ($bxSlide['title'] ?? '') !== '' ? $bxSlide['title'] : 'NO FLUFF. JUST THE GOODS.' }}
          </h1>
          <p class="bx-copy mt-6 text-base text-ink-black/80 max-w-lg leading-relaxed">
            {{ ($bxSlide['subtitle'] ?? '') !== '' ? $bxSlide['subtitle'] : 'Electronics, fashion, home, beauty, grocery, sports — stacked in one raw catalog with straight prices and zero marketing fluff. If it works, we stock it. If it doesn\'t, we don\'t.' }}
          </p>
          <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ ($bxSlide['cta_link'] ?? '') !== '' ? $bxSlide['cta_link'] : route('store.shop') }}" class="h-14 px-7 inline-flex items-center gap-2 bg-ink-black text-white font-bold uppercase tracking-wide border-4 border-ink-black bx-shadow-red bx-shadow-hover">
              {{ ($bxSlide['cta_text'] ?? '') !== '' ? $bxSlide['cta_text'] : 'Shop The Catalog' }}
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="square" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-14 px-7 inline-flex items-center gap-2 bg-white text-ink-black font-bold uppercase tracking-wide border-4 border-ink-black bx-shadow-sm bx-shadow-hover">
              Cheapest First
            </a>
          </div>
          <div class="mt-10 grid grid-cols-3 gap-0 border-4 border-ink-black divide-x-4 divide-ink-black w-fit font-mono">
            <div class="px-4 py-2 text-center"><div class="text-lg font-bold">6</div><div class="text-[10px] uppercase text-ink-black/60">Categories</div></div>
            <div class="px-4 py-2 text-center"><div class="text-lg font-bold">48H</div><div class="text-[10px] uppercase text-ink-black/60">Dispatch</div></div>
            <div class="px-4 py-2 text-center"><div class="text-lg font-bold">0%</div><div class="text-[10px] uppercase text-ink-black/60">B.S.</div></div>
          </div>
        </div>
        <div class="grid grid-cols-2 divide-x-4 divide-y-4 divide-ink-black">
          <div class="relative aspect-square overflow-hidden">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=700&q=70" class="w-full h-full object-cover" alt="Electronics">
            <span class="absolute bottom-2 left-2 bg-ink-black text-white text-[10px] font-bold uppercase px-2 py-1 border-2 border-white">Tech</span>
          </div>
          <div class="relative aspect-square overflow-hidden">
            <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=700&q=70" class="w-full h-full object-cover" alt="Fashion">
            <span class="absolute bottom-2 left-2 bg-ink-black text-white text-[10px] font-bold uppercase px-2 py-1 border-2 border-white">Fashion</span>
          </div>
          <div class="relative aspect-square overflow-hidden">
            <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=700&q=70" class="w-full h-full object-cover" alt="Home">
            <span class="absolute bottom-2 left-2 bg-ink-black text-white text-[10px] font-bold uppercase px-2 py-1 border-2 border-white">Home</span>
          </div>
          <div class="relative aspect-square overflow-hidden">
            <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=700&q=70" class="w-full h-full object-cover" alt="Beauty">
            <span class="absolute bottom-2 left-2 bg-ink-black text-white text-[10px] font-bold uppercase px-2 py-1 border-2 border-white">Beauty</span>
          </div>
        </div>
      </div>
    @endforeach

    @if(count($bxHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($bxHeroSlides as $bxI => $bxSlide)
          <button type="button" @click="bxHero = {{ $bxI }}" class="w-2 h-2 rounded-full transition-colors border border-ink-black" :class="bxHero === {{ $bxI }} ? 'bg-ink-black' : 'bg-ink-black/20'" aria-label="Slide {{ $bxI + 1 }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="border-b-4 border-ink-black grid md:grid-cols-2 divide-y-4 md:divide-y-0 md:divide-x-4 divide-ink-black">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif
  @endif

  {{-- ===== MANIFESTO STRIP ===== --}}
  <section class="bg-ink-black text-white border-b-4 border-ink-black">
    <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">
      <div>
        <span class="bx-head text-3xl text-ink-red">01</span>
        <h3 class="bx-head text-lg mt-2">ONE PRICE. NO GAMES.</h3>
        <p class="bx-copy text-sm text-white/60 mt-2">The price on the tag is the price at checkout. No fake countdowns, no manufactured urgency.</p>
      </div>
      <div>
        <span class="bx-head text-3xl text-ink-red">02</span>
        <h3 class="bx-head text-lg mt-2">EVERY CATEGORY. ONE CART.</h3>
        <p class="bx-copy text-sm text-white/60 mt-2">Headphones, hoodies, skillets, serums, cereal, dumbbells — checkout once, ship once.</p>
      </div>
      <div>
        <span class="bx-head text-3xl text-ink-red">03</span>
        <h3 class="bx-head text-lg mt-2">RETURNS THAT DON'T FIGHT YOU.</h3>
        <p class="bx-copy text-sm text-white/60 mt-2">30 days. No interrogation. Send it back if it doesn't work for you.</p>
      </div>
    </div>
  </section>

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="border-b-4 border-ink-black">
      <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex items-end justify-between mb-6">
          <h2 class="text-2xl text-ink-black">SHOP BY CATEGORY</h2>
          <a href="{{ route('store.shop') }}" class="text-sm font-mono font-bold text-ink-red hover:underline">VIEW ALL →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 border-4 border-ink-black divide-x-4 divide-y-4 sm:divide-y-0 divide-ink-black">
          @foreach($categories->take(8) as $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 bg-white hover:bg-ink-red transition-colors">
              <span class="w-11 h-11 border-2 border-ink-black bg-white text-ink-black group-hover:bg-ink-black group-hover:text-white flex items-center justify-center bx-head text-base transition-colors">
                <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
              </span>
              <span class="text-xs font-mono font-bold text-center text-ink-black group-hover:text-white line-clamp-2 uppercase transition-colors">{{ $cat->name }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== CONTENT BLOCKS (collections from homepage_lineup) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'FEATURED PICKS');
        $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      @endphp
      @if($productVms->count())
        <section class="border-b-4 border-ink-black">
          <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="flex items-end justify-between mb-6">
              <h2 class="text-2xl text-ink-black">{{ strtoupper($colTitle) }}</h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-mono font-bold text-ink-red hover:underline">VIEW ALL →</a>
              @endif
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
              @foreach($productVms as $product)
                @include('store.themes.brutalex.partials.product-card', ['product' => $product])
              @endforeach
            </div>
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO SLABS (tile 1 customizable via Banners: image, badge, headline, subtitle, button, colors) ===== --}}
  @php
    // A banner's own bg_color/bg_color_2/text_color (set in the Banners admin)
    // override this slab's fixed dark overlay/text color; absent -> theme default.
    $bannerOverlayStyle = function ($b) {
      if (!$b || empty($b->bg_color)) return null;
      $css = !empty($b->bg_color_2)
        ? "background:linear-gradient(to bottom, {$b->bg_color}99, {$b->bg_color_2}99);"
        : "background:{$b->bg_color}99;";
      return $css;
    };
    $bannerTextStyle = function ($b) {
      return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
    };
    $centerLeft = ($byPos['center_left'] ?? collect())->first();
  @endphp
  <section class="border-b-4 border-ink-black grid md:grid-cols-2 divide-y-4 md:divide-y-0 md:divide-x-4 divide-ink-black">
    <div class="relative overflow-hidden h-64 flex items-end p-6">
      <img src="{{ $centerLeft ? $bannerUrl($centerLeft) : 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70' }}" class="absolute inset-0 w-full h-full object-cover grayscale" alt="{{ $centerLeft->title ?? '' }}">
      <div class="absolute inset-0 bg-ink-black/60" @if($bannerOverlayStyle($centerLeft)) style="{{ $bannerOverlayStyle($centerLeft) }}" @endif></div>
      <div class="relative" @if($bannerTextStyle($centerLeft)) style="{{ $bannerTextStyle($centerLeft) }}" @endif>
        <span class="text-ink-red text-xs font-mono font-bold uppercase">{{ ($centerLeft->badge_text ?? null) ?: 'FASHION EDIT' }}</span>
        <h3 class="text-white text-2xl bx-head mt-1" @if($bannerTextStyle($centerLeft)) style="color:inherit;" @endif>{{ ($centerLeft->title ?? null) ?: 'GEAR THAT WORKS AS HARD AS YOU DO' }}</h3>
        @if(!empty($centerLeft->subtitle ?? null))
          <p class="text-white/80 text-sm mt-1 bx-copy" @if($bannerTextStyle($centerLeft)) style="color:inherit;" @endif>{{ $centerLeft->subtitle }}</p>
        @endif
        <a href="{{ $centerLeft ? ($centerLeft->link ?: route('store.shop')) : route('store.shop') }}" class="mt-3 inline-flex items-center gap-2 h-10 px-4 bg-ink-red text-white text-xs font-bold uppercase border-2 border-white">{{ ($centerLeft->button_text ?? null) ?: 'Shop Now' }} →</a>
      </div>
    </div>
    @if($offer['enabled'] ?? true)
    <div class="relative overflow-hidden h-64 flex items-end p-6">
      <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : 'https://images.unsplash.com/photo-1550928431-ee0ec6db30d3?auto=format&fit=crop&w=900&q=70' }}" class="absolute inset-0 w-full h-full object-cover grayscale" alt="">
      <div class="absolute inset-0 bg-ink-black/60"></div>
      <div class="relative">
        <span class="text-ink-red text-xs font-mono font-bold uppercase">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'TECH DUMP' }}</span>
        <h3 class="text-white text-2xl bx-head mt-1">{{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'UP TO 40% OFF AUDIO & WEARABLES' }}</h3>
        @if(!empty($offer['discount_text']))
          <span class="inline-flex mt-2 items-center rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-bold text-white uppercase">{{ $offer['discount_text'] }}</span>
        @endif
        <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : route('store.shop') }}" class="mt-3 inline-flex items-center gap-2 h-10 px-4 bg-white text-ink-black text-xs font-bold uppercase border-2 border-white">{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop Now →' }}</a>
      </div>
    </div>
    @endif
  </section>

  {{-- ===== TESTIMONIALS — raw transcript style ===== --}}
  <section class="border-b-4 border-ink-black bg-ink-fog">
    <div class="max-w-7xl mx-auto px-6 py-12">
      <h2 class="text-2xl text-ink-black text-center mb-8">WHAT PEOPLE SAY. UNEDITED.</h2>
      <div class="grid md:grid-cols-3 border-4 border-ink-black divide-y-4 md:divide-y-0 md:divide-x-4 divide-ink-black bg-white">
        @foreach([
          ['name' => 'AMARA K.', 'quote' => 'Ordered a laptop stand and a skincare set together. Both showed up in two days, no upsell emails, no drama.'],
          ['name' => 'DANIEL R.', 'quote' => 'The category spread is ridiculous. Running shoes, groceries, and a phone case, one cart, one checkout.'],
          ['name' => 'PRIYA S.', 'quote' => 'Prices are honest and the return was genuinely easy. No hoops, no chatbot maze, no fine print traps.'],
        ] as $t)
          <div class="p-6">
            <div class="flex gap-0.5 text-ink-red mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm bx-copy text-ink-black/80">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-mono font-bold text-ink-black">— {{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="border-b-4 border-ink-black">
    <div class="max-w-7xl mx-auto px-6 py-12">
      <div class="bg-ink-black border-4 border-ink-black p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center">
        <div class="lg:col-span-2">
          <h3 class="text-2xl text-white">GET THE GOOD STUFF FIRST</h3>
          <p class="text-white/60 text-sm mt-2 bx-copy">Join the list for restocks and price drops across every category. No spam, we don't have the patience for it.</p>
        </div>
        <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-3">
          @csrf
          <input type="email" required placeholder="you@example.com" class="flex-1 h-14 px-4 border-4 border-white bg-white text-sm font-mono focus:outline-none">
          <button type="submit" class="h-14 px-7 bg-ink-red text-white font-bold uppercase border-4 border-ink-red hover:bg-white hover:text-ink-black hover:border-white transition-colors">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="grid md:grid-cols-2 divide-y-4 md:divide-y-0 md:divide-x-4 divide-ink-black border-b-4 border-ink-black">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif
  @endif

</main>

@include('store.themes.brutalex.partials.footer', ['categories' => $categories])
@include('store.themes.brutalex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
