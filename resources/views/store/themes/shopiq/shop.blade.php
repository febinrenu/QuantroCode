<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.shopiq._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'ShopIQ')])
</head>
<body class="bg-brand-bg text-brand-ink antialiased">

@include('store.themes.shopiq.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-white border-b border-brand-line">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-brand-teal text-xs font-bold inline-flex items-center gap-1.5">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
          Compare &amp; Shop
        </span>
        <h1 class="text-2xl font-black text-brand-navy mt-1">All Products</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 rounded-lg border border-brand-line text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High (Best Value)</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-4 rounded-lg bg-brand-teal text-white text-sm font-semibold">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white rounded-xl border border-brand-line p-4 sticky top-24">
        <div class="flex items-center gap-1.5 text-xs font-bold uppercase text-brand-navy mb-4">
          <svg class="w-3.5 h-3.5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6"/></svg>
          Smart Filters
        </div>
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-500 mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 rounded-lg border border-brand-line text-sm">
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-500 mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-slate-500 mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 rounded-lg border border-brand-line text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 rounded-lg border border-brand-line text-sm">
            </div>
          </div>
          <button class="w-full h-10 rounded-lg bg-brand-navy text-white text-sm font-semibold">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-slate-400 hover:text-brand-teal">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24">
          <p class="text-slate-400">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-brand-teal font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $iqI => $product)
            @include('store.themes.shopiq.partials.product-card', ['product' => $product, 'idx' => $iqI])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.shopiq.partials.footer', ['categories' => $categories])
@include('store.themes.shopiq.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
