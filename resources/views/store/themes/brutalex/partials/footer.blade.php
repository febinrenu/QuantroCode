@php
  $bxSocial = $s->social_links ?? [];
  if (is_string($bxSocial)) { $d = json_decode($bxSocial, true); if (json_last_error() === JSON_ERROR_NONE) $bxSocial = $d; }
  if (!is_array($bxSocial)) { $bxSocial = []; }
  $bxIsAssoc = !empty($bxSocial) && array_keys($bxSocial) !== range(0, count($bxSocial) - 1);
  if ($bxIsAssoc) { $bxSocial = collect($bxSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-ink-black text-white border-t-4 border-ink-black">
  <div class="max-w-7xl mx-auto px-4 border-b-4 border-white/20">
    <div class="grid grid-cols-2 md:grid-cols-4 divide-x-0 md:divide-x-4 divide-white/20">
      @foreach([
        ['label' => 'NO-BS CHECKOUT', 'path' => 'M20 6 9 17l-5-5'],
        ['label' => 'FAST DISPATCH', 'path' => 'M3 3h15v13H3zM16 8h4l2 4v4h-6z'],
        ['label' => 'RETURNS, EASY', 'path' => 'M21 12a9 9 0 1 1-6-8.485M21 3v6h-6'],
        ['label' => 'BUYER PROTECTED', 'path' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z'],
      ] as $item)
        <div class="flex flex-col items-center gap-2 py-6 text-center border-t-4 md:border-t-0 border-white/20">
          <svg class="w-6 h-6 text-ink-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="{{ $item['path'] }}"/></svg>
          <span class="text-[11px] font-bold uppercase tracking-widest">{{ $item['label'] }}</span>
        </div>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="bx-head text-2xl text-white">{{ $s->store_name ?? 'BRUTALEX' }}</span>
      <p class="text-sm text-white/60 mt-3 max-w-xs bx-copy">{{ $s->footer_text ?? 'No fluff. Just the goods. Electronics, fashion, home, beauty, grocery and sports — stocked raw, priced honest, shipped fast.' }}</p>
      @if(!empty($bxSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($bxSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-9 h-9 border-2 border-white/30 hover:border-ink-red hover:bg-ink-red inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-ink-red mb-3">Shop</h6>
      <ul class="space-y-2 text-sm font-mono">
        <li><a href="{{ route('store.shop') }}" class="hover:text-ink-red">All Products</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-ink-red">Cheap Stuff</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-ink-red">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-ink-red mb-3">Categories</h6>
      <ul class="space-y-2 text-sm font-mono">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-ink-red">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-widest text-ink-red mb-3">Support</h6>
      <ul class="space-y-2 text-sm font-mono">
        <li><a href="{{ route('store.contact') }}" class="hover:text-ink-red">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-ink-red">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t-4 border-white/20 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs font-mono text-white/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'BRUTALEX' }}. ALL RIGHTS RESERVED.</span>
    <span>SECURE PAYMENTS · ENCRYPTED CHECKOUT</span>
  </div>
</footer>
