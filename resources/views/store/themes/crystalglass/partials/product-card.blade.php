{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group glass rounded-3xl shadow-glass hover:shadow-glassHover transition-shadow overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden rounded-t-3xl" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-black" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 glass-strong text-brand-violetDark text-[11px] font-bold px-2.5 py-1 rounded-full tracking-wide">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 bg-brand-violet text-white text-[11px] font-bold px-2.5 py-1 rounded-full tracking-wide">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 glass-dark text-white text-[11px] font-bold px-2.5 py-1 rounded-full tracking-wide">Out of stock</span>
    @endif
  </a>

  <div class="product-body p-4 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[11px] font-semibold text-brand-violetDark uppercase tracking-widest">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm font-semibold text-brand-ink mt-1 line-clamp-2 hover:text-brand-violetDark tracking-wide" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-base font-bold text-brand-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-brand-ink/40 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2.5 w-full inline-flex items-center justify-center gap-1.5 h-10 rounded-full bg-white/60 text-brand-violetDark text-sm font-semibold tracking-wide hover:bg-gradient-to-r hover:from-brand-violet hover:to-brand-pink hover:text-white transition-colors">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2.5 w-full inline-flex items-center justify-center gap-1.5 h-10 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white text-sm font-semibold tracking-wide hover:brightness-105 disabled:opacity-40 disabled:cursor-not-allowed transition"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-brand-violetDark underline tracking-wide">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-brand-ink/40 min-h-[1rem] mt-1 tracking-wide"></div>
    </div>
  </div>
</article>
