@php
  $fcSocial = $s->social_links ?? [];
  if (is_string($fcSocial)) { $d = json_decode($fcSocial, true); if (json_last_error() === JSON_ERROR_NONE) $fcSocial = $d; }
  if (!is_array($fcSocial)) { $fcSocial = []; }
  $fcIsAssoc = !empty($fcSocial) && array_keys($fcSocial) !== range(0, count($fcSocial) - 1);
  if ($fcIsAssoc) { $fcSocial = collect($fcSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-brand-greenDeep text-brand-cream/80">
  <div class="max-w-7xl mx-auto px-4 py-6 border-b border-white/10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/><circle cx="5.5" cy="18.5" r="1.5"/><circle cx="18.5" cy="18.5" r="1.5"/></svg>
        <span class="text-xs font-semibold">Free Delivery Daily</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
        <span class="text-xs font-semibold">Secure Payments</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
        <span class="text-xs font-semibold">Easy Returns</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <span class="text-xs font-semibold">24/7 Support</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-black text-xl text-white flex items-center gap-1.5">
        <svg class="w-6 h-6 text-brand-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h2l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>
        {{ $s->store_name ?? 'FreshCart' }}
      </span>
      <p class="text-sm text-brand-cream/60 mt-3 max-w-xs">{{ $s->footer_text ?? 'Fresh picks, delivered daily. Electronics, fashion, home, beauty, grocery and sports — one warm, friendly marketplace with fast delivery and honest prices.' }}</p>
      @if(!empty($fcSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($fcSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-brand-orange inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-cream/50 mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Today's Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-cream/50 mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-cream/50 mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-brand-cream/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'FreshCart' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
