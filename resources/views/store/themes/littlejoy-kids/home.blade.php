<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.littlejoy-kids._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'LittleJoy') . ' — for happy little ones'])
</head>
<body class="bg-lj-cream text-lj-ink antialiased">

@include('store.themes.littlejoy-kids.partials.header', ['categories' => $categories])

@php
  $ljHeroTitle = $s->hero_title ?? 'Little Ones\' Big Smiles';
  $ljHeroSubtitle = $s->hero_subtitle ?? 'Safe, quality products for every stage of your child\'s journey.';
  $ljImgs = $categorySpecificProducts->pluck('image_url')->filter()->values();
  $ljHeroImg = !empty($s->hero_image_path) ? global_asset($s->hero_image_path) : ($ljImgs[0] ?? null);

  $ljSubcatsHome = optional($categories->first())->subcategories ?? collect();
  $ljSubIdHome = fn ($name) => optional($ljSubcatsHome->firstWhere('name', $name))->id;

  $ljIconRow = [
    ['Baby Gear', 'bg-lj-lavender', 'M4 19h16 M6 19V9l6-4 6 4v10'],
    ['Toys & Games', 'bg-lj-creamDark', 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z'],
    ['Clothing', 'bg-teal-50', 'M7 4 3 7l3 3 2-2v12h8V8l2 2 3-3-4-3h-2a2 2 0 0 1-4 0H7Z'],
    ['Nursery', 'bg-amber-50', 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z'],
    ['Feeding', 'bg-pink-50', 'M8 2v6a4 4 0 0 0 8 0V2 M12 12v10'],
    ['Bath & Care', 'bg-sky-50', 'M4 12h16 M6 12V6a6 6 0 0 1 12 0v6 M6 16h.01 M10 16h.01 M14 16h.01 M18 16h.01'],
    ['Books', 'bg-rose-50', 'M4 4h11a2 2 0 0 1 2 2v14H6a2 2 0 0 1-2-2V4Z M17 6h3v14h-3'],
  ];
  $ljTileMap = [
    ['label' => 'New Arrivals', 'sub' => null, 'sort' => 'latest', 'bg' => 'bg-lj-lavender', 'text' => 'text-lj-purple', 'desc' => 'Fresh picks just for you'],
    ['label' => 'Summer Fun', 'sub' => 'Toys & Games', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'desc' => 'Outdoor toys & essentials'],
    ['label' => 'Nursery Must-Haves', 'sub' => 'Nursery', 'bg' => 'bg-lj-mint/20', 'text' => 'text-emerald-700', 'desc' => 'Create the perfect space for baby'],
    ['label' => 'Feeding Time', 'sub' => 'Feeding', 'bg' => 'bg-pink-50', 'text' => 'text-lj-pink', 'desc' => 'Smart choices for happy meals'],
  ];
@endphp

<main class="pb-20 md:pb-0">

  {{-- ===== HERO ===== --}}
  <section class="max-w-7xl mx-auto px-4 pt-4">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-100 via-lj-cream to-lj-lavender" style="min-height:420px;">
      <div class="relative grid md:grid-cols-2 items-center h-full px-8 md:px-14 py-14">
        <div>
          <span class="inline-flex items-center gap-1.5 text-lj-ink/70 text-sm font-medium">
            {{ 'Everything for your' }}
            <svg class="w-4 h-4 text-lj-pink" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.3-8.1C1 10.3 1.8 6.9 4.7 5.6 7 4.6 9.4 5.4 12 8c2.6-2.6 5-3.4 7.3-2.4 2.9 1.3 3.7 4.7 2 7.3C18.7 16.65 12 21 12 21Z"/></svg>
          </span>
          <h1 class="font-heading font-extrabold text-4xl md:text-6xl leading-[1.05] text-lj-ink mt-3">
            <span class="block">{{ \Illuminate\Support\Str::before($ljHeroTitle, "'") }}'</span>
            <span class="block text-lj-pink">{{ trim(\Illuminate\Support\Str::after($ljHeroTitle, "'")) }}</span>
          </h1>
          <p class="mt-5 text-lj-inkSoft max-w-sm">{{ $ljHeroSubtitle }}</p>
          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="{{ route('store.shop') }}" class="h-12 px-7 inline-flex items-center gap-2 bg-lj-purple text-white text-sm font-bold rounded-full hover:bg-lj-purpleDeep">
              {{ 'Shop Now' }}
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="h-12 px-7 inline-flex items-center bg-white text-lj-ink text-sm font-bold rounded-full border border-lj-ink/15 hover:bg-lj-cream">
              {{ 'Explore Deals' }}
            </a>
          </div>
        </div>
        <div class="relative hidden md:flex items-center justify-center">
          @if($ljHeroImg)
            <div class="w-72 h-72 rounded-full overflow-hidden border-4 border-white shadow-cardHover">
              <img src="{{ $ljHeroImg }}" alt="{{ $ljHeroTitle }}" class="w-full h-full object-cover">
            </div>
          @endif
          <div class="absolute -top-2 -right-2 w-24 h-24 rounded-full bg-lj-purple text-white flex flex-col items-center justify-center text-center leading-tight shadow-cardHover">
            <span class="text-[10px] font-bold eyebrow">{{ 'Up to' }}</span>
            <span class="text-xl font-heading font-extrabold">40%</span>
            <span class="text-[10px] font-bold eyebrow">{{ 'Off' }}</span>
          </div>
        </div>
      </div>
      <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-1.5">
        @for($i=0;$i<4;$i++)
          <span class="{{ $i === 0 ? 'w-6 bg-lj-purple' : 'w-1.5 bg-lj-ink/20' }} h-1.5 rounded-full"></span>
        @endfor
      </div>
    </div>
  </section>

  {{-- ===== ICON ROW ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-wrap items-start justify-center gap-x-8 gap-y-5">
      @foreach($ljIconRow as [$name, $bg, $icon])
        @if($ljSubIdHome($name))
          <a href="{{ route('store.shop', ['sub_category' => $ljSubIdHome($name)]) }}" class="flex flex-col items-center gap-2 w-20 group">
            <span class="w-16 h-16 rounded-full {{ $bg }} flex items-center justify-center text-lj-purple group-hover:scale-105 transition-transform">
              <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $icon }}"/></svg>
            </span>
            <span class="text-xs font-semibold text-lj-ink text-center leading-tight">{{ $name }}</span>
          </a>
        @endif
      @endforeach
      <a href="{{ route('store.shop') }}" class="flex flex-col items-center gap-2 w-20 group">
        <span class="w-16 h-16 rounded-full bg-lj-ink/5 flex items-center justify-center text-lj-inkSoft group-hover:scale-105 transition-transform">
          <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        </span>
        <span class="text-xs font-semibold text-lj-ink text-center leading-tight">{{ 'All Categories' }}</span>
      </a>
    </div>
  </section>

  {{-- ===== FEATURED TILES ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-2">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($ljTileMap as $i => $tile)
        @php
          $tHref = $tile['sub'] && $ljSubIdHome($tile['sub'])
            ? route('store.shop', ['sub_category' => $ljSubIdHome($tile['sub'])])
            : route('store.shop', ['sort' => $tile['sort'] ?? 'latest']);
          $tImg = $tile['sub'] ? ($subcategoryImages[$tile['sub']] ?? null) : null;
          $tImg = $tImg ?? ($ljImgs->count() ? $ljImgs[$i % $ljImgs->count()] : null);
        @endphp
        <a href="{{ $tHref }}" class="group rounded-2xl p-5 flex flex-col justify-between min-h-[210px] {{ $tile['bg'] }}">
          <div>
            <h3 class="font-heading font-bold text-lg {{ $tile['text'] }} leading-tight">{{ $tile['label'] }}</h3>
            <p class="text-[11px] text-lj-inkSoft mt-1">{{ $tile['desc'] }}</p>
            <span class="mt-3 inline-flex items-center gap-1 text-[11px] font-bold {{ $tile['text'] }} group-hover:underline">
              {{ 'Shop Now' }}
              <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
          @if($tImg)
            <img src="{{ $tImg }}" alt="{{ $tile['label'] }}" class="w-24 h-24 object-cover rounded-xl self-end mt-2 shadow-card">
          @endif
        </a>
      @endforeach
    </div>
  </section>

  {{-- ===== POPULAR PICKS ===== --}}
  @if($categorySpecificProducts->count())
    <section class="max-w-7xl mx-auto px-4 py-6">
      <div class="flex items-end justify-between mb-5">
        <h2 class="font-heading font-bold text-2xl text-lj-ink flex items-center gap-2">
          {{ 'Popular Picks' }}
          <svg class="w-5 h-5 text-lj-pink" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.3-8.1C1 10.3 1.8 6.9 4.7 5.6 7 4.6 9.4 5.4 12 8c2.6-2.6 5-3.4 7.3-2.4 2.9 1.3 3.7 4.7 2 7.3C18.7 16.65 12 21 12 21Z"/></svg>
        </h2>
        <a href="{{ route('store.shop') }}" class="text-sm font-bold text-lj-purple hover:underline inline-flex items-center gap-1">
          {{ 'View All Products' }}
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($categorySpecificProducts as $product)
          @include('store.themes.littlejoy-kids.partials.product-card', ['product' => $product])
        @endforeach
      </div>
    </section>
  @endif

  {{-- ===== TRUST STRIP ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="rounded-2xl bg-lj-lavender grid grid-cols-2 md:grid-cols-4 gap-6 px-6 py-5 text-center md:text-left">
      @foreach([
        ['icon' => 'M1 3h15v13H1z M16 8h4l3 5v3h-7z M5.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z M18.5 18.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z', 'title' => 'Free Shipping', 'sub' => 'On orders over $75'],
        ['icon' => 'm9 12 2 2 4-4 M20.5 7.3A10 10 0 0 1 12 22a10 10 0 0 1-8.5-14.7L12 2l8.5 5.3Z', 'title' => 'Safe Payments', 'sub' => '100% secure checkout'],
        ['icon' => 'M21 12a9 9 0 1 1-6-8.485 M21 3v6h-6', 'title' => 'Easy Returns', 'sub' => '30 days return policy'],
        ['icon' => 'M3 18v-6a9 9 0 0 1 18 0v6 M21 19a2 2 0 0 1-2 2h-1v-8h3zM3 19a2 2 0 0 0 2 2h1v-8H3z', 'title' => '24/7 Support', 'sub' => "We're here to help"],
      ] as $item)
        <div class="flex flex-col md:flex-row items-center gap-2">
          <svg class="w-6 h-6 text-lj-purple shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $item['icon'] }}"/></svg>
          <span class="leading-tight">
            <span class="block text-xs font-bold text-lj-ink">{{ $item['title'] }}</span>
            <span class="block text-[11px] text-lj-inkSoft">{{ $item['sub'] }}</span>
          </span>
        </div>
      @endforeach
    </div>
  </section>

  {{-- ===== NEWSLETTER ===== --}}
  <section class="max-w-7xl mx-auto px-4 py-6">
    <div class="rounded-2xl bg-amber-50 px-6 py-8 md:px-10 md:py-8 flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="flex items-center gap-4">
        <span class="w-14 h-14 rounded-full bg-white flex items-center justify-center shrink-0 text-lj-purple shadow-card">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/></svg>
        </span>
        <div>
          <h3 class="font-heading font-bold text-xl text-lj-ink">{{ 'Join the LittleJoy Family!' }}</h3>
          <p class="text-sm text-lj-inkSoft mt-1">{{ 'Subscribe for exclusive offers, parenting tips and new arrivals.' }}</p>
        </div>
      </div>
      <form id="newsletterForm" class="flex w-full md:w-auto max-w-md gap-2">
        @csrf
        <input name="email" type="email" id="newsletterEmail" class="flex-1 h-12 px-4 border border-lj-ink/15 bg-white text-sm rounded-full focus:outline-none" placeholder="{{ 'Enter your email address' }}" required>
        <button id="newsletterBtn" type="submit" class="h-12 px-6 bg-lj-purple text-white text-xs font-bold rounded-full hover:bg-lj-purpleDeep shrink-0">{{ __('messages.Subscribe') }}</button>
      </form>
    </div>
    <div id="newsletterMsg" class="text-sm mt-2 text-lj-inkSoft"></div>
  </section>

</main>

@include('store.themes.littlejoy-kids.partials.footer', ['categories' => $categories])
@include('store.themes.littlejoy-kids.partials.mobile-nav')

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
        msg.className = 'text-sm mt-2 text-lj-purple';
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
