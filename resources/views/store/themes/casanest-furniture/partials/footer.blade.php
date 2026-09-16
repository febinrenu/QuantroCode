@php
  $cnSocial = $s->social_links ?? [];
  if (is_string($cnSocial)) { $d = json_decode($cnSocial, true); if (json_last_error() === JSON_ERROR_NONE) $cnSocial = $d; }
  if (!is_array($cnSocial)) { $cnSocial = []; }
  $cnIsAssoc = !empty($cnSocial) && array_keys($cnSocial) !== range(0, count($cnSocial) - 1);
  if ($cnIsAssoc) { $cnSocial = collect($cnSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-cn-oliveDeep text-white/80">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="block font-serif font-bold text-xl text-white">{{ $s->store_name ?? 'CasaNest' }}</span>
      <p class="text-sm text-white/60 mt-3 max-w-xs">{{ $s->footer_text ?? '2024 CasaNest. All rights reserved.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($cnSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-cn-tan inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['instagram','pinterest','facebook','youtube'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-cn-tan inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'Shop' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-white">{{ 'New Arrivals' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Living Room' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Bedroom' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Dining Room' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'About CasaNest' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Craftsmanship' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Design Journal' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'White-Glove Delivery' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/50">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'CasaNest' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-white">{{ 'Terms of Service' }}</a>
    </span>
  </div>
</footer>
