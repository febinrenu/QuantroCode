<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.terraco._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Terraco')])
</head>
<body class="bg-terra-bg text-terra-ink antialiased">

@include('store.themes.terraco.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="border-b border-terra-line">
    <div class="max-w-6xl mx-auto px-6 py-10 flex flex-wrap items-end justify-between gap-6">
      <div>
        <span class="eyebrow text-xs text-terra-slate">Shop</span>
        <h1 class="font-heading font-light text-4xl text-terra-ink mt-2">All Products</h1>
        <p class="text-sm text-terra-inkSoft mt-2">{{ $products->total() }} products @if($q) matching "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-3">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-2 bg-transparent border-b border-terra-line text-sm focus:outline-none focus:border-terra-slate">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-5 border border-terra-ink text-terra-ink text-sm font-medium hover:bg-terra-ink hover:text-white transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-6xl mx-auto px-6 py-12 grid lg:grid-cols-[240px_1fr] gap-10">
    <aside class="hidden lg:block">
      <div class="sticky top-28">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-8">
            <div class="text-xs eyebrow text-terra-inkSoft mb-3">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-0 bg-transparent border-b border-terra-line text-sm focus:outline-none focus:border-terra-slate">
          </div>
          <div class="mb-8">
            <div class="text-xs eyebrow text-terra-inkSoft mb-3">Category</div>
            <ul class="space-y-2 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-terra-inkSoft cursor-pointer hover:text-terra-ink">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-8">
            <div class="text-xs eyebrow text-terra-inkSoft mb-3">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-0 bg-transparent border-b border-terra-line text-sm focus:outline-none focus:border-terra-slate">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-0 bg-transparent border-b border-terra-line text-sm focus:outline-none focus:border-terra-slate">
            </div>
          </div>
          <button class="w-full h-10 border border-terra-ink text-terra-ink text-sm font-medium hover:bg-terra-ink hover:text-white transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs text-terra-inkSoft hover:text-terra-slate">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-28 border border-terra-line">
          <p class="text-terra-inkSoft">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-terra-slate font-medium text-sm mt-2 inline-block">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
          @foreach($productVms as $product)
            @include('store.themes.terraco.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-12">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.terraco.partials.footer', ['categories' => $categories])
@include('store.themes.terraco.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
