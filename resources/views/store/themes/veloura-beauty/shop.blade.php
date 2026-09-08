@extends('store.themes.veloura-beauty._shell')

@section('title', 'Shop Luxury Beauty & Fragrance — ' . ($s->store_name ?? 'Veloura Beauty'))

@section('content')
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $homeUrl = $velRoute('store.index');

  $allCategories = [
      'Fragrance',
      'Skincare',
      'Makeup',
      'Bath & Body',
      'Hair Care',
      'Gift Sets',
      "Men's Grooming",
      'Clean Beauty',
  ];

  $selectedCat = request('category');
  $selectedSort = request('sort', 'latest');
  $selectedCollection = request('collection');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

  <!-- Breadcrumbs & Heading -->
  <div class="mb-8 space-y-3">
    <nav class="flex items-center gap-2 text-xs text-vel-muted font-medium">
      <a href="{{ $homeUrl }}" class="hover:text-vel-rose transition-colors">Home</a>
      <span>/</span>
      <span class="text-vel-charcoal font-bold">
        {{ $selectedCat ? $selectedCat : ($selectedCollection ? ucwords(str_replace(['-', '_'], ' ', $selectedCollection)) : ($q ? 'Search: "' . $q . '"' : 'Beauty Catalog')) }}
      </span>
    </nav>

    <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-4 border-b border-vel-border pb-6">
      <div>
        <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-vel-charcoal tracking-tight">
          {{ $selectedCat ? $selectedCat : ($selectedCollection ? ucwords(str_replace(['-', '_'], ' ', $selectedCollection)) : ($q ? 'Results for "' . $q . '"' : 'All Beauty Rituals')) }}
        </h1>
        <p class="text-xs sm:text-sm text-vel-muted mt-1 font-light">
          Discover clean luxury skincare, haute perfumes, and silken cosmetic formulations.
        </p>
      </div>

      <!-- Result Count & Sort Controls -->
      <div class="flex items-center gap-4 shrink-0">
        <span class="text-xs text-vel-muted">
          Showing <strong class="text-vel-charcoal">{{ $products->total() ?? count($products) }}</strong> items
        </span>

        <form action="{{ route('store.shop') }}" method="GET" class="flex items-center gap-2">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          @if($selectedCat)
            <input type="hidden" name="category" value="{{ $selectedCat }}">
          @endif
          @if($selectedCollection)
            <input type="hidden" name="collection" value="{{ $selectedCollection }}">
          @endif
          @if($q)
            <input type="hidden" name="q" value="{{ $q }}">
          @endif

          <select name="sort"
                  onchange="this.form.submit()"
                  class="text-xs bg-white border border-vel-border rounded-xl px-3 py-2 text-vel-charcoal font-bold focus:outline-none focus:border-vel-rose shadow-xs">
            <option value="latest" {{ $selectedSort === 'latest' ? 'selected' : '' }}>Sort: Newest</option>
            <option value="price_asc" {{ $selectedSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ $selectedSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  <!-- Category Pills Filter Bar -->
  <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar">
    <a href="{{ $velRoute('store.shop') }}"
       class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition-all border {{ !$selectedCat && !$selectedCollection ? 'bg-vel-charcoal text-white border-vel-charcoal shadow-xs' : 'bg-white text-vel-charcoal border-vel-border hover:border-vel-rose' }}">
      All Categories
    </a>
    @foreach($allCategories as $cName)
      <a href="{{ $velRoute('store.shop', ['category' => $cName]) }}"
         class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition-all border {{ $selectedCat === $cName ? 'bg-vel-rose text-white border-vel-rose shadow-xs' : 'bg-white text-vel-charcoal border-vel-border hover:border-vel-rose' }}">
        {{ $cName }}
      </a>
    @endforeach
  </div>

  <!-- Product Grid -->
  @if($products && count($products) > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @foreach($products as $product)
        @include('store.themes.veloura-beauty.partials.product-card', ['product' => $product])
      @endforeach
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
      <div class="mt-12 flex justify-center">
        {{ $products->appends(request()->query())->links() }}
      </div>
    @endif
  @else
    <div class="bg-white rounded-3xl border border-vel-border p-12 text-center space-y-4 max-w-lg mx-auto">
      <div class="w-16 h-16 bg-vel-roseLight rounded-full flex items-center justify-center text-2xl mx-auto">
        🌸
      </div>
      <h3 class="font-serif-luxury text-xl font-bold text-vel-charcoal">
        No beauty items found
      </h3>
      <p class="text-xs text-vel-muted">
        We could not find any products matching your selection. Explore our complete collection of luxury fragrances and rituals.
      </p>
      <div>
        <a href="{{ $velRoute('store.shop') }}"
           class="inline-block px-6 py-3 bg-vel-rose hover:bg-vel-roseDark text-white font-bold text-xs rounded-full shadow-md transition-all uppercase tracking-wider">
          Browse All Products
        </a>
      </div>
    </div>
  @endif

</div>
@endsection
