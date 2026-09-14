<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.naturia-living._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'Naturia') . ' — Pure Ingredients. Better Living.'])
</head>
<body class="bg-nt-cream text-nt-ink antialiased">

@include('store.themes.naturia-living.partials.header', ['categories' => $categories])

@php
  // Auto-rotating hero carousel; add slides via Store Settings > Hero Slides.
  $nlHeroSlides = $heroSlides ?? [];
  $nlSplitTitle = function ($title) {
    $words = explode(' ', $title);
    $mid = (int) ceil(count($words) / 2);
    return [implode(' ', array_slice($words, 0, $mid)), implode(' ', array_slice($words, $mid))];
  };
  // Category-specific themes always lead with their own category's product
  // photo -- the admin's store-wide hero_image_path (set for a different,
  // general-purpose theme) would otherwise show an unrelated image here.
  $ntHeroImg = $categorySpecificProducts->first()['image_url'] ?? (!empty($s->hero_image_path) ? global_asset($s->hero_image_path) : null);
  $ntImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $ntImgAt = fn ($i) => $ntImgs->count() ? $ntImgs[$i % $ntImgs->count()] : null;

  $ntSubcats = optional($categories->first())->subcategories ?? collect();
  $ntSubcatId = fn ($name) => optional($ntSubcats->firstWhere('name', $name))->id;
  $ntCatTiles = collect(['Skin Care', 'Hair Care', 'Supplements', 'Bath & Body', 'Home Care', 'Organic Food', 'Tea & Drinks'])
    ->map(fn ($name) => ['label' => $name, 'sub_category' => $ntSubcatId($name)]);

  // Merchant-customizable promo banners (Banners admin): position-keyed lookup
  // plus overlay/text style overrides so a merchant-set bg_color/text_color
  // can restyle a tile without touching markup.
  $byPos = collect($banners ?? [])->groupBy('position');
  $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');
  $bannerOverlayStyle = function ($b) {
    if (!$b || empty($b->bg_color)) return null;
    return !empty($b->bg_color_2)
      ? "background:linear-gradient(135deg, {$b->bg_color}, {$b->bg_color_2});"
      : "background:{$b->bg_color};";
  };
  $bannerTextStyle = function ($b) {
    return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
  };

  // Role-tagged Collection (Best Sellers) -- when a merchant has assigned
  // one, its own curated products win over the generic category listing.
  $ntCurrency = $s->currency_code ?? '$';
  $ntHidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $ntRoleBestSellers = collect($collectionsByRole['best_sellers']['products'] ?? [])
    ->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $ntCurrency, $ntHidePrices))
    ->values();
  $ntBestSellersProducts = $ntRoleBestSellers->isNotEmpty() ? $ntRoleBestSellers : $categorySpecificProducts;
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO (auto-rotating carousel; add slides via Store Settings > Hero Slides) ===== --}}
  <section class="relative bg-nt-creamDark grid"
           x-data="{ nlHero: 0, nlHeroCount: {{ count($nlHeroSlides) }} }"
           @if(count($nlHeroSlides) > 1) x-init="setInterval(() => { nlHero = (nlHero + 1) % nlHeroCount }, 6000)" @endif>
    @foreach($nlHeroSlides as $nlI => $nlSlide)
      @php
        $nlTitle = ($nlSlide['title'] ?? '') !== '' ? $nlSlide['title'] : 'Pure Ingredients. Better Living.';
        [$nlLine1, $nlLine2] = $nlSplitTitle($nlTitle);
        $nlSubtitle = ($nlSlide['subtitle'] ?? '') !== '' ? $nlSlide['subtitle'] : 'Discover natural & sustainable products for a healthier you and a greener planet.';
        $nlImg = !empty($nlSlide['image_url']) ? $nlSlide['image_url'] : $ntHeroImg;
      @endphp
      <div x-show="nlHero === {{ $nlI }}" @if(!$loop->first) x-cloak @endif
           x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
           x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
           class="col-start-1 row-start-1 max-w-7xl mx-auto px-4 py-10 relative">
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div>
            <h1 class="font-serif text-4xl md:text-5xl leading-[1.1] text-nt-ink">
              <span class="text-nt-green">{{ $nlLine1 }}</span><br>
              {{ $nlLine2 }}
            </h1>
            <p class="mt-5 text-nt-inkSoft max-w-md">{{ $nlSubtitle }}</p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
              <a href="{{ ($nlSlide['cta_link'] ?? '') !== '' ? $nlSlide['cta_link'] : route('store.shop') }}" class="h-12 px-7 inline-flex items-center bg-nt-green text-white text-xs font-bold rounded-full hover:bg-nt-greenDeep">
                {{ ($nlSlide['cta_text'] ?? '') !== '' ? $nlSlide['cta_text'] : 'Shop Now' }}
              </a>
              <a href="{{ route('store.contact') }}" class="h-12 px-7 inline-flex items-center border border-nt-green text-nt-ink text-xs font-bold rounded-full hover:bg-white">
                {{ 'Learn More' }}
              </a>
            </div>
            <div class="mt-10 flex flex-wrap items-center gap-8">
              @foreach([
                ['icon' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z', 'label' => '100% Natural Ingredients'],
                ['icon' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z M9 12l2 2 4-4', 'label' => 'Cruelty Free & Vegan'],
                ['icon' => 'M4 4h5v5H4z M15 4h5v5h-5z M4 15h5v5H4z M15 15h5v5h-5z', 'label' => 'Eco Friendly Packaging'],
              ] as $item)
                <div class="flex flex-col items-center gap-1.5 text-center w-24">
                  <svg class="w-6 h-6 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
                  <span class="text-[11px] font-semibold text-nt-inkSoft leading-tight">{{ $item['label'] }}</span>
                </div>
              @endforeach
            </div>
          </div>
          <div class="relative aspect-[6/5] overflow-hidden rounded-2xl bg-nt-creamDark">
            @if($nlImg)
              <img src="{{ $nlImg }}" alt="{{ $nlTitle }}" class="w-full h-full object-cover">
            @endif
            <span class="absolute top-6 right-6 w-20 h-20 rounded-full bg-nt-greenDeep text-white text-[11px] font-bold flex flex-col items-center justify-center text-center leading-tight">
              <span class="text-[9px]">{{ 'UP TO' }}</span>
              <span class="text-base">{{ '35%' }}</span>
              <span class="text-[9px]">{{ 'OFF' }}</span>
            </span>
          </div>
        </div>
      </div>
    @endforeach

    @if(count($nlHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($nlHeroSlides as $nlI => $nlSlide)
          <button type="button" @click="nlHero = {{ $nlI }}" class="w-2 h-2 rounded-full transition-colors" :class="nlHero === {{ $nlI }} ? 'bg-nt-green' : 'bg-nt-green/30'" aria-label="Slide {{ $nlI + 1 }}"></button>
        @endforeach
      </div>
    @endif
  </section>

  {{-- ===== CATEGORY ICON ROW ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-4 md:grid-cols-8 gap-3">
      @foreach($ntCatTiles as $tile)
        <a href="{{ $tile['sub_category'] ? route('store.shop', ['sub_category' => $tile['sub_category']]) : route('store.shop') }}" class="bg-white border border-nt-green/10 rounded-xl p-4 flex flex-col items-center text-center gap-2 hover:shadow-cardHover hover:border-nt-green/30 transition">
          <svg class="w-6 h-6 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/></svg>
          <span class="text-[11px] font-semibold text-nt-ink leading-tight">{{ $tile['label'] }}</span>
        </a>
      @endforeach
      <a href="{{ route('store.shop') }}" class="bg-nt-green rounded-xl p-4 flex flex-col items-center text-center gap-2 hover:bg-nt-greenDeep transition">
        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        <span class="text-[11px] font-semibold text-white leading-tight">{{ 'All Categories' }}</span>
      </a>
    </div>
  </section>

  {{-- ===== TRUST STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-8">
    <div class="bg-nt-greenLight rounded-xl px-6 py-5 grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z', 'title' => 'Free Shipping', 'sub' => 'On orders over $60'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z', 'title' => 'Secure Payments', 'sub' => '100% safe & secure'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30 days return policy'],
        ['icon' => 'M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3', 'title' => 'Customer Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex items-center gap-3">
          <svg class="w-6 h-6 text-nt-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-nt-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-nt-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== PROMO BANNERS (fully customizable via Banners: image, badge, headline, subtitle, button, colors) ===== --}}
  @if($bannerGridEnabled ?? true)
  @php
    $ntPromo1 = ($byPos['top_left'] ?? collect())->first();
    $ntPromo2 = ($byPos['top_right'] ?? collect())->first();
    $ntPromo3 = ($byPos['center_left'] ?? collect())->first();
  @endphp
  <section class="max-w-7xl mx-auto px-4 pb-10 grid md:grid-cols-3 gap-4">
    <div class="rounded-xl overflow-hidden bg-nt-creamDark relative min-h-[180px] flex items-end" @if($bannerOverlayStyle($ntPromo1)) style="{{ $bannerOverlayStyle($ntPromo1) }}" @endif>
      @if($ntPromo1 && $ntPromo1->image_url)
        <img src="{{ $bannerUrl($ntPromo1) }}" class="absolute inset-0 w-full h-full object-cover opacity-40" alt="{{ $ntPromo1->title }}">
      @elseif($ntImgAt(0))
        <img src="{{ $ntImgAt(0) }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
      @endif
      <div class="relative p-6" @if($bannerTextStyle($ntPromo1)) style="{{ $bannerTextStyle($ntPromo1) }}" @endif>
        @if(!empty($ntPromo1->badge_text ?? null))
          <span class="block text-[11px] font-bold uppercase tracking-wide text-nt-green mb-1" style="color:inherit;">{{ $ntPromo1->badge_text }}</span>
        @endif
        <h3 class="font-serif text-xl text-nt-ink" style="color:inherit;">
          @if(!empty($ntPromo1->title ?? null)){{ $ntPromo1->title }}@else{{ 'Wellness' }}<br>{{ 'Essentials' }}@endif
        </h3>
        <p class="text-xs text-nt-inkSoft mt-1" style="color:inherit;">{{ ($ntPromo1->subtitle ?? null) ?: 'Boost your daily wellness routine' }}</p>
        <a href="{{ $ntPromo1 ? ($ntPromo1->link ?: route('store.shop')) : route('store.shop') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-nt-green hover:underline" style="color:inherit;">{{ ($ntPromo1->button_text ?? null) ?: 'Shop Now' }} &rarr;</a>
      </div>
    </div>
    <div class="rounded-xl overflow-hidden bg-nt-greenLight relative min-h-[180px] flex items-end" @if($bannerOverlayStyle($ntPromo2)) style="{{ $bannerOverlayStyle($ntPromo2) }}" @endif>
      @if($ntPromo2 && $ntPromo2->image_url)
        <img src="{{ $bannerUrl($ntPromo2) }}" class="absolute inset-0 w-full h-full object-cover opacity-40" alt="{{ $ntPromo2->title }}">
      @elseif($ntImgAt(1))
        <img src="{{ $ntImgAt(1) }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
      @endif
      <div class="relative p-6" @if($bannerTextStyle($ntPromo2)) style="{{ $bannerTextStyle($ntPromo2) }}" @endif>
        @if(!empty($ntPromo2->badge_text ?? null))
          <span class="block text-[11px] font-bold uppercase tracking-wide text-nt-green mb-1" style="color:inherit;">{{ $ntPromo2->badge_text }}</span>
        @endif
        <h3 class="font-serif text-xl text-nt-green" style="color:inherit;">{{ ($ntPromo2->title ?? null) ?: 'Glow Naturally' }}</h3>
        <p class="text-xs text-nt-inkSoft mt-1" style="color:inherit;">{{ ($ntPromo2->subtitle ?? null) ?: 'Clean beauty for radiant skin' }}</p>
        <a href="{{ $ntPromo2 ? ($ntPromo2->link ?: route('store.shop')) : route('store.shop') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-nt-green hover:underline" style="color:inherit;">{{ ($ntPromo2->button_text ?? null) ?: 'Shop Now' }} &rarr;</a>
      </div>
    </div>
    <div class="rounded-xl overflow-hidden bg-orange-50 relative min-h-[180px] flex items-end" @if($bannerOverlayStyle($ntPromo3)) style="{{ $bannerOverlayStyle($ntPromo3) }}" @endif>
      @if($ntPromo3 && $ntPromo3->image_url)
        <img src="{{ $bannerUrl($ntPromo3) }}" class="absolute inset-0 w-full h-full object-cover opacity-40" alt="{{ $ntPromo3->title }}">
      @elseif($ntImgAt(2))
        <img src="{{ $ntImgAt(2) }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
      @endif
      <div class="relative p-6" @if($bannerTextStyle($ntPromo3)) style="{{ $bannerTextStyle($ntPromo3) }}" @endif>
        @if(!empty($ntPromo3->badge_text ?? null))
          <span class="block text-[11px] font-bold uppercase tracking-wide text-nt-green mb-1" style="color:inherit;">{{ $ntPromo3->badge_text }}</span>
        @endif
        <h3 class="font-serif text-xl text-nt-ink" style="color:inherit;">
          @if(!empty($ntPromo3->title ?? null)){{ $ntPromo3->title }}@else{{ 'Healthy' }}<br>{{ 'Inside Out' }}@endif
        </h3>
        <p class="text-xs text-nt-inkSoft mt-1" style="color:inherit;">{{ ($ntPromo3->subtitle ?? null) ?: 'Organic foods for a better you' }}</p>
        <a href="{{ $ntPromo3 ? ($ntPromo3->link ?: route('store.shop')) : route('store.shop') }}" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-nt-green hover:underline" style="color:inherit;">{{ ($ntPromo3->button_text ?? null) ?: 'Shop Now' }} &rarr;</a>
      </div>
    </div>
  </section>
  @endif

  {{-- ===== BEST SELLERS ===== --}}
  @if($ntBestSellersProducts->count())
    <section class="max-w-7xl mx-auto px-4 pb-10">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-serif text-2xl text-nt-ink">{{ 'Best Sellers' }}</h2>
        <a href="{{ route('store.shop') }}" class="text-xs font-bold text-nt-green hover:underline">{{ 'View All Products' }} &rarr;</a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($ntBestSellersProducts as $product)
          @include('store.themes.naturia-living.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== STATS BANNER ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <div class="relative overflow-hidden rounded-xl bg-nt-greenDeep min-h-[220px] grid md:grid-cols-[1.2fr_1fr]">
      @if($ntImgAt(3))
        <img src="{{ $ntImgAt(3) }}" class="absolute inset-0 w-full h-full object-cover opacity-25">
      @endif
      <div class="relative p-8 text-white flex flex-col justify-center">
        <h3 class="font-serif text-2xl leading-tight">{{ 'Small Choices,' }}<br>{{ 'Big Impact' }}</h3>
        <p class="text-white/70 text-sm mt-2 max-w-xs">{{ 'Every purchase supports a healthier you and a healthier planet.' }}</p>
        <a href="{{ route('store.contact') }}" class="mt-4 inline-flex h-10 px-5 items-center bg-white text-nt-greenDeep text-xs font-bold rounded-full hover:bg-nt-cream w-max">{{ 'Discover Our Story' }}</a>
      </div>
      <div class="relative grid grid-cols-2 gap-4 p-8 items-center">
        @foreach([
          ['icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2 M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z', 'value' => '10K+', 'label' => 'Happy Customers'],
          ['icon' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z', 'value' => '500+', 'label' => 'Organic Products'],
          ['icon' => 'M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z M3.6 9h16.8 M3.6 15h16.8 M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z', 'value' => '50+', 'label' => 'Countries Served'],
          ['icon' => 'M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z', 'value' => '100%', 'label' => 'Satisfaction'],
        ] as $stat)
          <div class="flex flex-col items-center gap-1.5 text-white text-center">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $stat['icon'] }}"/></svg>
            <span class="text-xl font-serif font-bold">{{ $stat['value'] }}</span>
            <span class="text-[11px] text-white/70">{{ $stat['label'] }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 pb-10">
    <div class="bg-nt-greenDeep rounded-xl px-6 py-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="flex items-center gap-3 text-white">
        <span class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0">
          <svg class="w-5 h-5 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z"/></svg>
        </span>
        <div>
          <h3 class="font-serif text-lg">{{ 'Join Our Natural Living Community' }}</h3>
          <p class="text-xs text-white/70">{{ 'Subscribe for exclusive offers, tips & new arrivals.' }}</p>
        </div>
      </div>
      <form id="newsletterForm" class="flex w-full md:w-auto max-w-sm gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-11 px-4 rounded-full border border-white/20 bg-white text-sm focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-11 px-6 bg-white text-nt-greenDeep text-xs font-bold rounded-full hover:bg-nt-cream shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-nt-inkSoft"></div>
  </section>

</main>

@include('store.themes.naturia-living.partials.footer', ['categories' => $categories])
@include('store.themes.naturia-living.partials.mobile-nav')

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
        msg.className = 'text-sm mt-2 text-nt-green';
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
