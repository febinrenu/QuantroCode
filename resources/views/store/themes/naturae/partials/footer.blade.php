@php
  $ntSocial = $s->social_links ?? [];
  if (is_string($ntSocial)) { $d = json_decode($ntSocial, true); if (json_last_error() === JSON_ERROR_NONE) $ntSocial = $d; }
  if (!is_array($ntSocial)) { $ntSocial = []; }
  $ntIsAssoc = !empty($ntSocial) && array_keys($ntSocial) !== range(0, count($ntSocial) - 1);
  if ($ntIsAssoc) { $ntSocial = collect($ntSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-leaf-deep text-cream/85">
  <div class="max-w-7xl mx-auto px-4 py-7 border-b border-white/10">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2.5">
        <svg class="w-7 h-7 text-terracotta-light shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
        <span class="text-xs font-semibold">Sustainably sourced</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2.5">
        <svg class="w-7 h-7 text-terracotta-light shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 10c3-4 7-6 8-6s5 2 8 6c-1 5-5 9-8 10-3-1-7-5-8-10Z"/><path stroke-linecap="round" d="M12 8v8"/></svg>
        <span class="text-xs font-semibold">Plastic-free packaging</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2.5">
        <svg class="w-7 h-7 text-terracotta-light shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12c1-4 5-7 9-7s8 3 9 7M3 12c1 4 5 7 9 7s8-3 9-7"/><path stroke-linecap="round" d="M9 12h6"/></svg>
        <span class="text-xs font-semibold">Carbon-neutral shipping</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2.5">
        <svg class="w-7 h-7 text-terracotta-light shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 3v4M4 5h4M18 3v4M16 5h4M12 8v13M6 13c0 4 3 6 6 8 3-2 6-4 6-8"/></svg>
        <span class="text-xs font-semibold">Ethical partners, always</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-11 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="inline-flex items-center gap-2 font-serif font-semibold text-xl text-white">
        <svg class="w-6 h-6 text-terracotta-light" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/></svg>
        {{ $s->store_name ?? 'Naturae' }}
      </span>
      <p class="text-sm text-cream/60 mt-3 max-w-xs leading-relaxed">{{ $s->footer_text ?? 'Good for you, good for the planet. A general store for electronics, fashion, home, beauty, grocery and sports — chosen with care, packed without waste, and shipped with a lighter footprint.' }}</p>
      @if(!empty($ntSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($ntSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 rounded-full bg-white/10 hover:bg-terracotta inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Shop</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Everyday Value</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Categories</h6>
      <ul class="space-y-2.5 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-cream/40 mb-3">Support</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-cream/45">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'Naturae' }}. All rights reserved.</span>
    <span>Rooted in honest sourcing, since day one.</span>
  </div>
</footer>
