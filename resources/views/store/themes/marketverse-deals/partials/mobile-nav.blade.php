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

  $mobileDepartments = [
      ['name' => 'Women\'s Fashion', 'category' => 'Fashion'],
      ['name' => 'Men\'s Fashion', 'category' => 'Fashion'],
      ['name' => 'Electronics', 'category' => 'Electronics'],
      ['name' => 'Home & Living', 'category' => 'Home & Living'],
      ['name' => 'Beauty & Personal Care', 'category' => 'Beauty & Personal Care'],
      ['name' => 'Grocery & Essentials', 'category' => 'Grocery & Essentials'],
      ['name' => 'Sports & Outdoors', 'category' => 'Sports & Outdoors'],
      ['name' => 'Toys & Games', 'category' => 'Toys & Games'],
      ['name' => 'Automotive', 'category' => 'Automotive'],
      ['name' => 'Books & Stationery', 'category' => 'Books & Stationery'],
      ['name' => 'Pet Supplies', 'category' => 'Pet Supplies'],
  ];
@endphp

<!-- 1. MOBILE DRAWER SLIDEOUT -->
<div x-show="mobileMenuOpen"
     x-cloak
     class="fixed inset-0 z-50 lg:hidden"
     role="dialog"
     aria-modal="true">

  <!-- Backdrop -->
  <div x-show="mobileMenuOpen"
       x-transition:enter="transition-opacity ease-linear duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-linear duration-300"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="mobileMenuOpen = false"
       class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

  <!-- Drawer Panel -->
  <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-2xl flex flex-col z-50 overflow-y-auto">

    <!-- Drawer Header -->
    <div class="p-4 bg-mv-purple text-white flex items-center justify-between">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-white text-mv-purple flex items-center justify-center font-bold">
          MV
        </div>
        <span class="font-bold text-base">MarketVerse</span>
      </div>
      <button type="button"
              @click="mobileMenuOpen = false"
              class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center">
        &times;
      </button>
    </div>

    <!-- Mobile Search -->
    <div class="p-4 border-b border-slate-100">
      <form action="{{ route('store.shop') }}" method="GET" class="relative">
        @if($themePreview)
          <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
        @endif
        <input type="text"
               name="q"
               placeholder="Search products, stores..."
               class="w-full bg-slate-100 text-xs text-slate-800 rounded-xl pl-3 pr-9 py-2.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-mv-purple">
        <button type="submit" class="absolute right-2.5 top-2.5 text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>
      </form>
    </div>

    <!-- Departments List -->
    <div class="p-4 space-y-4 flex-1">
      <div>
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Departments</h4>
        <div class="space-y-1">
          @foreach($mobileDepartments as $dept)
            <a href="{{ $mvRoute('store.shop', ['category' => $dept['category']]) }}"
               @click="mobileMenuOpen = false"
               class="flex items-center justify-between py-2 px-2.5 rounded-lg text-xs font-semibold text-slate-700 hover:bg-mv-purpleLight hover:text-mv-purple transition-colors">
              <span>{{ $dept['name'] }}</span>
              <span class="text-slate-400 text-[10px]">&rarr;</span>
            </a>
          @endforeach
        </div>
      </div>

      <!-- Quick Collections -->
      <div class="pt-2 border-t border-slate-100 space-y-1">
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Special Offers</h4>
        <a href="{{ $mvRoute('store.shop', ['collection' => 'flash-sale']) }}"
           @click="mobileMenuOpen = false"
           class="flex items-center gap-2 py-2 px-2.5 rounded-lg text-xs font-bold text-red-600 hover:bg-red-50">
          <span>⚡</span> Flash Sale Deals
        </a>
        <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}"
           @click="mobileMenuOpen = false"
           class="flex items-center gap-2 py-2 px-2.5 rounded-lg text-xs font-bold text-amber-600 hover:bg-amber-50">
          <span>🔥</span> Top Deals
        </a>
        <a href="{{ $mvRoute('store.shop', ['collection' => 'new-arrivals']) }}"
           @click="mobileMenuOpen = false"
           class="flex items-center gap-2 py-2 px-2.5 rounded-lg text-xs font-bold text-mv-purple hover:bg-mv-purpleLight">
          <span>✨</span> New Arrivals
        </a>
      </div>
    </div>

    <!-- Drawer Footer -->
    <div class="p-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-600 space-y-2">
      <div class="flex items-center justify-between">
        <span>Language: English</span>
        <span>Currency: USD ($)</span>
      </div>
      <a href="{{ $shopUrl }}" class="block text-center py-2 bg-mv-purple text-white font-bold rounded-xl shadow-xs">
        Become a Seller
      </a>
    </div>

  </div>
</div>

<!-- 2. BOTTOM STICKY NAVIGATION BAR (Mobile Only) -->
<div class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-mv-border px-4 py-2 shadow-lg" x-data="miniCart()">
  <div class="flex items-center justify-around text-center">

    <!-- Home -->
    <a href="{{ $homeUrl }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold {{ request()->routeIs('store.index') && !request('category') ? 'text-mv-purple' : 'text-slate-500 hover:text-mv-purple' }}">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      <span>Home</span>
    </a>

    <!-- Categories -->
    <a href="{{ $shopUrl }}" @click="mobileMenuOpen = true" class="flex flex-col items-center gap-1 text-[10px] font-semibold text-slate-500 hover:text-mv-purple">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
      <span>Categories</span>
    </a>

    <!-- Deals -->
    <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold text-slate-500 hover:text-mv-purple">
      <svg class="w-5 h-5 text-mv-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/></svg>
      <span class="text-mv-orange font-bold">Deals</span>
    </a>

    <!-- Account -->
    <a href="{{ $shopUrl }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold text-slate-500 hover:text-mv-purple">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      <span>Account</span>
    </a>

    <!-- Cart -->
    <a href="{{ $cartUrl }}" class="flex flex-col items-center gap-1 text-[10px] font-semibold text-slate-500 hover:text-mv-purple relative">
      <div class="relative">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <span class="absolute -top-1.5 -right-2 bg-mv-orange text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center"
              x-text="itemsCount()">0</span>
      </div>
      <span>Cart</span>
    </a>

  </div>
</div>
