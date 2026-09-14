<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.medisphere-care._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'MediSphere') . ' — Care Delivered With Confidence'])
</head>
<body class="bg-ms-cream text-ms-ink antialiased">

@include('store.themes.medisphere-care.partials.header', ['categories' => $categories])

@php
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $msFallbackHeroImg = $categorySpecificProducts->first()['image_url'] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);
  $msHeroSlides = $heroSlides ?? [];
  $msImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $msImgAt = fn ($i) => $msImgs->count() ? $msImgs[$i % $msImgs->count()] : null;

  $msSubcats = optional($categories->first())->subcategories ?? collect();
  $msSubcatId = fn ($name) => optional($msSubcats->firstWhere('name', $name))->id;

  $msNeeds = ['Cold & Flu', 'Pain Relief', 'Diabetes Care', 'Heart Health', 'Skin Care', 'Baby Essentials'];

  $msCatTiles = collect(['Prescription Medicines', 'Vitamins & Supplements', 'Personal Care', 'Baby Care', 'Diabetes Care', 'Medical Devices', 'Immunity Support', 'Senior Care'])
    ->values()
    ->map(fn ($name, $i) => ['label' => $name, 'sub_category' => $msSubcatId($name), 'img' => $msImgAt($i)]);

  $msSymptoms = ['Cold & Cough', 'Fever', 'Pain Relief', 'Allergy', 'Digestion', 'Sleep Support', "Women's Care", 'Skin Treatment'];

  // Promo banner tiles: merchant-managed via the Banners module, falling back
  // to this theme's original hardcoded copy when no banner is assigned.
  $byPos = collect($banners ?? [])->groupBy('position');
  $msTileBg = function ($b) {
    return ($b && !empty($b->bg_color)) ? "background-color:{$b->bg_color};" : null;
  };
  $msTileText = function ($b) {
    return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
  };

  // Role-tagged Collections (Recommended / Best Sellers) -- when a merchant
  // has assigned one, its own curated products win over the generic
  // category-specific product list for that named section.
  $msCurrency = $s->currency_code ?? '$';
  $msHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $msRoleVms = collect($collectionsByRole ?? [])->map(function ($r) use ($msCurrency, $msHidePrices) {
      return collect($r['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $msCurrency, $msHidePrices))->values();
  });
  $msRecommendedVms = ($msRoleVms['recommended'] ?? collect())->count() ? $msRoleVms['recommended'] : $categorySpecificProducts;
  $msBestSellersVms = ($msRoleVms['best_sellers'] ?? collect())->count() ? $msRoleVms['best_sellers'] : $categorySpecificProducts->reverse();

  // Category-specific themes like this one otherwise never render a
  // merchant's generic homepage Collections (they only auto-show the
  // locked category's own products) -- so any Collection placed in the
  // Homepage Blocks list gets its own section here too.
  $msCollectionBlocks = collect($blocks ?? [])->filter(fn($b) => ($b['type'] ?? '') === 'collection')->values();
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid lg:grid-cols-[220px_1fr_240px] gap-4">
      <aside class="hidden lg:block bg-white border border-ms-teal/10 rounded-xl2 p-4">
        <h3 class="text-xs font-bold uppercase tracking-wide text-ms-inkSoft mb-3">{{ 'Shop by Need' }}</h3>
        <ul class="space-y-2.5">
          @foreach($msNeeds as $need)
            <li>
              <a href="{{ route('store.shop') }}" class="flex items-center gap-2 text-sm text-ms-ink hover:text-ms-teal">
                <span class="w-1.5 h-1.5 rounded-full bg-ms-teal/40"></span>{{ $need }}
              </a>
            </li>
          @endforeach
        </ul>
        <a href="{{ route('store.shop') }}" class="block mt-4 text-xs font-bold text-ms-teal hover:underline">{{ 'View All' }} &rarr;</a>
      </aside>

      <div class="relative overflow-hidden bg-white border border-ms-teal/10 rounded-xl2 min-h-[340px] grid"
           x-data="{ msHero: 0, msHeroCount: {{ count($msHeroSlides) }} }"
           @if(count($msHeroSlides) > 1) x-init="setInterval(() => { msHero = (msHero + 1) % msHeroCount }, 6000)" @endif>
        @foreach($msHeroSlides as $msI => $msSlide)
          <div x-show="msHero === {{ $msI }}" @if(!$loop->first) x-cloak @endif
               x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
               x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
               class="col-start-1 row-start-1 flex items-center">
            <div class="relative z-10 px-8 py-8 max-w-md">
              <h1 class="font-heading text-3xl md:text-4xl font-extrabold leading-tight text-ms-ink">
                @if(($msSlide['title'] ?? '') !== '')
                  {{ $msSlide['title'] }}
                @else
                  Care Delivered<br>
                  <span class="text-ms-teal">With Confidence</span>
                @endif
              </h1>
              <p class="mt-4 text-sm text-ms-inkSoft max-w-sm">{{ ($msSlide['subtitle'] ?? '') !== '' ? $msSlide['subtitle'] : 'Genuine medicines, expert guidance and fast delivery to your doorstep.' }}</p>
              <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="{{ ($msSlide['cta_link'] ?? '') !== '' ? $msSlide['cta_link'] : route('store.shop') }}" class="h-11 px-6 inline-flex items-center bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep">
                  {{ ($msSlide['cta_text'] ?? '') !== '' ? $msSlide['cta_text'] : 'Shop Medicines' }}
                </a>
                <a href="{{ route('store.contact') }}" class="h-11 px-6 inline-flex items-center border border-ms-teal/40 text-ms-ink text-xs font-bold rounded hover:bg-ms-tealLight">
                  {{ 'Book Consultation' }}
                </a>
              </div>
            </div>
            @php $msHeroImg = !empty($msSlide['image_url']) ? $msSlide['image_url'] : $msFallbackHeroImg; @endphp
            @if($msHeroImg)
              <div class="hidden md:block absolute right-0 bottom-0 top-0 w-[42%]">
                <img src="{{ $msHeroImg }}" alt="" class="w-full h-full object-cover">
              </div>
            @endif
          </div>
        @endforeach

        @if(count($msHeroSlides) > 1)
          <div class="absolute bottom-4 left-8 flex items-center gap-1.5 z-10">
            @foreach($msHeroSlides as $msI => $msSlide)
              <button type="button" @click="msHero = {{ $msI }}" class="w-2 h-2 rounded-full transition-colors" :class="msHero === {{ $msI }} ? 'bg-ms-teal' : 'bg-ms-teal/25'" aria-label="Slide {{ $msI + 1 }}"></button>
            @endforeach
          </div>
        @endif
      </div>

      <div class="hidden lg:flex flex-col gap-4">
        <div class="bg-white border border-ms-teal/10 rounded-xl2 p-4">
          <h4 class="text-sm font-bold text-ms-ink">{{ 'Upload Prescription' }}</h4>
          <p class="text-xs text-ms-inkSoft mt-1">{{ 'Get medicines delivered to your home' }}</p>
          <div class="mt-3 border-2 border-dashed border-ms-teal/30 rounded-lg py-4 text-center">
            <svg class="w-6 h-6 mx-auto text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 16V4M12 4 7 9M12 4l5 5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/></svg>
            <span class="text-[11px] text-ms-inkSoft block mt-1">{{ 'Click to upload or drag & drop' }}</span>
          </div>
          <a href="{{ route('store.contact') }}" class="block mt-3 h-9 leading-9 text-center bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep">{{ 'Quick Refill' }}</a>
        </div>
        <div class="bg-ms-tealLight rounded-xl2 p-4">
          <h4 class="text-sm font-bold text-ms-ink">{{ 'Order in 30 Minutes' }}</h4>
          <p class="text-xs text-ms-inkSoft mt-1">{{ 'Quick delivery in selected areas' }}</p>
          <a href="{{ route('store.shop') }}" class="block mt-3 h-9 leading-9 text-center border border-ms-teal text-ms-teal text-xs font-bold rounded hover:bg-white">{{ 'Check Now' }}</a>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-white border-y border-ms-teal/10">
    <div class="max-w-7xl mx-auto px-4 py-5 grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
      @foreach([
        ['icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z', 'title' => '100% Genuine Products'],
        ['icon' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z M9 12l2 2 4-4', 'title' => 'Licensed Pharmacists'],
        ['icon' => 'M20 7h-4V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2H4a1 1 0 0 0-1 1v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1Z', 'title' => 'Temperature-Safe Delivery'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Payments'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns & Refunds'],
      ] as $item)
        <div class="flex flex-col items-center gap-2">
          <svg class="w-5 h-5 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $item['icon'] }}"/></svg>
          <span class="text-[11px] font-semibold text-ms-ink leading-tight">{{ $item['title'] }}</span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== POPULAR HEALTH CATEGORIES ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-end justify-between mb-5">
      <h2 class="font-heading text-xl font-extrabold text-ms-ink">{{ 'Popular Health Categories' }}</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-ms-teal hover:underline">{{ 'View All' }} &rarr;</a>
    </div>
    <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
      @foreach($msCatTiles as $tile)
        <a href="{{ $tile['sub_category'] ? route('store.shop', ['sub_category' => $tile['sub_category']]) : route('store.shop') }}" class="group flex flex-col items-center text-center gap-2">
          <div class="w-16 h-16 rounded-full overflow-hidden bg-ms-tealLight border border-ms-teal/10">
            @if($tile['img'])
              <img src="{{ $tile['img'] }}" alt="{{ $tile['label'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
            @endif
          </div>
          <span class="text-[11px] font-semibold text-ms-ink leading-tight">{{ $tile['label'] }}</span>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== SHOP BY SYMPTOM ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <h2 class="font-heading text-xl font-extrabold text-ms-ink mb-5">{{ 'Shop by Symptom' }}</h2>
    <div class="flex flex-wrap gap-2">
      @foreach($msSymptoms as $symptom)
        <a href="{{ route('store.shop') }}" class="h-9 px-4 inline-flex items-center rounded-full border border-ms-teal/25 text-xs font-semibold text-ms-ink hover:bg-ms-teal hover:text-white hover:border-ms-teal transition-colors">{{ $symptom }}</a>
      @endforeach
    </div>
  </section>

  {{-- ===== RECOMMENDED FOR YOU ===== --}}
  @if($msRecommendedVms->count())
    <section class="max-w-7xl mx-auto px-4 pb-10">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading text-xl font-extrabold text-ms-ink">{{ 'Recommended For You' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold text-ms-teal hover:underline">{{ 'View All' }} &rarr;</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($msRecommendedVms as $product)
          @include('store.themes.medisphere-care.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== PROMO BANNERS (side tiles via Banners; center tile via Offers & Promotions) ===== --}}
  @if(($bannerGridEnabled ?? true) || ($offer['enabled'] ?? true))
  <section class="max-w-7xl mx-auto px-4 pb-10 grid md:grid-cols-3 gap-4">
    @if($bannerGridEnabled ?? true)
    @php $topLeft = ($byPos['top_left'] ?? collect())->first(); @endphp
    <div class="rounded-xl2 p-6 bg-blue-50 flex items-center justify-between gap-3" @if($msTileBg($topLeft)) style="{{ $msTileBg($topLeft) }}" @endif>
      <div @if($msTileText($topLeft)) style="{{ $msTileText($topLeft) }}" @endif>
        <h3 class="font-heading font-extrabold text-ms-ink" style="color:inherit;">{{ ($topLeft->title ?? null) ?: 'Free Health Check Campaign' }}</h3>
        <p class="text-xs text-ms-inkSoft mt-1" style="color:inherit;">{{ ($topLeft->subtitle ?? null) ?: 'Stay Healthy, Stay Happy' }}</p>
        <a href="{{ $topLeft ? ($topLeft->link ?: route('store.contact')) : route('store.contact') }}" class="inline-flex mt-3 h-9 px-4 items-center bg-blue-600 text-white text-xs font-bold rounded">{{ ($topLeft->button_text ?? null) ?: 'Book Now' }}</a>
      </div>
    </div>
    @endif
    @if($offer['enabled'] ?? true)
    <div class="rounded-xl2 p-6 bg-ms-tealLight flex items-center justify-between gap-3">
      <div>
        <h3 class="font-heading font-extrabold text-ms-ink">{{ ($offer['title'] ?? '') !== '' ? $offer['title'] : 'Immunity Essentials' }}</h3>
        <p class="text-xs text-ms-inkSoft mt-1">{{ ($offer['subtitle'] ?? '') !== '' ? $offer['subtitle'] : 'Top picks to keep your immunity strong — Up to 30% Off' }}</p>
        @if(!empty($offer['discount_text']))
          <span class="inline-flex mt-2 items-center rounded-full bg-white/60 px-2 py-0.5 text-[10px] font-bold text-ms-ink">{{ $offer['discount_text'] }}</span>
        @endif
        <a href="{{ ($offer['link'] ?? '') !== '' ? $offer['link'] : route('store.shop') }}" class="inline-flex mt-3 h-9 px-4 items-center bg-ms-teal text-white text-xs font-bold rounded">{{ ($offer['button_text'] ?? '') !== '' ? $offer['button_text'] : 'Shop Now' }}</a>
      </div>
    </div>
    @endif
    @if($bannerGridEnabled ?? true)
    @php $topRight = ($byPos['top_right'] ?? collect())->first(); @endphp
    <div class="rounded-xl2 p-6 bg-pink-50 flex items-center justify-between gap-3" @if($msTileBg($topRight)) style="{{ $msTileBg($topRight) }}" @endif>
      <div @if($msTileText($topRight)) style="{{ $msTileText($topRight) }}" @endif>
        <h3 class="font-heading font-extrabold text-ms-ink" style="color:inherit;">{{ ($topRight->title ?? null) ?: 'Baby & Mom Care' }}</h3>
        <p class="text-xs text-ms-inkSoft mt-1" style="color:inherit;">{{ ($topRight->subtitle ?? null) ?: 'Gentle care for your little ones — Up to 25% Off' }}</p>
        <a href="{{ $topRight ? ($topRight->link ?: route('store.shop')) : route('store.shop') }}" class="inline-flex mt-3 h-9 px-4 items-center bg-ms-red text-white text-xs font-bold rounded">{{ ($topRight->button_text ?? null) ?: 'Shop Now' }}</a>
      </div>
    </div>
    @endif
  </section>
  @endif

  {{-- ===== HEALTH SERVICES ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <h2 class="font-heading text-xl font-extrabold text-ms-ink mb-5">{{ 'Health Services' }}</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach([
        ['icon' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z', 'title' => 'Online Doctor Consultation', 'cta' => 'Book Now'],
        ['icon' => 'M9 2h6l1 4v14a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V6l1-4Z', 'title' => 'Book Lab Test At Home', 'cta' => 'Book Now'],
        ['icon' => 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z M14 2v6h6', 'title' => 'Upload Prescription', 'cta' => 'Upload Now'],
        ['icon' => 'M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z M12 6v6l4 2', 'title' => 'Refill Reminder', 'cta' => 'Set Reminder'],
        ['icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z', 'title' => 'Wellness Programs', 'cta' => 'Explore'],
      ] as $svc)
        <a href="{{ route('store.contact') }}" class="bg-white border border-ms-teal/10 rounded-xl2 p-4 flex flex-col items-center text-center gap-2 hover:shadow-cardHover transition">
          <svg class="w-6 h-6 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $svc['icon'] }}"/></svg>
          <span class="text-xs font-bold text-ms-ink leading-tight">{{ $svc['title'] }}</span>
          <span class="text-[11px] text-ms-teal font-semibold">{{ $svc['cta'] }}</span>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== BEST SELLERS ===== --}}
  @if($msBestSellersVms->count())
    <section class="max-w-7xl mx-auto px-4 pb-10">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading text-xl font-extrabold text-ms-ink">{{ 'Best Sellers' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold text-ms-teal hover:underline">{{ 'View All' }} &rarr;</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($msBestSellersVms as $product)
          @include('store.themes.medisphere-care.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== FEATURED COLLECTIONS (merchant-managed via Homepage Blocks) ===== --}}
  @foreach($msCollectionBlocks as $msBlock)
    @php
      $msBlockProducts = collect($msBlock['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $msCurrency, $msHidePrices));
      $msBlockCollection = $msBlock['collection'] ?? null;
      $msBlockTitle = $msBlock['title'] ?? ($msBlockCollection->title ?? 'Featured');
    @endphp
    @if($msBlockProducts->count())
      <section class="max-w-7xl mx-auto px-4 pb-10">
        <div class="flex items-end justify-between mb-5">
          <h2 class="font-heading text-xl font-extrabold text-ms-ink">{{ $msBlockTitle }}</h2>
          @if($msBlockCollection && $msBlockCollection->slug)
            <a href="{{ route('store.shop', ['collection' => $msBlockCollection->slug]) }}" class="text-xs font-bold text-ms-teal hover:underline">{{ 'View All' }} &rarr;</a>
          @endif
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
          @foreach($msBlockProducts as $product)
            @include('store.themes.medisphere-care.partials.product-card', ['product' => $product])
          @endforeach
        </div>
      </section>
    @endif
  @endforeach

  {{-- ===== STATS STRIP ===== --}}
  <section class="bg-ms-teal text-white">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
      @foreach([
        ['icon' => 'M20 7h-9M14 17H5 M17 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z M7 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z', 'value' => '15K+', 'label' => 'Products'],
        ['icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z M23 21v-2a4 4 0 0 0-3-3.87 M16 3.13a4 4 0 0 1 0 7.75', 'value' => '100K+', 'label' => 'Happy Customers'],
        ['icon' => 'm12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z', 'value' => '4.9/5', 'label' => 'Average Rating'],
        ['icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z', 'value' => '100%', 'label' => 'Genuine Products'],
        ['icon' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z M9 12l2 2 4-4', 'value' => 'Licensed', 'label' => 'Pharmacy'],
      ] as $stat)
        <div class="flex flex-col items-center gap-1">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $stat['icon'] }}"/></svg>
          <span class="text-lg font-heading font-extrabold">{{ $stat['value'] }}</span>
          <span class="text-[11px] text-white/80">{{ $stat['label'] }}</span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="font-heading text-xl font-extrabold text-ms-ink text-center mb-8">{{ 'What Our Customers Say' }}</h2>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach([
        ['name' => 'Priya Sharma', 'loc' => 'Bangalore', 'text' => 'MediSphere has made ordering medicines so easy. Genuine products, fast delivery and excellent customer support!'],
        ['name' => 'Rahul Verma', 'loc' => 'Delhi', 'text' => 'I use the refill reminder and never miss my medicines now. Very reliable and convenient service.'],
        ['name' => 'Sana Khan', 'loc' => 'Hyderabad', 'text' => 'Excellent experience with lab test booking. Sample collection was on time and reports came quick.'],
      ] as $t)
        <div class="bg-white border border-ms-teal/10 rounded-xl2 p-6">
          <div class="flex gap-0.5 text-ms-gold mb-3">
            @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
          </div>
          <p class="text-sm text-ms-inkSoft leading-relaxed">&ldquo;{{ $t['text'] }}&rdquo;</p>
          <div class="mt-4 text-sm font-bold text-ms-ink">{{ $t['name'] }}</div>
          <div class="text-xs text-ms-inkSoft">{{ $t['loc'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

</main>

@include('store.themes.medisphere-care.partials.footer', ['categories' => $categories])
@include('store.themes.medisphere-care.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
