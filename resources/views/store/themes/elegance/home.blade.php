<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.elegance._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Elegance') . ' — Refined, for Every Room and Every Look'])
</head>
<body class="bg-brand-cream text-brand-charcoal antialiased">

@include('store.themes.elegance.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 pt-14 pb-16 lg:pt-20 lg:pb-24 grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <span class="eyebrow text-brand-gold text-xs font-semibold">The Autumn Edit</span>
        <h1 class="mt-4 font-serif text-4xl sm:text-5xl lg:text-6xl leading-[1.05] text-brand-charcoal">
          {{ $s->hero_title ?? 'Refined, for every room and every look' }}
        </h1>
        <p class="mt-6 text-brand-charcoalSoft max-w-md leading-relaxed">
          {{ $s->hero_subtitle ?? 'A considered edit spanning electronics, fashion, home, beauty, grocery and sport — chosen with one eye for quality and one for everyday life.' }}
        </p>
        <div class="mt-9 flex flex-wrap items-center gap-6">
          <a href="{{ route('store.shop') }}" class="h-12 px-8 inline-flex items-center gap-2 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold transition-colors">
            Explore the Collection
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="inline-flex items-center gap-2 text-xs eyebrow font-semibold text-brand-charcoal border-b border-brand-charcoal hover:text-brand-gold hover:border-brand-gold pb-1">
            View the Edit →
          </a>
        </div>
        <div class="mt-10 pt-8 border-t el-hairline flex items-center gap-8 text-brand-charcoalSoft text-xs eyebrow">
          <span>Buyer Assurance</span>
          <span>Effortless Returns</span>
          <span>Considered Shipping</span>
        </div>
      </div>
      <div class="relative">
        <div class="aspect-[4/5] overflow-hidden">
          <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=900&q=70" class="w-full h-full object-cover" alt="Fashion styling">
        </div>
        <div class="absolute -bottom-8 -left-8 w-40 h-52 overflow-hidden border-4 border-brand-cream shadow-[0_20px_45px_-15px_rgba(42,38,34,0.35)] hidden sm:block">
          <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=400&q=70" class="w-full h-full object-cover" alt="Home interior">
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-2 gap-8 border-t el-hairline">
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

  {{-- ===== CATEGORY LOOK BOOK ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-6 py-16 lg:py-20 border-t el-hairline">
      <div class="flex items-end justify-between mb-10">
        <h2 class="font-serif text-3xl italic text-brand-charcoal">Shop the Look Book</h2>
        <a href="{{ route('store.shop') }}" class="text-xs eyebrow font-semibold text-brand-gold hover:underline">View all →</a>
      </div>
      @php
        $lbImages = [
          'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=900&q=70',
          'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=900&q=70',
          'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=900&q=70',
          'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=900&q=70',
        ];
      @endphp
      <div class="grid md:grid-cols-2 gap-6">
        @foreach($categories->take(4) as $i => $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group relative block aspect-[4/3] overflow-hidden">
            <img src="{{ $lbImages[$i % count($lbImages)] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="{{ $cat->name }}">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-charcoal/70 via-brand-charcoal/10 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-6">
              <span class="font-serif italic text-3xl lg:text-4xl text-brand-cream">{{ $cat->name }}</span>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="border-y el-hairline">
    <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      @foreach([
        ['title' => 'Considered Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Effortless Returns', 'sub' => '30-day window'],
        ['title' => 'Personal Support', 'sub' => 'Always at hand'],
      ] as $item)
        <div>
          <div class="text-sm font-serif text-brand-charcoal">{{ $item['title'] }}</div>
          <div class="text-xs text-brand-charcoalSoft mt-1">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CONTENT BLOCKS (collections from homepage_lineup) — asymmetric lookbook grid ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Selections');
        $productVms = $products->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
      @endphp
      @if($productVms->count())
        <section class="max-w-7xl mx-auto px-6 py-16 lg:py-20 border-t el-hairline">
          <div class="flex items-end justify-between mb-10">
            <h2 class="font-serif text-3xl italic text-brand-charcoal">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-xs eyebrow font-semibold text-brand-gold hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
            @foreach($productVms as $i => $product)
              <div class="{{ $i === 0 ? 'col-span-2 row-span-2' : '' }}">
                @include('store.themes.elegance.partials.product-card', ['product' => $product])
              </div>
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== EDITORIAL SPREAD ===== --}}
  <section class="max-w-7xl mx-auto px-6 py-16 lg:py-20 border-t el-hairline grid md:grid-cols-2 gap-10 items-center">
    <div class="relative aspect-[4/5] overflow-hidden order-2 md:order-1">
      <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?auto=format&fit=crop&w=900&q=70" class="w-full h-full object-cover" alt="Beauty edit">
    </div>
    <div class="order-1 md:order-2">
      <span class="eyebrow text-brand-gold text-xs font-semibold">Beauty Notes</span>
      <h3 class="font-serif text-3xl lg:text-4xl mt-3 text-brand-charcoal leading-tight">Small rituals, carefully chosen</h3>
      <p class="mt-4 text-brand-charcoalSoft leading-relaxed max-w-md">From skincare essentials to the audio pieces on your desk, every corner of the collection is chosen with the same restraint — nothing loud, everything considered.</p>
      <a href="{{ route('store.shop') }}" class="mt-6 inline-flex items-center gap-2 text-xs eyebrow font-semibold text-brand-charcoal border-b border-brand-charcoal hover:text-brand-gold hover:border-brand-gold pb-1">Shop the Edit →</a>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="border-y el-hairline">
    <div class="max-w-7xl mx-auto px-6 py-16">
      <h2 class="font-serif text-3xl italic text-brand-charcoal text-center mb-12">Words from our readers</h2>
      <div class="grid md:grid-cols-3 gap-10">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'I ordered a desk lamp and a skincare set in the same afternoon — both felt like they were chosen by someone with real taste.'],
          ['name' => 'Daniel R.', 'quote' => 'The range still surprises me. Running shoes, groceries, a phone case — one cart, one considered aesthetic throughout.'],
          ['name' => 'Priya S.', 'quote' => 'Returns were genuinely simple, and the packaging alone felt like something worth keeping.'],
        ] as $t)
          <div class="text-center">
            <p class="font-serif italic text-lg text-brand-charcoal leading-relaxed">&ldquo;{{ $t['quote'] }}&rdquo;</p>
            <div class="mt-4 text-xs eyebrow font-semibold text-brand-gold">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-6 py-16 lg:py-20">
    <div class="border el-hairline p-10 lg:p-14 grid lg:grid-cols-5 gap-8 items-center">
      <div class="lg:col-span-2">
        <h3 class="font-serif text-3xl italic text-brand-charcoal">Notes from the Edit</h3>
        <p class="text-brand-charcoalSoft text-sm mt-3 leading-relaxed">A quiet email, now and then, when something new and worth knowing about arrives.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-3">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 bg-transparent border-b border-brand-hairline text-sm focus:outline-none focus:border-brand-gold">
        <button type="submit" class="h-12 px-8 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-6 pb-16 grid md:grid-cols-2 gap-8">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.elegance.partials.footer', ['categories' => $categories])
@include('store.themes.elegance.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
