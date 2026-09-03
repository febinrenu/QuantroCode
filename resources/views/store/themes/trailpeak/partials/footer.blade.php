@php
  $tpSocial = $s->social_links ?? [];
  if (is_string($tpSocial)) { $d = json_decode($tpSocial, true); if (json_last_error() === JSON_ERROR_NONE) $tpSocial = $d; }
  if (!is_array($tpSocial)) { $tpSocial = []; }
  $tpIsAssoc = !empty($tpSocial) && array_keys($tpSocial) !== range(0, count($tpSocial) - 1);
  if ($tpIsAssoc) { $tpSocial = collect($tpSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="bg-tp-ink text-white/75 mt-0">
  <div class="max-w-[1400px] mx-auto px-5 py-12 grid grid-cols-2 md:grid-cols-7 gap-8 text-[13px]">
    <div class="col-span-2">
      <span class="inline-flex items-center gap-2">
        <svg class="w-6 h-6 text-tp-orange shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="m3 20 6-11 4 7 3-5 5 9Z"/></svg>
        <span class="font-display text-lg tracking-tight text-white">{{ strtoupper($s->store_name ?? 'TrailPeak') }}</span>
      </span>
      <div class="text-[9px] tracking-[.2em] text-white/40 mt-1.5">BUILT FOR ADVENTURE</div>
      <p class="text-white/60 leading-5 mt-4">{{ $s->footer_text ?? 'We equip and inspire adventurers to explore the wild and live extraordinary lives.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @foreach($tpSocial ?: [1,2,3,4] as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-tp-orange inline-flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @endforeach
      </div>
    </div>
    @foreach([
      ['SHOP','All Products','New Arrivals','Best Sellers','Deals'],
      ['CUSTOMER CARE','Help Center','Track Order','Returns & Exchanges','Shipping Info'],
      ['ABOUT TRAILPEAK','Our Story','Sustainability','Careers','Affiliate Program'],
    ] as $column)
      <div>
        <b class="text-white text-xs tracking-wide">{{ $column[0] }}</b>
        @foreach(array_slice($column,1) as $link)
          <a href="{{ $link === 'Help Center' ? route('store.contact') : route('store.shop') }}" class="block text-white/60 mt-3 hover:text-white transition-colors">{{ $link }}</a>
        @endforeach
      </div>
    @endforeach
    <div>
      <b class="text-white text-xs tracking-wide">STORE LOCATIONS</b>
      <p class="text-white/60 mt-3 text-[12px] leading-5">Find a Store Near You</p>
      <div class="relative mt-3 h-20 rounded-md overflow-hidden bg-white/10">
        <svg class="w-full h-full text-white/15" viewBox="0 0 140 80" fill="none" stroke="currentColor" stroke-width="1">
          @for($i=1;$i<7;$i++)<line x1="{{ $i*20 }}" y1="0" x2="{{ $i*20 }}" y2="80"/>@endfor
          @for($i=1;$i<4;$i++)<line x1="0" y1="{{ $i*20 }}" x2="140" y2="{{ $i*20 }}"/>@endfor
        </svg>
        @foreach([[30,25],[70,45],[105,20],[50,60]] as $pin)
          <svg class="absolute w-3.5 h-3.5 text-tp-orange" style="left:{{ $pin[0] }}px; top:{{ $pin[1] }}px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22s8-9 8-14a8 8 0 1 0-16 0c0 5 8 14 8 14Zm0-11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/></svg>
        @endforeach
      </div>
      <a href="{{ route('store.shop') }}" class="block text-white/60 mt-3 hover:text-white transition-colors text-xs font-semibold">VIEW ALL STORES →</a>
    </div>
    <div>
      <b class="text-white text-xs tracking-wide">DOWNLOAD OUR APP</b>
      <p class="text-white/60 mt-3 text-[12px] leading-5">Gear. Guides. Adventure.</p>
      <div class="flex flex-col gap-2 mt-3">
        <span class="inline-flex items-center gap-2 bg-white/10 rounded-md px-3 py-2 text-[11px] font-semibold">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M16.5 2c.1 1-.3 2-1 2.7-.7.8-1.8 1.4-2.8 1.3-.1-1 .4-2 1-2.7.8-.8 2-1.3 2.8-1.3ZM20 17.3c-.5 1.2-.8 1.7-1.5 2.8-1 1.5-2.4 3.4-4.1 3.4-1.5 0-1.9-1-4-1-2 0-2.5 1-4 1-1.7 0-3-1.7-4-3.2C0.4 17.5-.6 13 1 9.9c.9-1.6 2.5-2.7 4.2-2.7 1.6 0 2.6 1 4 1 1.3 0 2.1-1 4-1 1.4 0 3 .8 4 2.1-3.5 1.9-2.9 6.9.8 8Z"/></svg>
          App Store
        </span>
        <span class="inline-flex items-center gap-2 bg-white/10 rounded-md px-3 py-2 text-[11px] font-semibold">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m3 2 11 10L3 22V2Zm12 11 3.5-2 3 1.7c.8.5.8 1.6 0 2.1l-3 1.7L15 13Zm-1-1L4 3l9 5.3L14 12ZM4 21l10-9 1 1-5.7 4.7L4 21Z"/></svg>
          Google Play
        </span>
      </div>
    </div>
  </div>
  <div class="max-w-[1400px] mx-auto px-5 py-5 border-t border-white/10 flex flex-wrap gap-3 justify-between items-center text-[11px] text-white/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'TrailPeak' }}. All Rights Reserved.</span>
    <span class="flex items-center gap-4">
      <a href="{{ route('store.contact') }}" class="hover:text-white">Privacy Policy</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Terms of Service</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Accessibility</a>
    </span>
    <span class="flex items-center gap-2 text-white/70">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
      Secure Checkout
    </span>
  </div>
</footer>
