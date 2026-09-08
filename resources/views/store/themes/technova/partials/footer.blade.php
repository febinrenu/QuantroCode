@php
  $tnSocial = $s->social_links ?? [];
  if (is_string($tnSocial)) { $d = json_decode($tnSocial, true); if (json_last_error() === JSON_ERROR_NONE) $tnSocial = $d; }
  if (!is_array($tnSocial)) { $tnSocial = []; }
  $tnIsAssoc = !empty($tnSocial) && array_keys($tnSocial) !== range(0, count($tnSocial) - 1);
  if ($tnIsAssoc) { $tnSocial = collect($tnSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-black border-t border-tn-border text-tn-mute">
  <div class="max-w-7xl mx-auto px-4 py-6 border-b border-tn-border">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="text-tn-green">[</span><span class="text-xs font-semibold text-tn-ink">encrypted_checkout</span><span class="text-tn-green">]</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="text-tn-green">[</span><span class="text-xs font-semibold text-tn-ink">fast_shipping</span><span class="text-tn-green">]</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="text-tn-green">[</span><span class="text-xs font-semibold text-tn-ink">easy_returns</span><span class="text-tn-green">]</span>
      </div>
      <div class="flex flex-col md:flex-row items-center gap-2">
        <span class="text-tn-green">[</span><span class="text-xs font-semibold text-tn-ink">buyer_protection</span><span class="text-tn-green">]</span>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-bold text-lg text-tn-green">&gt;{{ $s->store_name ?? 'technova' }}</span>
      <p class="text-sm text-tn-mute mt-3 max-w-xs">{{ $s->footer_text ?? '// A monospace marketplace compiling electronics, fashion, home, beauty, grocery and sports into a single checkout process.' }}</p>
      @if(!empty($tnSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($tnSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 border border-tn-border hover:border-tn-green hover:text-tn-green inline-flex items-center justify-center">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-tn-green mb-3">[shop]</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-tn-green">all_products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-tn-green">deals</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-tn-green">cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-tn-green mb-3">[categories]</h6>
      <ul class="space-y-2 text-sm">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-tn-green">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-tn-green mb-3">[support]</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-tn-green">contact_us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-tn-green">track_order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-tn-border flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-tn-mute">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'technova' }}. all rights reserved.</span>
    <span class="text-tn-green">process exited with code 0</span>
  </div>
</footer>
