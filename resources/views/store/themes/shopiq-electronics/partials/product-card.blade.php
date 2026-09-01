<article class="group relative bg-white border border-iq-line rounded-2xl overflow-hidden hover:shadow-lift transition-shadow">
  <a href="{{ $product['url'] }}" class="block relative aspect-square bg-iq-lav overflow-hidden">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    @else
      <div class="h-full grid place-items-center text-iq-purple">
        <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><rect x="4" y="4" width="16" height="12" rx="2"/><path stroke-linecap="round" d="M8 20h8M12 16v4"/></svg>
      </div>
    @endif
    @if($product['is_on_sale'])<span class="absolute top-3 left-3 text-[10px] font-bold bg-rose-500 text-white px-2 py-1 rounded-full">-{{ $product['discount_percent'] }}%</span>@endif
    <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 grid place-items-center text-iq-navy hover:text-rose-500">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
    </span>
  </a>
  <div class="p-3.5">
    <a href="{{ $product['url'] }}" class="block font-semibold text-[13px] truncate text-iq-navy">{{ $product['name'] }}</a>
    <div class="mt-1.5 flex items-center gap-1 text-iq-gold">
      @for($i=0;$i<5;$i++)<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
      <span class="text-iq-mute text-[11px] ml-1">({{ 60 + (($product['id'] ?? 0) % 90) }})</span>
    </div>
    @if(!$product['hide_prices'])
      <div class="mt-1.5 flex items-baseline gap-2">
        <span class="font-bold text-[14px] text-iq-navy">{{ $product['final_price_formatted'] }}</span>
        @if($product['compare_at_price_formatted'])<span class="text-[11px] text-iq-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>@endif
      </div>
    @endif
    @if(!$product['hide_prices'] && !count($product['variants']))
      <button type="button" class="js-add-to-cart w-full mt-2.5 h-9 bg-iq-purple text-white text-xs font-bold rounded-lg hover:brightness-95 transition"
        data-out-of-stock="{{ $product['is_available'] ? '0':'1' }}"
        data-is-preorder="{{ $product['is_preorder_active'] ? '1':'0' }}"
        data-id="{{ $product['id'] }}"
        data-slug="{{ $product['slug'] }}"
        data-name="{{ e($product['name']) }}"
        data-price="{{ number_format($product['final_price'],2,'.','') }}"
        data-image="{{ $product['image_url'] }}"
        data-currency="{{ $product['currency'] }}"
        data-qty="1"
        data-stock="{{ $product['stock'] ?? '' }}">Add to Cart</button>
    @endif
  </div>
</article>
