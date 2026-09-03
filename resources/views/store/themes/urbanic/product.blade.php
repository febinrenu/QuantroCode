@extends('store.themes.urbanic._shell')

@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $cartUrl = url('online_store/cart') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Resolve model vs view model array
    $prodObj = $p ?? null;
    $prodArray = is_array($product ?? null) ? $product : null;

    $prodId = $prodObj ? $prodObj->id : ($prodArray['id'] ?? request('id', 0));
    $prodName = $prodObj ? $prodObj->name : ($prodArray['name'] ?? 'Urbanic Fashion Item');
    $prodCode = $prodObj ? $prodObj->code : ($prodArray['code'] ?? 'URB-000');
    $prodDesc = $prodObj ? ($prodObj->description ?: $prodObj->note) : ($prodArray['description'] ?? 'Ultra-soft premium quality fashion piece designed for ultimate style, all-day comfort, and contemporary aesthetics.');
    $catName = ($prodObj && $prodObj->category) ? $prodObj->category->name : ($prodArray['category_name'] ?? 'Fashion');

    if ($prodObj) {
        $finalPrice = (float) ($prodObj->final_display_price ?? ($prodObj->after_discount ?? ($prodObj->price ?? 0)));
        $imgName = $prodObj->image ?? '';
        if ($imgName && file_exists(public_path('images/themes/urbanic/' . $imgName))) {
            $imageUrl = global_asset('images/themes/urbanic/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
            $imageUrl = global_asset('images/products/' . $imgName);
        } else {
            $imageUrl = global_asset('images/themes/urbanic/urb-oversize-tee.jpg');
        }
    } else {
        $finalPrice = (float) ($prodArray['final_price'] ?? ($prodArray['price'] ?? 0));
        $imageUrl = $prodArray['image_url'] ?? global_asset('images/themes/urbanic/urb-oversize-tee.jpg');
    }

    $formattedPrice = '$' . number_format($finalPrice, 2);
    $reviewsCount = $prodObj ? ($prodObj->id % 60 + 45) : 86;
@endphp

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-12"
     x-data="{ qty: 1 }">

    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 font-medium">
        <a href="{{ $storeUrl }}" class="hover:text-orange-600 transition">Home</a>
        <span>/</span>
        <a href="{{ $shopUrl }}" class="hover:text-orange-600 transition">Fashion</a>
        @if($catName)
            <span>/</span>
            <a href="{{ url('online_store/shop?category=' . urlencode($catName) . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-orange-600 transition">{{ $catName }}</a>
        @endif
        <span>/</span>
        <span class="text-urb-dark font-bold line-clamp-1">{{ $prodName }}</span>
    </nav>

    <!-- Product Details Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14">

        <!-- Left: Large Product Image -->
        <div class="space-y-4">
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 flex items-center justify-center aspect-square shadow-xs overflow-hidden">
                <img src="{{ $imageUrl }}"
                     alt="{{ $prodName }}"
                     class="w-full h-full object-contain max-h-[480px] hover:scale-105 transition-transform duration-500">
            </div>
        </div>

        <!-- Right: Information & Actions -->
        <div class="space-y-6 flex flex-col justify-between">

            <div class="space-y-4">

                <!-- Category Badge -->
                <span class="inline-block px-3.5 py-1 rounded-full bg-orange-50 text-orange-600 text-xs font-black uppercase tracking-wider">
                    {{ $catName }}
                </span>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-urb-dark tracking-tight leading-tight">
                    {{ $prodName }}
                </h1>

                <!-- Rating -->
                <div class="flex items-center gap-2 text-xs">
                    <div class="flex text-amber-500">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <span class="font-extrabold text-urb-dark">4.9</span>
                    <span class="text-slate-400">({{ $reviewsCount }} customer reviews)</span>
                </div>

                <!-- Price & Stock -->
                <div class="flex items-baseline gap-3 pt-2">
                    <span class="text-3xl font-black text-urb-dark">
                        {{ $formattedPrice }}
                    </span>
                    <span class="text-xs font-black text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full ml-2">
                        In Stock • Ready to Ship
                    </span>
                </div>

                <!-- Description -->
                <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed pt-2">
                    {{ $prodDesc }}
                </p>

            </div>

            <!-- Quantity & Add to Cart -->
            <div class="space-y-4 pt-4 border-t border-slate-100">

                <div class="flex items-center gap-4">
                    <div class="flex items-center border border-slate-200 rounded-2xl bg-white p-1 shadow-xs">
                        <button type="button"
                                @click="if (qty > 1) qty--"
                                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-urb-dark font-black flex items-center justify-center transition">
                            -
                        </button>
                        <span class="w-12 text-center text-sm font-black text-urb-dark" x-text="qty"></span>
                        <button type="button"
                                @click="qty++"
                                class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-urb-dark font-black flex items-center justify-center transition">
                            +
                        </button>
                    </div>

                    <!-- Add to Bag CTA -->
                    <button type="button"
                            class="js-add-to-cart flex-1 py-4 bg-orange-500 hover:bg-orange-600 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-xl hover:shadow-2xl transition-all flex items-center justify-center gap-2"
                            data-id="{{ $prodId }}"
                            data-name="{{ $prodName }}"
                            data-price="{{ $finalPrice }}"
                            data-image="{{ $imageUrl }}"
                            :data-quantity="qty">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Add To Bag</span>
                    </button>
                </div>

                <!-- Trust Guarantees -->
                <div class="grid grid-cols-3 gap-3 pt-3 text-center">
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-base block">🚚</span>
                        <span class="text-[10px] font-bold text-slate-700 block mt-1">Free Shipping</span>
                        <span class="text-[9px] text-slate-400 block">Orders over $75</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-base block">🔄</span>
                        <span class="text-[10px] font-bold text-slate-700 block mt-1">30-Day Returns</span>
                        <span class="text-[9px] text-slate-400 block">Hassle free</span>
                    </div>
                    <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <span class="text-base block">🛡️</span>
                        <span class="text-[10px] font-bold text-slate-700 block mt-1">Authentic</span>
                        <span class="text-[9px] text-slate-400 block">100% Genuine</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
