@php
  $cnClient = Auth::guard('store')->user();
  $cnCategories = $categories ?? collect();
  $cnSubcats = optional($cnCategories->first())->subcategories ?? collect();
  $cnSubcatId = fn ($name) => optional($cnSubcats->firstWhere('name', $name))->id;
  $cnNavRooms = ['Living Room', 'Bedroom', 'Dining Room', 'Office', 'Lighting', 'Storage'];
  $cnIcons = [
    'Wood' => 'M12 2 3 7v10l9 5 9-5V7l-9-5Z',
    'Sofa Sets' => 'M4 18v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6 M2 12v6a1 1 0 0 0 1 1h2v-3 M22 12v6a1 1 0 0 0-1 1h-2v-3 M6 10V7a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3',
    'Storage' => 'M3 3h18v18H3z M3 9h18 M9 21V9',
    'Rugs' => 'M3 4h18v16H3z M7 8h10 M7 12h10 M7 16h6',
    'Wall Art' => 'M4 4h16v16H4z M4 15l4-4 4 4 4-6 4 6',
    'Outdoor' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z',
  ];
@endphp
<div class="bg-cn-oliveDeep text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4 overflow-x-auto no-scrollbar">
    <span class="hidden sm:inline-flex items-center gap-1.5 whitespace-nowrap">
      <svg class="w-3.5 h-3.5 text-cn-tanSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg>
      {{ 'Visit Our Showroom:' }} {{ $s->contact_address ?? '123 Design Street, San Francisco, CA' }}
    </span>
    <span class="hidden md:inline text-cn-tanSoft/90 truncate">{{ $s->topbar_text_left ?? "Spring Refresh Sale — Up to 30% Off Selected Items" }}</span>
    <a href="tel:{{ $s->contact_phone ?? '4155550198' }}" class="hover:text-cn-tanSoft whitespace-nowrap">{{ 'Call Us:' }} {{ $s->contact_phone ?? '(415) 555-0198' }}</a>
  </div>
</div>

<header class="sticky top-0 z-40 bg-cn-cream/95 backdrop-blur border-b border-cn-olive/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2.5 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[170px] object-contain">
        @else
          <span class="leading-tight">
            <span class="block font-serif font-bold text-2xl tracking-tight text-cn-ink">{{ $s->store_name ?? 'CasaNest' }}</span>
            <span class="block eyebrow text-[9px] text-cn-inkSoft">{{ 'Live Beautifully' }}</span>
          </span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 ms-4">
        <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="px-3 h-9 inline-flex items-center text-xs font-semibold text-cn-ink hover:text-cn-olive">{{ 'New Arrivals' }}</a>
        @foreach(['Living Room', 'Bedroom', 'Dining Room', 'Office', 'Lighting'] as $room)
          @if($cnSubcatId($room))
            <a href="{{ route('store.shop', ['sub_category' => $cnSubcatId($room)]) }}" class="px-3 h-9 inline-flex items-center text-xs font-semibold text-cn-ink hover:text-cn-olive whitespace-nowrap">{{ $room }}</a>
          @endif
        @endforeach
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-9 inline-flex items-center text-xs font-bold text-cn-sale hover:opacity-80">{{ 'Sale' }}</a>
      </nav>

      <div class="ms-auto flex items-center gap-5">
        <div class="hidden md:flex relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
          <button type="button" class="text-cn-inkSoft hover:text-cn-olive" @click="$refs.cnSearchInput.focus()">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <form action="{{ route('store.shop') }}" method="GET" class="absolute top-full right-0 mt-2 w-72">
            <input x-ref="cnSearchInput" type="text" name="q" class="w-full h-10 px-3 border border-cn-olive/25 bg-white text-sm shadow-card focus:outline-none"
                   placeholder="{{ __('messages.SearchProducts') ?? 'Search furniture, decor…' }}" autocomplete="off" x-model="q" @input.debounce.250ms="fetch">
            <div x-show="results.length" x-cloak class="bg-white border border-cn-olive/15 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto">
              <template x-for="p in results" :key="p.id">
                <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-cn-creamDark">
                  <img :src="p.image_url" class="w-10 h-10 object-cover">
                  <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate" x-text="p.name"></div>
                    <div class="text-xs font-bold text-cn-olive" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                  </div>
                </a>
              </template>
            </div>
          </form>
        </div>
        <a href="{{ $cnClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex text-cn-inkSoft hover:text-cn-olive">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex text-cn-inkSoft hover:text-cn-olive relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
        </a>
        <a href="{{ route('store.cart') }}" class="flex text-cn-inkSoft hover:text-cn-olive relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-2 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-cn-olive text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('cn-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-cn-olive" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Category icon strip --}}
  <div class="hidden md:block border-t border-cn-olive/10">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-center gap-10 py-2.5">
      @foreach($cnIcons as $label => $path)
        <a href="{{ route('store.shop') }}" class="flex items-center gap-1.5 text-cn-inkSoft hover:text-cn-olive shrink-0">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="{{ $path }}"/></svg>
          <span class="text-xs font-medium whitespace-nowrap">{{ $label }}</span>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Mobile menu --}}
  <div id="cn-mobile-menu" class="hidden lg:hidden border-t border-cn-olive/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-3 border border-cn-olive/20 bg-cn-cream text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-cn-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-cn-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-cn-ink">{{ __('messages.Shop') }}</a>
      @foreach($cnNavRooms as $room)
        @if($cnSubcatId($room))
          <a href="{{ route('store.shop', ['sub_category' => $cnSubcatId($room)]) }}" class="block py-2 text-sm text-cn-inkSoft border-t border-cn-olive/10">{{ $room }}</a>
        @endif
      @endforeach
    </div>
  </div>
</header>
