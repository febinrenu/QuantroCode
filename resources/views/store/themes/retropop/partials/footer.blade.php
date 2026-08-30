@php
  $rpSocial = $s->social_links ?? [];
  if (is_string($rpSocial)) { $d = json_decode($rpSocial, true); if (json_last_error() === JSON_ERROR_NONE) $rpSocial = $d; }
  if (!is_array($rpSocial)) { $rpSocial = []; }
  $rpIsAssoc = !empty($rpSocial) && array_keys($rpSocial) !== range(0, count($rpSocial) - 1);
  if ($rpIsAssoc) { $rpSocial = collect($rpSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-0 bg-pop-ink text-pop-cream/80 relative overflow-hidden">
  <svg class="w-full h-8 lg:h-12 block" viewBox="0 0 1200 60" preserveAspectRatio="none" style="transform:translateY(1px)">
    <path d="M0,30 C150,60 350,0 600,30 C850,60 1050,0 1200,30 L1200,0 L0,0 Z" fill="#FFF8EC"/>
  </svg>

  <div class="max-w-7xl mx-auto px-4 pb-6 border-b border-white/10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-pop-mustard/20 text-pop-mustard flex items-center justify-center shrink-0"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></span>
        <span class="text-xs font-bold">Secure Checkout</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-pop-mustard/20 text-pop-mustard flex items-center justify-center shrink-0"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg></span>
        <span class="text-xs font-bold">Fast Shipping</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-pop-mustard/20 text-pop-mustard flex items-center justify-center shrink-0"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg></span>
        <span class="text-xs font-bold">Easy Returns</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-pop-mustard/20 text-pop-mustard flex items-center justify-center shrink-0"><svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg></span>
        <span class="text-xs font-bold">Buyer Protection</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-heading font-extrabold text-2xl text-white">{{ $s->store_name ?? 'Retropop' }}</span>
      <p class="text-sm text-pop-cream/60 mt-3 max-w-xs">{{ $s->footer_text ?? 'Shop like it\'s the best decade ever — electronics, fashion, home, beauty, grocery and sports, all in one groovy place with fast shipping and buyer protection on every order.' }}</p>
      @if(!empty($rpSocial))
        <div class="flex items-center gap-2 mt-5">
          @foreach($rpSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-white/10 hover:bg-pop-orange inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-pop-mustard mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-pop-mustard mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-pop-mustard mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-pop-cream/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'Retropop' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
