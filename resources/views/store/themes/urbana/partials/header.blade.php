@php
  $urClient = Auth::guard('store')->user();
  $urCategories = $categories ?? collect();
@endphp
<div class="bg-brand-blue text-white text-xs">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="truncate">{{ $s->topbar_text_left ?? '🏡 Free shipping on orders over $99 — every category, one cart' }}</span>
    <div class="hidden md:flex items-center gap-4">
      <span>{{ $s->topbar_text_right ?? '💛 New favorites added daily' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-brand-coralLight">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-brand-blueLight">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-4 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-10 max-w-[150px] object-contain rounded-2xl">
        @else
          <span class="font-heading font-bold text-2xl tracking-tight text-brand-blue">{{ $s->store_name ?? 'Urbana' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative">
        <div class="group relative">
          <button type="button" class="px-4 h-11 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-ink hover:text-brand-blue rounded-full hover:bg-brand-blueLight transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            {{ __('messages.Categories') ?? 'Categories' }}
          </button>
          @if($urCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-3 z-30 w-[580px] grid-cols-2 gap-x-6 gap-y-1 bg-white border border-brand-blueLight rounded-3xl shadow-soft p-6">
              @foreach($urCategories as $cat)
                <div class="py-2">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-sm font-bold text-brand-ink hover:text-brand-blue">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1.5 space-y-1">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-brand-sub hover:text-brand-coral">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-4 h-11 inline-flex items-center text-sm font-medium text-brand-ink hover:text-brand-blue rounded-full hover:bg-brand-blueLight transition-colors">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-4 h-11 inline-flex items-center text-sm font-medium text-brand-ink hover:text-brand-blue rounded-full hover:bg-brand-blueLight transition-colors">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-4 h-11 inline-flex items-center text-sm font-medium text-brand-ink hover:text-brand-coral rounded-full hover:bg-brand-coralLight transition-colors">{{ __('messages.Deals') ?? 'Deals' }}</a>
        <a href="{{ route('store.contact') }}" class="px-4 h-11 inline-flex items-center text-sm font-medium text-brand-ink hover:text-brand-blue rounded-full hover:bg-brand-blueLight transition-colors">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-lg mx-2 relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-brand-sub" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-12 pl-11 pr-3 rounded-full border border-brand-blueLight bg-brand-cream text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue/40"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for anything you love…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-brand-blueLight rounded-3xl shadow-soft overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-4 py-3 hover:bg-brand-blueLight">
                <img :src="p.image_url" class="w-11 h-11 rounded-2xl object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-brand-coral" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-1.5">
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($urClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-11 px-3 items-center gap-1.5 text-sm font-medium text-brand-ink hover:text-brand-blue rounded-full hover:bg-brand-blueLight">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($urClient->username ?: $urClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-11 px-5 items-center rounded-full text-sm font-semibold text-brand-blue border-2 border-brand-blue/30 hover:bg-brand-blueLight">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-11 px-5 inline-flex items-center gap-1.5 rounded-full bg-brand-coral text-white text-sm font-semibold shadow-softCoral hover:bg-brand-coralDark transition-colors">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-brand-blue text-white text-[11px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-11 w-11 inline-flex items-center justify-center rounded-full hover:bg-brand-blueLight" onclick="document.getElementById('ur-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $urCategories->count())
      <div class="hidden lg:block border-t border-brand-blueLight">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-2 py-3 overflow-x-auto">
          @foreach($urCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-4 h-9 inline-flex items-center text-xs font-semibold text-brand-sub hover:text-brand-blue hover:bg-brand-blueLight rounded-full transition-colors">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="ur-mobile-menu" class="hidden lg:hidden border-t border-brand-blueLight bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-4">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-12 pl-4 pr-3 rounded-full border border-brand-blueLight bg-brand-cream text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search for anything you love…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-semibold text-brand-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-semibold text-brand-ink">{{ __('messages.Shop') }}</a>
      <div class="text-xs font-bold uppercase tracking-widest text-brand-sub mt-4 mb-2">{{ __('messages.Language') ?? 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      @foreach($urCategories as $cat)
        <details class="border-t border-brand-blueLight py-1">
          <summary class="flex items-center justify-between py-2 text-sm font-medium text-brand-ink">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-brand-sub" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-brand-blue">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-brand-sub">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
