@extends('store.themes.zanova._shell')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';

    // Normalize product variable
    $prod = $p ?? ($product ?? null);

    $id = is_array($prod) ? ($prod['id'] ?? null) : ($prod->id ?? null);
    $code = is_array($prod) ? ($prod['code'] ?? '') : ($prod->code ?? '');
    $name = is_array($prod) ? ($prod['name'] ?? 'Product') : ($prod->name ?? 'Product');
    $price = is_array($prod) ? ($prod['final_display_price'] ?? $prod['price'] ?? 0) : ($prod->final_display_price ?? $prod->price ?? 0);
    $origPrice = is_array($prod) ? ($prod['original_price'] ?? $prod['base_price'] ?? $price) : ($prod->original_price ?? $prod->base_price ?? $price);
    $image = is_array($prod) ? ($prod['image'] ?? '') : ($prod->image ?? '');
    $desc = is_array($prod) ? ($prod['description'] ?? '') : ($prod->description ?? '');
    $catName = (is_array($prod) && isset($prod['category']['name'])) ? $prod['category']['name'] : ((isset($prod->category) && $prod->category) ? $prod->category->name : 'Electronics');

    // Clean image path
    $imagePath = '/images/themes/zanova/' . $image;
    if (!file_exists(public_path('images/themes/zanova/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/zanova/znv-wireless-earbuds.jpg';
        }
    }

    $discountPct = 0;
    if ($origPrice > $price && $origPrice > 0) {
        $discountPct = round((($origPrice - $price) / $origPrice) * 100);
    }
@endphp

@section('title', $name . ' — ZANOVA Marketplace')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12"
     x-data="{
         quantity: 1,
         activeTab: 'description',
         selectedVariant: null,
         price: {{ (float)$price }},
         origPrice: {{ (float)$origPrice }}
     }">

    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400">
        <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-navy">Home</a>
        <span>/</span>
        <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-zanova-navy">Shop</a>
        <span>/</span>
        <a href="{{ url('/online_store/shop?category=' . Str::slug($catName) . $previewAmp) }}" class="hover:text-zanova-navy">{{ $catName }}</a>
        <span>/</span>
        <span class="text-slate-800 font-bold truncate max-w-xs">{{ $name }}</span>
    </nav>

    <!-- Main PDP Hero (2-Column Grid) -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-zanova-border shadow-xs grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-start">

        <!-- Left Column: Product Image -->
        <div class="space-y-4">
            <div class="relative w-full aspect-square rounded-2xl bg-slate-50 border border-slate-100 p-8 flex items-center justify-center overflow-hidden">
                @if($discountPct > 0)
                    <span class="absolute top-4 left-4 z-10 px-3 py-1 bg-[#E63946] text-white text-xs font-black rounded-lg shadow-sm">
                        -{{ $discountPct }}% OFF
                    </span>
                @endif
                <img src="{{ $imagePath }}"
                     alt="{{ $name }}"
                     class="w-full h-full object-contain object-center transform hover:scale-105 transition-transform duration-500">
            </div>
        </div>

        <!-- Right Column: Details & Actions -->
        <div class="space-y-6">

            <!-- Category & SKU -->
            <div class="flex items-center justify-between gap-4">
                <span class="px-2.5 py-1 bg-purple-50 text-zanova-purple font-black text-xs rounded-md uppercase tracking-wider">
                    {{ $catName }}
                </span>
                <span class="text-xs font-mono text-slate-400">
                    SKU: {{ $code }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                {{ $name }}
            </h1>

            <!-- Ratings & Reviews -->
            <div class="flex items-center gap-3">
                <div class="flex text-amber-400 text-sm">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <span class="text-xs font-bold text-slate-600">5.0 (98 Verified Reviews)</span>
                <span class="text-slate-300">•</span>
                <span class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    In Stock (Fast Delivery)
                </span>
            </div>

            <!-- Price Display -->
            <div class="flex items-baseline gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <span class="text-3xl font-black text-slate-900">
                    ${{ number_format((float)$price, 2) }}
                </span>
                @if($origPrice > $price)
                    <span class="text-base text-slate-400 line-through font-semibold">
                        ${{ number_format((float)$origPrice, 2) }}
                    </span>
                    <span class="text-xs font-extrabold text-emerald-600">
                        Save ${{ number_format((float)($origPrice - $price), 2) }}
                    </span>
                @endif
            </div>

            <!-- Description Excerpt -->
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ $desc ?: 'Experience top-tier quality and exceptional performance with this carefully engineered product from ZANOVA.' }}
            </p>

            <!-- Quantity & Actions -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center gap-4">
                    <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Quantity:</span>
                    <div class="flex items-center border border-slate-300 rounded-xl bg-white overflow-hidden shadow-xs">
                        <button type="button"
                                @click="if (quantity > 1) quantity--"
                                class="px-3.5 py-2 text-slate-600 hover:bg-slate-100 font-black text-sm">
                            -
                        </button>
                        <span class="px-4 py-2 text-xs font-black text-slate-900" x-text="quantity"></span>
                        <button type="button"
                                @click="quantity++"
                                class="px-3.5 py-2 text-slate-600 hover:bg-slate-100 font-black text-sm">
                            +
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                    <!-- Add to Cart Button -->
                    <button type="button"
                            @click="CartLS.add({
                                id: {{ $id }},
                                code: '{{ $code }}',
                                name: '{{ addslashes($name) }}',
                                price: price,
                                final_display_price: price,
                                image: '{{ $image }}'
                            }, quantity)"
                            class="w-full sm:w-1/2 py-3.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Add to Cart</span>
                    </button>

                    <!-- Buy Now Button -->
                    <button type="button"
                            @click="CartLS.add({
                                id: {{ $id }},
                                code: '{{ $code }}',
                                name: '{{ addslashes($name) }}',
                                price: price,
                                final_display_price: price,
                                image: '{{ $image }}'
                            }, quantity); window.location.href = '{{ url('/online_store/cart' . $previewParam) }}';"
                            class="w-full sm:w-1/2 py-3.5 bg-zanova-navy hover:bg-slate-800 text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition-all">
                        Buy Now
                    </button>
                </div>
            </div>

            <!-- Trust Badges List -->
            <div class="grid grid-cols-3 gap-3 pt-4 border-t border-slate-100 text-[0.72rem] text-slate-500 font-semibold">
                <div class="flex items-center gap-2">
                    <span class="text-purple-600 text-sm">🚚</span>
                    <span>Free Shipping >$59</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-emerald-600 text-sm">🛡️</span>
                    <span>2-Year Warranty</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-amber-600 text-sm">🔄</span>
                    <span>30-Day Free Return</span>
                </div>
            </div>

        </div>

    </div>

    <!-- Details Tab Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-zanova-border shadow-xs space-y-6">
        <!-- Tabs Header -->
        <div class="flex items-center gap-6 border-b border-slate-200 text-xs font-bold">
            <button type="button"
                    @click="activeTab = 'description'"
                    :class="activeTab === 'description' ? 'border-b-2 border-zanova-navy text-zanova-navy pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors">
                Product Description
            </button>
            <button type="button"
                    @click="activeTab = 'specs'"
                    :class="activeTab === 'specs' ? 'border-b-2 border-zanova-navy text-zanova-navy pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors">
                Specifications & Features
            </button>
            <button type="button"
                    @click="activeTab = 'shipping'"
                    :class="activeTab === 'shipping' ? 'border-b-2 border-zanova-navy text-zanova-navy pb-3' : 'text-slate-400 hover:text-slate-700 pb-3'"
                    class="transition-colors">
                Shipping & Delivery
            </button>
        </div>

        <!-- Tab 1: Description -->
        <div x-show="activeTab === 'description'" class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3">
            <p>{{ $desc ?: 'Discover peak efficiency and modern engineering with this authentic product from ZANOVA. Built with industry-leading standards and certified materials.' }}</p>
            <p>Every order is backed by our customer satisfaction promise, 24/7 technical assistance, and direct manufacturer warranty.</p>
        </div>

        <!-- Tab 2: Specs -->
        <div x-show="activeTab === 'specs'" class="text-xs text-slate-700 space-y-2">
            <div class="grid grid-cols-2 max-w-md py-1 border-b border-slate-100">
                <span class="font-bold text-slate-400">Brand</span>
                <span class="font-semibold text-slate-900">ZANOVA Certified</span>
            </div>
            <div class="grid grid-cols-2 max-w-md py-1 border-b border-slate-100">
                <span class="font-bold text-slate-400">SKU Code</span>
                <span class="font-mono text-slate-900">{{ $code }}</span>
            </div>
            <div class="grid grid-cols-2 max-w-md py-1 border-b border-slate-100">
                <span class="font-bold text-slate-400">Category</span>
                <span class="font-semibold text-slate-900">{{ $catName }}</span>
            </div>
            <div class="grid grid-cols-2 max-w-md py-1">
                <span class="font-bold text-slate-400">Condition</span>
                <span class="font-semibold text-emerald-600">Brand New (Retail Sealed)</span>
            </div>
        </div>

        <!-- Tab 3: Shipping -->
        <div x-show="activeTab === 'shipping'" class="text-xs sm:text-sm text-slate-600 space-y-2 leading-relaxed">
            <p><strong>Express Delivery:</strong> Orders placed before 3:00 PM EST ship same day. Standard delivery arrives in 2–4 business days.</p>
            <p><strong>Free Shipping:</strong> Automatically applied to all orders over $59 across all categories.</p>
        </div>
    </div>

</div>
@endsection
