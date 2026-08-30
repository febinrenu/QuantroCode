<!doctype html>
<html lang="en">
<head>
@include('store.themes.freshcart._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'FreshCart')])
</head>
<body class="bg-brand-cream text-brand-ink antialiased">

@include('store.themes.freshcart.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-white border-b border-brand-green/10">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-brand-orange text-xs font-bold">Full Catalog</span>
        <h1 class="text-2xl font-black text-brand-greenDeep mt-1">All Products</h1>
        <p class="text-sm text-brand-inkSoft mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 rounded-full border border-brand-green/20 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-green/40">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-4 rounded-full bg-brand-green text-white text-sm font-semibold hover:bg-brand-greenDark transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[270px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white rounded-2xl border border-brand-green/10 shadow-card p-4 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-brand-inkSoft mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search products…" class="w-full h-10 px-3 rounded-full border border-brand-green/20 text-sm focus:outline-none focus:ring-2 focus:ring-brand-green/40">
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-brand-inkSoft mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-brand-ink cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-brand-green">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-brand-inkSoft mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 rounded-full border border-brand-green/20 text-sm focus:outline-none">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 rounded-full border border-brand-green/20 text-sm focus:outline-none">
            </div>
          </div>
          <button class="w-full h-10 rounded-full bg-brand-greenDeep text-white text-sm font-semibold hover:bg-brand-green transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-brand-inkSoft hover:text-brand-orange">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white rounded-2xl border border-brand-green/10">
          <p class="text-brand-inkSoft">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-brand-green font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.freshcart.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.freshcart.partials.footer', ['categories' => $categories])
@include('store.themes.freshcart.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
