{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-white rounded-3xl border border-nx-chrome1 shadow-card hover:shadow-cardHover transition-shadow overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden rounded-t-3xl" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'1a' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-black" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 w-12 h-12 rounded-full nx-holo-bg text-white text-[11px] font-black flex flex-col items-center justify-center leading-none rotate-[-8deg] shadow-card">
        <span>-{{ $product['discount_percent'] }}%</span>
      </span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 nx-sticker text-nx-ink text-[10px] font-bold px-2.5 py-1 rounded-full">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 bg-nx-ink/80 text-white text-[10px] font-bold px-2.5 py-1 rounded-full">Sold Out</span>
    @elseif($product['is_featured'])
      <span class="absolute top-2 left-2 w-12 h-12 rounded-full nx-holo-bg text-white text-[10px] font-black flex items-center justify-center rotate-[-8deg] shadow-card">NEW</span>
    @endif
  </a>

  <div class="product-body p-4 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[11px] font-bold text-nx-violet uppercase tracking-wide">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm font-bold text-nx-ink mt-0.5 line-clamp-2 hover:text-nx-pink" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-base font-black text-nx-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-nx-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="nx-shine mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 nx-pill border border-nx-chrome1 nx-chrome text-nx-ink text-sm font-bold hover:shadow-card transition-shadow">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart nx-shine mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 nx-pill nx-holo-bg text-white text-sm font-bold disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-bold text-nx-pink underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-nx-mute min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
