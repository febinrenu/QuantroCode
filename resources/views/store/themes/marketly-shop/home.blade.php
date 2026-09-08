<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.marketly-shop._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Marketly') . ' — Everything You Need.'])
</head>
<body class="bg-mkt-cream text-mkt-ink antialiased font-sans">

@include('store.themes.marketly-shop.partials.header', ['categories' => $categories])

@php
  $mktHeroEyebrow = 'Limited Time Only';
  $mktHeroTitle = $s->hero_title ?? 'Big Deals. Bigger Savings.';
  $mktHeroSubtitle = $s->hero_subtitle ?? 'Top brands at unbeatable prices.';
  $mktImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $mktHeroImg = $mktImgs[0] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);

  $mktSubcatsHome = optional($categories->first())->subcategories ?? collect();
  $mktSubIdHome = fn ($name) => optional($mktSubcatsHome->firstWhere('name', $name))->id;

  $mktSidebarIcons = [
    'Fiction & Bestsellers' => 'M4 4h11a2 2 0 0 1 2 2v14H6a2 2 0 0 1-2-2V4Z M17 6h3v14h-3',
    'Notebooks & Journals' => 'M6 2h12v20H6z M9 2v20 M6 6h3 M6 10h3',
    'Pens & Writing' => 'm14 4 6 6-10 10H4v-6L14 4Z',
    'Art & Craft Supplies' => 'M12 2a10 10 0 1 0 0 20c1.5 0 2-1 2-2s-1-1-1-2 1-1 2-1h2a3 3 0 0 0 3-3 8 8 0 0 0-8-12Z M7 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z M9 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z M15 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z',
    'Desk & Study Accessories' => 'M4 19h16 M6 19V9l6-4 6 4v10 M9 19v-6h6v6',
    'Kids & Educational' => 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z',
  ];
  $mktSidebarLinks = collect(array_keys($mktSidebarIcons))
    ->filter(fn ($name) => $mktSubIdHome($name))
    ->map(fn ($name) => ['label' => $name, 'icon' => $mktSidebarIcons[$name], 'href' => route('store.shop', ['sub_category' => $mktSubIdHome($name)])])
    ->values();

  $mktTileMap = [
    ['Fiction & Bestsellers', 'bg-violet-50', 'Smart reads for every mood.'],
    ['Notebooks & Journals', 'bg-pink-50', 'Capture ideas beautifully.'],
    ['Pens & Writing', 'bg-green-50', 'Write with confidence.'],
    ['Art & Craft Supplies', 'bg-yellow-50', 'Create something amazing.'],
    ['Desk & Study Accessories', 'bg-blue-50', 'Set up your perfect desk.'],
  ];
  $mktTiles = collect($mktTileMap)->filter(fn ($t) => $mktSubIdHome($t[0]))->values();
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== SIDEBAR + HERO ===== --}}
  <section class="max-w-7xl mx-auto px-4 pt-4">
    <div class="grid lg:grid-cols-[260px_1fr] gap-4">
      <aside class="hidden lg:block bg-mkt-purple text-white rounded-lg overflow-hidden">
        <div class="px-4 py-3.5 flex items-center gap-2 text-sm font-bold border-b border-white/10">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          {{ 'Shop by Category' }}
        </div>
        <ul class="py-1">
          @foreach($mktSidebarLinks as $link)
            <li>
              <a href="{{ $link['href'] }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-white/10">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $link['icon'] }}"/></svg>
                {{ $link['label'] }}
                <svg class="w-3.5 h-3.5 ms-auto opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </li>
          @endforeach
        </ul>
        <a href="{{ route('store.shop') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold border-t border-white/10 hover:bg-white/10">
          {{ 'View All Categories' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </aside>

      <div class="relative overflow-hidden bg-mkt-hero rounded-lg" style="min-height:420px;">
        <div class="absolute -top-10 -left-10 w-56 h-56 rounded-full bg-white/10"></div>
        <div class="absolute bottom-10 right-1/3 w-4 h-4 rounded-full bg-mkt-gold"></div>
        <div class="relative px-8 md:px-12 py-14 md:py-16 grid md:grid-cols-2 items-center gap-6 h-full">
          <div>
            <span class="eyebrow text-mkt-gold text-xs font-bold">{{ $mktHeroEyebrow }}</span>
            <h1 class="font-heading font-extrabold text-3xl md:text-5xl leading-tight text-white mt-3">{{ $mktHeroTitle }}</h1>
            <p class="mt-4 text-white/70 max-w-sm">{{ $mktHeroSubtitle }}</p>
            <div class="mt-7 flex flex-wrap items-center gap-3">
              <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-7 inline-flex items-center bg-mkt-gold text-mkt-purpleDeep text-sm font-bold rounded-md hover:bg-white">
                {{ 'Explore Deals' }}
              </a>
              <a href="{{ route('store.shop') }}" class="h-12 px-6 inline-flex items-center gap-2 text-white text-sm font-semibold rounded-full border border-white/40 hover:bg-white/10">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="m10 8 6 4-6 4Z"/></svg>
                {{ 'Watch Video' }}
              </a>
            </div>
          </div>
          <div class="relative flex items-center justify-center">
            @if($mktHeroImg)
              <div class="w-56 h-56 md:w-72 md:h-72 rounded-full overflow-hidden bg-white/10 border-4 border-white/20">
                <img src="{{ $mktHeroImg }}" alt="{{ $mktHeroTitle }}" class="w-full h-full object-cover">
              </div>
            @endif
            <div class="absolute -top-2 -right-2 md:top-2 md:right-2 w-20 h-20 rounded-full bg-white text-mkt-purpleDeep flex flex-col items-center justify-center text-center leading-tight shadow-cardHover">
              <span class="text-[9px] font-bold eyebrow">{{ 'Up to' }}</span>
              <span class="text-lg font-heading font-extrabold">60%</span>
              <span class="text-[9px] font-bold eyebrow">{{ 'Off' }}</span>
            </div>
          </div>
        </div>
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
          @for($i=0;$i<5;$i++)
            <span class="{{ $i === 0 ? 'w-6' : 'w-1.5' }} h-1.5 rounded-full bg-white {{ $i === 0 ? '' : 'bg-white/40' }}"></span>
          @endfor
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="border border-mkt-ink/10 rounded-lg bg-white grid grid-cols-2 md:grid-cols-4 gap-6 px-6 py-5 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Free Shipping', 'sub' => 'On orders over $75'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Payments', 'sub' => '100% safe & secure'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'M3 18v-6a9 9 0 0 1 18 0v6 M21 19a2 2 0 0 1-2 2h-1v-8h3zM3 19a2 2 0 0 0 2 2h1v-8H3z', 'title' => '24/7 Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-mkt-purple shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-mkt-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-mkt-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY TILES ===== --}}
  @if($mktTiles->count())
    <section class="max-w-7xl mx-auto px-4 py-2">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        @foreach($mktTiles as $i => [$subName, $bgClass, $tileDesc])
          @php $tImg = $subcategoryImages[$subName] ?? ($mktImgs->count() ? $mktImgs[$i % $mktImgs->count()] : null); @endphp
          <a href="{{ route('store.shop', ['sub_category' => $mktSubIdHome($subName)]) }}" class="group rounded-lg p-4 flex flex-col justify-between min-h-[210px] {{ $bgClass }}">
            <div>
              <h3 class="font-heading font-bold text-base text-mkt-ink leading-tight">{{ $subName }}</h3>
              <p class="text-[11px] text-mkt-inkSoft mt-1">{{ $tileDesc }}</p>
              <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold text-mkt-purple group-hover:underline">
                {{ 'Shop Now' }}
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </div>
            @if($tImg)
              <img src="{{ $tImg }}" alt="{{ $subName }}" class="w-20 h-20 object-cover rounded-md self-end mt-2 shadow-card">
            @endif
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRENDING PRODUCTS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading font-bold text-2xl text-mkt-ink">{{ 'Trending Products' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold text-mkt-purple hover:underline inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.marketly-shop.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== DAILY FLASH DEALS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="rounded-lg bg-mkt-ink px-6 py-5 flex flex-wrap items-center gap-5 justify-between">
      <div class="flex items-center gap-4">
        <span class="px-3 py-1.5 rounded border border-mkt-coral text-mkt-coral text-xs font-bold eyebrow" style="text-shadow:0 0 8px rgba(255,62,108,.6)">{{ 'WOW' }}</span>
        <div>
          <h3 class="font-heading font-bold text-lg text-white">{{ 'Daily Flash Deals' }}</h3>
          <p class="text-xs text-white/50">{{ 'New deals every day!' }}</p>
        </div>
      </div>
      <div class="flex items-center gap-2">
        @foreach([['02','Hours'],['18','Mins'],['34','Secs']] as [$num, $label])
          <div class="w-16 h-14 rounded-md bg-white/10 border border-white/20 flex flex-col items-center justify-center">
            <span class="text-white font-heading font-bold text-lg leading-none">{{ $num }}</span>
            <span class="text-[9px] text-white/50 mt-0.5">{{ $label }}</span>
          </div>
        @endforeach
      </div>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-11 px-6 inline-flex items-center bg-mkt-coral text-white text-sm font-bold rounded-md hover:bg-mkt-pink">
        {{ 'Shop Now' }}
      </a>
    </div>
  </section>

  {{-- ===== TOP BRANDS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-end justify-between mb-5">
      <h2 class="font-heading font-bold text-xl text-mkt-ink">{{ 'Top Brands' }}</h2>
      <a href="{{ route('store.shop') }}" class="text-sm font-bold text-mkt-purple hover:underline inline-flex items-center gap-1">
        {{ 'View All Brands' }}
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
      </a>
    </div>
    <div class="flex flex-wrap items-center gap-x-10 gap-y-4">
      @foreach(['Apple','SAMSUNG','SONY','Nike','adidas','PHILIPS','Dyson'] as $brand)
        <span class="text-mkt-ink/60 font-heading font-bold text-lg tracking-wide">{{ $brand }}</span>
      @endforeach
    </div>
  </section>

</main>

@include('store.themes.marketly-shop.partials.footer', ['categories' => $categories])
@include('store.themes.marketly-shop.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
