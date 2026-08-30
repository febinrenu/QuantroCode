@php
  $vlClient = Auth::guard('store')->user();
  $vlCategories = $categories ?? collect();
@endphp
<div class="bg-vel-black text-vel-mute text-[11px] border-b border-vel-line">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate eyebrow tracking-[0.18em]">{{ $s->topbar_text_left ?? 'White-glove service on every order' }}</span>
    <div class="hidden md:flex items-center gap-5">
      <span class="eyebrow tracking-[0.18em]">{{ $s->topbar_text_right ?? 'Insured shipping, worldwide' }}</span>
      <a href="{{ route('store.contact') }}" class="text-vel-gold hover:text-vel-goldSoft">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-vel-black/95 backdrop-blur border-b border-vel-line">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-serif font-bold text-2xl tracking-wide text-vel-ink">{{ $s->store_name ?? 'Veloura' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative ml-6">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-2 text-[13px] font-medium tracking-wide text-vel-ink/90 hover:text-vel-gold">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($vlCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-3 z-30 w-[620px] grid-cols-2 gap-x-8 gap-y-2 bg-vel-charcoal border border-vel-line rounded-none shadow-vlHover p-6">
              @foreach($vlCategories as $cat)
                <div class="py-2 border-b border-vel-line/60">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="font-serif text-[15px] font-semibold text-vel-ink hover:text-vel-gold">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1.5 space-y-1">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-vel-mute hover:text-vel-gold">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-[13px] font-medium text-vel-mute hover:text-vel-gold">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-[13px] font-medium text-vel-mute hover:text-vel-gold">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_desc']) }}" class="px-3 h-10 inline-flex items-center text-[13px] font-medium text-vel-mute hover:text-vel-gold">The Edit</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-[13px] font-medium text-vel-mute hover:text-vel-gold">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-md mx-2 relative ml-auto" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-vel-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-10 pr-3 bg-vel-charcoal border border-vel-line text-sm text-vel-ink placeholder:text-vel-mute focus:outline-none focus:border-vel-gold/60"
                 placeholder="Search the collection…" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-vel-charcoal border border-vel-line shadow-vlHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-vel-black/60">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium text-vel-ink truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-vel-gold" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto md:ms-0 flex items-center gap-1">
        @if($vlClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-[13px] font-medium text-vel-mute hover:text-vel-gold">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($vlClient->username ?: $vlClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center border border-vel-gold/40 text-[13px] font-semibold text-vel-gold hover:bg-vel-gold hover:text-vel-black transition-colors">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 bg-vel-gold text-vel-black text-[13px] font-bold hover:bg-vel-goldSoft transition-colors">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-vel-burgundy text-vel-ink text-[11px] font-bold inline-flex items-center justify-center border border-vel-black">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center text-vel-ink hover:text-vel-gold" onclick="document.getElementById('vl-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $vlCategories->count())
      <div class="hidden lg:block border-t border-vel-line">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2.5 overflow-x-auto">
          @foreach($vlCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-[11px] eyebrow font-medium text-vel-mute hover:text-vel-gold">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="vl-mobile-menu" class="hidden lg:hidden border-t border-vel-line bg-vel-charcoal max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 bg-vel-black border border-vel-line text-sm text-vel-ink" placeholder="Search the collection…">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-vel-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-vel-ink">{{ __('messages.Shop') }}</a>
      @foreach($vlCategories as $cat)
        <details class="border-t border-vel-line py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-vel-ink/90">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-vel-mute" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-vel-gold">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-vel-mute">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
