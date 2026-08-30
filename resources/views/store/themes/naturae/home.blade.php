<!doctype html>
<html lang="en">
<head>
@include('store.themes.naturae._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Naturae') . ' — Good for you, good for the planet'])
</head>
<body class="bg-cream text-ink antialiased">

@include('store.themes.naturae.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $tileBg = ['bg-leaf-light','bg-terracotta-light','bg-[#EFE6D6]','bg-[#E3E9D3]','bg-[#F1DCC7]','bg-[#DCE6D9]','bg-[#F5E3D0]','bg-[#E6E0CE]'];
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-leaf-light">
    <div class="absolute -top-20 -right-24 w-96 h-96 rounded-full bg-terracotta-light/60 blur-2xl"></div>
    <div class="absolute -bottom-24 -left-16 w-72 h-72 rounded-full bg-leaf/20 blur-2xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-14 lg:py-20 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="inline-flex items-center gap-2 eyebrow text-terracotta-dark text-xs font-bold bg-white/70 px-3 py-1.5 rounded-full">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
          One basket, every category
        </span>
        <h1 class="mt-4 text-4xl sm:text-5xl lg:text-[3.4rem] font-display font-semibold text-leaf-deep leading-[1.08]">
          {{ $s->hero_title ?? 'Good for you, good for the planet.' }}
        </h1>
        <p class="mt-5 text-bark/80 max-w-lg leading-relaxed text-[15px]">
          {{ $s->hero_subtitle ?? 'From noise-cancelling headphones to organic cotton knitwear, oak side tables to skincare oils — Naturae gathers electronics, fashion, home, beauty, grocery and sporting goods that are made responsibly, priced fairly, and packed without the plastic.' }}
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 rounded-full bg-leaf-dark text-white font-semibold hover:bg-leaf-deep transition-colors shadow-soft">
            Browse the whole store
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-13 px-7 py-3.5 inline-flex items-center gap-2 rounded-full border-2 border-leaf-dark/30 text-leaf-deep font-semibold hover:bg-white/60 transition-colors">
            Everyday value picks
          </a>
        </div>
        <div class="mt-9 flex flex-wrap items-center gap-x-6 gap-y-3 text-bark/70 text-xs font-medium">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17l-5-5"/></svg> Sustainably sourced</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17l-5-5"/></svg> Plastic-free packaging</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17l-5-5"/></svg> Carbon-neutral shipping</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-5">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=520&q=70" class="rounded-4xl h-52 w-full object-cover shadow-softHover" alt="Electronics">
        <img src="https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?auto=format&fit=crop&w=520&q=70" class="rounded-4xl h-52 w-full object-cover mt-10 shadow-softHover" alt="Fashion">
        <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=520&q=70" class="rounded-4xl h-52 w-full object-cover -mt-5 shadow-softHover" alt="Home goods">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=520&q=70" class="rounded-4xl h-52 w-full object-cover shadow-softHover" alt="Beauty">
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft hover:shadow-softHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft hover:shadow-softHover transition-shadow">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
  @endif

  {{-- ===== ECO TRUST BAR (reframed, not generic) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="rounded-3xl bg-white border border-leaf-light shadow-soft grid grid-cols-2 md:grid-cols-4 divide-x divide-leaf-light/70">
      @foreach([
        ['icon' => 'leaf', 'title' => 'Sustainably sourced', 'sub' => 'Vetted suppliers, every category'],
        ['icon' => 'sprout', 'title' => 'Plastic-free packaging', 'sub' => 'Recycled or compostable, always'],
        ['icon' => 'loop', 'title' => 'Carbon-neutral shipping', 'sub' => 'Offset on every single order'],
        ['icon' => 'seed', 'title' => 'Ethical partners', 'sub' => 'Fair wages, audited factories'],
      ] as $item)
        <div class="p-5 flex flex-col items-center text-center gap-2">
          <div class="w-11 h-11 rounded-full bg-leaf-light flex items-center justify-center">
            @if($item['icon']==='leaf')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
            @elseif($item['icon']==='sprout')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 10c3-4 7-6 8-6s5 2 8 6c-1 5-5 9-8 10-3-1-7-5-8-10Z"/><path stroke-linecap="round" d="M12 8v8"/></svg>
            @elseif($item['icon']==='loop')
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12c1-4 5-7 9-7s8 3 9 7M3 12c1 4 5 7 9 7s8-3 9-7"/><path stroke-linecap="round" d="M9 12h6"/></svg>
            @else
              <svg class="w-5 h-5 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="9" r="3.2"/><path stroke-linecap="round" d="M12 12.2V21M8 21h8"/></svg>
            @endif
          </div>
          <div class="text-sm font-bold text-leaf-deep font-display">{{ $item['title'] }}</div>
          <div class="text-xs text-bark/60">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY GRID — color-blocked tiles ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-12">
      <div class="flex items-end justify-between mb-6">
        <div>
          <span class="eyebrow text-terracotta-dark text-xs font-bold">Explore</span>
          <h2 class="text-2xl lg:text-3xl font-display font-semibold text-leaf-deep mt-1">Shop by category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-terracotta-dark nt-wiggle-underline">View all</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($categories->take(8) as $i => $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group relative flex flex-col justify-between gap-6 p-5 rounded-3xl {{ $tileBg[$i % count($tileBg)] }} hover:shadow-softHover transition-shadow min-h-[136px] overflow-hidden">
            <span class="w-11 h-11 rounded-full bg-white/70 flex items-center justify-center font-display font-bold text-leaf-deep text-lg group-hover:bg-white transition-colors">
              {{ strtoupper(substr($cat->name, 0, 1)) }}
            </span>
            <span class="text-sm font-bold text-ink/90 font-display leading-snug">{{ $cat->name }}</span>
            <svg class="absolute -bottom-4 -right-4 w-20 h-20 text-black/5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
          </a>
        @endforeach
      </div>
    </section>
  @endif

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
        <section class="max-w-7xl mx-auto px-4 py-10">
          <div class="flex items-end justify-between mb-6">
            <div>
              <span class="eyebrow text-terracotta-dark text-xs font-bold">Curated for you</span>
              <h2 class="text-2xl lg:text-3xl font-display font-semibold text-leaf-deep mt-1">{{ $colTitle }}</h2>
            </div>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-terracotta-dark nt-wiggle-underline">View all</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.naturae.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== "ROOTED IN GOOD PRACTICE" FEATURE STRIP ===== --}}
  <section class="bg-leaf-deep">
    <div class="max-w-7xl mx-auto px-4 py-14 grid lg:grid-cols-3 gap-8 items-start text-cream">
      <div>
        <span class="eyebrow text-terracotta-light text-xs font-bold">Our promise</span>
        <h2 class="text-2xl lg:text-3xl font-display font-semibold mt-2 leading-tight">Rooted in good practice, not just good marketing</h2>
        <p class="mt-4 text-cream/70 text-sm leading-relaxed max-w-sm">Every category on Naturae — from kitchen electronics to running shoes — is screened against the same standard: made well, sourced honestly, and shipped with the smallest footprint we can manage.</p>
      </div>
      <div class="lg:col-span-2 grid sm:grid-cols-2 gap-5">
        <div class="p-5 rounded-3xl bg-white/5 border border-white/10">
          <svg class="w-8 h-8 text-terracotta-light mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 10c3-4 7-6 8-6s5 2 8 6c-1 5-5 9-8 10-3-1-7-5-8-10Z"/><path stroke-linecap="round" d="M12 8v8"/></svg>
          <h3 class="font-display font-semibold text-white">Woven-basket sourcing</h3>
          <p class="text-cream/65 text-sm mt-1 leading-relaxed">We work directly with small manufacturers and co-ops across electronics, textiles and food — fewer middlemen, fairer prices at the source.</p>
        </div>
        <div class="p-5 rounded-3xl bg-white/5 border border-white/10">
          <svg class="w-8 h-8 text-terracotta-light mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
          <h3 class="font-display font-semibold text-white">Packaging that composts</h3>
          <p class="text-cream/65 text-sm mt-1 leading-relaxed">Every box ships in recycled cardboard, plant-based mailers, and paper tape — no single-use plastic, ever, on any order.</p>
        </div>
        <div class="p-5 rounded-3xl bg-white/5 border border-white/10">
          <svg class="w-8 h-8 text-terracotta-light mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12c1-4 5-7 9-7s8 3 9 7M3 12c1 4 5 7 9 7s8-3 9-7"/><path stroke-linecap="round" d="M9 12h6"/></svg>
          <h3 class="font-display font-semibold text-white">Offset delivery routes</h3>
          <p class="text-cream/65 text-sm mt-1 leading-relaxed">We calculate the footprint of every shipment and fund verified reforestation and clean-energy projects to balance it out.</p>
        </div>
        <div class="p-5 rounded-3xl bg-white/5 border border-white/10">
          <svg class="w-8 h-8 text-terracotta-light mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="9" r="3.2"/><path stroke-linecap="round" d="M12 12.2V21M8 21h8"/></svg>
          <h3 class="font-display font-semibold text-white">Audited, always</h3>
          <p class="text-cream/65 text-sm mt-1 leading-relaxed">Every factory and farm partner passes third-party labor and safety audits before a single product reaches our shelves.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-5">
    <div class="relative rounded-4xl overflow-hidden h-60 flex items-end p-7">
      <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="Home goods">
      <div class="absolute inset-0 bg-gradient-to-t from-black/65 to-transparent"></div>
      <div class="relative">
        <span class="text-terracotta-light text-xs font-bold uppercase">Home Edit</span>
        <h3 class="text-white text-2xl font-display font-semibold mt-1">Warm the house, not the planet</h3>
        <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-sm font-semibold text-white underline">Shop home &amp; living</a>
      </div>
    </div>
    <div class="relative rounded-4xl overflow-hidden h-60 flex items-end p-7">
      <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="Tech">
      <div class="absolute inset-0 bg-gradient-to-t from-black/65 to-transparent"></div>
      <div class="relative">
        <span class="text-leaf-light text-xs font-bold uppercase">Tech &amp; Audio</span>
        <h3 class="text-white text-2xl font-display font-semibold mt-1">Refurbished-friendly electronics</h3>
        <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-sm font-semibold text-white underline">Shop electronics</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-leaf-light">
    <div class="max-w-7xl mx-auto px-4 py-14">
      <div class="text-center mb-9">
        <span class="eyebrow text-terracotta-dark text-xs font-bold">Community</span>
        <h2 class="text-2xl lg:text-3xl font-display font-semibold text-leaf-deep mt-2">Loved by shoppers who care where things come from</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Marisol T.', 'role' => 'Verified buyer', 'quote' => 'I ordered a blender, a wool sweater and a bag of single-origin coffee in the same cart — everything arrived in cardboard and paper, no plastic in sight. That detail matters to me.'],
          ['name' => 'Owen F.', 'role' => 'Verified buyer', 'quote' => 'The sustainability claims here actually check out — the packaging insert explains exactly which farm the cotton in my shirt came from. Rare to see that level of transparency.'],
          ['name' => 'Ines D.', 'role' => 'Verified buyer', 'quote' => 'Bought running shoes and skincare together and both brands had ethical sourcing badges I could actually verify. Prices were fair too, not a "green tax" markup.'],
        ] as $t)
          <div class="p-7 rounded-3xl bg-cream border border-leaf-light">
            <div class="flex gap-0.5 text-terracotta mb-4">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-bark/80 leading-relaxed">&ldquo;{{ $t['quote'] }}&rdquo;</p>
            <div class="mt-4 flex items-center gap-2">
              <div class="w-8 h-8 rounded-full bg-leaf-light flex items-center justify-center font-display font-bold text-leaf-dark text-xs">{{ strtoupper(substr($t['name'],0,1)) }}</div>
              <div>
                <div class="text-sm font-bold text-leaf-deep font-display">{{ $t['name'] }}</div>
                <div class="text-[11px] text-bark/50">{{ $t['role'] }}</div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-14">
    <div class="relative rounded-4xl bg-terracotta-light overflow-hidden p-9 lg:p-14 grid lg:grid-cols-5 gap-7 items-center">
      <svg class="absolute -top-10 -left-10 w-56 h-56 text-terracotta/15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8"><path d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
      <div class="lg:col-span-2 relative">
        <h3 class="text-2xl lg:text-3xl font-display font-semibold text-leaf-deep">Join the good-for-the-planet list</h3>
        <p class="text-bark/70 text-sm mt-2 leading-relaxed">Early access to new arrivals across every category, plus the occasional note on where your favorite products actually come from.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 relative flex flex-col sm:flex-row gap-3">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-13 px-5 py-3.5 rounded-full border-0 text-sm shadow-soft">
        <button type="submit" class="h-13 px-7 py-3.5 rounded-full bg-leaf-dark text-white font-bold hover:bg-leaf-deep transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.naturae.partials.footer', ['categories' => $categories])
@include('store.themes.naturae.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
