@extends('store.themes.naturae-wellness._shell')

@section('title', 'Shop Natural Wellness & Organic Beauty — Naturae')

@section('content')
@php
    $previewTheme = request('preview_theme', 'naturae');
    $currentCat = request('category', '');
    $currentSort = request('sort', 'featured');
    $currentQ = request('q', '');
    $currentCollection = request('collection', '');
@endphp

<!-- Hero Banner -->
<div class="bg-naturae-sand/80 border-b border-naturae-border/80 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs font-bold uppercase tracking-widest text-naturae-sage">100% Pure & Certified</span>
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-naturae-forest mt-1">
            @if($currentCat)
                {{ $currentCat }}
            @elseif($currentCollection === 'new-arrivals')
                New Arrivals
            @elseif($currentCollection === 'bestsellers')
                Best Sellers
            @elseif($currentCollection === 'deals')
                Special Offers & Bundles
            @elseif($currentQ)
                Search Results for "{{ $currentQ }}"
            @else
                Botanical Wellness Catalog
            @endif
        </h1>
        <p class="text-xs sm:text-sm text-naturae-muted max-w-xl mx-auto mt-2">
            Formulated without toxins, synthetic parabens, or artificial fragrances. Pure care for body and soul.
        </p>
    </div>
</div>

<!-- Catalog Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Left Sidebar Filters (1 Col) -->
        <div class="space-y-6">

            <!-- Category Filter Box -->
            <div class="bg-white p-5 rounded-2xl border border-naturae-border shadow-sm">
                <h3 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider mb-3 pb-2 border-b border-naturae-border">
                    Categories
                </h3>
                <ul class="space-y-1.5 text-xs">
                    <li>
                        <a href="{{ url('online_store/shop' . ($previewTheme ? '?preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between py-1.5 px-2 rounded-lg transition {{ empty($currentCat) && empty($currentCollection) ? 'bg-naturae-forest text-white font-semibold' : 'text-naturae-text/80 hover:bg-naturae-sand hover:text-naturae-forest' }}">
                            <span>All Products</span>
                        </a>
                    </li>
                    @php
                        $natCats = [
                            'Skincare',
                            'Hair Care',
                            'Bath & Body',
                            'Wellness',
                            'Home Care',
                            'Organic Tea',
                            'Gift Sets',
                            'Accessories',
                        ];
                    @endphp
                    @foreach($natCats as $catName)
                        @php
                            $isActive = (strcasecmp($currentCat, $catName) === 0);
                            $catParam = urlencode($catName);
                            $url = url("online_store/shop?category={$catParam}" . ($previewTheme ? "&preview_theme={$previewTheme}" : ''));
                        @endphp
                        <li>
                            <a href="{{ $url }}"
                               class="flex items-center justify-between py-1.5 px-2 rounded-lg transition {{ $isActive ? 'bg-naturae-forest text-white font-semibold' : 'text-naturae-text/80 hover:bg-naturae-sand hover:text-naturae-forest' }}">
                                <span>{{ $catName }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Collections Filter Box -->
            <div class="bg-white p-5 rounded-2xl border border-naturae-border shadow-sm">
                <h3 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider mb-3 pb-2 border-b border-naturae-border">
                    Curated Edits
                </h3>
                <ul class="space-y-1.5 text-xs">
                    <li>
                        <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between py-1.5 px-2 rounded-lg transition {{ $currentCollection === 'new-arrivals' ? 'bg-naturae-forest text-white font-semibold' : 'text-naturae-text/80 hover:bg-naturae-sand hover:text-naturae-forest' }}">
                            <span>✨ New Arrivals</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between py-1.5 px-2 rounded-lg transition {{ $currentCollection === 'bestsellers' ? 'bg-naturae-forest text-white font-semibold' : 'text-naturae-text/80 hover:bg-naturae-sand hover:text-naturae-forest' }}">
                            <span>⭐ Best Sellers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between py-1.5 px-2 rounded-lg transition {{ $currentCollection === 'deals' ? 'bg-naturae-forest text-white font-semibold' : 'text-naturae-text/80 hover:bg-naturae-sand hover:text-naturae-forest' }}">
                            <span>🌿 Bundles & Deals</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Right Products Grid Area (3 Cols) -->
        <div class="lg:col-span-3 space-y-6">

            <!-- Top Controls Strip -->
            <div class="bg-white p-4 rounded-2xl border border-naturae-border flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                <div class="text-xs text-naturae-muted">
                    Showing <strong class="text-naturae-forest">{{ count($products) }}</strong> pure organic products
                </div>

                <!-- Sorting Dropdown -->
                <form method="GET" action="{{ url('online_store/shop') }}" class="flex items-center gap-2">
                    @if($previewTheme)<input type="hidden" name="preview_theme" value="{{ $previewTheme }}">@endif
                    @if($currentCat)<input type="hidden" name="category" value="{{ $currentCat }}">@endif
                    @if($currentCollection)<input type="hidden" name="collection" value="{{ $currentCollection }}">@endif
                    @if($currentQ)<input type="hidden" name="q" value="{{ $currentQ }}">@endif

                    <label for="sort" class="text-xs text-naturae-muted font-medium">Sort by:</label>
                    <select name="sort"
                            id="sort"
                            onchange="this.form.submit()"
                            class="bg-naturae-bg border border-naturae-border rounded-lg text-xs py-1.5 pl-2.5 pr-7 text-naturae-text focus:outline-none focus:border-naturae-forest">
                        <option value="featured" {{ $currentSort === 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ $currentSort === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid (4 cols on desktop) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
                @forelse($products as $product)
                    @include('store.themes.naturae-wellness.partials.product-card', ['product' => $product])
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center border border-naturae-border">
                        <div class="text-3xl mb-2">🌿</div>
                        <h3 class="font-serif text-base font-bold text-naturae-forest">No products found</h3>
                        <p class="text-xs text-naturae-muted mt-1">Try selecting another category or clear your search filters.</p>
                        <a href="{{ url('online_store/shop' . ($previewTheme ? '?preview_theme=' . $previewTheme : '')) }}"
                           class="inline-block mt-4 px-4 py-2 bg-naturae-forest text-white rounded-lg text-xs font-semibold uppercase tracking-wider">
                            View All Products
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links if available -->
            @if(method_exists($products, 'links'))
                <div class="pt-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

    </div>
</div>

@endsection
