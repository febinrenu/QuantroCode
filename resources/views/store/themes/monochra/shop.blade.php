<!doctype html>
<html lang="en">
<head>
@include('store.themes.monochra._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Monochra')])
</head>
<body class="bg-brand-white text-brand-black antialiased">

@include('store.themes.monochra.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-brand-black border-b-2 border-brand-black">
    <div class="max-w-7xl mx-auto px-4 py-8 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-brand-red text-xs font-bold">Shop</span>
        <h1 class="font-display text-3xl lg:text-4xl text-brand-white mt-1 uppercase">All Products</h1>
        <p class="text-sm text-white/60 mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 border-2 border-white/30 bg-brand-black text-white text-sm font-semibold uppercase">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-4 bg-brand-red text-brand-white text-sm font-bold uppercase hover:bg-brand-redDark transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-brand-white border-2 border-brand-black p-4 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="eyebrow text-xs font-bold text-brand-black mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 border-2 border-brand-black text-sm focus:outline-none focus:border-brand-red">
          </div>
          <div class="mb-4">
            <div class="eyebrow text-xs font-bold text-brand-black mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm font-medium text-brand-black cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-brand-red">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="eyebrow text-xs font-bold text-brand-black mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 border-2 border-brand-black text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 border-2 border-brand-black text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-brand-black text-brand-white text-sm font-bold uppercase hover:bg-brand-red transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs font-bold text-brand-gray hover:text-brand-red uppercase">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border-2 border-brand-black">
          <p class="text-brand-gray">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-brand-red font-bold text-sm uppercase">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.monochra.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.monochra.partials.footer', ['categories' => $categories])
@include('store.themes.monochra.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
