<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.generalhub-store._shell', ['pageTitle' => 'Shop All Products — ' . ($s->store_name ?? 'GeneralHub')])
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased selection:bg-hub-blue selection:text-white">

@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@include('store.themes.generalhub-store.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.generalhub-store.partials.mobile-nav')

@php
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  $productVms = collect($products->items())->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="pb-20">

  <!-- Breadcrumbs & Banner -->
  <div class="bg-white border-b border-slate-200 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
      <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ $hubRoute('store.index') }}" class="hover:text-hub-blue">Home</a>
        <span>/</span>
        <span class="text-slate-900 font-medium">Shop</span>
        @if($q)
          <span>/</span>
          <span class="text-hub-blue font-medium">&ldquo;{{ $q }}&rdquo;</span>
        @endif
      </div>
      <div class="text-xs text-slate-500">
        Showing <span class="font-semibold text-slate-900">{{ $products->total() }}</span> results
      </div>
    </div>
  </div>

  <!-- Main Layout -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid lg:grid-cols-[260px_1fr] gap-8">
    
    <!-- Left Sidebar Filters (Desktop) -->
    <aside class="hidden lg:block">
      <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-6 shadow-xs sticky top-24">
        
        <form method="get" action="{{ $hubRoute('store.shop') }}">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif

          <!-- Search Field -->
          <div class="space-y-2">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Search</h4>
            <input type="text" 
                   name="q" 
                   value="{{ $q ?? '' }}" 
                   placeholder="Keywords..." 
                   class="w-full text-xs bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-hub-blue">
          </div>

          <!-- Categories List -->
          <div class="pt-5 border-t border-slate-100 space-y-2.5">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Categories</h4>
            <div class="space-y-1 text-xs text-slate-600">
              <a href="{{ $hubRoute('store.shop') }}" class="flex items-center justify-between p-1.5 rounded-md hover:bg-slate-50 hover:text-hub-blue {{ !$cat && !$q ? 'text-hub-blue font-bold bg-blue-50/50' : '' }}">
                <span>All Categories</span>
              </a>
              @foreach($categories ?? [] as $c)
                <a href="{{ $hubRoute('store.shop', ['category' => $c->id]) }}" class="flex items-center justify-between p-1.5 rounded-md hover:bg-slate-50 hover:text-hub-blue {{ ($cat == $c->id) ? 'text-hub-blue font-bold bg-blue-50/50' : '' }}">
                  <span>{{ $c->name }}</span>
                </a>
              @endforeach
            </div>
          </div>

          <!-- Price Range Filter -->
          <div class="pt-5 border-t border-slate-100 space-y-3">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900">Price Range</h4>
            <div class="grid grid-cols-2 gap-2">
              <input type="number" name="min" value="{{ request('min') }}" placeholder="Min $" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 outline-none focus:border-hub-blue">
              <input type="number" name="max" value="{{ request('max') }}" placeholder="Max $" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 outline-none focus:border-hub-blue">
            </div>
            <button type="submit" class="w-full py-2 bg-hub-blue hover:bg-hub-blueHover text-white text-xs font-semibold rounded-lg shadow-sm transition-colors">
              Apply Filters
            </button>
          </div>

        </form>

      </div>
    </aside>

    <!-- Main Products Area -->
    <div>
      
      <!-- Top Toolbar (Sort, Active Filters) -->
      <div class="bg-white border border-slate-200 rounded-xl p-4 mb-6 flex items-center justify-between shadow-xs">
        <h1 class="text-base sm:text-lg font-bold text-slate-900">
          {{ $q ? 'Results for "' . $q . '"' : 'All Products' }}
        </h1>

        <!-- Sort Form -->
        <form method="get" action="{{ $hubRoute('store.shop') }}" class="flex items-center gap-2">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          @foreach(request()->except(['sort','page','preview_theme']) as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endforeach
          <label for="sort-select" class="text-xs text-slate-500 hidden sm:inline font-medium">Sort by:</label>
          <select id="sort-select" name="sort" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 py-1.5 px-3 rounded-lg outline-none focus:border-hub-blue cursor-pointer">
            <option value="latest" @selected(($sort ?? 'latest') === 'latest')>Newest Arrivals</option>
            <option value="price_asc" @selected(($sort ?? '') === 'price_asc')>Price: Low to High</option>
            <option value="price_desc" @selected(($sort ?? '') === 'price_desc')>Price: High to Low</option>
          </select>
        </form>
      </div>

      <!-- Products Grid -->
      @if($productVms->isEmpty())
        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center space-y-4 shadow-sm">
          <div class="w-16 h-16 rounded-full bg-blue-50 text-hub-blue flex items-center justify-center mx-auto text-2xl">
            🔍
          </div>
          <h3 class="text-xl font-bold text-slate-900">No products found</h3>
          <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto">
            We couldn't find any items matching your search or filters. Try adjusting your query or browsing all categories.
          </p>
          <div class="pt-2">
            <a href="{{ $hubRoute('store.shop') }}" class="inline-block px-6 py-2.5 bg-hub-blue text-white text-xs font-semibold rounded-lg hover:bg-hub-blueHover transition-colors shadow-sm">
              View All Products
            </a>
          </div>
        </div>
      @else
        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
          @foreach($productVms as $p)
            @include('store.themes.generalhub-store.partials.product-card', ['product' => $p])
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
          {{ $products->appends(request()->query())->links() }}
        </div>
      @endif

    </div>

  </div>

</main>

@include('store.themes.generalhub-store.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
