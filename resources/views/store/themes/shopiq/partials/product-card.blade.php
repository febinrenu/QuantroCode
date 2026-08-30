{{-- Pure presentation — $product is the StorefrontPresenter::product() view-model. No pricing/business logic here. --}}
@php
  // Comparison-style badge chip: rotate/vary by sale/featured status, else by index/id, for a "smart shopping assistant" feel.
  $iqIdx = $idx ?? $product['id'] ?? 0;
  if (!empty($product['is_on_sale'])) {
      $iqBadge = ['label' => 'Best Value', 'classes' => 'bg-brand-amber text-white'];
  } elseif (!empty($product['is_featured'])) {
      $iqBadge = ['label' => 'Staff Pick', 'classes' => 'bg-brand-teal text-white'];
  } elseif ($iqIdx % 3 === 0) {
      $iqBadge = ['label' => 'Trending', 'classes' => 'bg-brand-violet text-white'];
  } else {
      $iqBadge = null;
  }
@endphp
<article class="product-card group bg-white rounded-xl border border-brand-line shadow-card hover:shadow-cardHover transition-shadow overflow-hidden flex flex-col">
  <a href="{{ $product['url'] }}" class="relative block aspect-square overflow-hidden" style="{{ !$product['image_url'] ? 'background:'.$product['placeholder_color'].'22' : '' }}">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
    @else
      <div class="w-full h-full flex items-center justify-center text-3xl font-black" style="color: {{ $product['placeholder_color'] }}">
        {{ strtoupper(substr($product['name'], 0, 1)) }}
      </div>
    @endif

    <div class="absolute top-2 left-2 flex flex-col items-start gap-1">
      @if($iqBadge)
        <span class="iq-badge {{ $iqBadge['classes'] }} text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded-full inline-flex items-center gap-1">
          <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
          {{ $iqBadge['label'] }}
        </span>
      @endif
      @if($product['is_on_sale'])
        <span class="iq-badge bg-brand-navy text-white text-[11px] font-bold px-2 py-0.5 rounded-full">-{{ $product['discount_percent'] }}%</span>
      @elseif($product['stock_status'] === 'preorder')
        <span class="iq-badge bg-brand-teal text-white text-[11px] font-bold px-2 py-0.5 rounded-full">Pre-order</span>
      @elseif($product['stock_status'] === 'out_of_stock')
        <span class="iq-badge bg-slate-700 text-white text-[11px] font-bold px-2 py-0.5 rounded-full">Out of stock</span>
      @endif
    </div>
  </a>

  <div class="product-body p-3 flex flex-col flex-1">
    @if($product['category_name'])
      <span class="text-[11px] font-semibold text-brand-teal uppercase tracking-wide">{{ $product['category_name'] }}</span>
    @endif
    <a href="{{ $product['url'] }}" class="product-title text-sm font-semibold text-brand-navy mt-0.5 line-clamp-2 hover:text-brand-teal" title="{{ $product['name'] }}">
      {{ $product['name'] }}
    </a>

    <div class="mt-auto pt-2">
      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-1.5">
          <span class="price text-base font-bold text-brand-navy">{{ $product['final_price_formatted'] }}</span>
          @if($product['compare_at_price_formatted'])
            <span class="text-xs text-slate-400 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>

        @if(count($product['variants']) > 0)
          <a href="{{ $product['url'] }}" class="mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 rounded-lg bg-brand-tealLight text-brand-tealDark text-sm font-semibold hover:bg-brand-teal hover:text-white transition-colors">
            Compare options
          </a>
        @else
          <button type="button"
                  class="js-add-to-cart mt-2 w-full inline-flex items-center justify-center gap-1.5 h-9 rounded-lg bg-brand-teal text-white text-sm font-semibold hover:bg-brand-tealDark disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
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
        <a href="{{ url('/online_store/login') }}" class="text-xs font-semibold text-brand-teal underline">Sign in for price</a>
      @endif
      <div class="js-add-status text-[11px] text-slate-400 min-h-[1rem] mt-1"></div>
    </div>
  </div>
</article>
