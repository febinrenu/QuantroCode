@extends('store.themes.voguelane-couture._shell')

@section('title', 'Shop Fashion Collections — VogueLane')

@section('content')

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

  $currentCat = request('category') ?: request('cat');
  $currentColl = request('collection');
  $currentSort = request('sort', 'latest');
  $currentSearch = request('q');
@endphp

<!-- Page Breadcrumbs & Header -->
<div class="bg-vog-ivory border-b border-vog-border py-8 sm:py-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-2">
      <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium uppercase tracking-wider">
        <a href="{{ $vogRoute('store.index') }}" class="hover:text-slate-900 transition-colors">Home</a>
        <span>&rsaquo;</span>
        <span class="text-slate-900 font-semibold">
          @if($currentCat)
            {{ is_numeric($currentCat) ? ($categories->firstWhere('id', $currentCat)->name ?? 'Category') : $currentCat }}
          @elseif($currentColl)
            {{ ucwords(str_replace('-', ' ', $currentColl)) }}
          @elseif($currentSearch)
            Search: "{{ $currentSearch }}"
          @else
            All Collections
          @endif
        </span>
      </nav>
      <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
        @if($currentCat)
          {{ is_numeric($currentCat) ? ($categories->firstWhere('id', $currentCat)->name ?? 'Category') : $currentCat }}
        @elseif($currentColl)
          {{ ucwords(str_replace('-', ' ', $currentColl)) }}
        @elseif($currentSearch)
          Results for &ldquo;{{ $currentSearch }}&rdquo;
        @else
          The Collection
        @endif
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-normal">
        Showing {{ $products->total() }} luxury fashion piece{{ $products->total() == 1 ? '' : 's' }}
      </p>
    </div>
  </div>
</div>

