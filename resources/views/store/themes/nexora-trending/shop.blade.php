@extends('store.themes.nexora-trending._shell')

@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $currentCategory = request('category', '');
    $currentSort = request('sort', 'latest');
@endphp

@section('title', 'Marketplace Catalog — Nexora')

@section('content')

<!-- Catalog Header & Breadcrumbs -->
<div class="bg-white border-b border-slate-200/80 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb -->
        <nav class="flex text-xs text-slate-400 mb-2">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ $storeUrl }}" class="hover:text-nex-blue transition">Home</a></li>
                <li><span>/</span></li>
                <li class="text-nex-navy font-bold">Catalog</li>
                @if($currentCategory)
                    <li><span>/</span></li>
                    <li class="text-nex-blue font-bold">{{ $currentCategory }}</li>
                @endif
            </ol>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-nex-navy uppercase tracking-tight">
                    {{ $currentCategory ? $currentCategory : 'All Marketplace Products' }}
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Showing {{ count($products) }} curated items
                </p>
            </div>

            <!-- Sorting Dropdown -->
            <form method="GET" action="{{ url('online_store/shop') }}" class="flex items-center gap-2">
                @if($previewTheme)
                    <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                @endif
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif

                <label for="sort-select" class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sort by:</label>
                <select id="sort-select"
                        name="sort"
                        onchange="this.form.submit()"
                        class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-nex-navy focus:outline-none focus:border-nex-blue">
                    <option value="latest" {{ $currentSort === 'latest' ? 'selected' : '' }}>Latest Arrivals</option>
                    <option value="price_low" {{ $currentSort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ $currentSort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ $currentSort === 'name' ? 'selected' : '' }}>Product Name</option>
                </select>
            </form>
        </div>

    </div>
</div>

<!-- Main Catalog Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Sidebar Filters (3 Cols) -->
        <aside class="lg:col-span-3 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs space-y-6">

                <!-- Category Filter -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-nex-navy border-b border-slate-100 pb-2 mb-3">
                        Categories
                    </h3>
                    <ul class="space-y-1.5 text-xs font-semibold text-slate-600">
                        <li>
                            <a href="{{ url('online_store/shop' . ($previewTheme ? '?preview_theme=' . $previewTheme : '')) }}"
                               class="flex items-center justify-between py-1.5 px-2.5 rounded-xl {{ empty($currentCategory) ? 'bg-blue-50 text-nex-blue font-bold' : 'hover:bg-slate-50 hover:text-nex-blue' }}">
                                <span>All Categories</span>
                            </a>
                        </li>
                        @foreach($categories as $catItem)
                            <li>
                                <a href="{{ url('online_store/shop?category=' . urlencode($catItem->name) . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                                   class="flex items-center justify-between py-1.5 px-2.5 rounded-xl {{ $currentCategory === $catItem->name ? 'bg-blue-50 text-nex-blue font-bold' : 'hover:bg-slate-50 hover:text-nex-blue' }}">
                                    <span>{{ $catItem->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Quick Filter -->
                <div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-nex-navy border-b border-slate-100 pb-2 mb-3">
                        Price Range
                    </h3>
                    <div class="space-y-1.5 text-xs font-semibold text-slate-600">
                        <a href="{{ url('online_store/shop?min=0&max=50' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block py-1.5 px-2.5 rounded-xl hover:bg-slate-50 hover:text-nex-blue">Under $50</a>
                        <a href="{{ url('online_store/shop?min=50&max=100' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block py-1.5 px-2.5 rounded-xl hover:bg-slate-50 hover:text-nex-blue">$50 to $100</a>
                        <a href="{{ url('online_store/shop?min=100&max=200' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block py-1.5 px-2.5 rounded-xl hover:bg-slate-50 hover:text-nex-blue">$100 to $200</a>
                        <a href="{{ url('online_store/shop?min=200' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="block py-1.5 px-2.5 rounded-xl hover:bg-slate-50 hover:text-nex-blue">$200 & Above</a>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Right Products Grid (9 Cols) -->
        <main class="lg:col-span-9 space-y-6">
            @if(count($products) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-5">
                    @foreach($products as $prod)
                        @include('store.themes.nexora-trending.partials.product-card', ['product' => $prod])
                    @endforeach
                </div>

                @if(method_exists($products, 'links'))
                    <div class="pt-6">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-3xl p-12 text-center max-w-md mx-auto border border-slate-200 shadow-xs space-y-4">
                    <div class="text-4xl">🔍</div>
                    <h2 class="text-lg font-black text-nex-navy">No products found</h2>
                    <p class="text-xs text-slate-500">
                        Try adjusting your search keywords or category filters.
                    </p>
                    <div class="pt-2">
                        <a href="{{ url('online_store/shop' . ($previewTheme ? '?preview_theme=' . $previewTheme : '')) }}"
                           class="inline-block px-6 py-2.5 bg-nex-blue text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-nex-bluedark transition">
                            Clear Filters
                        </a>
                    </div>
                </div>
            @endif
        </main>

    </div>
</div>

@endsection
