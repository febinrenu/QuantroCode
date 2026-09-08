<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => 'High Jewelry Collections — ' . ($s->store_name ?? 'AurumÉclat')])
</head>
<body class="bg-[#0E0D0B] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'aurumeclat');
  $aurumRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-24">

  <!-- Header Banner -->
  <section class="bg-gradient-to-b from-[#090807] via-[#12100D] to-[#0E0D0B] border-b border-aurum-border py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
          <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-medium block mb-1">
            THE CATALOG
          </span>
          <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-normal text-white">
            Fine Jewelry &amp; Heirlooms
          </h1>
          <p class="text-xs sm:text-sm text-aurum-goldLight/60 font-light mt-2">
            Showing {{ $products->total() }} crafted pieces @if($q) for &ldquo;{{ $q }}&rdquo; @endif
          </p>
        </div>

        <!-- Sort Form -->
        <form method="get" action="{{ $aurumRoute('store.shop') }}" class="flex items-center gap-3">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          @foreach(request()->except(['sort','page','preview_theme']) as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endforeach
          <label for="sort-select" class="text-xs text-aurum-goldLight/70 font-light uppercase tracking-wider hidden sm:inline">Sort by:</label>
          <select id="sort-select" name="sort" onchange="this.form.submit()" class="h-10 px-3 bg-[#151310] border border-aurum-border text-xs text-white rounded-none focus:outline-none focus:border-aurum-gold">
            <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Newest Arrivals</option>
            <option value="price_asc" @selected(($sort ?? '') === 'price_asc')>Price: Low to High</option>
            <option value="price_desc" @selected(($sort ?? '') === 'price_desc')>Price: High to Low</option>
          </select>
        </form>
      </div>
    </div>
  </section>

  <!-- Main Content Layout -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[240px_1fr] gap-10">
    
    <!-- Sidebar Filters -->
    <aside class="hidden lg:block">
      <div class="sticky top-28 bg-[#12100E] border border-aurum-border p-6 space-y-8">
        
        <form method="get" action="{{ $aurumRoute('store.shop') }}">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          <!-- Search Field -->
          <div class="space-y-3">
            <div class="text-[11px] font-semibold tracking-widest text-aurum-gold uppercase">SEARCH</div>
            <div class="relative">
              <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Ring, Diamond, Gold..." class="w-full bg-[#1A1713] border border-aurum-border text-xs text-white placeholder-aurum-goldLight/40 px-3 py-2 rounded-none focus:outline-none focus:border-aurum-gold">
            </div>
          </div>

          <!-- Quick Category Filters -->
          <div class="pt-6 border-t border-aurum-border/60 space-y-3">
            <div class="text-[11px] font-semibold tracking-widest text-aurum-gold uppercase">COLLECTIONS</div>
            <ul class="space-y-2 text-xs font-light text-aurum-goldLight/80">
              <li>
                <a href="{{ $aurumRoute('store.shop') }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ !$q ? 'text-aurum-gold font-medium' : '' }}">
                  All Jewelry
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'ring']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'ring' ? 'text-aurum-gold font-medium' : '' }}">
                  Diamond Rings
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'necklace']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'necklace' ? 'text-aurum-gold font-medium' : '' }}">
                  Necklaces &amp; Pendants
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'earring']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'earring' ? 'text-aurum-gold font-medium' : '' }}">
                  Earrings &amp; Drops
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'bracelet']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'bracelet' ? 'text-aurum-gold font-medium' : '' }}">
                  Tennis Bracelets &amp; Bangles
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'bridal']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'bridal' ? 'text-aurum-gold font-medium' : '' }}">
                  Bridal &amp; Wedding Sets
                </a>
              </li>
              <li>
                <a href="{{ $aurumRoute('store.shop', ['q' => 'gold coin']) }}" class="hover:text-aurum-gold transition-colors block py-0.5 {{ ($q ?? '') === 'gold coin' ? 'text-aurum-gold font-medium' : '' }}">
                  Gold Coins (22K / 24K)
                </a>
              </li>
            </ul>
          </div>

          <!-- Price Range Filter -->
          <div class="pt-6 border-t border-aurum-border/60 space-y-3">
            <div class="text-[11px] font-semibold tracking-widest text-aurum-gold uppercase">PRICE RANGE</div>
            <div class="grid grid-cols-2 gap-2">
              <input type="number" name="min" value="{{ request('min') }}" placeholder="Min $" class="w-full bg-[#1A1713] border border-aurum-border text-xs text-white px-2.5 py-1.5 rounded-none focus:outline-none focus:border-aurum-gold">
              <input type="number" name="max" value="{{ request('max') }}" placeholder="Max $" class="w-full bg-[#1A1713] border border-aurum-border text-xs text-white px-2.5 py-1.5 rounded-none focus:outline-none focus:border-aurum-gold">
            </div>
            <button type="submit" class="w-full mt-2 py-2 bg-aurum-gold text-aurum-black font-semibold text-xs tracking-wider uppercase hover:bg-aurum-goldLight transition-colors">
              APPLY FILTERS
            </button>
          </div>

        </form>

      </div>
    </aside>

    <!-- Products Grid -->
    <div>
      @if($productVms->isEmpty())
        <div class="bg-[#141210] border border-aurum-border p-12 text-center space-y-3">
          <div class="text-3xl text-aurum-gold/40 font-serif">✦</div>
          <h3 class="font-serif text-2xl text-white font-medium">No jewelry items found</h3>
          <p class="text-xs text-aurum-goldLight/60 font-light max-w-sm mx-auto">
            Try adjusting your search query or clear filters to view the full jewelry collection.
          </p>
          <a href="{{ $aurumRoute('store.shop') }}" class="inline-block mt-4 px-6 py-2.5 bg-aurum-gold text-aurum-black text-xs font-semibold tracking-wider uppercase">
            VIEW ALL PIECES
          </a>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
          @foreach($productVms as $p)
            @include('store.themes.aurumeclat.partials.product-card', ['product' => $p])
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
          {{ $products->appends(request()->query())->links() }}
        </div>
      @endif
    </div>

  </div>

</main>

@include('store.themes.aurumeclat.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
