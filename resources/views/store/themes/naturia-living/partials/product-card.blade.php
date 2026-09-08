{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. --}}
<article class="product-card group bg-white border border-nt-green/10 rounded-xl hover:shadow-cardHover transition-shadow flex flex-col relative">
  @if($product['is_on_sale'])
    <span class="absolute top-2 left-2 z-10 bg-nt-green text-white text-[10px] font-bold px-2 py-1 rounded-full">-{{ $product['discount_percent'] }}%</span>
  @elseif($product['stock_status'] === 'preorder')
    <span class="absolute top-2 left-2 z-10 bg-nt-tan text-white text-[10px] font-bold px-2 py-1 rounded-full">Pre-order</span>
  @elseif($product['stock_status'] === 'out_of_stock')
    <span class="absolute top-2 left-2 z-10 bg-nt-ink/80 text-white text-[10px] font-bold px-2 py-1 rounded-full">Out of stock</span>
  @endif

  <button type="button" class="absolute top-2 right-2 z-10 w-7 h-7 rounded-full bg-white/90 shadow-card inline-flex items-center justify-center text-nt-inkSoft hover:text-nt-green">
    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
  </button>

  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden bg-nt-creamDark rounded-t-xl" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-serif font-bold" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif
  </a>

  <div class="product-body p-3 flex flex-col flex-1">
    <a href="{{ $product['url'] }}" class="product-title text-sm font-semibold text-nt-ink line-clamp-2 hover:text-nt-green" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="flex items-center gap-1 mt-1">
      <div class="flex gap-0.5 text-nt-gold">
        @for($i=0;$i<5;$i++)<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
      </div>
      <span class="text-[11px] text-nt-inkSoft">({{ (($product['id'] ?? 1) * 17) % 140 + 30 }})</span>
    </div>

    <div class="mt-auto pt-2">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-base font-bold text-nt-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-nt-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 border border-nt-green text-nt-green rounded-full text-xs font-bold hover:bg-nt-green hover:text-white transition-colors">
            {{ 'View options' }}
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 bg-nt-green text-white rounded-full text-xs font-bold hover:bg-nt-greenDeep disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
            {{ $product['is_preorder_active'] ? 'Pre-order' : (__('messages.AddToCart') ?? 'Add to Cart') }}
          </button>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-nt-green underline">{{ 'Sign in for price' }}</a>
      @endif
      <div class="js-add-status text-[11px] text-nt-inkSoft min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
