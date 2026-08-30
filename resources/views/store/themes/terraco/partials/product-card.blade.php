{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-terra-surface border border-terra-line hover:border-terra-lineStrong transition-colors overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden bg-terra-bg" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'14' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-heading font-light" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-0 left-0 bg-terra-slate text-white text-[10px] font-medium tracking-wide px-2 py-1">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-0 left-0 bg-terra-ink text-white text-[10px] font-medium tracking-wide px-2 py-1">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-0 left-0 bg-terra-inkSoft text-white text-[10px] font-medium tracking-wide px-2 py-1">Sold out</span>
    @endif
  </a>

  <div class="product-body p-4 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[10px] eyebrow text-terra-inkSoft">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm text-terra-ink mt-1 line-clamp-2 hover:text-terra-slate" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2">
          <span class="price text-base font-medium text-terra-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-terra-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 h-9 border border-terra-line text-terra-ink text-xs font-medium tracking-wide hover:border-terra-slate hover:text-terra-slate transition-colors">
            VIEW OPTIONS
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-3 w-full inline-flex items-center justify-center gap-1.5 h-9 border border-terra-slate text-terra-slate text-xs font-medium tracking-wide hover:bg-terra-slate hover:text-white disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
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
            {{ $product['is_preorder_active'] ? 'PRE-ORDER' : strtoupper(__('messages.AddToCart')) }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs font-medium text-terra-slate underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-terra-inkSoft min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
