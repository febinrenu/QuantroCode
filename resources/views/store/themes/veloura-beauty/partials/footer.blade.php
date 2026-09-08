@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $velRoute('store.shop');
@endphp

<footer class="bg-vel-espresso text-white pt-16 pb-12 border-t border-vel-espresso/80">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    <!-- Newsletter & Brand Strip -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-12 border-b border-white/10 items-center">
      <div class="lg:col-span-6 space-y-2">
        <span class="font-serif-luxury text-2xl sm:text-3xl font-bold tracking-widest text-white block">
          VELOURA BEAUTY
        </span>
        <p class="text-xs sm:text-sm text-slate-300 font-light max-w-md">
          Join the Veloura Inner Circle. Receive complimentary deluxe miniatures, bespoke ritual guides, and exclusive private sale invitations.
        </p>
      </div>

      <div class="lg:col-span-6">
        <form class="flex flex-col sm:flex-row gap-3" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Veloura Beauty!')">
          <input type="email"
                 required
                 placeholder="Enter your email address..."
                 class="flex-1 bg-white/10 border border-white/20 rounded-full px-5 py-3 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-vel-rose focus:bg-white/15 transition-all">
          <button type="submit"
                  class="px-8 py-3 bg-vel-rose hover:bg-vel-roseDark text-white font-bold text-xs rounded-full shadow-md active:scale-95 transition-all uppercase tracking-wider">
            Subscribe
          </button>
        </form>
      </div>
    </div>

    <!-- 5-Column Navigation Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-xs">

      <!-- Col 1: Shop -->
      <div class="space-y-3">
        <h4 class="font-serif-luxury text-sm font-bold tracking-wider text-rose-200 uppercase">
          Shop
        </h4>
        <ul class="space-y-2 text-slate-300">
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Fragrance']) }}" class="hover:text-rose-200 transition-colors">Fragrance</a></li>
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Skincare']) }}" class="hover:text-rose-200 transition-colors">Skincare</a></li>
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Makeup']) }}" class="hover:text-rose-200 transition-colors">Makeup</a></li>
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Bath & Body']) }}" class="hover:text-rose-200 transition-colors">Bath & Body</a></li>
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Hair Care']) }}" class="hover:text-rose-200 transition-colors">Hair Care</a></li>
          <li><a href="{{ $velRoute('store.shop', ['category' => 'Gift Sets']) }}" class="hover:text-rose-200 transition-colors">Gift Sets</a></li>
          <li><a href="{{ $velRoute('store.shop', ['collection' => 'new-in']) }}" class="hover:text-rose-200 transition-colors">New Arrivals</a></li>
          <li><a href="{{ $velRoute('store.shop', ['collection' => 'bestsellers']) }}" class="hover:text-rose-200 transition-colors">Bestsellers</a></li>
        </ul>
      </div>

      <!-- Col 2: Help & Support -->
      <div class="space-y-3">
        <h4 class="font-serif-luxury text-sm font-bold tracking-wider text-rose-200 uppercase">
          Client Care
        </h4>
        <ul class="space-y-2 text-slate-300">
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Order Tracking</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Shipping & Delivery</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Complimentary Returns</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Frequently Asked Questions</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Contact Beauty Advisors</a></li>
        </ul>
      </div>

      <!-- Col 3: About Veloura -->
      <div class="space-y-3">
        <h4 class="font-serif-luxury text-sm font-bold tracking-wider text-rose-200 uppercase">
          The Maison
        </h4>
        <ul class="space-y-2 text-slate-300">
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Our Philosophy</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Clean Formulations</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Sustainable Packaging</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Boutique Locations</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Careers at Veloura</a></li>
        </ul>
      </div>

      <!-- Col 4: Beauty Services -->
      <div class="space-y-3">
        <h4 class="font-serif-luxury text-sm font-bold tracking-wider text-rose-200 uppercase">
          Services
        </h4>
        <ul class="space-y-2 text-slate-300">
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Virtual Skin Consultation</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Signature Fragrance Finder</a></li>
          <li><a href="{{ $shopUrl }}" class="hover:text-rose-200 transition-colors">Bespoke Gift Boxing</a></li>
          <li><a href="#veloura-club" class="hover:text-rose-200 transition-colors">Veloura Club Membership</a></li>
        </ul>
      </div>

      <!-- Col 5: Promises & Badges -->
      <div class="space-y-3">
        <h4 class="font-serif-luxury text-sm font-bold tracking-wider text-rose-200 uppercase">
          Our Guarantees
        </h4>
        <div class="space-y-2 text-slate-300 text-xs">
          <div class="flex items-center gap-2">
            <span>🌿</span> 100% Cruelty-Free & Clean
          </div>
          <div class="flex items-center gap-2">
            <span>✨</span> 3 Free Samples per Order
          </div>
          <div class="flex items-center gap-2">
            <span>🚚</span> Free Carbon-Neutral Shipping
          </div>
          <div class="flex items-center gap-2">
            <span>🔄</span> 30-Day Happiness Guarantee
          </div>
        </div>
      </div>

    </div>

    <!-- Bottom Legal Row -->
    <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-400">
      <p>&copy; {{ date('Y') }} Veloura Beauty Maison. All rights reserved.</p>
      <div class="flex items-center gap-6">
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Privacy Policy</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Terms of Service</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Accessibility</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Cookies</a>
      </div>
    </div>

  </div>
</footer>
