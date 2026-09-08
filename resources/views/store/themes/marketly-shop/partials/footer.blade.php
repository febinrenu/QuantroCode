@php
  $mktSocial = $s->social_links ?? [];
  if (is_string($mktSocial)) { $d = json_decode($mktSocial, true); if (json_last_error() === JSON_ERROR_NONE) $mktSocial = $d; }
  if (!is_array($mktSocial)) { $mktSocial = []; }
  $mktIsAssoc = !empty($mktSocial) && array_keys($mktSocial) !== range(0, count($mktSocial) - 1);
  if ($mktIsAssoc) { $mktSocial = collect($mktSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-mkt-purpleDeep text-white/70">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-6 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2.5">
        <span class="w-9 h-9 rounded-lg bg-mkt-purple text-white inline-flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18 M16 10a4 4 0 0 1-8 0"/></svg>
        </span>
        <span class="leading-tight">
          <span class="block font-heading font-bold text-lg text-white">{{ $s->store_name ?? 'Marketly' }}</span>
          <span class="block text-[11px] text-white/50">{{ 'Everything you need.' }}</span>
        </span>
      </span>
      <p class="text-sm text-white/50 mt-3 max-w-xs">{{ $s->footer_text ?? 'Your one-stop destination for quality products across all categories at the best prices.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($mktSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mkt-gold hover:text-mkt-purpleDeep inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','twitter','youtube','pinterest'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mkt-gold hover:text-mkt-purpleDeep inline-flex items-center justify-center">
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
        <li><a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="hover:text-white">{{ 'Best Sellers' }}</a></li>
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">{{ 'Deals' }}</a></li>
        <li><a href="{{ route('store.shop') }}" class="hover:text-white">{{ 'Gift Cards' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Customer Service' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Contact Us' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Company' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'About Us' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Blog' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Press' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Affiliates' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'My Account' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account') }}" class="hover:text-white">{{ 'My Orders' }}</a></li>
        <li><a href="{{ url('/online_store/account/wishlist') }}" class="hover:text-white">{{ 'Wishlist' }}</a></li>
        <li><a href="{{ url('/online_store/account') }}" class="hover:text-white">{{ 'Account Details' }}</a></li>
        <li><a href="{{ url('/online_store/account') }}" class="hover:text-white">{{ 'Addresses' }}</a></li>
        <li><a href="{{ url('/online_store/login') }}" class="hover:text-white">{{ 'Logout' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 border-t border-white/10">
    <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'We Accept' }}</h6>
    <div class="flex flex-wrap items-center gap-2">
      @foreach(['VISA','Mastercard','PayPal','Apple Pay','G Pay'] as $method)
        <span class="h-8 px-3 inline-flex items-center rounded bg-white/10 text-[11px] font-bold text-white">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/40">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'Marketly' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-white">{{ 'Terms & Conditions' }}</a>
      <a href="#" class="hover:text-white">{{ 'Sitemap' }}</a>
    </span>
  </div>
</footer>
