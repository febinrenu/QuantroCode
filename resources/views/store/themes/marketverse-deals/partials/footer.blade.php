@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $mvRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $mvRoute('store.shop');
  $homeUrl = $mvRoute('store.index');
@endphp

<footer class="bg-[#220F63] text-slate-300 pt-12 pb-24 md:pb-12 border-t-4 border-mv-purple">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Top 6-Column Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 pb-12 border-b border-white/10 text-xs">

      <!-- Col 1: Marketplace -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Marketplace</h4>
        <ul class="space-y-2">
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">About MarketVerse</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">How It Works</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Seller Directory</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Careers & Press</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Affiliate Program</a></li>
        </ul>
      </div>

      <!-- Col 2: Sell on MarketVerse -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Sell with Us</h4>
        <ul class="space-y-2">
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Become a Seller</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Seller Dashboard</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Seller Academy</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Fulfillment by MV</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Fee Schedule</a></li>
        </ul>
      </div>

      <!-- Col 3: Help Center -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Help Center</h4>
        <ul class="space-y-2">
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Customer Support</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Shipping & Delivery</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Returns & Refunds</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Order Tracking</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Report an Issue</a></li>
        </ul>
      </div>

      <!-- Col 4: Buyer Protection -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Buyer Protection</h4>
        <ul class="space-y-2">
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Safe & Secure Payments</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Money Back Guarantee</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Dispute Resolution</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Terms of Service</a></li>
        </ul>
      </div>

      <!-- Col 5: Popular Categories -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Top Categories</h4>
        <ul class="space-y-2">
          <li><a href="{{ $mvRoute('store.shop', ['category' => 'Fashion']) }}" class="hover:text-white transition-colors">Fashion & Apparel</a></li>
          <li><a href="{{ $mvRoute('store.shop', ['category' => 'Electronics']) }}" class="hover:text-white transition-colors">Consumer Electronics</a></li>
          <li><a href="{{ $mvRoute('store.shop', ['category' => 'Home & Living']) }}" class="hover:text-white transition-colors">Home & Living</a></li>
          <li><a href="{{ $mvRoute('store.shop', ['category' => 'Beauty & Personal Care']) }}" class="hover:text-white transition-colors">Beauty & Skincare</a></li>
          <li><a href="{{ $mvRoute('store.shop', ['category' => 'Sports & Outdoors']) }}" class="hover:text-white transition-colors">Sports & Fitness</a></li>
        </ul>
      </div>

      <!-- Col 6: Download App & Social -->
      <div class="space-y-3">
        <h4 class="text-white font-bold text-sm tracking-tight">Connect With Us</h4>
        <p class="text-[11px] text-slate-400">Get the MarketVerse App for exclusive deals.</p>
        <div class="flex items-center gap-3 pt-1">
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mv-purple flex items-center justify-center text-white transition-colors">
            f
          </a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mv-purple flex items-center justify-center text-white transition-colors">
            𝕏
          </a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mv-purple flex items-center justify-center text-white transition-colors">
            in
          </a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-mv-purple flex items-center justify-center text-white transition-colors">
            ▶
          </a>
        </div>
      </div>

    </div>

    <!-- Bottom Strip -->
    <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
      <div class="flex items-center gap-2">
        <div class="w-6 h-6 rounded-md bg-mv-purple text-white flex items-center justify-center font-black text-xs">
          MV
        </div>
        <span>&copy; {{ date('Y') }} MarketVerse Inc. All rights reserved. One Trusted Multi-Vendor Marketplace.</span>
      </div>

      <!-- Payment Badges -->
      <div class="flex items-center gap-2 text-[10px] font-semibold text-slate-300">
        <span class="px-2 py-1 bg-white/10 rounded">VISA</span>
        <span class="px-2 py-1 bg-white/10 rounded">Mastercard</span>
        <span class="px-2 py-1 bg-white/10 rounded">PayPal</span>
        <span class="px-2 py-1 bg-white/10 rounded">Apple Pay</span>
        <span class="px-2 py-1 bg-white/10 rounded">Google Pay</span>
      </div>
    </div>

  </div>
</footer>
