@php
  $ntSocial = $s->social_links ?? [];
  if (is_string($ntSocial)) { $d = json_decode($ntSocial, true); if (json_last_error() === JSON_ERROR_NONE) $ntSocial = $d; }
  if (!is_array($ntSocial)) { $ntSocial = []; }
  $ntIsAssoc = !empty($ntSocial) && array_keys($ntSocial) !== range(0, count($ntSocial) - 1);
  if ($ntIsAssoc) { $ntSocial = collect($ntSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-nt-creamDark border-t border-nt-green/10">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2">
        <span class="w-9 h-9 rounded-full border-2 border-nt-green flex items-center justify-center shrink-0">
          <svg class="w-4 h-4 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z"/><path d="M12 8v8"/></svg>
        </span>
        <span class="leading-tight">
          <span class="block font-serif font-bold text-lg tracking-wide text-nt-ink">{{ strtoupper($s->store_name ?? 'Naturia') }}</span>
          <span class="block eyebrow text-[9px] text-nt-inkSoft">{{ 'Live Naturally' }}</span>
        </span>
      </span>
      <p class="text-sm text-nt-inkSoft mt-3 max-w-xs">{{ $s->footer_text ?? 'Natural products for a healthier lifestyle and a sustainable planet. Thank you for choosing better.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($ntSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white hover:bg-nt-green hover:text-white inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','pinterest','youtube','tiktok'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white hover:bg-nt-green hover:text-white inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-nt-inkSoft mb-3">{{ 'Shop' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-nt-green">{{ 'All Products' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-nt-green">{{ 'New Arrivals' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-nt-green">{{ 'Best Sellers' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-nt-green">{{ 'Special Offers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Gift Cards' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-nt-inkSoft mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-nt-green">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Contact Us' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-nt-inkSoft mb-3">{{ 'About Us' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Sustainability' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Blog' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-nt-green">{{ 'Press' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 border-t border-nt-green/10">
    <h6 class="text-xs font-bold eyebrow text-nt-inkSoft mb-3">{{ 'Payment Methods' }}</h6>
    <div class="flex flex-wrap items-center gap-2">
      @foreach(['VISA','Mastercard','AMEX','PayPal','Apple Pay','G Pay','Shop Pay'] as $method)
        <span class="h-8 px-3 inline-flex items-center rounded bg-white text-[11px] font-bold text-nt-ink border border-nt-green/10">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-nt-green/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-nt-inkSoft">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'Naturia' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-nt-green">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-nt-green">{{ 'Terms & Conditions' }}</a>
    </span>
  </div>
</footer>
