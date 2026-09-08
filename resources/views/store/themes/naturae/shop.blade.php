<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.naturae._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Naturae')])
</head>
<body class="bg-cream text-ink antialiased">

@include('store.themes.naturae.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-leaf-light">
    <div class="max-w-7xl mx-auto px-4 py-8 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-terracotta-dark text-xs font-bold">Full catalog</span>
        <h1 class="text-2xl lg:text-3xl font-display font-semibold text-leaf-deep mt-1">Everything, sourced with care</h1>
        <p class="text-sm text-bark/70 mt-1">{{ $products->total() }} products found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 rounded-full border border-leaf-light bg-white text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-11 px-5 rounded-full bg-leaf-dark text-white text-sm font-semibold hover:bg-leaf-deep transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-10 grid lg:grid-cols-[270px_1fr] gap-7">
    <aside class="hidden lg:block">
      <div class="bg-white rounded-3xl border border-leaf-light p-5 sticky top-24 shadow-soft">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-wide text-bark/50 mb-2 flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
              Search
            </div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search everything…" class="w-full h-11 px-4 rounded-full border border-leaf-light text-sm">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-wide text-bark/50 mb-2">Category</div>
            <ul class="space-y-1.5 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-bark/80 cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-leaf-dark">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold uppercase tracking-wide text-bark/50 mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-10 px-3 rounded-xl border border-leaf-light text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-10 px-3 rounded-xl border border-leaf-light text-sm">
            </div>
          </div>
          <button class="w-full h-11 rounded-full bg-leaf-dark text-white text-sm font-semibold hover:bg-leaf-deep transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs text-bark/50 hover:text-terracotta-dark">Clear all</a>
        </form>
        <div class="mt-6 pt-5 border-t border-leaf-light/70 flex items-start gap-2.5">
          <svg class="w-5 h-5 text-leaf-dark shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
          <p class="text-xs text-bark/60 leading-relaxed">Every listing here — no matter the category — ships in plastic-free packaging with carbon-neutral delivery.</p>
        </div>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white rounded-3xl border border-leaf-light">
          <svg class="w-12 h-12 mx-auto text-bark/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M4 10c3-4 7-6 8-6s5 2 8 6c-1 5-5 9-8 10-3-1-7-5-8-10Z"/></svg>
          <p class="mt-4 text-bark/50">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-terracotta-dark font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.naturae.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-9">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.naturae.partials.footer', ['categories' => $categories])
@include('store.themes.naturae.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
