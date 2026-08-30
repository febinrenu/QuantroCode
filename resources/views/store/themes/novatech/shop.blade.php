<!doctype html>
<html lang="en">
<head>
@include('store.themes.novatech._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'NovaTech')])
</head>
<body class="bg-nova-bg text-slate-100 antialiased bg-nova-radial bg-no-repeat">

@include('store.themes.novatech.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-nova-violetLight text-xs font-bold">Shop</span>
        <h1 class="text-2xl lg:text-3xl font-black text-white mt-1">All Products</h1>
        <p class="text-sm text-slate-400 mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 rounded-full nt-glass text-sm text-white bg-nova-bg">
          <option class="bg-nova-bg" value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option class="bg-nova-bg" value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option class="bg-nova-bg" value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-4 rounded-full bg-nova-violet text-white text-sm font-semibold hover:bg-nova-violetDark">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="nt-glass rounded-2xl p-4 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-400 mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 rounded-lg bg-white/5 border border-white/10 text-sm text-white placeholder:text-slate-500">
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-400 mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-slate-300 cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-nova-violet">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-400 mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 rounded-lg bg-white/5 border border-white/10 text-sm text-white placeholder:text-slate-500">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 rounded-lg bg-white/5 border border-white/10 text-sm text-white placeholder:text-slate-500">
            </div>
          </div>
          <button class="w-full h-10 rounded-full bg-nova-violet text-white text-sm font-semibold hover:bg-nova-violetDark">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-slate-500 hover:text-nova-violetLight">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 nt-glass rounded-2xl">
          <p class="text-slate-400">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-nova-violetLight font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.novatech.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8 [&_a]:text-slate-300 [&_span]:text-slate-500">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.novatech.partials.footer', ['categories' => $categories])
@include('store.themes.novatech.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
