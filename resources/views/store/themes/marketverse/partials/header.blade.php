@php
  $mvClient = Auth::guard('store')->user();
  $mvCategories = $categories ?? collect();
@endphp
<div class="bg-mv-inkDark text-mv-accentLight text-xs">
  <div class="max-w-[1600px] mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate mv-mono">{{ $s->topbar_text_left ?? 'FREE SHIPPING > $99' }}</span>
    <div class="hidden md:flex items-center gap-4">
      <span class="mv-mono">{{ $s->topbar_text_right ?? 'NEW LISTINGS DAILY' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-white">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/97 backdrop-blur border-b-2 border-mv-ink shadow-tile">
  <div class="max-w-[1600px] mx-auto px-4">
    <div class="flex items-center gap-3 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-black text-xl tracking-tight text-mv-ink">{{ $s->store_name ?? 'MarketVerse' }}<span class="text-mv-accent">.</span></span>
        @endif
      </a>

      <button type="button" class="hidden lg:inline-flex h-10 px-3 items-center gap-2 rounded-md bg-mv-ink text-white text-sm font-bold" onclick="document.getElementById('mv-rail-toggle-note')?.scrollIntoView()">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        {{ __('messages.Categories') ?? 'Categories' }}
      </button>

      <div class="hidden md:flex flex-1 max-w-xl mx-1 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-mv-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-10 pr-3 rounded-md border-2 border-mv-line bg-mv-cream text-sm focus:outline-none focus:ring-2 focus:ring-mv-accent/40 focus:border-mv-accent"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search electronics, fashion, home & more…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border-2 border-mv-line rounded-md shadow-tileHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-mv-accentSoft">
                <img :src="p.image_url" class="w-10 h-10 rounded object-cover border border-mv-line">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-mv-accentDark mv-mono" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <nav class="hidden xl:flex items-center gap-1">
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-sm font-semibold text-mv-ink hover:text-mv-accentDark">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-sm font-semibold text-mv-ink hover:text-mv-accentDark">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center text-sm font-semibold text-mv-ink hover:text-mv-accentDark">{{ __('messages.Deals') ?? 'Deals' }}</a>
      </nav>

      <div class="ms-auto flex items-center gap-1">
        @if($mvClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-sm font-medium text-mv-ink hover:text-mv-accentDark">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($mvClient->username ?: $mvClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center rounded-md text-sm font-bold text-mv-ink border-2 border-mv-ink hover:bg-mv-ink hover:text-white transition-colors">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 rounded-md bg-mv-accent text-white text-sm font-bold hover:bg-mv-accentDark transition-colors">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-mv-ink text-white text-[11px] font-bold inline-flex items-center justify-center mv-mono">0</span>
        </a>
        <button type="button" class="xl:hidden h-10 w-10 inline-flex items-center justify-center rounded-md hover:bg-mv-accentSoft" onclick="document.getElementById('mv-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $mvCategories->count())
      <div class="hidden lg:block border-t border-mv-line">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-1.5 overflow-x-auto">
          @foreach($mvCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-2.5 h-7 inline-flex items-center text-[11px] font-bold uppercase tracking-wide text-mv-slate hover:text-mv-accentDark hover:bg-mv-accentSoft rounded mv-mono">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="mv-mobile-menu" class="hidden xl:hidden border-t border-mv-line bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 rounded-md border-2 border-mv-line bg-mv-cream text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold text-mv-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold text-mv-ink">{{ __('messages.Shop') }}</a>
      @foreach($mvCategories as $cat)
        <details class="border-t border-mv-line py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-semibold text-mv-ink">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-mv-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-mv-accentDark font-semibold">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-mv-slate">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
