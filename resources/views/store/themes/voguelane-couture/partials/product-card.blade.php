{{-- VogueLane Product Card Component --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $productUrl = $product['url'] ?? '#';
  if ($themePreview && !str_contains($productUrl, 'preview_theme=')) {
      $productUrl .= (str_contains($productUrl, '?') ? '&' : '?') . 'preview_theme=' . $themePreview;
  }
  
  $price = $product['final_price'] ?? ($product['price'] ?? 0);
  $priceFormatted = $product['final_price_formatted'] ?? ($product['display_price_formatted'] ?? (($product['currency'] ?? '$') . number_format($price, 2)));
  $comparePriceFormatted = $product['compare_at_price_formatted'] ?? ($product['base_price_formatted'] ?? null);
  $isOnSale = !empty($product['is_on_sale']) || !empty($product['compare_at_price']);
  $discountPercent = $product['discount_percent'] ?? 0;

  $badge = $product['badge'] ?? null;
  if (!$badge) {
      if ($isOnSale) {
          $badge = 'Sale ' . ($discountPercent ? '-' . $discountPercent . '%' : '');
      } elseif (!empty($product['is_new']) || str_contains($product['sku'] ?? '', 'VOG-DRS-001') || str_contains($product['sku'] ?? '', 'VOG-BAG-001')) {
          $badge = 'New';
      } elseif (str_contains($product['sku'] ?? '', 'VOG-BLZ-001')) {
          $badge = 'Best Seller';
      }
  }
@endphp

<article class="vog-card group relative bg-white flex flex-col justify-between" data-product-id="{{ $product['id'] }}">
  
  <!-- Image Container -->
  <div class="relative aspect-[3/4] bg-vog-warm rounded-xl overflow-hidden mb-3">
    
    <!-- Top Badges -->
    <div class="absolute top-2.5 left-2.5 z-10 flex flex-col gap-1.5 pointer-events-none">
      @if($badge)
        @if(str_contains(strtolower($badge), 'sale'))
          <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-vog-sale text-white rounded-md shadow-xs">
            {{ $badge }}
          </span>
        @elseif(str_contains(strtolower($badge), 'best'))
          <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-vog-tan text-white rounded-md shadow-xs">
            {{ $badge }}
          </span>
        @else
          <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-vog-black text-white rounded-md shadow-xs">
            {{ $badge }}
          </span>
        @endif
      @endif
    </div>

    <!-- Wishlist Button -->
    <button type="button" 
            class="absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full bg-white/90 backdrop-blur-xs text-slate-700 hover:text-red-500 hover:bg-white shadow-xs flex items-center justify-center transition-all opacity-90 group-hover:opacity-100" 
            title="Add to Wishlist"
            aria-label="Add to Wishlist">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
      </svg>
    </button>

    <!-- Product Image Link -->
    <a href="{{ $productUrl }}" class="block w-full h-full">
      <img src="{{ $product['image_url'] ?? global_asset('images/products/' . ($product['image'] ?? 'no-image.png')) }}" 
           alt="{{ $product['name'] }}" 
           class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
           loading="lazy">
    </a>

    <!-- Quick Add Button Overlay (appears on desktop hover, always present on mobile) -->
    <div class="absolute inset-x-2 bottom-2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:block">
      <button type="button" 
              class="js-add-to-cart w-full h-9 bg-vog-black/90 hover:bg-vog-black text-white text-xs font-semibold rounded-lg flex items-center justify-center gap-1.5 shadow-md active:scale-95 transition-all"
              data-out-of-stock="{{ !empty($product['is_available']) ? '0' : '1' }}"
              data-is-preorder="{{ !empty($product['is_preorder_active']) ? '1' : '0' }}"
              data-id="{{ $product['id'] }}"
              data-slug="{{ $product['slug'] ?? $product['id'] }}"
              data-name="{{ $product['name'] }}"
              data-price="{{ $price }}"
              data-image="{{ $product['image_url'] ?? '' }}"
              data-currency="{{ $product['currency'] ?? '$' }}"
              data-qty="1"
              data-stock="{{ $product['stock'] ?? 100 }}"
              data-added-label="Added to Bag">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Add to Bag</span>
      </button>
    </div>

  </div>

  <!-- Product Meta -->
  <div class="space-y-1">
    
    <!-- Title -->
    <h3 class="text-xs sm:text-sm font-medium text-slate-900 tracking-tight line-clamp-1 group-hover:text-vog-tan transition-colors">
      <a href="{{ $productUrl }}">
        {{ $product['name'] }}
      </a>
    </h3>

    <!-- Price -->
    <div class="flex items-center gap-2 pt-0.5">
      <span class="text-xs sm:text-sm font-bold text-slate-900">
        {{ $priceFormatted }}
      </span>
      @if($isOnSale && $comparePriceFormatted)
        <span class="text-[11px] sm:text-xs text-slate-400 line-through">
          {{ $comparePriceFormatted }}
        </span>
      @endif
    </div>

    <!-- Color Swatches Dots (Editorial Fashion Detail) -->
    <div class="flex items-center gap-1 pt-1">
      <span class="w-2.5 h-2.5 rounded-full bg-[#E5D7C5] border border-black/10"></span>
      <span class="w-2.5 h-2.5 rounded-full bg-[#1A1A1A] border border-black/10"></span>
      <span class="w-2.5 h-2.5 rounded-full bg-[#8E7963] border border-black/10"></span>
      <span class="text-[10px] text-slate-400 font-medium ml-1">+2</span>
    </div>

    <!-- Mobile Add to Bag Button (visible on mobile only) -->
    <div class="sm:hidden pt-2">
      <button type="button" 
              class="js-add-to-cart w-full h-8 bg-vog-black hover:bg-neutral-800 text-white text-[11px] font-semibold rounded-md flex items-center justify-center gap-1 active:scale-95 transition-all"
              data-out-of-stock="{{ !empty($product['is_available']) ? '0' : '1' }}"
              data-is-preorder="{{ !empty($product['is_preorder_active']) ? '1' : '0' }}"
              data-id="{{ $product['id'] }}"
              data-slug="{{ $product['slug'] ?? $product['id'] }}"
              data-name="{{ $product['name'] }}"
              data-price="{{ $price }}"
              data-image="{{ $product['image_url'] ?? '' }}"
              data-currency="{{ $product['currency'] ?? '$' }}"
              data-qty="1"
              data-stock="{{ $product['stock'] ?? 100 }}"
              data-added-label="Added">
        <span>Add to Bag</span>
      </button>
    </div>

  </div>

</article>
