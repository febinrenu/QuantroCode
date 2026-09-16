<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.freshcart-daily._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'FreshCart') . ' — Fresh Groceries Delivered Daily'])
</head>
<body class="bg-fc-cream text-fc-ink antialiased">

@include('store.themes.freshcart-daily.partials.header', ['categories' => $categories])

@php
  $fcHeroTitle = $s->hero_title ?? 'Fresh Groceries Delivered Daily';
  $fcHeroSubtitle = $s->hero_subtitle ?? 'Farm fresh quality, daily essentials and everything in between.';
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $fcHeroImg = $categorySpecificProducts->first()['image_url'] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);
  $fcProdImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $fcImgAt = fn ($i) => $fcProdImgs->count() ? $fcProdImgs[$i % $fcProdImgs->count()] : null;

  $fcSidebarCats = ['Fresh Fruits & Vegetables', 'Dairy, Bread & Eggs', 'Bakery & Cakes', 'Meat, Fish & Seafood', 'Frozen Foods', 'Beverages', 'Snacks & Branded Foods', 'Baby Care', 'Cleaning Essentials', 'Personal Care', 'Organic & Natural'];

  $fcTileLabels = ['Fruits & Vegetables', 'Dairy & Eggs', 'Bakery', 'Meat & Seafood', 'Beverages', 'Snacks & Munchies', 'Cleaning Essentials', 'Baby Care', 'Organic Store'];
  $fcTiles = collect($fcTileLabels)->map(fn ($label, $i) => ['label' => $label, 'img' => $fcImgAt($i)]);

  $fcAisles = ['Grains & Rice', 'Pulses & Dals', 'Flours & Sooji', 'Oil & Ghee', 'Masalas & Spices', 'Sauces & Ketchup', 'Tea, Coffee & Drinks'];

  $fcHeroWords = explode(' ', $fcHeroTitle);
  $fcHeroMid = (int) ceil(count($fcHeroWords) / 2);
  $fcHeroLine1 = implode(' ', array_slice($fcHeroWords, 0, $fcHeroMid));
  $fcHeroLine2 = implode(' ', array_slice($fcHeroWords, $fcHeroMid));
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO (sidebar + banner) ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid lg:grid-cols-[260px_1fr] gap-4">
      <aside class="hidden lg:block bg-white border border-fc-green/10 rounded-xl2 overflow-hidden">
        <ul class="divide-y divide-fc-green/5">
          @foreach($fcSidebarCats as $cat)
            <li>
              <a href="{{ route('store.shop') }}" class="flex items-center px-4 py-2.5 text-sm text-fc-ink hover:bg-fc-greenLight hover:text-fc-green">{{ $cat }}</a>
            </li>
          @endforeach
        </ul>
        <a href="{{ route('store.shop') }}" class="block m-3 text-center h-10 leading-10 bg-fc-green text-white text-xs font-bold rounded-full hover:bg-fc-greenDeep">
          {{ 'View All Categories' }}
        </a>
      </aside>

      <div class="relative overflow-hidden bg-white border border-fc-green/10 rounded-xl2 min-h-[380px] flex items-center">
        <div class="relative z-10 px-8 py-10 max-w-md">
          <h1 class="font-heading text-3xl md:text-4xl font-extrabold leading-tight text-fc-ink">
            <span>{{ $fcHeroLine1 }}</span><br>
            <span class="text-fc-green">{{ $fcHeroLine2 }}</span>
          </h1>
          <p class="mt-4 text-sm text-fc-inkSoft max-w-sm">{{ $fcHeroSubtitle }}</p>
          <div class="mt-6 flex flex-wrap items-center gap-3">
            <a href="{{ route('store.shop') }}" class="h-11 px-6 inline-flex items-center bg-fc-green text-white text-xs font-bold rounded-full hover:bg-fc-greenDeep">
              {{ 'Shop Fresh Produce' }}
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-11 px-6 inline-flex items-center bg-fc-orange text-white text-xs font-bold rounded-full hover:opacity-90">
              {{ 'View Weekly Deals' }}
            </a>
          </div>
          <div class="mt-6 flex items-center gap-4 text-[11px] font-semibold text-fc-inkSoft">
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>100% Fresh</span>
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>Best Prices</span>
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>On Time, Every Time</span>
          </div>
        </div>
        @if($fcHeroImg)
          <div class="hidden md:block absolute right-0 bottom-0 top-0 w-[45%]">
            <img src="{{ $fcHeroImg }}" alt="{{ $fcHeroTitle }}" class="w-full h-full object-cover">
          </div>
        @endif
        <span class="hidden md:flex absolute top-6 right-6 w-16 h-16 rounded-full bg-fc-green text-white text-[10px] font-bold items-center justify-center text-center leading-tight px-1 z-10">
          {{ 'Same Day Delivery' }}
        </span>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-6">
    <div class="bg-white border border-fc-green/10 rounded-full px-6 py-4 grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Same Day Delivery', 'sub' => 'On time, every time'],
        ['icon' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z', 'title' => 'Farm Fresh Quality', 'sub' => 'Sourced with care'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => 'No questions asked'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Payments', 'sub' => '100% safe checkout'],
        ['icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z', 'title' => 'Pickup Points', 'sub' => 'Across your city'],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center justify-center gap-2">
          <svg class="w-5 h-5 text-fc-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight text-left hidden md:inline">
            <span class="block text-xs font-bold text-fc-ink">{{ $item['title'] }}</span>
            <span class="block text-[10px] text-fc-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY GRID ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <div class="grid grid-cols-3 md:grid-cols-5 gap-3">
      @foreach($fcTiles as $tile)
        <a href="{{ route('store.shop') }}" class="group bg-white border border-fc-green/10 rounded-xl2 p-3 flex flex-col items-center text-center gap-2 hover:shadow-cardHover hover:border-fc-green/30 transition">
          <div class="w-16 h-16 rounded-full overflow-hidden bg-fc-greenLight">
            @if($tile['img'])
              <img src="{{ $tile['img'] }}" alt="{{ $tile['label'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
            @endif
          </div>
          <span class="text-xs font-semibold text-fc-ink">{{ $tile['label'] }}</span>
        </a>
      @endforeach
      <a href="{{ route('store.shop') }}" class="bg-fc-greenDeep rounded-xl2 p-3 flex flex-col items-center justify-center text-center gap-2 hover:opacity-90 transition">
        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        <span class="text-xs font-semibold text-white">{{ 'More Categories' }}</span>
      </a>
    </div>
  </section>

  {{-- ===== TODAY'S DEALS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 pb-10" x-data="{ h: 6, m: 45, s: 32 }" x-init="setInterval(() => { if (s > 0) { s--; } else if (m > 0) { m--; s = 59; } else if (h > 0) { h--; m = 59; s = 59; } }, 1000)">
      <div class="flex items-center justify-between mb-5">
        <h2 class="font-heading text-xl font-extrabold text-fc-ink flex items-center gap-2">
          <svg class="w-5 h-5 text-fc-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M13 2 3 14h7l-1 8 11-14h-7l1-6Z"/></svg>
          {{ "Today's Deals" }}
        </h2>
        <div class="flex items-center gap-2 text-xs font-bold text-fc-ink">
          <span class="hidden sm:inline text-fc-inkSoft font-medium">{{ 'Ends in' }}</span>
          <span class="bg-fc-greenDeep text-white rounded px-2 py-1" x-text="String(h).padStart(2,'0')"></span>:
          <span class="bg-fc-greenDeep text-white rounded px-2 py-1" x-text="String(m).padStart(2,'0')"></span>:
          <span class="bg-fc-greenDeep text-white rounded px-2 py-1" x-text="String(s).padStart(2,'0')"></span>
        </div>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($categorySpecificProducts->take(5) as $product)
          @include('store.themes.freshcart-daily.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== SHOP BY AISLE ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <h2 class="font-heading text-xl font-extrabold text-fc-ink mb-5">{{ 'Shop by Aisle' }}</h2>
    <div class="flex items-center gap-6 overflow-x-auto no-scrollbar">
      @foreach($fcAisles as $i => $aisle)
        <a href="{{ route('store.shop') }}" class="flex flex-col items-center gap-2 shrink-0 text-center w-20">
          <div class="w-14 h-14 rounded-full bg-fc-greenLight overflow-hidden flex items-center justify-center">
            @if($fcImgAt($i + 2))
              <img src="{{ $fcImgAt($i + 2) }}" class="w-full h-full object-cover">
            @else
              <svg class="w-6 h-6 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/></svg>
            @endif
          </div>
          <span class="text-[11px] font-semibold text-fc-ink leading-tight">{{ $aisle }}</span>
        </a>
      @endforeach
      <a href="{{ route('store.shop') }}" class="flex flex-col items-center gap-2 shrink-0 text-center w-20">
        <div class="w-14 h-14 rounded-full bg-fc-greenDeep flex items-center justify-center">
          <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        </div>
        <span class="text-[11px] font-semibold text-fc-ink leading-tight">{{ 'More Aisles' }}</span>
      </a>
    </div>
  </section>

  {{-- ===== PROMO BANNERS ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10 grid md:grid-cols-3 gap-4">
    <div class="rounded-xl2 p-6 flex items-center justify-between gap-3 bg-fc-orange/10">
      <div>
        <h3 class="font-heading font-extrabold text-fc-ink">{{ 'Save More with FreshCart Club' }}</h3>
        <p class="text-xs text-fc-inkSoft mt-1 max-w-[180px]">{{ 'Get exclusive offers, free delivery and extra benefits!' }}</p>
        <a href="{{ route('store.contact') }}" class="inline-flex mt-3 h-9 px-4 items-center bg-fc-green text-white text-xs font-bold rounded-full">{{ 'Join Now — It’s Free' }}</a>
      </div>
      <svg class="w-14 h-14 text-fc-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="12" r="10"/><path d="M9 12h6M12 9v6"/></svg>
    </div>
    <div class="rounded-xl2 p-6 flex items-center justify-between gap-3 bg-fc-greenDeep text-white">
      <div>
        <h3 class="font-heading font-extrabold">{{ 'Flat 10% OFF' }}</h3>
        <p class="text-xs text-white/70 mt-1">{{ 'On Your First Order' }}</p>
        <span class="inline-flex mt-3 h-9 px-4 items-center bg-white/15 text-white text-xs font-bold rounded-full border border-white/30">{{ 'Use Code: FRESH10' }}</span>
      </div>
    </div>
    <div class="rounded-xl2 p-6 flex items-center justify-between gap-3 bg-fc-green/10">
      <div>
        <h3 class="font-heading font-extrabold text-fc-ink">{{ 'Free Delivery' }}</h3>
        <p class="text-xs text-fc-inkSoft mt-1">{{ 'On Orders Above $50 — Limited time offer!' }}</p>
      </div>
    </div>
  </section>

  {{-- ===== BEST SELLERS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 pb-10">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading text-xl font-extrabold text-fc-ink">{{ 'Best Sellers' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold text-fc-green hover:underline inline-flex items-center gap-1">
          {{ 'View All' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.freshcart-daily.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="rounded-xl2 bg-fc-greenLight px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
      <div>
        <h3 class="font-heading text-xl font-extrabold text-fc-ink">{{ 'Join the FreshCart Family!' }}</h3>
        <p class="text-sm text-fc-inkSoft mt-1">{{ 'Be the first to get exclusive offers, new arrivals and healthy recipes straight to your inbox.' }}</p>
      </div>
      <form id="newsletterForm" class="flex w-full md:w-auto max-w-md gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 rounded-full border border-fc-green/25 bg-white text-sm focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-fc-green text-white text-xs font-bold rounded-full hover:bg-fc-greenDeep shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-fc-inkSoft"></div>
  </section>

</main>

@include('store.themes.freshcart-daily.partials.footer', ['categories' => $categories])
@include('store.themes.freshcart-daily.partials.mobile-nav')

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
        msg.className = 'text-sm mt-2 text-fc-green';
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
