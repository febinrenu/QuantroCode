@extends('store.themes.technova._shell')

@php
    // Resolve Eloquent model vs View Model array
    $prodObj = $p ?? null;
    $prodArray = is_array($product ?? null) ? $product : null;

    $prodId = $prodObj ? $prodObj->id : ($prodArray['id'] ?? request('id', 0));
    $prodName = $prodObj ? $prodObj->name : ($prodArray['name'] ?? 'TechNova Electronics');
    $prodCode = $prodObj ? $prodObj->code : ($prodArray['code'] ?? 'TNV-000');
    $prodDesc = $prodObj ? $prodObj->description : ($prodArray['description'] ?? 'Engineered for exceptional performance, durability, and technological innovation.');
    $catName = ($prodObj && $prodObj->category) ? $prodObj->category->name : ($prodArray['category_name'] ?? 'Electronics');
    $brandName = ($prodObj && $prodObj->brand) ? $prodObj->brand->name : ($prodArray['brand_name'] ?? 'TechNova');

    // Prices
    $currency = '$';
    if ($prodObj) {
        $finalPrice = $prodObj->final_display_price ?? ($prodObj->after_discount ?? ($prodObj->price ?? 0));
        $comparePrice = ($prodObj->base_price && $prodObj->base_price > $finalPrice) ? $prodObj->base_price : null;
        $discPercent = $prodObj->discount_percent ?? ($comparePrice ? round((($comparePrice - $finalPrice) / $comparePrice) * 100) : 0);

        $imgName = $prodObj->image ?? '';
        if ($imgName && file_exists(public_path('images/themes/technova/' . $imgName))) {
            $imgUrl = global_asset('images/themes/technova/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
            $imgUrl = global_asset('images/products/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $imgName))) {
            $imgUrl = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $imgName);
        } else {
            $imgUrl = global_asset('images/themes/technova/generic-electronics.jpg');
        }
    } else {
        $finalPrice = $prodArray['final_price'] ?? ($prodArray['price'] ?? 0);
        $comparePrice = $prodArray['compare_at_price'] ?? null;
        $discPercent = $prodArray['discount_percent'] ?? 0;
        $imgUrl = $prodArray['image_url'] ?? global_asset('images/themes/technova/generic-electronics.jpg');
    }

    $rating = 4.9;
    $reviewCount = 128;
@endphp

@section('title', $prodName . ' | TechNova Electronics')

@section('content')
@php
    $previewTheme = request('preview_theme', 'technova');
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };
@endphp

