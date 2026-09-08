@php
  $vlClient = Auth::guard('store')->user();
  $vlCategories = $categories ?? collect();
@endphp
<div class="bg-black text-white text-[11px] eyebrow">
  <div class="px-4 lg:px-8 flex items-center justify-between h-8">
    <span class="truncate">{{ $s->topbar_text_left ?? 'Free shipping over $99 · every category' }}</span>
    <div class="hidden md:flex items-center gap-5">
      <span class="text-brand-magenta">{{ $s->topbar_text_right ?? 'New drops weekly' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-brand-magenta">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-black text-white border-b-2 border-brand-magenta">
  <div class="px-4 lg:px-8">
    <div class="flex items-center gap-4 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0 mr-2">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-8 max-w-[140px] object-contain">
        @else
          <span class="font-display text-3xl tracking-wide leading-none">{{ $s->store_name ?? 'VOGUELANE' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative ml-4">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest hover:text-brand-magenta">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($vlCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-2 z-30 w-[600px] grid-cols-2 gap-x-6 gap-y-1 bg-black border border-white/10 shadow-2xl p-6">
              @foreach($vlCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold uppercase tracking-wide hover:text-brand-magenta">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-white/50 hover:text-brand-magenta">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-xs font-bold uppercase tracking-widest text-white/70 hover:text-brand-magenta">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-xs font-bold uppercase tracking-widest text-white/70 hover:text-brand-magenta">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center text-xs font-bold uppercase tracking-widest text-white/70 hover:text-brand-magenta">{{ __('messages.Deals') ?? 'Deals' }}</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-xs font-bold uppercase tracking-widest text-white/70 hover:text-brand-magenta">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-md ml-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-white/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-10 pr-3 bg-white/10 border border-white/20 text-sm text-white placeholder-white/40 focus:outline-none focus:border-brand-magenta"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-black border border-white/10 shadow-2xl overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-white/5">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate text-white" x-text="p.name"></div>
                  <div class="text-xs font-bold text-brand-magenta" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-2 flex items-center gap-1">
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($vlClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-white/70 hover:text-brand-magenta">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($vlClient->username ?: $vlClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center text-xs font-bold uppercase tracking-wide text-white border border-white/30 hover:border-brand-magenta hover:text-brand-magenta">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 bg-brand-magenta text-white text-xs font-bold uppercase tracking-wide hover:bg-brand-magentaDark">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-white text-brand-black text-[11px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center hover:bg-white/10" onclick="document.getElementById('vl-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $vlCategories->count())
      <div class="hidden lg:block border-t border-white/10">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2 overflow-x-auto">
          @foreach($vlCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-[11px] font-bold uppercase tracking-widest text-white/50 hover:text-brand-magenta">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="vl-mobile-menu" class="hidden lg:hidden border-t border-white/10 bg-black max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 bg-white/10 border border-white/20 text-sm text-white placeholder-white/40" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-white/40 mt-1 mb-2">{{ __('messages.Language') ?? 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold uppercase tracking-wide mt-2">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold uppercase tracking-wide">{{ __('messages.Shop') }}</a>
      @foreach($vlCategories as $cat)
        <details class="border-t border-white/10 py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-semibold text-white/80">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-white/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-brand-magenta">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-white/50">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
