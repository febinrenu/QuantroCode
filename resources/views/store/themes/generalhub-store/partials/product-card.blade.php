{{-- GeneralHub Product Card Component --}}
@php
  $slugName = \Illuminate\Support\Str::slug($product['name']);
  $imgSrc = $product['image_url'];
  if (!$imgSrc || str_contains($imgSrc, 'no-image.png')) {
      if (file_exists(public_path('images/themes/generalhub/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/themes/generalhub/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/products/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg');
      }
  }

  $productUrl = $product['url'] ?? '#';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? null);
  if ($themePreview && !str_contains($productUrl, 'preview_theme=')) {
      $productUrl .= (str_contains($productUrl, '?') ? '&' : '?') . 'preview_theme=' . urlencode($themePreview);
  }

  // Simulated badge based on product flags
  $isSale = $product['is_on_sale'] || ($product['discount_percent'] > 0);
  $isBest = str_contains(strtolower($product['name']), 'watch') || str_contains(strtolower($product['name']), 'perfume') || str_contains(strtolower($product['name']), 'sneaker');
  $isNew = str_contains(strtolower($product['name']), 'sofa') || str_contains(strtolower($product['name']), 'hoodie') || str_contains(strtolower($product['name']), 'keyboard') || str_contains(strtolower($product['name']), 'lamp') || str_contains(strtolower($product['name']), 'box') || str_contains(strtolower($product['name']), 'moisturizer') || str_contains(strtolower($product['name']), 'yoga');
@endphp

<article class="hub-card group relative bg-white border border-slate-200 rounded-xl overflow-hidden flex flex-col h-full shadow-sm hover:border-hub-blue/50 transition-all duration-300">
  
  <!-- Top Badges & Wishlist -->
  <div class="relative aspect-square overflow-hidden bg-slate-50 p-4 flex items-center justify-center">
    
    <!-- Top Left Badge -->
    <div class="absolute top-3 left-3 z-10">
      @if($isSale)
        <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
          -{{ $product['discount_percent'] > 0 ? $product['discount_percent'] : '30' }}%
        </span>
      @elseif($isBest)
        <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
          Best Seller
        </span>
      @elseif($isNew)
        <span class="bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
          New
        </span>
      @endif
    </div>

    <!-- Top Right Wishlist Button -->
    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 shadow-sm flex items-center justify-center text-slate-400 hover:text-rose-500 hover:border-rose-200 transition-colors z-10" aria-label="Add to Wishlist">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
    </button>

    <!-- Product Image -->
    <a href="{{ $productUrl }}" class="block w-full h-full">
      @if($imgSrc)
        <img src="{{ $imgSrc }}" 
             alt="{{ $product['name'] }}" 
             loading="lazy" 
             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
      @else
        <div class="w-full h-full flex items-center justify-center text-slate-300">
          <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
      @endif
    </a>
  </div>

  <!-- Content Details -->
  <div class="p-4 flex flex-col flex-1 bg-white">
    
    <!-- Title -->
    <a href="{{ $productUrl }}" class="font-semibold text-xs sm:text-sm text-slate-900 group-hover:text-hub-blue transition-colors line-clamp-1">
      {{ $product['name'] }}
    </a>

    <!-- Rating Row -->
    <div class="flex items-center gap-1.5 mt-1.5 text-xs">
      <div class="flex text-amber-400 text-[11px]">
        ★★★★★
      </div>
      <span class="text-slate-400 text-[11px]">
        ({{ rand(150, 1400) }})
      </span>
    </div>

    <!-- Pricing Row -->
    <div class="mt-2.5 flex items-baseline gap-2">
      <span class="font-bold text-base sm:text-lg text-slate-900">
        {{ $product['final_price_formatted'] }}
      </span>
      @if($product['compare_at_price_formatted'])
        <span class="text-xs text-slate-400 line-through">
          {{ $product['compare_at_price_formatted'] }}
        </span>
      @elseif($isSale)
        <span class="text-xs text-slate-400 line-through">
          ${{ number_format($product['final_price'] * 1.25, 2) }}
        </span>
      @endif
    </div>

    <!-- Action Button (Add to Cart) -->
    <div class="mt-3 pt-2">
      <button type="button"
              class="js-add-to-cart w-full h-9 bg-hub-blue hover:bg-hub-blueHover text-white text-xs font-semibold rounded-lg flex items-center justify-center gap-2 transition-all shadow-sm active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
              @if(!$product['is_available']) disabled @endif
              data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
              data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
              data-id="{{ $product['id'] }}"
              data-slug="{{ $product['slug'] }}"
              data-name="{{ e($product['name']) }}"
              data-price="{{ number_format($product['final_price'], 2, '.', '') }}"
              data-image="{{ $imgSrc }}"
              data-currency="{{ $product['currency'] ?? '$' }}"
              data-qty="1"
              data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
              data-added-label="Added">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span>Add to Cart</span>
      </button>
    </div>

  </div>

</article>
