<!doctype html>
<html lang="en">
<head>
@include('store.themes.veloura._shell', ['pageTitle' => 'The Collection — ' . ($s->store_name ?? 'Veloura')])
</head>
<body class="bg-vel-black text-vel-ink antialiased">

@include('store.themes.veloura.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-vel-charcoal border-b border-vel-line">
    <div class="max-w-7xl mx-auto px-4 py-10 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-vel-gold text-xs font-bold">The Full Collection</span>
        <h1 class="font-serif text-3xl font-bold text-vel-ink mt-2">Every Category, One Standard</h1>
        <p class="text-sm text-vel-mute mt-2">{{ $products->total() }} pieces found @if($q) for "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 bg-vel-black border border-vel-line text-sm text-vel-ink">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Newest Arrivals</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-5 bg-vel-gold text-vel-black text-sm font-semibold hover:bg-vel-goldSoft transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-7xl mx-auto px-4 py-10 grid lg:grid-cols-[260px_1fr] gap-8">
    <aside class="hidden lg:block">
      <div class="bg-vel-charcoal border border-vel-line p-5 sticky top-28">
        <form method="get" action="{{ route('store.shop') }}">
          <div class="mb-5">
            <div class="text-[11px] font-bold eyebrow text-vel-gold/80 mb-2">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search the collection…" class="w-full h-10 px-3 bg-vel-black border border-vel-line text-sm text-vel-ink placeholder:text-vel-mute">
          </div>
          <div class="mb-5">
            <div class="text-[11px] font-bold eyebrow text-vel-gold/80 mb-2">Category</div>
            <ul class="space-y-1.5 max-h-64 overflow-y-auto">
              @foreach($categories as $c)
                <li>
                  <label class="flex items-center gap-2 text-sm text-vel-mute cursor-pointer hover:text-vel-ink">
                    <input type="radio" name="category" value="{{ $c->id }}" {{ (string)$cat === (string)$c->id ? 'checked' : '' }} onchange="this.form.submit()" class="accent-vel-gold">
                    {{ $c->name }}
                  </label>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="mb-5">
            <div class="text-[11px] font-bold eyebrow text-vel-gold/80 mb-2">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 bg-vel-black border border-vel-line text-sm text-vel-ink">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 bg-vel-black border border-vel-line text-sm text-vel-ink">
            </div>
          </div>
          <button class="w-full h-10 bg-vel-gold text-vel-black text-sm font-semibold hover:bg-vel-goldSoft transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-3 text-xs text-vel-mute hover:text-vel-gold">Clear all</a>
        </form>
      </div>
    </aside>

    <div>
      @if($productVms->isEmpty())
        <div class="text-center py-24 border border-vel-line bg-vel-charcoal">
          <p class="text-vel-mute font-serif text-lg">No pieces matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-vel-gold font-semibold text-sm mt-3 inline-block">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
          @foreach($productVms as $product)
            @include('store.themes.veloura.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-10">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.veloura.partials.footer', ['categories' => $categories])
@include('store.themes.veloura.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
