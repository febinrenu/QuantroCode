<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.veloura._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Veloura') . ' — Curated for those who notice'])
</head>
<body class="bg-vel-black text-vel-ink antialiased">

@include('store.themes.veloura.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== ASYMMETRIC EDITORIAL HERO ===== --}}
  <section class="relative overflow-hidden bg-vel-black border-b border-vel-line">
    <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-12 min-h-[560px] lg:min-h-[640px]">

      {{-- Left: tall image column, offset --}}
      <div class="hidden lg:block lg:col-span-5 relative order-2">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=900&q=70"
             alt="" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-vel-black via-transparent to-transparent"></div>
        <div class="absolute left-6 bottom-24 w-40 h-52 border border-vel-gold/40 overflow-hidden shadow-vlHover translate-y-8">
          <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=400&q=70" class="w-full h-full object-cover" alt="">
        </div>
        <div class="absolute right-8 top-14 w-36 h-36 border border-vel-gold/40 overflow-hidden shadow-vlHover">
          <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=400&q=70" class="w-full h-full object-cover" alt="">
        </div>
      </div>

      {{-- Right: offset headline block, generous negative space --}}
      <div class="lg:col-span-7 order-1 flex flex-col justify-center py-16 lg:py-0 lg:pl-14">
        <span class="eyebrow text-vel-gold text-xs font-bold">Volume Twelve — The Considered Edit</span>
        <h1 class="mt-5 font-serif font-extrabold text-white leading-[1.05] text-4xl sm:text-5xl lg:text-[3.6rem] max-w-2xl">
          {{ $s->hero_title ?? 'Curated for those who notice.' }}
        </h1>
        <p class="mt-6 text-vel-mute max-w-md text-[15px] leading-relaxed">
          {{ $s->hero_subtitle ?? 'From considered electronics to fine fashion, from the home to the vanity — every piece in our collection is chosen for its craft, not its category. This is shopping treated as a quiet pleasure, not a chore.' }}
        </p>
        <div class="mt-9 flex flex-wrap items-center gap-5">
          <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center gap-2 bg-vel-gold text-vel-black font-semibold text-sm hover:bg-vel-goldSoft transition-colors">
            Explore the Collection
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="text-sm font-semibold text-vel-ink border-b border-vel-gold/50 pb-0.5 hover:text-vel-gold hover:border-vel-gold transition-colors">
            View the Edit
          </a>
        </div>
        <div class="mt-10 flex items-center gap-8 text-vel-mute text-xs eyebrow">
          <span>No. 01 — Electronics</span>
          <span>No. 02 — Fashion</span>
          <span>No. 03 — Home &amp; Beauty</span>
        </div>
      </div>
    </div>
  </section>

  <div class="vl-rule"></div>

  {{-- ===== TRUST BAR (understated, luxury framing) ===== --}}
  <section class="bg-vel-black">
    <div class="max-w-7xl mx-auto px-4 py-10 grid sm:grid-cols-3 gap-8 text-center sm:text-left">
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
        <div>
          <div class="font-serif text-base font-semibold text-vel-ink">White-glove service</div>
          <p class="text-xs text-vel-mute mt-1 leading-relaxed max-w-[220px]">A dedicated concierge reviews every order before it leaves our hands — nothing ships without a second look.</p>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>
        <div>
          <div class="font-serif text-base font-semibold text-vel-ink">Insured shipping</div>
          <p class="text-xs text-vel-mute mt-1 leading-relaxed max-w-[220px]">Every parcel travels fully insured, door to door, with discreet packaging worthy of what's inside.</p>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        <div>
          <div class="font-serif text-base font-semibold text-vel-ink">Lifetime support</div>
          <p class="text-xs text-vel-mute mt-1 leading-relaxed max-w-[220px]">Our relationship with you doesn't end at delivery — reach us anytime for care, repair or advice.</p>
        </div>
      </div>
    </div>
  </section>

  <div class="vl-rule"></div>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['top_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden hover:border-vel-gold/50 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['top_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden hover:border-vel-gold/50 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
    <div class="vl-rule"></div>
  @endif

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-14">
      <div class="flex items-end justify-between mb-7">
        <div>
          <span class="eyebrow text-vel-gold text-xs font-bold">Browse</span>
          <h2 class="font-serif text-2xl lg:text-3xl font-bold text-vel-ink mt-1">Shop by Category</h2>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-vel-gold hover:text-vel-goldSoft border-b border-vel-gold/40 pb-0.5">View all →</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-3 p-4 bg-vel-charcoal border border-vel-line hover:border-vel-gold/60 transition-colors">
            <span class="w-11 h-11 rounded-full border border-vel-gold/40 text-vel-gold flex items-center justify-center font-serif font-bold text-lg group-hover:bg-vel-gold group-hover:text-vel-black transition-colors">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-medium text-center text-vel-ink/90 line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
    <div class="vl-rule"></div>
  @endif

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
        <section class="max-w-7xl mx-auto px-4 py-14">
          <div class="flex items-end justify-between mb-7">
            <div>
              <span class="eyebrow text-vel-gold text-xs font-bold">Selected for you</span>
              <h2 class="font-serif text-2xl lg:text-3xl font-bold text-vel-ink mt-1">{{ $colTitle }}</h2>
            </div>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-vel-gold hover:text-vel-goldSoft border-b border-vel-gold/40 pb-0.5">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.veloura.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
        <div class="vl-rule"></div>
      @endif
    @endif
  @endforeach

  {{-- ===== EDITORIAL PROMO STRIP (asymmetric, 3-across mixed categories) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-14">
    <div class="flex items-end justify-between mb-7">
      <div>
        <span class="eyebrow text-vel-gold text-xs font-bold">Three Ways to Notice</span>
        <h2 class="font-serif text-2xl lg:text-3xl font-bold text-vel-ink mt-1">Stories Worth a Second Look</h2>
      </div>
    </div>
    <div class="grid md:grid-cols-3 gap-4">
      <div class="relative overflow-hidden h-72 flex items-end p-6 group">
        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
        <div class="relative">
          <span class="text-vel-gold text-[11px] font-bold eyebrow">Technology</span>
          <h3 class="font-serif text-white text-xl font-bold mt-2">Precision, quietly engineered</h3>
          <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-xs font-semibold text-white border-b border-white/50 pb-0.5">Discover →</a>
        </div>
      </div>
      <div class="relative overflow-hidden h-72 flex items-end p-6 group">
        <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
        <div class="relative">
          <span class="text-vel-gold text-[11px] font-bold eyebrow">Fashion</span>
          <h3 class="font-serif text-white text-xl font-bold mt-2">Tailoring that holds its shape</h3>
          <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-xs font-semibold text-white border-b border-white/50 pb-0.5">Discover →</a>
        </div>
      </div>
      <div class="relative overflow-hidden h-72 flex items-end p-6 group">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=700&q=70" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent"></div>
        <div class="relative">
          <span class="text-vel-gold text-[11px] font-bold eyebrow">Home &amp; Beauty</span>
          <h3 class="font-serif text-white text-xl font-bold mt-2">Everyday objects, elevated</h3>
          <a href="{{ route('store.shop') }}" class="mt-3 inline-flex text-xs font-semibold text-white border-b border-white/50 pb-0.5">Discover →</a>
        </div>
      </div>
    </div>
  </section>

  <div class="vl-rule"></div>

  {{-- ===== CENTER BANNERS ===== --}}
  @if(($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-14 grid md:grid-cols-2 gap-4">
      @foreach($byPos['center_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden hover:border-vel-gold/50 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
      @foreach($byPos['center_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden hover:border-vel-gold/50 transition-colors">
          <img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt="{{ $b->title }}">
        </a>
      @endforeach
    </section>
    <div class="vl-rule"></div>
  @endif

  {{-- ===== TESTIMONIALS — SERIF PULL-QUOTE STYLE ===== --}}
  <section class="bg-vel-charcoal">
    <div class="max-w-7xl mx-auto px-4 py-16">
      <div class="text-center mb-12">
        <span class="eyebrow text-vel-gold text-xs font-bold">In Their Words</span>
        <h2 class="font-serif text-2xl lg:text-3xl font-bold text-vel-ink mt-2">What Clients Tell Us</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-10">
        @foreach([
          ['name' => 'Amara K.', 'role' => 'Repeat client since 2022', 'quote' => 'I ordered a set of noise-cancelling headphones and a cashmere scarf in the same week — both arrived exactly as described, and someone actually called to confirm my delivery window. That kind of attention is rare now.'],
          ['name' => 'Daniel R.', 'role' => 'Verified purchaser', 'quote' => 'What struck me was the range without the compromise. Running shoes, a countertop appliance, skincare — every single item felt like it had been chosen by someone who actually cared, not just stocked.'],
          ['name' => 'Priya S.', 'role' => 'Verified purchaser', 'quote' => 'The packaging alone told me this wasn\'t a typical order. Everything arrived insured and beautifully presented, and when I had a question afterward, a real person answered within the hour.'],
        ] as $t)
          <div class="relative px-2">
            <svg class="w-10 h-10 text-vel-gold/30 mb-2" viewBox="0 0 40 40" fill="currentColor"><path d="M12.9 20.6c-2.4 0-4.3-.8-5.7-2.4-1.4-1.6-2.1-3.6-2.1-6 0-3.1 1-5.9 3-8.4 2-2.5 4.6-4.3 7.8-5.4l1.4 2.7c-2.1 1-3.8 2.2-5 3.8-1.2 1.5-1.9 3-2 4.5.5-.2 1.1-.3 1.8-.3 1.8 0 3.3.6 4.5 1.9 1.2 1.3 1.8 2.8 1.8 4.6 0 1.9-.6 3.5-1.9 4.8-1.3 1.2-2.8 1.9-4.6 1.9zm18.2 0c-2.4 0-4.3-.8-5.7-2.4-1.4-1.6-2.1-3.6-2.1-6 0-3.1 1-5.9 3-8.4 2-2.5 4.6-4.3 7.8-5.4l1.4 2.7c-2.1 1-3.8 2.2-5 3.8-1.2 1.5-1.9 3-2 4.5.5-.2 1.1-.3 1.8-.3 1.8 0 3.3.6 4.5 1.9 1.2 1.3 1.8 2.8 1.8 4.6 0 1.9-.6 3.5-1.9 4.8-1.3 1.2-2.8 1.9-4.6 1.9z"/></svg>
            <p class="font-serif text-[17px] leading-relaxed text-vel-ink/95 italic">{{ $t['quote'] }}</p>
            <div class="mt-5 flex items-center gap-2">
              <span class="w-8 h-px bg-vel-gold/50"></span>
              <div>
                <div class="text-sm font-semibold text-vel-ink">{{ $t['name'] }}</div>
                <div class="text-[11px] text-vel-mute">{{ $t['role'] }}</div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <div class="vl-rule"></div>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-16">
    <div class="border border-vel-gold/30 bg-vel-charcoal p-8 lg:p-14 grid lg:grid-cols-5 gap-8 items-center relative overflow-hidden">
      <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-vel-burgundy/30 blur-3xl pointer-events-none"></div>
      <div class="lg:col-span-2 relative">
        <span class="eyebrow text-vel-gold text-xs font-bold">Join the List</span>
        <h3 class="font-serif text-2xl lg:text-3xl font-bold text-vel-ink mt-3">The first word on new arrivals</h3>
        <p class="text-vel-mute text-sm mt-3 leading-relaxed">Twice a month, a short note on what's newly arrived across the collection — no noise, no daily blasts, just what's genuinely worth your attention.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-3 relative">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-12 px-4 bg-vel-black border border-vel-line text-sm text-vel-ink placeholder:text-vel-mute focus:outline-none focus:border-vel-gold/60">
        <button type="submit" class="h-12 px-7 bg-vel-gold text-vel-black font-bold text-sm hover:bg-vel-goldSoft transition-colors">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <div class="vl-rule"></div>
    <section class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block border border-vel-line overflow-hidden"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.veloura.partials.footer', ['categories' => $categories])
@include('store.themes.veloura.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
