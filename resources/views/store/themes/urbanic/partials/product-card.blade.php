@php
    $previewTheme = request('preview_theme', 'urbanic');
    $productUrl = url('online_store/product/' . $product->id) . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Resolve price
    $price = (float)($product->final_display_price ?? $product->price ?? 0);
    $formattedPrice = '$' . number_format($price, 2);

    // Resolve image
    $imgUrl = '';
    if (!empty($product->image)) {
        if (str_starts_with($product->image, 'http')) {
            $imgUrl = $product->image;
        } elseif (file_exists(public_path('images/themes/urbanic/' . $product->image))) {
            $imgUrl = global_asset('images/themes/urbanic/' . $product->image);
        } elseif (file_exists(public_path('images/products/' . $product->image))) {
            $imgUrl = global_asset('images/products/' . $product->image);
        } else {
            $imgUrl = global_asset('images/products/' . $product->image);
        }
    } else {
        $imgUrl = global_asset('images/themes/urbanic/urb-oversize-tee.jpg');
    }

    // Rating & reviews
    $rating = $product->rating ?? 5.0;
    $reviewsCount = $product->reviews_count ?? ($product->id % 60 + 45);
@endphp

<div class="group bg-white rounded-2xl border border-slate-100/90 overflow-hidden hover:shadow-xl hover:border-slate-200 transition-all duration-300 flex flex-col justify-between">

    <!-- Image Box with Wishlist Heart -->
    <div class="relative bg-slate-50 aspect-square overflow-hidden flex items-center justify-center p-3">

        <!-- Wishlist Button -->
        <button type="button"
                class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/90 hover:bg-white text-slate-400 hover:text-rose-500 shadow-xs flex items-center justify-center transition-all duration-200 hover:scale-110"
                aria-label="Add to Wishlist">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>

        <!-- Product Image Link -->
        <a href="{{ $productUrl }}" class="w-full h-full flex items-center justify-center">
            <img src="{{ $imgUrl }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
        </a>

        <!-- Quick Add Overlay (Desktop Hover) -->
        <div class="absolute inset-x-3 bottom-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none group-hover:pointer-events-auto">
            <button type="button"
                    class="js-add-to-cart w-full py-2.5 bg-urb-dark hover:bg-black text-white text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-lg transition-all flex items-center justify-center gap-1.5"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $price }}"
                    data-image="{{ $imgUrl }}"
                    data-quantity="1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add to Bag</span>
            </button>
        </div>

    </div>

    <!-- Product Details Content -->
    <div class="p-4 space-y-2 flex flex-col justify-between flex-grow">

        <div>
            <a href="{{ $productUrl }}" class="block">
                <h3 class="text-xs sm:text-sm font-bold text-urb-dark group-hover:text-orange-500 transition-colors line-clamp-1 leading-snug">
                    {{ $product->name }}
                </h3>
            </a>

            <!-- Price -->
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-sm sm:text-base font-black text-urb-dark">
                    {{ $formattedPrice }}
                </span>
                @if(isset($product->original_price) && $product->original_price > $price)
                    <span class="text-xs text-slate-400 line-through font-normal">
                        ${{ number_format($product->original_price, 2) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- 5-Star Rating & Reviews -->
        <div class="flex items-center gap-1.5 pt-1 text-xs">
            <div class="flex text-amber-500 text-xs">
                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
            </div>
            <span class="text-[11px] text-slate-400 font-medium">
                ({{ $reviewsCount }})
            </span>
        </div>

    </div>

</div>
