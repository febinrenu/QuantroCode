<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.futurex-tech._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'FutureX') . ' — Tech Store'])
</head>
<body class="bg-fx-cream text-fx-ink antialiased font-sans">

@include('store.themes.futurex-tech.partials.header', ['categories' => $categories])

@php
  $fxHeroEyebrow = 'Power Up Your World';
  $fxHeroTitle = $s->hero_title ?? 'Next Gen Technology';
  $fxHeroSubtitle = $s->hero_subtitle ?? 'For work, play and everything in between.';
  $fxImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $fxHeroImg = $fxImgs[0] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);

  $fxSubcatsHome = optional($categories->first())->subcategories ?? collect();
  $fxSubIdHome = fn ($name) => optional($fxSubcatsHome->firstWhere('name', $name))->id;

  $fxSidebarIcons = [
    'Laptops & Computers' => 'M4 4h16v10H4z M2 18h20 M9 18v2h6v-2',
    'Smartphones & Tablets' => 'M7 2h10v20H7z M11 18h2',
    'Wearables' => 'M12 8v4l3 2 M9 3h6l1 4H8l1-4Z M8 17h8l-1 4H9l-1-4Z M12 8a5 5 0 1 0 0 10 5 5 0 0 0 0-10Z',
    'Audio & Headphones' => 'M4 14v-2a8 8 0 0 1 16 0v2 M2 14h4v6H4a2 2 0 0 1-2-2v-4Z M18 14h4v4a2 2 0 0 1-2 2h-2v-6Z',
    'Gaming' => 'M6 8h12l2 8a2 2 0 0 1-2 2.5c-1 0-1.5-.5-2-1.5l-1-2H9l-1 2c-.5 1-1 1.5-2 1.5A2 2 0 0 1 4 16Z M8 10v4 M6 12h4 M16 10h.01 M18 12h.01',
    'Cameras & Drones' => 'M4 8h3l2-2h6l2 2h3v11H4Z M12 17a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z',
  ];
  $fxSidebarLinks = collect(array_keys($fxSidebarIcons))
    ->filter(fn ($name) => $fxSubIdHome($name))
    ->map(fn ($name) => ['label' => $name, 'icon' => $fxSidebarIcons[$name], 'href' => route('store.shop', ['sub_category' => $fxSubIdHome($name)])])
    ->values();

  $fxTileMap = [
    ['Gaming', 'bg-fx-navy', 'text-white', 'Level up your gaming experience.'],
    ['Smartphones & Tablets', 'bg-blue-50', 'text-fx-ink', 'Stay connected with innovation.'],
    ['Audio & Headphones', 'bg-emerald-50', 'text-fx-ink', 'Premium sound for every moment.'],
    ['Wearables', 'bg-orange-50', 'text-fx-ink', 'Health, fitness & smart features.'],
  ];
  $fxTiles = collect($fxTileMap)->filter(fn ($t) => $fxSubIdHome($t[0]))->values();
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== SIDEBAR + HERO ===== --}}
  <section class="max-w-7xl mx-auto px-4 pt-4">
    <div class="grid lg:grid-cols-[260px_1fr] gap-4">
      <aside class="hidden lg:block bg-white border border-fx-ink/10 rounded-lg overflow-hidden">
        <ul class="py-1">
          @foreach($fxSidebarLinks as $link)
            <li>
              <a href="{{ $link['href'] }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-fx-ink hover:bg-fx-cream hover:text-fx-purple">
                <svg class="w-4 h-4 shrink-0 text-fx-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $link['icon'] }}"/></svg>
                {{ $link['label'] }}
                <svg class="w-3.5 h-3.5 ms-auto opacity-40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </a>
            </li>
          @endforeach
        </ul>
        <a href="{{ route('store.shop') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold text-fx-purple border-t border-fx-ink/10 hover:bg-fx-cream">
          {{ 'View All Categories' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </aside>

      <div class="relative overflow-hidden bg-fx-hero rounded-lg" style="min-height:420px;">
        <div class="absolute inset-0 opacity-40" style="background:radial-gradient(circle at 65% 45%, #3F8CFF33, transparent 60%);"></div>
        <div class="relative px-8 md:px-12 py-14 md:py-16 grid md:grid-cols-2 items-center gap-6 h-full">
          <div>
            <span class="eyebrow text-fx-cyan text-xs font-bold">{{ $fxHeroEyebrow }}</span>
            <h1 class="font-heading font-extrabold text-3xl md:text-5xl leading-tight text-white mt-3">{{ $fxHeroTitle }}</h1>
            <p class="mt-4 text-white/60 max-w-sm">{{ $fxHeroSubtitle }}</p>
            <div class="mt-7">
              <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center gap-2 bg-fx-badge text-white text-sm font-bold rounded-full hover:opacity-90">
                {{ 'Explore Now' }}
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
          </div>
          <div class="relative flex items-center justify-center">
            @if($fxHeroImg)
              <div class="w-56 h-56 md:w-64 md:h-64 rounded-full overflow-hidden border-2 border-fx-cyan/40" style="box-shadow:0 0 60px 10px #3F8CFF22;">
                <img src="{{ $fxHeroImg }}" alt="{{ $fxHeroTitle }}" class="w-full h-full object-cover">
              </div>
            @endif
            <div class="absolute -top-2 right-4 md:right-8 w-20 h-20 rounded-full bg-white text-fx-purpleDeep flex flex-col items-center justify-center text-center leading-tight shadow-cardHover">
              <span class="text-[9px] font-bold eyebrow">{{ 'Up to' }}</span>
              <span class="text-lg font-heading font-extrabold">45%</span>
              <span class="text-[9px] font-bold eyebrow">{{ 'Off' }}</span>
            </div>
          </div>
        </div>
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
          @for($i=0;$i<4;$i++)
            <span class="{{ $i === 0 ? 'w-6 bg-fx-cyan' : 'w-1.5 bg-white/40' }} h-1.5 rounded-full"></span>
          @endfor
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="border border-fx-ink/10 rounded-lg bg-white grid grid-cols-2 md:grid-cols-5 gap-6 px-6 py-5 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Next-Day Delivery', 'sub' => 'On orders over $50'],
        ['icon' => 'm9 12 2 2 4-4 M20.5 7.3A10 10 0 0 1 12 22a10 10 0 0 1-8.5-14.7L12 2l8.5 5.3Z', 'title' => 'Secure Payments', 'sub' => '100% secure checkout'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30-day return policy'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Warranty & Support', 'sub' => 'Official product warranty'],
        ['icon' => 'M3 18v-6a9 9 0 0 1 18 0v6 M21 19a2 2 0 0 1-2 2h-1v-8h3zM3 19a2 2 0 0 0 2 2h1v-8H3z', 'title' => '24/7 Customer Care', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-fx-purple shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-fx-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-fx-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== CATEGORY TILES ===== --}}
  @if($fxTiles->count())
    <section class="max-w-7xl mx-auto px-4 py-2">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        @foreach($fxTiles as $i => [$subName, $bgClass, $textClass, $tileDesc])
          @php $tImg = $subcategoryImages[$subName] ?? ($fxImgs->count() ? $fxImgs[$i % $fxImgs->count()] : null); @endphp
          <a href="{{ route('store.shop', ['sub_category' => $fxSubIdHome($subName)]) }}" class="group rounded-lg p-5 flex flex-col justify-between min-h-[230px] {{ $bgClass }}">
            <div>
              <h3 class="font-heading font-bold text-lg leading-tight {{ $textClass }}">{{ $subName }}</h3>
              <p class="text-[11px] mt-1 {{ $textClass === 'text-white' ? 'text-white/60' : 'text-fx-inkSoft' }}">{{ $tileDesc }}</p>
              <span class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold {{ $textClass === 'text-white' ? 'text-fx-cyan' : 'text-fx-purple' }} group-hover:underline">
                {{ 'Shop Now' }}
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </span>
            </div>
            @if($tImg)
              <img src="{{ $tImg }}" alt="{{ $subName }}" class="w-24 h-24 object-cover rounded-md self-end mt-2 shadow-card">
            @endif
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== DEAL OF THE DAY ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="rounded-lg bg-fx-badge px-6 py-6 flex flex-wrap items-center gap-5 justify-between overflow-hidden relative">
      <div class="flex items-center gap-4 relative z-10">
        <svg class="w-8 h-8 text-white shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2 3 14h7l-1 8 11-14h-8l1-6Z"/></svg>
        <div>
          <h3 class="font-heading font-bold text-xl text-white">{{ 'Deal of the Day' }}</h3>
          <p class="text-xs text-white/70">{{ 'Limited time offer on selected items' }}</p>
        </div>
      </div>
      <div class="flex items-center gap-2 relative z-10">
        @foreach([['12','Hrs'],['34','Mins'],['56','Secs']] as [$num, $label])
          <div class="w-16 h-14 rounded-md bg-white/15 border border-white/25 flex flex-col items-center justify-center">
            <span class="text-white font-heading font-bold text-lg leading-none">{{ $num }}</span>
            <span class="text-[9px] text-white/60 mt-0.5 uppercase">{{ $label }}</span>
          </div>
        @endforeach
      </div>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-11 px-6 inline-flex items-center bg-white text-fx-purpleDeep text-sm font-bold rounded-md hover:bg-fx-cream relative z-10">
        {{ 'Shop Deals' }}
      </a>
      @if($fxImgs->last())
        <img src="{{ $fxImgs->last() }}" alt="Deal of the day" class="hidden lg:block absolute right-0 bottom-0 w-40 h-40 object-cover opacity-30 rounded-tl-lg">
      @endif
    </div>
  </section>

  {{-- ===== BEST SELLERS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading font-bold text-2xl text-fx-ink eyebrow">{{ 'Best Sellers' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold text-fx-purple hover:underline inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.futurex-tech.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TOP BRANDS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex flex-wrap items-center justify-between gap-y-4 border-y border-fx-ink/10 py-5">
      @foreach(['Apple','SAMSUNG','SONY','BOSE','dji','DELL','logitech'] as $brand)
        <span class="text-fx-ink/60 font-heading font-bold text-lg tracking-wide">{{ $brand }}</span>
      @endforeach
    </div>
  </section>

  {{-- ===== NEWSLETTER / APP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="rounded-lg bg-fx-navy grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-white/10 overflow-hidden">
      <div class="p-8 flex items-center gap-4">
        <span class="w-12 h-12 rounded-full bg-fx-badge text-white flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>
        </span>
        <div class="flex-1 min-w-0">
          <h3 class="font-heading font-bold text-lg text-white">{{ 'Get Exclusive Access' }}</h3>
          <p class="text-xs text-white/50 mt-1">{{ 'Subscribe to our newsletter and get 10% off your first order.' }}</p>
          <form id="newsletterForm" class="flex mt-3 gap-2 max-w-sm">
            @csrf
            <input name="email" type="email" id="newsletterEmail" class="flex-1 h-11 px-3 border border-white/20 bg-white/10 text-white placeholder-white/40 text-sm rounded-md focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
            <button id="newsletterBtn" type="submit" class="h-11 px-5 bg-fx-purple text-white text-xs font-bold rounded-md hover:bg-fx-purpleDeep shrink-0">{{ __('messages.Subscribe') }}</button>
          </form>
          <div id="newsletterMsg" class="text-xs mt-2 text-white/50"></div>
        </div>
      </div>
      <div class="p-8 flex items-center gap-4">
        <span class="w-12 h-12 rounded-full bg-fx-badge text-white flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12" y2="18"/></svg>
        </span>
        <div class="flex-1 min-w-0">
          <h3 class="font-heading font-bold text-lg text-white">{{ 'Shop on the Go' }}</h3>
          <p class="text-xs text-white/50 mt-1">{{ 'Download our app and get exclusive app-only offers.' }}</p>
          <a href="#" class="mt-3 inline-flex h-11 px-5 items-center bg-white text-fx-purpleDeep text-xs font-bold rounded-md hover:bg-fx-cream">
            {{ 'Download App' }}
          </a>
        </div>
      </div>
    </div>
  </section>

</main>

@include('store.themes.futurex-tech.partials.footer', ['categories' => $categories])
@include('store.themes.futurex-tech.partials.mobile-nav')

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
        msg.className = 'text-xs mt-2 text-fx-cyan';
        msg.textContent = @json(__('messages.NewsletterThanks'));
        emailInput.value = '';
      } else {
        msg.className = 'text-xs mt-2 text-red-400';
        msg.textContent = data.message || @json(__('messages.NewsletterFailed'));
      }
    } catch (err) {
      msg.className = 'text-xs mt-2 text-red-400';
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
