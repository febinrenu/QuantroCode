@php
  $fxSocial = $s->social_links ?? [];
  if (is_string($fxSocial)) { $d = json_decode($fxSocial, true); if (json_last_error() === JSON_ERROR_NONE) $fxSocial = $d; }
  if (!is_array($fxSocial)) { $fxSocial = []; }
  $fxIsAssoc = !empty($fxSocial) && array_keys($fxSocial) !== range(0, count($fxSocial) - 1);
  if ($fxIsAssoc) { $fxSocial = collect($fxSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-[#05070F] text-fx-mute border-t border-fx-border">
  <div class="max-w-7xl mx-auto px-4 py-6 border-b border-fx-border/60">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
        <span class="text-xs font-semibold text-fx-ink">Secure Checkout</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
        <span class="text-xs font-semibold text-fx-ink">Fast Shipping</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
        <span class="text-xs font-semibold text-fx-ink">Easy Returns</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <svg class="w-6 h-6 text-fx-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
        <span class="text-xs font-semibold text-fx-ink">Buyer Protection</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-heading font-bold text-xl fx-grad-text">{{ $s->store_name ?? 'FutureX' }}</span>
      <p class="text-sm text-fx-mute mt-3 max-w-xs">{{ $s->footer_text ?? 'The store from tomorrow — electronics, fashion, home, beauty, grocery and more, curated for the future and shipped today.' }}</p>
      @if(!empty($fxSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($fxSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-fx-panel hover:bg-fx-violet/30 border border-fx-border inline-flex items-center justify-center">
              <svg class="w-4 h-4 text-fx-ink" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-fx-mute mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-fx-cyan">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-fx-cyan">Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-fx-cyan">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-fx-mute mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-fx-cyan">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-fx-mute mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-fx-cyan">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-fx-cyan">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-fx-border/60 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-fx-mute">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'FutureX' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
