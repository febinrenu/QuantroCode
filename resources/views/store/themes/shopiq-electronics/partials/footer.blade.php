@php
  $iqSocial = $s->social_links ?? [];
  if (is_string($iqSocial)) { $d = json_decode($iqSocial, true); if (json_last_error() === JSON_ERROR_NONE) $iqSocial = $d; }
  if (!is_array($iqSocial)) { $iqSocial = []; }
  $iqIsAssoc = !empty($iqSocial) && array_keys($iqSocial) !== range(0, count($iqSocial) - 1);
  if ($iqIsAssoc) { $iqSocial = collect($iqSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="bg-iq-navy text-white/75 mt-0">
  <div class="max-w-[1400px] mx-auto px-5 py-12 grid grid-cols-2 md:grid-cols-6 gap-8 text-[13px]">
    <div class="col-span-2">
      <span class="font-display font-bold text-xl text-white">{{ strtoupper($s->store_name ?? 'ShopIQ') }}<span class="text-iq-gold">.</span></span>
      <div class="text-white/50 text-xs mt-1">Shop Smart. Live Better.</div>
      <p class="text-white/60 leading-5 mt-4">{{ $s->footer_text ?? 'Your one-stop shop for the latest tech and top brands. Quality products, best prices, and great service.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @foreach($iqSocial ?: [1,2,3,4] as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-iq-purple inline-flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @endforeach
      </div>
    </div>
    @foreach([
      ['SHOP','All Categories','New Arrivals','Best Sellers','Deals','Gift Cards'],
      ['CUSTOMER SERVICE','Track Order','Returns & Exchanges','Shipping Info','FAQs','Contact Us'],
      ['ABOUT US','Our Story','Careers','Blog','Press','Sustainability'],
      ['MY ACCOUNT','My Account','Wishlist','Order History','Addresses','Rewards'],
    ] as $column)
      <div>
        <b class="text-white text-xs tracking-wide">{{ $column[0] }}</b>
        @foreach(array_slice($column,1) as $link)
          <a href="{{ $link === 'Contact Us' ? route('store.contact') : route('store.shop') }}" class="block text-white/60 mt-3 hover:text-white transition-colors">{{ $link }}</a>
        @endforeach
      </div>
    @endforeach
  </div>
  <div class="max-w-[1400px] mx-auto px-5 pb-8">
    <b class="text-white text-xs tracking-wide">WE ACCEPT</b>
    <div class="flex flex-wrap gap-2 mt-3">
      @foreach(['VISA','Mastercard','Amex','PayPal','Apple Pay','G Pay'] as $method)
        <span class="bg-white rounded-md px-2.5 py-1.5 text-iq-navy text-[10px] font-bold">{{ $method }}</span>
      @endforeach
    </div>
  </div>
  <div class="max-w-[1400px] mx-auto px-5 py-5 border-t border-white/10 flex flex-wrap gap-3 justify-between items-center text-[11px] text-white/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'ShopIQ' }}. All Rights Reserved.</span>
    <span class="flex items-center gap-4">
      <a href="{{ route('store.contact') }}" class="hover:text-white">Privacy Policy</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Terms & Conditions</a>
    </span>
  </div>
</footer>
