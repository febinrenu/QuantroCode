{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-vel-charcoal border border-vel-line hover:border-vel-gold/50 transition-colors overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden bg-vel-black" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-serif font-bold" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 bg-vel-burgundy text-vel-ink text-[10px] font-bold eyebrow px-2 py-1">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 bg-vel-gold text-vel-black text-[10px] font-bold eyebrow px-2 py-1">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 bg-vel-black/80 border border-vel-line text-vel-mute text-[10px] font-bold eyebrow px-2 py-1">Out of stock</span>
    @endif
  </a>

  <div class="product-body p-4 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[10px] font-semibold text-vel-gold eyebrow">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title font-serif text-[15px] font-semibold text-vel-ink mt-1 line-clamp-2 hover:text-vel-gold" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2">
          <span class="price text-base font-bold text-vel-gold">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-vel-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 h-9 border border-vel-gold/40 text-vel-gold text-sm font-semibold hover:bg-vel-gold hover:text-vel-black transition-colors">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-3 w-full inline-flex items-center justify-center gap-1.5 h-9 bg-vel-gold text-vel-black text-sm font-semibold hover:bg-vel-goldSoft disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
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
                  data-added-label="{{ __('messages.Added') }}">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            {{ $product['is_preorder_active'] ? 'Pre-order' : __('messages.AddToCart') }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-vel-gold underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-vel-mute min-h-[1rem] mt-1.5"></div>
    </div>
  </div>
</article>
