<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.trailpeak._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'TrailPeak')])
</head>
<body class="bg-tp-cream text-tp-ink antialiased">

@include('store.themes.trailpeak.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-tp-forest text-white">
    <div class="max-w-[1400px] mx-auto px-5 py-10 text-center">
      <span class="eyebrow text-tp-orange text-xs font-bold">The Gear Shop</span>
      <h1 class="text-3xl font-display font-bold mt-1">All Outdoor Gear</h1>
      <p class="text-sm text-white/70 mt-2">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
    </div>
  </section>

  <div class="max-w-[1400px] mx-auto px-5 py-4 flex justify-end">
    <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
      @foreach(request()->except(['sort','page']) as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <select name="sort" class="h-10 px-3 border border-tp-line bg-white text-sm rounded">
        <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
        <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
        <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
      </select>
      <button class="h-10 px-4 bg-tp-orange text-white text-sm font-bold rounded hover:brightness-95 transition">Update</button>
    </form>
  </div>

  <div class="max-w-[1400px] mx-auto px-5 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white border border-tp-line rounded-lg p-5 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-tp-forest mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 border border-tp-line rounded text-sm">
          </div>
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-tp-forest mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-tp-mute cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-tp-forest mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 border border-tp-line rounded text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 border border-tp-line rounded text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-tp-orange text-white text-sm font-bold rounded hover:brightness-95 transition">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-tp-mute hover:text-tp-orange">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white border border-tp-line rounded-lg">
          <p class="text-tp-mute">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-tp-forest font-bold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.trailpeak.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.trailpeak.partials.footer', ['categories' => $categories])
@include('store.themes.trailpeak.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
