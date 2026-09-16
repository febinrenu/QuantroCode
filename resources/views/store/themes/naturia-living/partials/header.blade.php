@php
  $ntClient = Auth::guard('store')->user();
  $ntCategories = $categories ?? collect();
  $ntSubcats = optional($ntCategories->first())->subcategories ?? collect();
  $ntSubcatId = fn ($name) => optional($ntSubcats->firstWhere('name', $name))->id;
@endphp
<div class="bg-nt-greenDeep text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4 overflow-x-auto no-scrollbar">
    <span class="hidden sm:inline-flex items-center gap-1.5 whitespace-nowrap">
      <svg class="w-3.5 h-3.5 text-nt-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>
      {{ 'Free shipping on orders over $60' }} | {{ '30-Day hassle-free returns' }}
    </span>
    <span class="ms-auto flex items-center gap-4 whitespace-nowrap">
      <a href="{{ route('store.contact') }}" class="hidden md:inline hover:text-nt-gold">{{ 'About Us' }}</a>
      <a href="{{ route('store.contact') }}" class="hidden md:inline hover:text-nt-gold">{{ 'Sustainability' }}</a>
      <a href="{{ route('store.contact') }}" class="hidden sm:inline hover:text-nt-gold">{{ 'Store Locator' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-nt-gold">{{ 'Help Center' }}</a>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-nt-green/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2.5 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[170px] object-contain">
        @else
          <span class="w-10 h-10 rounded-full border-2 border-nt-green flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z"/><path d="M12 8v8"/></svg>
          </span>
          <span class="leading-tight">
            <span class="block font-serif font-bold text-xl tracking-wide text-nt-ink">{{ strtoupper($s->store_name ?? 'Naturia') }}</span>
            <span class="block eyebrow text-[9px] text-nt-inkSoft">{{ 'Live Naturally' }}</span>
          </span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-nt-green/25 rounded-full overflow-hidden bg-white">
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ 'Search natural products...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-12 h-11 inline-flex items-center justify-center bg-nt-green text-white hover:bg-nt-greenDeep rounded-full m-0.5">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-nt-green/15 rounded-2xl shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-nt-greenLight">
                <img :src="p.image_url" class="w-10 h-10 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-nt-green" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-5">
        <a href="{{ $ntClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-nt-inkSoft hover:text-nt-green">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-nt-inkSoft hover:text-nt-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-nt-inkSoft hover:text-nt-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-nt-green text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="md:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('nt-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-nt-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    <nav class="hidden md:flex items-center gap-1 h-12 border-t border-nt-green/10">
      <a href="{{ route('store.index') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-green border-b-2 border-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
        {{ 'HOME' }}
      </a>
      <div class="group relative">
        <button type="button" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 7v13a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7l-3-5Z"/><path d="M3 7h18M9 11a3 3 0 0 0 6 0"/></svg>
          {{ 'SHOP' }}
          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        @if($ntSubcats->count())
          <div class="hidden group-hover:block absolute top-full left-0 pt-0 z-30 min-w-[200px] bg-white border border-nt-green/15 shadow-cardHover">
            @foreach($ntSubcats as $sc)
              <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block px-4 py-2 text-sm text-nt-ink hover:bg-nt-greenLight hover:text-nt-green">{{ $sc->name }}</a>
            @endforeach
          </div>
        @endif
      </div>
      <a href="{{ $ntSubcatId('Skin Care') ? route('store.shop', ['sub_category' => $ntSubcatId('Skin Care')]) : route('store.shop') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
        {{ 'BEAUTY' }}
      </a>
      <a href="{{ $ntSubcatId('Supplements') ? route('store.shop', ['sub_category' => $ntSubcatId('Supplements')]) : route('store.shop') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="9" width="16" height="12" rx="2"/><path d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
        {{ 'HEALTH' }}
      </a>
      <a href="{{ $ntSubcatId('Home Care') ? route('store.shop', ['sub_category' => $ntSubcatId('Home Care')]) : route('store.shop') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
        {{ 'HOME & LIVING' }}
      </a>
      <a href="{{ $ntSubcatId('Organic Food') ? route('store.shop', ['sub_category' => $ntSubcatId('Organic Food')]) : route('store.shop') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9Z"/></svg>
        {{ 'FOOD & DRINKS' }}
      </a>
      <a href="{{ route('store.contact') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-nt-ink hover:text-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
        {{ 'BLOG' }}
      </a>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="ms-auto h-8 px-4 inline-flex items-center gap-1.5 bg-nt-greenDeep text-white text-xs font-bold rounded-full hover:bg-nt-green">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        {{ 'OFFERS' }}
      </a>
    </nav>
  </div>

  {{-- Mobile menu --}}
  <div id="nt-mobile-menu" class="hidden md:hidden border-t border-nt-green/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-4 rounded-full border border-nt-green/20 bg-nt-cream text-sm" placeholder="{{ 'Search natural products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-nt-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-nt-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-nt-ink">{{ __('messages.Shop') }}</a>
      @foreach($ntSubcats as $sc)
        <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block py-2 text-sm text-nt-inkSoft border-t border-nt-green/10">{{ $sc->name }}</a>
      @endforeach
    </div>
  </div>
</header>
