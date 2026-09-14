<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.voguelane._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Voguelane') . ' — Style Has No Single Lane'])
</head>
<body class="bg-white text-black antialiased">

@include('store.themes.voguelane.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $collectionBlocks = collect($blocks)->filter(fn($b) => ($b['type'] ?? '') === 'collection')->values();

  // A banner's own bg_color/bg_color_2/text_color (set in the Banners admin)
  // override each tile's fixed gradient/text color; absent -> theme default.
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
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== SPLIT-SCREEN DIAGONAL HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  @php $vgHeroSlides = $heroSlides ?? []; @endphp
  <section class="relative bg-black overflow-hidden lg:h-[640px] grid"
           x-data="{ vgHero: 0, vgHeroCount: {{ count($vgHeroSlides) }} }"
           @if(count($vgHeroSlides) > 1) x-init="setInterval(() => { vgHero = (vgHero + 1) % vgHeroCount }, 6000)" @endif>
    @foreach($vgHeroSlides as $vgI => $vgSlide)
      <div x-show="vgHero === {{ $vgI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1 flex flex-col lg:flex-row h-full">
        <div class="relative z-10 lg:w-[60%] bg-black px-6 py-16 lg:py-0 lg:pl-10 lg:pr-24 flex flex-col justify-center vl-clip-left">
          <span class="eyebrow text-brand-magenta text-xs font-bold">Every category. One bold lane.</span>
          <h1 class="font-display text-white leading-[0.9] mt-3 text-6xl sm:text-7xl lg:text-8xl">
            {{ ($vgSlide['title'] ?? '') !== '' ? $vgSlide['title'] : 'STYLE HAS NO SINGLE LANE' }}
          </h1>
          <p class="mt-5 text-white/60 max-w-md text-sm lg:text-base">
            {{ ($vgSlide['subtitle'] ?? '') !== '' ? $vgSlide['subtitle'] : 'Electronics, fashion, home, beauty, grocery and sports — curated with a point of view and dropped fast. This is general merchandise with an edit.' }}
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ ($vgSlide['cta_link'] ?? '') !== '' ? $vgSlide['cta_link'] : route('store.shop') }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 bg-brand-magenta text-white text-sm font-bold uppercase tracking-wide hover:bg-white hover:text-black transition-colors">
              {{ ($vgSlide['cta_text'] ?? '') !== '' ? $vgSlide['cta_text'] : 'Shop the edit' }}
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 border border-white/30 text-white text-sm font-bold uppercase tracking-wide hover:border-brand-magenta hover:text-brand-magenta transition-colors">
              Today's deals
            </a>
          </div>
          <div class="mt-10 flex items-center gap-6 text-white/50 text-[11px] uppercase tracking-widest">
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free returns</span>
          </div>
        </div>
        <div class="relative lg:w-[40%] h-72 lg:h-full -mt-1 lg:mt-0 lg:-ml-24">
          <img src="{{ !empty($vgSlide['image_url']) ? $vgSlide['image_url'] : 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1000&q=70' }}" alt="" class="w-full h-full object-cover">
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent lg:hidden"></div>
        </div>
      </div>
    @endforeach

    @if(count($vgHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($vgHeroSlides as $vgI => $vgSlide)
          <button type="button" @click="vgHero = {{ $vgI }}" class="w-2 h-2 rounded-full transition-colors" :class="vgHero === {{ $vgI }} ? 'bg-white' : 'bg-white/40'" aria-label="Slide {{ $vgI + 1 }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  {{-- ===== TOP BANNERS (fully customizable via Banners: image, badge, headline, subtitle, button, colors) ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="px-4 lg:px-8 py-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="relative block overflow-hidden border border-black/10 hover:border-brand-magenta transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
          @if($bannerOverlayStyle($b))
            <div class="absolute inset-0 pointer-events-none" style="{{ $bannerOverlayStyle($b) }}"></div>
          @endif
          @if(!empty($b->badge_text) || !empty($b->title) || !empty($b->subtitle) || !empty($b->button_text))
            <div class="absolute inset-0 p-6 flex flex-col justify-end" @if($bannerTextStyle($b)) style="{{ $bannerTextStyle($b) }}" @endif>
              @if(!empty($b->badge_text))
                <span class="eyebrow text-brand-magenta text-xs font-bold" style="color:inherit;">{{ $b->badge_text }}</span>
              @endif
              @if(!empty($b->title))
                <h3 class="font-display text-white text-2xl mt-1" style="color:inherit;">{{ $b->title }}</h3>
              @endif
              @if(!empty($b->subtitle))
                <p class="text-white/70 text-sm mt-1" style="color:inherit;">{{ $b->subtitle }}</p>
              @endif
              @if(!empty($b->button_text))
                <span class="mt-2 inline-flex text-sm font-bold uppercase tracking-wide text-white underline" style="color:inherit;">{{ $b->button_text }} →</span>
              @endif
            </div>
          @endif
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="relative block overflow-hidden border border-black/10 hover:border-brand-magenta transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
          @if($bannerOverlayStyle($b))
            <div class="absolute inset-0 pointer-events-none" style="{{ $bannerOverlayStyle($b) }}"></div>
          @endif
          @if(!empty($b->badge_text) || !empty($b->title) || !empty($b->subtitle) || !empty($b->button_text))
            <div class="absolute inset-0 p-6 flex flex-col justify-end" @if($bannerTextStyle($b)) style="{{ $bannerTextStyle($b) }}" @endif>
              @if(!empty($b->badge_text))
                <span class="eyebrow text-brand-magenta text-xs font-bold" style="color:inherit;">{{ $b->badge_text }}</span>
              @endif
              @if(!empty($b->title))
                <h3 class="font-display text-white text-2xl mt-1" style="color:inherit;">{{ $b->title }}</h3>
              @endif
              @if(!empty($b->subtitle))
                <p class="text-white/70 text-sm mt-1" style="color:inherit;">{{ $b->subtitle }}</p>
              @endif
              @if(!empty($b->button_text))
                <span class="mt-2 inline-flex text-sm font-bold uppercase tracking-wide text-white underline" style="color:inherit;">{{ $b->button_text }} →</span>
              @endif
            </div>
          @endif
        </a>
      @endforeach
    </section>
  @endif
  @endif

  {{-- ===== ASYMMETRIC CATEGORY MASONRY ===== --}}
  @if(($categories ?? collect())->count())
    <section class="px-4 lg:px-8 py-14">
      <div class="flex items-end justify-between mb-6">
        <h2 class="font-display text-4xl lg:text-5xl">SHOP THE LANES</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold uppercase tracking-widest text-brand-magenta hover:underline">View all →</a>
      </div>
      @php $catImgs = ['1441984904996-e0b6ba687e04','1441986300917-64674bd600d8','1517336714731-489689fd1ca8','1483985988355-763728e1935b','1583743814966-8936f5b7be1a','1472851294608-062f824d29cc']; @endphp
      <div class="grid grid-cols-6 grid-rows-2 gap-3 h-[560px] lg:h-[440px]">
        @foreach($categories->take(6) as $i => $cat)
          @php
            $spanClasses = [
              0 => 'col-span-6 lg:col-span-3 row-span-2',
              1 => 'col-span-3 lg:col-span-2 row-span-1',
              2 => 'col-span-3 lg:col-span-1 row-span-1',
              3 => 'col-span-3 lg:col-span-1 row-span-1',
              4 => 'col-span-3 lg:col-span-1 row-span-1',
              5 => 'col-span-6 lg:col-span-1 row-span-1',
            ][$i] ?? 'col-span-3 row-span-1';
          @endphp
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group relative overflow-hidden bg-black {{ $spanClasses }}">
            <img src="https://images.unsplash.com/photo-{{ $catImgs[$i % count($catImgs)] }}?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:opacity-90 group-hover:scale-105 transition-all duration-300" alt="">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/10 to-transparent"></div>
            <span class="absolute bottom-3 left-3 font-display text-white text-xl lg:text-2xl leading-none">{{ strtoupper($cat->name) }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-black text-white">
    <div class="px-4 lg:px-8 py-7 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day window'],
        ['title' => '24/7 Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-9 h-9 mx-auto rounded-full border border-brand-magenta text-brand-magenta flex items-center justify-center mb-2">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-xs font-bold uppercase tracking-wide">{{ $item['title'] }}</div>
          <div class="text-[11px] text-white/40">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== FEATURED + GRID COLLECTION BLOCKS ===== --}}
  @foreach($collectionBlocks as $bIdx => $block)
    @php
      $products = collect($block['products'] ?? []);
      $collection = $block['collection'] ?? null;
      $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Picks');
      $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      $featured = $productVms->first();
      $rest = $productVms->slice(1);
    @endphp
    @if($productVms->count())
      <section class="px-4 lg:px-8 py-14 {{ $bIdx % 2 === 1 ? 'bg-brand-paper' : '' }}">
        <div class="flex items-end justify-between mb-6">
          <h2 class="font-display text-4xl lg:text-5xl">{{ strtoupper($colTitle) }}</h2>
          @if($collection && $collection->slug)
            <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-xs font-bold uppercase tracking-widest text-brand-magenta hover:underline">View all →</a>
          @endif
        </div>
        <div class="grid lg:grid-cols-3 gap-5">
          @if($featured)
            <div class="lg:col-span-1 lg:row-span-2">
              @include('store.themes.voguelane.partials.product-card', ['product' => $featured])
            </div>
          @endif
          <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-5">
            @foreach($rest as $product)
              @include('store.themes.voguelane.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </div>
      </section>
    @endif
  @endforeach

  {{-- ===== PROMO — OVERLAPPING TYPOGRAPHY (customizable via Offers & Promotions) ===== --}}
  @if($offer['enabled'] ?? true)
  <section class="px-4 lg:px-8 py-16 grid lg:grid-cols-2 gap-10 items-center">
    <div class="relative">
      <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?auto=format&fit=crop&w=900&q=70' }}" class="w-full h-72 lg:h-96 object-cover" alt="">
      <h3 class="font-display text-black leading-[0.85] text-6xl lg:text-8xl absolute -bottom-6 -left-2 lg:-left-6">
        NEW<br>DROPS
      </h3>
    </div>
    <div class="lg:pl-10">
      <span class="eyebrow text-brand-magenta text-xs font-bold">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'Fashion Edit' }}</span>
      <h3 class="font-display text-4xl lg:text-5xl mt-2">{{ ($offer['title'] ?? '') !== '' ? $offer['title'] : "SEASON'S BOLDEST LOOKS" }}</h3>
      <p class="text-black/60 text-sm mt-4 max-w-md">{{ ($offer['subtitle'] ?? '') !== '' ? $offer['subtitle'] : 'From statement outerwear to everyday essentials — plus the tech, home and beauty pieces that round out the look. New arrivals land every week.' }}</p>
      @if(!empty($offer['discount_text']))
        <span class="inline-flex mt-3 items-center border border-brand-magenta px-3 py-1 text-xs font-bold uppercase tracking-wide text-brand-magenta">{{ $offer['discount_text'] }}</span>
      @endif
      <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : route('store.shop') }}" class="mt-6 inline-flex items-center gap-2 h-12 px-6 bg-black text-white text-sm font-bold uppercase tracking-wide hover:bg-brand-magenta transition-colors">
        {{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop now' }}
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
      </a>
    </div>
  </section>
  @endif

  {{-- ===== TESTIMONIALS — HORIZONTAL SCROLL STRIP ===== --}}
  <section class="bg-black text-white py-14 overflow-hidden">
    <div class="px-4 lg:px-8 mb-6">
      <h2 class="font-display text-4xl lg:text-5xl">LOVED ACROSS EVERY LANE</h2>
    </div>
    <div class="vl-scroll-strip flex gap-4 overflow-x-auto no-scrollbar px-4 lg:px-8 pb-2">
      @foreach([
        ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. This is my go-to now.'],
        ['name' => 'Daniel R.', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart.'],
        ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. No hoops to jump through.'],
        ['name' => 'Jonas T.', 'quote' => 'The vibe of this store hits different — bold, confident, and the products back it up.'],
      ] as $t)
        <div class="shrink-0 w-80 p-6 border border-white/10 hover:border-brand-magenta transition-colors">
          <div class="flex gap-0.5 text-brand-magenta mb-3">
            @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
          </div>
          <p class="text-sm text-white/70">"{{ $t['quote'] }}"</p>
          <div class="mt-4 text-sm font-bold uppercase tracking-wide">{{ $t['name'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="px-4 lg:px-8 py-16">
    <div class="bg-black p-8 lg:p-14 grid lg:grid-cols-5 gap-8 items-center border-2 border-brand-magenta">
      <div class="lg:col-span-2">
        <h3 class="font-display text-white text-4xl leading-none">GET IN THE LANE FIRST</h3>
        <p class="text-white/50 text-sm mt-3">Early access to drops and deals across every category, straight to your inbox.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-13 py-3.5 px-4 bg-white/10 border border-white/20 text-white placeholder-white/40 text-sm focus:outline-none focus:border-brand-magenta">
        <button type="submit" class="h-13 py-3.5 px-7 bg-brand-magenta text-white font-bold uppercase tracking-wide hover:bg-white hover:text-black transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS (fully customizable via Banners: image, badge, headline, subtitle, button, colors) ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="px-4 lg:px-8 pb-14 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="relative block overflow-hidden border border-black/10">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
          @if($bannerOverlayStyle($b))
            <div class="absolute inset-0 pointer-events-none" style="{{ $bannerOverlayStyle($b) }}"></div>
          @endif
          @if(!empty($b->badge_text) || !empty($b->title) || !empty($b->subtitle) || !empty($b->button_text))
            <div class="absolute inset-0 p-6 flex flex-col justify-end" @if($bannerTextStyle($b)) style="{{ $bannerTextStyle($b) }}" @endif>
              @if(!empty($b->badge_text))
                <span class="eyebrow text-brand-magenta text-xs font-bold" style="color:inherit;">{{ $b->badge_text }}</span>
              @endif
              @if(!empty($b->title))
                <h3 class="font-display text-white text-2xl mt-1" style="color:inherit;">{{ $b->title }}</h3>
              @endif
              @if(!empty($b->subtitle))
                <p class="text-white/70 text-sm mt-1" style="color:inherit;">{{ $b->subtitle }}</p>
              @endif
              @if(!empty($b->button_text))
                <span class="mt-2 inline-flex text-sm font-bold uppercase tracking-wide text-white underline" style="color:inherit;">{{ $b->button_text }} →</span>
              @endif
            </div>
          @endif
        </a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="relative block overflow-hidden border border-black/10">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
          @if($bannerOverlayStyle($b))
            <div class="absolute inset-0 pointer-events-none" style="{{ $bannerOverlayStyle($b) }}"></div>
          @endif
          @if(!empty($b->badge_text) || !empty($b->title) || !empty($b->subtitle) || !empty($b->button_text))
            <div class="absolute inset-0 p-6 flex flex-col justify-end" @if($bannerTextStyle($b)) style="{{ $bannerTextStyle($b) }}" @endif>
              @if(!empty($b->badge_text))
                <span class="eyebrow text-brand-magenta text-xs font-bold" style="color:inherit;">{{ $b->badge_text }}</span>
              @endif
              @if(!empty($b->title))
                <h3 class="font-display text-white text-2xl mt-1" style="color:inherit;">{{ $b->title }}</h3>
              @endif
              @if(!empty($b->subtitle))
                <p class="text-white/70 text-sm mt-1" style="color:inherit;">{{ $b->subtitle }}</p>
              @endif
              @if(!empty($b->button_text))
                <span class="mt-2 inline-flex text-sm font-bold uppercase tracking-wide text-white underline" style="color:inherit;">{{ $b->button_text }} →</span>
              @endif
            </div>
          @endif
        </a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.voguelane.partials.footer', ['categories' => $categories])
@include('store.themes.voguelane.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
