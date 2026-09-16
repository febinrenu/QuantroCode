@php
  $fxSocial = $s->social_links ?? [];
  if (is_string($fxSocial)) { $d = json_decode($fxSocial, true); if (json_last_error() === JSON_ERROR_NONE) $fxSocial = $d; }
  if (!is_array($fxSocial)) { $fxSocial = []; }
  $fxIsAssoc = !empty($fxSocial) && array_keys($fxSocial) !== range(0, count($fxSocial) - 1);
  if ($fxIsAssoc) { $fxSocial = collect($fxSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-fx-black text-white/70">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2.5">
        <span class="w-9 h-9 rounded-lg bg-fx-badge text-white inline-flex items-center justify-center shrink-0 font-heading font-extrabold">X</span>
        <span class="leading-tight">
          <span class="block font-heading font-extrabold text-lg text-white uppercase">{{ $s->store_name ?? 'FutureX' }}</span>
          <span class="block text-[10px] eyebrow text-white/40">{{ 'Tech Store' }}</span>
        </span>
      </span>
      <p class="text-sm text-white/50 mt-3 max-w-xs">{{ $s->footer_text ?? 'Your one-stop destination for the latest tech. Quality products, trusted by millions.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($fxSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-fx-purple inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','twitter','youtube','tiktok'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-fx-purple inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Shop' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'All Categories' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-white">{{ 'New Arrivals' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">{{ 'Top Deals' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-white">{{ 'Best Sellers' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Brands' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Gift Cards' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Contact Us' }}</a></li>
        <li><a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'About Us' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Blog' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Sustainability' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Press' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Payment Methods' }}</h6>
      <div class="flex flex-wrap items-center gap-2">
        @foreach(['VISA','Mastercard','AMEX','PayPal','Apple Pay','G Pay','Shop Pay'] as $method)
          <span class="h-8 px-3 inline-flex items-center rounded bg-white/10 text-[11px] font-bold text-white">{{ $method }}</span>
        @endforeach
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/40">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'FutureX' }} {{ 'Tech Store' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Terms & Conditions' }}</a>
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
    </span>
  </div>
</footer>
