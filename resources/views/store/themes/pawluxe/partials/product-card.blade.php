<article class="group relative bg-white border border-pl-line rounded-2xl overflow-hidden hover:shadow-lift transition-shadow">
  <a href="{{ $product['url'] }}" class="block relative aspect-square bg-pl-mint overflow-hidden">
    @if($product['image_url'])
      <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    @else
      <div class="h-full grid place-items-center text-pl-teal">
        <svg class="w-10 h-10" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
      </div>
    @endif
    @if($product['is_on_sale'])
      <span class="absolute top-3 left-3 text-[10px] font-bold bg-pl-teal text-white px-2 py-1 rounded-full">Best Seller</span>
    @endif
    <span class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/90 grid place-items-center text-pl-ink hover:text-pl-coral">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
    </span>
  </a>
  <div class="p-3.5">
    <a href="{{ $product['url'] }}" class="block font-bold text-[13px] truncate text-pl-ink">{{ $product['name'] }}</a>
    <div class="mt-1.5 flex items-center gap-1 text-pl-coral">
      @for($i=0;$i<5;$i++)<svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
      <span class="text-pl-mute text-[11px] ml-1">({{ 40 + (($product['id'] ?? 0) % 90) }})</span>
    </div>
    @if(!$product['hide_prices'])<div class="font-bold mt-1.5 text-[14px] text-pl-ink">{{ $product['final_price_formatted'] }}</div>@endif
    @if(!$product['hide_prices'] && !count($product['variants']))
      <button type="button" class="js-add-to-cart w-full mt-2.5 h-9 bg-pl-coral text-white text-xs font-bold rounded-lg hover:brightness-95 transition"
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
