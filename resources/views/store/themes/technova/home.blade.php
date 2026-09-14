<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.technova._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Technova') . ' — Shop the terminal'])
</head>
<body class="bg-tn-bg text-tn-ink antialiased">
<div class="tn-scanlines"></div>

@include('store.themes.technova.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

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

  {{-- ===== HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  @php $tnHeroSlides = $heroSlides ?? []; @endphp
  <section class="relative overflow-hidden bg-tn-bg border-b border-tn-border grid"
           x-data="{ tnHero: 0, tnHeroCount: {{ count($tnHeroSlides) }} }"
           @if(count($tnHeroSlides) > 1) x-init="setInterval(() => { tnHero = (tnHero + 1) % tnHeroCount }, 6000)" @endif>
    @foreach($tnHeroSlides as $tnI => $tnSlide)
      <div x-show="tnHero === {{ $tnI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1">
        <div class="absolute inset-0">
          <img src="{{ !empty($tnSlide['image_url']) ? $tnSlide['image_url'] : 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1600&q=70' }}"
               alt="" class="w-full h-full object-cover opacity-20 grayscale">
          <div class="absolute inset-0 bg-gradient-to-r from-tn-bg via-tn-bg/95 to-tn-bg/60"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
          <div>
            <span class="text-tn-amber text-xs font-bold tn-bracket">general_merchandise --all-categories</span>
            <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-bold text-tn-ink leading-tight">
              {{ ($tnSlide['title'] ?? '') !== '' ? $tnSlide['title'] : 'Shop the terminal.' }}<span class="tn-cursor text-tn-green"></span>
            </h1>
            <p class="mt-4 text-tn-mute max-w-lg leading-relaxed">
              {{ ($tnSlide['subtitle'] ?? '') !== '' ? $tnSlide['subtitle'] : 'Electronics, fashion, home, beauty, grocery and sports — compiled into one clean catalog. No bloat, no noise, just fast checkout and a command line that actually works.' }}
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
              <a href="{{ ($tnSlide['cta_link'] ?? '') !== '' ? $tnSlide['cta_link'] : route('store.shop') }}" class="tn-glow-btn h-12 px-6 inline-flex items-center gap-2 border border-tn-green bg-tn-green text-black font-bold">
                {{ ($tnSlide['cta_text'] ?? '') !== '' ? $tnSlide['cta_text'] : 'run ./shop' }}
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
              </a>
              <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="tn-glow-btn h-12 px-6 inline-flex items-center gap-2 border border-tn-amber text-tn-amber font-bold">
                ./deals --today
              </a>
            </div>
            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-tn-mute text-xs">
              <span class="flex items-center gap-1.5 tn-bracket">buyer_protection</span>
              <span class="flex items-center gap-1.5 tn-bracket">free_returns</span>
              <span class="flex items-center gap-1.5 tn-bracket">24_7_support</span>
            </div>
          </div>
          <div class="hidden lg:block tn-window">
            <div class="tn-window-pad p-5 grid grid-cols-2 gap-3">
              <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=500&q=70" class="h-40 w-full object-cover border border-tn-border grayscale-[30%]" alt="">
              <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="h-40 w-full object-cover mt-6 border border-tn-border grayscale-[30%]" alt="">
              <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="h-40 w-full object-cover -mt-3 border border-tn-border grayscale-[30%]" alt="">
              <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70" class="h-40 w-full object-cover border border-tn-border grayscale-[30%]" alt="">
            </div>
          </div>
        </div>
      </div>
    @endforeach

    @if(count($tnHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($tnHeroSlides as $tnI => $tnSlide)
          <button type="button" @click="tnHero = {{ $tnI }}" class="w-2 h-2 rounded-full transition-colors" :class="tnHero === {{ $tnI }} ? 'bg-tn-green' : 'bg-tn-border'" aria-label="Slide {{ $tnI + 1 }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if($bannerGridEnabled ?? true)
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-tn-border hover:border-tn-green transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-tn-border hover:border-tn-green transition-colors">
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
        <h2 class="text-2xl font-bold text-tn-ink tn-bracket">ls ./categories</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-tn-green hover:underline">view --all &gt;</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-3 border border-tn-border hover:border-tn-green transition-colors">
            <span class="w-11 h-11 border border-tn-green text-tn-green flex items-center justify-center font-bold text-lg group-hover:bg-tn-green group-hover:text-black transition-colors">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-medium text-center text-tn-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-tn-panel border-y border-tn-border">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'free_shipping', 'sub' => 'on orders over $99'],
        ['title' => 'secure_payments', 'sub' => 'encrypted checkout'],
        ['title' => 'easy_returns', 'sub' => '30-day window'],
        ['title' => '24_7_support', 'sub' => 'real humans, always'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto border border-tn-green text-tn-green flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-tn-ink">{{ $item['title'] }}</div>
          <div class="text-xs text-tn-mute">{{ $item['sub'] }}</div>
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
            <h2 class="text-2xl font-bold text-tn-ink tn-bracket">{{ strtolower(str_replace(' ', '_', $colTitle)) }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-tn-green hover:underline">view --all &gt;</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.technova.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    @php $centerLeft = ($byPos['center_left'] ?? collect())->first(); @endphp
    @if($bannerGridEnabled ?? true)
    <div class="relative tn-window overflow-hidden h-56 flex items-end p-6 tn-window-pad">
      <img src="{{ $centerLeft ? $bannerUrl($centerLeft) : 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70' }}" class="absolute inset-0 w-full h-full object-cover grayscale-[40%]" alt="{{ $centerLeft->title ?? '' }}">
      <div class="absolute inset-0 bg-gradient-to-t from-black/85 to-transparent" @if($bannerOverlayStyle($centerLeft)) style="{{ $bannerOverlayStyle($centerLeft) }}" @endif></div>
      <div class="relative" @if($bannerTextStyle($centerLeft)) style="{{ $bannerTextStyle($centerLeft) }}" @endif>
        <span class="text-tn-amber text-xs font-bold tn-bracket">{{ ($centerLeft->badge_text ?? null) ?: 'fashion_edit' }}</span>
        <h3 class="text-tn-ink text-xl font-bold mt-1" style="color:inherit;">{{ ($centerLeft->title ?? null) ?: 'New season styles, compiled' }}</h3>
        @if(!empty($centerLeft->subtitle ?? null))
          <p class="text-tn-mute text-xs mt-1" style="color:inherit;">{{ $centerLeft->subtitle }}</p>
        @endif
        <a href="{{ $centerLeft ? ($centerLeft->link ?: route('store.shop')) : route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-tn-green underline" style="color:inherit;">{{ ($centerLeft->button_text ?? null) ?: './shop_now' }} &gt;</a>
      </div>
    </div>
    @endif
    @if($offer['enabled'] ?? true)
    <div class="relative tn-window overflow-hidden h-56 flex items-end p-6 tn-window-pad">
      <img src="{{ !empty($offer['image_url']) ? $offer['image_url'] : 'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70' }}" class="absolute inset-0 w-full h-full object-cover grayscale-[40%]" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/85 to-transparent"></div>
      <div class="relative">
        <span class="text-tn-green text-xs font-bold tn-bracket">{{ ($offer['badge_text'] ?? '') !== '' ? $offer['badge_text'] : 'tech_deals' }}</span>
        <h3 class="text-tn-ink text-xl font-bold mt-1">{{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'Up to 40% off audio & wearables' }}</h3>
        @if(!empty($offer['discount_text']))
          <span class="block mt-1 text-[10px] font-bold text-tn-amber tn-bracket">{{ $offer['discount_text'] }}</span>
        @endif
        <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-tn-green underline">{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : './shop_now >' }}</a>
      </div>
    </div>
    @endif
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-tn-panel border-y border-tn-border">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-bold text-tn-ink text-center mb-8 tn-bracket">cat ./reviews.log</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'amara_k', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived in two days. This is my go-to now.'],
          ['name' => 'daniel_r', 'quote' => 'The category range is wild — I bought running shoes, groceries and a phone case in one cart.'],
          ['name' => 'priya_s', 'quote' => 'Prices are honest and returns were genuinely easy. No hoops to jump through.'],
        ] as $t)
          <div class="p-6 tn-window tn-window-pad">
            <div class="flex gap-0.5 text-tn-amber mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-tn-mute">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-tn-green">{{ '@' . $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="tn-window tn-window-pad p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center">
      <div class="lg:col-span-2">
        <h3 class="text-2xl font-bold text-tn-ink tn-bracket">subscribe --deals</h3>
        <p class="text-tn-mute text-sm mt-2">Join the mailing list for early access to sales across every category.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 border border-tn-border bg-black text-tn-ink text-sm placeholder-tn-mute focus:outline-none focus:border-tn-green">
        <button type="submit" class="tn-glow-btn h-12 px-6 border border-tn-amber text-tn-amber font-bold hover:bg-tn-amber hover:text-black transition-colors">./subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-tn-border"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-tn-border"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.technova.partials.footer', ['categories' => $categories])
@include('store.themes.technova.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
