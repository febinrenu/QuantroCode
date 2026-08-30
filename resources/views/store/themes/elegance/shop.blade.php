<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.elegance._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Elegance')])
</head>
<body class="bg-brand-cream text-brand-charcoal antialiased">

@include('store.themes.elegance.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="border-b el-hairline">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-wrap items-end justify-between gap-6">
      <div>
        <span class="eyebrow text-brand-gold text-xs font-semibold">Shop</span>
        <h1 class="font-serif text-4xl italic text-brand-charcoal mt-2">The Full Collection</h1>
        <p class="text-sm text-brand-charcoalSoft mt-2">{{ $products->total() }} pieces found @if($q) for &ldquo;{{ $q }}&rdquo; @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-3">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-2 bg-transparent border-b border-brand-hairline text-sm focus:outline-none focus:border-brand-gold">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-6 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-6 py-14 grid lg:grid-cols-[240px_1fr] gap-12">
    <aside class="hidden lg:block">
      <div class="sticky top-28">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-8">
            <div class="text-[11px] eyebrow font-bold text-brand-gold mb-3">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-0 bg-transparent border-b border-brand-hairline text-sm focus:outline-none focus:border-brand-gold">
          </div>
          <div class="mb-8">
            <div class="text-[11px] eyebrow font-bold text-brand-gold mb-3">Category</div>
            <ul class="space-y-2 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-brand-charcoalSoft cursor-pointer hover:text-brand-charcoal">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-8">
            <div class="text-[11px] eyebrow font-bold text-brand-gold mb-3">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-0 bg-transparent border-b border-brand-hairline text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-0 bg-transparent border-b border-brand-hairline text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs text-brand-charcoalSoft hover:text-brand-gold">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24">
          <p class="text-brand-charcoalSoft font-serif italic text-lg">No pieces matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-brand-gold text-xs eyebrow font-semibold mt-3 inline-block">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
          @foreach($productVms as $product)
            @include('store.themes.elegance.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-12">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.elegance.partials.footer', ['categories' => $categories])
@include('store.themes.elegance.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
