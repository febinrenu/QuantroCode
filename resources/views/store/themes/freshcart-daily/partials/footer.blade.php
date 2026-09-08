@php
  $fcSocial = $s->social_links ?? [];
  if (is_string($fcSocial)) { $d = json_decode($fcSocial, true); if (json_last_error() === JSON_ERROR_NONE) $fcSocial = $d; }
  if (!is_array($fcSocial)) { $fcSocial = []; }
  $fcIsAssoc = !empty($fcSocial) && array_keys($fcSocial) !== range(0, count($fcSocial) - 1);
  if ($fcIsAssoc) { $fcSocial = collect($fcSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-fc-greenDeep text-white/80">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2">
        <svg class="w-8 h-8 text-fc-orangeSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z"/><path d="M12 8v8"/></svg>
        <span class="leading-tight">
          <span class="block font-heading font-extrabold text-lg text-white">FreshCart Market</span>
        </span>
      </span>
      <p class="text-sm text-white/60 mt-3 max-w-xs">{{ $s->footer_text ?? 'Delivering freshness and happiness to your doorstep every day.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($fcSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-fc-orange inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','youtube','pinterest'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-fc-orange inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-white/50 mb-3">{{ 'Customer Support' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Help Center' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Refunds' }}</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Order Tracking' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-white/50 mb-3">{{ 'Shop by Department' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Fruits & Vegetables' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Dairy & Eggs' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Bakery' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Meat & Seafood' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-white/50 mb-3">{{ 'About FreshCart' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Delivery Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'About Us' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Sustainability' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/50">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'FreshCart Market' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-white">{{ 'Terms & Conditions' }}</a>
    </span>
  </div>
</footer>
