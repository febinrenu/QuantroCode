@php
  $urbClient = Auth::guard('store')->user();
  $urbCategories = $categories ?? collect();
  $urbSubcats = optional($urbCategories->first())->subcategories ?? collect();
  $urbSubcatId = fn ($name) => optional($urbSubcats->firstWhere('name', $name))->id;
@endphp
<div class="bg-urb-black text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="hidden sm:inline-flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>
      {{ $s->topbar_text_left ?? 'Free shipping on orders over $75' }}
    </span>
    <span class="hidden md:inline">
      {{ '10% OFF your first order' }} | {{ 'Use code:' }} <span class="text-urb-gold font-bold">HELLO10</span>
    </span>
    <span class="flex items-center gap-4 whitespace-nowrap">
      <a href="{{ route('store.contact') }}" class="hover:text-urb-gold hidden sm:inline">{{ 'About Us' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-urb-gold hidden sm:inline">{{ 'Stores' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-urb-gold hidden sm:inline">{{ 'Help & FAQs' }}</a>
      <span class="text-white/60">{{ 'US' }} ({{ $s->currency_code ?? 'USD' }})</span>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-urb-ink/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex flex-col shrink-0 leading-none">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[190px] object-contain">
        @else
          <span class="font-serif font-bold text-2xl tracking-wide text-urb-ink uppercase">{{ $s->store_name ?? 'Urbana' }}</span>
          <span class="text-[11px] italic text-urb-inkSoft mt-0.5">{{ 'Live Stylish. Every Day.' }}</span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-urb-ink/20 rounded-full overflow-hidden">
          <span class="hidden lg:inline-flex items-center gap-1 px-4 text-xs font-semibold text-urb-inkSoft border-r border-urb-ink/15 whitespace-nowrap">
            {{ __('messages.AllCategories') ?? 'All Categories' }}
            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </span>
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for products, brands and more...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-11 h-11 my-0.5 me-0.5 rounded-full inline-flex items-center justify-center bg-urb-green text-white hover:bg-urb-greenDeep">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-urb-ink/15 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-urb-cream">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-urb-green" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-6">
        <a href="{{ $urbClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-urb-ink hover:text-urb-green">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-urb-ink hover:text-urb-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-urb-green text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-urb-ink hover:text-urb-green relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-urb-green text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="md:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('urb-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-urb-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="hidden md:flex items-center gap-1 h-12 border-t border-urb-ink/10">
    <div class="max-w-7xl mx-auto px-4 w-full flex items-center">
      <a href="{{ route('store.index') }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-green border-b-2 border-urb-green">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-ink hover:text-urb-green">{{ __('messages.Shop') }}</a>
      <a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-ink hover:text-urb-green">{{ 'Collections' }}</a>
      <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-ink hover:text-urb-green">{{ 'New In' }}</a>
      <a href="{{ route('store.shop') }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-ink hover:text-urb-green">{{ 'Brands' }}</a>
      <a href="{{ route('store.shop') }}" class="px-4 h-8 inline-flex items-center text-xs font-bold eyebrow text-urb-ink hover:text-urb-green">{{ 'Lookbook' }}</a>
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="ms-auto h-8 px-4 inline-flex items-center gap-1.5 border border-urb-gold text-urb-green text-xs font-bold eyebrow hover:bg-urb-gold hover:text-white">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41 13.42 20.58a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82Z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        {{ 'Offers Zone' }}
      </a>
    </div>
  </nav>

  {{-- Mobile menu --}}
  <div id="urb-mobile-menu" class="hidden md:hidden border-t border-urb-ink/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-3 border border-urb-ink/20 bg-urb-cream text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-urb-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold eyebrow text-urb-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold eyebrow text-urb-ink">{{ __('messages.Shop') }}</a>
      @foreach($urbSubcats as $urbSub)
        <a href="{{ route('store.shop', ['sub_category' => $urbSub->id]) }}" class="block py-2 text-sm text-urb-inkSoft border-t border-urb-ink/10">{{ $urbSub->name }}</a>
      @endforeach
    </div>
  </div>
</header>
