@props(['product'])

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
    
    // Normalise product properties
    $id = is_array($product) ? ($product['id'] ?? null) : $product->id;
    $code = is_array($product) ? ($product['code'] ?? '') : $product->code;
    $name = is_array($product) ? ($product['name'] ?? 'Homely Product') : $product->name;
    $slug = is_array($product) ? ($product['slug'] ?? Str::slug($name)) : ($product->slug ?? Str::slug($name));
    $price = is_array($product) ? ($product['final_display_price'] ?? $product['price'] ?? 0) : ($product->final_display_price ?? $product->price ?? 0);
    $origPrice = is_array($product) ? ($product['original_price'] ?? $product['base_price'] ?? $price) : ($product->original_price ?? $product->base_price ?? $price);
    $image = is_array($product) ? ($product['image'] ?? '') : $product->image;
    
    // Clean image path
    $imagePath = '/images/themes/homely/' . $image;
    if (!file_exists(public_path('images/themes/homely/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/homely/hom-glass-bud-vase.jpg';
        }
    }

    // Star reviews fallback
    $rating = 4.8;
    $reviewsCount = 100 + (abs(crc32($name)) % 60);
    if (str_contains($name, 'Glass Bud Vase')) { $rating = 4.9; $reviewsCount = 128; }
    elseif (str_contains($name, 'Woven Storage Basket')) { $rating = 4.8; $reviewsCount = 96; }
    elseif (str_contains($name, 'Natural Hand Wash')) { $rating = 5.0; $reviewsCount = 87; }
    elseif (str_contains($name, 'Scented Soy Candle')) { $rating = 4.9; $reviewsCount = 156; }
    elseif (str_contains($name, 'Acacia Wood Tray')) { $rating = 4.7; $reviewsCount = 74; }
    elseif (str_contains($name, 'Ceramic Planter')) { $rating = 4.8; $reviewsCount = 101; }
    $productKey = !empty($code) ? $code : (!empty($slug) ? $slug : $id);
@endphp

<div class="group relative bg-white rounded-2xl p-4 border border-homely-borderLight hover:border-homely-border transition-all duration-300 hover:shadow-md flex flex-col justify-between"
     x-data="{ isHovered: false }"
     @mouseenter="isHovered = true"
     @mouseleave="isHovered = false">
    
    <!-- Top Card Header: Wishlist Button -->
    <div class="relative">
        <button type="button" 
                class="absolute top-2 right-2 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-xs flex items-center justify-center text-stone-400 hover:text-rose-500 hover:bg-white transition-all shadow-xs"
                aria-label="Add to wishlist">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>

        <!-- Product Image -->
        <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}" class="block aspect-square w-full rounded-xl overflow-hidden bg-[#FAF7F2] p-3 flex items-center justify-center">
            <img src="{{ $imagePath }}" 
                 alt="{{ $name }}" 
                 class="w-full h-full object-contain object-center transform group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
        </a>
    </div>

    <!-- Product Info -->
    <div class="mt-3.5 flex flex-col flex-grow">
        <!-- Title -->
        <h3 class="text-sm font-semibold text-homely-text hover:text-homely-primary transition-colors line-clamp-1">
            <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}">
                {{ $name }}
            </a>
        </h3>

        <!-- Price -->
        <div class="mt-1 flex items-baseline gap-2">
            <span class="text-base font-bold text-homely-text">
                ${{ number_format($price, 2) }}
            </span>
            @if($origPrice > $price)
                <span class="text-xs text-stone-400 line-through">
                    ${{ number_format($origPrice, 2) }}
                </span>
            @endif
        </div>

        <!-- Rating & Review Count -->
        <div class="mt-1.5 flex items-center gap-1.5 text-xs text-stone-500">
            <div class="flex text-amber-500 text-xs">
                @for($i = 0; $i < 5; $i++)
                    <span>★</span>
                @endfor
            </div>
            <span class="text-[11px] text-stone-400">({{ $reviewsCount }})</span>
        </div>

        <!-- Quick Add to Cart Button -->
        <div class="mt-3.5 pt-2 border-t border-stone-100">
            <button type="button"
                    @click="addToCart({
                        id: {{ json_encode($id) }},
                        code: {{ json_encode($code) }},
                        name: {{ json_encode($name) }},
                        price: {{ json_encode((float)$price) }},
                        original_price: {{ json_encode((float)$origPrice) }},
                        image: {{ json_encode($imagePath) }}
                    }, 1)"
                    class="w-full py-2 px-3 rounded-lg text-xs font-semibold bg-stone-100 hover:bg-homely-primary text-stone-700 hover:text-white transition-all flex items-center justify-center gap-1.5 shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
</div>
