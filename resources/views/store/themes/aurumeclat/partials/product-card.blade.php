{{-- AurumÉclat Luxury Product Card --}}
<article class="product-card group relative bg-[#141210] border border-aurum-border/80 hover:border-aurum-gold/60 transition-all duration-500 rounded-none overflow-hidden flex flex-col h-full luxury-card-hover">
  
  <!-- Image Container -->
  <div class="relative aspect-square overflow-hidden bg-[#0A0908] p-3 flex items-center justify-center">
    <a href="{{ $product['url'] }}" class="block w-full h-full">
      @if($product['image_url'])
        <img src="{{ $product['image_url'] }}" 
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
    <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
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
    <button type="button" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/40 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold/50 transition-colors z-10" aria-label="Add to Wishlist">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
    </button>
  </div>

  <!-- Content Body -->
  <div class="p-4 sm:p-5 flex flex-col flex-1 bg-[#141210]">
    
    <!-- Title -->
    <a href="{{ $product['url'] }}" class="font-serif text-[15px] sm:text-base font-medium text-white group-hover:text-aurum-gold transition-colors line-clamp-1">
      {{ $product['name'] }}
    </a>

    <!-- Metal / Subtitle -->
    <div class="text-[11px] tracking-wider text-aurum-goldLight/60 mt-1 uppercase font-light">
      {{ $product['category_name'] ?? '18K Fine Gold' }}
    </div>

    <!-- Price & Actions Row -->
    <div class="mt-auto pt-3.5 flex items-center justify-between border-t border-aurum-border/40">
      <div>
        @if(!$product['hide_prices'])
          <div class="flex items-baseline gap-2">
            <span class="text-sm sm:text-base font-semibold text-aurum-gold font-serif">
              {{ $product['final_price_formatted'] }}
            </span>
            @if($product['compare_at_price_formatted'])
              <span class="text-xs text-white/40 line-through">
                {{ $product['compare_at_price_formatted'] }}
              </span>
            @endif
          </div>
        @endif

        <!-- 5 Gold Stars Rating -->
        <div class="flex items-center gap-1 mt-1">
          <div class="flex text-aurum-gold text-[10px]">
            ★★★★★
          </div>
          <span class="text-[10px] text-white/40 font-light">
            ({{ rand(30, 150) }})
          </span>
        </div>
      </div>

      <!-- Quick Add To Bag Icon Button -->
      <div>
        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="w-8 h-8 rounded-full bg-[#1F1C17] border border-aurum-border hover:border-aurum-gold flex items-center justify-center text-aurum-goldLight hover:text-aurum-gold transition-colors" title="Select Options">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart w-8 h-8 rounded-full bg-[#1F1C17] border border-aurum-border hover:border-aurum-gold flex items-center justify-center text-aurum-goldLight hover:text-aurum-gold transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  data-price="{{ number_format($product['final_price'], 2, '.', '') }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  data-qty="1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}"
                  title="Add to Shopping Bag">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
              <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
          </button>
        @endif
      </div>

    </div>

  </div>
</article>
