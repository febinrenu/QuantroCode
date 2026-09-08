{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-white border border-black/10 hover:border-brand-magenta transition-colors overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-[4/5] overflow-hidden bg-brand-paper" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-display" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-0 left-0 bg-brand-magenta text-white text-[11px] font-bold px-2.5 py-1 uppercase tracking-wide">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-0 left-0 bg-black text-white text-[11px] font-bold px-2.5 py-1 uppercase tracking-wide">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-0 left-0 bg-black/70 text-white text-[11px] font-bold px-2.5 py-1 uppercase tracking-wide">Out of stock</span>
    @endif
  </a>

  <div class="product-body p-3.5 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[10px] font-bold text-brand-magenta uppercase tracking-widest">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm font-semibold text-black mt-0.5 line-clamp-2 hover:text-brand-magenta" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-2.5">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-lg font-display text-black">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-black/35 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 border border-black text-black text-xs font-bold uppercase tracking-wide hover:bg-black hover:text-white transition-colors">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 bg-black text-white text-xs font-bold uppercase tracking-wide hover:bg-brand-magenta disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-bold text-brand-magenta underline uppercase">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-black/40 min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
