@php
  $hlSocial = $s->social_links ?? [];
  if (is_string($hlSocial)) { $d = json_decode($hlSocial, true); if (json_last_error() === JSON_ERROR_NONE) $hlSocial = $d; }
  if (!is_array($hlSocial)) { $hlSocial = []; }
  $hlIsAssoc = !empty($hlSocial) && array_keys($hlSocial) !== range(0, count($hlSocial) - 1);
  if ($hlIsAssoc) { $hlSocial = collect($hlSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="bg-hl-deep text-white/85 mt-0">
  <div class="max-w-[1440px] mx-auto px-5 py-12 grid grid-cols-2 md:grid-cols-6 gap-8 text-[13px]">
    <div class="col-span-2 md:col-span-1">
      <span class="inline-flex items-center gap-2">
        <span class="font-display text-xl tracking-wide">
          @if($s->store_name ?? null)
            <span class="text-white">{{ $s->store_name }}</span>
          @else
            <span class="text-white">HOME</span><span class="text-hl-gold">LUXE</span>
          @endif
        </span>
      </span>
      <div class="tracking-[.2em] text-[8px] mt-1.5 text-white/50">LIVE BEAUTIFULLY</div>
      <p class="text-white/60 leading-5 mt-4">{{ $s->footer_text ?? 'Quality furniture and decor curated for modern, sustainable living.' }}</p>
      @if(!empty($hlSocial))
        <div class="flex items-center gap-2 mt-4">
          @foreach($hlSocial as $item)
            @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-hl-gold hover:text-hl-deep inline-flex items-center justify-center transition-colors">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            </a>
          @endforeach
        </div>
      @endif
    </div>
    @foreach([
      ['SHOP','All Products','New Arrivals','Best Sellers','Sale','Gift Cards'],
      ['CUSTOMER SERVICE','Track Your Order','Returns & Exchanges','Shipping Info','FAQs','Contact Us'],
      ['COMPANY','Our Story','Sustainability','Careers','Blog'],
      ['MY ACCOUNT','My Orders','Wishlist','Account Details','Addresses'],
    ] as $column)
      <div>
        <b class="text-white text-xs tracking-wide">{{ $column[0] }}</b>
        @foreach(array_slice($column,1) as $link)
          <a href="{{ $link === 'Contact Us' ? route('store.contact') : ($link === 'All Products' ? route('store.shop') : route('store.shop')) }}" class="block text-white/70 mt-3 hover:text-white transition-colors">{{ $link }}</a>
        @endforeach
      </div>
    @endforeach
    <div>
      <b class="text-white text-xs tracking-wide">WE ACCEPT</b>
      <div class="grid grid-cols-2 gap-2 mt-4">
        @foreach(['VISA','Mastercard','Amex','PayPal'] as $method)
          <span class="bg-white rounded-md px-2 py-1.5 text-hl-deep text-[10px] font-bold text-center">{{ $method }}</span>
        @endforeach
      </div>
    </div>
  </div>
  <div class="max-w-[1440px] mx-auto px-5 py-5 border-t border-white/15 flex flex-wrap gap-3 justify-between items-center text-[11px] text-white/60">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'HomeLuxe' }}. All Rights Reserved.</span>
    <span class="flex items-center gap-4">
      <a href="{{ route('store.contact') }}" class="hover:text-white">Privacy Policy</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Terms &amp; Conditions</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Sitemap</a>
    </span>
  </div>
</footer>
