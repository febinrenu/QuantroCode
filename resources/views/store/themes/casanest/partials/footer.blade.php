@php
  $cnSocial = $s->social_links ?? [];
  if (is_string($cnSocial)) { $d = json_decode($cnSocial, true); if (json_last_error() === JSON_ERROR_NONE) $cnSocial = $d; }
  if (!is_array($cnSocial)) { $cnSocial = []; }
  $cnIsAssoc = !empty($cnSocial) && array_keys($cnSocial) !== range(0, count($cnSocial) - 1);
  if ($cnIsAssoc) { $cnSocial = collect($cnSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-cn-emeraldDark text-cn-goldLight">
  {{-- sunburst divider --}}
  <div class="flex justify-center pt-10 pb-2">
    <svg width="90" height="46" viewBox="0 0 90 46" fill="none">
      <g stroke="#C9A15B" stroke-width="1">
        <path d="M45 46 L45 6"/><path d="M45 46 L20 10"/><path d="M45 46 L70 10"/>
        <path d="M45 46 L5 22"/><path d="M45 46 L85 22"/>
        <path d="M45 46 L32 8"/><path d="M45 46 L58 8"/>
      </g>
      <circle cx="45" cy="46" r="4" fill="#C9A15B"/>
    </svg>
  </div>

  <div class="max-w-7xl mx-auto px-4 pb-6 text-center">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
      <div class="flex flex-col items-center gap-2">
        <svg class="w-6 h-6 text-cn-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 6 9 17l-5-5"/></svg>
        <span class="text-[11px] eyebrow">Secure Checkout</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <svg class="w-6 h-6 text-cn-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 3h15v13H3zM16 8h4l2 4v4h-6z"/><circle cx="7.5" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
        <span class="text-[11px] eyebrow">Curated Shipping</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <svg class="w-6 h-6 text-cn-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
        <span class="text-[11px] eyebrow">Effortless Returns</span>
      </div>
      <div class="flex flex-col items-center gap-2">
        <svg class="w-6 h-6 text-cn-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
        <span class="text-[11px] eyebrow">Buyer Protection</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left">
    <div class="col-span-2 md:col-span-1 text-center">
      <span class="font-display text-2xl font-semibold text-white">{{ $s->store_name ?? 'Casanest' }}</span>
      <p class="text-sm text-cn-goldLight/80 mt-3 max-w-xs mx-auto">{{ $s->footer_text ?? 'A thoughtfully chosen selection spanning electronics, fashion, home, beauty, grocery and sports — each piece considered before it earns a place in our catalogue.' }}</p>
      @if(!empty($cnSocial))
        <div class="flex items-center justify-center gap-2 mt-4">
          @foreach($cnSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 border border-cn-gold/40 hover:bg-cn-gold hover:text-cn-emeraldDark inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-[11px] eyebrow font-bold text-cn-gold mb-3">Shop</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">Curated Deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-white">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-[11px] eyebrow font-bold text-cn-gold mb-3">Categories</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-white">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-[11px] eyebrow font-bold text-cn-gold mb-3">Support</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-cn-gold/20 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-cn-goldLight/70">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'Casanest' }}. All rights reserved.</span>
    <span>Secure payments · Encrypted checkout</span>
  </div>
</footer>
