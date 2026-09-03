@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $mvRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $mvRoute('store.shop');
  $cartUrl = $mvRoute('store.cart');
  $homeUrl = $mvRoute('store.index');

  $navDepartments = [
      ['name' => 'Fashion', 'category' => 'Fashion'],
      ['name' => 'Electronics', 'category' => 'Electronics'],
      ['name' => 'Home', 'category' => 'Home & Living'],
      ['name' => 'Beauty', 'category' => 'Beauty & Personal Care'],
      ['name' => 'Grocery', 'category' => 'Grocery & Essentials'],
      ['name' => 'Toys', 'category' => 'Toys & Games'],
      ['name' => 'Sports', 'category' => 'Sports & Outdoors'],
      ['name' => 'Automotive', 'category' => 'Automotive'],
  ];
@endphp

<header class="w-full bg-white border-b border-mv-border sticky top-0 z-40 shadow-xs">

  <!-- 1. TOP UTILITY BAR (Purple Deep) -->
  <div class="bg-[#2D1680] text-slate-200 text-[11px] py-1.5 px-4 sm:px-6 lg:px-8 border-b border-white/10 hidden md:block">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <!-- Left Links -->
      <div class="flex items-center gap-5">
        <a href="#app-download" class="flex items-center gap-1.5 hover:text-white transition-colors">
          <svg class="w-3.5 h-3.5 text-mv-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
          <span>Download App</span>
        </a>
        <a href="{{ $shopUrl }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
          <svg class="w-3.5 h-3.5 text-mv-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          <span>Become a Seller</span>
        </a>
        <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
          <svg class="w-3.5 h-3.5 text-mv-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          <span>Order Tracking</span>
        </a>
        <a href="#coupons-section" class="flex items-center gap-1.5 hover:text-white transition-colors">
          <svg class="w-3.5 h-3.5 text-mv-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
          <span>Coupons</span>
        </a>
        <a href="{{ $shopUrl }}" class="flex items-center gap-1.5 hover:text-white transition-colors">
          <svg class="w-3.5 h-3.5 text-mv-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          <span>Customer Support</span>
        </a>
      </div>

      <!-- Right Preferences -->
      <div class="flex items-center gap-4">
        <div class="flex items-center gap-1 cursor-pointer hover:text-white">
          <span>🇺🇸 English</span>
        </div>
        <span>|</span>
        <div class="flex items-center gap-1 cursor-pointer hover:text-white">
          <span>USD ($)</span>
        </div>
      </div>
    </div>
  </div>

  <!-- 2. MAIN BRAND & SEARCH HEADER -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
    <div class="flex items-center justify-between gap-4 lg:gap-8">

      <!-- Mobile Menu Button -->
      <button type="button"
              @click="mobileMenuOpen = true"
              class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>

      <!-- MarketVerse Logo -->
      <a href="{{ $homeUrl }}" class="flex items-center gap-2.5 shrink-0 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-mv-purpleDark to-mv-purple flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <div class="flex flex-col">
          <span class="text-2xl font-black tracking-tight text-slate-900 leading-none">
            Market<span class="text-mv-purple">Verse</span>
          </span>
          <span class="text-[10px] font-semibold text-slate-400 tracking-wider uppercase mt-0.5">Mega Marketplace</span>
        </div>
      </a>

      <!-- Large Center Search Bar with Department Selector -->
      <div class="flex-1 max-w-2xl hidden md:block">
        <form action="{{ route('store.shop') }}" method="GET" class="flex items-center bg-slate-50 border-2 border-mv-purple/30 focus-within:border-mv-purple rounded-full p-1 shadow-xs transition-colors">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif

          <!-- Departments Dropdown -->
          <div class="relative pl-3 pr-2 py-1.5 border-r border-slate-200 shrink-0">
            <select name="category" class="text-xs bg-transparent font-medium text-slate-700 focus:outline-none cursor-pointer">
              <option value="">All Departments</option>
              <option value="Fashion">Fashion</option>
              <option value="Electronics">Electronics</option>
              <option value="Home & Living">Home & Living</option>
              <option value="Beauty & Personal Care">Beauty</option>
              <option value="Grocery & Essentials">Grocery</option>
              <option value="Toys & Games">Toys</option>
              <option value="Sports & Outdoors">Sports</option>
              <option value="Automotive">Automotive</option>
              <option value="Books & Stationery">Books</option>
            </select>
          </div>

          <!-- Query Input -->
          <input type="text"
                 name="q"
                 value="{{ request('q') }}"
                 placeholder="Search for products, brands and stores..."
                 class="w-full bg-transparent px-4 py-2 text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none">

          <!-- Search Submit Button (Orange) -->
          <button type="submit"
                  class="w-10 h-10 rounded-full bg-mv-orange hover:bg-mv-orangeHover text-white flex items-center justify-center shrink-0 shadow-md transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </button>
        </form>
      </div>

      <!-- Right Utility Actions -->
      <div class="flex items-center gap-3 sm:gap-5 shrink-0">

        <!-- Delivery Location -->
        <div class="hidden xl:flex items-center gap-2 text-left pl-2">
          <div class="w-8 h-8 rounded-full bg-mv-purpleLight text-mv-purple flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          </div>
          <div class="text-[11px] leading-tight">
            <span class="text-slate-400 block">Deliver to</span>
            <span class="font-bold text-slate-800">New York, USA</span>
          </div>
        </div>

        <!-- Account -->
        <a href="{{ $shopUrl }}" class="flex items-center gap-2 text-slate-700 hover:text-mv-purple transition-colors">
          <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
          <div class="hidden sm:block text-[11px] text-left leading-tight">
            <span class="text-slate-400 block">Account</span>
            <span class="font-bold text-slate-800">Hello, Sign In</span>
          </div>
        </a>

        <!-- Wishlist -->
        <a href="{{ $shopUrl }}" class="relative p-2 text-slate-700 hover:text-mv-purple transition-colors hidden sm:block">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
          <span class="absolute top-0 right-0 w-4 h-4 bg-mv-purple text-white text-[9px] font-bold rounded-full flex items-center justify-center">0</span>
        </a>

        <!-- Cart Badge (Single Alpine runtime synced via miniCart()) -->
        <div x-data="miniCart()">
          <a href="{{ $cartUrl }}"
             class="flex items-center gap-2 px-3.5 py-2 bg-mv-purple hover:bg-mv-purpleDark text-white rounded-full transition-all shadow-md active:scale-95 group">
            <div class="relative">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
              <span class="absolute -top-2 -right-2 bg-mv-orange text-white text-[10px] font-extrabold w-4 h-4 rounded-full flex items-center justify-center"
                    x-text="itemsCount()">0</span>
            </div>
            <span class="text-xs font-bold hidden sm:inline">Cart</span>
          </a>
        </div>

      </div>

    </div>
  </div>

  <!-- 3. PURPLE MARKETPLACE NAVIGATION BAR -->
  <nav class="bg-mv-purple text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between">

        <!-- Left: All Departments Button -->
        <div class="relative" x-data="{ deptOpen: false }">
          <button type="button"
                  @click="deptOpen = !deptOpen"
                  class="flex items-center gap-2.5 px-4 py-3 bg-[#3C1BA8] hover:bg-[#341696] font-bold text-xs uppercase tracking-wider transition-colors shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <span>All Departments</span>
            <svg class="w-3.5 h-3.5 transition-transform" :class="deptOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
          </button>

          <!-- Dropdown List -->
          <div x-show="deptOpen"
               @click.away="deptOpen = false"
               x-cloak
               class="absolute top-full left-0 w-64 bg-white text-slate-800 shadow-2xl rounded-b-2xl border border-slate-200 py-2 z-50">
            @foreach($navDepartments as $dept)
              <a href="{{ $mvRoute('store.shop', ['category' => $dept['category']]) }}"
                 class="flex items-center justify-between px-4 py-2.5 text-xs font-semibold hover:bg-mv-purpleLight hover:text-mv-purple transition-colors">
                <span>{{ $dept['name'] }}</span>
                <span class="text-slate-400">&rarr;</span>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Center: Department Links (Horizontal Scroll) -->
        <div class="flex items-center overflow-x-auto no-scrollbar py-2 text-xs font-semibold space-x-1 sm:space-x-4">
          @foreach($navDepartments as $dept)
            <a href="{{ $mvRoute('store.shop', ['category' => $dept['category']]) }}"
               class="px-2.5 py-1.5 rounded-lg hover:bg-white/15 transition-colors whitespace-nowrap {{ request('category') === $dept['category'] ? 'bg-white/20 text-white font-bold' : 'text-slate-100' }}">
              {{ $dept['name'] }}
            </a>
          @endforeach

          <!-- Top Deals Highlight -->
          <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}"
             class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-mv-gold text-slate-900 font-extrabold hover:bg-amber-400 transition-colors whitespace-nowrap shadow-xs">
            <span>🔥</span>
            <span>Top Deals</span>
          </a>
        </div>

        <!-- Right Promo Tag -->
        <div class="hidden lg:flex items-center gap-2 text-[11px] font-bold text-amber-300">
          <span>⚡ Flash Deals Up to 70% OFF</span>
        </div>

      </div>
    </div>
  </nav>

</header>