<!-- Shop Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Sidebar Filters (3 cols on desktop) -->
    <aside class="lg:col-span-3 space-y-6 sm:space-y-8 bg-white lg:sticky lg:top-28">
      
      <!-- Category Filter -->
      <div class="border border-vog-border rounded-2xl p-5 bg-vog-ivory space-y-4">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center justify-between">
          <span>Categories</span>
          @if($currentCat)
            <a href="{{ $vogRoute('store.shop') }}" class="text-[10px] text-vog-tan hover:underline lowercase font-normal">Clear</a>
          @endif
        </h3>
        <ul class="space-y-2 text-xs font-medium">
          <li>
            <a href="{{ $vogRoute('store.shop') }}" 
               class="flex items-center justify-between py-1 transition-colors {{ !$currentCat ? 'text-vog-tan font-bold' : 'text-slate-600 hover:text-slate-900' }}">
              <span>All Categories</span>
              <span class="text-slate-400">&rsaquo;</span>
            </a>
          </li>
          @foreach($categories as $category)
            @php
              $isActive = ($currentCat == $category->id || $currentCat == $category->name);
            @endphp
            <li>
              <a href="{{ $vogRoute('store.shop', ['category' => $category->name]) }}" 
                 class="flex items-center justify-between py-1 transition-colors {{ $isActive ? 'text-vog-tan font-bold' : 'text-slate-600 hover:text-slate-900' }}">
                <span>{{ $category->name }}</span>
                <span class="text-slate-400">&rsaquo;</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Quick Collections -->
      <div class="border border-vog-border rounded-2xl p-5 bg-vog-ivory space-y-4">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
          Curated Lines
        </h3>
        <ul class="space-y-2 text-xs font-medium">
          <li>
            <a href="{{ $vogRoute('store.shop', ['collection' => 'new-in']) }}" 
               class="flex items-center justify-between py-1 transition-colors {{ $currentColl === 'new-in' ? 'text-vog-tan font-bold' : 'text-slate-600 hover:text-slate-900' }}">
              <span>✨ New In</span>
              <span class="text-slate-400">&rsaquo;</span>
            </a>
          </li>
          <li>
            <a href="{{ $vogRoute('store.shop', ['collection' => 'bestselling']) }}" 
               class="flex items-center justify-between py-1 transition-colors {{ $currentColl === 'bestselling' ? 'text-vog-tan font-bold' : 'text-slate-600 hover:text-slate-900' }}">
              <span>🔥 Best Sellers</span>
              <span class="text-slate-400">&rsaquo;</span>
            </a>
          </li>
          <li>
            <a href="{{ $vogRoute('store.shop', ['collection' => 'top-rated']) }}" 
               class="flex items-center justify-between py-1 transition-colors {{ $currentColl === 'top-rated' ? 'text-vog-tan font-bold' : 'text-slate-600 hover:text-slate-900' }}">
              <span>⭐ Top Rated</span>
              <span class="text-slate-400">&rsaquo;</span>
            </a>
          </li>
          <li>
            <a href="{{ $vogRoute('store.shop', ['collection' => 'sale']) }}" 
               class="flex items-center justify-between py-1 text-vog-sale font-semibold hover:underline">
              <span>🏷️ Summer Sale</span>
              <span class="text-vog-sale">&rsaquo;</span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Filter Form: Price & Sort -->
      <form action="{{ $vogRoute('store.shop') }}" method="GET" class="border border-vog-border rounded-2xl p-5 bg-vog-ivory space-y-4">
        @if($themePreview)
          <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
        @endif
        @if($currentCat)
          <input type="hidden" name="category" value="{{ $currentCat }}">
        @endif
        @if($currentColl)
          <input type="hidden" name="collection" value="{{ $currentColl }}">
        @endif

        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
          Price Range
        </h3>
        
        <div class="grid grid-cols-2 gap-2">
          <input type="number" 
                 name="min_price" 
                 value="{{ request('min_price') }}" 
                 placeholder="Min $" 
                 class="w-full text-xs p-2.5 bg-white border border-vog-border rounded-lg outline-none focus:border-slate-900">
          <input type="number" 
                 name="max_price" 
                 value="{{ request('max_price') }}" 
                 placeholder="Max $" 
                 class="w-full text-xs p-2.5 bg-white border border-vog-border rounded-lg outline-none focus:border-slate-900">
        </div>

        <button type="submit" class="w-full py-2.5 bg-vog-black hover:bg-neutral-800 text-white text-xs font-semibold rounded-lg transition-colors">
          Apply Filter
        </button>
      </form>

    </aside>

    <!-- Product Grid & Toolbar (9 cols on desktop) -->
    <main class="lg:col-span-9 space-y-6">
      
      <!-- Toolbar: Sort & Count -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-vog-ivory border border-vog-border rounded-xl p-3 sm:px-5">
        <span class="text-xs text-slate-600 font-medium">
          Showing <strong>{{ $products->count() }}</strong> of <strong>{{ $products->total() }}</strong> pieces
        </span>

        <!-- Sort Select -->
        <div class="flex items-center gap-2">
          <label for="sort-select" class="text-xs text-slate-500 font-medium">Sort by:</label>
          <select id="sort-select" 
                  onchange="window.location.href=this.value" 
                  class="text-xs font-semibold bg-white border border-vog-border rounded-lg px-3 py-1.5 outline-none focus:border-slate-900 text-slate-800">
            <option value="{{ $vogRoute('store.shop', array_merge(request()->query(), ['sort' => 'latest'])) }}" {{ $currentSort === 'latest' ? 'selected' : '' }}>Newest</option>
            <option value="{{ $vogRoute('store.shop', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="{{ $vogRoute('store.shop', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </div>
      </div>

      <!-- Products Grid -->
      @if($products->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          @foreach($products as $p)
            @php
              $prodVm = is_array($p) ? $p : \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices);
            @endphp
            @include('store.themes.voguelane-couture.partials.product-card', ['product' => $prodVm])
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="pt-8 flex justify-center">
          {{ $products->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-16 px-4 bg-vog-ivory rounded-2xl border border-vog-border space-y-4">
          <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto text-slate-400 border border-vog-border shadow-xs">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" /></svg>
          </div>
          <h3 class="font-serif-luxury text-xl font-bold text-slate-900">No products found</h3>
          <p class="text-xs text-slate-500 max-w-sm mx-auto">
            We couldn't find any fashion items matching your criteria. Try adjusting your filters or category selection.
          </p>
          <a href="{{ $vogRoute('store.shop') }}" class="inline-block px-6 py-2.5 bg-vog-black text-white text-xs font-semibold rounded-full hover:bg-neutral-800 transition-colors">
            View All Products
          </a>
        </div>
      @endif

    </main>

  </div>
</div>

@endsection
