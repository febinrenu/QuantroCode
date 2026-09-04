@php
  $tcSocial = $s->social_links ?? [];
  if (is_string($tcSocial)) { $d = json_decode($tcSocial, true); if (json_last_error() === JSON_ERROR_NONE) $tcSocial = $d; }
  if (!is_array($tcSocial)) { $tcSocial = []; }
  $tcIsAssoc = !empty($tcSocial) && array_keys($tcSocial) !== range(0, count($tcSocial) - 1);
  if ($tcIsAssoc) { $tcSocial = collect($tcSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-tc-greenDeep text-tc-cream/80">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2">
        <svg class="w-7 h-7 text-tc-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22c0-6 4-10 8-11-1 6-4 10-8 11Z"/><path d="M12 22c0-7-4-13-9-14 1 7 4 13 9 14Z"/></svg>
        <span class="leading-tight">
          <span class="block font-serif font-bold text-lg tracking-wide text-white">{{ strtoupper($s->store_name ?? 'Terra & Co.') }}</span>
          <span class="block eyebrow text-[9px] text-tc-cream/50">Fine Food Market</span>
        </span>
      </span>
      <p class="text-sm text-tc-cream/60 mt-3 max-w-xs">{{ $s->footer_text ?? 'Bringing you the world\'s finest ingredients and gourmet delights.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($tcSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-tc-gold inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','youtube','tiktok'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-tc-gold inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-tc-cream/50 mb-3">{{ __('messages.Shop') }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ __('messages.AllProducts') ?? 'All Products' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-white">{{ 'New Arrivals' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-white">{{ 'Best Sellers' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Gift Hampers' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-tc-cream/50 mb-3">{{ 'Customer Service' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-tc-cream/50 mb-3">{{ 'About Us' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Sustainability' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Recipes' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Store Locator' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 border-t border-white/10">
    <h6 class="text-xs font-bold eyebrow text-tc-cream/50 mb-3">{{ 'We Accept' }}</h6>
    <div class="flex flex-wrap items-center gap-2">
      @foreach(['VISA','Mastercard','AMEX','PayPal','Apple Pay','G Pay'] as $method)
        <span class="h-8 px-3 inline-flex items-center rounded bg-white/10 text-[11px] font-bold text-white">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-tc-cream/50">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'Terra & Co.' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-white">{{ 'Terms & Conditions' }}</a>
    </span>
  </div>
</footer>
