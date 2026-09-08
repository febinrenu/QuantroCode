<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.naturia-living._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Naturia')])
</head>
<body class="bg-nt-cream text-nt-ink antialiased">

@include('store.themes.naturia-living.partials.header', ['categories' => $categories])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $ntSubcats = optional($categories->first())->subcategories ?? collect();
@endphp

<main class="pb-24 md:pb-0">
  <section class="border-b border-nt-green/10">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-nt-green text-xs font-bold">{{ __('messages.Shop') }}</span>
        <h1 class="font-serif text-3xl text-nt-ink mt-1">{{ __('messages.AllProducts') ?? 'All Products' }}</h1>
        <p class="text-sm text-nt-inkSoft mt-1">{{ $products->total() }} {{ 'products' }}</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 rounded-full border border-nt-green/25 bg-white text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>{{ __('messages.Latest') ?? 'Latest' }}</option>
          <option value="price_asc" @selected($sort === 'price_asc')>{{ __('messages.PriceLowToHigh') ?? 'Price: Low to High' }}</option>
          <option value="price_desc" @selected($sort === 'price_desc')>{{ __('messages.PriceHighToLow') ?? 'Price: High to Low' }}</option>
        </select>
        <button class="h-11 px-6 bg-nt-green text-white text-xs font-bold rounded-full hover:bg-nt-greenDeep">{{ __('messages.Update') ?? 'Update' }}</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="border border-nt-green/15 bg-white rounded-xl overflow-hidden sticky top-24">
        <div class="bg-nt-greenDeep text-white text-xs font-bold eyebrow px-4 py-3">{{ 'Refine Results' }}</div>
        <form method="get" action="{{ route('store.shop') }}" class="p-4">
          <div class="mb-5">
            <div class="text-xs font-bold eyebrow text-nt-inkSoft mb-2">{{ __('messages.Search') }}</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}" class="w-full h-10 px-3 rounded-lg border border-nt-green/20 bg-nt-cream text-sm">
          </div>
          @if($ntSubcats->count())
            <div class="mb-5">
              <div class="text-xs font-bold eyebrow text-nt-inkSoft mb-2">{{ 'Category' }}</div>
              <div class="space-y-1.5">
                @foreach($ntSubcats as $sc)
                  <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block text-sm {{ (string) request('sub_category') === (string) $sc->id ? 'text-nt-green font-bold' : 'text-nt-inkSoft hover:text-nt-green' }}">{{ $sc->name }}</a>
                @endforeach
              </div>
            </div>
          @endif
          <div class="mb-5">
            <div class="text-xs font-bold eyebrow text-nt-inkSoft mb-2">{{ 'Price Range' }}</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-3 rounded-lg border border-nt-green/20 bg-nt-cream text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-3 rounded-lg border border-nt-green/20 bg-nt-cream text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-nt-green text-white text-xs font-bold rounded-full hover:bg-nt-greenDeep">{{ __('messages.ApplyFilters') ?? 'Apply Filters' }}</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-nt-inkSoft hover:text-nt-green">{{ 'Clear all' }}</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border border-nt-green/15 bg-white rounded-xl">
          <p class="text-nt-inkSoft">{{ 'No products matched your filters.' }}</p>
          <a href="{{ route('store.shop') }}" class="text-nt-green font-semibold text-sm">{{ __('messages.ClearFilters') ?? 'Clear filters' }}</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.naturia-living.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.naturia-living.partials.footer', ['categories' => $categories])
@include('store.themes.naturia-living.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
