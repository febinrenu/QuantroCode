@extends('store.themes.urbanic._shell')

@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $currentCategory = request('category', '');
    $currentSort = request('sort', '');
    $currentCollection = request('collection', '');
@endphp

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Breadcrumb & Title Header -->
    <div class="space-y-2 border-b border-slate-200 pb-5">
        <nav class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
            <a href="{{ $storeUrl }}" class="hover:text-orange-600 transition">Home</a>
            <span>/</span>
            <a href="{{ $shopUrl }}" class="hover:text-orange-600 transition">Shop</a>
            @if($currentCategory)
                <span>/</span>
                <span class="text-urb-dark font-bold">{{ $currentCategory }}</span>
            @elseif($currentCollection)
                <span>/</span>
                <span class="text-urb-dark font-bold">{{ ucwords(str_replace('-', ' ', $currentCollection)) }}</span>
            @endif
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-urb-dark tracking-tight uppercase">
                    @if($currentCategory)
                        {{ $currentCategory }}
                    @elseif($currentCollection)
                        {{ ucwords(str_replace('-', ' ', $currentCollection)) }}
                    @else
                        Fashion & Lifestyle Collection
                    @endif
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Showing {{ $products->total() ?? count($products) }} fashion items
                </p>
            </div>

            <!-- Sort By Dropdown -->
            <form action="{{ $shopUrl }}" method="GET" class="flex items-center gap-2">
                @if($previewTheme)
                    <input type="hidden" name="preview_theme" value="{{ $previewTheme }}">
                @endif
                @if($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
                @if($currentCollection)
                    <input type="hidden" name="collection" value="{{ $currentCollection }}">
                @endif

                <label for="sort" class="text-xs font-bold text-slate-600 shrink-0">Sort By:</label>
                <select name="sort"
                        id="sort"
                        onchange="this.form.submit()"
                        class="bg-white border border-slate-200 text-xs font-bold text-slate-800 rounded-xl px-3 py-2 focus:outline-none focus:border-orange-500 shadow-xs">
                    <option value="" {{ $currentSort == '' ? 'selected' : '' }}>Featured</option>
                    <option value="price_asc" {{ $currentSort == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ $currentSort == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Main Grid: Sidebar + Product Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Sidebar: Categories & Filters -->
        <aside class="lg:col-span-1 space-y-6">

            <!-- Category Filter Box -->
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 space-y-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-urb-dark">
                    Categories
                </h3>

                <ul class="space-y-1.5 text-xs font-bold">
                    <li>
                        <a href="{{ $shopUrl }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ empty($currentCategory) && empty($currentCollection) ? 'bg-orange-500 text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-orange-600' }}">
                            <span>All Fashion</span>
                            <span>•</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        @php
                            $catLink = url('online_store/shop?category=' . urlencode($cat->name) . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
                            $isActive = strcasecmp($currentCategory, $cat->name) === 0;
                        @endphp
                        <li>
                            <a href="{{ $catLink }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl transition {{ $isActive ? 'bg-orange-500 text-white shadow-xs' : 'text-slate-700 hover:bg-slate-100 hover:text-orange-600' }}">
                                <span>{{ $cat->name }}</span>
                                <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Collections Filter Box -->
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200/80 space-y-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-urb-dark">
                    Collections
                </h3>

                <ul class="space-y-1.5 text-xs font-bold text-slate-700">
                    <li>
                        <a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-slate-100 hover:text-orange-600 transition {{ $currentCollection === 'new-arrivals' ? 'bg-orange-500 text-white' : '' }}">
                            <span>⭐ New Arrivals</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-slate-100 hover:text-orange-600 transition {{ $currentCollection === 'bestsellers' ? 'bg-orange-500 text-white' : '' }}">
                            <span>🔥 Best Sellers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-slate-100 hover:text-orange-600 transition {{ $currentCollection === 'deals' ? 'bg-orange-500 text-white' : '' }}">
                            <span>⚡ Hot Summer Sale</span>
                        </a>
                    </li>
                </ul>
            </div>

        </aside>

        <!-- Products Grid Area -->
        <div class="lg:col-span-3 space-y-8">

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6">
                @forelse($products as $prod)
                    @include('store.themes.urbanic.partials.product-card', ['product' => $prod])
                @empty
                    <div class="col-span-full py-16 text-center bg-slate-50 rounded-2xl border border-slate-200">
                        <div class="text-4xl mb-3">👗</div>
                        <h3 class="text-base font-bold text-slate-800">No fashion products found</h3>
                        <p class="text-xs text-slate-500 mt-1">Try selecting another category or clearing your filters.</p>
                        <a href="{{ $shopUrl }}" class="inline-block mt-4 px-6 py-2.5 bg-orange-500 text-white text-xs font-black uppercase rounded-full shadow-md">
                            Clear Filters
                        </a>
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

    </div>

</div>

@endsection
