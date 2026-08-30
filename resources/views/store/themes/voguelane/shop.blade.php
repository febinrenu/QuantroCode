<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.voguelane._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Voguelane')])
</head>
<body class="bg-white text-black antialiased">

@include('store.themes.voguelane.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-black text-white">
    <div class="px-4 lg:px-8 py-10 lg:py-14">
      <span class="eyebrow text-brand-magenta text-xs font-bold">Full Catalog</span>
      <h1 class="font-display text-6xl lg:text-7xl mt-1">ALL PRODUCTS</h1>
      <p class="text-sm text-white/50 mt-2">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
    </div>
  </section>

  <div class="px-4 lg:px-8 py-10">
    <div class="flex flex-wrap items-end justify-end gap-3 mb-6">
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 border border-black/20 text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-5 bg-black text-white text-sm font-bold uppercase tracking-wide hover:bg-brand-magenta">Update</button>
      </form>
    </div>

    <div class="grid lg:grid-cols-[1fr_280px] gap-8">
      <div>
        @if($productVms->isEmpty())
          <div class="text-center py-24">
            <p class="text-black/40">No products matched your filters.</p>
            <a href="{{ route('store.shop') }}" class="text-brand-magenta font-bold text-sm uppercase">Clear filters</a>
          </div>
        @else
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
            @foreach($productVms as $product)
              @include('store.themes.voguelane.partials.product-card', ['product' => $product])
            @endforeach
          </div>
          <div class="mt-10">{{ $products->links() }}</div>
        @endif
      </div>

      <aside class="order-first lg:order-last">
        <div class="border border-black/10 p-5 lg:sticky lg:top-24">
          <form method="get" action="{{ route('store.shop') }}">
            <div class="mb-5">
              <div class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-2">Search</div>
              <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 border border-black/20 text-sm">
            </div>
            <div class="mb-5">
              <div class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-2">Category</div>
              <ul class="space-y-1 max-h-64 overflow-y-auto">
                @foreach($categories as $c)
                  <li>
                    <label class="flex items-center gap-2 text-sm text-black/70 cursor-pointer">
                      <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                      {{ $c->name }}
                    </label>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="mb-5">
              <div class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-2">Price Range</div>
              <div class="flex items-center gap-2">
                <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 border border-black/20 text-sm">
                <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 border border-black/20 text-sm">
              </div>
            </div>
            <button class="w-full h-10 bg-black text-white text-sm font-bold uppercase tracking-wide hover:bg-brand-magenta">Apply Filters</button>
            <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-black/40 hover:text-brand-magenta">Clear all</a>
          </form>
        </div>
      </aside>
    </div>
  </div>
</main>

@include('store.themes.voguelane.partials.footer', ['categories' => $categories])
@include('store.themes.voguelane.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
