{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. --}}
<article class="product-card group bg-white border border-tc-green/10 hover:shadow-cardHover transition-shadow flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden bg-tc-cream" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-serif font-bold" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    <button type="button" class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 shadow-card inline-flex items-center justify-center text-tc-inkSoft hover:text-tc-gold">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
    </button>

    @if($product['is_on_sale'])
      <span class="absolute top-2 left-2 bg-tc-gold text-white text-[10px] font-bold eyebrow px-2 py-1">-{{ $product['discount_percent'] }}%</span>
    @elseif($product['stock_status'] === 'preorder')
      <span class="absolute top-2 left-2 bg-tc-green text-white text-[10px] font-bold eyebrow px-2 py-1">Pre-order</span>
    @elseif($product['stock_status'] === 'out_of_stock')
      <span class="absolute top-2 left-2 bg-tc-ink/80 text-white text-[10px] font-bold eyebrow px-2 py-1">Out of stock</span>
    @endif
  </a>

  <div class="product-body p-4 flex flex-col flex-1">
    <a href="{{ $product['url'] }}" class="product-title text-sm font-semibold text-tc-ink line-clamp-2 hover:text-tc-green" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="flex items-center gap-1 mt-1.5">
      <div class="flex gap-0.5 text-tc-gold">
        @for($i=0;$i<5;$i++)<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
      </div>
      <span class="text-[11px] text-tc-inkSoft">({{ (($product['id'] ?? 1) * 17) % 140 + 30 }})</span>
    </div>

    <div class="mt-auto pt-3">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-base font-bold text-tc-ink">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-tc-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2.5 w-full inline-flex items-center justify-center gap-1.5 h-10 border border-tc-green text-tc-green text-xs font-bold eyebrow hover:bg-tc-green hover:text-white transition-colors">
            {{ 'View options' }}
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2.5 w-full inline-flex items-center justify-center gap-1.5 h-10 bg-tc-green text-white text-xs font-bold eyebrow hover:bg-tc-greenDeep disabled:opacity-40 disabled:cursor-not-allowed transition"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-tc-green underline">{{ 'Sign in for price' }}</a>
      @endif
      <div class="js-add-status text-[11px] text-tc-inkSoft min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
