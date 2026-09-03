@php
  $plSocial = $s->social_links ?? [];
  if (is_string($plSocial)) { $d = json_decode($plSocial, true); if (json_last_error() === JSON_ERROR_NONE) $plSocial = $d; }
  if (!is_array($plSocial)) { $plSocial = []; }
  $plIsAssoc = !empty($plSocial) && array_keys($plSocial) !== range(0, count($plSocial) - 1);
  if ($plIsAssoc) { $plSocial = collect($plSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
  $plSocialByPlatform = collect($plSocial)->keyBy(fn($i) => strtolower(is_array($i) ? ($i['platform'] ?? '') : ''));
  $plSocialIcons = [
    'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/>',
    'facebook' => '<path d="M13 21v-8h2.7l.4-3.2H13V7.7c0-.9.3-1.6 1.6-1.6H16V3.3C15.6 3.2 14.6 3 13.5 3 11 3 9.4 4.5 9.4 7.3v2.5H7V13h2.4v8Z"/>',
    'tiktok' => '<path d="M14 3v10.5a2.8 2.8 0 1 1-2-2.7V8.6a5.6 5.6 0 1 0 4.8 5.5V9.2a6.6 6.6 0 0 0 3.7 1.1V7.5a3.9 3.9 0 0 1-3.8-3.8Z"/>',
    'pinterest' => '<circle cx="12" cy="12" r="9"/><path d="M9.5 20c.5-1.5 1.7-6.2 1.7-6.2m0 0a2.6 2.6 0 0 0 2.4 1.4c2 0 3.4-1.8 3.4-4.2 0-2-1.6-3.9-4.1-3.9-3.2 0-4.8 2.3-4.8 4.2 0 1.1.4 2.1 1.3 2.5m.2-3.2c.2-.9.9-3.9.9-3.9" fill="none" stroke="currentColor" stroke-width="1.4"/>',
    'youtube' => '<rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9.5v5l4.5-2.5Z" fill="white"/>',
  ];
@endphp
<footer class="bg-pl-ink text-white/80 mt-0">
  <div class="max-w-[1360px] mx-auto px-5 py-12 grid grid-cols-2 md:grid-cols-6 gap-8 text-[13px]">
    <div class="col-span-2">
      <span class="inline-flex items-center gap-2">
        <svg class="w-6 h-6 text-pl-coral shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
        <span class="font-display font-bold text-xl text-white">{{ $s->store_name ?? 'PawLuxe' }}</span>
      </span>
      <p class="text-white/60 leading-5 mt-4">{{ $s->footer_text ?? 'Get exclusive deals, pet tips & new arrivals!' }}</p>
      <form class="flex mt-4 max-w-xs" onsubmit="return false;">
        <input type="email" placeholder="Enter your email" class="h-11 flex-1 min-w-0 px-4 text-xs text-pl-ink rounded-l-full outline-none">
        <button class="bg-pl-coral text-white px-5 rounded-r-full text-[11px] font-bold">Subscribe</button>
      </form>
      <div class="flex items-center gap-2 mt-4">
        @foreach($plSocialIcons as $platform => $path)
          @php $url = is_array($plSocialByPlatform[$platform] ?? null) ? ($plSocialByPlatform[$platform]['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($platform) }}" class="w-8 h-8 rounded-full bg-white/10 hover:bg-pl-coral inline-flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">{!! $path !!}</svg>
          </a>
        @endforeach
      </div>
    </div>
    @foreach([
      ['PET CARE','Pet Care Tips','Nutrition Guide','New Pet Checklist','Pet Health Library','Community Stories'],
      ['CUSTOMER SERVICE','Contact Us','Help Center','Track Your Order','Returns & Exchanges','Shipping Info'],
      ['ABOUT PAWLUXE','Our Story','Sustainability','Careers','Press & Media'],
    ] as $column)
      <div>
        <b class="text-white text-xs tracking-wide">{{ $column[0] }}</b>
        @foreach(array_slice($column,1) as $link)
          <a href="{{ $link === 'Contact Us' ? route('store.contact') : route('store.shop') }}" class="block text-white/60 mt-3 hover:text-white transition-colors">{{ $link }}</a>
        @endforeach
      </div>
    @endforeach
    <div class="flex gap-3">
      <div>
        <b class="text-white text-xs tracking-wide">DOWNLOAD THE APP</b>
        <p class="text-white/60 mt-3 text-[12px] leading-5">Shop, track &amp; manage your pet's needs on the go!</p>
        <div class="flex flex-col gap-2 mt-3">
          <a href="#"><img src="{{ global_asset('images/themes/pawluxe/app-store-badge.png') }}" alt="Download on the App Store" class="h-9 w-auto"></a>
          <a href="#"><img src="{{ global_asset('images/themes/pawluxe/google-play-badge.png') }}" alt="Get it on Google Play" class="h-9 w-auto"></a>
        </div>
      </div>
      <img src="{{ global_asset('images/themes/pawluxe/app-phone-mockup.png') }}" alt="PawLuxe app" class="hidden lg:block h-32 w-auto self-end rounded-xl shadow-lift">
    </div>
  </div>
  <div class="max-w-[1360px] mx-auto px-5 pb-8 flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-6">
    <div>
      <b class="text-white text-xs tracking-wide">WE ACCEPT</b>
      <div class="flex flex-wrap gap-2 mt-3">
        @foreach(['VISA','Mastercard','Amex','Discover'] as $method)
          <span class="bg-white rounded-md px-2.5 py-1.5 text-pl-ink text-[10px] font-bold">{{ $method }}</span>
        @endforeach
        @foreach(['Apple Pay','G Pay','PayPal'] as $method)
          <span class="border border-white/25 rounded-md px-2.5 py-1.5 text-white/80 text-[10px] font-bold">{{ $method }}</span>
        @endforeach
      </div>
    </div>
  </div>
  <div class="max-w-[1360px] mx-auto px-5 py-5 border-t border-white/10 flex flex-wrap gap-3 justify-between items-center text-[11px] text-white/50">
    <span>© {{ date('Y') }} {{ $s->store_name ?? 'PawLuxe' }} Pet Supplies. All Rights Reserved.</span>
    <span class="flex items-center gap-4">
      <a href="{{ route('store.contact') }}" class="hover:text-white">Terms of Service</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Privacy Policy</a>
      <a href="{{ route('store.contact') }}" class="hover:text-white">Accessibility</a>
    </span>
  </div>
</footer>

<button type="button" aria-label="Chat with us" class="fixed bottom-5 right-5 z-40 w-14 h-14 rounded-full bg-pl-teal text-white shadow-lift grid place-items-center hover:brightness-95 transition">
  <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/><circle cx="8.5" cy="12" r="1" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/><circle cx="15.5" cy="12" r="1" fill="currentColor" stroke="none"/></svg>
</button>
