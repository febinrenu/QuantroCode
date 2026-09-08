@extends('store.themes.paperloom._shell')

@section('title', 'Books, Stationery & Study Catalog — PaperLoom')

@section('content')

@php
  use App\Models\Category;

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $plRoute('store.shop');

  $selectedCat = request('category');
  $selectedSort = request('sort', 'latest');
  $q = request('q', '');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

  <!-- Breadcrumbs & Heading -->
  <div class="mb-8 space-y-2">
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
      <a href="{{ $plRoute('store.index') }}" class="hover:text-pl-terracotta transition-colors">Home</a>
      <span>/</span>
      <span class="text-slate-900 font-semibold">
        {{ $selectedCat ? $selectedCat : ($q ? 'Search: "' . $q . '"' : 'Catalog') }}
      </span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4 border-b border-pl-border pb-6">
      <div>
        <h1 class="font-serif-book text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
          {{ $selectedCat ? $selectedCat : (request('collection') ? ucwords(str_replace(['-', '_'], ' ', request('collection'))) : ($q ? 'Results for "' . $q . '"' : 'Books & Stationery Collection')) }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
          Explore handcrafted journals, literary bestsellers, and study essentials.
        </p>
      </div>

      <!-- Result Count & Sort Controls -->
      <div class="flex items-center gap-4">
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
          @if(request('collection'))
            <input type="hidden" name="collection" value="{{ request('collection') }}">
          @endif
          @if($q)
            <input type="hidden" name="q" value="{{ $q }}">
          @endif

          <select name="sort"
                  onchange="this.form.submit()"
                  class="text-xs bg-white border border-pl-border rounded-xl px-3 py-2 text-slate-900 font-semibold focus:outline-none focus:border-pl-terracotta shadow-xs">
            <option value="latest" {{ $selectedSort === 'latest' ? 'selected' : '' }}>Sort: Newest</option>
            <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <!-- Layout: 3-col Sidebar + 9-col Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

    <!-- Sidebar Filters (3 cols on desktop) -->
    <aside class="lg:col-span-3 space-y-6">

      <!-- Category Filter Box -->
      <div class="bg-white rounded-2xl border border-pl-border p-5 space-y-3 shadow-xs">
        <h3 class="font-serif-book text-base font-bold text-slate-900 border-b border-pl-border/60 pb-2">
          Categories
        </h3>

        <ul class="space-y-1 text-xs font-medium">
          <li>
            <a href="{{ $plRoute('store.shop') }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ empty($selectedCat) && empty(request('collection')) ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
              <span>All Products</span>
            </a>
          </li>
          @foreach($categories as $catItem)
            <li>
              <a href="{{ $plRoute('store.shop', ['category' => $catItem->name]) }}"
                 class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ $selectedCat === $catItem->name ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
                <span>{{ $catItem->name }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Featured Collections Filter Box -->
      <div class="bg-white rounded-2xl border border-pl-border p-5 space-y-3 shadow-xs">
        <h3 class="font-serif-book text-base font-bold text-slate-900 border-b border-pl-border/60 pb-2">
          Featured Collections
        </h3>
        <ul class="space-y-1 text-xs font-medium">
          <li>
            <a href="{{ $plRoute('store.shop', ['collection' => 'highlights']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'highlights' ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
              <span>This Month's Highlights</span>
            </a>
          </li>
          <li>
            <a href="{{ $plRoute('store.shop', ['collection' => 'staff-picks']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'staff-picks' ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
              <span>Staff Picks</span>
            </a>
          </li>
          <li>
            <a href="{{ $plRoute('store.shop', ['collection' => 'study-essentials']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'study-essentials' ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
              <span>Study & Work Essentials</span>
            </a>
          </li>
          <li>
            <a href="{{ $plRoute('store.shop', ['collection' => 'new-arrivals']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'new-arrivals' ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-slate-700 hover:bg-pl-cream/50' }}">
              <span>New Arrivals</span>
            </a>
          </li>
          <li>
            <a href="{{ $plRoute('store.shop', ['collection' => 'sale']) }}"
               class="flex items-center justify-between py-1.5 px-2.5 rounded-lg {{ request('collection') === 'sale' ? 'bg-pl-cream text-pl-terracotta font-bold' : 'text-pl-terracotta font-bold hover:bg-pl-cream/50' }}">
              <span>Deals & Sale</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Quick Trust Callout -->
      <div class="bg-pl-forest text-white rounded-2xl p-5 space-y-2 text-center">
        <span class="text-xl block">🌿</span>
        <h4 class="font-serif-book font-bold text-sm text-amber-200">The PaperLoom Promise</h4>
        <p class="text-[11px] text-slate-300 leading-relaxed">
          Every piece is packaged with care in recyclable eco-friendly paper.
        </p>
      </div>

    </aside>

    <!-- Product Grid (9 cols on desktop) -->
    <main class="lg:col-span-9 space-y-8">

      @if($products->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-3xl border border-pl-border p-12 text-center space-y-4 max-w-lg mx-auto">
          <div class="w-16 h-16 rounded-2xl bg-pl-cream flex items-center justify-center text-3xl mx-auto">
            📖
          </div>
          <h2 class="font-serif-book text-2xl font-bold text-slate-900">No items found</h2>
          <p class="text-xs text-slate-500 leading-relaxed">
            We couldn't find any products matching your current selection. Try clearing filters or exploring our curated collections.
          </p>
          <div class="pt-2">
            <a href="{{ $plRoute('store.shop') }}" class="inline-block px-6 py-2.5 bg-pl-terracotta text-white rounded-full text-xs font-bold hover:bg-pl-terracottaHover transition-colors shadow-xs">
              View All Books & Stationery
            </a>
          </div>
        </div>
      @else
        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
          @foreach($products as $prod)
            @include('store.themes.paperloom.partials.product-card', ['product' => $prod])
          @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($products, 'links') && $products->hasPages())
          <div class="pt-6 flex justify-center">
            {{ $products->appends(request()->query())->links() }}
          </div>
        @endif
      @endif

    </main>

  </div>

</div>

@endsection
