@extends('store.themes.verde._shell')

@section('title', 'Catalog | Verde Living — Sustainable Lifestyle & Organic Decor')
@section('meta_description', 'Explore sustainable living essentials, natural organic home decor, non-toxic cleaning, and eco-friendly bath & body.')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
    
    $currentCategory = request('category', request('cat', ''));
    $currentCollection = request('collection', '');
    $searchQuery = request('q', '');
    $currentSort = request('sort', 'newest');
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-10">

    <!-- Page Header & Breadcrumbs -->
    <div class="border-b border-verde-borderLight pb-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-stone-500 mb-3">
            <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-verde-primary transition-colors">Home</a>
            <span>/</span>
            <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-verde-primary transition-colors">Shop</a>
            @if($currentCategory)
                <span>/</span>
                <span class="text-verde-primary font-semibold capitalize">{{ str_replace('-', ' ', $currentCategory) }}</span>
            @elseif($currentCollection)
                <span>/</span>
                <span class="text-verde-primary font-semibold capitalize">{{ str_replace('-', ' ', $currentCollection) }}</span>
            @endif
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl text-verde-dark font-medium capitalize">
                    @if($searchQuery)
                        Search: "{{ $searchQuery }}"
                    @elseif($currentCategory)
                        {{ str_replace('-', ' ', $currentCategory) }}
                    @elseif($currentCollection)
                        {{ str_replace('-', ' ', $currentCollection) }}
                    @else
                        All Sustainable Living
                    @endif
                </h1>
                <p class="text-xs text-stone-500 mt-1 font-light">
                    Showing {{ $products->count() }} eco-friendly products curated for mindful living.
                </p>
            </div>

            <!-- Sort Dropdown -->
            <form action="{{ url('/online_store/shop') }}" method="GET" class="flex items-center gap-2">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                @if($currentCollection)
                    <input type="hidden" name="collection" value="{{ $currentCollection }}">
                @endif
                @if($searchQuery)
                    <input type="hidden" name="q" value="{{ $searchQuery }}">
                @endif

                <label for="sort" class="text-xs font-semibold text-stone-600 whitespace-nowrap">Sort By:</label>
                <select name="sort" 
                        id="sort" 
                        onchange="this.form.submit()"
                        class="bg-white border border-verde-border text-xs rounded-xl px-3 py-2 text-stone-800 focus:outline-hidden focus:border-verde-primary shadow-xs">
                    <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ $currentSort === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                </select>
            </form>
        </div>

        <!-- Horizontal Category Pills Bar -->
        <div class="flex items-center gap-2 overflow-x-auto py-4 scrollbar-none">
            <a href="{{ url('/online_store/shop' . $previewParam) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ empty($currentCategory) && empty($currentCollection) ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                All Products
            </a>
            <a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'home-decor' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Home & Decor
            </a>
            <a href="{{ url('/online_store/shop?category=cleaning-essentials' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'cleaning-essentials' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Cleaning Essentials
            </a>
            <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'bath-body' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Bath & Body
            </a>
            <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'kitchen-dining' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Kitchen & Dining
            </a>
            <a href="{{ url('/online_store/shop?category=gifts-sets' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'gifts-sets' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Gifts & Sets
            </a>
            <a href="{{ url('/online_store/shop?category=beauty' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCategory === 'beauty' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                Beauty
            </a>
            <a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCollection === 'best-sellers' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                ★ Best Sellers
            </a>
            <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" 
               class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-all {{ $currentCollection === 'new-arrivals' ? 'bg-verde-primary text-white shadow-xs' : 'bg-white text-stone-700 hover:bg-verde-sand border border-verde-borderLight' }}">
                🌿 New Arrivals
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @forelse($products as $product)
            @include('store.themes.verde.partials.product-card', ['product' => $product])
        @empty
            <div class="col-span-full py-16 text-center space-y-4 bg-white rounded-3xl border border-verde-borderLight p-8">
                <div class="w-16 h-16 rounded-full bg-verde-sand text-verde-muted flex items-center justify-center mx-auto text-2xl">
                    🌿
                </div>
                <h3 class="text-base font-bold text-verde-dark">No products found</h3>
                <p class="text-xs text-stone-500 max-w-sm mx-auto">
                    We couldn't find any sustainable items matching your filters. Try clearing search or selecting a different category.
                </p>
                <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                   class="inline-block px-6 py-2.5 bg-verde-btn text-white text-xs font-bold rounded-xl shadow-xs hover:bg-verde-btnHover transition-colors">
                    Reset Catalog
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
        <div class="pt-8">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection
