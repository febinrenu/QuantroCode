<article class="group relative bg-white border border-hl-line rounded-2xl overflow-hidden hover:shadow-lift transition-shadow">
  <a href="{{ $product['url'] }}" class="block relative aspect-square bg-hl-goldLight overflow-hidden">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    @else
      <div class="h-full grid place-items-center text-hl-forest">
        <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><path d="M3 21V9l9-6 9 6v12H3Z"/><path d="M9 21v-8h6v8"/></svg>
      </div>
    @endif
    @if($product['is_on_sale'])<span class="absolute top-3 left-3 text-[10px] font-bold bg-hl-gold text-hl-deep px-2 py-1 rounded">SALE</span>@endif
    <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 grid place-items-center text-hl-ink hover:text-hl-forest">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
    </span>
  </a>
  <div class="p-3.5">
    <a href="{{ $product['url'] }}" class="block font-semibold text-[13px] truncate text-hl-ink">{{ $product['name'] }}</a>
    <div class="mt-1.5 flex items-center gap-1 text-hl-gold">
      @for($i=0;$i<5;$i++)<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
      <span class="text-hl-mute text-[11px] ml-1">({{ 58 + (($product['id'] ?? 0) % 74) }})</span>
    </div>
    @if(!$product['hide_prices'])<div class="font-bold mt-1.5 text-[14px] text-hl-ink">{{ $product['final_price_formatted'] }}</div>@endif
    @if(!$product['hide_prices'] && !count($product['variants']))
      <button type="button" class="js-add-to-cart opacity-0 group-hover:opacity-100 transition absolute inset-x-3 bottom-3 h-9 bg-hl-forest text-white text-xs font-bold rounded-lg hover:bg-hl-deep"
        data-out-of-stock="{{ $product['is_available'] ? '0':'1' }}"
        data-is-preorder="{{ $product['is_preorder_active'] ? '1':'0' }}"
        data-id="{{ $product['id'] }}"
        data-slug="{{ $product['slug'] }}"
        data-name="{{ e($product['name']) }}"
        data-price="{{ number_format($product['final_price'],2,'.','') }}"
        data-image="{{ $product['image_url'] }}"
        data-currency="{{ $product['currency'] }}"
        data-qty="1"
        data-stock="{{ $product['stock'] ?? '' }}">ADD TO CART</button>
    @endif
  </div>
</article>
