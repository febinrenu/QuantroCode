@extends('store.themes.marketverse-deals._shell')

@section('title', 'Marketplace Catalog — MarketVerse')

@section('content')

@php
  use App\Models\Category;

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $mvRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $mvRoute('store.shop');

  $selectedCat = request('category');
  $selectedSort = request('sort', 'latest');
  $q = request('q', '');

  $departments = [
      'Fashion',
      'Electronics',
      'Home & Living',
      'Beauty & Personal Care',
      'Grocery & Essentials',
      'Sports & Outdoors',
      'Toys & Games',
      'Automotive',
      'Books & Stationery',
      'Pet Supplies'
  ];
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

  <!-- Breadcrumbs & Heading -->
  <div class="mb-6 space-y-2">
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
      <a href="{{ $mvRoute('store.index') }}" class="hover:text-mv-purple transition-colors">Home</a>
      <span>/</span>
      <span class="text-slate-900 font-bold">
        {{ $selectedCat ? $selectedCat : (request('brand') ? 'Brand: ' . request('brand') : ($q ? 'Search: "' . $q . '"' : 'Marketplace Catalog')) }}
      </span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4 border-b border-mv-border pb-5">
      <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
          {{ $selectedCat ? $selectedCat : (request('brand') ? 'Brand: ' . request('brand') : (request('collection') ? ucwords(str_replace(['-', '_'], ' ', request('collection'))) : ($q ? 'Results for "' . $q . '"' : 'All Marketplace Products'))) }}
        </h1>
        <p class="text-xs text-slate-500 mt-1">
          Explore products from verified sellers and top-rated marketplace brands.
        </p>
      </div>

      <!-- Result Count & Sort Controls -->
      <div class="flex items-center gap-4 shrink-0">
        <span class="text-xs text-slate-500">
          Showing <strong class="text-slate-900">{{ $products->total() ?? count($products) }}</strong> items
        </span>

        <form action="{{ route('store.shop') }}" method="GET" class="flex items-center gap-2">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          @if($selectedCat)
            <input type="hidden" name="category" value="{{ $selectedCat }}">
          @endif
          @if(request('brand'))
            <input type="hidden" name="brand" value="{{ request('brand') }}">
          @endif
          @if(request('collection'))
            <input type="hidden" name="collection" value="{{ request('collection') }}">
          @endif
          @if($q)
            <input type="hidden" name="q" value="{{ $q }}">
          @endif

          <select name="sort"
                  onchange="this.form.submit()"
                  class="text-xs bg-white border border-mv-border rounded-xl px-3 py-2 text-slate-900 font-bold focus:outline-none focus:border-mv-purple shadow-xs">
            <option value="latest" {{ $selectedSort === 'latest' ? 'selected' : '' }}>Sort: Newest</option>
            <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <!-- Layout: 3-col Sidebar + 9-col Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Sidebar Filters (3 cols on desktop) -->
    <aside class="lg:col-span-3 space-y-6">

      <!-- Departments Filter Box -->
      <div class="bg-white rounded-2xl border border-mv-border p-4 sm:p-5 space-y-3 shadow-xs">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2">
          Departments
        </h3>

        <ul class="space-y-1 text-xs font-semibold">
          <li>
            <a href="{{ $plShop = $mvRoute('store.shop') }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ empty($selectedCat) && empty(request('collection')) ? 'bg-mv-purpleLight text-mv-purple font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>All Departments</span>
            </a>
          </li>
          @foreach($departments as $dept)
            <li>
              <a href="{{ $mvRoute('store.shop', ['category' => $dept]) }}"
                 class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ $selectedCat === $dept ? 'bg-mv-purpleLight text-mv-purple font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
                <span>{{ $dept }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Marketplace Collections Box -->
      <div class="bg-white rounded-2xl border border-mv-border p-4 sm:p-5 space-y-3 shadow-xs">
        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 border-b border-slate-100 pb-2">
          Featured Deals
        </h3>
        <ul class="space-y-1 text-xs font-semibold">
          <li>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'flash-sale']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'flash-sale' ? 'bg-red-50 text-red-600 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>⚡ Flash Sale</span>
            </a>
          </li>
          <li>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'top-deals' ? 'bg-amber-50 text-amber-600 font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>🔥 Top Deals</span>
            </a>
          </li>
          <li>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'recommended']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'recommended' ? 'bg-mv-purpleLight text-mv-purple font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>👍 Recommended</span>
            </a>
          </li>
          <li>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'new-arrivals']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'new-arrivals' ? 'bg-mv-purpleLight text-mv-purple font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>✨ New Arrivals</span>
            </a>
          </li>
          <li>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'bestselling']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'bestselling' ? 'bg-mv-purpleLight text-mv-purple font-extrabold' : 'text-slate-700 hover:bg-slate-50' }}">
              <span>⭐ Best Sellers</span>
            </a>
          </li>
        </ul>
      </div>

    </aside>

    <!-- Products Grid (9 cols on desktop) -->
    <main class="lg:col-span-9">
      @if($products->isNotEmpty())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
          @foreach($products as $prod)
            @include('store.themes.marketverse-deals.partials.product-card', ['product' => $prod])
          @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($products, 'links') && $products->hasPages())
          <div class="mt-10 flex justify-center">
            {{ $products->appends(request()->query())->links() }}
          </div>
        @endif
      @else
        <div class="bg-white rounded-3xl border border-mv-border p-12 text-center space-y-4 shadow-xs">
          <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
            📦
          </div>
          <h3 class="text-lg font-bold text-slate-900">No marketplace products found</h3>
          <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Try adjusting your search query, clearing department filters, or exploring all products.
          </p>
          <div>
            <a href="{{ $shopUrl }}" class="px-6 py-2.5 bg-mv-purple text-white font-bold text-xs rounded-full shadow-md hover:bg-mv-purpleDark transition-all inline-block">
              Browse All Products
            </a>
          </div>
        </div>
      @endif
    </main>

  </div>
</div>
@endsection
