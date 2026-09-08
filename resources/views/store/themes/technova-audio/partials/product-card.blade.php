@php
    $previewTheme = request('preview_theme', 'technova');

    // Normalize object vs array view-model
    $isArr = is_array($p);
    $prodId = $isArr ? ($p['id'] ?? 0) : $p->id;
    $prodName = $isArr ? ($p['name'] ?? '') : $p->name;
    $prodCode = $isArr ? ($p['code'] ?? '') : ($p->code ?? '');

    // Prices
    $currency = '$';
    if ($isArr) {
        $finalPrice = $p['final_price'] ?? ($p['price'] ?? 0);
        $comparePrice = $p['compare_at_price'] ?? null;
        $discPercent = $p['discount_percent'] ?? 0;
        $catName = $p['category_name'] ?? ($p['category'] ?? 'Electronics');
        $imgUrl = $p['image_url'] ?? global_asset('images/themes/technova/generic-electronics.jpg');
    } else {
        $finalPrice = $p->final_display_price ?? ($p->after_discount ?? ($p->price ?? 0));
        $comparePrice = ($p->base_price && $p->base_price > $finalPrice) ? $p->base_price : null;
        $discPercent = $p->discount_percent ?? ($comparePrice ? round((($comparePrice - $finalPrice) / $comparePrice) * 100) : 0);
        $catName = $p->category->name ?? 'Electronics';

        $imgName = $p->image ?? '';
        if ($imgName && file_exists(public_path('images/themes/technova/' . $imgName))) {
            $imgUrl = global_asset('images/themes/technova/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
            $imgUrl = global_asset('images/products/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $imgName))) {
            $imgUrl = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $imgName);
        } else {
            $imgUrl = global_asset('images/themes/technova/generic-electronics.jpg');
        }
    }

    $detailUrl = url('online_store/product/' . $prodId);
    if ($previewTheme) {
        $detailUrl .= '?preview_theme=' . $previewTheme;
    }

    $rating = 4.8 + (($prodId % 3) * 0.1);
    $reviews = 45 + ($prodId * 7);
@endphp

<div class="group bg-white rounded-2xl border border-slate-200/80 hover:border-blue-500/50 hover:shadow-tech-hover transition-all duration-300 flex flex-col justify-between overflow-hidden relative">
    <!-- Badges Container -->
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-1">
        @if($discPercent > 0)
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-extrabold bg-red-600 text-white shadow-sm">
                -{{ $discPercent }}%
            </span>
        @endif
        @if($prodId % 2 == 0)
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-600 text-white shadow-sm uppercase tracking-wider">
                Hot Deal
            </span>
        @endif
    </div>

    <!-- Wishlist Button -->
    <button type="button" class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 text-slate-400 hover:text-red-500 hover:bg-white flex items-center justify-center transition shadow-sm" title="Add to Wishlist">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>

    <!-- Product Image -->
    <a href="{{ $detailUrl }}" class="block relative pt-[85%] bg-slate-50 overflow-hidden">
        <img src="{{ $imgUrl }}"
             alt="{{ $prodName }}"
             loading="lazy"
             class="absolute inset-0 w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
             onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
    </a>

    <!-- Product Info Content -->
    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between">
        <div>
            <!-- Category & Rating -->
            <div class="flex items-center justify-between gap-2 text-xs mb-1.5">
                <span class="text-blue-600 font-semibold tracking-wide uppercase text-[11px]">{{ $catName }}</span>
                <div class="flex items-center text-amber-400 text-xs">
                    <span>★</span>
                    <span class="font-bold text-slate-700 ml-1">{{ number_format($rating, 1) }}</span>
                    <span class="text-slate-400 ml-0.5 text-[11px]">({{ $reviews }})</span>
                </div>
            </div>

            <!-- Product Title -->
            <h3 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-blue-600 transition line-clamp-2 mb-3">
                <a href="{{ $detailUrl }}">{{ $prodName }}</a>
            </h3>
        </div>

        <!-- Price & Action Footer -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
            <div>
                <div class="text-lg font-extrabold text-slate-900 font-heading">
                    {{ $currency }}{{ number_format((float)$finalPrice, 2) }}
                </div>
                @if($comparePrice && $comparePrice > $finalPrice)
                    <div class="text-xs text-slate-400 line-through">
                        {{ $currency }}{{ number_format((float)$comparePrice, 2) }}
                    </div>
                @endif
            </div>

            <!-- Add to Cart Button -->
            <button type="button"
                    class="js-add-to-cart inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-xs font-bold transition shadow-sm shadow-blue-500/20"
                    data-product-id="{{ $prodId }}"
                    data-product-name="{{ $prodName }}"
                    data-product-price="{{ $finalPrice }}"
                    data-product-image="{{ $imgUrl }}"
                    data-quantity="1"
                    title="Add to Cart">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="hidden sm:inline">Add</span>
            </button>
        </div>
    </div>
</div>
