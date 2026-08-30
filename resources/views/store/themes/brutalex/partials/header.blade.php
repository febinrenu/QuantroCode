@php
  $bxClient = Auth::guard('store')->user();
  $bxCategories = $categories ?? collect();
@endphp
<div class="bg-ink-black text-white text-xs font-mono border-b-4 border-ink-black overflow-hidden">
  <div class="whitespace-nowrap py-1.5">
    <div class="inline-block bx-marquee">
      @for($i = 0; $i < 2; $i++)
        <span class="px-6 uppercase tracking-widest">{{ $s->topbar_text_left ?? 'NO FLUFF. JUST THE GOODS.' }}</span>
        <span class="px-6 text-ink-red">/</span>
        <span class="px-6 uppercase tracking-widest">{{ $s->topbar_text_right ?? 'FREE SHIPPING OVER $99 — NO GAMES' }}</span>
        <span class="px-6 text-ink-red">/</span>
      @endfor
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b-4 border-ink-black">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-20 border-b-4 border-ink-black">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[150px] object-contain">
        @else
          <span class="bx-head text-2xl text-ink-black">{{ $s->store_name ?? 'BRUTALEX' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-0 h-full relative border-x-4 border-ink-black divide-x-4 divide-ink-black">
        <div class="group relative h-full">
          <button type="button" class="px-4 h-full inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wide text-ink-black hover:bg-ink-black hover:text-white transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="square" d="M4 6h16M4 12h16M4 18h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($bxCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 z-30 w-[600px] grid-cols-2 bg-white border-4 border-ink-black divide-x-4 divide-y-4 divide-ink-black bx-shadow">
              @foreach($bxCategories as $cat)
                <div class="p-4">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold uppercase text-ink-black hover:text-ink-red">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-2 space-y-1">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs font-mono text-ink-black/60 hover:text-ink-red">— {{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-4 h-full inline-flex items-center text-sm font-bold uppercase tracking-wide text-ink-black hover:bg-ink-black hover:text-white transition-colors">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-4 h-full inline-flex items-center text-sm font-bold uppercase tracking-wide text-ink-black hover:bg-ink-black hover:text-white transition-colors">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-4 h-full inline-flex items-center text-sm font-bold uppercase tracking-wide text-ink-red hover:bg-ink-black hover:text-white transition-colors">{{ __('messages.Deals') ?? 'Cheap Stuff' }}</a>
        <a href="{{ route('store.contact') }}" class="px-4 h-full inline-flex items-center text-sm font-bold uppercase tracking-wide text-ink-black hover:bg-ink-black hover:text-white transition-colors">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-ink-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="11" cy="11" r="7"/><path stroke-linecap="square" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-11 pl-10 pr-3 border-4 border-ink-black bg-white text-sm font-mono focus:outline-none focus:bg-ink-fog"
                 placeholder="{{ __('messages.SearchProducts') ?? 'SEARCH THE CATALOG…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border-4 border-ink-black bx-shadow overflow-hidden max-h-96 overflow-y-auto z-50 divide-y-4 divide-ink-black">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-ink-fog">
                <img :src="p.image_url" class="w-10 h-10 object-cover border-2 border-ink-black">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-bold truncate bx-copy" x-text="p.name"></div>
                  <div class="text-xs font-mono font-bold text-ink-red" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-0 h-full border-l-4 border-ink-black divide-x-4 divide-ink-black">
        @if($bxClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-full px-3 items-center gap-1.5 text-xs font-bold uppercase text-ink-black hover:bg-ink-black hover:text-white transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($bxClient->username ?: $bxClient->email, 10) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-full px-4 items-center text-xs font-bold uppercase text-ink-black hover:bg-ink-black hover:text-white transition-colors">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-full px-4 inline-flex items-center gap-1.5 bg-ink-red text-white text-xs font-bold uppercase hover:bg-ink-black transition-colors">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-2 -right-2 min-w-[22px] h-[22px] px-1 border-2 border-white bg-ink-black text-white text-[11px] font-mono font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-full w-14 inline-flex items-center justify-center hover:bg-ink-black hover:text-white" onclick="document.getElementById('bx-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="square" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $bxCategories->count())
      <div class="hidden lg:block border-b-4 border-ink-black">
        <ul class="no-scrollbar flex flex-nowrap items-stretch overflow-x-auto divide-x-4 divide-ink-black">
          @foreach($bxCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-4 h-9 inline-flex items-center text-xs font-bold uppercase tracking-wide text-ink-black hover:bg-ink-red hover:text-white transition-colors">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="bx-mobile-menu" class="hidden lg:hidden border-b-4 border-ink-black bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 pl-3 pr-3 border-4 border-ink-black bg-white text-sm font-mono" placeholder="{{ __('messages.SearchProducts') ?? 'SEARCH…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold uppercase border-b-2 border-ink-black">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold uppercase border-b-2 border-ink-black">{{ __('messages.Shop') }}</a>
      @foreach($bxCategories as $cat)
        <details class="border-b-2 border-ink-black py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-bold uppercase">
            {{ $cat->name }}
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="square" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm font-bold text-ink-red uppercase">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm font-mono text-ink-black/70">— {{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
