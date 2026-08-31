@php
  $elClient = Auth::guard('store')->user();
  $elCategories = $categories ?? collect();
@endphp
<div class="bg-el-black text-white text-[11px]">
  <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-9">
    <span class="hidden sm:inline-flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5 text-el-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2 15 8.5 22 9.3 17 14.1 18.2 21 12 17.6 5.8 21 7 14.1 2 9.3 9 8.5 12 2Z"/></svg>
      {{ $s->topbar_text_left ?? 'EXTRA 20% OFF ON FIRST ORDER' }} | {{ 'USE CODE:' }} <span class="text-el-gold font-bold">NEW20</span>
    </span>
    <span class="flex items-center gap-4 whitespace-nowrap">
      <a href="{{ route('store.contact') }}" class="hover:text-el-gold hidden sm:inline">{{ 'Store Locator' }}</a>
      <a href="{{ route('store.contact') }}" class="hover:text-el-gold hidden sm:inline">{{ 'Help & FAQs' }}</a>
      <a href="{{ url('/online_store/account/orders') }}" class="hover:text-el-gold hidden sm:inline">{{ 'Returns' }}</a>
      <span class="text-white/60">{{ $s->currency_code ?? 'USD' }}</span>
    </span>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-el-ink/10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center gap-6 h-20">
      <a href="{{ route('store.index') }}" class="flex flex-col shrink-0 leading-none">
        @if(!empty($s->logo_path))
          <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-9 max-w-[190px] object-contain">
        @else
          <span class="font-serif font-bold text-2xl tracking-wide text-el-ink uppercase">{{ $s->store_name ?? 'Élégance' }}</span>
          <span class="eyebrow text-[9px] text-el-inkSoft mt-0.5">{{ 'Timeless Fashion' }}</span>
        @endif
      </a>

      <div class="hidden md:flex flex-1 max-w-xl relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full flex items-stretch border border-el-ink/20">
          <input type="text" name="q" class="flex-1 h-11 px-4 text-sm focus:outline-none bg-transparent"
                 placeholder="{{ __('messages.SearchProducts') ?? 'Search for products, brands and more...' }}" autocomplete="off" value="{{ request('q') }}" x-model="q" @input.debounce.250ms="fetch">
          <button type="submit" class="w-12 h-11 inline-flex items-center justify-center bg-el-black text-white hover:bg-el-ink">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
          </button>
          <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-el-ink/15 shadow-cardHover overflow-hidden max-h-96 overflow-y-auto z-50">
            <template x-for="p in results" :key="p.id">
              <a :href="p.url" class="flex items-center gap-3 px-3 py-2 hover:bg-el-cream">
                <img :src="p.image_url" class="w-10 h-10 object-cover">
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-medium truncate" x-text="p.name"></div>
                  <div class="text-xs font-bold text-el-gold" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
                </div>
              </a>
            </template>
          </div>
        </form>
      </div>

      <div class="ms-auto flex items-center gap-6">
        <a href="{{ $elClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-el-ink hover:text-el-gold">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
          <span class="text-[10px] font-medium">{{ __('messages.Account') ?? 'Account' }}</span>
        </a>
        <a href="{{ url('/online_store/account/wishlist') }}" class="hidden sm:flex flex-col items-center gap-0.5 text-el-ink hover:text-el-gold relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
          <span class="absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-el-black text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ 'Wishlist' }}</span>
        </a>
        <a href="{{ route('store.cart') }}" class="flex flex-col items-center gap-0.5 text-el-ink hover:text-el-gold relative">
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="cart-count absolute -top-1.5 -right-2 min-w-[16px] h-4 px-1 rounded-full bg-el-black text-[9px] font-bold text-white inline-flex items-center justify-center">0</span>
          <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
        </a>
        <button type="button" class="md:hidden h-9 w-9 inline-flex items-center justify-center" onclick="document.getElementById('el-mobile-menu').classList.toggle('hidden')" aria-label="Menu">
          <svg class="w-6 h-6 text-el-ink" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
    </div>
  </div>

  <nav class="hidden md:flex items-center justify-center gap-1 h-11 bg-el-black">
    <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="px-4 h-11 inline-flex items-center text-[11px] font-bold eyebrow text-white hover:text-el-gold">{{ 'New In' }}</a>
    @php $elGroups = [['Women','sort','price_desc'], ['Men','sort','price_asc'], ['Dresses','q','dress'], ['Shoes','q','shoe'], ['Bags','q','bag'], ['Accessories','q','accessor']]; @endphp
    @foreach($elGroups as [$label, $param, $value])
      <a href="{{ route('store.shop', [$param => $value]) }}" class="px-4 h-11 inline-flex items-center text-[11px] font-bold eyebrow text-white hover:text-el-gold">{{ strtoupper($label) }}</a>
    @endforeach
    <a href="{{ route('store.shop') }}" class="px-4 h-11 inline-flex items-center text-[11px] font-bold eyebrow text-white hover:text-el-gold">{{ 'Brands' }}</a>
    <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="px-4 h-11 inline-flex items-center text-[11px] font-bold eyebrow text-el-gold hover:text-white">{{ 'Sale' }}</a>
  </nav>

  {{-- Mobile menu --}}
  <div id="el-mobile-menu" class="hidden md:hidden border-t border-el-ink/10 bg-white max-h-[70vh] overflow-y-auto">
    <div class="px-4 py-3">
      <form action="{{ route('store.shop') }}" method="GET" class="relative mb-3">
        <input type="text" name="q" class="w-full h-11 px-3 border border-el-ink/20 bg-el-cream text-sm" placeholder="{{ __('messages.SearchProducts') ?? 'Search products…' }}">
      </form>
      <div class="text-xs font-bold uppercase tracking-widest text-el-inkSoft mt-4 mb-2">{{ 'Language' }}</div>
      @include('store.partials.language-switcher', ['variant' => 'mobile'])
      <a href="{{ route('store.index') }}" class="block py-2 text-sm font-bold eyebrow text-el-ink">{{ __('messages.Home') }}</a>
      <a href="{{ route('store.shop') }}" class="block py-2 text-sm font-bold eyebrow text-el-ink">{{ __('messages.Shop') }}</a>
      @foreach($elCategories as $cat)
        <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="block py-2 text-sm text-el-inkSoft border-t border-el-ink/10">{{ $cat->name }}</a>
      @endforeach
    </div>
  </div>
</header>
