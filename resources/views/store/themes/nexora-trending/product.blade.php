@extends('store.themes.nexora-trending._shell')

@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Resolve model vs view model array
    $prodObj = $p ?? null;
    $prodArray = is_array($product ?? null) ? $product : null;

    $prodId = $prodObj ? $prodObj->id : ($prodArray['id'] ?? request('id', 0));
    $prodName = $prodObj ? $prodObj->name : ($prodArray['name'] ?? 'Nexora Marketplace Product');
    $prodCode = $prodObj ? $prodObj->code : ($prodArray['code'] ?? 'NEX-000');
    $prodDesc = $prodObj ? ($prodObj->note ?: $prodObj->description) : ($prodArray['description'] ?? 'Designed with premium materials and high precision craftsmanship. Offers superior performance, reliability, and everyday convenience.');
    $catName = ($prodObj && $prodObj->category) ? $prodObj->category->name : ($prodArray['category_name'] ?? 'Marketplace');
    $currencySym = $s->currency_code ?? '$';

    if ($prodObj) {
        $finalPrice = (float) ($prodObj->final_display_price ?? ($prodObj->after_discount ?? ($prodObj->price ?? 0)));
        $imgName = $prodObj->image ?? '';
        if ($imgName && file_exists(public_path('images/themes/nexora/' . $imgName))) {
            $imageUrl = global_asset('images/themes/nexora/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
            $imageUrl = global_asset('images/products/' . $imgName);
        } else {
            $imageUrl = global_asset('images/themes/nexora/nex-airpods-pro.jpg');
        }
    } else {
        $finalPrice = (float) ($prodArray['final_price'] ?? ($prodArray['price'] ?? 0));
        $imageUrl = $prodArray['image_url'] ?? global_asset('images/themes/nexora/nex-airpods-pro.jpg');
    }
@endphp

@section('title', $prodName . ' — Nexora')

@section('content')

<!-- Breadcrumbs -->
<div class="bg-white border-b border-slate-200/80 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-400">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ $storeUrl }}" class="hover:text-nex-blue transition">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ $shopUrl }}" class="hover:text-nex-blue transition">Catalog</a></li>
                @if($catName)
                    <li><span>/</span></li>
                    <li>
                        <a href="{{ url('online_store/shop?category=' . urlencode($catName) . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-nex-blue transition">
                            {{ $catName }}
                        </a>
                    </li>
                @endif
                <li><span>/</span></li>
                <li class="text-nex-navy font-bold truncate max-w-xs">{{ $prodName }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Details Section -->
<section class="py-10 bg-nex-bg" x-data="{ qty: 1, added: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm">

            <!-- Left: Product Image (5 cols) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-white border border-slate-200 p-6 flex items-center justify-center">
                    <img src="{{ $imageUrl }}"
                         alt="{{ $prodName }}"
                         class="max-w-full max-h-full object-contain">
                </div>

                <!-- Feature Icons -->
                <div class="grid grid-cols-3 gap-2 text-center text-[11px] text-slate-500 font-semibold">
                    <div class="p-3 rounded-2xl bg-blue-50/50 border border-blue-100/50">
                        <span class="block text-base mb-1">🚚</span>
                        <span class="text-nex-navy">Free Delivery</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-blue-50/50 border border-blue-100/50">
                        <span class="block text-base mb-1">🛡️</span>
                        <span class="text-nex-navy">1-Yr Warranty</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-blue-50/50 border border-blue-100/50">
                        <span class="block text-base mb-1">🔄</span>
                        <span class="text-nex-navy">30-Day Return</span>
                    </div>
                </div>
            </div>

            <!-- Right: Details & Add to Cart (7 cols) -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    @if($catName)
                        <span class="text-xs font-extrabold uppercase tracking-wider text-nex-blue">
                            {{ $catName }}
                        </span>
                    @endif

                    <h1 class="text-3xl sm:text-4xl font-black text-nex-navy mt-1 leading-tight">
                        {{ $prodName }}
                    </h1>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mt-3">
                        <div class="flex text-amber-400 text-sm">
                            ★★★★★
                        </div>
                        <span class="text-xs text-slate-500 font-bold">4.9 / 5.0 (245 verified reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="mt-4 flex items-baseline gap-3">
                        <span class="text-3xl sm:text-4xl font-black text-nex-navy">
                            {{ $currencySym }}{{ number_format($finalPrice, 2) }}
                        </span>
                        <span class="text-xs text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold">
                            In Stock • Dispatches in 24h
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mt-5 text-sm text-slate-600 leading-relaxed border-t border-b border-slate-100 py-4 space-y-3">
                        <p>
                            {{ $prodDesc }}
                        </p>
                        <div class="space-y-1.5 text-xs text-nex-navy font-semibold">
                            <div class="flex items-center gap-2">
                                <span class="text-nex-blue">✓</span>
                                <span>100% Genuine brand authentic guarantee</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-nex-blue">✓</span>
                                <span>Complimentary express delivery on orders over $99</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-nex-blue">✓</span>
                                <span>24/7 dedicated customer care & tracking assistance</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity & Add to Cart Action -->
                    <div class="mt-6 space-y-4">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">

                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-slate-300 rounded-2xl bg-slate-50">
                                <button type="button"
                                        @click="if(qty > 1) qty--"
                                        class="w-12 h-12 flex items-center justify-center text-nex-navy hover:bg-slate-200 rounded-l-2xl font-bold transition">
                                    -
                                </button>
                                <span class="w-12 text-center text-sm font-bold text-nex-navy" x-text="qty"></span>
                                <button type="button"
                                        @click="qty++"
                                        class="w-12 h-12 flex items-center justify-center text-nex-navy hover:bg-slate-200 rounded-r-2xl font-bold transition">
                                    +
                                </button>
                            </div>

                            <!-- Add to Cart Button (Royal Blue) -->
                            <button type="button"
                                    @click="if (window.CartLS) { window.CartLS.add({ id: '{{ $prodId }}', name: '{{ addslashes($prodName) }}', price: {{ $finalPrice }}, image: '{{ $imageUrl }}', currency: '{{ $currencySym }}' }, qty); added = true; setTimeout(() => added = false, 1500); }"
                                    class="flex-1 bg-nex-blue hover:bg-nex-bluedark text-white font-extrabold py-3.5 px-8 rounded-2xl uppercase tracking-widest text-xs sm:text-sm flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition transform active:scale-98">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span x-text="added ? 'Added to Cart!' : 'Add to Shopping Cart'">Add to Shopping Cart</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Footer Trust Strip -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div class="flex items-center gap-2">
                        <span>🔒 256-bit Encrypted Checkout</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>⚡ Instant Order Confirmation</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
