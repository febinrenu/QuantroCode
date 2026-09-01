<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.urbana-lifestyle._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Urbana') . ' — Live Stylish. Every Day.'])
</head>
<body class="bg-urb-cream text-urb-ink antialiased">

@include('store.themes.urbana-lifestyle.partials.header', ['categories' => $categories])

@php
  $urbHeroTitle = $s->hero_title ?? 'Elevate Your Everyday Style';
  $urbHeroSubtitle = $s->hero_subtitle ?? 'Curated pieces for the modern lifestyle.';
  $urbHeroSplit = \Illuminate\Support\Str::of($urbHeroTitle)->explode(' ');
  $urbHeroFirst = $urbHeroSplit->slice(0, ceil($urbHeroSplit->count()/2))->implode(' ');
  $urbHeroRest = $urbHeroSplit->slice(ceil($urbHeroSplit->count()/2))->implode(' ');
  $urbImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $urbHeroImg = !empty($s->hero_image_path) ? global_asset($s->hero_image_path) : ($urbImgs[0] ?? null);

  $urbSubcatsHome = optional($categories->first())->subcategories ?? collect();
  $urbSubIdHome = fn ($name) => optional($urbSubcatsHome->firstWhere('name', $name))->id;

  $urbSidebarIcons = [
    "Women's Fashion" => 'M12 2 9 5H7l1 4-2 1 2 12h8l2-12-2-1 1-4h-2l-3-3Z',
    "Men's Fashion" => 'M7 4 3 7l3 3 2-2v12h8V8l2 2 3-3-4-3h-2a2 2 0 0 1-4 0H7Z',
    'Footwear' => 'M3 18v-3c3-1 4-3 6-6l2 2-3 4h9a3 3 0 0 1 3 3v0H3Z',
    'Bags & Accessories' => 'M6 8h12l1 13H5L6 8Z M9 8V6a3 3 0 0 1 6 0v2',
    'Watches' => 'M12 8v4l3 2 M9 3h6l1 4H8l1-4Z M8 17h8l-1 4H9l-1-4Z M12 8a5 5 0 1 0 0 10 5 5 0 0 0 0-10Z',
    'Beauty & Fragrance' => 'M9 2h6v3H9V2Z M8 5h8l1 4v11a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V9l1-4Z',
    'Home & Living' => 'm3 11 9-8 9 8 M5 10v10h14V10',
    'Sports & Fitness' => 'M6 8v8 M18 8v8 M2 12h4 M18 12h4 M6 12h12',
    'Gadgets & Tech' => 'M4 4h16v12H4z M9 20h6 M12 16v4',
  ];
  $urbSidebarLinks = collect(array_keys($urbSidebarIcons))
    ->filter(fn ($name) => $urbSubIdHome($name))
    ->map(fn ($name) => ['label' => $name, 'icon' => $urbSidebarIcons[$name], 'href' => route('store.shop', ['sub_category' => $urbSubIdHome($name)])])
    ->values();
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== SIDEBAR + HERO ===== --}}
  <section class="max-w-7xl mx-auto px-4 pt-4">
    <div class="grid lg:grid-cols-[260px_1fr] gap-4">
      <aside class="hidden lg:block bg-urb-green text-white">
        <div class="px-4 py-3.5 flex items-center gap-2 text-xs font-bold eyebrow border-b border-white/10">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          {{ 'Shop by Category' }}
        </div>
        <ul class="py-1">
          <li>
            <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-white/10">
              <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z"/></svg>
              {{ 'New Arrivals' }}
              <span class="ms-auto bg-urb-orange text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ 'NEW' }}</span>
            </a>
          </li>
          @foreach($urbSidebarLinks as $link)
            <li>
              <a href="{{ $link['href'] }}" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-white/10">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $link['icon'] }}"/></svg>
                {{ $link['label'] }}
              </a>
            </li>
          @endforeach
          <li>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-white/10">
              <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
              {{ 'Sale & Clearance' }}
              <span class="ms-auto bg-urb-red text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ 'SALE' }}</span>
            </a>
          </li>
        </ul>
        <a href="{{ route('store.shop') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold eyebrow border-t border-white/10 hover:bg-white/10">
          {{ 'View All Categories' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </aside>

      <div class="relative overflow-hidden bg-urb-creamDark" style="min-height:420px;">
        @if($urbHeroImg)
          <img src="{{ $urbHeroImg }}" alt="{{ $urbHeroTitle }}" class="absolute inset-0 w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-urb-creamDark via-urb-creamDark/60 to-transparent"></div>
        <div class="relative px-8 md:px-12 py-16 md:py-20 max-w-md">
          <h1 class="font-serif text-4xl md:text-5xl leading-[1.05] text-urb-ink">
            <span class="block">{{ $urbHeroFirst }}</span>
            <span class="block urb-italic">{{ $urbHeroRest }}</span>
          </h1>
          <p class="mt-4 text-urb-inkSoft max-w-sm">{{ $urbHeroSubtitle }}</p>
          <div class="mt-7 flex flex-wrap items-center gap-3">
            <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center bg-urb-green text-white text-xs font-bold eyebrow hover:bg-urb-greenDeep">
              {{ 'Shop Now' }}
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="h-12 px-7 inline-flex items-center border border-urb-ink/30 text-urb-ink text-xs font-bold eyebrow hover:bg-urb-ink hover:text-white">
              {{ 'Explore Lookbook' }}
            </a>
          </div>
        </div>
        <div class="absolute top-6 right-6 md:top-10 md:right-10 w-24 h-24 rounded-full bg-urb-greenDeep text-white flex flex-col items-center justify-center text-center leading-tight">
          <span class="text-[9px] font-bold eyebrow">{{ 'Up to' }}</span>
          <span class="text-xl font-serif font-bold">40%</span>
          <span class="text-[9px] font-bold eyebrow">{{ 'Off' }}</span>
        </div>
        <button type="button" class="hidden md:inline-flex absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 items-center justify-center text-urb-ink">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button type="button" class="hidden md:inline-flex absolute right-4 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/80 items-center justify-center text-urb-ink">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-urb-cream">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Free Delivery', 'sub' => 'On orders over $75'],
        ['icon' => 'm9 12 2 2 4-4 M20.5 7.3A10 10 0 0 1 12 22a10 10 0 0 1-8.5-14.7L12 2l8.5 5.3Z', 'title' => 'Secure Checkout', 'sub' => '100% safe & secure'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z', 'title' => 'Member Benefits', 'sub' => 'Exclusive deals & perks'],
        ['icon' => 'M3 18v-6a9 9 0 0 1 18 0v6 M21 19a2 2 0 0 1-2 2h-1v-8h3zM3 19a2 2 0 0 0 2 2h1v-8H3z', 'title' => '24/7 Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-urb-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-urb-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-urb-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY TILES ===== --}}
  @php
    $urbTileMap = [
      ["Women's Fashion", 'Women', 'Discover the latest trends for you.'],
      ["Men's Fashion", 'Men Collection', 'Timeless styles made for you.'],
      ['Footwear', 'Shoes Edition', 'Step into comfort and style.'],
      ['Bags & Accessories', 'Bags Collection', 'Carry elegance everywhere.'],
      ['Home & Living', 'Home Essentials', 'Transform your space beautifully.'],
    ];
    $urbTiles = collect($urbTileMap)
      ->filter(fn ($t) => $urbSubIdHome($t[0]))
      ->values();
  @endphp
  @if($urbTiles->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        @foreach($urbTiles as $i => [$subName, $tileLabel, $tileDesc])
          @php $tImg = $urbImgs->count() ? $urbImgs[$i % $urbImgs->count()] : null; @endphp
          <a href="{{ route('store.shop', ['sub_category' => $urbSubIdHome($subName)]) }}" class="group bg-white flex flex-col">
            <div class="aspect-square overflow-hidden bg-urb-creamDark">
              @if($tImg)
                <img src="{{ $tImg }}" alt="{{ $tileLabel }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              @endif
            </div>
            <div class="p-3">
              <h3 class="font-serif text-base text-urb-ink leading-tight">{{ \Illuminate\Support\Str::of($tileLabel)->before(' ') }}</h3>
              @if(\Illuminate\Support\Str::of($tileLabel)->after(' ') !== $tileLabel)
                <h3 class="font-serif text-base text-urb-ink leading-tight -mt-1">{{ \Illuminate\Support\Str::of($tileLabel)->after(' ') }}</h3>
              @endif
              <p class="text-[11px] text-urb-inkSoft mt-1">{{ $tileDesc }}</p>
              <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold eyebrow text-urb-green group-hover:underline">
                {{ 'Shop Now' }}
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== SUMMER SALE / NEW IN THIS WEEK BANNERS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="grid md:grid-cols-2 gap-4">
      <div class="relative overflow-hidden bg-urb-green min-h-[220px] flex items-center">
        @php $urbSaleImg = $urbImgs[1] ?? ($urbImgs[0] ?? null); @endphp
        @if($urbSaleImg)
          <img src="{{ $urbSaleImg }}" alt="Summer Sale" class="absolute inset-0 w-full h-full object-cover opacity-25">
        @endif
        <div class="relative p-8 text-white flex items-center justify-between w-full gap-4">
          <div>
            <h3 class="font-serif text-2xl">{{ 'Summer Sale' }}</h3>
            <p class="mt-1 text-white/70 max-w-xs text-sm">{{ "Don't miss out on amazing deals!" }}</p>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="mt-5 inline-flex h-11 px-6 items-center bg-urb-gold text-urb-greenDeep text-xs font-bold eyebrow hover:bg-white">
              {{ 'Shop The Sale' }} &rarr;
            </a>
          </div>
          <div class="hidden sm:flex w-24 h-24 rounded-full border-2 border-urb-gold items-center justify-center text-center leading-tight shrink-0">
            <span>
              <span class="block text-[9px] font-bold eyebrow">{{ 'Up to' }}</span>
              <span class="block text-xl font-serif font-bold">50%</span>
              <span class="block text-[9px] font-bold eyebrow">{{ 'Off' }}</span>
            </span>
          </div>
        </div>
      </div>
      <div class="relative overflow-hidden bg-urb-creamDark min-h-[220px] flex items-center">
        @php $urbNewImg = $urbImgs->last(); @endphp
        @if($urbNewImg)
          <img src="{{ $urbNewImg }}" alt="New In This Week" class="absolute inset-0 w-full h-full object-cover opacity-20">
        @endif
        <div class="relative p-8">
          <h3 class="font-serif text-2xl text-urb-ink">{{ 'New In This Week' }}</h3>
          <p class="mt-1 text-urb-inkSoft max-w-xs text-sm">{{ 'Fresh arrivals, handpicked for you.' }}</p>
          <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="mt-5 inline-flex items-center gap-1 text-urb-ink text-xs font-bold eyebrow hover:text-urb-green">
            {{ 'Explore Now' }} &rarr;
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRENDING NOW ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-serif text-2xl text-urb-ink">{{ 'Trending Now' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-urb-ink hover:text-urb-green inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-x-4 gap-y-6">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.urbana-lifestyle.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== FOLLOW STRIP ===== --}}
  @if($urbImgs->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="grid grid-cols-2 sm:grid-cols-6 gap-2 items-stretch">
        <div class="col-span-2 sm:col-span-1 bg-urb-green text-white p-4 flex flex-col justify-center">
          <h3 class="font-serif text-lg">{{ 'Follow @urbana.style' }}</h3>
          <p class="text-[11px] text-white/70 mt-1">{{ 'Get daily style inspiration' }}</p>
        </div>
        @foreach($urbImgs->take(5) as $img)
          <div class="aspect-square overflow-hidden bg-urb-creamDark">
            <img src="{{ $img }}" class="w-full h-full object-cover" alt="Urbana style">
          </div>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== JOIN OUR COMMUNITY ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="bg-urb-green text-white px-6 py-8 md:px-10 md:py-8 flex flex-col lg:flex-row items-center justify-between gap-6">
      <div class="flex items-center gap-4">
        <span class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center shrink-0 text-urb-gold">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87 M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
        <div>
          <h3 class="font-serif text-xl">{{ 'Join Our Community' }}</h3>
          <p class="text-sm text-white/60 mt-1">{{ 'Subscribe to get exclusive offers, style tips & new arrivals.' }}</p>
        </div>
      </div>
      <form id="newsletterForm" class="flex w-full lg:w-auto max-w-md gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 border border-white/20 bg-white/10 text-white placeholder-white/50 text-sm focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-urb-gold text-urb-greenDeep text-xs font-bold eyebrow hover:bg-white shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
      <div class="hidden xl:flex items-center gap-6 text-[11px] text-white/70">
        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-urb-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z"/></svg>{{ 'Exclusive Offers' }}</span>
        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-urb-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>{{ 'Early Access' }}</span>
        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-urb-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>{{ 'Style Tips' }}</span>
      </div>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-urb-inkSoft"></div>
  </section>

</main>

@include('store.themes.urbana-lifestyle.partials.footer', ['categories' => $categories])
@include('store.themes.urbana-lifestyle.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('newsletterForm');
  const emailInput = document.getElementById('newsletterEmail');
  const btn = document.getElementById('newsletterBtn');
  const msg = document.getElementById('newsletterMsg');
  if (!form) return;
  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    msg.textContent = '';
    btn.disabled = true;
    const originalHTML = btn.innerHTML;
    btn.textContent = '…';
    try {
      const resp = await fetch(@json(route('newsletter.subscribe')), {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: new FormData(form),
      });
      const data = await resp.json().catch(() => ({}));
      if (resp.ok) {
        msg.className = 'text-sm mt-2 text-urb-green';
        msg.textContent = @json(__('messages.NewsletterThanks'));
        emailInput.value = '';
      } else {
        msg.className = 'text-sm mt-2 text-red-600';
        msg.textContent = data.message || @json(__('messages.NewsletterFailed'));
      }
    } catch (err) {
      msg.className = 'text-sm mt-2 text-red-600';
      msg.textContent = @json(__('messages.NewsletterFailed'));
    } finally {
      btn.disabled = false;
      btn.innerHTML = originalHTML;
    }
  });
});
</script>
</body>
</html>
