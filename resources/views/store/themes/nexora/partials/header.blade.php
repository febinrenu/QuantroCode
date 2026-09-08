@php
  $nxClient = Auth::guard('store')->user();
  $nxCategories = $categories ?? collect();
@endphp
<div class="nx-holo-bg text-white text-xs font-semibold">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate">{{ $s->topbar_text_left ?? '✨ Free shipping on orders over $99' }}</span>
    <div class="hidden md:flex items-center gap-4">
      <span>{{ $s->topbar_text_right ?? '🛸 New drops daily' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:underline">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-nx-chrome1 shadow-card">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-black text-xl tracking-tight nx-holo-text">{{ $s->store_name ?? 'nexora' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-4 h-10 nx-pill inline-flex items-center gap-1 text-sm font-semibold text-nx-ink hover:bg-nx-chrome1/40">
            Categories
          </button>
          @if($nxCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-2 z-30 w-[560px] grid-cols-2 gap-x-6 gap-y-1 bg-white border border-nx-chrome1 rounded-3xl shadow-cardHover p-5">
              @foreach($nxCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold text-nx-ink hover:text-nx-pink">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-nx-mute hover:text-nx-violet">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-4 h-10 nx-pill inline-flex items-center text-sm font-medium text-nx-mute hover:bg-nx-chrome1/40">Home</a>
        <a href="{{ route('store.shop') }}" class="px-4 h-10 nx-pill inline-flex items-center text-sm font-medium text-nx-mute hover:bg-nx-chrome1/40">Shop</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-4 h-10 nx-pill inline-flex items-center text-sm font-medium text-nx-mute hover:bg-nx-chrome1/40">Deals</a>
        <a href="{{ route('store.contact') }}" class="px-4 h-10 nx-pill inline-flex items-center text-sm font-medium text-nx-mute hover:bg-nx-chrome1/40">Support</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-nx-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-11 pl-10 pr-4 nx-pill border border-nx-chrome1 bg-nx-bg text-sm focus:outline-none focus:ring-2 focus:ring-nx-pink/40"
                 placeholder="Search products…" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-nx-chrome1 rounded-3xl shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-4 py-2 hover:bg-nx-bg">
                <img :src="p.image_url" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-nx-pink" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-2">
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($nxClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-11 px-4 items-center gap-1.5 nx-pill text-sm font-semibold text-nx-ink hover:bg-nx-chrome1/40">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($nxClient->username ?: $nxClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-11 px-5 items-center nx-pill text-sm font-bold text-white nx-holo-bg nx-shine">Sign In</a>
        @endif
        <a href="{{ route('store.cart') }}" class="nx-shine relative h-11 px-5 inline-flex items-center gap-1.5 nx-pill nx-chrome text-nx-ink text-sm font-bold border border-nx-chrome1 shadow-card">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">Cart</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full nx-holo-bg text-white text-[11px] font-bold inline-flex items-center justify-center border-2 border-white">0</span>
        </a>
        <button type="button" class="lg:hidden h-11 w-11 inline-flex items-center justify-center nx-pill hover:bg-nx-chrome1/40" onclick="document.getElementById('nx-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $nxCategories->count())
      <div class="hidden lg:block border-t border-nx-chrome1/60">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-2 py-2.5 overflow-x-auto">
          @foreach($nxCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-4 h-8 nx-pill inline-flex items-center text-xs font-semibold text-nx-mute hover:text-white hover:nx-holo-bg border border-nx-chrome1">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="nx-mobile-menu" class="hidden lg:hidden border-t border-nx-chrome1 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 pl-4 pr-3 nx-pill border border-nx-chrome1 bg-nx-bg text-sm" placeholder="Search products…">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-nx-mute mt-1 mb-2">Language</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-nx-ink mt-2">Home</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-nx-ink">Shop</a>
      @foreach($nxCategories as $cat)
        <details class="border-t border-nx-chrome1/60 py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-nx-ink">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-nx-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-nx-pink">View all</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-nx-mute">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
