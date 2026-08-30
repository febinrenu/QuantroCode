@php
  $cnClient = Auth::guard('store')->user();
  $cnCategories = $categories ?? collect();
@endphp
<div class="bg-cn-emeraldDark text-cn-goldLight text-[11px] eyebrow">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-center h-9 text-center">
    <span class="truncate">{{ $s->topbar_text_left ?? 'Complimentary shipping on orders over $99' }}</span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-cn-cream/95 backdrop-blur border-b border-cn-gold/30">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-3 items-center h-20">
      {{-- left nav (desktop) --}}
      <nav class="hidden lg:flex items-center gap-6 justify-start">
        <a href="{{ route('store.index') }}" class="text-xs eyebrow font-semibold text-cn-emerald hover:text-cn-gold">Home</a>
        <a href="{{ route('store.shop') }}" class="text-xs eyebrow font-semibold text-cn-emerald hover:text-cn-gold">Shop</a>
        <div class="group relative">
          <button type="button" class="text-xs eyebrow font-semibold text-cn-emerald hover:text-cn-gold">Categories</button>
          @if($cnCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-1/2 -translate-x-1/2 pt-3 z-30 w-[560px] grid-cols-2 gap-x-6 gap-y-1 bg-white border border-cn-gold/40 shadow-cardHover p-6 cn-frame">
              <span class="cn-corner-tr"></span><span class="cn-corner-bl"></span>
              @foreach($cnCategories as $cat)
                <div class="py-1.5 text-center">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="font-display text-lg font-semibold text-cn-emerald hover:text-cn-gold">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-cn-mute hover:text-cn-gold">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </nav>

      {{-- centered logo --}}
      <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center text-center">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[160px] object-contain">
        @else
          <span class="font-display text-2xl font-semibold tracking-wide text-cn-emerald">{{ $s->store_name ?? 'Casanest' }}</span>
          <span class="cn-gold-rule w-16 mt-1"></span>
        @endif
      </a>

      {{-- right actions --}}
      <div class="flex items-center gap-3 justify-end">
        <div class="hidden md:block relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
          <form action="{{ route('store.shop') }}" method="GET" class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-cn-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
            <input type="text" name="q" class="w-40 lg:w-56 h-10 pl-9 pr-3 border border-cn-gold/40 bg-white text-sm focus:outline-none focus:border-cn-gold rounded-none"
                   placeholder="Search the collection…" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
            <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-cn-gold/40 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
              <template x-for="p in results" :key="p.id">
                <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-cn-cream">
                  <img :src="p.image_url" class="w-10 h-10 object-cover">
                  <div class="flex-1 min-w-0">
                    <div class="text-sm truncate" x-text="p.name"></div>
                    <div class="text-xs font-bold text-cn-emerald" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                  </div>
                </a>
              </template>
            </div>
          </form>
        </div>

        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($cnClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 w-10 items-center justify-center text-cn-emerald hover:text-cn-gold" title="{{ $cnClient->username ?: $cnClient->email }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center text-xs eyebrow font-semibold text-cn-emerald border border-cn-emerald hover:bg-cn-emerald hover:text-white">Sign In</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 w-10 inline-flex items-center justify-center text-cn-emerald hover:text-cn-gold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-cn-gold text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center text-cn-emerald" onclick="document.getElementById('cn-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $cnCategories->count())
      <div class="hidden lg:flex justify-center border-t border-cn-gold/20">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-6 py-2.5 overflow-x-auto">
          @foreach($cnCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-[11px] eyebrow text-cn-mute hover:text-cn-gold">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="cn-mobile-menu" class="hidden lg:hidden border-t border-cn-gold/30 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 border border-cn-gold/40 bg-white text-sm" placeholder="Search the collection…">
      </form>
      <div class="text-[11px] eyebrow text-cn-mute mt-1 mb-2 text-center">Language</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-cn-emerald mt-2">Home</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-cn-emerald">Shop</a>
      @foreach($cnCategories as $cat)
        <details class="border-t border-cn-gold/20 py-1">
          <summary class="flex items-center justify-between py-2 text-sm text-cn-ink">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-cn-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-cn-gold">View all</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-cn-mute">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
