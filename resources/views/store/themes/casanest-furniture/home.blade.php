<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.casanest-furniture._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'CasaNest') . ' — Design a Home You Love'])
</head>
<body class="bg-cn-cream text-cn-ink antialiased">

@include('store.themes.casanest-furniture.partials.header', ['categories' => $categories])

@php
  $cnHeroEyebrow = 'Timeless Comfort';
  $cnHeroTitle = $s->hero_title ?? 'Design a Home You Love';
  $cnHeroSubtitle = $s->hero_subtitle ?? 'Thoughtful furniture. Beautiful spaces. Made for the way you live.';
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $cnHeroImg = $categorySpecificProducts->first()['image_url'] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);
  $cnImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $cnImgAt = fn ($i) => $cnImgs->count() ? $cnImgs[$i % $cnImgs->count()] : null;

  $cnSubcats = optional($categories->first())->subcategories ?? collect();
  $cnSubcatId = fn ($name) => optional($cnSubcats->firstWhere('name', $name))->id;
  $cnRoomTiles = collect(['Living Room', 'Bedroom', 'Dining Room', 'Office', 'Lighting', 'Storage'])
    ->values()
    ->map(fn ($name, $i) => ['label' => $name, 'sub_category' => $cnSubcatId($name), 'img' => $cnImgAt($i)]);

  $cnStyles = ['Scandinavian', 'Modern Minimal', 'Japandi', 'Industrial', 'Contemporary'];

  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

  // Role-tagged Collections -- when a merchant has assigned a dedicated
  // "Best Sellers" Collection, its curated products win over the generic
  // $categorySpecificProducts slice for that section.
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $roleVms = collect($collectionsByRole ?? [])->map(function ($r) use ($currency, $hidePrices) {
      return collect($r['products'] ?? [])->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices))->values();
  });
  $bestSellersProducts = ($roleVms['best_sellers'] ?? collect())->count() ? $roleVms['best_sellers'] : $categorySpecificProducts->take(5);
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  @php $cfHeroSlides = $heroSlides ?? []; @endphp
  <section class="relative max-w-7xl mx-auto px-4 py-6 grid"
           x-data="{ cfHero: 0, cfHeroCount: {{ count($cfHeroSlides) }} }"
           @if(count($cfHeroSlides) > 1) x-init="setInterval(() => { cfHero = (cfHero + 1) % cfHeroCount }, 6000)" @endif>
    @foreach($cfHeroSlides as $cfI => $cfSlide)
      <div x-show="cfHero === {{ $cfI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1 grid md:grid-cols-2 gap-8 items-center">
        <div class="relative aspect-[4/3] md:aspect-[6/5] overflow-hidden bg-cn-creamDark order-2 md:order-1">
          @php $cfHeroImg = !empty($cfSlide['image_url']) ? $cfSlide['image_url'] : $cnHeroImg; @endphp
          @if($cfHeroImg)
            <img src="{{ $cfHeroImg }}" alt="{{ ($cfSlide['title'] ?? '') !== '' ? $cfSlide['title'] : $cnHeroTitle }}" class="w-full h-full object-cover">
          @endif
        </div>
        <div class="order-1 md:order-2">
          <span class="eyebrow text-cn-olive text-xs font-bold">{{ $cnHeroEyebrow }}</span>
          <h1 class="font-serif text-4xl md:text-5xl leading-[1.1] text-cn-ink mt-3">{{ ($cfSlide['title'] ?? '') !== '' ? $cfSlide['title'] : $cnHeroTitle }}</h1>
          <p class="mt-5 text-cn-inkSoft max-w-md">{{ ($cfSlide['subtitle'] ?? '') !== '' ? $cfSlide['subtitle'] : $cnHeroSubtitle }}</p>
          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="{{ ($cfSlide['cta_link'] ?? '') !== '' ? $cfSlide['cta_link'] : ($cnSubcatId('Living Room') ? route('store.shop', ['sub_category' => $cnSubcatId('Living Room')]) : route('store.shop')) }}" class="h-12 px-7 inline-flex items-center bg-cn-olive text-white text-xs font-bold eyebrow hover:bg-cn-oliveDeep">
              {{ ($cfSlide['cta_text'] ?? '') !== '' ? $cfSlide['cta_text'] : 'Shop Living Room' }}
            </a>
            <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center border border-cn-olive/40 text-cn-ink text-xs font-bold eyebrow hover:bg-cn-creamDark">
              {{ 'Explore Collection' }}
            </a>
          </div>
        </div>
      </div>
    @endforeach

    @if(count($cfHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($cfHeroSlides as $cfI => $cfSlide)
          <button type="button" @click="cfHero = {{ $cfI }}" class="w-2 h-2 rounded-full transition-colors" :class="cfHero === {{ $cfI }} ? 'bg-cn-olive' : 'bg-cn-olive/30'" aria-label="Slide {{ $cfI + 1 }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="bg-cn-cream border-y border-cn-olive/10">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'White-Glove Delivery', 'sub' => 'Carefully delivered to your door'],
        ['icon' => 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z', 'title' => 'Curated Design', 'sub' => 'Handpicked pieces for every home'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Checkout', 'sub' => 'Safe, encrypted & trusted payments'],
        ['icon' => 'M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76Z', 'title' => 'Assembly Support', 'sub' => 'Expert help for a seamless setup'],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-cn-olive shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-cn-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-cn-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== SHOP BY ROOM ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-end justify-between mb-5">
      <h2 class="font-serif text-2xl text-cn-ink">{{ 'Shop by Room' }}</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-cn-olive hover:underline">{{ 'View All Rooms' }} &rarr;</a>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
      @foreach($cnRoomTiles as $tile)
        <a href="{{ $tile['sub_category'] ? route('store.shop', ['sub_category' => $tile['sub_category']]) : route('store.shop') }}" class="group relative aspect-[4/5] overflow-hidden bg-cn-oliveDeep">
          @if($tile['img'])
            <img src="{{ $tile['img'] }}" alt="{{ $tile['label'] }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-60 group-hover:scale-105 transition-all duration-300">
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-3">
            <h3 class="text-xs md:text-sm font-bold text-white leading-tight">{{ $tile['label'] }}</h3>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== FEATURED COLLECTION ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-1">
        <div>
          <h2 class="font-serif text-2xl text-cn-ink">{{ 'Featured Collection' }}</h2>
          <p class="text-sm text-cn-inkSoft">{{ 'New pieces. Inspired spaces.' }}</p>
        </div>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-cn-olive hover:underline">{{ 'View All' }} &rarr;</a>
      </div>
      <div class="mt-5 flex gap-4 overflow-x-auto no-scrollbar pb-2">
        @foreach($categorySpecificProducts as $product)
          <div class="w-48 shrink-0">
            @include('store.themes.casanest-furniture.partials.product-card', ['product' => $product])
          </div>
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== NATURAL MATERIALS BANNER (fully customizable via Banners: image, badge, headline, subtitle, button, colors) ===== --}}
  @if($bannerGridEnabled ?? true)
  @php
    // A banner's own bg_color/bg_color_2/text_color (set in the Banners admin)
    // override each tile's fixed gradient/text color; absent -> theme default.
    $bannerOverlayStyle = function ($b) {
      if (!$b || empty($b->bg_color)) return null;
      $css = !empty($b->bg_color_2)
        ? "background:linear-gradient(to top, {$b->bg_color}b3, {$b->bg_color_2}33, transparent);"
        : "background:linear-gradient(to top, {$b->bg_color}b3, {$b->bg_color}33, transparent);";
      return $css;
    };
    $bannerTextStyle = function ($b) {
      return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
    };
    $cnTopLeft = ($byPos['top_left'] ?? collect())->first();
    $cnTopRight = ($byPos['top_right'] ?? collect())->first();
    $cnCenterLeft = ($byPos['center_left'] ?? collect())->first();
    $cnBannerImg = $cnTopLeft ? $bannerUrl($cnTopLeft) : $cnImgAt(1);
  @endphp
  <section class="max-w-7xl mx-auto px-4 py-6 grid md:grid-cols-[1.4fr_1fr] gap-4">
    <a href="{{ $cnTopLeft ? ($cnTopLeft->link ?: route('store.shop')) : route('store.shop') }}" class="relative overflow-hidden bg-cn-oliveDeep min-h-[280px] flex items-end">
      @if($cnBannerImg)
        <img src="{{ $cnBannerImg }}" alt="Natural Materials" class="absolute inset-0 w-full h-full object-cover opacity-70">
      @endif
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent" @if($bannerOverlayStyle($cnTopLeft)) style="{{ $bannerOverlayStyle($cnTopLeft) }}" @endif></div>
      <div class="relative p-8 text-white" @if($bannerTextStyle($cnTopLeft)) style="{{ $bannerTextStyle($cnTopLeft) }}" @endif>
        <span class="eyebrow text-xs font-bold text-cn-tanSoft" style="color:inherit;">{{ ($cnTopLeft->badge_text ?? null) ?: 'The Art of Living' }}</span>
        <h3 class="font-serif text-3xl mt-2 leading-tight" style="color:inherit;">{{ ($cnTopLeft->title ?? null) ?: 'Natural Materials. Lasting Beauty.' }}</h3>
        <p class="text-white/70 text-sm mt-2 max-w-xs" style="color:inherit;">{{ ($cnTopLeft->subtitle ?? null) ?: 'Crafted from solid wood, natural stone, and premium textiles — designed to be loved for years.' }}</p>
        <span class="mt-4 inline-flex h-10 px-5 items-center bg-cn-tan text-white text-xs font-bold eyebrow hover:opacity-90">{{ ($cnTopLeft->button_text ?? null) ?: 'Shop the Look' }} &rarr;</span>
      </div>
    </a>
    <div class="grid grid-rows-2 gap-4">
      <a href="{{ $cnTopRight ? ($cnTopRight->link ?: route('store.shop')) : route('store.shop') }}" class="relative overflow-hidden bg-cn-creamDark p-6 flex flex-col justify-center" @if($bannerOverlayStyle($cnTopRight)) style="{{ $bannerOverlayStyle($cnTopRight) }}" @endif>
        @if($cnTopRight && $cnTopRight->image_url)
          <img src="{{ $bannerUrl($cnTopRight) }}" alt="{{ $cnTopRight->title }}" class="absolute inset-0 w-full h-full object-cover">
          <div class="absolute inset-0 bg-cn-creamDark/80"></div>
        @endif
        <div class="relative" @if($bannerTextStyle($cnTopRight)) style="{{ $bannerTextStyle($cnTopRight) }}" @endif>
          <h4 class="font-serif text-lg text-cn-ink" style="color:inherit;">{{ ($cnTopRight->title ?? null) ?: 'Layer Your Space with Textures' }}</h4>
          <span class="mt-2 inline-flex text-xs font-bold eyebrow text-cn-olive hover:underline" style="color:inherit;">{{ ($cnTopRight->button_text ?? null) ?: 'Shop Rugs' }} &rarr;</span>
        </div>
      </a>
      <a href="{{ $cnCenterLeft ? ($cnCenterLeft->link ?: route('store.shop')) : route('store.shop') }}" class="relative overflow-hidden bg-cn-oliveDeep text-white p-6 flex flex-col justify-center" @if($bannerOverlayStyle($cnCenterLeft)) style="{{ $bannerOverlayStyle($cnCenterLeft) }}" @endif>
        @if($cnCenterLeft && $cnCenterLeft->image_url)
          <img src="{{ $bannerUrl($cnCenterLeft) }}" alt="{{ $cnCenterLeft->title }}" class="absolute inset-0 w-full h-full object-cover">
          <div class="absolute inset-0 bg-cn-oliveDeep/80"></div>
        @endif
        <div class="relative" @if($bannerTextStyle($cnCenterLeft)) style="{{ $bannerTextStyle($cnCenterLeft) }}" @endif>
          <h4 class="font-serif text-lg" style="color:inherit;">{{ ($cnCenterLeft->title ?? null) ?: 'Outdoor Living Reimagined' }}</h4>
          <span class="mt-2 inline-flex text-xs font-bold eyebrow text-cn-tanSoft hover:underline" style="color:inherit;">{{ ($cnCenterLeft->button_text ?? null) ?: 'Shop Outdoor' }} &rarr;</span>
        </div>
      </a>
    </div>
  </section>
  @endif

  {{-- ===== BROWSE BY STYLE ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex items-end justify-between mb-5">
      <h2 class="font-serif text-2xl text-cn-ink">{{ 'Browse by Style' }}</h2>
      <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-cn-olive hover:underline">{{ 'Explore All Styles' }} &rarr;</a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
      @foreach($cnStyles as $i => $style)
        <a href="{{ route('store.shop') }}" class="group relative aspect-[4/3] overflow-hidden bg-cn-oliveDeep">
          @if($cnImgAt($i + 2))
            <img src="{{ $cnImgAt($i + 2) }}" alt="{{ $style }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-60 group-hover:scale-105 transition-all duration-300">
          @endif
          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
          <div class="absolute inset-x-0 bottom-0 p-3">
            <h3 class="text-xs md:text-sm font-bold text-white leading-tight">{{ $style }}</h3>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== BEST SELLERS ===== --}}
  @if($bestSellersProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-serif text-2xl text-cn-ink">{{ 'Best Sellers' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold eyebrow text-cn-olive hover:underline">{{ 'View All' }} &rarr;</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($bestSellersProducts as $product)
          @include('store.themes.casanest-furniture.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TESTIMONIALS ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="font-serif text-2xl text-cn-ink text-center mb-8">{{ 'What Our Customers Say' }}</h2>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach([
        ['name' => 'Emily R.', 'loc' => 'San Francisco, CA', 'text' => 'CasaNest helped us transform our living room into a warm, inviting space. The quality is exceptional.'],
        ['name' => 'James T.', 'loc' => 'Austin, TX', 'text' => 'Beautiful pieces, fast delivery, and amazing customer service. Highly recommend!'],
        ['name' => 'Sophia L.', 'loc' => 'Seattle, WA', 'text' => 'The attention to detail in every piece is unmatched. We\'ll be back for more.'],
      ] as $t)
        <div class="bg-white border border-cn-olive/10 p-6">
          <div class="flex gap-0.5 text-cn-tan mb-3">
            @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
          </div>
          <p class="text-sm text-cn-inkSoft leading-relaxed">&ldquo;{{ $t['text'] }}&rdquo;</p>
          <div class="mt-4 text-sm font-bold text-cn-ink">{{ $t['name'] }}</div>
          <div class="text-xs text-cn-inkSoft">{{ $t['loc'] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== NEWSLETTER / CASANEST CLUB ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-10">
    <div class="bg-cn-oliveDeep text-white px-6 py-10 md:px-12 md:py-12 text-center">
      <h3 class="font-serif text-2xl md:text-3xl">{{ 'Join the CasaNest Club' }}</h3>
      <p class="text-white/70 mt-2 max-w-md mx-auto">{{ 'Be the first to know about new arrivals, exclusive offers, and design inspiration.' }}</p>
      <form id="newsletterForm" class="mt-6 flex flex-col sm:flex-row w-full max-w-md mx-auto gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 border border-white/20 bg-white/10 text-white placeholder-white/50 text-sm focus:outline-none" placeholder="{{ 'Enter your email' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-cn-tan text-white text-xs font-bold eyebrow hover:opacity-90 shrink-0">{{ 'Join Now' }}</button>
      </form>
      <div id="newsletterMsg" class="text-sm mt-2 text-white/70"></div>
      <div class="mt-8 flex flex-wrap items-center justify-center gap-8 text-[11px] font-semibold text-white/70">
        <span>{{ 'Exclusive Offers' }}</span>
        <span>{{ 'Design Tips' }}</span>
        <span>{{ 'New Arrivals' }}</span>
        <span>{{ 'Private Sales' }}</span>
      </div>
    </div>
  </section>

</main>

@include('store.themes.casanest-furniture.partials.footer', ['categories' => $categories])
@include('store.themes.casanest-furniture.partials.mobile-nav')

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
        msg.textContent = @json(__('messages.NewsletterThanks'));
        emailInput.value = '';
      } else {
        msg.textContent = data.message || @json(__('messages.NewsletterFailed'));
      }
    } catch (err) {
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
