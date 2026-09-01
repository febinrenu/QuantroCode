@php
  $tpClient = Auth::guard('store')->user();
  $tpCategories = $categories ?? collect();
  $tpStaticNav = ['Hiking','Camping','Travel Gear','Footwear','Apparel','Climbing','Cycling','Water Sports'];
@endphp
<div class="bg-tp-ink text-white text-xs">
  <div class="max-w-[1400px] mx-auto px-5 flex items-center justify-between h-9 gap-4">
    <span class="truncate">{{ $s->topbar_text_left ?? 'Free Shipping on orders $75+' }}</span>
    <div class="hidden lg:flex items-center gap-5 font-medium">
      <span>{{ $s->topbar_text_right ?? 'TrailPeak Rewards — Earn 10% Back' }}</span>
      <a href="{{ route('store.shop') }}" class="hover:text-tp-orange">Gear Guide</a>
      <a href="{{ route('store.shop') }}" class="hover:text-tp-orange">Store Locator</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hover:text-tp-orange">Track Order</a>
      @include('store.partials.language-switcher')
      <span>{{ $s->currency_code ?? 'USD' }}</span>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-tp-line">
  <div class="max-w-[1400px] mx-auto px-5 h-[86px] flex items-center gap-8">
    <a href="{{ route('store.index') }}" class="shrink-0 leading-none">
      @if(!empty($s->logo_path))
        <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[190px] object-contain">
      @else
        <span class="inline-flex items-center gap-2.5">
          <svg class="w-9 h-9 text-tp-forest shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="m3 20 6-11 4 7 3-5 5 9Z"/></svg>
          <span class="leading-none">
            <span class="block font-display text-[22px] tracking-tight text-tp-ink">{{ strtoupper($s->store_name ?? 'TrailPeak') }}</span>
            <span class="block text-[9px] tracking-[.2em] text-tp-mute mt-0.5">BUILT FOR ADVENTURE</span>
          </span>
        </span>
      @endif
    </a>

    <div class="hidden md:flex flex-1 max-w-[540px] mx-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
      <form action="{{ route('store.shop') }}" method="get" class="w-full relative">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search gear, brands or adventures..." class="w-full h-11 pl-5 pr-14 rounded-lg border border-tp-line bg-white text-xs outline-none focus:ring-2 focus:ring-tp-forest/30" autocomplete="off" x-model="q" @input.debounce.250ms="fetch">
        <button type="submit" aria-label="Search" class="absolute right-1 top-1 w-9 h-9 rounded-md bg-tp-ink text-white grid place-items-center hover:bg-tp-forest transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
        </button>
        <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-tp-line rounded-lg shadow-lift overflow-hidden max-h-96 overflow-y-auto z-50">
          <template x-for="p in results" :key="p.id">
            <a :href="p.url" class="flex items-center gap-3 px-4 py-2.5 hover:bg-tp-cream">
              <img :src="p.image_url" class="w-10 h-10 rounded-md object-cover">
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate" x-text="p.name"></div>
                <div class="text-xs font-bold text-tp-forest" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
              </div>
            </a>
          </template>
        </div>
      </form>
    </div>

    <div class="ml-auto flex items-center gap-5 md:gap-6 text-center text-[10px] font-semibold text-tp-ink">
      <a href="{{ $tpClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-tp-forest">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        {{ $tpClient ? 'Account' : 'Sign In' }}
      </a>
      <a href="{{ route('store.shop') }}" class="relative hidden sm:flex flex-col items-center gap-0.5 hover:text-tp-forest">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
        <b class="absolute -top-1.5 -right-2 bg-tp-orange text-white rounded-full min-w-[16px] h-4 px-1 text-[9px] leading-4">2</b>
        Wishlist
      </a>
      <a href="{{ route('store.shop') }}" class="relative hidden sm:flex flex-col items-center gap-0.5 hover:text-tp-forest">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M17 3v4M7 3v4M4 8h16l-1 12H5L4 8Z"/></svg>
        Compare
      </a>
      <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center gap-0.5 hover:text-tp-forest">
        <svg class="w-[21px] h-[21px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
        <b class="cart-count absolute -top-1.5 -right-2 bg-tp-orange text-white rounded-full min-w-[16px] h-4 px-1 text-[9px] leading-4">0</b>
        Cart
      </a>
      <button class="md:hidden text-2xl text-tp-ink" onclick="document.getElementById('tp-mobile').classList.toggle('hidden')" aria-label="Menu">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>

  <div class="bg-tp-forest text-white">
    <div class="max-w-[1400px] mx-auto px-5 flex items-center gap-6 h-11 text-[12px] font-bold overflow-x-auto no-scrollbar">
      @if($tpCategories->count() > 1)
        @foreach($tpCategories->take(8) as $cat)
          <a class="shrink-0 hover:text-tp-orange" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ strtoupper($cat->name) }}</a>
        @endforeach
      @else
        @foreach($tpStaticNav as $nav)
          <a class="shrink-0 hover:text-tp-orange" href="{{ route('store.shop') }}">{{ strtoupper($nav) }}</a>
        @endforeach
      @endif
      <a href="{{ route('store.shop') }}" class="shrink-0 flex items-center gap-1">NEW ARRIVALS <span class="bg-tp-orange text-white text-[8px] px-1.5 py-0.5 rounded">NEW</span></a>
      <a href="{{ route('store.shop',['sort'=>'price_asc']) }}" class="shrink-0 ml-auto text-tp-orange">DEALS</a>
    </div>
  </div>

  <div id="tp-mobile" class="hidden md:hidden px-5 py-4 border-t border-tp-line">
    <form action="{{ route('store.shop') }}" class="mb-3">
      <input name="q" class="w-full h-11 px-4 border border-tp-line rounded-lg text-sm" placeholder="Search gear, brands or adventures">
    </form>
    <div class="mb-3">@include('store.partials.language-switcher', ['variant' => 'mobile'])</div>
    <div class="grid grid-cols-2 gap-1">
      @if($tpCategories->count() > 1)
        @foreach($tpCategories as $cat)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
        @endforeach
      @else
        @foreach($tpStaticNav as $nav)
          <a class="py-2 text-sm font-semibold" href="{{ route('store.shop') }}">{{ $nav }}</a>
        @endforeach
      @endif
    </div>
  </div>
</header>
