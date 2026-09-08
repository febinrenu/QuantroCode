@extends('store.themes.marketverse._shell')

@section('title', 'MarketVerse — Everything from Every Store, All in One Marketplace')

@section('content')

@php
  use App\Models\Product;
  use App\Models\Category;

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $mvRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $mvRoute('store.shop');

  // Query MarketVerse products
  $flashSaleProducts = Product::where('code', 'like', 'MKT-%')
      ->whereIn('code', [
          'MKT-EAR-001', 'MKT-WAT-001', 'MKT-MIX-001',
          'MKT-SHU-001', 'MKT-SRM-001', 'MKT-MOU-001'
      ])
      ->take(6)
      ->get();

  $recommendedProducts = Product::where('code', 'like', 'MKT-%')
      ->whereIn('code', [
          'MKT-BAG-001', 'MKT-VAC-001', 'MKT-CLK-001',
          'MKT-TRK-001', 'MKT-CKW-001', 'MKT-CAS-001'
      ])
      ->take(6)
      ->get();

  $newArrivals = Product::where('code', 'like', 'MKT-%')
      ->whereIn('code', [
          'MKT-BUD-002', 'MKT-PHN-001', 'MKT-SHU-002',
          'MKT-DRY-001', 'MKT-SPK-001', 'MKT-MUG-001'
      ])
      ->take(6)
      ->get();

  // If specific codes are not yet seeded, fallback to any MarketVerse products
  if ($flashSaleProducts->isEmpty()) {
      $flashSaleProducts = Product::where('code', 'like', 'MKT-%')->take(6)->get();
  }
  if ($recommendedProducts->isEmpty()) {
      $recommendedProducts = Product::where('code', 'like', 'MKT-%')->skip(6)->take(6)->get();
  }
  if ($newArrivals->isEmpty()) {
      $newArrivals = Product::where('code', 'like', 'MKT-%')->skip(12)->take(6)->get();
  }

  $departmentsList = [
      ['name' => "Women's Fashion", 'category' => 'Fashion'],
      ['name' => "Men's Fashion", 'category' => 'Fashion'],
      ['name' => "Electronics", 'category' => 'Electronics'],
      ['name' => "Home & Living", 'category' => 'Home & Living'],
      ['name' => "Beauty & Personal Care", 'category' => 'Beauty & Personal Care'],
      ['name' => "Grocery & Essentials", 'category' => 'Grocery & Essentials'],
      ['name' => "Sports & Outdoors", 'category' => 'Sports & Outdoors'],
      ['name' => "Toys & Games", 'category' => 'Toys & Games'],
      ['name' => "Automotive", 'category' => 'Automotive'],
      ['name' => "Books & Stationery", 'category' => 'Books & Stationery'],
      ['name' => "Pet Supplies", 'category' => 'Pet Supplies'],
  ];

  $topStores = [
      ['name' => 'TrendyHub', 'category' => 'Fashion Store', 'rating' => '4.8', 'sales' => '12.5k Sales', 'logo' => 'store-trendyhub.png', 'color' => 'from-pink-500 to-rose-600'],
      ['name' => 'TechWorld', 'category' => 'Electronics', 'rating' => '4.9', 'sales' => '18.2k Sales', 'logo' => 'store-techworld.png', 'color' => 'from-blue-600 to-indigo-700'],
      ['name' => 'HomeNest', 'category' => 'Home & Living', 'rating' => '4.7', 'sales' => '9.3k Sales', 'logo' => 'store-homenest.png', 'color' => 'from-amber-500 to-orange-600'],
      ['name' => 'BeautyBliss', 'category' => 'Beauty Store', 'rating' => '4.8', 'sales' => '15.6k Sales', 'logo' => 'store-beautybliss.png', 'color' => 'from-purple-500 to-fuchsia-600'],
      ['name' => 'Sportify', 'category' => 'Sports & Outdoors', 'rating' => '4.6', 'sales' => '11.2k Sales', 'logo' => 'store-sportify.png', 'color' => 'from-emerald-500 to-teal-700'],
      ['name' => 'ToyLand', 'category' => 'Toys & Games', 'rating' => '4.9', 'sales' => '8.5k Sales', 'logo' => 'store-toyland.png', 'color' => 'from-cyan-500 to-blue-600'],
  ];

  $trendingCategories = [
      ['name' => 'Fashion', 'category' => 'Fashion', 'icon' => 'cat-fashion.jpg'],
      ['name' => 'Electronics', 'category' => 'Electronics', 'icon' => 'cat-electronics.jpg'],
      ['name' => 'Home & Living', 'category' => 'Home & Living', 'icon' => 'cat-home-living.jpg'],
      ['name' => 'Beauty', 'category' => 'Beauty & Personal Care', 'icon' => 'cat-beauty.jpg'],
      ['name' => 'Grocery', 'category' => 'Grocery & Essentials', 'icon' => 'cat-grocery.jpg'],
      ['name' => 'Toys & Games', 'category' => 'Toys & Games', 'icon' => 'cat-toys.jpg'],
      ['name' => 'Sports', 'category' => 'Sports & Outdoors', 'icon' => 'cat-sports.jpg'],
      ['name' => 'Automotive', 'category' => 'Automotive', 'icon' => 'cat-automotive.jpg'],
  ];

  $coupons = [
      ['discount' => '20% OFF', 'desc' => 'Min. $50 Order', 'code' => 'SAVE20', 'bg' => 'bg-emerald-50 border-emerald-200 text-emerald-800'],
      ['discount' => '15% OFF', 'desc' => 'Fashion Items', 'code' => 'FASHION15', 'bg' => 'bg-rose-50 border-rose-200 text-rose-800'],
      ['discount' => '10% OFF', 'desc' => 'Electronics', 'code' => 'TECH10', 'bg' => 'bg-blue-50 border-blue-200 text-blue-800'],
      ['discount' => '$10 OFF', 'desc' => 'Home & Living', 'code' => 'HOME10', 'bg' => 'bg-amber-50 border-amber-200 text-amber-800'],
      ['discount' => '5% OFF', 'desc' => 'Storewide', 'code' => 'MV5', 'bg' => 'bg-purple-50 border-purple-200 text-purple-800'],
  ];

  $brands = [
      ['name' => 'Nike', 'logo' => 'marketverse-brand-nike.png'],
      ['name' => 'Samsung', 'logo' => 'marketverse-brand-samsung.png'],
      ['name' => 'boAt', 'logo' => 'marketverse-brand-boat.png'],
      ['name' => 'Puma', 'logo' => 'marketverse-brand-puma.png'],
      ['name' => 'Philips', 'logo' => 'marketverse-brand-philips.png'],
      ['name' => 'realme', 'logo' => 'marketverse-brand-realme.png'],
      ['name' => 'Lenovo', 'logo' => 'marketverse-brand-lenovo.png'],
      ['name' => 'Xiaomi', 'logo' => 'marketverse-brand-xiaomi.png'],
  ];

  $testimonials = [
      ['name' => 'Sarah Johnson', 'role' => 'Verified Buyer', 'rating' => 5, 'text' => 'Amazing variety and great prices! Everything arrived from three different stores in one neat package.'],
      ['name' => 'Michael Brown', 'role' => 'Verified Buyer', 'rating' => 5, 'text' => 'Fast delivery and excellent customer service. The vendor spotlight discounts saved me over $80.'],
      ['name' => 'Priya Sharma', 'role' => 'Verified Buyer', 'rating' => 5, 'text' => 'Love the seller offers and authenticity guarantee. Best multi-vendor marketplace I have used.'],
      ['name' => 'David Wilson', 'role' => 'Verified Buyer', 'rating' => 5, 'text' => 'Seamless checkout experience and quick tracking updates. Highly recommended marketplace.'],
  ];
