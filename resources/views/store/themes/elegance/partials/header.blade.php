@php
  $elClient = Auth::guard('store')->user();
  $elCategories = $categories ?? collect();
@endphp
<div class="bg-brand-charcoal text-brand-cream/80 text-xs">
  <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-9">
    <span class="truncate el-caption">{{ $s->topbar_text_left ?? 'Complimentary shipping on orders over $99' }}</span>
    <div class="hidden md:flex items-center gap-5">
      <span class="tracking-wide">{{ $s->topbar_text_right ?? 'New arrivals, weekly' }}</span>
      <a href="{{ route('store.contact') }}" class="hover:text-brand-gold">{{ __('messages.Support') }}</a>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-brand-cream/95 backdrop-blur border-b border-brand-hairline">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex items-center gap-2 shrink-0">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[150px] object-contain">
        @else
          <span class="font-serif text-2xl tracking-tight text-brand-charcoal">{{ $s->store_name ?? 'Elegance' }}</span>
        @endif
      </a>

      <nav class="hidden lg:flex items-center gap-1 relative ms-6">
        <div class="group relative">
          <button type="button" class="px-3 h-10 inline-flex items-center gap-1.5 text-xs eyebrow font-semibold text-brand-charcoal hover:text-brand-gold">
            {{ __('messages.Categories') ?? 'Categories' }}
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </button>
          @if($elCategories->count())
            <div class="hidden group-hover:grid absolute top-full left-0 pt-3 z-30 w-[560px] grid-cols-2 gap-x-8 gap-y-2 bg-brand-cream border border-brand-hairline p-6 shadow-[0_20px_45px_-20px_rgba(42,38,34,0.25)]">
              @foreach($elCategories as $cat)
                <div class="py-1.5">
                  <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="font-serif text-base text-brand-charcoal hover:text-brand-gold">{{ $cat->name }}</a>
                  @if(($cat->subcategories ?? collect())->count())
                    <ul class="mt-1.5 space-y-1">
                      @foreach($cat->subcategories->take(4) as $sub)
                        <li><a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="text-xs text-brand-charcoalSoft hover:text-brand-gold">{{ $sub->name }}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
        <a href="{{ route('store.index') }}" class="px-3 h-10 inline-flex items-center text-xs eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">{{ __('messages.Home') }}</a>
        <a href="{{ route('store.shop') }}" class="px-3 h-10 inline-flex items-center text-xs eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">{{ __('messages.Shop') }}</a>
        <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-3 h-10 inline-flex items-center text-xs eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">{{ __('messages.Deals') ?? 'Edit' }}</a>
        <a href="{{ route('store.contact') }}" class="px-3 h-10 inline-flex items-center text-xs eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">{{ __('messages.Support') }}</a>
      </nav>

      <div class="hidden md:flex flex-1 max-w-md ms-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          <svg class="w-4 h-4 absolute left-0 top-1/2 -translate-y-1/2 text-brand-charcoalSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="q" class="w-full h-10 pl-7 pr-2 bg-transparent border-b border-brand-hairline text-sm focus:outline-none focus:border-brand-gold placeholder:text-brand-charcoalSoft/70"
                 placeholder="Search the collection…" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-brand-cream border border-brand-hairline overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-brand-paper">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm truncate" x-text="p.name"></div>
                  <div class="text-xs font-semibold text-brand-gold" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="flex items-center gap-1 ms-2">
        <div class="hidden md:block">
          @include('store.partials.language-switcher')
        </div>
        @if($elClient)
          <a href="{{ url('/online_store/account') }}" class="hidden md:inline-flex h-10 px-3 items-center gap-1.5 text-xs eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
            {{ \Illuminate\Support\Str::limit($elClient->username ?: $elClient->email, 12) }}
          </a>
        @else
          <a href="{{ url('/online_store/login') }}" class="hidden md:inline-flex h-10 px-4 items-center text-xs eyebrow font-semibold text-brand-charcoal border border-brand-charcoal hover:bg-brand-charcoal hover:text-brand-cream transition-colors">{{ __('messages.SignIn') }}</a>
        @endif
        <a href="{{ route('store.cart') }}" class="relative h-10 px-4 inline-flex items-center gap-1.5 text-xs eyebrow font-semibold text-brand-charcoal hover:text-brand-gold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="hidden sm:inline">{{ __('messages.Cart') }}</span>
          <span class="cart-count absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-brand-gold text-brand-cream text-[10px] font-bold inline-flex items-center justify-center">0</span>
        </a>
        <button type="button" class="lg:hidden h-10 w-10 inline-flex items-center justify-center" onclick="document.getElementById('el-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>

    @if(($showCategoryBar ?? true) && $elCategories->count())
      <div class="hidden lg:block border-t border-brand-hairline">
        <ul class="no-scrollbar flex flex-nowrap items-center gap-1 py-2.5 overflow-x-auto">
          @foreach($elCategories as $cat)
            <li class="shrink-0">
              <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="px-3 h-8 inline-flex items-center text-[11px] eyebrow font-medium text-brand-charcoalSoft hover:text-brand-gold">{{ $cat->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  {{-- Mobile menu --}}
  <div id="el-mobile-menu" class="hidden lg:hidden border-t border-brand-hairline bg-brand-cream max-h-[70vh] overflow-y-auto">
    <div class="px-6 py-4">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-4">
        <input type="text" name="q" class="w-full h-10 pl-3 pr-3 bg-transparent border-b border-brand-hairline text-sm" placeholder="Search the collection…">
      </form>
      <a href="{{ route('store.index') }}" class="block py-2.5 font-serif text-lg text-brand-charcoal border-b border-brand-hairline">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2.5 font-serif text-lg text-brand-charcoal border-b border-brand-hairline">{{ __('messages.Shop') }}</a>
      <div class="text-xs eyebrow font-semibold text-brand-charcoalSoft mt-4 mb-2">{{ __('messages.Language') ?? 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      @foreach($elCategories as $cat)
        <details class="border-b border-brand-hairline py-1">
          <summary class="flex items-center justify-between py-2.5 text-sm font-medium text-brand-charcoal">
            {{ $cat->name }}
            <svg class="w-4 h-4 text-brand-charcoalSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
          </summary>
          <div class="pl-3 pb-2 space-y-1">
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-1 text-sm text-brand-gold">{{ __('messages.ViewAll') ?? 'View all' }}</a>
            @foreach($cat->subcategories ?? [] as $sub)
              <a href="{{ route('store.shop', ['category' => $cat->id, 'sub_category' => $sub->id]) }}" class="block py-1 text-sm text-brand-charcoalSoft">{{ $sub->name }}</a>
            @endforeach
          </div>
        </details>
      @endforeach
    </div>
  </div>
</header>
