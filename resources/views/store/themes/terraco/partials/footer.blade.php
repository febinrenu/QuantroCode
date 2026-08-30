@php
  $trSocial = $s->social_links ?? [];
  if (is_string($trSocial)) { $d = json_decode($trSocial, true); if (json_last_error() === JSON_ERROR_NONE) $trSocial = $d; }
  if (!is_array($trSocial)) { $trSocial = []; }
  $trIsAssoc = !empty($trSocial) && array_keys($trSocial) !== range(0, count($trSocial) - 1);
  if ($trIsAssoc) { $trSocial = collect($trSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-24 border-t border-terra-line bg-terra-bg">
  <div class="max-w-6xl mx-auto px-6 py-16 grid grid-cols-2 md:grid-cols-5 gap-10">
    <div class="col-span-2">
      <span class="font-heading font-light text-2xl text-terra-ink">{{ $s->store_name ?? 'Terraco' }}</span>
      <p class="text-sm text-terra-inkSoft mt-4 max-w-xs leading-relaxed">{{ $s->footer_text ?? 'Less noise, better choices — a considered selection across electronics, fashion, home and beauty.' }}</p>
      @if(!empty($trSocial))
        <div class="flex items-center gap-3 mt-5">
          @foreach($trSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 border border-terra-line hover:border-terra-slate inline-flex items-center justify-center">
              <svg class="w-3.5 h-3.5 text-terra-inkSoft" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    <div>
      <h6 class="text-xs eyebrow text-terra-inkSoft mb-4">Shop</h6>
      <ul class="space-y-2.5 text-sm text-terra-inkSoft">
        <li><a href="{{ route('store.shop') }}" class="hover:text-terra-ink">All Products</a></li>
        <li><a href="{{ route('store.cart') }}" class="hover:text-terra-ink">Cart</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs eyebrow text-terra-inkSoft mb-4">Categories</h6>
      <ul class="space-y-2.5 text-sm text-terra-inkSoft">
        @foreach(($categories ?? collect())->take(4) as $cat)
          <li><a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="hover:text-terra-ink">{{ $cat->name }}</a></li>
        @endforeach
      </ul>
    </div>
    <div>
      <h6 class="text-xs eyebrow text-terra-inkSoft mb-4">Support</h6>
      <ul class="space-y-2.5 text-sm text-terra-inkSoft">
        <li><a href="{{ route('store.contact') }}" class="hover:text-terra-ink">Contact Us</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-terra-ink">Track Order</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-6xl mx-auto px-6 py-6 border-t border-terra-line flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-terra-inkSoft">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'Terraco' }}. All rights reserved.</span>
    <span>Less noise. Better choices.</span>
  </div>
</footer>
