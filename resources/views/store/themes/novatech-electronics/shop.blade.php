@extends('store.themes.novatech-electronics._shell')

@section('title', 'Shop All Tech & Electronics — NOVATECH')
@section('meta_description', 'Explore our comprehensive selection of high-performance laptops, 5G smartphones, smartwatches, ANC audio gear, cameras, and gaming gear at NovaTech.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500 mb-2">
                <a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="hover:text-indigo-600 transition-colors">Home</a>
                <span>/</span>
                <span class="text-slate-900 font-bold">Shop</span>
                @if(request('category'))
                    <span>/</span>
                    <span class="text-indigo-600 font-bold capitalize">{{ str_replace('-', ' ', request('category')) }}</span>
                @endif
            </nav>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight uppercase">
                @if(request('category'))
                    {{ str_replace('-', ' ', request('category')) }}
                @elseif(request('q'))
                    Search results for "{{ request('q') }}"
                @else
                    All Tech Products
                @endif
            </h1>
        </div>

        <!-- Result count & Sorting -->
        <div class="flex items-center space-x-4">
            <span class="text-xs font-semibold text-slate-500">
                Showing <strong class="text-slate-900">{{ $products->count() }}</strong> products
            </span>
        </div>
    </div>

    <!-- Main Layout: Sidebar Filters + Products Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">

        <!-- 1. Left Sidebar Filters -->
        <aside class="space-y-6">
            <!-- Categories Filter Widget -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center justify-between">
                    <span>Categories</span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </h3>
                <ul class="space-y-1.5 text-xs">
                    <li>
                        <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl font-bold transition-colors {{ !request('category') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span>All Products</span>
                        </a>
                    </li>
                    @php
                        $nvtCategories = [
                            'laptops'          => '💻 Laptops',
                            'smartphones'      => '📱 Smartphones',
                            'wearables'        => '⌚ Wearables',
                            'audio'            => '🎧 Audio & Headphones',
                            'gaming'           => '🎮 Gaming',
                            'accessories'      => '🔌 Accessories',
                            'cameras'          => '📷 Cameras',
                            'smart-home'       => '🏠 Smart Home',
                            'software'         => '💿 Software',
                            'home-appliances'  => '🏠 Home Appliances',
                        ];
                    @endphp
                    @foreach($nvtCategories as $slug => $name)
                        <li>
                            <a href="{{ route('store.shop', ['preview_theme' => 'novatech', 'category' => $slug]) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl font-medium transition-colors {{ request('category') === $slug ? 'bg-indigo-50 text-indigo-600 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                                <span>{{ $name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Promotional Mini Banner -->
            <div class="rounded-2xl bg-gradient-to-br from-[#1E1B4B] to-[#4338CA] p-6 text-white text-center shadow-md space-y-3">
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-indigo-300">LIMITED DEAL</span>
                <h4 class="text-base font-black leading-snug">Extra 15% OFF Tech Bundles</h4>
                <p class="text-xs text-indigo-200">Use code <strong class="text-amber-300">NOVATECH15</strong> at checkout</p>
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="inline-block w-full py-2 rounded-xl bg-white text-indigo-900 font-bold text-xs uppercase tracking-wider hover:bg-indigo-50 transition-colors shadow-sm">
                    Shop Bundles
                </a>
            </div>
        </aside>

        <!-- 2. Products Grid (3 Columns) -->
        <main class="lg:col-span-3">
            @if($products->isEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">No products found</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">We couldn't find any products matching your current filters. Try selecting a different category or clearing search filters.</p>
                    <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition-all shadow-md">
                        Clear All Filters
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($products as $product)
                        @include('store.themes.novatech-electronics.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            @endif
        </main>

    </div>

</div>
@endsection
