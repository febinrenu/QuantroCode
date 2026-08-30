@php
  $ntSocial = $s->social_links ?? [];
  if (is_string($ntSocial)) { $d = json_decode($ntSocial, true); if (json_last_error() === JSON_ERROR_NONE) $ntSocial = $d; }
  if (!is_array($ntSocial)) { $ntSocial = []; }
  $ntIsAssoc = !empty($ntSocial) && array_keys($ntSocial) !== range(0, count($ntSocial) - 1);
  if ($ntIsAssoc) { $ntSocial = collect($ntSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-nova-bgDeep text-slate-400 border-t border-white/10">
  <div class="max-w-7xl mx-auto px-4 py-6 border-b border-white/5">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
        <span class="text-xs font-semibold text-slate-300">Secure Checkout</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
        <span class="text-xs font-semibold text-slate-300">Fast Shipping</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
        <span class="text-xs font-semibold text-slate-300">Easy Returns</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
        <span class="text-xs font-semibold text-slate-300">Buyer Protection</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-black text-xl text-white">{{ $s->store_name ?? 'NovaTech' }}<span class="text-nova-violet">.</span></span>
      <p class="text-sm text-slate-500 mt-3 max-w-xs">{{ $s->footer_text ?? 'Tomorrow\'s essentials, today — electronics, fashion, home, beauty, grocery and sports, curated in one premium destination and shipped fast with full buyer protection.' }}</p>
      @if(!empty($ntSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($ntSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full nt-glass hover:bg-nova-violet inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'NovaTech' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
