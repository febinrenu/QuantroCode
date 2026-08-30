<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.crystalglass._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'CrystalGlass')])
</head>
<body class="text-brand-ink antialiased">
<div class="cg-mesh"><div class="cg-blob cg-blob-1"></div><div class="cg-blob cg-blob-2"></div><div class="cg-blob cg-blob-3"></div></div>

@include('store.themes.crystalglass.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0 relative z-10">
  <section class="glass border-b border-white/40">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-brand-violetDark text-xs font-bold">Shop</span>
        <h1 class="text-2xl font-black text-brand-ink mt-1 tracking-tight">All Products</h1>
        <p class="text-sm text-brand-ink/50 mt-1 tracking-wide">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-4 rounded-full border border-white/60 bg-white/60 text-sm tracking-wide">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-5 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white text-sm font-semibold tracking-wide">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[280px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="glass rounded-3xl p-5 sticky top-24 shadow-glass">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-widest text-brand-ink/50 mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-4 rounded-full border border-white/60 bg-white/60 text-sm tracking-wide">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-widest text-brand-ink/50 mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-brand-ink/70 cursor-pointer tracking-wide">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-widest text-brand-ink/50 mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-3 rounded-full border border-white/60 bg-white/60 text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-3 rounded-full border border-white/60 bg-white/60 text-sm">
            </div>
          </div>
          <button class="w-full h-10 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white text-sm font-semibold tracking-wide">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-brand-ink/40 hover:text-brand-violetDark">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 glass rounded-3xl">
          <p class="text-brand-ink/40 tracking-wide">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-brand-violetDark font-semibold text-sm tracking-wide">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.crystalglass.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.crystalglass.partials.footer', ['categories' => $categories])
@include('store.themes.crystalglass.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
