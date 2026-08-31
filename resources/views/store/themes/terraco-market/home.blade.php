<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.terraco-market._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Terra & Co.') . ' — Fine Food Market'])
</head>
<body class="bg-tc-cream text-tc-ink antialiased">

@include('store.themes.terraco-market.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $tcHeroTitle = $s->hero_title ?? 'Discover the Art of Fine Food';
  $tcHeroSubtitle = $s->hero_subtitle ?? 'Premium ingredients sourced from the finest producers around the world.';
  $tcHeroImg = !empty($s->hero_image_path) ? global_asset($s->hero_image_path) : 'https://picsum.photos/seed/terraco-hero/1400/700';
  $tcTiles = [
    ['label' => 'Olive Oils & Vinegars', 'img' => 'https://picsum.photos/seed/terraco-oils/400/500'],
    ['label' => 'Artisan Cheese',        'img' => 'https://picsum.photos/seed/terraco-cheese/400/500'],
    ['label' => 'Gourmet Pantry',        'img' => 'https://picsum.photos/seed/terraco-pantry/400/500'],
    ['label' => 'Organic Beverages',     'img' => 'https://picsum.photos/seed/terraco-beverages/400/500'],
    ['label' => 'Gift Hampers',          'img' => 'https://picsum.photos/seed/terraco-hampers/400/500'],
  ];
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="relative overflow-hidden" style="min-height:520px;">
    <div class="absolute inset-0">
      <img src="{{ $tcHeroImg }}" alt="{{ $tcHeroTitle }}" class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 min-h-[520px] flex items-center">
      <div class="max-w-xl">
        <h1 class="font-serif text-4xl md:text-6xl leading-[0.95] text-white">
          <span class="block font-sans font-black uppercase tracking-tight">{{ \Illuminate\Support\Str::of($tcHeroTitle)->before(' ') }}</span>
          <span class="block tc-hero-italic">{{ \Illuminate\Support\Str::of($tcHeroTitle)->after(' ') }}</span>
        </h1>
        <p class="mt-5 text-white/80 max-w-md">{{ $tcHeroSubtitle }}</p>
        <div class="mt-8 flex flex-wrap items-center gap-3">
          <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center bg-tc-green text-white text-xs font-bold eyebrow hover:bg-tc-greenDeep">
            {{ 'Explore Products' }}
          </a>
          <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center border border-white/60 text-white text-xs font-bold eyebrow hover:bg-white/10">
            {{ 'Shop Collections' }}
          </a>
        </div>
      </div>
    </div>
    <div class="absolute bottom-6 left-4 flex items-center gap-2">
      <span class="w-6 h-1.5 rounded-full bg-white"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
      <span class="w-1.5 h-1.5 rounded-full bg-white/50"></span>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-tc-cream border-b border-tc-green/10">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-center md:text-left">
      @foreach([
        ['icon' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z', 'title' => 'Farm to Table', 'sub' => 'Sustainably sourced'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Payments', 'sub' => '100% safe & secure'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6 M2 7h20v5H2z M12 22V7 M7.5 7A2.5 2.5 0 1 1 10 4.5 2.5 2.5 0 0 1 12 7a2.5 2.5 0 1 1 2.5-2.5A2.5 2.5 0 0 1 14 7', 'title' => 'Gift Packaging', 'sub' => 'Beautifully packaged'],
        ['icon' => 'M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9 M13.73 21a2 2 0 0 1-3.46 0', 'title' => 'Customer Care', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-tc-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-tc-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-tc-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY TILES ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach($tcTiles as $tile)
        <a href="{{ route('store.shop') }}" class="group relative aspect-[4/5] overflow-hidden bg-tc-greenDeep">
          <img src="{{ $tile['img'] }}" alt="{{ $tile['label'] }}" class="w-full h-full object-cover opacity-70 group-hover:opacity-55 group-hover:scale-105 transition-all duration-300">
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-4">
            <h3 class="font-serif text-lg text-white leading-tight">{{ $tile['label'] }}</h3>
            <span class="mt-1 inline-flex items-center gap-1 text-[11px] font-bold eyebrow text-tc-gold">
              {{ __('messages.ShopNow') ?? 'Shop Now' }}
              <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== BEST SELLERS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-serif text-2xl text-tc-ink flex items-center gap-2">
          {{ 'Best Sellers' }}
          <svg class="w-5 h-5 text-tc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22c0-6 4-10 8-11-1 6-4 10-8 11Z"/><path d="M12 22c0-7-4-13-9-14 1 7 4 13 9 14Z"/></svg>
        </h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-tc-green hover:underline inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.terraco-market.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== PERFECT GIFT BANNER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="relative overflow-hidden bg-tc-greenDeep grid md:grid-cols-2 items-center">
      <div class="p-8 lg:p-12 text-white">
        <h2 class="font-serif text-3xl">{{ 'The Perfect Gift' }}</h2>
        <p class="mt-2 text-white/70 max-w-sm">{{ 'Curated hampers for every occasion.' }}</p>
        <a href="{{ route('store.shop') }}" class="mt-6 inline-flex h-11 px-6 items-center bg-tc-goldSoft text-tc-greenDeep text-xs font-bold eyebrow hover:bg-tc-gold hover:text-white">
          {{ 'Shop Gift Hampers' }}
        </a>
        <div class="mt-8 grid grid-cols-2 gap-4 max-w-sm">
          @foreach([
            ['icon' => 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z', 'label' => 'Premium Selection'],
            ['icon' => 'M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6 M2 7h20v5H2z M12 22V7', 'label' => 'Elegant Packaging'],
            ['icon' => 'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76Z', 'label' => 'Custom Options'],
            ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'label' => 'Nationwide Delivery'],
          ] as $item)
            <div class="flex items-center gap-2 text-xs text-white/80">
              <svg class="w-4 h-4 text-tc-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
              {{ $item['label'] }}
            </div>
          @endforeach
        </div>
      </div>
      <div class="hidden md:block h-full min-h-[280px]">
        <img src="https://picsum.photos/seed/terraco-gift/700/500" alt="Gift hamper" class="w-full h-full object-cover">
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="border border-tc-green/15 bg-tc-creamDark/40 px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
      <div>
        <h3 class="font-serif text-xl text-tc-ink">{{ 'Join Our Foodie Community' }}</h3>
        <p class="text-sm text-tc-inkSoft mt-1">{{ 'Get exclusive offers, new arrivals, and delicious recipes straight to your inbox.' }}</p>
      </div>
      <form id="newsletterForm" class="flex w-full md:w-auto max-w-md gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 border border-tc-green/25 bg-white text-sm focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-tc-green text-white text-xs font-bold eyebrow hover:bg-tc-greenDeep shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-tc-inkSoft"></div>
  </section>

</main>

@include('store.themes.terraco-market.partials.footer', ['categories' => $categories])
@include('store.themes.terraco-market.partials.mobile-nav')

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
        msg.className = 'text-sm mt-2 text-tc-green';
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
