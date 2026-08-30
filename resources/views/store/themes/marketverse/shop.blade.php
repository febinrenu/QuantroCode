<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.marketverse._shell', ['pageTitle' => 'Shop — ' . ($s->store_name ?? 'MarketVerse')])
</head>
<body class="bg-mv-cream text-mv-ink antialiased">

@include('store.themes.marketverse.partials.header', ['categories' => $categories, 'showCategoryBar' => true])

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24 lg:pb-0">
  <section class="bg-white border-b-2 border-mv-line">
    <div class="max-w-[1600px] mx-auto px-4 py-5 flex flex-wrap items-end justify-between gap-4">
      <div>
        <span class="eyebrow text-mv-accentDark text-xs font-bold mv-mono">SHOP.ALL_CATEGORIES</span>
        <h1 class="text-2xl font-black text-mv-ink mt-1">All Products</h1>
        <p class="text-sm text-mv-slate mt-1 mv-mono">{{ $products->total() }} RESULTS @if($q) FOR "{{ $q }}" @endif</p>
      </div>
      <form method="get" action="{{ route('store.shop') }}" class="flex items-end gap-2">
        @foreach(request()->except(['sort','page']) as $k => $v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="h-10 px-3 rounded-md border-2 border-mv-line text-sm font-semibold">
          <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Latest</option>
          <option value="price_asc" @selected($sort === 'price_asc')>Price: Low to High</option>
          <option value="price_desc" @selected($sort === 'price_desc')>Price: High to Low</option>
        </select>
        <button class="h-10 px-4 rounded-md bg-mv-ink text-white text-sm font-bold hover:bg-mv-accentDark transition-colors">Update</button>
      </form>
    </div>
  </section>

  <div class="max-w-[1600px] mx-auto px-4 py-6 grid lg:grid-cols-[240px_1fr] gap-5">

    {{-- Persistent left category rail + filters --}}
    <aside class="hidden lg:block">
      <div class="bg-white rounded-lg border-2 border-mv-line sticky top-24 overflow-hidden">
        <div class="bg-mv-ink text-white text-[11px] font-bold uppercase tracking-wider px-4 py-3 mv-mono">Browse Categories</div>
        <ul class="divide-y divide-mv-line max-h-72 overflow-y-auto">
          <li>
            <a href="{{ route('store.shop') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-semibold {{ !$cat ? 'text-mv-accentDark bg-mv-accentSoft' : 'text-mv-ink hover:bg-mv-accentSoft hover:text-mv-accentDark' }} transition-colors">
              All Categories
            </a>
          </li>
          @foreach($categories as $c)
            <li>
              <a href="{{ route('store.shop', ['category' => $c->id]) }}" class="flex items-center justify-between gap-2 px-4 py-2.5 text-sm font-semibold {{ (string)$cat === (string)$c->id ? 'text-mv-accentDark bg-mv-accentSoft' : 'text-mv-ink hover:bg-mv-accentSoft hover:text-mv-accentDark' }} transition-colors">
                <span class="truncate">{{ $c->name }}</span>
                <svg class="w-3.5 h-3.5 shrink-0 text-mv-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
              </a>
            </li>
          @endforeach
        </ul>

        <form method="get" action="{{ route('store.shop') }}" class="p-4 border-t-2 border-mv-line">
          <input type="hidden" name="category" value="{{ $cat }}">
          <div class="mb-4">
            <div class="text-[11px] font-bold uppercase text-mv-slate mb-2 mv-mono">Search</div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Search…" class="w-full h-9 px-3 rounded-md border-2 border-mv-line text-sm">
          </div>
          <div class="mb-4">
            <div class="text-[11px] font-bold uppercase text-mv-slate mb-2 mv-mono">Price Range</div>
            <div class="flex items-center gap-2">
              <input type="number" name="min" value="{{ $min }}" placeholder="Min" class="w-1/2 h-9 px-2 rounded-md border-2 border-mv-line text-sm mv-mono">
              <input type="number" name="max" value="{{ $max }}" placeholder="Max" class="w-1/2 h-9 px-2 rounded-md border-2 border-mv-line text-sm mv-mono">
            </div>
          </div>
          <button class="w-full h-9 rounded-md bg-mv-accent text-white text-sm font-bold hover:bg-mv-accentDark transition-colors">Apply Filters</button>
          <a href="{{ route('store.shop') }}" class="block text-center mt-2 text-xs text-mv-slate hover:text-mv-accentDark mv-mono">CLEAR ALL</a>
        </form>
      </div>
    </aside>

    <div class="min-w-0">
      {{-- Mobile: category chip scroller --}}
      <div class="lg:hidden -mx-1 mb-4 overflow-x-auto no-scrollbar">
        <div class="flex gap-2 px-1">
          <a href="{{ route('store.shop') }}" class="shrink-0 px-3 h-8 inline-flex items-center rounded-full border-2 text-xs font-bold mv-mono {{ !$cat ? 'bg-mv-accent text-white border-mv-accent' : 'border-mv-line text-mv-ink' }}">ALL</a>
          @foreach($categories as $c)
            <a href="{{ route('store.shop', ['category' => $c->id]) }}" class="shrink-0 px-3 h-8 inline-flex items-center rounded-full border-2 text-xs font-bold {{ (string)$cat === (string)$c->id ? 'bg-mv-accent text-white border-mv-accent' : 'border-mv-line text-mv-ink' }}">{{ $c->name }}</a>
          @endforeach
        </div>
      </div>

      @if($productVms->isEmpty())
        <div class="text-center py-24 bg-white rounded-lg border-2 border-mv-line">
          <p class="text-mv-slate">No products matched your filters.</p>
          <a href="{{ route('store.shop') }}" class="text-mv-accentDark font-bold text-sm">Clear filters</a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
          @foreach($productVms as $product)
            @include('store.themes.marketverse.partials.product-card', ['product' => $product])
          @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
      @endif
    </div>
  </div>
</main>

@include('store.themes.marketverse.partials.footer', ['categories' => $categories])
@include('store.themes.marketverse.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
