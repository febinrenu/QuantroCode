<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.medisphere-care._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'MediSphere')])
</head>
<body class="bg-ms-cream text-ms-ink antialiased">

@include('store.themes.medisphere-care.partials.header', ['categories' => $categories])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $msSubcats = optional($categories->first())->subcategories ?? collect();
@endphp

<main class="pb-24 md:pb-0">
  <section class="border-b border-ms-teal/10 bg-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="text-xs font-bold text-ms-teal">{{ __('messages.Shop') }}</span>
        <h1 class="font-heading text-2xl font-extrabold text-ms-ink mt-1">{{ __('messages.AllProducts') ?? 'All Products' }}</h1>
        <p class="text-sm text-ms-inkSoft mt-1">{{ $products->total() }} {{ 'products' }}</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 rounded border border-ms-teal/25 bg-white text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>{{ __('messages.Latest') ?? 'Latest' }}</option>
          <option value="price_asc" @selected($sort === 'price_asc')>{{ __('messages.PriceLowToHigh') ?? 'Price: Low to High' }}</option>
          <option value="price_desc" @selected($sort === 'price_desc')>{{ __('messages.PriceHighToLow') ?? 'Price: High to Low' }}</option>
        </select>
        <button class="h-11 px-6 bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep">{{ __('messages.Update') ?? 'Update' }}</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="border border-ms-teal/15 bg-white rounded-xl2 overflow-hidden sticky top-24">
        <div class="bg-ms-teal text-white text-xs font-bold px-4 py-3">{{ 'Refine Results' }}</div>
        <form method="get" action="{{ route('store.shop') }}" class="p-4">
          <div class="mb-5">
            <div class="text-xs font-bold text-ms-inkSoft mb-2">{{ __('messages.Search') }}</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}" class="w-full h-10 px-3 rounded border border-ms-teal/20 bg-ms-cream text-sm">
          </div>
          @if($msSubcats->count())
            <div class="mb-5">
              <div class="text-xs font-bold text-ms-inkSoft mb-2">{{ 'Category' }}</div>
              <div class="space-y-1.5">
                @foreach($msSubcats as $sc)
                  <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block text-sm {{ (string) request('sub_category') === (string) $sc->id ? 'text-ms-teal font-bold' : 'text-ms-inkSoft hover:text-ms-teal' }}">{{ $sc->name }}</a>
                @endforeach
              </div>
            </div>
          @endif
          <div class="mb-5">
            <div class="text-xs font-bold text-ms-inkSoft mb-2">{{ 'Price Range' }}</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-3 rounded border border-ms-teal/20 bg-ms-cream text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-3 rounded border border-ms-teal/20 bg-ms-cream text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep">{{ __('messages.ApplyFilters') ?? 'Apply Filters' }}</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-ms-inkSoft hover:text-ms-teal">{{ 'Clear all' }}</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border border-ms-teal/15 bg-white rounded-xl2">
          <p class="text-ms-inkSoft">{{ 'No products matched your filters.' }}</p>
          <a href="{{ route('store.shop') }}" class="text-ms-teal font-semibold text-sm">{{ __('messages.ClearFilters') ?? 'Clear filters' }}</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.medisphere-care.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.medisphere-care.partials.footer', ['categories' => $categories])
@include('store.themes.medisphere-care.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
