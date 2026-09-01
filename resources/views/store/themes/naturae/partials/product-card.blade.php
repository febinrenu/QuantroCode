@php
    $previewTheme = request('preview_theme', 'naturae');
    $productUrl = url('online_store/product/' . $product->id) . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Image resolution
    $rawImage = $product->image;
    if ($rawImage && file_exists(public_path('images/products/' . $rawImage))) {
        $imageUrl = global_asset('images/products/' . $rawImage);
    } elseif ($rawImage && file_exists(public_path('images/themes/naturae/' . $rawImage))) {
        $imageUrl = global_asset('images/themes/naturae/' . $rawImage);
    } else {
        $imageUrl = global_asset('images/themes/naturae/nat-aloe-cleanser.jpg');
    }

    $price = (float) ($product->final_display_price ?? $product->price);
    $currencySym = $s->currency_code ?? '$';
@endphp

<div class="product-card group flex flex-col bg-white rounded-2xl p-3 border border-naturae-border/80 hover:border-naturae-sage/50 transition-all duration-300 hover:shadow-lg">
    <!-- Product Image Container -->
    <a href="{{ $productUrl }}" class="block relative aspect-square rounded-xl overflow-hidden bg-naturae-sand/60 mb-3.5">
        <img src="{{ $imageUrl }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">

        @if($product->is_featured)
            <span class="absolute top-2.5 left-2.5 bg-naturae-forest/90 backdrop-blur-sm text-white text-[10px] font-semibold px-2 py-0.5 rounded-full uppercase tracking-wider">
                Best Seller
            </span>
        @endif

        <!-- Quick Add Overlay Button -->
        <button type="button"
                class="js-add-to-cart absolute bottom-2.5 right-2.5 w-9 h-9 bg-white/95 hover:bg-naturae-forest text-naturae-forest hover:text-white rounded-full flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $price }}"
                data-image="{{ $imageUrl }}"
                data-currency="{{ $currencySym }}"
                data-qty="1"
                data-stock="100"
                data-added-label="Added!"
                title="Add to Bag">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </a>

    <!-- Product Info -->
    <div class="flex-1 flex flex-col justify-between">
        <div>
            @if($product->category)
                <p class="text-[11px] font-semibold uppercase tracking-widest text-naturae-muted mb-1">
                    {{ $product->category->name }}
                </p>
            @endif
            <h3 class="product-title font-serif text-sm font-semibold text-naturae-text group-hover:text-naturae-sage transition line-clamp-2 leading-snug">
                <a href="{{ $productUrl }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        <div class="mt-3 flex items-center justify-between pt-2 border-t border-naturae-border/50">
            <div class="font-semibold text-sm text-naturae-forest">
                {{ $currencySym }}{{ number_format($price, 2) }}
            </div>

            <button type="button"
                    class="js-add-to-cart text-xs font-semibold text-naturae-sage hover:text-naturae-forest tracking-wider uppercase transition flex items-center gap-1"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $price }}"
                    data-image="{{ $imageUrl }}"
                    data-currency="{{ $currencySym }}"
                    data-qty="1"
                    data-stock="100"
                    data-added-label="Added!">
                <span>Add +</span>
            </button>
        </div>
    </div>
</div>
