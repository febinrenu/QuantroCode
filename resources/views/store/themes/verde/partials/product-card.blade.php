@props(['product'])

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
    
    // Normalise product properties
    $id = is_array($product) ? ($product['id'] ?? null) : $product->id;
    $code = is_array($product) ? ($product['code'] ?? '') : $product->code;
    $name = is_array($product) ? ($product['name'] ?? 'Verde Living Product') : $product->name;
    $slug = is_array($product) ? ($product['slug'] ?? Str::slug($name)) : ($product->slug ?? Str::slug($name));
    $price = is_array($product) ? ($product['final_display_price'] ?? $product['price'] ?? 0) : ($product->final_display_price ?? $product->price ?? 0);
    $origPrice = is_array($product) ? ($product['original_price'] ?? $product['base_price'] ?? $price) : ($product->original_price ?? $product->base_price ?? $price);
    $image = is_array($product) ? ($product['image'] ?? '') : $product->image;
    
    // Clean image path
    $imagePath = '/images/themes/verde/' . $image;
    if (!file_exists(public_path('images/themes/verde/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/verde/vrd-herbal-hand-wash.jpg';
        }
    }

    // Star reviews & counts mapping
    $rating = 5.0;
    $reviewsCount = 80 + (abs(crc32($name)) % 50);
    if (str_contains($name, 'Herbal Hand Wash')) { $rating = 5.0; $reviewsCount = 124; }
    elseif (str_contains($name, 'Lavender Soy Candle')) { $rating = 5.0; $reviewsCount = 96; }
    elseif (str_contains($name, 'Vitamin C Serum')) { $rating = 5.0; $reviewsCount = 76; }
    elseif (str_contains($name, 'Aroma Reed Diffuser')) { $rating = 5.0; $reviewsCount = 110; }
    elseif (str_contains($name, 'Natural Soap Bar')) { $rating = 5.0; $reviewsCount = 67; }
    elseif (str_contains($name, 'Organic Cotton Tote')) { $rating = 5.0; $reviewsCount = 53; }

    $productKey = !empty($code) ? $code : (!empty($slug) ? $slug : $id);
@endphp

<div class="group relative bg-white rounded-2xl p-3.5 border border-verde-borderLight hover:border-verde-border transition-all duration-300 hover:shadow-md flex flex-col justify-between"
     x-data="{ isHovered: false }"
     @mouseenter="isHovered = true"
     @mouseleave="isHovered = false">
    
    <!-- Top Image Container with Wishlist Heart -->
    <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-[#FAF7F2] p-3 flex items-center justify-center">
        <!-- Wishlist Button -->
        <button type="button" 
                class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-white/80 backdrop-blur-xs flex items-center justify-center text-stone-400 hover:text-rose-500 hover:bg-white transition-all shadow-xs"
                aria-label="Add to wishlist">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>

        <!-- Product Image Link -->
        <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}" class="w-full h-full flex items-center justify-center">
            <img src="{{ $imagePath }}" 
                 alt="{{ $name }}" 
                 class="w-full h-full object-contain object-center transform group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
        </a>

        <!-- Quick Add Overlay on Hover -->
        <div class="absolute inset-x-3 bottom-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <button type="button"
                    @click.prevent="CartLS.add({
                        id: {{ $id }},
                        code: '{{ $code }}',
                        name: '{{ addslashes($name) }}',
                        price: {{ (float) $price }},
                        final_display_price: {{ (float) $price }},
                        image: '{{ $image }}'
                    }, 1)"
                    class="w-full py-2 bg-verde-btn hover:bg-verde-btnHover text-white text-xs font-bold rounded-lg shadow-md transition-all flex items-center justify-center gap-1.5 uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Add to Bag</span>
            </button>
        </div>
    </div>

    <!-- Product Details -->
    <div class="mt-3 flex flex-col flex-grow">
        <!-- Title -->
        <h3 class="text-sm font-semibold text-verde-text hover:text-verde-primary transition-colors line-clamp-1">
            <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}">
                {{ $name }}
            </a>
        </h3>

        <!-- Price -->
        <div class="mt-1 flex items-baseline gap-2">
            <span class="text-sm font-bold text-verde-dark">
                ${{ number_format((float)$price, 2) }}
            </span>
            @if($origPrice > $price)
                <span class="text-xs text-stone-400 line-through">
                    ${{ number_format((float)$origPrice, 2) }}
                </span>
            @endif
        </div>

        <!-- Rating Stars with Count -->
        <div class="mt-1.5 flex items-center gap-1">
            <div class="flex text-amber-500 text-xs">
                @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-[0.72rem] text-stone-500 font-medium">({{ $reviewsCount }})</span>
        </div>
    </div>
</div>
