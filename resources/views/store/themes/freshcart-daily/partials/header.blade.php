@php
  $fcClient = Auth::guard('store')->user();
  $fcCategories = $categories ?? collect();
  $fcDepartments = [
    ['label' => 'Fruits & Veg', 'icon' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z'],
    ['label' => 'Dairy & Eggs', 'icon' => 'M8 2h8l1 4v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6l1-4Z M8 10h8'],
    ['label' => 'Bakery', 'icon' => 'M4 13a8 8 0 0 1 16 0v6H4v-6Z M2 19h20'],
    ['label' => 'Meat & Seafood', 'icon' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z'],
    ['label' => 'Beverages', 'icon' => 'M6 2h12l-2 6v12a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V8L6 2Z'],
    ['label' => 'Snacks', 'icon' => 'M3 10a9 9 0 0 1 18 0v1H3v-1Z M3 11h18l-1.5 9a2 2 0 0 1-2 1.7H6.5a2 2 0 0 1-2-1.7L3 11Z'],
    ['label' => 'Baby Care', 'icon' => 'M12 2a5 5 0 0 1 5 5c0 2-1 3-1 5v2a4 4 0 0 1-8 0v-2c0-2-1-3-1-5a5 5 0 0 1 5-5Z'],
    ['label' => 'Household', 'icon' => 'm3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z'],
    ['label' => 'Organic', 'icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z'],
    ['label' => 'Offers', 'icon' => 'M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z M7 7h.01'],
  ];
  $fcDeptNav = ['Fresh Produce', 'Dairy & Eggs', 'Bakery', 'Meat & Seafood', 'Frozen', 'Beverages', 'Snacks', 'Baby Care', 'Household', 'Organic'];
@endphp
<div class="bg-fc-greenDeep text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4 overflow-x-auto no-scrollbar">
    <span class="hidden sm:flex items-center gap-1.5 font-medium whitespace-nowrap">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
      {{ 'Delivery to:' }} {{ $s->store_zip_code ?? '560001' }}, {{ $s->store_city ?? 'Bangalore' }}
    </span>
    <span class="hidden md:flex items-center gap-1.5 whitespace-nowrap">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      {{ 'Delivery Slot: Today, 6 PM - 8 PM' }}
    </span>
    <span class="ms-auto flex items-center gap-4 whitespace-nowrap">
      <a href="{{ route('store.shop') }}" class="hidden lg:inline hover:text-fc-orangeSoft">{{ 'Weekly Deals' }}</a>
      <a href="{{ route('store.contact') }}" class="hidden lg:inline hover:text-fc-orangeSoft">{{ 'Recipes' }}</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hidden sm:inline hover:text-fc-orangeSoft">{{ 'Order Tracking' }}</a>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-fc-green/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[170px] object-contain">
        @else
          <svg class="w-9 h-9 text-fc-green shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z"/><path d="M12 8v8"/></svg>
          <span class="leading-tight">
            <span class="block font-heading font-extrabold text-xl tracking-tight">
              <span class="text-fc-green">Fresh</span><span class="text-fc-orange">Cart</span>
            </span>
            <span class="block text-[10px] font-semibold text-fc-inkSoft -mt-0.5">{{ 'Market' }}</span>
          </span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border-2 border-fc-green rounded-full overflow-hidden bg-white">
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ 'Search for fruits, vegetables, dairy and more...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-12 h-11 inline-flex items-center justify-center bg-fc-green text-white hover:bg-fc-greenDeep">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-fc-green/15 rounded-2xl shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-fc-greenLight">
                <img :src="p.image_url" class="w-10 h-10 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-fc-green" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-5">
        <button type="button" class="hidden sm:flex flex-col items-center gap-0.5 text-fc-inkSoft hover:text-fc-green">
          <span class="text-[10px] font-semibold flex items-center gap-1">
            {{ 'Deliver to' }} {{ $s->store_zip_code ?? '560001' }}
            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </span>
        </button>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-fc-inkSoft hover:text-fc-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ $fcClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-fc-inkSoft hover:text-fc-green">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-fc-inkSoft hover:text-fc-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-fc-orange text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="md:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('fc-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Category icon strip --}}
  <div class="hidden md:block bg-fc-greenLight border-t border-fc-green/10">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between gap-2 py-2.5 overflow-x-auto no-scrollbar">
      @foreach($fcDepartments as $dept)
        <a href="{{ route('store.shop') }}" class="flex flex-col items-center gap-1 shrink-0 text-fc-ink hover:text-fc-green px-2">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $dept['icon'] }}"/></svg>
          <span class="text-[10px] font-semibold whitespace-nowrap">{{ $dept['label'] }}</span>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Departments nav bar --}}
  <div class="hidden md:block bg-fc-greenDeep">
    <div class="max-w-7xl mx-auto px-4 flex items-center gap-1 h-11 overflow-x-auto no-scrollbar">
      <div class="group relative shrink-0">
        <button type="button" class="h-8 px-3 inline-flex items-center gap-2 bg-white/10 rounded text-white text-xs font-bold hover:bg-white/20">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          {{ 'All Departments' }}
        </button>
        @if($fcCategories->count())
          <div class="hidden group-hover:block absolute top-full left-0 pt-0 z-30 min-w-[220px] bg-white border border-fc-green/15 rounded-b-xl shadow-cardHover">
            @foreach($fcCategories as $cat)
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block px-4 py-2 text-sm text-fc-ink hover:bg-fc-greenLight hover:text-fc-green">{{ $cat->name }}</a>
            @endforeach
          </div>
        @endif
      </div>
      @foreach($fcDeptNav as $dept)
        <a href="{{ route('store.shop') }}" class="px-3 h-8 inline-flex items-center text-xs font-semibold text-white/90 hover:text-white whitespace-nowrap">{{ $dept }}</a>
      @endforeach
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="ms-auto px-3 h-8 inline-flex items-center text-xs font-bold text-fc-orangeSoft hover:text-white whitespace-nowrap">{{ 'Deals' }}</a>
    </div>
  </div>

  {{-- Mobile menu --}}
  <div id="fc-mobile-menu" class="hidden md:hidden border-t border-fc-green/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-4 rounded-full border-2 border-fc-green bg-white text-sm" placeholder="{{ 'Search groceries, products...' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-fc-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-fc-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-fc-ink">{{ __('messages.Shop') }}</a>
      @foreach($fcCategories as $cat)
        <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-2 text-sm text-fc-inkSoft border-t border-fc-green/10">{{ $cat->name }}</a>
      @endforeach
    </div>
  </div>
</header>
