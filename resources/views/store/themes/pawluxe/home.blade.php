<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.pawluxe._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'PawLuxe') . ' — Healthy Essentials for Happy Pets'])
</head>
<body class="bg-pl-cream text-pl-ink antialiased">

@include('store.themes.pawluxe.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $featured = collect($blocks)->where('type','collection')->flatMap(fn($b) => $b['products'] ?? [])->unique('id')->take(6)
      ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  $asset = fn($f) => global_asset('images/themes/pawluxe/'.$f);

  $iconCats = [
    ['Food & Treats', '#F3DFC1', 'M3 11a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1v-6h3M3 11h3v6H5a2 2 0 0 1-2-2z'],
    ['Toys & Play', '#D9EFE3', 'M6.5 8a2.5 2.5 0 1 1 3.9 2.06L9 11.5H15l-1.4-1.44A2.5 2.5 0 1 1 17.5 8a2.5 2.5 0 0 1-1.5 4.4l1.4 1.44a2.5 2.5 0 1 1-2.76 2.9L15 15H9l-1.64 1.74a2.5 2.5 0 1 1-2.76-2.9l1.4-1.44A2.5 2.5 0 0 1 6.5 8Z'],
    ['Grooming', '#FBDCE0', 'M4 4v6M2 6h4M18 4v6M16 6h4M11 7v14M5 12c0 3.5 2.7 5.5 6 7.3 3.3-1.8 6-3.8 6-7.3'],
    ['Health & Wellness', '#F8D3D3', 'M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Zm-8.3 1.9 1.5 2.6h3l-3 5-1.5-2.6h-3Z'],
    ['Beds & Furniture', '#DCEAF5', 'M2 17h20M3 17v-4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4M6 11V8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3'],
    ['Collars & Leashes', '#FBEFC7', 'M8 13a4 4 0 1 1 5.66 0L10 16.5 6.34 13a4 4 0 0 1 1.66-0ZM10 16.5V21'],
    ['Bowls & Feeders', '#D7EFEA', 'M2 11h20v2a7 7 0 0 1-7 7H9a7 7 0 0 1-7-7v-2Zm8-6 1 3M14 5l-1 3'],
    ['Litter & Habitat', '#F6E4D3', 'M4 8h16v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8Zm-1 0 2-4h14l2 4'],
    ['Travel & Carriers', '#DCEFE9', 'M7 8V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2m-13 0h16v11a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8Zm4 4h8'],
    ['Sale & Offers', '#F9D6D2', 'm12 2 2.4 1.4 2.8-.3 1.1 2.6 2.6 1.1-.3 2.8L22 12l-1.4 2.4.3 2.8-2.6 1.1-1.1 2.6-2.8-.3L12 22l-2.4-1.4-2.8.3-1.1-2.6-2.6-1.1.3-2.8L2 12l1.4-2.4-.3-2.8 2.6-1.1 1.1-2.6 2.8.3ZM9 9h.01M15 15h.01M9 15l6-6'],
  ];

  $shopByPet = [
    ['Dogs', $asset('pet-dogs.png'), '#DDEFE6', 'text-pl-ink', '50% 15%'],
    ['Cats', $asset('pet-cats.png'), '#FBDDE0', 'text-rose-600', '50% 25%'],
    ['Birds', $asset('pet-birds.png'), '#FBEFC7', 'text-amber-600', '50% 12%'],
    ['Fish', $asset('pet-fish.png'), '#DCEAF5', 'text-sky-600', '50% 45%'],
    ['Small Pets', $asset('pet-small.png'), '#E9E1F5', 'text-violet-600', '50% 20%'],
  ];

  $articles = [
    ['5 Tips for Healthier Joints in Dogs', $asset('companion-1.png')],
    ['Grooming Essentials for Every Season', $asset('companion-2.png')],
    ['Choosing the Right Habitat for Small Pets', $asset('companion-3.png')],
    ["How to Switch Your Pet's Food the Right Way", $asset('companion-4.png')],
  ];

  $testimonials = [
    ['Jessica M.', '& Buddy', 'PawLuxe has everything I need for my golden! Fast shipping and top quality products.'],
    ['David R.', '& Luna', 'The best pet store online! My cat loves the treats and the bed is super cozy.'],
    ['Priya S.', '& Coco', 'Great selection for small pets and excellent customer service. Highly recommend!'],
  ];

  $brands = ['Royal Canin', 'Hill\'s', 'Blue', 'Wellness', 'Greenies', 'Zesty Paws', 'PetSafe', 'Tidy Cats'];
@endphp

<main>
  {{-- ===== HERO ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 pt-5 grid lg:grid-cols-[1.6fr_1fr] gap-5">
    <div class="relative rounded-3xl bg-pl-mint overflow-hidden min-h-[360px] grid lg:grid-cols-2 items-center">
      <div class="relative z-10 p-8 md:p-12">
        <h1 class="font-display text-[36px] md:text-[46px] leading-[1.08] text-pl-ink">Healthy Essentials<br>for <span class="text-pl-coral">Happy Pets</span></h1>
        <p class="mt-4 text-sm text-pl-mute max-w-sm">Premium products for every tail wag, purr, and tiny paw.</p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="bg-pl-coral text-white px-6 py-3.5 rounded-full text-sm font-bold hover:brightness-95 transition">Shop Bestsellers</a>
          <a href="{{ route('store.shop') }}" class="bg-white border border-pl-ink/15 px-6 py-3.5 rounded-full text-sm font-bold hover:bg-white/70 transition">Explore New Arrivals</a>
        </div>
        <div class="mt-8 flex flex-wrap gap-x-5 gap-y-2 text-xs font-semibold text-pl-ink/80">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pl-teal shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>Vet Approved</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pl-teal shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>Free Shipping On $59+</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-pl-teal shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-Day Returns</span>
        </div>
      </div>
      <div class="hidden lg:block relative h-full min-h-[360px]">
        <img src="{{ $asset('hero-lifestyle.png') }}" alt="Golden retriever and cat with PawLuxe food" class="absolute inset-0 w-full h-full object-cover object-center">
      </div>
    </div>
    <div class="grid grid-rows-2 gap-5">
      <a href="{{ route('store.shop') }}" class="relative rounded-3xl bg-amber-100 p-6 pr-28 flex flex-col justify-center overflow-hidden">
        <h3 class="font-display text-xl text-pl-ink">Vet Approved<br>Wellness</h3>
        <p class="text-xs text-pl-mute mt-2 max-w-[10rem]">Supplements &amp; care you can trust.</p>
        <span class="text-xs font-bold text-pl-coral mt-3 flex items-center gap-1">Shop Wellness <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></span>
        <img src="{{ $asset('promo-wellness-product.png') }}" alt="" class="absolute right-0 bottom-0 h-full w-28 object-cover object-left" style="mask-image:linear-gradient(to right, transparent, black 25%)">
      </a>
      <a href="{{ route('store.shop') }}" class="relative rounded-3xl bg-rose-100 p-6 pr-28 flex flex-col justify-center overflow-hidden">
        <h3 class="font-display text-xl text-pl-ink">Save on<br>Grooming</h3>
        <p class="text-xs text-pl-mute mt-2 max-w-[10rem]">Up to 25% off brushes, shampoos &amp; more!</p>
        <span class="text-xs font-bold text-pl-coral mt-3 flex items-center gap-1">Shop Now <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></span>
        <img src="{{ $asset('promo-grooming-product.png') }}" alt="" class="absolute right-0 bottom-0 h-full w-28 object-cover object-left" style="mask-image:linear-gradient(to right, transparent, black 25%)">
      </a>
    </div>
  </section>

  {{-- ===== CATEGORY ICON ROW ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-8">
    <div class="grid grid-cols-3 sm:grid-cols-5 lg:grid-cols-10 gap-4">
      @foreach($iconCats as $cat)
        <a href="{{ route('store.shop') }}" class="flex flex-col items-center gap-2 text-center group">
          <span class="w-14 h-14 rounded-full grid place-items-center text-pl-ink/70 group-hover:scale-105 transition-transform" style="background:{{ $cat[1] }}">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat[2] }}"/></svg>
          </span>
          <span class="text-[11px] font-semibold leading-tight">{{ $cat[0] }}</span>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== SHOP BY PET ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <div>
        <h2 class="font-display text-2xl text-pl-ink">Shop by Pet</h2>
        <p class="text-xs text-pl-mute mt-1">Find everything your companion needs in one place.</p>
      </div>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-pl-coral flex items-center gap-1">View All Pets <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
      @foreach($shopByPet as $pet)
        <a href="{{ route('store.shop') }}" class="group">
          <div class="relative rounded-2xl overflow-hidden h-40" style="background:{{ $pet[2] }}">
            <img src="{{ $pet[1] }}" alt="{{ $pet[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" style="object-position: {{ $pet[4] }}">
            <span class="absolute top-2 right-2 w-6 h-6 rounded-full bg-white/85 grid place-items-center text-pl-teal">
              <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
            </span>
          </div>
          <div class="mt-2 flex items-center justify-between">
            <span class="font-display text-base {{ $pet[3] }}">{{ $pet[0] }}</span>
            <span class="text-[11px] font-bold text-pl-coral">Shop Now →</span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== FEATURED PICKS ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-2xl text-pl-ink">Featured Picks</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-pl-coral flex items-center gap-1">View All Products <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    @if($featured->isNotEmpty())
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($featured as $product)
          @include('store.themes.pawluxe.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    @else
      <div class="rounded-2xl bg-white border border-pl-line p-10 text-center text-sm text-pl-mute">Add products to your Pet Supplies category to display your collection here.</div>
    @endif
  </section>

  {{-- ===== AUTO-SHIP PROMO ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <div class="rounded-3xl bg-pl-coral text-white px-7 py-7 md:py-8 grid md:grid-cols-[1.3fr_auto_auto] gap-6 items-center">
      <div>
        <h2 class="font-display text-xl md:text-2xl flex items-center gap-2">
          <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8 12 3 3 8v8l9 5 9-5V8Zm0 0-9 5-9-5m9 5v9"/></svg>
          Never Run Out of Their Favorites
        </h2>
        <p class="text-xs text-white/80 mt-1">Save time &amp; money with Auto-Ship.</p>
        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-3 text-xs font-semibold text-white/90">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M9 15l6-6"/></svg>Save 5% on every order</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 3"/></svg>Flexible — skip or cancel anytime</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>Free Shipping on Auto-Ship orders</span>
        </div>
      </div>
      <div class="text-center">
        <div class="text-[10px] uppercase tracking-wide text-white/70 mb-1.5">Next Ship in:</div>
        <div class="flex gap-2">
          @foreach([['02','Days'],['23','Hrs'],['47','Mins'],['18','Secs']] as $t)
            <div class="bg-white/15 rounded-lg px-3 py-2 min-w-[56px]">
              <div class="text-lg font-bold">{{ $t[0] }}</div>
              <div class="text-[9px] uppercase tracking-wide">{{ $t[1] }}</div>
            </div>
          @endforeach
        </div>
      </div>
      <a href="{{ route('store.shop') }}" class="bg-white text-pl-coral px-6 py-3 rounded-full text-sm font-bold whitespace-nowrap hover:bg-pl-cream transition">Start Saving Now →</a>
    </div>
  </section>

  {{-- ===== BEST FOR YOUR COMPANION ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <div class="flex justify-between items-end mb-4">
      <h2 class="font-display text-2xl text-pl-ink flex items-center gap-2">
        <svg class="w-5 h-5 text-pl-coral" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
        Best for Your Companion
      </h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold text-pl-coral flex items-center gap-1">Explore All Articles <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach($articles as $article)
        <a href="{{ route('store.shop') }}" class="flex items-center gap-3 bg-white border border-pl-line rounded-2xl p-2.5 hover:shadow-card transition-shadow">
          <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 bg-pl-mint">
            <img src="{{ $article[1] }}" alt="" class="w-full h-full object-cover">
          </div>
          <div class="min-w-0">
            <div class="text-[13px] font-bold text-pl-ink leading-snug">{{ $article[0] }}</div>
            <span class="text-[11px] font-bold text-pl-coral">Read More →</span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <h2 class="font-display text-2xl text-pl-ink mb-4 flex items-center gap-2">
      <svg class="w-5 h-5 text-pl-coral" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
      What Pet Parents Say
    </h2>
    <div class="grid md:grid-cols-3 gap-4">
      @foreach($testimonials as $t)
        <div class="relative bg-white border border-pl-line rounded-2xl p-5">
          <svg class="absolute top-4 right-4 w-6 h-6 text-pl-mint" viewBox="0 0 24 24" fill="currentColor"><path d="M9 7c-2.8 0-5 2.2-5 5v5h5v-5H6.5C6.5 10 7.6 9 9 9V7Zm9 0c-2.8 0-5 2.2-5 5v5h5v-5h-2.5c0-2 1.1-3 2.5-3V7Z"/></svg>
          <div class="flex gap-0.5 text-pl-coral mb-3">
            @for($i=0;$i<5;$i++)<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
          </div>
          <p class="text-sm text-pl-mute leading-relaxed pr-6">&ldquo;{{ $t[2] }}&rdquo;</p>
          <div class="mt-4 flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-pl-mint grid place-items-center font-display font-bold text-pl-teal text-xs">{{ strtoupper(substr($t[0],0,1)) }}</div>
            <div>
              <div class="text-sm font-bold text-pl-ink">{{ $t[0] }}</div>
              <div class="text-[11px] text-pl-mute">{{ $t[1] }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== TRUSTED BRANDS ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10">
    <p class="text-center text-xs font-bold text-pl-mute mb-4">Trusted by Pets. Loved by Families.</p>
    <div class="flex flex-wrap justify-center gap-x-10 gap-y-3">
      @foreach($brands as $brand)
        <span class="text-sm font-bold text-pl-ink/60 tracking-wide">{{ $brand }}</span>
      @endforeach
    </div>
  </section>

  {{-- ===== JOIN THE CLUB ===== --}}
  <section class="max-w-[1360px] mx-auto px-5 mt-10 mb-12">
    <div class="relative rounded-3xl bg-pl-teal text-white px-7 md:px-10 py-8 grid md:grid-cols-[auto_1fr_auto] gap-6 items-center overflow-hidden">
      <img src="{{ $asset('joinclub-dog.png') }}" alt="" class="hidden md:block h-28 w-auto shrink-0 drop-shadow-lg">
      <div>
        <div class="flex items-center gap-3 flex-wrap">
          <h2 class="font-display text-xl md:text-2xl">Join the PawLuxe Club</h2>
          <span class="text-[11px] font-bold bg-white/20 rounded-full px-3 py-1">It's free to join!</span>
        </div>
        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-3 text-xs font-semibold text-white/90">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>Earn Points on every purchase</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m20.6 12.6-8-8A2 2 0 0 0 11.2 4H5a1 1 0 0 0-1 1v6.2a2 2 0 0 0 .6 1.4l8 8a2 2 0 0 0 2.8 0l5.2-5.2a2 2 0 0 0 0-2.8Z"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>Exclusive Deals &amp; early access</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 12v9H4v-9M2 7h20v5H2zM12 22V7M12 7c-1-2-3-4-5-3s-1 4 1 4M12 7c1-2 3-4 5-3s1 4-1 4"/></svg>Birthday Gifts for your pet</span>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <a href="{{ route('store.shop') }}" class="bg-white text-pl-teal px-6 py-3 rounded-full text-sm font-bold whitespace-nowrap hover:bg-pl-cream transition">Join Now — It's Free</a>
        <img src="{{ $asset('joinclub-cat.png') }}" alt="" class="hidden md:block h-24 w-auto shrink-0 drop-shadow-lg">
      </div>
    </div>
  </section>
</main>

@include('store.themes.pawluxe.partials.footer', ['categories' => $categories])
@include('store.themes.pawluxe.partials.mobile-nav')
<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
