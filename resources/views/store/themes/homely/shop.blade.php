@extends('store.themes.homely._shell')

@section('title', 'Shop Natural Home & Living — Homely')

@section('content')
@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 space-y-8">
    <!-- Breadcrumbs & Header -->
    <div class="border-b border-homely-borderLight pb-6">
        <nav class="flex items-center gap-2 text-xs text-stone-500 mb-3">
            <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-homely-primary transition-colors">Home</a>
            <span>/</span>
            <span class="text-homely-text font-semibold">Shop</span>
            @if(request('category'))
                <span>/</span>
                <span class="text-homely-primary font-bold uppercase">{{ str_replace('-', ' ', request('category')) }}</span>
            @elseif(request('collection'))
                <span>/</span>
                <span class="text-homely-primary font-bold uppercase">{{ str_replace('-', ' ', request('collection')) }}</span>
            @endif
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-homely-primary">
                    @if(request('category'))
                        {{ ucwords(str_replace('-', ' ', request('category'))) }}
                    @elseif(request('collection'))
                        {{ ucwords(str_replace('-', ' ', request('collection'))) }}
                    @else
                        All Home Collections
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-stone-500 mt-1">
                    Organic materials, handmade essentials, and conscious sustainable designs.
                </p>
            </div>

            <!-- Sort By Selector -->
            <form method="GET" action="{{ url('/online_store/shop') }}" class="flex items-center gap-2">
                @if(request('preview_theme'))
                    <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <label for="sort" class="text-xs font-semibold text-stone-500">Sort By:</label>
                <select name="sort" 
                        id="sort" 
                        onchange="this.form.submit()"
                        class="text-xs font-medium border border-homely-border rounded-lg px-3 py-2 bg-white text-homely-text focus:outline-none focus:border-homely-primary">
                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Category Filter Pills -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs font-semibold">
        <a href="{{ url('/online_store/shop' . $previewParam) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ !request('category') ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            All Products
        </a>
        <a href="{{ url('/online_store/shop?category=living-room' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'living-room' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Living Room
        </a>
        <a href="{{ url('/online_store/shop?category=kitchen-dining' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'kitchen-dining' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Kitchen & Dining
        </a>
        <a href="{{ url('/online_store/shop?category=bedroom' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'bedroom' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Bedroom
        </a>
        <a href="{{ url('/online_store/shop?category=bathroom' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'bathroom' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Bathroom
        </a>
        <a href="{{ url('/online_store/shop?category=indoor-plants' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'indoor-plants' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Indoor Plants
        </a>
        <a href="{{ url('/online_store/shop?category=decor' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'decor' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Decor
        </a>
        <a href="{{ url('/online_store/shop?category=furniture' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'furniture' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Furniture
        </a>
        <a href="{{ url('/online_store/shop?category=bath-body' . $previewAmp) }}" 
           class="px-4 py-2 rounded-full whitespace-nowrap transition-colors {{ request('category') === 'bath-body' ? 'bg-homely-primary text-white shadow-xs' : 'bg-white border border-homely-border text-stone-700 hover:bg-homely-sand' }}">
            Bath & Body
        </a>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 sm:gap-6">
        @forelse($products as $product)
            @include('store.themes.homely.partials.product-card', ['product' => $product])
        @empty
            <div class="col-span-full py-16 text-center space-y-3 bg-white rounded-2xl border border-homely-borderLight">
                <div class="text-3xl text-stone-400">🌿</div>
                <h3 class="font-serif text-lg font-bold text-homely-primary">No products found</h3>
                <p class="text-xs text-stone-500">Try adjusting your category filter or search query.</p>
                <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                   class="inline-block mt-2 px-5 py-2 rounded-full bg-homely-primary text-white text-xs font-semibold">
                    View All Products
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($products, 'links'))
        <div class="pt-8 border-t border-homely-borderLight flex justify-center">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
