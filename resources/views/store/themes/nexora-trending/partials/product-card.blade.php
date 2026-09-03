@php
    $previewTheme = request('preview_theme', 'nexora');
    $currencySym = $s->currency_code ?? '$';

    $prodId = $product->id ?? ($product['id'] ?? 0);
    $prodName = $product->name ?? ($product['name'] ?? 'Nexora Product');
    $prodCode = $product->code ?? ($product['code'] ?? 'NEX-000');
    $prodPrice = (float) ($product->final_display_price ?? ($product->after_discount ?? ($product->price ?? ($product['price'] ?? 0))));
    $prodOriginalPrice = (float) ($product->price ?? ($product['original_price'] ?? 0));
    $prodCategory = ($product->category && isset($product->category->name)) ? $product->category->name : ($product['category_name'] ?? 'Marketplace');

    $prodUrl = url('online_store/product/' . $prodId) . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Resolve Image
    $imgName = $product->image ?? ($product['image'] ?? '');
    if ($imgName && file_exists(public_path('images/themes/nexora/' . $imgName))) {
        $imageUrl = global_asset('images/themes/nexora/' . $imgName);
    } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
        $imageUrl = global_asset('images/products/' . $imgName);
    } else {
        $imageUrl = global_asset('images/themes/nexora/nex-airpods-pro.jpg');
    }

    // Reference review counts
    $reviewMap = [
        'AirPods Pro 2nd Gen' => ['rating' => '5.0', 'count' => 245],
        'Leather Handbag' => ['rating' => '4.9', 'count' => 168],
        'Smartwatch Series 8' => ['rating' => '5.0', 'count' => 310],
        'Luxury Perfume' => ['rating' => '4.8', 'count' => 192],
        'Portable Bluetooth Speaker' => ['rating' => '4.9', 'count' => 87],
        'Coffee Maker' => ['rating' => '4.8', 'count' => 84]
    ];
    $matchedReview = $reviewMap[$prodName] ?? ['rating' => '4.9', 'count' => 120];
@endphp

<div class="product-card group bg-white rounded-2xl border border-slate-200/90 hover:border-nex-blue hover:shadow-lg transition-all duration-300 flex flex-col justify-between overflow-hidden relative p-3">

    <!-- Top Row: Category / Wishlist Heart Icon -->
    <div class="flex items-center justify-between w-full z-10">
        <span class="text-[10px] font-extrabold uppercase tracking-wider text-nex-royal line-clamp-1 max-w-[70%]">
            {{ $prodCategory }}
        </span>
        <button type="button"
                class="w-7 h-7 rounded-full bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-500 flex items-center justify-center transition"
                title="Save to wishlist"
                aria-label="Wishlist">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>
    </div>

    <!-- Product Image Container (Large & Prominent) -->
    <a href="{{ $prodUrl }}" class="relative w-full aspect-square my-2 flex items-center justify-center overflow-hidden bg-white">
        <img src="{{ $imageUrl }}"
             alt="{{ $prodName }}"
             loading="lazy"
             class="w-full h-full object-contain p-1 group-hover:scale-108 transition-transform duration-300">
    </a>

    <!-- Product Metadata (Title, Price, Star Ratings) -->
    <div class="space-y-1.5 pt-1">

        <!-- Product Title -->
        <a href="{{ $prodUrl }}" class="block">
            <h3 class="font-bold text-xs sm:text-[13px] text-nex-navy group-hover:text-nex-blue transition leading-snug line-clamp-2 min-h-[34px]">
                {{ $prodName }}
            </h3>
        </a>

        <!-- Price -->
        <div class="flex items-baseline gap-2 pt-0.5">
            <span class="font-black text-sm sm:text-base text-nex-navy">
                {{ $currencySym }}{{ number_format($prodPrice, 2) }}
            </span>
            @if($prodOriginalPrice > $prodPrice)
                <span class="text-[11px] text-slate-400 line-through font-medium">
                    {{ $currencySym }}{{ number_format($prodOriginalPrice, 2) }}
                </span>
            @endif
        </div>

        <!-- Star Rating + Review Count -->
        <div class="flex items-center gap-1.5 text-[11px] text-amber-500 font-semibold">
            <div class="flex tracking-tighter text-xs">
                ★★★★★
            </div>
            <span class="text-slate-400 text-[10px] font-bold">({{ $matchedReview['count'] }})</span>
        </div>

        <!-- Add to Cart Action Button -->
        <div class="pt-2">
            <button type="button"
                    class="js-add-to-cart w-full bg-nex-blue hover:bg-nex-bluedark text-white font-extrabold text-[11px] py-2 px-3 rounded-xl uppercase tracking-wider transition-all shadow-xs hover:shadow-md flex items-center justify-center gap-1.5"
                    data-id="{{ $prodId }}"
                    data-name="{{ $prodName }}"
                    data-price="{{ $prodPrice }}"
                    data-image="{{ $imageUrl }}"
                    data-currency="{{ $currencySym }}"
                    data-qty="1"
                    data-stock="100"
                    data-added-label="Added!">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Add to Cart</span>
            </button>
        </div>

    </div>

</div>
