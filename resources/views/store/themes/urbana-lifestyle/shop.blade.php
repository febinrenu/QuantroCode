<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.urbana-lifestyle._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Urbana')])
</head>
<body class="bg-urb-cream text-urb-ink antialiased">

@include('store.themes.urbana-lifestyle.partials.header', ['categories' => $categories])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  $urbShopSubcats = optional($categories->first())->subcategories ?? collect();
@endphp

<main class="pb-24 md:pb-0">
  <section class="border-b border-urb-ink/10 bg-white">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-urb-gold text-xs font-bold">{{ __('messages.Shop') }}</span>
        <h1 class="font-serif text-3xl text-urb-ink mt-1">{{ __('messages.AllProducts') ?? 'All Products' }}</h1>
        <p class="text-sm text-urb-inkSoft mt-1">{{ $products->total() }} {{ 'RESULTS' }}</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-11 px-4 border border-urb-ink/20 bg-white text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>{{ __('messages.Latest') ?? 'Latest' }}</option>
          <option value="price_asc" @selected($sort === 'price_asc')>{{ __('messages.PriceLowToHigh') ?? 'Price: Low to High' }}</option>
          <option value="price_desc" @selected($sort === 'price_desc')>{{ __('messages.PriceHighToLow') ?? 'Price: High to Low' }}</option>
        </select>
        <button class="h-11 px-6 bg-urb-green text-white text-xs font-bold eyebrow hover:bg-urb-greenDeep">{{ __('messages.Update') ?? 'Update' }}</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="border border-urb-ink/15 bg-white sticky top-24">
        <div class="bg-urb-green text-white text-xs font-bold eyebrow px-4 py-3">{{ 'Refine Results' }}</div>
        <form method="get" action="{{ route('store.shop') }}" class="p-4">
          <div class="mb-5">
            <div class="text-xs font-bold eyebrow text-urb-inkSoft mb-2">{{ __('messages.Search') }}</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}" class="w-full h-10 px-3 border border-urb-ink/15 bg-urb-cream text-sm">
          </div>
          <div class="mb-5">
            <div class="text-xs font-bold eyebrow text-urb-inkSoft mb-2">{{ 'Price Range' }}</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-3 border border-urb-ink/15 bg-urb-cream text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-3 border border-urb-ink/15 bg-urb-cream text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-urb-green text-white text-xs font-bold eyebrow hover:bg-urb-greenDeep">{{ __('messages.ApplyFilters') ?? 'Apply Filters' }}</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-urb-inkSoft hover:text-urb-green">{{ 'Clear all' }}</a>
        </form>
        @if($urbShopSubcats->count())
          <div class="border-t border-urb-ink/10 p-4">
            <div class="text-xs font-bold eyebrow text-urb-inkSoft mb-2">{{ 'Categories' }}</div>
            <ul class="space-y-1.5">
              @foreach($urbShopSubcats as $sub)
                <li>
                  <a href="{{ route('store.shop', ['sub_category' => $sub->id]) }}" class="text-sm {{ (string) request('sub_category') === (string) $sub->id ? 'text-urb-green font-semibold' : 'text-urb-inkSoft hover:text-urb-green' }}">
                    {{ $sub->name }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border border-urb-ink/15 bg-white">
          <p class="text-urb-inkSoft">{{ 'No products matched your filters.' }}</p>
          <a href="{{ route('store.shop') }}" class="text-urb-green font-semibold text-sm">{{ __('messages.ClearFilters') ?? 'Clear filters' }}</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-4 gap-y-6">
          @foreach($productVms as $product)
            @include('store.themes.urbana-lifestyle.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.urbana-lifestyle.partials.footer', ['categories' => $categories])
@include('store.themes.urbana-lifestyle.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
