{{-- AurumÉclat Luxury Product Card --}}
@php
  $slugName = \Illuminate\Support\Str::slug($product['name']);
  $imgSrc = $product['image_url'];
  if (!$imgSrc || str_contains($imgSrc, 'no-image.png')) {
      if (file_exists(public_path('images/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/products/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg');
      }
  }
  $productUrl = $product['url'] ?? '#';
  $previewThemeParam = request('preview_theme') ?: (session('preview_theme') ?? null);
  if ($previewThemeParam && !str_contains($productUrl, 'preview_theme=')) {
      $productUrl .= (str_contains($productUrl, '?') ? '&' : '?') . 'preview_theme=' . urlencode($previewThemeParam);
  }
@endphp

<article class="product-card group relative bg-[#120F0C] border border-aurum-border hover:border-aurum-gold/60 transition-all duration-500 rounded-none overflow-hidden flex flex-col h-full luxury-card-hover">
  
  <!-- Image Container -->
  <div class="relative aspect-square overflow-hidden bg-[#0A0908] p-3 flex items-center justify-center">
    <a href="{{ $productUrl }}" class="block w-full h-full">
      @if($imgSrc)
        <img src="{{ $imgSrc }}" 
             alt="{{ $product['name'] }}" 
             loading="lazy" 
             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700">
      @else
        <div class="w-full h-full flex items-center justify-center text-3xl font-serif text-aurum-gold/40 bg-[#12100E]">
          ✦
        </div>
      @endif
    </a>

    <!-- Top Left Badges -->
    <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
      @if($product['is_on_sale'])
        <span class="bg-aurum-wine border border-aurum-wine/80 text-white text-[9px] font-bold tracking-widest uppercase px-2 py-0.5 shadow-sm">
          -{{ $product['discount_percent'] }}%
        </span>
      @elseif($product['stock_status'] === 'preorder')
        <span class="bg-aurum-gold/90 text-aurum-black text-[9px] font-bold tracking-widest uppercase px-2 py-0.5">
          PRE-ORDER
        </span>
      @endif
    </div>

    <!-- Top Right Wishlist Heart -->
    <button type="button" class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold/50 transition-colors z-10" aria-label="Add to Wishlist">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
    </button>
  </div>

  <!-- Content Body -->
  <div class="p-3.5 sm:p-4 flex flex-col flex-1 bg-[#120F0C]">
    
    <!-- Title -->
    <a href="{{ $productUrl }}" class="font-serif text-[13px] sm:text-[14px] font-medium text-white group-hover:text-aurum-gold transition-colors line-clamp-1">
      {{ $product['name'] }}
    </a>

    <!-- Metal / Subtitle -->
    <div class="text-[10px] tracking-wider text-aurum-goldLight/60 mt-0.5 uppercase font-light">
      {{ $product['category_name'] ?? '18K Fine Gold' }}
    </div>

    <!-- Rating Stars -->
    <div class="flex items-center gap-1 mt-1 text-aurum-gold text-[10px]">
      <span>★★★★★</span>
      <span class="text-white/40 text-[9px] ml-0.5">(5.0)</span>
    </div>

    <!-- Price Row & Actions -->
    <div class="mt-auto pt-3 border-t border-aurum-border/50 flex items-end justify-between gap-2">
      <div>
        @if(!$product['hide_prices'])
          <div class="flex items-baseline gap-1.5">
            <span class="font-serif text-sm sm:text-base font-semibold text-white">
              {{ $product['final_price_formatted'] }}
            </span>
            @if($product['compare_at_price_formatted'])
              <span class="text-[11px] text-aurum-goldLight/40 line-through font-light">
                {{ $product['compare_at_price_formatted'] }}
              </span>
            @endif
          </div>
        @else
          <span class="text-[10px] text-aurum-goldLight/50 uppercase tracking-wider">Inquire Price</span>
        @endif
      </div>

      <!-- Quick Add to Bag -->
      <button type="button" 
              onclick="window.dispatchEvent(new CustomEvent('add-to-cart', { detail: { id: {{ $product['id'] }}, name: '{{ addslashes($product['name']) }}', price: {{ $product['final_price'] }}, image: '{{ $imgSrc }}' } }))"
              class="w-7 h-7 rounded-none bg-aurum-border/60 hover:bg-aurum-gold hover:text-aurum-black text-aurum-goldLight flex items-center justify-center transition-colors shrink-0" 
              title="Add to Shopping Bag">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
          <line x1="3" y1="6" x2="21" y2="6"></line>
        </svg>
      </button>
    </div>

  </div>

</article>
