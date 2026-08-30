{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
<article class="product-card group bg-white rounded-lg border border-mv-line hover:border-mv-accent shadow-tile hover:shadow-tileHover transition-all overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-2xl font-black" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    <div class="absolute top-1.5 left-1.5 flex flex-col gap-1 items-start">
      @if($product['is_on_sale'])
        <span class="bg-mv-accent text-white text-[10px] font-bold px-1.5 py-0.5 rounded mv-mono">-{{ $product['discount_percent'] }}%</span>
      @elseif($product['stock_status'] === 'preorder')
        <span class="bg-mv-ink text-white text-[10px] font-bold px-1.5 py-0.5 rounded mv-mono">PREORDER</span>
      @elseif($product['stock_status'] === 'out_of_stock')
        <span class="bg-slate-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded mv-mono">SOLD OUT</span>
      @elseif($product['stock_status'] === 'low_stock')
        <span class="bg-amber-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded mv-mono">LOW STOCK</span>
      @endif
    </div>

    @if($product['brand_name'] || $product['category_name'])
      <span class="absolute top-1.5 right-1.5 bg-mv-ink/90 text-mv-accentLight text-[9px] font-bold px-1.5 py-0.5 rounded mv-chip max-w-[70%] truncate">
        {{ $product['brand_name'] ?: $product['category_name'] }}
      </span>
    @endif
  </a>

  <div class="product-body p-2.5 flex flex-col flex-1">
    <div class="flex items-center justify-between gap-1">
      @if($product['category_name'])
        <span class="text-[10px] font-bold text-mv-accentDark uppercase tracking-wide truncate">{{ $product['category_name'] }}</span>
      @else
        <span></span>
      @endif
      <span class="text-[9px] text-mv-slate mv-mono shrink-0">#{{ $product['sku'] }}</span>
    </div>
    <a href="{{ $product['url'] }}" class="product-title text-[13px] leading-snug font-semibold text-mv-ink mt-0.5 line-clamp-2 hover:text-mv-accentDark" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-2">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5 flex-wrap">
          <span class="price mv-mono text-[15px] font-bold text-mv-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-[11px] text-mv-slate line-through mv-mono">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2 w-full inline-flex items-center justify-center gap-1.5 h-8 rounded-md bg-mv-accentSoft text-mv-accentDark text-xs font-bold hover:bg-mv-accent hover:text-white transition-colors">
            View options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2 w-full inline-flex items-center justify-center gap-1.5 h-8 rounded-md bg-mv-ink text-white text-xs font-bold hover:bg-mv-accentDark disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            {{ $product['is_preorder_active'] ? 'Pre-order' : __('messages.AddToCart') }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs font-bold text-mv-accentDark underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[10px] text-mv-slate min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
