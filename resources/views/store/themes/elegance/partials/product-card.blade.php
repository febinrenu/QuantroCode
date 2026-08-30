{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-[4/5] overflow-hidden bg-brand-paper" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-serif" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    @if($product['is_on_sale'])
      <span class="absolute top-3 left-3 bg-brand-charcoal text-brand-cream text-[10px] eyebrow font-semibold px-2 py-1">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-3 left-3 bg-brand-gold text-brand-cream text-[10px] eyebrow font-semibold px-2 py-1">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-3 left-3 bg-brand-charcoalSoft text-brand-cream text-[10px] eyebrow font-semibold px-2 py-1">Out of stock</span>
    @endif
  </a>

  <div class="product-body pt-3 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="el-caption text-xs text-brand-gold">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title font-serif text-base text-brand-charcoal mt-0.5 line-clamp-2 hover:text-brand-gold" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-3 border-t el-hairline">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-3">
          <span class="price text-sm font-semibold text-brand-charcoal">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-brand-charcoalSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 border border-brand-charcoal text-brand-charcoal text-xs eyebrow font-semibold hover:bg-brand-charcoal hover:text-brand-cream transition-colors">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-3 w-full inline-flex items-center justify-center gap-1.5 h-10 border border-brand-charcoal text-brand-charcoal text-xs eyebrow font-semibold hover:bg-brand-charcoal hover:text-brand-cream disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-brand-gold underline mt-3 inline-block">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-brand-charcoalSoft min-h-[1rem] mt-1.5">
      </div>
    </div>
  </div>
</article>
