<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.urbana._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Urbana') . ' — Shopping that feels like home'])
</head>
<body class="bg-brand-cream text-brand-ink antialiased">

@include('store.themes.urbana.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
@endphp

<main class="pb-24 lg:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden bg-brand-blueLight">
    <svg class="ur-blob absolute -top-24 -left-24 w-96 h-96 opacity-40" viewBox="0 0 200 200"><path fill="#5B8DEF" d="M43.4,-56.8C56.5,-47.9,67.3,-34.9,71.6,-19.8C75.9,-4.7,73.7,12.6,66.1,27.4C58.5,42.2,45.5,54.6,30.3,61.9C15.1,69.2,-2.3,71.5,-19,67.5C-35.7,63.5,-51.7,53.2,-61.6,38.9C-71.5,24.6,-75.3,6.3,-72.1,-10.4C-68.9,-27.1,-58.7,-42.2,-45.1,-51.3C-31.5,-60.4,-14.5,-63.5,1.6,-65.4C17.7,-67.3,30.3,-65.7,43.4,-56.8Z" transform="translate(100 100)"/></svg>
    <svg class="ur-blob-slow absolute -bottom-32 -right-16 w-[28rem] h-[28rem] opacity-30" viewBox="0 0 200 200"><path fill="#FF6F61" d="M39.6,-51.7C51.4,-42.6,60.9,-29.9,64.8,-15.5C68.7,-1.1,67,15,59.6,27.8C52.2,40.6,39.1,50.1,24.7,56.6C10.3,63.1,-5.4,66.6,-20.6,63.8C-35.8,61,-50.5,51.9,-59.6,39C-68.7,26.1,-72.2,9.4,-69.6,-6C-67,-21.4,-58.3,-35.5,-46.4,-44.8C-34.5,-54.1,-19.4,-58.6,-3.5,-53.9C12.4,-49.2,27.8,-60.8,39.6,-51.7Z" transform="translate(100 100)"/></svg>
    <svg class="absolute top-1/2 left-1/3 w-24 h-24 opacity-20" viewBox="0 0 200 200"><path fill="#FBFAF8" d="M20,80 Q50,20 80,80 T140,80" stroke="#5B8DEF" stroke-width="6" fill="none"/></svg>
    <div class="relative max-w-7xl mx-auto px-4 py-16 lg:py-24 grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="eyebrow text-brand-coral text-xs font-bold">One cozy cart, every category</span>
        <h1 class="mt-3 text-3xl sm:text-4xl lg:text-5xl font-bold font-heading text-brand-ink leading-tight">
          {{ $s->hero_title ?? 'Shopping that feels like home' }}
        </h1>
        <p class="mt-4 text-brand-ink/70 max-w-lg">
          {{ $s->hero_subtitle ?? 'Electronics, fashion, home goods, beauty, groceries and sports gear — all picked with care, wrapped up nicely, and delivered with a smile.' }}
        </p>
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="{{ route('store.shop') }}" class="h-14 px-7 inline-flex items-center gap-2 rounded-full bg-brand-blue text-white font-semibold shadow-soft hover:bg-brand-blueDark hover:shadow-softHover transition-all">
            Start browsing
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
          </a>
          <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-14 px-7 inline-flex items-center gap-2 rounded-full border-2 border-brand-coral text-brand-coral font-semibold hover:bg-brand-coralLight transition-colors">
            Today's cozy deals
          </a>
        </div>
        <div class="mt-8 flex flex-wrap items-center gap-5 text-brand-ink/70 text-xs">
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Buyer protection</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Free easy returns</span>
          <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-brand-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg> Friendly support, always</span>
        </div>
      </div>
      <div class="hidden lg:grid grid-cols-2 gap-4 relative">
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover shadow-softHover" alt="Electronics">
        <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover mt-8 shadow-softHover" alt="Fashion">
        <img src="https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover -mt-4 shadow-softHover" alt="Grocery">
        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=500&q=70" class="rounded-3xl h-48 w-full object-cover shadow-softHover" alt="Beauty">
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

  {{-- ===== CATEGORY GRID ===== --}}
  @if(($categories ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 py-8">
      <div class="flex items-end justify-between mb-5">
        <div>
          <h2 class="text-2xl font-bold font-heading text-brand-ink">Shop by category</h2>
          <p class="text-sm text-brand-ink/60 mt-1">Everything you're looking for, sorted just how you like it.</p>
        </div>
        <a href="{{ route('store.shop') }}" class="text-sm font-semibold text-brand-blue hover:underline shrink-0">View all →</a>
      </div>
      <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        @foreach($categories->take(8) as $cat)
          <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="group flex flex-col items-center gap-2 p-4 rounded-3xl bg-white border border-brand-blueLight hover:border-brand-blue hover:shadow-soft transition-all">
            <span class="w-12 h-12 rounded-full bg-brand-blueLight text-brand-blue flex items-center justify-center font-bold font-heading text-lg group-hover:bg-brand-blue group-hover:text-white transition-colors">
              <x-store.icon :name="category_icon_name($cat->name)" class="w-5 h-5" />
            </span>
            <span class="text-xs font-semibold text-center text-brand-ink line-clamp-2">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-white border-y border-brand-blueLight">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      @foreach([
        ['title' => 'Free Shipping', 'sub' => 'On orders over $99'],
        ['title' => 'Secure Payments', 'sub' => 'Encrypted checkout'],
        ['title' => 'Easy Returns', 'sub' => '30-day happy window'],
        ['title' => 'Friendly Support', 'sub' => 'Real humans, always'],
      ] as $item)
        <div>
          <div class="w-12 h-12 mx-auto rounded-full bg-brand-coralLight text-brand-coral flex items-center justify-center mb-2">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
          </div>
          <div class="text-sm font-bold text-brand-ink">{{ $item['title'] }}</div>
          <div class="text-xs text-brand-ink/60">{{ $item['sub'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== WHY SHOP WITH US (bento) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-bold font-heading text-brand-ink text-center mb-6">Why folks keep coming back</h2>
    <div class="grid md:grid-cols-3 gap-4">
      <div class="rounded-3xl bg-brand-blue text-white p-6 flex flex-col justify-between h-48">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M2 12h20"/></svg>
        <div>
          <h3 class="font-heading font-bold text-lg">Everything, curated</h3>
          <p class="text-sm text-white/80 mt-1">Thousands of products across every category, hand-checked for quality.</p>
        </div>
      </div>
      <div class="rounded-3xl bg-brand-coral text-white p-6 flex flex-col justify-between h-48">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h9l-1 8 10-12h-9z"/></svg>
        <div>
          <h3 class="font-heading font-bold text-lg">Speedy delivery</h3>
          <p class="text-sm text-white/80 mt-1">Most orders arrive within 2-3 days, gift-wrapped smiles included.</p>
        </div>
      </div>
      <div class="rounded-3xl bg-brand-ink text-white p-6 flex flex-col justify-between h-48">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m9 12 2 2 4-4"/></svg>
        <div>
          <h3 class="font-heading font-bold text-lg">No-hassle returns</h3>
          <p class="text-sm text-white/80 mt-1">Changed your mind? 30 days, no questions, no fine print.</p>
        </div>
      </div>
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
            <h2 class="text-2xl font-bold font-heading text-brand-ink">{{ $colTitle }}</h2>
            @if($collection && $collection->slug)
              <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="text-sm font-semibold text-brand-blue hover:underline">View all →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($productVms as $product)
              @include('store.themes.urbana.partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== PROMO STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8 grid md:grid-cols-2 gap-4">
    <div class="relative rounded-3xl overflow-hidden h-56 flex items-end p-6">
      <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-brand-ink/70 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-coralLight text-xs font-bold uppercase">Cozy Wardrobe Edit</span>
        <h3 class="text-white text-xl font-bold font-heading mt-1">Fresh styles for every season</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
    <div class="relative rounded-3xl overflow-hidden h-56 flex items-end p-6">
      <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=900&q=70" class="absolute inset-0 w-full h-full object-cover" alt="">
      <div class="absolute inset-0 bg-gradient-to-t from-brand-ink/70 to-transparent"></div>
      <div class="relative">
        <span class="text-brand-blueLight text-xs font-bold uppercase">Home Comforts</span>
        <h3 class="text-white text-xl font-bold font-heading mt-1">Make your space feel like you</h3>
        <a href="{{ route('store.shop') }}" class="mt-2 inline-flex text-sm font-semibold text-white underline">Shop now →</a>
      </div>
    </div>
  </section>

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="bg-white border-y border-brand-blueLight">
    <div class="max-w-7xl mx-auto px-4 py-12">
      <h2 class="text-2xl font-bold font-heading text-brand-ink text-center mb-8">Loved by shoppers everywhere</h2>
      <div class="grid md:grid-cols-3 gap-6">
        @foreach([
          ['name' => 'Amara K.', 'quote' => 'Ordered a blender, a throw pillow and a lip balm in one go — everything showed up together, cozy and on time.'],
          ['name' => 'Daniel R.', 'quote' => 'It genuinely feels like shopping with a friend who has good taste. The category range is unmatched.'],
          ['name' => 'Priya S.', 'quote' => 'Returns took two clicks. No forms, no waiting on hold. Just easy, like everything here.'],
        ] as $t)
          <div class="p-6 rounded-3xl bg-brand-cream border border-brand-blueLight">
            <div class="flex gap-0.5 text-brand-coral mb-3">
              @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
            </div>
            <p class="text-sm text-brand-ink/70">"{{ $t['quote'] }}"</p>
            <div class="mt-3 text-sm font-bold text-brand-ink">{{ $t['name'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-12">
    <div class="relative rounded-4xl bg-brand-blue overflow-hidden p-8 lg:p-12 grid lg:grid-cols-5 gap-6 items-center">
      <svg class="absolute -bottom-16 -right-10 w-56 h-56 opacity-20" viewBox="0 0 200 200"><path fill="#fff" d="M45.3,-58.6C58.9,-49.5,70.3,-35.7,74.7,-19.9C79.1,-4.1,76.5,13.7,68.6,28.5C60.7,43.3,47.5,55.1,32.5,62.1C17.5,69.1,0.7,71.3,-16.4,69.1C-33.5,66.9,-51,60.3,-62.1,47.7C-73.2,35.1,-77.9,16.5,-76.4,-1.2C-74.9,-18.9,-67.2,-35.7,-55,-45.6C-42.8,-55.5,-26.1,-58.5,-9.5,-59.9C7.1,-61.3,31.7,-67.7,45.3,-58.6Z" transform="translate(100 100)"/></svg>
      <div class="lg:col-span-2 relative">
        <h3 class="text-2xl font-bold font-heading text-white">Get the cozy deals first</h3>
        <p class="text-white/80 text-sm mt-2">Join our list for early access to sales across every single category.</p>
      </div>
      <form action="#" method="post" class="lg:col-span-3 flex flex-col sm:flex-row gap-2 relative">
        @csrf
        <input type="email" required placeholder="you@example.com" class="flex-1 h-14 px-5 rounded-full border-0 text-sm">
        <button type="submit" class="h-14 px-7 rounded-full bg-brand-coral text-white font-bold hover:brightness-95 shadow-softCoral">Subscribe</button>
      </form>
    </div>
  </section>

  {{-- ===== FOOTER BANNERS ===== --}}
  @if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
    <section class="max-w-7xl mx-auto px-4 pb-8 grid md:grid-cols-2 gap-4">
      @foreach($byPos['footer_left'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
      @foreach($byPos['footer_right'] ?? collect() as $b)
        <a href="{{ $b->link ?: route('store.shop') }}" class="block rounded-3xl overflow-hidden shadow-soft"><img src="{{ $bannerUrl($b) }}" class="w-full h-full object-cover" alt=""></a>
      @endforeach
    </section>
  @endif

</main>

@include('store.themes.urbana.partials.footer', ['categories' => $categories])
@include('store.themes.urbana.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
