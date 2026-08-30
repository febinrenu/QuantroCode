@php
  $trClient = Auth::guard('store')->user();
  $trCategories = $categories ?? collect();
@endphp
<div class="bg-terra-bg text-terra-inkSoft text-xs border-b border-terra-line">
  <div class="max-w-6xl mx-auto px-6 flex items-center justify-between h-9">
    <span class="truncate tracking-wide">{{ $s->topbar_text_left ?? 'Free shipping over $99' }}</span>
    <div class="hidden md:flex items-center gap-5">
      <a href="{{ route('store.contact') }}" class="hover:text-terra-slate">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-terra-bg/95 backdrop-blur border-b border-terra-line">
  <div class="max-w-6xl mx-auto px-6">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-8 max-w-[140px] object-contain">
        @else
          <span class="font-heading font-light text-2xl tracking-tight text-terra-ink">{{ $s->store_name ?? 'Terraco' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 ms-4">
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-sm text-terra-inkSoft hover:text-terra-ink">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-sm text-terra-inkSoft hover:text-terra-ink">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-sm text-terra-inkSoft hover:text-terra-ink">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-sm ms-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-0 top-1/2 -translate-y-1/2 text-terra-inkSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-6 pr-2 bg-transparent border-b border-terra-line text-sm focus:outline-none focus:border-terra-slate"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-terra-surface border border-terra-line overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-terra-bg border-b border-terra-line last:border-b-0">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm truncate" x-text="p.name"></div>
                  <div class="text-xs font-medium text-terra-slate" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto md:ms-0 flex items-center gap-1">
        @if($trClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-sm text-terra-inkSoft hover:text-terra-ink">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($trClient->username ?: $trClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center text-sm text-terra-inkSoft hover:text-terra-ink border border-terra-line">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 border border-terra-slate text-terra-slate text-sm font-medium hover:bg-terra-slate hover:text-white transition-colors">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-2 -right-2 min-w-[18px] h-[18px] px-1 rounded-full bg-terra-slate text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center" onclick="document.getElementById('tr-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $trCategories->count())
      <div class="hidden lg:block border-t border-terra-line">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-6 py-3 overflow-x-auto">
          @foreach($trCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="text-xs tracking-wide text-terra-inkSoft hover:text-terra-slate">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="tr-mobile-menu" class="hidden lg:hidden border-t border-terra-line bg-terra-bg max-h-[70vh] overflow-y-auto">
    <div class="px-6 py-4">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-4">
        <input type="text" name="q" class="w-full h-10 px-0 bg-transparent border-b border-terra-line text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search…' }}">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2.5 text-sm text-terra-ink border-b border-terra-line">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2.5 text-sm text-terra-ink border-b border-terra-line">{{ __('messages.Shop') }}</a>
      @foreach($trCategories as $cat)
        <details class="border-b border-terra-line py-1">
          <summary class="flex items-center justify-between py-2 text-sm text-terra-inkSoft">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-terra-inkSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-terra-slate">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-terra-inkSoft">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
