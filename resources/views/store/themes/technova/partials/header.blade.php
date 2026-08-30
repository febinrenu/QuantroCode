@php
  $tnClient = Auth::guard('store')->user();
  $tnCategories = $categories ?? collect();
@endphp
<div class="bg-black text-tn-green text-xs border-b border-tn-border">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate tn-bracket">{{ $s->topbar_text_left ?? 'root@store:~$ free_shipping --over 99' }}</span>
    <div class="hidden md:flex items-center gap-4">
      <span class="text-tn-amber">{{ $s->topbar_text_right ?? '// new stock pushed daily' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-white">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-tn-bg/95 backdrop-blur border-b border-tn-border">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-bold text-lg tracking-tight text-tn-green">
            <span class="text-tn-mute">&gt;</span>{{ $s->store_name ?? 'technova' }}<span class="tn-cursor"></span>
          </span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-1.5 text-sm font-medium text-tn-ink hover:text-tn-green">
            <span class="text-tn-green">[</span>menu<span class="text-tn-green">]</span>
          </button>
          @if($tnCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-2 z-30 w-[560px] grid-cols-2 gap-x-6 gap-y-1 bg-tn-panel border border-tn-border p-5 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.8)]">
              @foreach($tnCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-semibold text-tn-green hover:text-white">./{{ str($cat->name)->slug() }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-tn-mute hover:text-tn-amber">-- {{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-sm text-tn-mute hover:text-tn-green">~/home</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-sm text-tn-mute hover:text-tn-green">~/shop</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center text-sm text-tn-mute hover:text-tn-amber">~/deals</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-sm text-tn-mute hover:text-tn-green">~/support</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-tn-green text-sm font-bold pointer-events-none">$</span>
          <input type="text" name="q" class="w-full h-10 pl-7 pr-3 border border-tn-border bg-tn-panel text-sm text-tn-ink placeholder-tn-mute focus:outline-none focus:border-tn-green"
                 placeholder="search products…" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-tn-panel border border-tn-border overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-tn-panel2 border-b border-tn-border">
                <img :src="p.image_url" class="w-10 h-10 object-cover border border-tn-border">
                <div class="flex-1 min-w-0">
                  <div class="text-sm text-tn-ink truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-tn-amber" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-1">
        @if($tnClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-sm text-tn-mute hover:text-tn-green">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($tnClient->username ?: $tnClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center border border-tn-green/50 text-sm font-semibold text-tn-green hover:bg-tn-green/10">sign_in</a>
        @endif
        <a href="{{ route('store.cart') }}" class="tn-glow-btn relative h-10 px-4 inline-flex items-center gap-1.5 border border-tn-green bg-tn-green text-black text-sm font-bold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">cart</span>
          <span class="cart-count absolute -top-2 -right-2 min-w-[20px] h-5 px-1 rounded-full bg-tn-amber text-black text-[11px] font-bold inline-flex items-center justify-center border border-black">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center border border-tn-border text-tn-green" onclick="document.getElementById('tn-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $tnCategories->count())
      <div class="hidden lg:block border-t border-tn-border">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2 overflow-x-auto">
          @foreach($tnCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-xs text-tn-mute hover:text-tn-green hover:bg-tn-panel">./{{ str($cat->name)->slug() }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="tn-mobile-menu" class="hidden lg:hidden border-t border-tn-border bg-tn-bg max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 border border-tn-border bg-tn-panel text-sm text-tn-ink placeholder-tn-mute" placeholder="$ search products…">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-tn-green">~/home</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-tn-green">~/shop</a>
      @foreach($tnCategories as $cat)
        <details class="border-t border-tn-border py-1">
          <summary class="flex items-center justify-between py-2 text-sm text-tn-ink">
            ./{{ str($cat->name)->slug() }}
            <svg class="w-4 h-4 text-tn-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-tn-green">view all</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-tn-mute">-- {{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
