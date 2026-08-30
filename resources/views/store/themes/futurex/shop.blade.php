<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.futurex._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'FutureX')])
</head>
<body class="bg-fx-bg text-fx-ink antialiased">

@include('store.themes.futurex.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="border-b border-fx-border bg-fx-panel/40">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-fx-cyan text-xs font-bold">Shop</span>
        <h1 class="text-2xl lg:text-3xl font-black font-heading fx-grad-text mt-1">All Products</h1>
        <p class="text-sm text-fx-mute mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 rounded-full border border-fx-border bg-fx-panel text-sm text-fx-ink">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="fx-glow-btn h-10 px-4 rounded-full fx-grad-btn text-[#0A0E1A] text-sm font-bold">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-fx-panel rounded-2xl border border-fx-border p-4 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-fx-mute mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 rounded-full border border-fx-border bg-fx-panel2 text-sm text-fx-ink placeholder-fx-mute">
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-fx-mute mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-fx-mute cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-fx-mute mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 rounded-lg border border-fx-border bg-fx-panel2 text-sm text-fx-ink">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 rounded-lg border border-fx-border bg-fx-panel2 text-sm text-fx-ink">
            </div>
          </div>
          <button class="w-full h-10 rounded-full fx-grad-btn text-[#0A0E1A] text-sm font-bold fx-glow-btn">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-fx-mute hover:text-fx-cyan">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24">
          <p class="text-fx-mute">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-fx-cyan font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.futurex.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.futurex.partials.footer', ['categories' => $categories])
@include('store.themes.futurex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
