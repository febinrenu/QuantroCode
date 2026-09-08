@php
  $vlSocial = $s->social_links ?? [];
  if (is_string($vlSocial)) { $d = json_decode($vlSocial, true); if (json_last_error() === JSON_ERROR_NONE) $vlSocial = $d; }
  if (!is_array($vlSocial)) { $vlSocial = []; }
  $vlIsAssoc = !empty($vlSocial) && array_keys($vlSocial) !== range(0, count($vlSocial) - 1);
  if ($vlIsAssoc) { $vlSocial = collect($vlSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-20 bg-vel-black text-vel-mute border-t border-vel-line">
  <div class="vl-rule"></div>
  <div class="max-w-7xl mx-auto px-4 py-8 border-b border-vel-line">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center sm:text-left">
      <div class="flex flex-col sm:flex-row items-center gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
        <div>
          <div class="text-xs font-semibold text-vel-ink eyebrow">White-Glove Service</div>
          <div class="text-[11px] text-vel-mute mt-0.5">A dedicated concierge for every order</div>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row items-center gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>
        <div>
          <div class="text-xs font-semibold text-vel-ink eyebrow">Insured Shipping</div>
          <div class="text-[11px] text-vel-mute mt-0.5">Every parcel fully covered, door to door</div>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row items-center gap-3">
        <svg class="w-6 h-6 text-vel-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
        <div>
          <div class="text-xs font-semibold text-vel-ink eyebrow">Lifetime Support</div>
          <div class="text-[11px] text-vel-mute mt-0.5">We stand behind what we sell, always</div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-serif font-bold text-2xl text-vel-ink">{{ $s->store_name ?? 'Veloura' }}</span>
      <p class="text-sm text-vel-mute mt-4 max-w-xs leading-relaxed">{{ $s->footer_text ?? 'A considered assortment across electronics, fashion, home and beauty — each piece selected for quality, then delivered with the care it deserves.' }}</p>
      @if(!empty($vlSocial))
        <div class="flex items-center gap-2 mt-5">
          @foreach($vlSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 border border-vel-line hover:border-vel-gold hover:text-vel-gold inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-vel-gold/80 mb-4">Shop</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-vel-gold">Full Collection</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-vel-gold">The Edit</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-vel-gold">Your Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-vel-gold/80 mb-4">Categories</h6>
      <ul class="space-y-2.5 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-vel-gold">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-vel-gold/80 mb-4">Client Care</h6>
      <ul class="space-y-2.5 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-vel-gold">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-vel-gold">Track an Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-vel-line flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-vel-mute eyebrow">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'Veloura' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
