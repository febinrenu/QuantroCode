<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.elegance-boutique._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Élégance') . ' — Timeless Fashion'])
</head>
<body class="bg-el-cream text-el-ink antialiased">

@include('store.themes.elegance-boutique.partials.header', ['categories' => $categories])

@php
  $elHeroEyebrow = 'Summer Collection \'24';
  $elHeroTitle = $s->hero_title ?? 'Define Your Signature Style';
  $elHeroSubtitle = $s->hero_subtitle ?? 'Elevate your wardrobe with modern pieces that speak elegance.';
  $elHeroSplit = \Illuminate\Support\Str::of($elHeroTitle)->explode(' ');
  $elHeroFirst = $elHeroSplit->slice(0, ceil($elHeroSplit->count()/2))->implode(' ');
  $elHeroRest = $elHeroSplit->slice(ceil($elHeroSplit->count()/2))->implode(' ');
  $elImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $elHeroImg = $elImgs[0] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);
  $elHomeSubcats = optional($categories->first())->subcategories ?? collect();
  $elHomeSubcatId = fn ($name) => optional($elHomeSubcats->firstWhere('name', $name))->id;
  $elTiles = collect(['Women', 'Men', 'Shoes', 'Bags', 'Accessories'])
    ->filter(fn ($name) => $elHomeSubcatId($name))
    ->map(fn ($name) => ['label' => $name, 'sub_category' => $elHomeSubcatId($name)])
    ->values();
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="bg-el-black">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2">
      <div class="px-6 md:px-12 py-16 md:py-20 flex flex-col justify-center">
        <span class="eyebrow text-el-gold text-xs font-bold">{{ $elHeroEyebrow }}</span>
        <h1 class="font-serif text-4xl md:text-6xl leading-[1.05] text-white mt-4">
          <span class="block">{{ $elHeroFirst }}</span>
          <span class="block el-script">{{ $elHeroRest }}</span>
        </h1>
        <p class="mt-5 text-white/60 max-w-sm">{{ $elHeroSubtitle }}</p>
        <div class="mt-8 flex flex-wrap items-center gap-3">
          <a href="{{ route('store.shop', $elHomeSubcatId('Women') ? ['sub_category' => $elHomeSubcatId('Women')] : []) }}" class="h-12 px-7 inline-flex items-center bg-el-gold text-el-black text-xs font-bold eyebrow hover:bg-white">
            {{ 'Shop Women' }}
          </a>
          <a href="{{ route('store.shop', $elHomeSubcatId('Men') ? ['sub_category' => $elHomeSubcatId('Men')] : []) }}" class="h-12 px-7 inline-flex items-center border border-white/50 text-white text-xs font-bold eyebrow hover:bg-white/10">
            {{ 'Shop Men' }}
          </a>
        </div>
        <div class="mt-10 flex items-center gap-2 text-white/40 text-[11px] font-semibold">
          <span>01</span>
          <span class="w-16 h-px bg-el-gold"></span>
          <span>03</span>
        </div>
      </div>
      <div class="relative min-h-[360px] md:min-h-[560px]">
        @if($elHeroImg)
          <img src="{{ $elHeroImg }}" alt="{{ $elHeroTitle }}" class="w-full h-full object-cover absolute inset-0">
        @endif
        <div class="absolute top-6 right-6 md:top-10 md:right-10 w-24 h-24 rounded-full border-2 border-el-gold bg-el-black/70 backdrop-blur flex flex-col items-center justify-center text-el-gold text-center leading-tight">
          <span class="text-[9px] font-bold eyebrow">{{ 'Up to' }}</span>
          <span class="text-xl font-serif font-bold">50%</span>
          <span class="text-[9px] font-bold eyebrow">{{ 'Off' }}</span>
        </div>
        <div class="absolute bottom-6 right-6 flex items-center gap-2">
          <span class="w-9 h-9 rounded-full bg-el-black/70 backdrop-blur inline-flex items-center justify-center text-white">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
          </span>
          <span class="w-9 h-9 rounded-full bg-el-black/70 backdrop-blur inline-flex items-center justify-center text-white">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </span>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-el-cream border-b border-el-ink/10">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-5 gap-6 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Free Shipping', 'sub' => 'On orders over $100'],
        ['icon' => 'm9 12 2 2 4-4 M20.5 7.3A10 10 0 0 1 12 22a10 10 0 0 1-8.5-14.7L12 2l8.5 5.3Z', 'title' => 'Secure Payment', 'sub' => '100% secure checkout'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'M2 20h20 M12 2 3 8l9-2 9 2-9-6Z M5 20V10 M19 20V10 M9 20v-5h6v5', 'title' => 'Premium Quality', 'sub' => 'Handpicked with care'],
        ['icon' => 'M3 18v-6a9 9 0 0 1 18 0v6 M21 19a2 2 0 0 1-2 2h-1v-8h3zM3 19a2 2 0 0 0 2 2h1v-8H3z', 'title' => '24/7 Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-el-ink shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-el-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-el-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY TILES ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach($elTiles as $i => $tile)
        @php $tImg = $subcategoryImages[$tile['label']] ?? ($elImgs->count() ? $elImgs[$i % $elImgs->count()] : null); @endphp
        <a href="{{ route('store.shop', ['sub_category' => $tile['sub_category']]) }}" class="group relative aspect-[4/5] overflow-hidden bg-el-ink">
          @if($tImg)
            <img src="{{ $tImg }}" alt="{{ $tile['label'] }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-60 group-hover:scale-105 transition-all duration-300">
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/5 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-4">
            <h3 class="font-serif text-lg text-white leading-tight uppercase">{{ $tile['label'] }}</h3>
            <span class="text-[9px] eyebrow text-white/60">{{ 'Collection' }}</span>
            <a href="{{ route('store.shop', ['sub_category' => $tile['sub_category']]) }}" class="mt-2 inline-flex h-7 px-3 items-center border border-white/70 text-white text-[10px] font-bold eyebrow hover:bg-white hover:text-el-black">
              {{ 'Shop Now' }}
            </a>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== NEW IN ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5 border-b border-el-ink/10 pb-3">
        <h2 class="font-serif text-2xl text-el-ink flex items-center gap-2">
          <span class="w-6 h-px bg-el-gold hidden md:inline-block"></span>
          {{ 'New In' }}
        </h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-el-ink hover:text-el-gold inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-x-4 gap-y-6">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.elegance-boutique.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== BRAND STRIP ===== --}}
  <section class="bg-el-black py-6 mt-4">
    <div class="max-w-7xl mx-auto px-4 flex flex-wrap items-center justify-between gap-6">
      @foreach(['ZARA','MANGO','BOSS','GUESS','Calvin Klein','MICHAEL KORS','TED BAKER'] as $brand)
        <span class="text-white/50 font-serif text-lg tracking-wide">{{ $brand }}</span>
      @endforeach
    </div>
  </section>

  {{-- ===== TWO-COLUMN BANNER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid md:grid-cols-2 gap-4">
      <div class="relative overflow-hidden bg-el-ink min-h-[280px] flex items-end">
        @php $elMinimalImg = $elImgs[1] ?? ($elImgs[0] ?? null); @endphp
        @if($elMinimalImg)
          <img src="{{ $elMinimalImg }}" alt="The Art of Minimalism" class="absolute inset-0 w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="relative p-8 text-white">
          <h3 class="font-serif text-2xl">{{ 'The Art of Minimalism' }}</h3>
          <p class="mt-1 text-white/70 max-w-xs text-sm">{{ 'Discover pieces that make simplicity look extraordinary.' }}</p>
          <a href="{{ route('store.shop') }}" class="mt-5 inline-flex h-11 px-6 items-center bg-white text-el-black text-xs font-bold eyebrow hover:bg-el-gold">
            {{ 'Explore Editorial' }}
          </a>
        </div>
      </div>
      <div class="relative overflow-hidden bg-el-creamDark min-h-[280px] grid md:grid-cols-2 items-center">
        <div class="p-8">
          <h3 class="font-serif text-2xl text-el-ink">{{ 'Timeless Accessories' }}</h3>
          <p class="mt-1 text-el-inkSoft max-w-xs text-sm">{{ 'The finishing touches that complete your look.' }}</p>
          <a href="{{ route('store.shop', $elHomeSubcatId('Accessories') ? ['sub_category' => $elHomeSubcatId('Accessories')] : []) }}" class="mt-5 inline-flex h-11 px-6 items-center bg-el-black text-white text-xs font-bold eyebrow hover:bg-el-gold hover:text-el-black">
            {{ 'Shop Accessories' }}
          </a>
        </div>
        @php $elAccessoryImg = $elImgs->last(); @endphp
        @if($elAccessoryImg)
          <div class="hidden md:block h-full min-h-[280px]">
            <img src="{{ $elAccessoryImg }}" alt="Accessories" class="w-full h-full object-cover">
          </div>
        @endif
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="border border-el-ink/15 bg-white px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="flex items-center gap-4">
        <span class="w-14 h-14 rounded-full border border-el-gold flex items-center justify-center shrink-0 text-el-gold">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>
        </span>
        <div>
          <h3 class="font-serif text-xl text-el-ink">{{ 'Be the First to Know' }}</h3>
          <p class="text-sm text-el-inkSoft mt-1">{{ 'Subscribe to get special offers, free giveaways, and once-in-a-lifetime deals.' }}</p>
        </div>
      </div>
      <form id="newsletterForm" class="flex w-full md:w-auto max-w-md gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 border border-el-ink/20 bg-el-cream text-sm focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-el-black text-white text-xs font-bold eyebrow hover:bg-el-gold hover:text-el-black shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-el-inkSoft"></div>
  </section>

</main>

@include('store.themes.elegance-boutique.partials.footer', ['categories' => $categories])
@include('store.themes.elegance-boutique.partials.mobile-nav')

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
        msg.className = 'text-sm mt-2 text-el-gold';
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
