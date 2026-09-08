<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.freshcart-daily._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'FreshCart')])
</head>
<body class="bg-fc-cream text-fc-ink antialiased">

@include('store.themes.freshcart-daily.partials.header', ['categories' => $categories])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 md:pb-0">
  <section class="border-b border-fc-green/10 bg-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="text-xs font-bold text-fc-green">{{ __('messages.Shop') }}</span>
        <h1 class="font-heading text-2xl font-extrabold text-fc-ink mt-1">{{ __('messages.AllProducts') ?? 'All Products' }}</h1>
        <p class="text-sm text-fc-inkSoft mt-1">{{ $products->total() }} {{ 'products' }}</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 rounded-full border border-fc-green/25 bg-white text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>{{ __('messages.Latest') ?? 'Latest' }}</option>
          <option value="price_asc" @selected($sort === 'price_asc')>{{ __('messages.PriceLowToHigh') ?? 'Price: Low to High' }}</option>
          <option value="price_desc" @selected($sort === 'price_desc')>{{ __('messages.PriceHighToLow') ?? 'Price: High to Low' }}</option>
        </select>
        <button class="h-11 px-6 bg-fc-green text-white text-xs font-bold rounded-full hover:bg-fc-greenDeep">{{ __('messages.Update') ?? 'Update' }}</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="border border-fc-green/15 bg-white rounded-xl2 overflow-hidden sticky top-24">
        <div class="bg-fc-greenDeep text-white text-xs font-bold px-4 py-3">{{ 'Refine Results' }}</div>
        <form method="get" action="{{ route('store.shop') }}" class="p-4">
          <div class="mb-5">
            <div class="text-xs font-bold text-fc-inkSoft mb-2">{{ __('messages.Search') }}</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}" class="w-full h-10 px-3 rounded-lg border border-fc-green/20 bg-fc-cream text-sm">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold text-fc-inkSoft mb-2">{{ 'Price Range' }}</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-3 rounded-lg border border-fc-green/20 bg-fc-cream text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-3 rounded-lg border border-fc-green/20 bg-fc-cream text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-fc-green text-white text-xs font-bold rounded-full hover:bg-fc-greenDeep">{{ __('messages.ApplyFilters') ?? 'Apply Filters' }}</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-fc-inkSoft hover:text-fc-green">{{ 'Clear all' }}</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border border-fc-green/15 bg-white rounded-xl2">
          <p class="text-fc-inkSoft">{{ 'No products matched your filters.' }}</p>
          <a href="{{ route('store.shop') }}" class="text-fc-green font-semibold text-sm">{{ __('messages.ClearFilters') ?? 'Clear filters' }}</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.freshcart-daily.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.freshcart-daily.partials.footer', ['categories' => $categories])
@include('store.themes.freshcart-daily.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
