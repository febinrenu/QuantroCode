<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.casanest._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Casanest') . ' — Timeless pieces, thoughtfully chosen'])
</head>
<body class="bg-cn-cream text-cn-ink antialiased">

@include('store.themes.casanest.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

@php
  $cnSunburst = function($size = 70) {
    return '<svg width="'.$size.'" height="'.($size*0.55).'" viewBox="0 0 90 46" fill="none"><g stroke="#C9A15B" stroke-width="1"><path d="M45 46 L45 6"/><path d="M45 46 L20 10"/><path d="M45 46 L70 10"/><path d="M45 46 L5 22"/><path d="M45 46 L85 22"/><path d="M45 46 L32 8"/><path d="M45 46 L58 8"/></g><circle cx="45" cy="46" r="4" fill="#C9A15B"/></svg>';
  };
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO (symmetrical, centered) ===== --}}
  <section class="relative overflow-hidden bg-cn-emerald">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=1600&q=70"
           alt="" class="w-full h-full object-cover opacity-25">
      <div class="absolute inset-0 bg-gradient-to-b from-cn-emeraldDark/70 via-cn-emerald/85 to-cn-emeraldDark/90"></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4 py-20 lg:py-28 text-center">
      <span class="eyebrow text-cn-goldLight text-xs font-bold">General Merchandise, Curated</span>
      <h1 class="mt-4 text-4xl sm:text-5xl lg:text-6xl font-display font-semibold text-white leading-tight">
        {{ $s->hero_title ?? 'Timeless pieces, thoughtfully chosen.' }}
      </h1>
      <div class="flex justify-center my-5">{!! $cnSunburst(64) !!}</div>
      <p class="mt-2 text-cn-goldLight/90 max-w-xl mx-auto text-lg font-light">
        {{ $s->hero_subtitle ?? 'Electronics, fashion, home, beauty, grocery and sports — each item selected with the same care as the last, so every order feels considered rather than crowded.' }}
      </p>
      <div class="mt-8 flex flex-wrap gap-4 justify-center">
        <a href="{{ route('store.shop') }}" class="h-12 px-8 inline-flex items-center gap-2 bg-cn-gold text-cn-emeraldDark font-semibold text-sm eyebrow hover:bg-cn-goldLight transition-colors">
          Explore The Collection
        </a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-8 inline-flex items-center gap-2 border border-cn-goldLight/60 text-white font-semibold text-sm eyebrow hover:bg-white/10 transition-colors">
          Featured Value
        </a>
      </div>
      <div class="mt-10 flex items-center justify-center gap-8 text-cn-goldLight/80 text-xs eyebrow">
        <span>Buyer Protection</span>
        <span class="w-1 h-1 rounded-full bg-cn-gold"></span>
        <span>Free Returns</span>
        <span class="w-1 h-1 rounded-full bg-cn-gold"></span>
        <span>Concierge Support</span>
      </div>
    </div>
  </section>

  {{-- ===== SYMMETRICAL FEATURE IMAGES ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-3 gap-4 items-center">
    <div class="relative cn-frame">
      <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
      <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=70" class="h-64 w-full object-cover" alt="Electronics">
    </div>
    <div class="text-center px-4">
      <div class="flex justify-center mb-3">{!! $cnSunburst(50) !!}</div>
      <h2 class="font-display text-2xl font-semibold text-cn-emerald">One House, Every Category</h2>
      <p class="text-sm text-cn-mute mt-2">From tailored fashion to considered home goods, technology and everyday essentials — arranged with symmetry and intent.</p>
    </div>
    <div class="relative cn-frame">
      <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
      <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=700&q=70" class="h-64 w-full object-cover" alt="Fashion">
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block cn-frame overflow-hidden shadow-card hover:shadow-cardHover transition-shadow">
          <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block cn-frame overflow-hidden shadow-card hover:shadow-cardHover transition-shadow">
          <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- sunburst divider --}}
  <div class="flex justify-center py-6">{!! $cnSunburst(80) !!}</div>

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 text-center">
      <span class="eyebrow text-cn-gold text-xs font-bold">Browse</span>
      <h2 class="text-3xl font-display font-semibold text-cn-emerald mt-1 mb-8">Shop By Category</h2>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-4">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 bg-white border border-cn-gold/25 hover:border-cn-gold hover:shadow-card transition-all">
            <span class="w-12 h-12 rounded-full border border-cn-gold text-cn-emerald flex items-center justify-center font-display font-semibold text-xl group-hover:bg-cn-emerald group-hover:text-white transition-colors">
              {{ strtoupper(substr($cat->name, 0, 1)) }}
            </span>
            <span class="text-xs eyebrow font-semibold text-center text-cn-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-cn-emerald text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Complimentary Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Effortless Returns', 'sub' => '30-day window'],
        ['title' => 'Concierge Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-10 h-10 mx-auto rounded-full border border-cn-gold text-cn-gold flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm eyebrow font-bold">{{ $item['title'] }}</div>
          <div class="text-xs text-cn-goldLight/80 mt-0.5">{{ $item['sub'] }}</div>
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Selections');
        $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      @endphp
      @if($productVms->count())
        <section class="max-w-7xl mx-auto px-4 py-10 text-center">
          <span class="eyebrow text-cn-gold text-xs font-bold">Curated</span>
          <h2 class="text-3xl font-display font-semibold text-cn-emerald mt-1 mb-8">{{ $colTitle }}</h2>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 text-left">
            @foreach($productVms as $product)
              @include('store.themes.casanest.partials.product-card', ['product' => $product])
            @endforeach
          </div>
          @if($collection && $collection->slug)
            <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="inline-block mt-8 text-sm eyebrow font-semibold text-cn-emerald border-b border-cn-gold hover:text-cn-gold">View All</a>
          @endif
        </section>
      @endif
    @endif
  @endforeach

  {{-- sunburst divider --}}
  <div class="flex justify-center py-6">{!! $cnSunburst(80) !!}</div>

  {{-- ===== PROMO STRIP (symmetrical) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative cn-frame overflow-hidden h-64 flex items-end justify-center p-6 text-center">
      <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
      <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
      <div class="relative">
        <span class="text-cn-goldLight text-xs eyebrow font-bold">The Fashion Edit</span>
        <h3 class="text-white text-2xl font-display font-semibold mt-1">New Season, Considered</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm eyebrow font-semibold text-white underline">Shop Now</a>
      </div>
    </div>
    <div class="relative cn-frame overflow-hidden h-64 flex items-end justify-center p-6 text-center">
      <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
      <div class="relative">
        <span class="text-cn-goldLight text-xs eyebrow font-bold">Technology &amp; Home</span>
        <h3 class="text-white text-2xl font-display font-semibold mt-1">Up To 40% Off Select Pieces</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm eyebrow font-semibold text-white underline">Shop Now</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-cn-gold/20">
    <div class="max-w-5xl mx-auto px-4 py-14 text-center">
      <span class="eyebrow text-cn-gold text-xs font-bold">Testimonials</span>
      <h2 class="text-3xl font-display font-semibold text-cn-emerald mt-1 mb-10">Loved By Discerning Shoppers</h2>
      <div class="grid md:grid-cols-3 gap-8">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a laptop stand and a skincare set together — both arrived beautifully packaged. This is my go-to now.'],
          ['name' => 'Daniel R.', 'quote' => 'The category range is remarkable — running shoes, pantry staples and a phone case in one considered cart.'],
          ['name' => 'Priya S.', 'quote' => 'Prices are honest and returns were genuinely easy. Every detail feels deliberate.'],
        ] as $t)
          <div class="p-6 cn-frame bg-cn-cream">
            <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
            <div class="flex gap-0.5 text-cn-gold mb-3 justify-center">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-cn-mute font-light italic">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm eyebrow font-bold text-cn-emerald">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-4xl mx-auto px-4 py-16 text-center">
    <div class="flex justify-center mb-4">{!! $cnSunburst(60) !!}</div>
    <h3 class="text-3xl font-display font-semibold text-cn-emerald">Join The Inner Circle</h3>
    <p class="text-cn-mute text-sm mt-2 max-w-md mx-auto">Be the first to hear about newly curated pieces and seasonal offerings across every category.</p>
    <form action="#" method="post" class="mt-6 flex flex-col sm:flex-row gap-2 max-w-md mx-auto">
      @csrf
      <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 border border-cn-gold/40 text-sm focus:outline-none focus:border-cn-gold">
      <button type="submit" class="h-12 px-8 bg-cn-emerald text-white font-semibold text-sm eyebrow hover:bg-cn-emeraldDark">Subscribe</button>
    </form>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block cn-frame overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block cn-frame overflow-hidden shadow-card"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.casanest.partials.footer', ['categories' => $categories])
@include('store.themes.casanest.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
