@php
  $urSocial = $s->social_links ?? [];
  if (is_string($urSocial)) { $d = json_decode($urSocial, true); if (json_last_error() === JSON_ERROR_NONE) $urSocial = $d; }
  if (!is_array($urSocial)) { $urSocial = []; }
  $urIsAssoc = !empty($urSocial) && array_keys($urSocial) !== range(0, count($urSocial) - 1);
  if ($urIsAssoc) { $urSocial = collect($urSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-brand-blue text-white relative overflow-hidden">
  <svg class="absolute -top-10 -left-10 w-64 h-64 opacity-10" viewBox="0 0 200 200"><path fill="#fff" d="M45.3,-58.6C58.9,-49.5,70.3,-35.7,74.7,-19.9C79.1,-4.1,76.5,13.7,68.6,28.5C60.7,43.3,47.5,55.1,32.5,62.1C17.5,69.1,0.7,71.3,-16.4,69.1C-33.5,66.9,-51,60.3,-62.1,47.7C-73.2,35.1,-77.9,16.5,-76.4,-1.2C-74.9,-18.9,-67.2,-35.7,-55,-45.6C-42.8,-55.5,-26.1,-58.5,-9.5,-59.9C7.1,-61.3,31.7,-67.7,45.3,-58.6Z" transform="translate(100 100)"/></svg>
  <div class="max-w-7xl mx-auto px-4 py-8 border-b border-white/15 relative">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg></span>
        <span class="text-xs font-semibold">Cozy checkout, zero stress</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg></span>
        <span class="text-xs font-semibold">Fast, friendly delivery</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg></span>
        <span class="text-xs font-semibold">No-fuss returns</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center shrink-0"><svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg></span>
        <span class="text-xs font-semibold">Buyer protection always</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8 relative">
    <div class="col-span-2">
      <span class="font-heading font-bold text-2xl text-white">{{ $s->store_name ?? 'Urbana' }}</span>
      <p class="text-sm text-white/80 mt-3 max-w-xs">{{ $s->footer_text ?? 'Shopping that feels like home — electronics, fashion, home goods, beauty, grocery and sports, all picked with care and delivered with a smile.' }}</p>
      @if(!empty($urSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($urSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-white/15 hover:bg-brand-coral transition-colors inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-brand-coralLight">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-brand-coralLight">Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-brand-coralLight">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-brand-coralLight">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-white/60 mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-brand-coralLight">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-brand-coralLight">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/15 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/70 relative">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'Urbana' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
