@php
  $ljClient = Auth::guard('store')->user();
  $ljCategories = $categories ?? collect();
  $ljSubcats = optional($ljCategories->first())->subcategories ?? collect();
  $ljSubIcons = [
    'Baby Gear' => 'M4 19h16 M6 19V9l6-4 6 4v10',
    'Toys & Games' => 'M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z',
    'Clothing' => 'M7 4 3 7l3 3 2-2v12h8V8l2 2 3-3-4-3h-2a2 2 0 0 1-4 0H7Z',
    'Nursery' => 'M12 2c-4 3-7 6-7 10a7 7 0 0 0 14 0c0-4-3-7-7-10Z',
    'Feeding' => 'M8 2v6a4 4 0 0 0 8 0V2 M12 12v10',
    'Bath & Care' => 'M4 12h16 M6 12V6a6 6 0 0 1 12 0v6 M6 16h.01 M10 16h.01 M14 16h.01 M18 16h.01',
    'Books' => 'M4 4h11a2 2 0 0 1 2 2v14H6a2 2 0 0 1-2-2V4Z M17 6h3v14h-3',
  ];
@endphp
<div class="bg-lj-lavender text-lj-ink text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4">
    <span class="hidden sm:inline-flex items-center gap-1.5 font-semibold">
      <svg class="w-3.5 h-3.5 text-lj-pink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6 M2 7h20v5H2z M12 22V7 M7.5 7A2.5 2.5 0 1 1 10 4.5 2.5 2.5 0 0 1 12 7a2.5 2.5 0 1 1 2.5-2.5A2.5 2.5 0 0 1 14 7"/></svg>
      {{ $s->topbar_text_left ?? 'Welcome Offer! Get 15% OFF on your first order' }}
      <span class="px-2.5 py-0.5 rounded-full bg-lj-gold text-lj-ink font-bold">{{ 'Use Code: HELLO15' }}</span>
    </span>
    <span class="flex items-center gap-4 whitespace-nowrap ms-auto">
      <a href="{{ url('/online_store/account/orders') }}" class="hover:text-lj-purple hidden sm:inline">{{ 'Track Order' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-lj-purple hidden sm:inline">{{ 'Help Center' }}</a>
      <span class="text-lj-inkSoft">{{ $s->currency_code ?? 'USD' }}</span>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-lj-ink/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <button type="button" class="hidden lg:inline-flex h-9 w-9 items-center justify-center text-lj-ink" onclick="document.getElementById('lj-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
      <a href="{{ route('store.index') }}" class="flex flex-col shrink-0 leading-none">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[190px] object-contain">
        @else
          <span class="font-heading font-extrabold text-2xl uppercase lj-rainbow">
            @foreach(str_split($s->store_name ?? 'LittleJoy') as $ch)<span>{{ $ch }}</span>@endforeach
          </span>
          <span class="text-[11px] text-lj-inkSoft mt-0.5">{{ 'for happy little ones' }}</span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-lj-ink/15 rounded-full overflow-hidden">
          <input type="text" name="q" class="flex-1 h-11 px-5 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for toys, baby gear, clothing...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-11 h-11 my-0.5 me-0.5 rounded-full inline-flex items-center justify-center bg-lj-purple text-white hover:bg-lj-purpleDeep">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-lj-ink/15 rounded-xl shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-lj-cream">
                <img :src="p.image_url" class="w-10 h-10 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-lj-purple" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-5">
        <a href="{{ $ljClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-lj-ink hover:text-lj-purple">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-lj-ink hover:text-lj-purple relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-lj-pink text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-lj-ink hover:text-lj-purple relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-lj-pink text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="lg:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('lj-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-lj-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="hidden md:flex items-center gap-1 h-12 border-t border-lj-ink/10">
    <div class="max-w-7xl mx-auto px-4 w-full flex items-center gap-1">
      <a href="{{ route('store.index') }}" class="px-3.5 h-8 inline-flex items-center gap-1.5 text-sm font-semibold text-lj-purple border-b-2 border-lj-purple">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
        {{ __('messages.Home') }}
      </a>
      @foreach($ljSubcats as $sub)
        <a href="{{ route('store.shop', ['sub_category' => $sub->id]) }}" class="px-3.5 h-8 inline-flex items-center gap-1.5 text-sm font-medium text-lj-ink hover:text-lj-purple">
          @if(isset($ljSubIcons[$sub->name]))
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="{{ $ljSubIcons[$sub->name] }}"/></svg>
          @endif
          {{ $sub->name }}
        </a>
      @endforeach
      <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="ms-auto h-8 px-4 inline-flex items-center gap-1.5 rounded-full bg-lj-pink/10 text-lj-pink text-sm font-bold hover:bg-lj-pink hover:text-white">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z"/></svg>
        {{ 'Deals' }}
      </a>
    </div>
  </nav>

  {{-- Mobile menu --}}
  <div id="lj-mobile-menu" class="hidden border-t border-lj-ink/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-4 border border-lj-ink/15 bg-lj-cream text-sm rounded-full" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-lj-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-lj-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-lj-ink">{{ __('messages.Shop') }}</a>
      @foreach($ljSubcats as $sub)
        <a href="{{ route('store.shop', ['sub_category' => $sub->id]) }}" class="block py-2 text-sm text-lj-inkSoft border-t border-lj-ink/10">{{ $sub->name }}</a>
      @endforeach
    </div>
  </div>
</header>
