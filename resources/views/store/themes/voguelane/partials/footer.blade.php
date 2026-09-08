@php
  $vlSocial = $s->social_links ?? [];
  if (is_string($vlSocial)) { $d = json_decode($vlSocial, true); if (json_last_error() === JSON_ERROR_NONE) $vlSocial = $d; }
  if (!is_array($vlSocial)) { $vlSocial = []; }
  $vlIsAssoc = !empty($vlSocial) && array_keys($vlSocial) !== range(0, count($vlSocial) - 1);
  if ($vlIsAssoc) { $vlSocial = collect($vlSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-20 bg-black text-white">
  <div class="px-4 lg:px-8 py-6 border-b border-white/10 grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
    <div class="flex flex-col md:flex-row items-center gap-2">
      <svg class="w-6 h-6 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
      <span class="text-xs font-bold uppercase tracking-wide">Secure Checkout</span>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-2">
      <svg class="w-6 h-6 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
      <span class="text-xs font-bold uppercase tracking-wide">Fast Shipping</span>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-2">
      <svg class="w-6 h-6 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
      <span class="text-xs font-bold uppercase tracking-wide">Easy Returns</span>
    </div>
    <div class="flex flex-col md:flex-row items-center gap-2">
      <svg class="w-6 h-6 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
      <span class="text-xs font-bold uppercase tracking-wide">Buyer Protection</span>
    </div>
  </div>

  <div class="px-4 lg:px-8 py-14 grid grid-cols-2 lg:grid-cols-12 gap-8">
    <div class="col-span-2 lg:col-span-5">
      <span class="font-display text-5xl leading-none">{{ $s->store_name ?? 'VOGUELANE' }}</span>
      <p class="text-sm text-white/50 mt-4 max-w-xs">{{ $s->footer_text ?? 'Style has no single lane — electronics, fashion, home, beauty, grocery and sports, curated with a bold point of view and shipped fast.' }}</p>
      @if(!empty($vlSocial))
        <div class="flex items-center gap-2 mt-5">
          @foreach($vlSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full border border-white/20 hover:border-brand-magenta hover:text-brand-magenta inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div class="lg:col-span-2 lg:col-start-7">
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-3">Shop</h6>
      <ul class="space-y-2 text-sm text-white/60">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div class="lg:col-span-2">
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-3">Categories</h6>
      <ul class="space-y-2 text-sm text-white/60">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div class="lg:col-span-2">
      <h6 class="text-xs font-bold uppercase tracking-widest text-brand-magenta mb-3">Support</h6>
      <ul class="space-y-2 text-sm text-white/60">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="px-4 lg:px-8 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/40">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'VOGUELANE' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
