<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.retropop._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Retropop')])
</head>
<body class="bg-pop-cream text-pop-ink antialiased">

@include('store.themes.retropop.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="relative bg-pop-teal overflow-hidden">
    <svg class="absolute -top-16 -right-16 w-64 h-64 text-white/10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
    <div class="relative max-w-7xl mx-auto px-4 py-10 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-pop-mustard text-xs font-extrabold">Shop</span>
        <h1 class="text-3xl lg:text-4xl font-heading font-extrabold text-white mt-1">All Products</h1>
        <p class="text-sm text-pop-cream/80 mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 rounded-full border-2 border-white/30 bg-white text-sm font-semibold text-pop-ink">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-11 px-5 rounded-full bg-pop-orange text-white text-sm font-heading font-bold shadow-pop hover:shadow-popHover hover:-translate-y-0.5 active:translate-y-0 active:shadow-none transition-all">Update</button>
      </form>
    </div>
    <svg class="rp-wave" viewBox="0 0 1200 60" preserveAspectRatio="none"><path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,60 L0,60 Z" fill="#FFF8EC"/></svg>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[280px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white rounded-groovy border-2 border-pop-ink/10 p-5 sticky top-24 shadow-card">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="eyebrow text-xs font-extrabold text-pop-teal mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Find something groovy…" class="w-full h-11 px-4 rounded-full border-2 border-pop-ink/10 text-sm focus:outline-none focus:ring-2 focus:ring-pop-orange/40 focus:border-pop-orange">
          </div>
          <div class="mb-5">
            <div class="eyebrow text-xs font-extrabold text-pop-teal mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm font-medium text-pop-ink/70 cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-pop-orange">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="eyebrow text-xs font-extrabold text-pop-teal mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-10 px-3 rounded-full border-2 border-pop-ink/10 text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-10 px-3 rounded-full border-2 border-pop-ink/10 text-sm">
            </div>
          </div>
          <button class="w-full h-11 rounded-full bg-pop-ink text-white text-sm font-heading font-bold shadow-pop hover:shadow-popHover transition-all">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs font-bold text-pop-ink/40 hover:text-pop-orange">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white rounded-groovy border-2 border-pop-ink/10">
          <p class="text-pop-ink/40 font-medium">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-pop-orange font-heading font-bold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.retropop.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.retropop.partials.footer', ['categories' => $categories])
@include('store.themes.retropop.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
