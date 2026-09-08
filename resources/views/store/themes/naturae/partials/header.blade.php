@php
  $ntClient = Auth::guard('store')->user();
  $ntCategories = $categories ?? collect();
@endphp
<div class="bg-leaf-deep text-cream text-xs">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9 gap-4">
    <span class="truncate flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
      {{ $s->topbar_text_left ?? 'Carbon-neutral shipping on every order' }}
    </span>
    <div class="hidden md:flex items-center gap-4">
      <span>{{ $s->topbar_text_right ?? 'Plastic-free packaging, always' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-terracotta-light">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-cream/95 backdrop-blur border-b border-leaf-light shadow-soft">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-[72px]">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[160px] object-contain">
        @else
          <span class="inline-flex items-center gap-2">
            <svg class="w-8 h-8 text-leaf-dark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9M12 9c0-3 2-5 5-5"/></svg>
            <span class="font-serif font-semibold text-2xl tracking-tight text-leaf-deep">{{ $s->store_name ?? 'Naturae' }}</span>
          </span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-3.5 h-11 inline-flex items-center gap-1.5 text-sm font-semibold text-leaf-deep hover:text-terracotta-dark rounded-full hover:bg-leaf-light/70 transition-colors">
            <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8c2-3 5-5 8-5s6 2 8 5M4 8c1 5 4 9 8 11 4-2 7-6 8-11M4 8h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($ntCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-3 z-30 w-[600px] grid-cols-2 gap-x-7 gap-y-2 bg-white border border-leaf-light rounded-3xl shadow-softHover p-6">
              @foreach($ntCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold text-leaf-deep hover:text-terracotta-dark font-display">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1.5 space-y-1">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-bark/70 hover:text-terracotta-dark">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3.5 h-11 inline-flex items-center text-sm font-medium text-bark/80 hover:text-terracotta-dark rounded-full hover:bg-leaf-light/70 transition-colors">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3.5 h-11 inline-flex items-center text-sm font-medium text-bark/80 hover:text-terracotta-dark rounded-full hover:bg-leaf-light/70 transition-colors">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3.5 h-11 inline-flex items-center text-sm font-medium text-bark/80 hover:text-terracotta-dark rounded-full hover:bg-leaf-light/70 transition-colors">Everyday Value</a>
        <a href="{{ route('store.contact') }}" class="px-3.5 h-11 inline-flex items-center text-sm font-medium text-bark/80 hover:text-terracotta-dark rounded-full hover:bg-leaf-light/70 transition-colors">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-bark/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-11 pl-11 pr-4 rounded-full border border-leaf-light bg-white text-sm focus:outline-none focus:ring-2 focus:ring-leaf/40"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for anything…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-leaf-light rounded-2xl shadow-softHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-4 py-2.5 hover:bg-leaf-light/50">
                <img :src="p.image_url" class="w-10 h-10 rounded-xl object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-terracotta-dark" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-1">
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($ntClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-11 px-3 items-center gap-1.5 text-sm font-medium text-bark/80 hover:text-terracotta-dark">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($ntClient->username ?: $ntClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-11 px-4 items-center rounded-full text-sm font-semibold text-leaf-dark border border-leaf/40 hover:bg-leaf-light">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-11 px-5 inline-flex items-center gap-1.5 rounded-full bg-terracotta text-white text-sm font-semibold hover:bg-terracotta-dark transition-colors">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-leaf-deep text-white text-[11px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-11 w-11 inline-flex items-center justify-center rounded-full hover:bg-leaf-light/70" onclick="document.getElementById('nt-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $ntCategories->count())
      <div class="hidden lg:block border-t border-leaf-light/70">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2.5 overflow-x-auto">
          @foreach($ntCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3.5 h-8 inline-flex items-center text-xs font-medium text-bark/70 hover:text-terracotta-dark hover:bg-terracotta-light/50 rounded-full transition-colors">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="nt-mobile-menu" class="hidden lg:hidden border-t border-leaf-light bg-cream max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-4">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 pl-4 pr-4 rounded-full border border-leaf-light bg-white text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search for anything…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-leaf-deep">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-leaf-deep">{{ __('messages.Shop') }}</a>
      <div class="text-xs font-bold uppercase tracking-wide text-bark/50 mt-4 mb-2">{{ __('messages.Language') ?? 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      @foreach($ntCategories as $cat)
        <details class="border-t border-leaf-light/70 py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-bark">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-bark/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-terracotta-dark">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-bark/70">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
