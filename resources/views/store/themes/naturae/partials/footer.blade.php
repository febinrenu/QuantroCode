@php
  $ntSocial = $s->social_links ?? [];
  if (is_string($ntSocial)) { $d = json_decode($ntSocial, true); if (json_last_error() === JSON_ERROR_NONE) $ntSocial = $d; }
  if (!is_array($ntSocial)) { $ntSocial = []; }
  $ntIsAssoc = !empty($ntSocial) && array_keys($ntSocial) !== range(0, count($ntSocial) - 1);
  if ($ntIsAssoc) { $ntSocial = collect($ntSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-leaf-deep text-cream/85">
  <div class="max-w-7xl mx-auto px-4 py-11 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="inline-flex items-center gap-2 font-serif font-semibold text-xl text-white">
        <span class="w-9 h-9 rounded-full border-2 border-terracotta-light flex items-center justify-center shrink-0">
          <svg class="w-4.5 h-4.5 text-terracotta-light" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
        </span>
        <span class="leading-none">
          <span class="block">NATURIA</span>
          <span class="block eyebrow text-[8px] font-bold text-cream/50 mt-0.5">Live naturally</span>
        </span>
      </span>
      <p class="text-sm text-cream/60 mt-3 max-w-xs leading-relaxed">Natural products for a healthier lifestyle and a sustainable planet. Thank you for choosing better.</p>
      <div class="flex items-center gap-2 mt-4">
        @if(!empty($ntSocial))
          @foreach($ntSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-white/10 hover:bg-terracotta inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        @else
          @foreach(['facebook','instagram','pinterest','youtube'] as $platform)
            <span class="w-9 h-9 rounded-full bg-white/10 inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </span>
          @endforeach
        @endif
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Shop</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Bestsellers</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Customer Care</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Your Order</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Shipping Info</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">About Us</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Our Story</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Sustainability</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 pb-8">
    <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Payment Methods</h6>
    <div class="flex flex-wrap gap-2">
      @foreach(['VISA','Mastercard','Amex','PayPal','GPay','ShopPay'] as $method)
        <span class="bg-white rounded-md px-3 py-1.5 text-leaf-deep text-[10px] font-bold">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-cream/45">
    <span>© {{ date('Y') }} NATURIA. All rights reserved.</span>
    <span>Live naturally, since day one.</span>
  </div>
</footer>
