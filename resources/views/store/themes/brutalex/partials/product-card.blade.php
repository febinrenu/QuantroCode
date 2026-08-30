{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-white border-4 border-ink-black bx-shadow-sm bx-shadow-hover flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden border-b-4 border-ink-black" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover grayscale-[15%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl bx-head" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 bg-ink-red text-white text-[11px] font-mono font-bold px-2 py-1 border-2 border-ink-black">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 bg-ink-black text-white text-[11px] font-mono font-bold px-2 py-1 border-2 border-white">PRE-ORDER</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 bg-white text-ink-black text-[11px] font-mono font-bold px-2 py-1 border-2 border-ink-black">SOLD OUT</span>
    @endif
  </a>

  <div class="product-body p-3 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[10px] font-mono font-bold text-ink-red uppercase tracking-widest">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm font-bold bx-copy text-ink-black mt-0.5 line-clamp-2 hover:text-ink-red" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-2">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5 font-mono">
          <span class="price text-base font-bold text-ink-black">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-ink-black/40 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 border-4 border-ink-black bg-white text-ink-black text-xs font-bold uppercase tracking-wide hover:bg-ink-black hover:text-white transition-colors">
            View Options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 border-4 border-ink-black bg-ink-black text-white text-xs font-bold uppercase tracking-wide hover:bg-ink-red hover:border-ink-red disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            {{ $product['is_preorder_active'] ? 'PRE-ORDER' : strtoupper(__('messages.AddToCart')) }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs font-mono font-bold text-ink-red underline">SIGN IN FOR PRICE</a>
      @endif
      <div class="js-add-status text-[11px] font-mono text-ink-black/40 min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
