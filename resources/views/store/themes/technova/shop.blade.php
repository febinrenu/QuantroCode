<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.technova._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'Technova')])
</head>
<body class="bg-tn-bg text-tn-ink antialiased">
<div class="tn-scanlines"></div>

@include('store.themes.technova.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-tn-panel border-b border-tn-border">
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="text-tn-amber text-xs font-bold tn-bracket">shop</span>
        <h1 class="text-2xl font-bold text-tn-ink mt-1">ls ./all_products</h1>
        <p class="text-sm text-tn-mute mt-1">{{ $products->total() }} results found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 border border-tn-border bg-black text-tn-ink text-sm">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>--sort=latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>--sort=price_asc</option>
          <option value="price_desc" @selected($sort === 'price_desc')>--sort=price_desc</option>
        </select>
        <button class="h-10 px-4 border border-tn-green bg-tn-green text-black text-sm font-bold">run</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="tn-window tn-window-pad p-4 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-tn-green mb-2 tn-bracket">search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="$ query…" class="w-full h-10 px-3 border border-tn-border bg-black text-tn-ink text-sm placeholder-tn-mute">
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-tn-green mb-2 tn-bracket">category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-tn-mute cursor-pointer hover:text-tn-ink">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-4">
            <div class="text-xs font-bold uppercase text-tn-green mb-2 tn-bracket">price_range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="min" class="w-1/2 h-9 px-2 border border-tn-border bg-black text-tn-ink text-sm placeholder-tn-mute">
              <input type="number" name="max" value="{{ $max }}" placeholder="max" class="w-1/2 h-9 px-2 border border-tn-border bg-black text-tn-ink text-sm placeholder-tn-mute">
            </div>
          </div>
          <button class="w-full h-10 border border-tn-green bg-tn-green text-black text-sm font-bold">apply --filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-tn-mute hover:text-tn-green">clear_all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 tn-window tn-window-pad">
          <p class="text-tn-mute">// no products matched your filters</p>
          <a href="{{ route('store.shop') }}" class="text-tn-green font-semibold text-sm">clear_filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.technova.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.technova.partials.footer', ['categories' => $categories])
@include('store.themes.technova.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
