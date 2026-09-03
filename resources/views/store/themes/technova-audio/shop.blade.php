@extends('store.themes.technova-audio._shell')

@php
    $currentCategory = request('category', '');
    $currentBrand = request('brand', '');
    $currentCollection = request('collection', '');
    $currentSort = request('sort', 'latest');
    $searchQuery = request('q', '');
    $previewTheme = request('preview_theme', 'technova');

    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };

    $prods = $products ?? collect([]);
    $totalCount = method_exists($prods, 'total') ? $prods->total() : $prods->count();
@endphp

@section('title', ($currentCategory ? $currentCategory . ' | TechNova Electronics' : 'Catalog | TechNova Electronics'))

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs & Heading -->
        <div class="mb-6">
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ $themeUrl('online_store') }}" class="hover:text-blue-600 transition">Home</a>
                <span>/</span>
                <a href="{{ $themeUrl('online_store/shop') }}" class="hover:text-blue-600 transition">Shop</a>
                @if($currentCategory)
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">{{ $currentCategory }}</span>
                @elseif($currentCollection)
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">{{ ucwords(str_replace('-', ' ', $currentCollection)) }}</span>
                @endif
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight font-heading">
                        @if($searchQuery)
                            Search Results for "{{ $searchQuery }}"
                        @elseif($currentCategory)
                            {{ $currentCategory }}
                        @elseif($currentCollection)
                            {{ ucwords(str_replace('-', ' ', $currentCollection)) }}
                        @elseif($currentBrand)
                            {{ $currentBrand }} Products
                        @else
                            All Electronics & Gadgets
                        @endif
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Showing {{ $totalCount }} products available with fast dispatch
                    </p>
                </div>

                <!-- Sorting Dropdown -->
                <form action="{{ url('online_store/shop') }}" method="GET" class="flex items-center gap-2 text-xs">
                    @if($previewTheme) <input type="hidden" name="preview_theme" value="{{ $previewTheme }}"> @endif
                    @if($currentCategory) <input type="hidden" name="category" value="{{ $currentCategory }}"> @endif
                    @if($currentBrand) <input type="hidden" name="brand" value="{{ $currentBrand }}"> @endif
                    @if($currentCollection) <input type="hidden" name="collection" value="{{ $currentCollection }}"> @endif
                    @if($searchQuery) <input type="hidden" name="q" value="{{ $searchQuery }}"> @endif

                    <label for="sort" class="font-bold text-slate-700">Sort By:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()" class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:border-blue-600 cursor-pointer shadow-sm">
                        <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Latest Arrivals</option>
                        <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ $currentSort === 'name_asc' ? 'selected' : '' }}>Product Name A-Z</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Main Layout: Sidebar Filters + Products Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            <!-- Sidebar Filters -->
            <div class="space-y-6">
                <!-- Active Filters Clear Badge -->
                @if($currentCategory || $currentBrand || $currentCollection || $searchQuery)
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-900">Filters Active</span>
                        <a href="{{ $themeUrl('online_store/shop') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 underline">
                            Clear All
                        </a>
                    </div>
                @endif

                <!-- Category Filters -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-tech-sm">
                    <h3 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider mb-4 font-heading border-b border-slate-100 pb-2">
                        Categories
                    </h3>
                    @php
                        $shopCats = ['Smartphones', 'Laptops', 'Tablets', 'Audio', 'Gaming', 'Cameras', 'Smart Home', 'Accessories'];
                    @endphp
                    <div class="space-y-1">
                        <a href="{{ $themeUrl('online_store/shop') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ !$currentCategory ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }} transition">
                            <span>All Categories</span>
                        </a>
                        @foreach($shopCats as $sc)
                            <a href="{{ $themeUrl('online_store/shop', ['category' => $sc]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ $currentCategory === $sc ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }} transition">
                                <span>{{ $sc }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Brand Filters -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-tech-sm">
                    <h3 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider mb-4 font-heading border-b border-slate-100 pb-2">
                        Top Brands
                    </h3>
                    @php
                        $shopBrands = ['Apple', 'Samsung', 'Sony', 'Google', 'ASUS', 'Razer', 'Anker', 'DJI'];
                    @endphp
                    <div class="space-y-1">
                        @foreach($shopBrands as $sb)
                            <a href="{{ $themeUrl('online_store/shop', array_merge(request()->all(), ['brand' => $sb])) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ $currentBrand === $sb ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }} transition">
                                <span>{{ $sb }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Collection Filters -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-tech-sm">
                    <h3 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider mb-4 font-heading border-b border-slate-100 pb-2">
                        Special Collections
                    </h3>
                    @php
                        $shopCollections = [
                            'deals' => '🔥 Exclusive Deals',
                            'bestsellers' => '⭐ Best Sellers',
                            'new-arrivals' => '✨ New Arrivals',
                            'top-picks' => '🎯 Top Picks',
                        ];
                    @endphp
                    <div class="space-y-1">
                        @foreach($shopCollections as $cSlug => $cLabel)
                            <a href="{{ $themeUrl('online_store/shop', ['collection' => $cSlug]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ $currentCollection === $cSlug ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-50' }} transition">
                                <span>{{ $cLabel }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @if($prods->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">
                            🔍
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">No Products Found</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto mb-6">
                            We couldn't find any electronics matching your selected filters. Try searching for a different keyword or resetting your filters.
                        </p>
                        <a href="{{ $themeUrl('online_store/shop') }}" class="inline-flex px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-sm">
                            Reset All Filters
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($prods as $p)
                            @include('store.themes.technova-audio.partials.product-card', ['p' => $p])
                        @endforeach
                    </div>

                    <!-- Pagination Links if available -->
                    @if(method_exists($prods, 'links'))
                        <div class="mt-10">
                            {{ $prods->withQueryString()->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
