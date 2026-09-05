@php
  $hlClient = Auth::guard('store')->user();
  $hlCategories = $categories ?? collect();
@endphp
<div class="bg-hl-deep text-white text-xs">
  <div class="max-w-[1440px] mx-auto px-5 flex items-center justify-between h-9 gap-4">
    <span class="truncate flex items-center gap-1.5">
      <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>
      {{ $s->topbar_text_left ?? 'Free Delivery on orders over $99' }}
    </span>
    <div class="hidden md:flex items-center gap-5">
      <span class="flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>
        {{ $s->topbar_text_right ?? '30-Day Easy Returns' }}
      </span>
      <a href="{{ route('store.shop') }}" class="hover:text-hl-goldLight">Stores</a>
      <a href="{{ route('store.shop') }}" class="hover:text-hl-goldLight">Inspiration</a>
      <a href="{{ route('store.contact') }}" class="hover:text-hl-goldLight">Help Center</a>
      @include('store.partials.language-switcher')
      <span>{{ $s->currency_code ?? 'USD' }}</span>
    </div>
  </div>
</div>

<header class="sticky top-0 z-40 bg-white border-b border-hl-line">
  <div class="max-w-[1440px] mx-auto px-5 h-[92px] flex items-center gap-8">
    <a href="{{ route('store.index') }}" class="shrink-0 leading-none">
      @if(!empty($s->logo_path))
        <img src="{{ \Illuminate\Support\Str::startsWith($s->logo_path,['http://','https://','/']) ? $s->logo_path : global_asset($s->logo_path) }}" alt="{{ $s->store_name }}" class="h-11 max-w-[180px] object-contain">
      @else
        <img src="{{ global_asset('images/themes/homeluxe/logo.png') }}" alt="{{ $s->store_name ?? 'HomeLuxe' }}" class="h-9 max-w-[190px] object-contain object-left">
      @endif
    </a>

    <div class="hidden md:flex flex-1 max-w-[560px] mx-auto relative" x-data="searchBox('{{ route('store.search.suggestions') }}')" @click.outside="results = []">
      <form action="{{ route('store.shop') }}" method="get" class="w-full relative">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search for furniture, decor and more…" class="w-full h-11 pl-5 pr-14 rounded-full border border-hl-line bg-white text-xs outline-none focus:ring-2 focus:ring-hl-forest/30" autocomplete="off" x-model="q" @input.debounce.250ms="fetch">
        <button type="submit" aria-label="Search" class="absolute right-1 top-1 w-9 h-9 rounded-full bg-hl-forest text-white grid place-items-center hover:bg-hl-deep transition-colors">
          <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
        </button>
        <div x-show="results.length" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white border border-hl-line rounded-2xl shadow-lift overflow-hidden max-h-96 overflow-y-auto z-50">
          <template x-for="p in results" :key="p.id">
            <a :href="p.url" class="flex items-center gap-3 px-4 py-2.5 hover:bg-hl-cream">
              <img :src="p.image_url" class="w-10 h-10 rounded-lg object-cover">
              <div class="flex-1 min-w-0">
                <div class="text-sm font-medium truncate" x-text="p.name"></div>
                <div class="text-xs font-bold text-hl-forest" x-text="window.__HIDE_PRICES__ ? '' : ('{{ $s->currency_code ?? '$' }}' + p.display_price)"></div>
              </div>
            </a>
          </template>
        </div>
      </form>
    </div>

    <div class="ml-auto flex items-center gap-5 md:gap-7 text-center text-[10px] font-medium text-hl-ink">
      <a href="{{ route('store.shop') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-hl-forest">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6c0-3.1-2.4-5.6-5.4-5.6-2 0-3.7 1.1-4.6 2.8C10 4.1 8.3 3 6.3 3 3.3 3 .9 5.5.9 8.6c0 6.3 8.6 10.9 10.4 11.8 1.8-.9 10.4-5.5 10.4-11.8Z"/></svg>
        Wishlist
      </a>
      <a href="{{ $hlClient ? url('/online_store/account') : url('/online_store/login') }}" class="hidden sm:flex flex-col items-center gap-0.5 hover:text-hl-forest">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        {{ $hlClient ? 'Account' : 'Sign In' }}
      </a>
      <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center gap-0.5 hover:text-hl-forest">
        <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
        <b class="cart-count absolute -top-1.5 -right-2 bg-hl-forest text-white rounded-full min-w-[16px] h-4 px-1 text-[9px] leading-4">0</b>
        Cart
      </a>
      <button class="md:hidden text-2xl text-hl-ink" onclick="document.getElementById('hl-mobile').classList.toggle('hidden')" aria-label="Menu">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>

  <div class="max-w-[1440px] mx-auto px-5 hidden md:flex items-center gap-6 h-[54px] text-[12px] font-semibold text-hl-ink border-t border-hl-line">
    <details class="relative">
      <summary class="cursor-pointer flex items-center gap-2 rounded-full bg-hl-forest text-white px-5 py-2.5 hover:bg-hl-deep transition-colors">
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
        SHOP ALL CATEGORIES
        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
      </summary>
      <div class="absolute z-50 top-12 w-64 bg-white border border-hl-line rounded-2xl shadow-lift p-3 space-y-1">
        @forelse($hlCategories as $cat)
          <a class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-hl-cream hover:text-hl-forest" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
        @empty
          <span class="block px-3 py-2 text-sm text-hl-mute">Furniture &amp; decor collections</span>
        @endforelse
      </div>
    </details>
    @foreach($hlCategories->take(6) as $cat)
      <a class="hover:text-hl-forest" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ strtoupper($cat->name) }}</a>
    @endforeach
    <a href="{{ route('store.shop') }}" class="flex items-center gap-1">NEW ARRIVALS <span class="bg-hl-deep text-white text-[8px] px-1.5 py-0.5 rounded">NEW</span></a>
    <a class="ml-auto flex items-center gap-1.5 rounded-full bg-hl-goldLight text-hl-deep px-5 py-2.5" href="{{ route('store.shop',['sort'=>'price_asc']) }}">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.83 0l4.59-4.59a2 2 0 0 0 0-2.83Z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>
      GOOD DEALS
    </a>
  </div>

  <div id="hl-mobile" class="hidden md:hidden px-5 py-4 border-t border-hl-line">
    <form action="{{ route('store.shop') }}" class="mb-3">
      <input name="q" class="w-full h-11 px-4 border border-hl-line rounded-full text-sm" placeholder="Search furniture and decor">
    </form>
    <div class="mb-3">@include('store.partials.language-switcher', ['variant' => 'mobile'])</div>
    <div class="grid grid-cols-2 gap-1">
      @foreach($hlCategories as $cat)
        <a class="py-2 text-sm font-medium" href="{{ route('store.shop',['category'=>$cat->id]) }}">{{ $cat->name }}</a>
      @endforeach
    </div>
  </div>
</header>
