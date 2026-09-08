@php
  $mktClient = Auth::guard('store')->user();
  $mktCategories = $categories ?? collect();
  $mktSubcats = optional($mktCategories->first())->subcategories ?? collect();
@endphp
<div class="bg-mkt-purpleDeep text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4">
    <span class="hidden sm:inline-flex items-center gap-1.5 truncate">
      <svg class="w-3.5 h-3.5 text-mkt-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6 M2 7h20v5H2z M12 22V7"/></svg>
      {{ $s->topbar_text_left ?? 'Mega Sale is Live! Up to 60% OFF on selected items.' }}
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="text-mkt-gold font-bold hover:underline">{{ 'Shop Now' }} &rarr;</a>
    </span>
    <span class="flex items-center gap-4 whitespace-nowrap ms-auto">
      <a href="{{ route('store.contact') }}" class="hover:text-mkt-gold hidden md:inline">{{ 'Sell on Marketly' }}</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hover:text-mkt-gold hidden sm:inline">{{ 'Track Order' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-mkt-gold hidden sm:inline">{{ 'Help Center' }}</a>
      <span class="text-white/60">{{ 'EN' }} | {{ $s->currency_code ?? 'USD' }}</span>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-mkt-ink/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2.5 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[190px] object-contain">
        @else
          <span class="w-9 h-9 rounded-lg bg-mkt-purple text-white inline-flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18 M16 10a4 4 0 0 1-8 0"/></svg>
          </span>
          <span class="leading-tight">
            <span class="block font-heading font-bold text-xl text-mkt-ink">{{ $s->store_name ?? 'Marketly' }}</span>
            <span class="block text-[11px] text-mkt-inkSoft">{{ 'Everything you need.' }}</span>
          </span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-mkt-ink/20 rounded-md overflow-hidden">
          <span class="hidden lg:inline-flex items-center gap-1 px-3 text-xs font-semibold text-mkt-inkSoft border-r border-mkt-ink/15 whitespace-nowrap">
            {{ __('messages.AllCategories') ?? 'All Categories' }}
            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </span>
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for products, brands and more...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-12 h-11 inline-flex items-center justify-center bg-mkt-purple text-white hover:bg-mkt-purpleDeep">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-mkt-ink/15 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-mkt-cream">
                <img :src="p.image_url" class="w-10 h-10 object-cover rounded">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-mkt-purple" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-5">
        <a href="{{ route('store.shop') }}" class="hidden lg:flex flex-col items-center gap-0.5 text-mkt-ink hover:text-mkt-purple">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 3v10a2 2 0 0 0 2 2h9 M6 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z M17 21a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z M3 3h2l1 5 M8 8h9l2-4H6"/></svg>
          <span class="text-[10px] font-medium">{{ 'Compare' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-mkt-ink hover:text-mkt-purple relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-mkt-coral text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-mkt-ink hover:text-mkt-purple relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-mkt-coral text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <a href="{{ $mktClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-mkt-ink hover:text-mkt-purple">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <button type="button" class="md:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('mkt-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-mkt-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="hidden md:block border-t border-mkt-ink/10">
    <div class="max-w-7xl mx-auto px-4 h-12 flex items-center">
      <a href="{{ route('store.index') }}" class="px-4 h-8 inline-flex items-center text-sm font-semibold text-mkt-purple border-b-2 border-mkt-purple">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ __('messages.Shop') }}</a>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'Deals' }}</a>
      <a href="{{ route('store.shop') }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'Top Brands' }}</a>
      <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'New Arrivals' }}</a>
      <a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'Flash Sale' }}</a>
      <a href="{{ route('store.contact') }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'Blog' }}</a>
      <a href="{{ route('store.contact') }}" class="px-4 h-8 inline-flex items-center text-sm font-medium text-mkt-ink hover:text-mkt-purple">{{ 'Contact Us' }}</a>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="ms-auto h-8 px-4 inline-flex items-center gap-1.5 rounded-full bg-mkt-coral text-white text-xs font-bold hover:bg-mkt-pink">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M13 2 3 14h7l-1 8 11-14h-8l1-6Z"/></svg>
        {{ 'Flash Deals' }}
      </a>
    </div>
  </nav>

  {{-- Mobile menu --}}
  <div id="mkt-mobile-menu" class="hidden md:hidden border-t border-mkt-ink/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-3 border border-mkt-ink/20 bg-mkt-cream text-sm rounded-md" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-mkt-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-mkt-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-mkt-ink">{{ __('messages.Shop') }}</a>
      @foreach($mktSubcats as $sub)
        <a href="{{ route('store.shop', ['sub_category' => $sub->id]) }}" class="block py-2 text-sm text-mkt-inkSoft border-t border-mkt-ink/10">{{ $sub->name }}</a>
      @endforeach
    </div>
  </div>
</header>
