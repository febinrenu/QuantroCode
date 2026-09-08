@props(['product'])

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';

    // Normalise product properties
    $id = is_array($product) ? ($product['id'] ?? null) : $product->id;
    $code = is_array($product) ? ($product['code'] ?? '') : $product->code;
    $name = is_array($product) ? ($product['name'] ?? 'Zanova Product') : $product->name;
    $slug = is_array($product) ? ($product['slug'] ?? Str::slug($name)) : ($product->slug ?? Str::slug($name));
    $price = is_array($product) ? ($product['final_display_price'] ?? $product['price'] ?? 0) : ($product->final_display_price ?? $product->price ?? 0);
    $origPrice = is_array($product) ? ($product['original_price'] ?? $product['base_price'] ?? $price) : ($product->original_price ?? $product->base_price ?? $price);
    $image = is_array($product) ? ($product['image'] ?? '') : $product->image;

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

    // Discount percentage calculation
    $discountPct = 0;
    if ($origPrice > $price && $origPrice > 0) {
        $discountPct = round((($origPrice - $price) / $origPrice) * 100);
    }
    if ($discountPct == 0) {
        if (str_contains($name, 'Earbuds')) $discountPct = 25;
        elseif (str_contains($name, 'Watch')) $discountPct = 30;
        elseif (str_contains($name, 'Camera')) $discountPct = 20;
        elseif (str_contains($name, 'Speaker')) $discountPct = 40;
        elseif (str_contains($name, 'Backpack')) $discountPct = 15;
        elseif (str_contains($name, 'Mixer')) $discountPct = 25;
    }

    // Review counts & ratings mapping
    $rating = 5.0;
    $reviewsCount = 95;
    if (str_contains($name, 'Earbuds')) { $rating = 5.0; $reviewsCount = 128; }
    elseif (str_contains($name, 'Watch')) { $rating = 5.0; $reviewsCount = 96; }
    elseif (str_contains($name, 'Camera')) { $rating = 5.0; $reviewsCount = 74; }
    elseif (str_contains($name, 'Speaker')) { $rating = 5.0; $reviewsCount = 112; }
    elseif (str_contains($name, 'Backpack')) { $rating = 5.0; $reviewsCount = 67; }
    elseif (str_contains($name, 'Mixer')) { $rating = 5.0; $reviewsCount = 89; }

    $productKey = !empty($code) ? $code : (!empty($slug) ? $slug : $id);
@endphp

<div class="group relative bg-white rounded-2xl p-4 border border-zanova-border hover:border-zanova-yellow transition-all duration-300 hover:shadow-lg flex flex-col justify-between"
     x-data="{ isHovered: false }"
     @mouseenter="isHovered = true"
     @mouseleave="isHovered = false">

    <!-- Top Image Container with Red Discount Badge & Wishlist -->
    <div class="relative w-full aspect-square rounded-xl overflow-hidden bg-slate-50 p-4 flex items-center justify-center">
        <!-- Discount Badge (Top Left) -->
        @if($discountPct > 0)
            <span class="absolute top-2.5 left-2.5 z-10 px-2 py-0.5 bg-[#E63946] text-white text-[0.68rem] font-black rounded-md shadow-xs">
                -{{ $discountPct }}%
            </span>
        @endif

        <!-- Wishlist Button (Top Right) -->
        <button type="button"
                class="absolute top-2.5 right-2.5 z-10 w-7 h-7 rounded-full bg-white/90 backdrop-blur-xs flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-white transition-all shadow-xs"
                aria-label="Add to wishlist">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>

        <!-- Product Image Link -->
        <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}" class="w-full h-full flex items-center justify-center">
            <img src="{{ $imagePath }}"
                 alt="{{ $name }}"
                 class="w-full h-full object-contain object-center transform group-hover:scale-105 transition-transform duration-500"
                 loading="lazy">
        </a>
    </div>

    <!-- Product Details -->
    <div class="mt-3.5 flex flex-col flex-grow">
        <!-- Title -->
        <h3 class="text-xs font-bold text-slate-800 hover:text-zanova-navy transition-colors line-clamp-1">
            <a href="{{ url('/online_store/product/' . $productKey . $previewParam) }}">
                {{ $name }}
            </a>
        </h3>

        <!-- Rating Stars with Count -->
        <div class="mt-1.5 flex items-center gap-1.5">
            <div class="flex text-amber-400 text-xs">
                @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-[0.7rem] text-slate-500 font-semibold">({{ $reviewsCount }})</span>
        </div>

        <!-- Price -->
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-sm font-extrabold text-slate-900">
                ${{ number_format((float)$price, 2) }}
            </span>
            @if($origPrice > $price)
                <span class="text-xs text-slate-400 line-through">
                    ${{ number_format((float)$origPrice, 2) }}
                </span>
            @endif
        </div>

        <!-- Add to Cart CTA Button -->
        <div class="mt-3">
            <button type="button"
                    @click.prevent="CartLS.add({
                        id: {{ $id }},
                        code: '{{ $code }}',
                        name: '{{ addslashes($name) }}',
                        price: {{ (float) $price }},
                        final_display_price: {{ (float) $price }},
                        image: '{{ $image }}'
                    }, 1)"
                    class="w-full py-2 bg-zanova-navy hover:bg-slate-800 text-white text-xs font-bold rounded-lg shadow-sm hover:shadow transition-all flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-zanova-yellow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
</div>
