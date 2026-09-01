@php
  $plClient = Auth::guard('store')->user();
  $plCategories = $categories ?? collect();
  $plStaticNav = [
    ['Dogs', 'M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z'],
    ['Cats', 'M12 3 9 6H7a3 3 0 0 0-3 3v6a5 5 0 0 0 5 5h6a5 5 0 0 0 5-5V9a3 3 0 0 0-3-3h-2Z M9 13.5c0 .8.9 1.5 3 1.5s3-.7 3-1.5'],
    ['Small Pets', 'M8 4c0 2-1.5 3-1.5 5S8 12 12 12s5.5-1 5.5-3S16 6 16 4M6 13c-2 .3-3 1.7-3 3.3C3 19 5.5 20 9 20h6c3.5 0 6-1 6-3.7 0-1.6-1-3-3-3.3'],
    ['Food', 'M3 11a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1v-6h3M3 11h3v6H5a2 2 0 0 1-2-2z'],
    ['Toys', 'M6.5 8a2.5 2.5 0 1 1 3.9 2.06L9 11.5H15l-1.4-1.44A2.5 2.5 0 1 1 17.5 8a2.5 2.5 0 0 1-1.5 4.4l1.4 1.44a2.5 2.5 0 1 1-2.76 2.9L15 15H9l-1.64 1.74a2.5 2.5 0 1 1-2.76-2.9l1.4-1.44A2.5 2.5 0 0 1 6.5 8Z'],
    ['Grooming', 'M4 4v6M2 6h4M18 4v6M16 6h4M11 7v14M5 12c0 3.5 2.7 5.5 6 7.3 3.3-1.8 6-3.8 6-7.3'],
    ['Health', 'M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z'],
    ['Beds', 'M2 17h20M3 17v-4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4M6 11V8a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3'],
  ];
@endphp
<div class="bg-pl-mint text-pl-ink text-xs">
  <div class="max-w-[1360px] mx-auto px-5 flex items-center justify-between h-9 gap-4">
    <span class="truncate flex items-center gap-1.5 font-semibold">
      <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
      {{ $s->topbar_text_left ?? 'Free Shipping on orders $59+' }}
    </span>
    <div class="hidden lg:flex items-center gap-4 font-medium">
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        {{ $s->topbar_text_right ?? 'Pet Care Hotline: (888) 729-PAWS' }}
      </span>
      <a href="{{ route('store.shop') }}" class="flex items-center gap-1.5 hover:opacity-70"><svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>Store Locator</a>
      <a href="{{ route('store.shop') }}" class="flex items-center gap-1.5 hover:opacity-70"><svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>Rewards Club</a>
      <a href="{{ route('store.contact') }}" class="hover:opacity-70">Help Center</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hover:opacity-70">Track Order</a>
      <a href="{{ $plClient ? url('/online_store/account') : url('/online_store/login') }}" class="flex items-center gap-1.5 hover:opacity-70"><svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>My Account</a>
      @include('store.partials.language-switcher')
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-pl-line">
  <div class="max-w-[1360px] mx-auto px-5 h-[84px] flex items-center gap-8">
    <a href="{{ route('store.index') }}" class="shrink-0 leading-none">
      @if(!empty($s->logo_path))
        <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[170px] object-contain">
      @else
        <img src="{{ global_asset('images/themes/pawluxe/logo.png') }}" alt="{{ $s->store_name ?? 'PawLuxe' }}" class="h-12 max-w-[190px] object-contain object-left">
      @endif
    </a>

    <div class="hidden md:flex flex-1 max-w-[520px] mx-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
      <form action="{{ route('store.shop') }}" method="get" class="w-full relative">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search for food, toys, treats and more..." class="w-full h-11 pl-5 pr-14 rounded-full border border-pl-line bg-white text-xs outline-none focus:ring-2 focus:ring-pl-teal/30" autocomplete="off" x-model="q" @input.debounce.250ms="fetch">
        <button type="submit" aria-label="Search" class="absolute right-1 top-1 w-9 h-9 rounded-full bg-pl-coral text-white grid place-items-center hover:brightness-95 transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
        </button>
        <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-pl-line rounded-2xl shadow-lift overflow-hidden max-h-96 overflow-y-auto z-50">
          <template x-for="p in results" :key="p.id">
            <a :href="p.url" class="flex items-center gap-3 px-4 py-2.5 hover:bg-pl-cream">
              <img :src="p.image_url" class="w-10 h-10 rounded-lg object-cover">
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate" x-text="p.name"></div>
                <div class="text-xs font-bold text-pl-teal" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
              </div>
            </a>
          </template>
        </div>
      </form>
    </div>

    <div class="ml-auto flex items-center gap-5 md:gap-7 text-center text-[10px] font-semibold text-pl-ink">
      <a href="{{ route('store.shop') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-pl-teal">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
        Favorites
      </a>
      <a href="{{ $plClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-pl-teal">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12a9 9 0 1 1-2.64-6.36"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 3v6h-6"/></svg>
        Auto-Ship
      </a>
      <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center gap-0.5 hover:text-pl-teal">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
        <b class="cart-count absolute -top-1.5 -right-2 bg-pl-coral text-white rounded-full min-w-[16px] h-4 px-1 text-[9px] leading-4">0</b>
        Cart
      </a>
      <button class="md:hidden text-2xl text-pl-ink" onclick="document.getElementById('pl-mobile').classList.toggle('hidden')" aria-label="Menu">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>

  <div class="max-w-[1360px] mx-auto px-5 hidden md:flex items-center gap-6 h-12 text-[12px] font-bold text-pl-ink border-t border-pl-line overflow-x-auto no-scrollbar">
    @if($plCategories->count() > 1)
      @foreach($plCategories->take(8) as $cat)
        <a class="flex items-center gap-1.5 shrink-0 hover:text-pl-coral" href="{{ route('store.shop',['category'=>$cat->id]) }}">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
          {{ strtoupper($cat->name) }}
        </a>
      @endforeach
    @else
      @foreach($plStaticNav as $nav)
        <a class="flex items-center gap-1.5 shrink-0 hover:text-pl-coral" href="{{ route('store.shop') }}">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $nav[1] }}"/></svg>
          {{ strtoupper($nav[0]) }}
        </a>
      @endforeach
    @endif
    <a href="{{ route('store.shop') }}" class="ml-auto shrink-0 flex items-center gap-1">NEW ARRIVALS <span class="bg-pl-coral text-white text-[8px] px-1.5 py-0.5 rounded">NEW</span></a>
  </div>

  <div id="pl-mobile" class="hidden md:hidden px-5 py-4 border-t border-pl-line">
    <form action="{{ route('store.shop') }}" class="mb-3">
      <input name="q" class="w-full h-11 px-4 border border-pl-line rounded-full text-sm" placeholder="Search food, toys, treats and more">
    </form>
    <div class="mb-3">@include('store.partials.language-switcher', ['variant' => 'mobile'])</div>
    <div class="grid grid-cols-2 gap-1">
      @if($plCategories->count() > 1)
        @foreach($plCategories as $cat)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
        @endforeach
      @else
        @foreach($plStaticNav as $nav)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop') }}">{{ $nav[0] }}</a>
        @endforeach
      @endif
    </div>
  </div>
</header>
