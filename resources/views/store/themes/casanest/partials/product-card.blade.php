{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-white border border-cn-gold/25 hover:border-cn-gold shadow-card hover:shadow-cardHover transition-all overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'1a' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-display font-semibold" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 bg-cn-emeraldDark text-cn-goldLight text-[10px] eyebrow font-bold px-2 py-1">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 bg-cn-gold text-white text-[10px] eyebrow font-bold px-2 py-1">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 bg-black/70 text-white text-[10px] eyebrow font-bold px-2 py-1">Sold Out</span>
    @endif

    <span class="absolute top-2 right-2 w-7 h-7 border border-cn-gold/60 bg-white/80 hidden"></span>
  </a>

  <div class="product-body p-4 flex flex-col flex-1 text-center">
    @if($product['category_name'])
      <span class="text-[10px] eyebrow font-semibold text-cn-gold">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title font-display text-lg font-medium text-cn-ink mt-0.5 line-clamp-2 hover:text-cn-emerald" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline justify-center gap-1.5">
          <span class="price text-base font-bold text-cn-emerald">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-cn-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 border border-cn-emerald text-cn-emerald text-xs eyebrow font-semibold hover:bg-cn-emerald hover:text-white transition-colors">
            View Options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 bg-cn-emerald text-white text-xs eyebrow font-semibold hover:bg-cn-emeraldDark disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
            {{ $product['is_preorder_active'] ? 'Pre-order' : __('messages.AddToCart') }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs eyebrow font-semibold text-cn-emerald underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-cn-mute min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