@endphp

<div class="space-y-10 sm:space-y-14 pb-16">

  <!-- =========================================================================
       1. HERO SECTION (Left Department Sidebar + Center Gradient Banner + Right Promo Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

      <!-- Left Departments Drawer Menu (Hidden on mobile, 3 cols on desktop) -->
      <div class="hidden lg:block lg:col-span-3 bg-white rounded-3xl border border-mv-border p-4 shadow-xs">
        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 px-3 py-2 border-b border-slate-100">
          Browse Departments
        </h3>
        <div class="py-2 space-y-0.5 text-xs font-semibold text-slate-700">
          @foreach($departmentsList as $dept)
            <a href="{{ $mvRoute('store.shop', ['category' => $dept['category']]) }}"
               class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-mv-purpleLight hover:text-mv-purple transition-colors group">
              <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 group-hover:bg-mv-purple transition-colors"></span>
                <span>{{ $dept['name'] }}</span>
              </div>
              <span class="text-slate-300 group-hover:text-mv-purple transition-colors">&rarr;</span>
            </a>
          @endforeach
          <div class="pt-2 border-t border-slate-100">
            <a href="{{ $shopUrl }}" class="block text-center py-2 text-xs font-bold text-mv-purple hover:underline">
              View All Categories &rarr;
            </a>
          </div>
        </div>
      </div>

      <!-- Center Hero Banner (6 cols on desktop) -->
      <div class="lg:col-span-6 rounded-3xl overflow-hidden relative bg-gradient-to-tr from-[#371B97] via-[#4F28D9] to-[#6D38E0] text-white p-6 sm:p-10 flex flex-col justify-between shadow-lg min-h-[380px] sm:min-h-[440px]">
        <!-- Background Decorative Illustration -->
        <img src="{{ global_asset('images/themes/marketverse/hero-marketverse-main.jpg') }}"
             alt="MarketVerse Marketplace"
             class="absolute right-0 bottom-0 w-3/5 h-4/5 object-contain object-bottom opacity-85 pointer-events-none">

        <!-- Gradient Readability Shield -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#371B97]/90 via-[#4F28D9]/70 to-transparent w-4/5 pointer-events-none"></div>

        <!-- Banner Content -->
        <div class="relative z-10 space-y-4 max-w-sm my-auto">
          <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-xs rounded-full text-[10px] font-extrabold uppercase tracking-wider text-amber-300">
            ★ All In One Mega Marketplace
          </span>
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-[1.15]">
            Everything from <span class="text-amber-300">Every Store</span>, All in One Marketplace.
          </h1>
          <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-normal">
            Millions of products. Thousands of stores. Endless choices. One trusted marketplace.
          </p>
          <div class="pt-2 flex flex-wrap items-center gap-3">
            <a href="{{ $shopUrl }}"
               class="px-6 py-3 bg-mv-orange hover:bg-mv-orangeHover text-white text-xs sm:text-sm font-extrabold rounded-full shadow-lg active:scale-95 transition-all">
              Shop All Categories
            </a>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'top-deals']) }}"
               class="px-6 py-3 bg-white/15 hover:bg-white/25 text-white border border-white/20 text-xs sm:text-sm font-bold rounded-full backdrop-blur-xs active:scale-95 transition-all">
              Explore Top Stores
            </a>
          </div>
        </div>

        <!-- Carousel Indicators -->
        <div class="relative z-10 flex items-center gap-1.5 pt-4">
          <span class="w-6 h-1.5 bg-amber-400 rounded-full"></span>
          <span class="w-2 h-1.5 bg-white/40 rounded-full"></span>
          <span class="w-2 h-1.5 bg-white/40 rounded-full"></span>
        </div>
      </div>

      <!-- Right 3 Promo Cards (3 cols on desktop) -->
      <div class="lg:col-span-3 flex flex-col gap-4">

        <!-- Card 1: Flash Deals -->
        <div class="flex-1 rounded-3xl bg-white border border-mv-border p-4 sm:p-5 flex flex-col justify-between shadow-xs relative overflow-hidden group">
          <div class="space-y-1">
            <div class="flex items-center justify-between">
              <span class="text-[10px] font-extrabold uppercase tracking-wider text-red-600 flex items-center gap-1">
                <span>⚡</span> Flash Deals
              </span>
              <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-black rounded-md">
                Up to 70% OFF
              </span>
            </div>
            <h4 class="text-sm font-bold text-slate-900 leading-tight">Top Electronics & Audio</h4>
          </div>

          <!-- Live Countdown -->
          <div class="my-2 flex items-center gap-1 text-center font-mono font-black text-xs">
            <span class="px-2 py-1 bg-slate-900 text-white rounded-md">02</span> :
            <span class="px-2 py-1 bg-slate-900 text-white rounded-md">45</span> :
            <span class="px-2 py-1 bg-slate-900 text-white rounded-md">18</span>
          </div>

          <div>
            <a href="{{ $mvRoute('store.shop', ['collection' => 'flash-sale']) }}" class="text-xs font-bold text-mv-purple hover:underline flex items-center justify-between">
              <span>Shop Deals</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Card 2: New Seller Offers -->
        <div class="flex-1 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-700 text-white p-4 sm:p-5 flex flex-col justify-between shadow-xs relative overflow-hidden">
          <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-100">Welcome Bonus</span>
            <h4 class="text-sm font-bold leading-tight">New Seller Offers<br><span class="text-amber-300">Extra 20% OFF</span></h4>
          </div>
          <div class="pt-2 relative z-10">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-mono font-bold tracking-wider">
              Code: NEW20
            </span>
          </div>
        </div>

        <!-- Card 3: Weekend Coupons -->
        <div class="flex-1 rounded-3xl bg-gradient-to-br from-amber-400 to-orange-500 text-slate-900 p-4 sm:p-5 flex flex-col justify-between shadow-xs relative overflow-hidden">
          <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-800">Limited Time</span>
            <h4 class="text-sm font-black leading-tight">Weekend Coupons<br>Save More This Weekend!</h4>
          </div>
          <div class="pt-2 relative z-10">
            <a href="#coupons-section" class="inline-flex items-center gap-1 text-xs font-bold text-slate-900 hover:underline">
              <span>Get Coupons</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       2. TRUST & VALUE STRIP (5 items)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl border border-mv-border p-4 sm:p-5 shadow-xs">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-4 divide-y md:divide-y-0 md:divide-x divide-slate-100">

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4 first:pt-0 first:px-0">
          <div class="w-10 h-10 rounded-xl bg-mv-purpleLight text-mv-purple flex items-center justify-center text-lg shrink-0">
            🛡️
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Buyer Protection</h4>
            <p class="text-[11px] text-slate-500">Shop with confidence</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-mv-purpleLight text-mv-purple flex items-center justify-center text-lg shrink-0">
            🚚
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Fast Shipping</h4>
            <p class="text-[11px] text-slate-500">Quick marketplace delivery</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-mv-purpleLight text-mv-purple flex items-center justify-center text-lg shrink-0">
            🔒
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Secure Payments</h4>
            <p class="text-[11px] text-slate-500">100% secure checkout</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-mv-purpleLight text-mv-purple flex items-center justify-center text-lg shrink-0">
            🔄
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Easy Returns</h4>
            <p class="text-[11px] text-slate-500">Hassle-free guarantee</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-mv-purpleLight text-mv-purple flex items-center justify-center text-lg shrink-0">
            ⭐
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Verified Sellers</h4>
            <p class="text-[11px] text-slate-500">Trusted stores network</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================================
       3. TOP STORES (6 Stores with Badges)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          Top Stores
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Explore popular and top-rated marketplace sellers.</p>
      </div>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All Stores &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      @foreach($topStores as $store)
        <a href="{{ $mvRoute('store.shop', ['category' => explode(' ', $store['category'])[0]]) }}"
           class="bg-white rounded-2xl border border-mv-border p-4 text-center flex flex-col items-center justify-between gap-3 mv-card group">
          <div class="w-16 h-16 rounded-full overflow-hidden flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
            <img src="{{ global_asset('images/themes/marketverse/' . $store['logo']) }}"
                 alt="{{ $store['name'] }}"
                 class="w-full h-full object-contain">
          </div>
          <div class="space-y-0.5">
            <span class="inline-block px-2 py-0.5 bg-mv-purpleLight text-mv-purple text-[9px] font-extrabold rounded-full mb-1">
              Top Rated
            </span>
            <h4 class="text-xs font-bold text-slate-900 group-hover:text-mv-purple transition-colors leading-tight">
              {{ $store['name'] }}
            </h4>
            <p class="text-[10px] text-slate-400">{{ $store['category'] }}</p>
          </div>
          <div class="flex items-center justify-center gap-2 text-[10px] text-slate-500 pt-1 border-t border-slate-100 w-full">
            <span class="font-bold text-amber-500">★ {{ $store['rating'] }}</span>
            <span>•</span>
            <span>{{ $store['sales'] }}</span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       4. TRENDING CATEGORIES (8 Circular / Rounded Category Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          Trending Categories
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Shop popular departments across the marketplace.</p>
      </div>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
      @foreach($trendingCategories as $catItem)
        <a href="{{ $mvRoute('store.shop', ['category' => $catItem['category']]) }}"
           class="bg-white rounded-2xl border border-mv-border p-3.5 text-center flex flex-col items-center justify-center gap-2.5 mv-card group">
          <div class="w-16 h-16 rounded-full bg-slate-50 overflow-hidden border border-slate-100 flex items-center justify-center p-2 group-hover:bg-mv-purpleLight transition-colors">
            <img src="{{ global_asset('images/themes/marketverse/' . $catItem['icon']) }}"
                 alt="{{ $catItem['name'] }}"
                 class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-300">
          </div>
          <h3 class="text-xs font-bold text-slate-800 group-hover:text-mv-purple transition-colors leading-tight">
            {{ $catItem['name'] }}
          </h3>
        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       5. FLASH SALE (Countdown + 6 Products in Grid)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-gradient-to-r from-red-600 via-rose-600 to-orange-600 rounded-3xl p-5 sm:p-7 text-white shadow-md space-y-6">

      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
          <span class="text-2xl font-black tracking-tight flex items-center gap-2">
            <span>⚡</span> Flash Sale
          </span>
          <span class="text-xs font-semibold text-rose-100 hidden sm:inline">Ends in:</span>
          <div class="flex items-center gap-1 font-mono font-black text-xs text-slate-900">
            <span class="px-2.5 py-1 bg-white rounded-md shadow-xs">02</span> :
            <span class="px-2.5 py-1 bg-white rounded-md shadow-xs">45</span> :
            <span class="px-2.5 py-1 bg-white rounded-md shadow-xs">18</span>
          </div>
        </div>

        <a href="{{ $mvRoute('store.shop', ['collection' => 'flash-sale']) }}"
           class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-bold text-xs rounded-full backdrop-blur-xs transition-colors shrink-0">
          View All Deals &rarr;
        </a>
      </div>

      <!-- Flash Sale Products Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        @foreach($flashSaleProducts as $prod)
          @include('store.themes.marketverse.partials.product-card', ['product' => $prod])
        @endforeach
      </div>

    </div>
  </section>

  <!-- =========================================================================
       6. COUPONS & DEALS CENTER (5 Coupon Badges)
       ========================================================================= -->
  <section id="coupons-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          Coupons & Deals Center
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Collect coupons and save big on your orders.</p>
      </div>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All Coupons &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      @foreach($coupons as $c)
        <div class="rounded-2xl border p-4 flex flex-col justify-between gap-3 shadow-xs {{ $c['bg'] }}">
          <div>
            <span class="text-xl sm:text-2xl font-black block tracking-tight">{{ $c['discount'] }}</span>
            <span class="text-xs font-medium opacity-80">{{ $c['desc'] }}</span>
          </div>
          <div class="flex items-center justify-between pt-2 border-t border-current/15">
            <span class="font-mono font-bold text-xs bg-white/80 px-2 py-1 rounded">Code: {{ $c['code'] }}</span>
            <button type="button"
                    onclick="alert('Coupon {{ $c['code'] }} collected!')"
                    class="text-[11px] font-extrabold underline hover:opacity-75">
              Collect
            </button>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       7. SHOP BY BRAND
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
        Shop by Brand
      </h2>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All Brands &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
      @foreach($brands as $b)
        <a href="{{ $mvRoute('store.shop', ['brand' => $b['name']]) }}"
           class="bg-white rounded-2xl border border-mv-border p-3 text-center flex items-center justify-center mv-card h-20 group hover:border-mv-purple transition-all shadow-xs">
          <img src="{{ global_asset('images/themes/marketverse/' . $b['logo']) }}"
               alt="{{ $b['name'] }}"
               class="max-h-10 max-w-[85%] object-contain group-hover:scale-110 transition-transform duration-300">
        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       8. RECOMMENDED FOR YOU (6 Products)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          Recommended For You
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Personalized recommendations based on your browsing.</p>
      </div>
      <a href="{{ $mvRoute('store.shop', ['collection' => 'recommended']) }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
      @foreach($recommendedProducts as $prod)
        @include('store.themes.marketverse.partials.product-card', ['product' => $prod])
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       9. PROMOTIONAL BANNERS GRID (3 Banners)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Banner 1: Vendor Spotlight (TechWorld) -->
      <div class="rounded-3xl relative text-white p-7 flex flex-col justify-between min-h-[260px] shadow-sm overflow-hidden group">
        <img src="{{ global_asset('images/themes/marketverse/promo-vendor-spotlight.jpg') }}"
             alt="TechWorld Electronics Spotlight"
             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-gradient-to-t from-[#1F0E54]/95 via-[#2D1680]/75 to-transparent"></div>
        <div class="space-y-2 relative z-10">
          <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-300">Vendor Spotlight</span>
          <h3 class="text-2xl font-black leading-tight">TechWorld Electronics</h3>
          <p class="text-xs text-slate-200">★★★★★ Top Rated Seller • Up to 40% OFF on Bestselling Electronics</p>
        </div>
        <div class="pt-4 relative z-10">
          <a href="{{ $mvRoute('store.shop', ['category' => 'Electronics']) }}" class="inline-block px-5 py-2.5 bg-white text-mv-purple font-extrabold text-xs rounded-full shadow-md hover:bg-slate-100 transition-colors">
            Visit Store &rarr;
          </a>
        </div>
      </div>

      <!-- Banner 2: Home Essentials -->
      <div class="rounded-3xl relative text-white p-7 flex flex-col justify-between min-h-[260px] shadow-sm overflow-hidden group">
        <img src="{{ global_asset('images/themes/marketverse/promo-home-essentials.jpg') }}"
             alt="Home Essentials"
             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-gradient-to-t from-[#064E3B]/95 via-[#0F766E]/75 to-transparent"></div>
        <div class="space-y-2 relative z-10">
          <span class="text-[10px] font-extrabold uppercase tracking-wider text-teal-200">Mega Savings</span>
          <h3 class="text-2xl font-black leading-tight">Home Essentials</h3>
          <p class="text-xs text-slate-200">Sofas, kitchenware & decor • Up to 60% OFF</p>
        </div>
        <div class="pt-4 relative z-10">
          <a href="{{ $mvRoute('store.shop', ['category' => 'Home & Living']) }}" class="inline-block px-5 py-2.5 bg-white text-teal-800 font-extrabold text-xs rounded-full shadow-md hover:bg-slate-100 transition-colors">
            Shop Now &rarr;
          </a>
        </div>
      </div>

      <!-- Banner 3: Fashion Drop -->
      <div class="rounded-3xl relative text-white p-7 flex flex-col justify-between min-h-[260px] shadow-sm overflow-hidden group">
        <img src="{{ global_asset('images/themes/marketverse/promo-fashion-drop.jpg') }}"
             alt="Fashion Drop"
             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute inset-0 bg-gradient-to-t from-[#881337]/95 via-[#BE185D]/75 to-transparent"></div>
        <div class="space-y-2 relative z-10">
          <span class="text-[10px] font-extrabold uppercase tracking-wider text-rose-200">New Collection</span>
          <h3 class="text-2xl font-black leading-tight">Fashion Drop</h3>
          <p class="text-xs text-slate-200">Trendy apparel, footwear & bags • Extra 25% OFF</p>
        </div>
        <div class="pt-4 relative z-10">
          <a href="{{ $mvRoute('store.shop', ['category' => 'Fashion']) }}" class="inline-block px-5 py-2.5 bg-white text-rose-700 font-extrabold text-xs rounded-full shadow-md hover:bg-slate-100 transition-colors">
            Shop Now &rarr;
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       10. NEW ARRIVALS (6 Products)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          New Arrivals
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">Freshly listed products from verified vendors.</p>
      </div>
      <a href="{{ $mvRoute('store.shop', ['collection' => 'new-arrivals']) }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
      @foreach($newArrivals as $prod)
        @include('store.themes.marketverse.partials.product-card', ['product' => $prod])
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       11. WHAT CUSTOMERS SAY (Testimonials)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
        What Customers Say
      </h2>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
        View All Reviews &rarr;
      </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach($testimonials as $t)
        <div class="bg-white rounded-2xl border border-mv-border p-5 flex flex-col justify-between space-y-3 shadow-xs">
          <div class="space-y-2">
            <div class="flex items-center gap-1 text-amber-500 text-xs">
              ★★★★★
            </div>
            <p class="text-xs text-slate-600 leading-relaxed italic">
              "{{ $t['text'] }}"
            </p>
          </div>
          <div class="pt-2 border-t border-slate-100 flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-mv-purpleLight text-mv-purple font-bold text-xs flex items-center justify-center">
              {{ substr($t['name'], 0, 1) }}
            </div>
            <div>
              <h5 class="text-xs font-bold text-slate-900">{{ $t['name'] }}</h5>
              <span class="text-[10px] text-slate-400 block">{{ $t['role'] }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       12. APP PROMOTION BANNER
       ========================================================================= -->
  <section id="app-download" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="rounded-3xl bg-[#220F63] text-white p-6 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-md border-2 border-mv-purple">
      <div class="space-y-2 text-center md:text-left">
        <span class="text-xs font-extrabold uppercase tracking-wider text-amber-300">Shop Smarter On The Go</span>
        <h3 class="text-2xl sm:text-3xl font-black tracking-tight">
          Shop Smarter with MarketVerse App
        </h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-md">
          Exclusive app discounts, flash sale notifications & real-time order tracking.
        </p>
      </div>

      <div class="flex flex-wrap items-center justify-center gap-3">
        <div class="px-5 py-2.5 bg-black/40 border border-white/20 rounded-xl flex items-center gap-2 text-xs font-bold cursor-pointer hover:bg-black/60 transition-colors">
          <span>▶ Google Play</span>
        </div>
        <div class="px-5 py-2.5 bg-black/40 border border-white/20 rounded-xl flex items-center gap-2 text-xs font-bold cursor-pointer hover:bg-black/60 transition-colors">
          <span>🍏 App Store</span>
        </div>
        <a href="{{ $shopUrl }}" class="px-6 py-2.5 bg-mv-orange hover:bg-mv-orangeHover text-white font-extrabold text-xs rounded-xl shadow-md transition-colors">
          Scan to Download
        </a>
      </div>
    </div>
  </section>

</div>
@endsection
