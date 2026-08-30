<!doctype html>
<html lang="en">
<head>
@include('store.themes.nexora._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Nexora')])
</head>
<body class="bg-nx-bg text-nx-ink antialiased">

@include('store.themes.nexora.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-28 lg:pb-0">
  <section class="bg-white border-b border-nx-chrome1">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="inline-flex px-3 py-1 nx-pill nx-sticker text-xs font-bold text-nx-ink">Shop</span>
        <h1 class="text-2xl font-black nx-holo-text mt-2">All Products</h1>
        <p class="text-sm text-nx-mute mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 nx-pill border border-nx-chrome1 text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-11 px-5 nx-pill nx-holo-bg text-white text-sm font-bold">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white rounded-3xl border border-nx-chrome1 p-5 sticky top-24 shadow-card">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-nx-violet mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-11 px-4 nx-pill border border-nx-chrome1 text-sm">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-nx-violet mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-nx-mute cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-nx-violet mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-10 px-3 nx-pill border border-nx-chrome1 text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-10 px-3 nx-pill border border-nx-chrome1 text-sm">
            </div>
          </div>
          <button class="w-full h-11 nx-pill nx-holo-bg text-white text-sm font-bold">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-nx-mute hover:text-nx-pink">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white rounded-3xl border border-nx-chrome1">
          <p class="text-nx-mute">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-nx-pink font-bold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.nexora.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.nexora.partials.footer', ['categories' => $categories])
@include('store.themes.nexora.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
