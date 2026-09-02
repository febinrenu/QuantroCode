{{-- VogueLane Header Partial --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $currentCat = request('category');
@endphp

<header class="sticky top-0 z-40 bg-white shadow-xs">
  
  <!-- 1. TOP PROMOTIONAL BANNER -->
  <div class="bg-vog-black text-white text-[11px] sm:text-xs py-2 px-4 sm:px-6 lg:px-8 tracking-wide">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-2 font-medium">
        <span class="text-amber-400">✨</span>
        <span class="font-semibold uppercase tracking-wider text-amber-300 text-[10px]">Summer Collection</span>
        <span class="hidden sm:inline text-white/80">|</span>
        <span class="text-white/90">Up to 40% Off Everything</span>
        <span class="hidden md:inline text-white/60">| Limited Time Only</span>
        <a href="{{ $vogRoute('store.shop', ['collection' => 'sale']) }}" class="underline font-semibold text-amber-300 hover:text-white transition-colors ml-1">
          Shop Now &rarr;
        </a>
      </div>
      <div class="hidden lg:flex items-center gap-4 text-white/80 text-[11px]">
        <div class="flex items-center gap-1">
          <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          <span>Free Shipping on orders $80+</span>
        </div>
        <span>•</span>
        <span>Easy 30-Day Returns</span>
      </div>
    </div>
  </div>

  <!-- 2. MAIN LOGO, SEARCH, UTILITY BAR -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
    <div class="flex items-center justify-between gap-4 sm:gap-8">
      
      <!-- Mobile Menu Button & Search Trigger -->
      <div class="flex items-center gap-2 lg:hidden">
        <button type="button" 
                @click="mobileMenuOpen = true" 
                class="p-2 -ml-2 text-slate-800 hover:text-black focus:outline-none" 
                aria-label="Open mobile menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>

      <!-- Brand Logo -->
      <a href="{{ $vogRoute('store.index') }}" class="shrink-0 flex items-center group">
        <span class="font-serif-luxury text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 group-hover:text-vog-tan transition-colors">
          Vogue<span class="text-vog-tan font-normal italic">Lane</span>
        </span>
      </a>

      <!-- Desktop Search Bar -->
      <div class="hidden md:flex flex-1 max-w-xl mx-auto">
        <form action="{{ $vogRoute('store.shop') }}" method="GET" class="w-full relative">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          <input type="text" 
                 name="q" 
                 value="{{ request('q') }}"
                 placeholder="Search for products, brands and more..." 
                 class="w-full h-10 pl-4 pr-10 text-xs sm:text-sm bg-vog-ivory border border-vog-border rounded-full focus:outline-none focus:border-slate-900 focus:bg-white transition-all text-slate-900 placeholder:text-slate-400">
          <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-900 transition-colors" aria-label="Submit search">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
          </button>
        </form>
      </div>

      <!-- Right Utility Actions -->
      <div class="flex items-center gap-3 sm:gap-6 shrink-0">
        
        <!-- Account -->
        @if(Auth::guard('store')->check())
          <a href="{{ $vogRoute('account') }}" class="hidden sm:flex items-center gap-2 text-xs text-slate-800 hover:text-vog-tan transition-colors">
            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <div class="text-left leading-tight hidden lg:block">
              <span class="block text-[10px] text-slate-400 uppercase font-medium">Hello,</span>
              <span class="font-semibold text-slate-900">{{ Str::limit(Auth::guard('store')->user()->name, 10) }}</span>
            </div>
          </a>
        @else
          <a href="{{ $vogRoute('store.login.show') }}" class="hidden sm:flex items-center gap-2 text-xs text-slate-800 hover:text-vog-tan transition-colors">
            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <div class="text-left leading-tight hidden lg:block">
              <span class="block text-[10px] text-slate-400 uppercase font-medium">Account</span>
              <span class="font-semibold text-slate-900">Sign In</span>
            </div>
          </a>
        @endif

        <!-- Wishlist -->
        <a href="{{ $vogRoute('store.shop', ['collection' => 'featured']) }}" class="flex items-center gap-1.5 text-xs text-slate-800 hover:text-vog-tan transition-colors" title="Wishlist">
          <div class="relative">
            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
          </div>
          <span class="hidden lg:inline text-xs font-semibold text-slate-900">Wishlist</span>
        </a>

        <!-- Cart Bag -->
        <a href="{{ $vogRoute('store.cart') }}" class="flex items-center gap-2 text-xs text-slate-800 hover:text-vog-tan transition-colors group">
          <div class="relative">
            <svg class="w-5 h-5 text-slate-900 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
            </svg>
            <span class="js-cart-count cart-count absolute -top-1.5 -right-2 bg-vog-black text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center leading-none">
              0
            </span>
          </div>
          <div class="text-left leading-tight hidden sm:block">
            <span class="block text-[10px] text-slate-400 uppercase font-medium">Bag</span>
            <span class="font-semibold text-slate-900">Cart</span>
          </div>
        </a>

      </div>

    </div>
  </div>

  <!-- 3. MAIN CATEGORY NAVIGATION STRIP -->
  <nav class="border-y border-vog-border bg-white hidden md:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <ul class="flex items-center justify-center space-x-6 lg:space-x-8 py-2.5 text-xs sm:text-[13px] font-semibold tracking-wide uppercase text-slate-800">
        
        <li>
          <a href="{{ $vogRoute('store.shop', ['collection' => 'new-in']) }}" 
             class="hover:text-vog-tan transition-colors {{ request('collection') === 'new-in' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            New In
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Women' || $currentCat == '13' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Women
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Men']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Men' || $currentCat == '14' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Men
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Shoes']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Shoes' || $currentCat == '15' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Shoes
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Bags']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Bags' || $currentCat == '16' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Bags
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Accessories']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Accessories' || $currentCat == '9' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Accessories
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Beauty']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Beauty' || $currentCat == '8' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Beauty
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Jewelry']) }}" 
             class="hover:text-vog-tan transition-colors {{ $currentCat == 'Jewelry' || $currentCat == '17' ? 'text-vog-tan border-b-2 border-vog-tan pb-1' : '' }}">
            Jewelry
          </a>
        </li>

        <li>
          <a href="{{ $vogRoute('store.shop', ['collection' => 'sale']) }}" 
             class="text-vog-sale font-bold hover:text-red-700 transition-colors {{ request('collection') === 'sale' ? 'border-b-2 border-vog-sale pb-1' : '' }}">
            Sale
          </a>
        </li>

      </ul>
    </div>
  </nav>

</header>
