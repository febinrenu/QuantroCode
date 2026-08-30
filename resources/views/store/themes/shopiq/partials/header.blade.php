@php
  $iqClient = Auth::guard('store')->user();
  $iqCategories = $categories ?? collect();
@endphp
<div class="bg-brand-ink text-white text-xs">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
      {{ $s->topbar_text_left ?? 'Prices tracked daily so you always get the smart deal' }}
    </span>
    <div class="hidden md:flex items-center gap-4">
      <span>{{ $s->topbar_text_right ?? 'Free shipping over $99 · Rated 4.8/5 by shoppers' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-brand-teal">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-brand-line shadow-card">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-16">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="inline-flex items-center gap-1.5 font-black text-xl tracking-tight text-brand-navy">
            <svg class="w-6 h-6 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
            {{ $s->store_name ?? 'ShopIQ' }}
          </span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-1 text-sm font-semibold text-brand-navy hover:text-brand-teal rounded-md">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($iqCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-2 z-30 w-[560px] grid-cols-2 gap-x-6 gap-y-1 bg-white border border-brand-line rounded-xl shadow-cardHover p-5">
              @foreach($iqCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold text-brand-navy hover:text-brand-teal">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1 space-y-0.5">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-slate-500 hover:text-brand-teal">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-slate-600 hover:text-brand-teal">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-slate-600 hover:text-brand-teal">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-brand-teal">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
          Best Value
        </a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-sm font-medium text-slate-600 hover:text-brand-teal">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-10 pr-3 rounded-lg border border-brand-line bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-teal/40"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-brand-line rounded-lg shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-brand-tealLight">
                <img :src="p.image_url" class="w-10 h-10 rounded object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-brand-teal" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-1">
        @if($iqClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-brand-teal">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($iqClient->username ?: $iqClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center rounded-lg text-sm font-semibold text-brand-teal border border-brand-teal/30 hover:bg-brand-tealLight">{{ __('messages.SignIn') }}</a>
        @endif
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 rounded-lg bg-brand-teal text-white text-sm font-semibold hover:bg-brand-tealDark">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-brand-amber text-white text-[11px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center rounded-lg hover:bg-slate-100" onclick="document.getElementById('iq-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $iqCategories->count())
      <div class="hidden lg:block border-t border-slate-100">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2 overflow-x-auto">
          @foreach($iqCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-xs font-medium text-slate-500 hover:text-brand-teal hover:bg-brand-tealLight rounded-md">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="iq-mobile-menu" class="hidden lg:hidden border-t border-slate-100 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 rounded-lg border border-brand-line bg-slate-50 text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-slate-400 mt-4 mb-2">{{ __('messages.Language') ?? 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-brand-navy">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-brand-navy">{{ __('messages.Shop') }}</a>
      @foreach($iqCategories as $cat)
        <details class="border-t border-slate-100 py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-slate-700">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-brand-teal">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-slate-500">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
