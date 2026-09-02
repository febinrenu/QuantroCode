@php
    $previewParam = '?preview_theme=novatech';
    $productImage = $product->image ?? '';
    if (empty($productImage)) {
        $imageUrl = '/images/themes/novatech/nvt-wireless-earbuds.jpg';
    } elseif (str_starts_with($productImage, 'http') || str_starts_with($productImage, '/')) {
        $imageUrl = $productImage;
    } else {
        $imageUrl = '/images/themes/novatech/' . $productImage;
    }

    $id = $product->id ?? null;
    $code = $product->code ?? '';
    $productKey = !empty($code) ? $code : $id;

    $price = $product->final_display_price ?? $product->price ?? 0;
    $basePrice = $product->base_price ?? $product->price ?? 0;
    $hasDiscount = $basePrice > $price;

    $rating = 5.0;
    $reviewsCount = 100 + (abs(crc32($product->name ?? 'novatech')) % 350);
@endphp

<div class="group relative bg-white rounded-2xl border border-slate-200 hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 p-4 flex flex-col justify-between h-full">
    <!-- Top Action Bar: Wishlist & Discount Badge -->
    <div class="flex items-center justify-between mb-2">
        <div>
            @if($hasDiscount)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-50 text-rose-600 border border-rose-200">
                    SALE
                </span>
            @endif
        </div>
        <button type="button" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-500 flex items-center justify-center transition-colors shadow-sm" aria-label="Add to wishlist">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>
    </div>

    <!-- Product Image -->
    <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}" class="relative block w-full h-44 mb-3 rounded-xl overflow-hidden bg-slate-50/50 p-2 flex items-center justify-center">
        <img src="{{ $imageUrl }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300"
             onerror="this.onerror=null; this.src='/images/products/{{ $product->image ?? '' }}';">
    </a>

    <!-- Product Details -->
    <div class="flex-1 flex flex-col justify-between">
        <div>
            <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}" class="block">
                <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                    {{ $product->name }}
                </h3>
            </a>

            <!-- Price -->
            <div class="mt-1.5 flex items-baseline space-x-2">
                <span class="text-base font-extrabold text-slate-900">
                    ${{ number_format($price, 2) }}
                </span>
                @if($hasDiscount)
                    <span class="text-xs font-semibold text-slate-400 line-through">
                        ${{ number_format($basePrice, 2) }}
                    </span>
                @endif
            </div>

            <!-- Rating -->
            <div class="mt-2 flex items-center space-x-1.5">
                <div class="flex text-indigo-600">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>
                <span class="text-xs font-semibold text-slate-400">({{ $reviewsCount }})</span>
            </div>
        </div>

        <!-- Add to Cart CTA -->
        <button type="button"
                @click="CartLS.add({ id: {{ $product->id }}, name: '{{ addslashes($product->name) }}', price: {{ $price }}, image: '{{ $product->image ?? 'nvt-wireless-earbuds.jpg' }}', code: '{{ $product->code ?? '' }}' })"
                class="mt-4 w-full py-2.5 px-3 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold transition-all flex items-center justify-center space-x-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>Add to Cart</span>
        </button>
    </div>
</div>
