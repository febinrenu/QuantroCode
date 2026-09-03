@extends('store.themes.zanova-flash._shell')

@section('title', 'Shop All Products — ZANOVA Marketplace')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
    $currentCat = request('category', '');
    $currentSort = request('sort', 'featured');
    $currentQuery = request('q', '');
    $currentCollection = request('collection', '');
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Page Header & Breadcrumb -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1">
                <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-navy">Home</a>
                <span>/</span>
                <span class="text-slate-700">Shop Catalog</span>
                @if($currentCat)
                    <span>/</span>
                    <span class="text-zanova-purple font-bold capitalize">{{ str_replace('-', ' ', $currentCat) }}</span>
                @endif
            </nav>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                @if($currentQuery)
                    Search Results for "{{ $currentQuery }}"
                @elseif($currentCollection === 'mega-deals')
                    🔥 Mega Deals & Discounts
                @elseif($currentCollection === 'top-brands')
                    ⭐ Top Featured Brands
                @elseif($currentCat)
                    {{ ucwords(str_replace(['-', '_'], ' ', $currentCat)) }}
                @else
                    All Marketplace Products
                @endif
            </h1>
        </div>

        <!-- Sort Control Dropdown -->
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-slate-500 whitespace-nowrap">Sort By:</span>
            <form action="{{ url('/online_store/shop') }}" method="GET" class="relative">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                @if($currentCat)
                    <input type="hidden" name="category" value="{{ $currentCat }}">
                @endif
                @if($currentQuery)
                    <input type="hidden" name="q" value="{{ $currentQuery }}">
                @endif
                @if($currentCollection)
                    <input type="hidden" name="collection" value="{{ $currentCollection }}">
                @endif

                <select name="sort"
                        onchange="this.form.submit()"
                        class="bg-white border border-slate-300 text-xs font-bold text-slate-800 rounded-xl px-3.5 py-2 pr-8 focus:outline-hidden focus:border-zanova-yellow cursor-pointer shadow-xs">
                    <option value="featured" {{ $currentSort === 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ $currentSort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Category Filter Pills Strip -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
        <a href="{{ url('/online_store/shop' . $previewParam) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ empty($currentCat) && empty($currentCollection) ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            All Products
        </a>
        <a href="{{ url('/online_store/shop?category=electronics' . $previewAmp) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ $currentCat === 'electronics' ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            💻 Electronics
        </a>
        <a href="{{ url('/online_store/shop?category=fashion-apparel' . $previewAmp) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ $currentCat === 'fashion-apparel' ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            👕 Fashion & Apparel
        </a>
        <a href="{{ url('/online_store/shop?category=home-kitchen' . $previewAmp) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ $currentCat === 'home-kitchen' ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            🏠 Home & Kitchen
        </a>
        <a href="{{ url('/online_store/shop?category=beauty-personal-care' . $previewAmp) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ $currentCat === 'beauty-personal-care' ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            🧴 Beauty & Personal Care
        </a>
        <a href="{{ url('/online_store/shop?category=sports-outdoors' . $previewAmp) }}"
           class="px-4 py-2 rounded-xl text-xs font-extrabold whitespace-nowrap transition-all {{ $currentCat === 'sports-outdoors' ? 'bg-zanova-navy text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            ⚽ Sports & Outdoors
        </a>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 sm:gap-5">
        @forelse($products as $product)
            @include('store.themes.zanova-flash.partials.product-card', ['product' => $product])
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-4">
                    🔍
                </div>
                <h3 class="text-base font-bold text-slate-800">No products found</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    We couldn't find any items matching your selected criteria. Try adjusting your search or clearing your filters.
                </p>
                <div class="mt-6">
                    <a href="{{ url('/online_store/shop' . $previewParam) }}" class="px-5 py-2.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy text-xs font-black rounded-xl transition-colors inline-flex items-center gap-2 shadow-xs">
                        <span>Clear All Filters</span>
                        <span>↺</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
        <div class="pt-6">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection
