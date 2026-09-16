@php
  $ljSocial = $s->social_links ?? [];
  if (is_string($ljSocial)) { $d = json_decode($ljSocial, true); if (json_last_error() === JSON_ERROR_NONE) $ljSocial = $d; }
  if (!is_array($ljSocial)) { $ljSocial = []; }
  $ljIsAssoc = !empty($ljSocial) && array_keys($ljSocial) !== range(0, count($ljSocial) - 1);
  if ($ljIsAssoc) { $ljSocial = collect($ljSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-lj-purple text-white/80 rounded-t-[2.5rem]">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-heading font-extrabold text-xl uppercase lj-rainbow">
        @foreach(str_split($s->store_name ?? 'LittleJoy') as $ch)<span>{{ $ch }}</span>@endforeach
      </span>
      <span class="block text-[11px] text-white/60 mt-0.5">{{ 'for happy little ones' }}</span>
      <p class="text-sm text-white/60 mt-3 max-w-xs">{{ $s->footer_text ?? 'Your one-stop shop for everything your little one needs. Quality, safety and happiness, always.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($ljSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-lj-gold hover:text-lj-purpleDeep inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','pinterest','youtube','tiktok'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-lj-gold hover:text-lj-purpleDeep inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'Shop' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'All Categories' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-white">{{ 'New Arrivals' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-white">{{ 'Best Sellers' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">{{ 'Deals' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Gift Cards' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Contact Us' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'About Us' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Blog' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Privacy Policy' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Terms & Conditions' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 border-t border-white/10">
    <h6 class="text-xs font-bold eyebrow text-white/50 mb-3">{{ 'Payment Methods' }}</h6>
    <div class="flex flex-wrap items-center gap-2">
      @foreach(['VISA','Mastercard','AMEX','PayPal','Apple Pay','G Pay','Shop Pay'] as $method)
        <span class="h-8 px-3 inline-flex items-center rounded-lg bg-white/10 text-[11px] font-bold text-white">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/50">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'LittleJoy' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-1.5">
      <svg class="w-4 h-4 text-lj-pink" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-6.7-4.35-9.3-8.1C1 10.3 1.8 6.9 4.7 5.6 7 4.6 9.4 5.4 12 8c2.6-2.6 5-3.4 7.3-2.4 2.9 1.3 3.7 4.7 2 7.3C18.7 16.65 12 21 12 21Z"/></svg>
      {{ 'Designed with love for little ones and their families' }}
    </span>
  </div>
</footer>
