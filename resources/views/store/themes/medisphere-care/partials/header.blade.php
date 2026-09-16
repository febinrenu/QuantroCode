@php
  $msClient = Auth::guard('store')->user();
  $msCategories = $categories ?? collect();
  $msSubcats = optional($msCategories->first())->subcategories ?? collect();
  $msSubcatId = fn ($name) => optional($msSubcats->firstWhere('name', $name))->id;
@endphp
<div class="bg-ms-tealDeep text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4 overflow-x-auto no-scrollbar">
    <span class="hidden sm:inline-flex items-center gap-1.5 whitespace-nowrap">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
      {{ '24/7 Pharmacist Support' }}
    </span>
    <span class="hidden md:inline-flex items-center gap-1.5 whitespace-nowrap">{{ 'Prescription Refills' }}</span>
    <span class="hidden lg:inline-flex items-center gap-1.5 whitespace-nowrap">{{ 'Same-Day Delivery in Select Areas' }}</span>
    <a href="tel:{{ $s->contact_phone ?? '18001236677' }}" class="ms-auto hover:text-white/80 whitespace-nowrap flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>
      {{ $s->contact_phone ?? '1800-123-6677' }}
    </a>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-ms-teal/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[170px] object-contain">
        @else
          <svg class="w-9 h-9 text-ms-teal shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M12 8v8M8 12h8"/></svg>
          <span class="leading-tight">
            <span class="block font-heading font-extrabold text-xl text-ms-ink">{{ $s->store_name ?? 'MediSphere' }}</span>
            <span class="block text-[10px] font-semibold text-ms-inkSoft -mt-0.5">{{ 'Pharmacy & Wellness' }}</span>
          </span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-ms-teal/25 rounded-lg overflow-hidden bg-white">
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ 'Search medicines, wellness products, devices...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-12 h-11 inline-flex items-center justify-center bg-ms-teal text-white hover:bg-ms-tealDeep">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-ms-teal/15 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-ms-tealLight">
                <img :src="p.image_url" class="w-10 h-10 object-cover rounded">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-ms-teal" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-5">
        <span class="hidden lg:flex flex-col text-[11px] text-ms-inkSoft">
          <span>{{ 'Deliver to' }}</span>
          <span class="font-semibold text-ms-ink flex items-center gap-1">{{ $s->store_zip_code ?? '560001' }} {{ $s->store_city ?? 'Bangalore' }}
            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </span>
        </span>
        <a href="{{ $msClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-ms-inkSoft hover:text-ms-teal">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-ms-inkSoft hover:text-ms-teal relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-ms-inkSoft hover:text-ms-teal relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-ms-red text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="lg:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('ms-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    <nav class="hidden lg:flex items-center gap-1 h-11 border-t border-ms-teal/10">
      <div class="group relative">
        <button type="button" class="h-8 px-3 inline-flex items-center gap-2 text-xs font-semibold text-ms-ink hover:text-ms-teal">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          {{ 'All Categories' }}
          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        @if($msSubcats->count())
          <div class="hidden group-hover:block absolute top-full left-0 pt-0 z-30 min-w-[220px] bg-white border border-ms-teal/15 shadow-cardHover">
            @foreach($msSubcats as $sc)
              <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block px-4 py-2 text-sm text-ms-ink hover:bg-ms-tealLight hover:text-ms-teal">{{ $sc->name }}</a>
            @endforeach
          </div>
        @endif
      </div>
      @foreach(['Prescription Medicines', 'Vitamins & Supplements', 'Personal Care', 'Baby Care', 'Medical Devices'] as $item)
        @if($msSubcatId($item))
          <a href="{{ route('store.shop', ['sub_category' => $msSubcatId($item)]) }}" class="px-3 h-8 inline-flex items-center text-xs font-semibold text-ms-ink hover:text-ms-teal whitespace-nowrap">{{ $item }}</a>
        @endif
      @endforeach
      <a href="{{ route('store.shop') }}" class="px-3 h-8 inline-flex items-center gap-1.5 text-xs font-bold text-ms-red whitespace-nowrap">
        {{ 'Deals' }}
        <span class="bg-ms-red text-white text-[9px] font-bold px-1.5 py-0.5 rounded">HOT</span>
      </a>
      <a href="{{ route('store.contact') }}" class="ms-auto h-8 px-4 inline-flex items-center gap-1.5 bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6"/></svg>
        {{ 'Upload Prescription' }}
      </a>
    </nav>
  </div>

  {{-- Mobile menu --}}
  <div id="ms-mobile-menu" class="hidden lg:hidden border-t border-ms-teal/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-4 rounded-lg border border-ms-teal/25 bg-ms-cream text-sm" placeholder="{{ 'Search medicines, wellness products...' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-ms-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-ms-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-ms-ink">{{ __('messages.Shop') }}</a>
      @foreach($msSubcats as $sc)
        <a href="{{ route('store.shop', ['sub_category' => $sc->id]) }}" class="block py-2 text-sm text-ms-inkSoft border-t border-ms-teal/10">{{ $sc->name }}</a>
      @endforeach
    </div>
  </div>
</header>
