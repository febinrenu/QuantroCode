@php
  $iqClient = Auth::guard('store')->user();
  $iqCategories = $categories ?? collect();
  $iqStaticNav = ['Headphones & Audio','Wearables','Drones & Cameras','Keyboards & Accessories','Speakers'];
@endphp
<div class="bg-iq-gold text-iq-navy text-xs font-semibold">
  <div class="max-w-[1400px] mx-auto px-5 flex items-center justify-between h-9 gap-4">
    <span class="truncate">{{ $s->topbar_text_left ?? 'Happy Shopping! Get 20% OFF on your first order. Use Code: WELCOME20' }}</span>
    <div class="hidden lg:flex items-center gap-5">
      <a href="{{ route('store.shop') }}" class="hover:opacity-70">Download App</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hover:opacity-70">Track Order</a>
      <a href="{{ route('store.contact') }}" class="hover:opacity-70">Help Center</a>
      @include('store.partials.language-switcher')
      <span>{{ $s->currency_code ?? 'USD' }}</span>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-iq-line">
  <div class="max-w-[1400px] mx-auto px-5 h-[84px] flex items-center gap-6">
    <a href="{{ route('store.index') }}" class="shrink-0 leading-none">
      @if(!empty($s->logo_path))
        <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[190px] object-contain">
      @else
        <span class="leading-none inline-block">
          <span class="block font-display font-bold text-2xl text-iq-navy">{{ strtoupper($s->store_name ?? 'ShopIQ') }}<span class="text-iq-gold">.</span></span>
          <span class="block text-[10px] text-iq-mute mt-0.5">Shop Smart. Live Better.</span>
        </span>
      @endif
    </a>

    <div class="hidden md:flex flex-1 max-w-[560px] relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
      <form action="{{ route('store.shop') }}" method="get" class="w-full relative">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search for products, brands and more..." class="w-full h-11 pl-5 pr-14 rounded-full border border-iq-line bg-white text-xs outline-none focus:ring-2 focus:ring-iq-purple/30" autocomplete="off" x-model="q" @input.debounce.250ms="fetch">
        <button type="submit" aria-label="Search" class="absolute right-1 top-1 w-9 h-9 rounded-full bg-iq-purple text-white grid place-items-center hover:brightness-95 transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
        </button>
        <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-iq-line rounded-2xl shadow-lift overflow-hidden max-h-96 overflow-y-auto z-50">
          <template x-for="p in results" :key="p.id">
            <a :href="p.url" class="flex items-center gap-3 px-4 py-2.5 hover:bg-iq-lav/40">
              <img :src="p.image_url" class="w-10 h-10 rounded-lg object-cover">
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate" x-text="p.name"></div>
                <div class="text-xs font-bold text-iq-purple" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
              </div>
            </a>
          </template>
        </div>
      </form>
    </div>

    <div class="ml-auto flex items-center gap-5 md:gap-6 text-center text-[10px] font-semibold text-iq-navy">
      <a href="{{ $iqClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-iq-purple">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        {{ $iqClient ? 'Account' : 'Login' }}
      </a>
      <a href="{{ route('store.shop') }}" class="relative hidden sm:flex flex-col items-center gap-0.5 hover:text-iq-purple">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
        Wishlist
      </a>
      <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center gap-0.5 hover:text-iq-purple">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
        <b class="cart-count absolute -top-1.5 -right-2 bg-iq-purple text-white rounded-full min-w-[16px] h-4 px-1 text-[9px] leading-4">0</b>
        Cart
      </a>
      <button class="md:hidden text-2xl text-iq-navy" onclick="document.getElementById('iq-mobile').classList.toggle('hidden')" aria-label="Menu">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>

  <div class="max-w-[1400px] mx-auto px-5 hidden md:flex items-center gap-6 h-14 text-[13px] font-semibold text-iq-navy border-t border-iq-line">
    <details class="relative">
      <summary class="cursor-pointer flex items-center gap-2 rounded-lg bg-iq-purple text-white px-5 py-2.5 hover:brightness-95 transition">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        BROWSE CATEGORIES
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
      </summary>
      <div class="absolute z-50 top-12 w-64 bg-white border border-iq-line rounded-2xl shadow-lift p-3 space-y-1">
        @if($iqCategories->count() > 1)
          @foreach($iqCategories as $cat)
            <a class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-iq-lav/40" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
          @endforeach
        @else
          @foreach($iqStaticNav as $nav)
            <a class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-iq-lav/40" href="{{ route('store.shop') }}">{{ $nav }}</a>
          @endforeach
        @endif
      </div>
    </details>
    <a href="{{ route('store.index') }}" class="hover:text-iq-purple">HOME</a>
    <a href="{{ route('store.shop') }}" class="hover:text-iq-purple">SHOP</a>
    <a href="{{ route('store.shop',['sort'=>'price_asc']) }}" class="hover:text-iq-purple">DEALS</a>
    <a href="{{ route('store.shop') }}" class="hover:text-iq-purple">BRANDS</a>
    <a href="{{ route('store.shop') }}" class="hover:text-iq-purple">FEATURED</a>
    <a href="{{ route('store.contact') }}" class="hover:text-iq-purple">CONTACT</a>
    <a href="{{ route('store.shop',['sort'=>'price_asc']) }}" class="ml-auto rounded-full bg-emerald-500 text-white px-4 py-2 text-xs font-bold">🔥 HOT DEALS</a>
  </div>

  <div id="iq-mobile" class="hidden md:hidden px-5 py-4 border-t border-iq-line">
    <form action="{{ route('store.shop') }}" class="mb-3">
      <input name="q" class="w-full h-11 px-4 border border-iq-line rounded-full text-sm" placeholder="Search for products, brands and more">
    </form>
    <div class="mb-3">@include('store.partials.language-switcher', ['variant' => 'mobile'])</div>
    <div class="grid grid-cols-2 gap-1">
      @if($iqCategories->count() > 1)
        @foreach($iqCategories as $cat)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
        @endforeach
      @else
        @foreach($iqStaticNav as $nav)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop') }}">{{ $nav }}</a>
        @endforeach
      @endif
    </div>
  </div>
</header>
