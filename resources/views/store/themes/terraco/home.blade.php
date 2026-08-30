<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.terraco._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Terraco') . ' — Less noise, better choices'])
</head>
<body class="bg-terra-bg text-terra-ink antialiased">

@include('store.themes.terraco.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $topBanner = ($byPos['top_left'] ?? collect())->first() ?? ($byPos['top_right'] ?? collect())->first();
  $firstCollectionBlock = collect($blocks ?? [])->first(fn($b) => ($b['type'] ?? '') === 'collection' && !empty($b['products']));
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== 1. HERO — huge thin headline, small subhead, one CTA, lots of whitespace ===== --}}
  <section class="max-w-6xl mx-auto px-6 pt-16 pb-20 lg:pt-28 lg:pb-28">
    <div class="max-w-3xl">
      <span class="eyebrow text-xs text-terra-slate">General merchandise, curated calmly</span>
      <h1 class="font-heading font-light text-6xl lg:text-7xl leading-[1.05] text-terra-ink mt-5 tracking-tight">
        {{ $s->hero_title ?? 'Less noise. Better choices.' }}
      </h1>
      <p class="text-sm text-terra-inkSoft mt-6 max-w-md leading-relaxed">
        {{ $s->hero_subtitle ?? 'A considered selection of electronics, fashion, home and beauty — chosen so you don\'t have to sift through everything else.' }}
      </p>
      <div class="mt-10">
        <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-3 h-12 px-7 border border-terra-ink text-terra-ink text-sm font-medium tracking-wide hover:bg-terra-ink hover:text-white transition-colors">
          Shop the collection
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
        </a>
      </div>
    </div>

    @if($topBanner)
      <a href="{{ $topBanner->link ?: route('store.shop') }}" class="mt-16 block border border-terra-line overflow-hidden">
        <img src="{{ $bannerUrl($topBanner) }}" alt="{{ $topBanner->title }}" class="w-full h-40 lg:h-56 object-cover">
      </a>
    @else
      <div class="mt-16 border border-terra-line overflow-hidden">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=70" alt="" class="w-full h-40 lg:h-56 object-cover">
      </div>
    @endif
  </section>

  {{-- ===== 2. CATEGORY STRIP — single row, not a grid ===== --}}
  @if(($categories ?? collect())->count())
    <section class="border-y border-terra-line">
      <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-6">
          <h2 class="font-heading font-light text-2xl text-terra-ink">Browse by category</h2>
          <a href="{{ route('store.shop') }}" class="text-xs eyebrow text-terra-slate hover:text-terra-ink">View all</a>
        </div>
        <ul class="no-scrollbar flex flex-nowrap items-center gap-8 overflow-x-auto pb-1">
          @foreach($categories->take(10) as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex items-center gap-3">
                <span class="w-11 h-11 rounded-full border border-terra-line flex items-center justify-center font-heading font-light text-base text-terra-slate group-hover:border-terra-slate transition-colors">
                  {{ strtoupper(substr($cat->name, 0, 1)) }}
                </span>
                <span class="text-sm text-terra-ink whitespace-nowrap group-hover:text-terra-slate">{{ $cat->name }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </section>
  @endif

  {{-- ===== 3. PRODUCT GRID — single collection section, general merchandise mix ===== --}}
  @php
    $colProducts = collect($firstCollectionBlock['products'] ?? [])
      ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
    $colCollection = $firstCollectionBlock['collection'] ?? null;
    $colTitle = $firstCollectionBlock['title'] ?? ($colCollection->title ?? $colCollection->name ?? 'Selected for you');
  @endphp
  @if($colProducts->count())
    <section class="max-w-6xl mx-auto px-6 py-16 lg:py-20">
      <div class="flex items-end justify-between mb-10">
        <div>
          <span class="eyebrow text-xs text-terra-slate">Across every category</span>
          <h2 class="font-heading font-light text-3xl text-terra-ink mt-2">{{ $colTitle }}</h2>
        </div>
        @if($colCollection && $colCollection->slug)
          <a href="{{ route('store.shop', ['collection' => $colCollection->slug]) }}" class="text-xs eyebrow text-terra-slate hover:text-terra-ink whitespace-nowrap">View all</a>
        @else
          <a href="{{ route('store.shop') }}" class="text-xs eyebrow text-terra-slate hover:text-terra-ink whitespace-nowrap">View all</a>
        @endif
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($colProducts->take(8) as $product)
          @include('store.themes.terraco.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== 4. SINGLE MINIMAL TESTIMONIAL — one quiet quote, not a grid ===== --}}
  <section class="border-y border-terra-line">
    <div class="max-w-3xl mx-auto px-6 py-20 text-center">
      <svg class="w-6 h-6 mx-auto text-terra-sand mb-6" viewBox="0 0 24 24" fill="currentColor"><path d="M9.5 6C6.5 6 4 8.5 4 11.5S6.5 17 9.5 17c.4 0 .8 0 1.1-.1-.6 1.9-2.2 3.3-4.3 3.9l.6 1.7c3.9-1.1 6.6-4.2 6.6-8.5V11c0-2.8-1.8-5-4-5zm10 0c-3 0-5.5 2.5-5.5 5.5S16.5 17 19.5 17c.4 0 .8 0 1.1-.1-.6 1.9-2.2 3.3-4.3 3.9l.6 1.7c3.9-1.1 6.6-4.2 6.6-8.5V11c0-2.8-1.8-5-4-5z"/></svg>
      <p class="font-heading font-light text-2xl lg:text-3xl leading-snug text-terra-ink">
        "One cart, honest prices, and nothing I didn't ask for — this is how shopping should feel."
      </p>
      <p class="text-xs eyebrow text-terra-inkSoft mt-6">Mia L., verified customer</p>
    </div>
  </section>

</main>

{{-- ===== 5. FOOTER ===== --}}
@include('store.themes.terraco.partials.footer', ['categories' => $categories])
@include('store.themes.terraco.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