<div class="bg-slate-50 min-h-screen py-10" x-data="{ qty: 1, activeTab: 'description' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-8">
            <a href="{{ $themeUrl('online_store') }}" class="hover:text-blue-600 transition">Home</a>
            <span>/</span>
            <a href="{{ $themeUrl('online_store/shop') }}" class="hover:text-blue-600 transition">Shop</a>
            <span>/</span>
            <a href="{{ $themeUrl('online_store/shop', ['category' => $catName]) }}" class="hover:text-blue-600 transition">{{ $catName }}</a>
            <span>/</span>
            <span class="text-slate-700 font-semibold truncate max-w-xs">{{ $prodName }}</span>
        </div>

        <!-- Product Presentation Grid -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-10 shadow-tech-sm mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Left: Product Photography Gallery -->
                <div class="lg:col-span-6 space-y-4">
                    <div class="relative pt-[85%] rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 group">
                        <img src="{{ $imgUrl }}"
                             alt="{{ $prodName }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />

                        @if($discPercent > 0)
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-extrabold bg-red-600 text-white shadow-md">
                                    -{{ $discPercent }}% OFF
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Security & Shipping Badges -->
                    <div class="grid grid-cols-3 gap-3 pt-2 text-center text-[11px] text-slate-500">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="block text-base mb-0.5">🛡️</span>
                            <span class="font-bold text-slate-700 block">2-Yr Warranty</span>
                            <span>Direct brand coverage</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="block text-base mb-0.5">🚀</span>
                            <span class="font-bold text-slate-700 block">Express Dispatch</span>
                            <span>Ships in 24 hours</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="block text-base mb-0.5">🔄</span>
                            <span class="font-bold text-slate-700 block">30-Day Returns</span>
                            <span>Money-back guarantee</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Product Specifications & Action Panel -->
                <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <!-- Brand & SKU -->
                        <div class="flex items-center justify-between gap-2 text-xs">
                            <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 font-extrabold tracking-wider uppercase">
                                {{ $brandName }}
                            </span>
                            <span class="text-slate-400 font-mono text-[11px]">SKU: {{ $prodCode }}</span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight font-heading">
                            {{ $prodName }}
                        </h1>

                        <!-- Rating & Stock Status -->
                        <div class="flex items-center gap-4 text-xs">
                            <div class="flex items-center text-amber-400">
                                <span>★★★★★</span>
                                <span class="font-bold text-slate-800 ml-1.5">{{ number_format($rating, 1) }}</span>
                                <span class="text-slate-400 ml-1">({{ $reviewCount }} reviews)</span>
                            </div>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="inline-flex items-center text-emerald-600 font-bold gap-1">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                In Stock & Ready to Ship
                            </span>
                        </div>

                        <!-- Price Block -->
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] uppercase tracking-wider font-bold text-slate-400">Special Price</span>
                                <div class="flex items-baseline gap-3">
                                    <span class="text-3xl font-extrabold text-slate-900 font-heading">
                                        {{ $currency }}{{ number_format((float)$finalPrice, 2) }}
                                    </span>
                                    @if($comparePrice && $comparePrice > $finalPrice)
                                        <span class="text-base text-slate-400 line-through">
                                            {{ $currency }}{{ number_format((float)$comparePrice, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($discPercent > 0)
                                <div class="text-right">
                                    <span class="text-xs font-bold text-emerald-600 block">You Save</span>
                                    <span class="text-sm font-extrabold text-emerald-700">
                                        {{ $currency }}{{ number_format((float)($comparePrice - $finalPrice), 2) }} ({{ $discPercent }}%)
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Short Description -->
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                            {{ $prodDesc }}
                        </p>
                    </div>

                    <!-- Quantity & Action Buttons -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-bold text-slate-700">Quantity:</span>
                            <div class="flex items-center border border-slate-200 rounded-xl bg-white shadow-sm overflow-hidden">
                                <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-3.5 py-2 text-slate-600 hover:bg-slate-100 font-bold transition">&minus;</button>
                                <span class="px-4 py-2 text-xs font-extrabold text-slate-900" x-text="qty"></span>
                                <button type="button" @click="qty++" class="px-3.5 py-2 text-slate-600 hover:bg-slate-100 font-bold transition">&plus;</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Add to Cart -->
                            <button type="button"
                                    class="js-add-to-cart w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2"
                                    data-product-id="{{ $prodId }}"
                                    data-product-name="{{ $prodName }}"
                                    data-product-price="{{ $finalPrice }}"
                                    data-product-image="{{ $imgUrl }}"
                                    :data-quantity="qty">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Add to Cart</span>
                            </button>

                            <!-- View Bag / Checkout -->
                            <a href="{{ $themeUrl('online_store/cart') }}" class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition text-center flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>View Bag</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs: Description / Technical Specs / Warranty -->
            <div class="mt-12 pt-8 border-t border-slate-200">
                <div class="flex items-center space-x-6 border-b border-slate-200 mb-6">
                    <button @click="activeTab = 'description'" :class="activeTab === 'description' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900'" class="pb-3 border-b-2 font-bold text-xs uppercase tracking-wider transition">
                        Overview & Features
                    </button>
                    <button @click="activeTab = 'specs'" :class="activeTab === 'specs' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900'" class="pb-3 border-b-2 font-bold text-xs uppercase tracking-wider transition">
                        Technical Specs
                    </button>
                    <button @click="activeTab = 'warranty'" :class="activeTab === 'warranty' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-900'" class="pb-3 border-b-2 font-bold text-xs uppercase tracking-wider transition">
                        Warranty & Support
                    </button>
                </div>

                <!-- Tab 1: Overview -->
                <div x-show="activeTab === 'description'" class="text-xs sm:text-sm text-slate-600 space-y-4 leading-relaxed max-w-4xl">
                    <p>{{ $prodDesc }}</p>
                    <p>
                        Engineered with premium aerospace-grade materials, precision microelectronics, and thermal dissipation systems to guarantee sustained peak performance under heavy everyday computing, audio listening, or intense gaming workloads.
                    </p>
                </div>

                <!-- Tab 2: Specs -->
                <div x-show="activeTab === 'specs'" class="max-w-2xl text-xs">
                    <div class="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden">
                        <div class="grid grid-cols-2 p-3 bg-slate-50">
                            <span class="font-bold text-slate-700">Category</span>
                            <span class="text-slate-600">{{ $catName }}</span>
                        </div>
                        <div class="grid grid-cols-2 p-3 bg-white">
                            <span class="font-bold text-slate-700">Brand</span>
                            <span class="text-slate-600">{{ $brandName }}</span>
                        </div>
                        <div class="grid grid-cols-2 p-3 bg-slate-50">
                            <span class="font-bold text-slate-700">Model Identifier</span>
                            <span class="text-slate-600 font-mono">{{ $prodCode }}</span>
                        </div>
                        <div class="grid grid-cols-2 p-3 bg-white">
                            <span class="font-bold text-slate-700">Warranty Term</span>
                            <span class="text-slate-600">24 Months Official Global Coverage</span>
                        </div>
                        <div class="grid grid-cols-2 p-3 bg-slate-50">
                            <span class="font-bold text-slate-700">Shipping Condition</span>
                            <span class="text-slate-600">Brand New Factory Sealed in Retail Box</span>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Warranty -->
                <div x-show="activeTab === 'warranty'" class="text-xs text-slate-600 space-y-3 leading-relaxed max-w-3xl">
                    <p class="font-bold text-slate-900">Official Manufacturer Direct Warranty</p>
                    <p>
                        Every product sold on TechNova includes a full manufacturer warranty valid at authorized service centers globally. In addition, TechNova provides our 30-Day Hassle-Free Return policy for complete peace of mind.
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Tech Gear Recommendations -->
        @if(!empty($relatedProducts) && count($relatedProducts) > 0)
            <div class="pb-16">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight font-heading mb-6">
                    Complete Your Setup
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relP)
                        @include('store.themes.technova.partials.product-card', ['p' => $relP])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
