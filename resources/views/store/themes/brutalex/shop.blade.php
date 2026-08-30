<!doctype html>
<html lang="en">
<head>
@include('store.themes.brutalex._shell', ['pageTitle' => 'SHOP — ' . ($s->store_name ?? 'BRUTALEX')])
</head>
<body class="bg-white text-ink-black antialiased">

@include('store.themes.brutalex.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-white border-b-4 border-ink-black">
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow bg-ink-red text-white text-xs font-bold px-2 py-1 inline-block">Catalog</span>
        <h1 class="text-3xl text-ink-black mt-2">ALL PRODUCTS</h1>
        <p class="bx-copy text-sm text-ink-black/60 mt-1">{{ $products->total() }} items in stock @if($q) matching "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-3 border-4 border-ink-black text-sm font-mono font-bold bg-white focus:outline-none">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>LATEST</option>
          <option value="price_asc" @selected($sort === 'price_asc')>PRICE: LOW TO HIGH</option>
          <option value="price_desc" @selected($sort === 'price_desc')>PRICE: HIGH TO LOW</option>
        </select>
        <button class="h-11 px-5 bg-ink-black text-white text-sm font-bold uppercase border-4 border-ink-black bx-shadow-sm bx-shadow-hover">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-6 py-8 grid lg:grid-cols-[280px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white border-4 border-ink-black p-5 sticky top-24 bx-shadow-sm">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-ink-black mb-2 border-b-2 border-ink-black pb-1">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="SEARCH…" class="w-full h-11 px-3 border-4 border-ink-black text-sm font-mono focus:outline-none">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-ink-black mb-2 border-b-2 border-ink-black pb-1">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm font-mono text-ink-black cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-ink-red">
                    {{ strtoupper($c->name) }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase text-ink-black mb-2 border-b-2 border-ink-black pb-1">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="MIN" class="w-1/2 h-10 px-2 border-4 border-ink-black text-sm font-mono focus:outline-none">
              <input type="number" name="max" value="{{ $max }}" placeholder="MAX" class="w-1/2 h-10 px-2 border-4 border-ink-black text-sm font-mono focus:outline-none">
            </div>
          </div>
          <button class="w-full h-11 bg-ink-red text-white text-sm font-bold uppercase border-4 border-ink-black bx-shadow-sm bx-shadow-hover">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs font-mono font-bold text-ink-black/60 hover:text-ink-red">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border-4 border-ink-black bx-shadow-sm">
          <p class="bx-copy text-ink-black/60">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-ink-red font-bold text-sm uppercase mt-2 inline-block">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.brutalex.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.brutalex.partials.footer', ['categories' => $categories])
@include('store.themes.brutalex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
