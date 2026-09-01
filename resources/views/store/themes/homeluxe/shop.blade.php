<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.homeluxe._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'HomeLuxe')])
</head>
<body class="bg-hl-cream text-hl-ink antialiased">

@include('store.themes.homeluxe.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-hl-deep text-white">
    <div class="max-w-[1440px] mx-auto px-5 py-10 text-center">
      <span class="eyebrow text-hl-gold text-xs font-bold">The Collection</span>
      <h1 class="text-3xl font-display font-semibold mt-1">Furniture &amp; Decor</h1>
      <p class="text-sm text-white/70 mt-2">{{ $products->total() }} pieces found @if($q) for "{{ $q }}" @endif</p>
    </div>
  </section>

  <div class="max-w-[1440px] mx-auto px-5 py-4 flex justify-end">
    <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
      @foreach(request()->except(['sort','page']) as $k => $v)
        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
      @endforeach
      <select name="sort" class="h-10 px-3 border border-hl-line bg-white text-sm rounded-lg">
        <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
        <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
        <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
      </select>
      <button class="h-10 px-4 bg-hl-forest text-white text-sm font-semibold rounded-lg hover:bg-hl-deep transition-colors">Update</button>
    </form>
  </div>

  <div class="max-w-[1440px] mx-auto px-5 py-8 grid lg:grid-cols-[260px_1fr] gap-6">
    <aside class="hidden lg:block">
      <div class="bg-white border border-hl-line rounded-2xl p-5 sticky top-24">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-hl-forest mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-10 px-3 border border-hl-line rounded-lg text-sm">
          </div>
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-hl-forest mb-2">Category</div>
            <ul class="space-y-1 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-hl-mute cursor-pointer">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-[11px] eyebrow font-bold text-hl-forest mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 border border-hl-line rounded-lg text-sm">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 border border-hl-line rounded-lg text-sm">
            </div>
          </div>
          <button class="w-full h-10 bg-hl-forest text-white text-sm font-semibold rounded-lg hover:bg-hl-deep transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-hl-mute hover:text-hl-forest">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white border border-hl-line rounded-2xl">
          <p class="text-hl-mute">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-hl-forest font-semibold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.homeluxe.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.homeluxe.partials.footer', ['categories' => $categories])
@include('store.themes.homeluxe.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
