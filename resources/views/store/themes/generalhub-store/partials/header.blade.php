{{-- GeneralHub Header Component --}}
@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<!-- 1. TOP PROMOTIONAL ANNOUNCEMENT BAR -->
<div class="bg-hub-navy text-white text-[12px] py-2 px-4 border-b border-hub-navyDark">
  <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1 sm:gap-4">
    <div class="flex items-center gap-1.5 font-normal tracking-wide">
      <span class="text-orange-400">🔥</span>
      <span>Summer Sale is Live! Up to 50% Off on 1000+ products.</span>
      <a href="{{ $hubRoute('store.shop', ['collection' => 'sale']) }}" class="underline hover:text-blue-200 font-medium ml-1">Shop Now &rarr;</a>
    </div>
    <div class="hidden md:flex items-center gap-4 text-slate-300 text-[11px]">
      <span class="flex items-center gap-1">
        <span>📦</span> Free Delivery on orders over $49
      </span>
      <span>|</span>
      <span>30-Day Returns</span>
    </div>
  </div>
</div>

<!-- 2. MAIN HEADER (Logo, Search, Actions) -->
<header class="bg-white border-b border-hub-border sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4 sm:gap-8">
    
    <!-- Mobile Hamburger & Logo -->
    <div class="flex items-center gap-3">
      <button type="button" id="mobile-menu-btn" class="lg:hidden p-1.5 text-slate-700 hover:text-hub-blue rounded-lg hover:bg-slate-100 transition-colors" aria-label="Open navigation menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
      </button>

      <!-- Brand Logo -->
      <a href="{{ $hubRoute('store.index') }}" class="flex items-center gap-2.5 group shrink-0">
        <div class="w-9 h-9 rounded-lg bg-hub-blue flex items-center justify-center text-white shadow-sm group-hover:bg-hub-blueHover transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
        <span class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 group-hover:text-hub-blue transition-colors">
          General<span class="text-hub-blue">Hub</span>
        </span>
      </a>
    </div>

    <!-- Center Search Bar (Desktop) -->
    <div class="hidden lg:flex flex-1 max-w-2xl mx-auto">
      <form action="{{ $hubRoute('store.shop') }}" method="GET" class="w-full flex items-center bg-white border-2 border-hub-blue rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-hub-blue/20 transition-all">
        @if($themePreview)
          <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
        @endif

        <!-- Category Dropdown inside Search -->
        <select name="category" class="bg-slate-50 text-slate-700 text-xs font-medium py-2.5 px-3 border-r border-slate-200 outline-none cursor-pointer hover:bg-slate-100 transition-colors">
          <option value="">All Categories</option>
          @foreach($categories ?? [] as $cat)
            <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
          @endforeach
        </select>

        <!-- Search Input -->
        <input type="text" 
               name="q" 
               value="{{ request('q') }}" 
               placeholder="Search for products, brands and more..." 
               class="w-full text-xs sm:text-sm text-slate-800 placeholder-slate-400 px-4 py-2.5 outline-none">

        <!-- Search Button -->
        <button type="submit" class="bg-hub-blue hover:bg-hub-blueHover text-white px-5 py-2.5 flex items-center justify-center transition-colors" aria-label="Submit search">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
        </button>
      </form>
    </div>

    <!-- Right Actions (Account, Wishlist, Cart) -->
    <div class="flex items-center gap-3 sm:gap-6 shrink-0">
      
      <!-- Account -->
      @if(Auth::guard('store')->check())
        <a href="{{ $hubRoute('account') }}" class="hidden sm:flex items-center gap-2 text-slate-700 hover:text-hub-blue transition-colors">
          <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <div class="text-left leading-tight hidden md:block">
            <div class="text-[10px] text-slate-500 font-normal">Welcome</div>
            <div class="text-xs font-semibold text-slate-800 truncate max-w-[90px]">{{ Auth::guard('store')->user()->name ?? 'My Account' }}</div>
          </div>
        </a>
      @else
        <a href="{{ $hubRoute('store.login.show') }}" class="hidden sm:flex items-center gap-2 text-slate-700 hover:text-hub-blue transition-colors">
          <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <div class="text-left leading-tight hidden md:block">
            <div class="text-[10px] text-slate-500 font-normal">Account</div>
            <div class="text-xs font-semibold text-slate-800">Sign In</div>
          </div>
        </a>
      @endif

      <!-- Wishlist -->
      <a href="{{ $hubRoute('store.shop', ['collection' => 'featured']) }}" class="hidden sm:flex items-center gap-1.5 text-slate-700 hover:text-hub-blue transition-colors" title="Wishlist">
        <div class="relative">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
          <span class="absolute -top-1.5 -right-2 bg-rose-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center">0</span>
        </div>
        <span class="text-xs font-semibold text-slate-800 hidden md:inline ml-1">Wishlist</span>
      </a>

      <!-- Shopping Cart -->
      <a href="{{ $hubRoute('store.cart') }}" class="flex items-center gap-2 text-slate-700 hover:text-hub-blue transition-colors" title="Shopping Cart">
        <div class="relative">
          <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 hover:bg-blue-50 hover:text-hub-blue transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <span class="js-cart-count absolute -top-1 -right-1.5 bg-hub-blue text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm">0</span>
        </div>
        <div class="text-left leading-tight hidden lg:block">
          <div class="text-[10px] text-slate-500 font-normal">Cart</div>
          <div class="text-xs font-semibold text-slate-900">$0.00</div>
        </div>
      </a>

    </div>

  </div>

  <!-- 3. SECONDARY CATEGORY & NAVIGATION BAR (Desktop) -->
  <div class="hidden lg:block bg-white border-t border-hub-borderLight">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
      
      <div class="flex items-center gap-6">
        
        <!-- Browse Categories Button with Dropdown -->
        <div class="relative group">
          <button type="button" class="h-11 px-5 bg-hub-blue hover:bg-hub-blueHover text-white text-xs font-bold tracking-wide uppercase flex items-center gap-2.5 transition-colors rounded-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <span>Browse Categories</span>
            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>

          <!-- Flyout Dropdown -->
          <div class="absolute left-0 top-full w-60 bg-white border border-hub-border shadow-xl rounded-b-xl py-2 hidden group-hover:block z-50 transition-all">
            @php
              $catIcons = [
                'Electronics' => '🎧',
                'Fashion' => '👕',
                'Home & Living' => '🛋️',
                'Beauty' => '💄',
                'Accessories' => '👜',
                'Sports' => '⚽',
                'Toys & Games' => '🧸',
                'Daily Essentials' => '🧴',
              ];
            @endphp
            @foreach($categories ?? [] as $cat)
              <a href="{{ $hubRoute('store.shop', ['category' => $cat->id]) }}" class="flex items-center justify-between px-4 py-2 text-xs font-medium text-slate-700 hover:bg-hub-blueSoft hover:text-hub-blue">
                <span>{{ $catIcons[$cat->name] ?? '📦' }} {{ $cat->name }}</span>
                <span class="text-slate-400">&rsaquo;</span>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Primary Navigation Menu -->
        <nav>
          <ul class="flex items-center gap-7 text-xs font-medium text-slate-700">
            <li>
              <a href="{{ $hubRoute('store.index') }}" class="py-3 inline-block hover:text-hub-blue transition-colors {{ request()->routeIs('store.index') && !request('collection') && !request('sort') ? 'text-hub-blue font-semibold' : '' }}">
                Home
              </a>
            </li>
            <li>
              <a href="{{ $hubRoute('store.shop') }}" class="py-3 inline-block hover:text-hub-blue transition-colors">
                Shop
              </a>
            </li>
            <li>
              <a href="{{ $hubRoute('store.shop', ['collection' => 'deals']) }}" class="py-3 inline-block hover:text-hub-blue transition-colors">
                Deals
              </a>
            </li>
            <li>
              <a href="{{ $hubRoute('store.shop', ['sort' => 'latest']) }}" class="py-3 inline-block hover:text-hub-blue transition-colors">
                New Arrivals
              </a>
            </li>
            <li>
              <a href="{{ $hubRoute('store.shop', ['collection' => 'bestselling']) }}" class="py-3 inline-block hover:text-hub-blue transition-colors">
                Best Sellers
              </a>
            </li>
            <li>
              <a href="#track-order-section" class="py-3 inline-block hover:text-hub-blue transition-colors">
                Track Order
              </a>
            </li>
            <li>
              <a href="#about-section" class="py-3 inline-block hover:text-hub-blue transition-colors">
                About Us
              </a>
            </li>
            <li>
              <a href="#contact-section" class="py-3 inline-block hover:text-hub-blue transition-colors">
                Contact
              </a>
            </li>
          </ul>
        </nav>

      </div>

      <!-- Right Fast Hotline / Order Help -->
      <div class="text-xs text-slate-500 font-medium">
        <span>Hotline: </span>
        <span class="text-slate-800 font-bold">+1 (800) 123-4567</span>
      </div>

    </div>
  </div>

  <!-- Mobile Search Bar (Directly below header on small viewports) -->
  <div class="lg:hidden p-3 bg-slate-50 border-t border-slate-200">
    <form action="{{ $hubRoute('store.shop') }}" method="GET" class="relative">
      @if($themePreview)
        <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
      @endif
      <input type="text" 
             name="q" 
             value="{{ request('q') }}" 
             placeholder="Search products..." 
             class="w-full text-xs bg-white border border-slate-300 rounded-lg pl-3 pr-10 py-2.5 outline-none focus:border-hub-blue">
      <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-hub-blue" aria-label="Search">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      </button>
    </form>
  </div>
</header>
