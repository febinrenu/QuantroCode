@php
  $znClient = Auth::guard('store')->user();
  $znCategories = $categories ?? collect();
  $znDeals = [
    '⚡ Flash sale — up to 40% off audio & wearables',
    '🛰️ New arrivals drop every Friday',
    '💜 Free shipping on orders over $99',
    '🧴 Beauty edit: buy 2 get 1 free',
    '🛒 Grocery essentials restocked daily',
    '👟 Sportswear clearance — while stock lasts',
  ];
@endphp
<div class="bg-zn-bg text-zn-mist text-xs border-b border-white/5">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate">{{ $s->topbar_text_left ?? '🚀 Shop the future — new drops daily' }}</span>
    <div class="hidden md:flex items-center gap-4">
      <span>{{ $s->topbar_text_right ?? '📡 Track your order in real time' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-zn-cyan transition-colors">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

{{-- ===== MARQUEE DEALS TICKER ===== --}}
<div class="relative bg-gradient-to-r from-zn-violetDark via-zn-violet to-zn-cyan overflow-hidden">
  <div class="zn-marquee-track py-1.5">
    @for($r = 0; $r < 2; $r++)
      <div class="flex items-center shrink-0">
        @foreach($znDeals as $deal)
          <span class="mx-6 text-[11px] sm:text-xs font-semibold text-white/95 tracking-wide whitespace-nowrap">{{ $deal }}</span>
          <span class="text-white/40">•</span>
        @endforeach
      </div>
    @endfor
  </div>
</div>

<header class="sticky top-0 z-40 bg-zn-bg/90 backdrop-blur-md border-b border-violet-500/20">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-heading font-bold text-xl tracking-tight text-gradient">{{ $s->store_name ?? 'Zanova' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-1 text-sm font-semibold text-slate-200 hover:text-zn-cyan rounded-md transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($znCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-2 z-30 w-[560px] grid-cols-2 gap-x-6 gap-y-1 bg-zn-surface border border-violet-500/25 rounded-xl shadow-glowLg p-5">
              @foreach($znCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold text-slate-100 hover:text-zn-cyan transition-colors">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-zn-mist hover:text-zn-cyan transition-colors">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-zn-mist hover:text-zn-cyan transition-colors">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-zn-mist hover:text-zn-cyan transition-colors">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-zn-mist hover:text-zn-cyan transition-colors">{{ __('messages.Deals') ?? 'Deals' }}</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-zn-mist hover:text-zn-cyan transition-colors">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-zn-mist" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-10 pr-3 rounded-lg border border-violet-500/20 bg-zn-surface text-sm text-slate-100 placeholder-zn-mist focus:outline-none focus:ring-2 focus:ring-zn-cyan/50 focus:border-zn-cyan/50"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-zn-surface border border-violet-500/25 rounded-lg shadow-glowLg overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-white/5">
                <img :src="p.image_url" class="w-10 h-10 rounded object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate text-slate-100" x-text="p.name"></div>
                  <div class="text-xs font-bold text-zn-cyan" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-1">
        @if($znClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-sm font-medium text-zn-mist hover:text-zn-cyan transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($znClient->username ?: $znClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center rounded-lg text-sm font-semibold text-zn-cyan border border-zn-cyan/30 hover:bg-zn-cyan/10 transition-colors">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="btn-glass relative h-10 px-4 inline-flex items-center gap-1.5 rounded-lg text-white text-sm font-semibold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-zn-pink text-white text-[11px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center rounded-lg hover:bg-white/5 text-slate-200" onclick="document.getElementById('zn-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $znCategories->count())
      <div class="hidden lg:block border-t border-white/5">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2 overflow-x-auto">
          @foreach($znCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-xs font-medium text-zn-mist hover:text-zn-cyan hover:bg-white/5 rounded-md transition-colors">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="zn-mobile-menu" class="hidden lg:hidden border-t border-white/5 bg-zn-surface max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 rounded-lg border border-violet-500/20 bg-zn-bg text-sm text-slate-100 placeholder-zn-mist" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-slate-100">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-slate-100">{{ __('messages.Shop') }}</a>
      @foreach($znCategories as $cat)
        <details class="border-t border-white/5 py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-slate-300">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-zn-mist" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-zn-cyan">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-zn-mist">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
