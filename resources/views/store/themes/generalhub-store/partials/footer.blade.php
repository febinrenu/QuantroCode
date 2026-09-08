{{-- GeneralHub Footer Component --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<!-- 1. NEWSLETTER & EXCLUSIVE DEALS BANNER (Deep Navy #0B286D) -->
<section class="bg-hub-navy text-white py-10 px-4 sm:px-6 lg:px-8">
  <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-6">
    
    <!-- Left: Envelope Icon & Copy -->
    <div class="flex items-center gap-4 text-center lg:text-left">
      <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-white shrink-0 border border-white/15">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
      </div>
      <div>
        <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
          Stay Updated with Exclusive Deals!
        </h3>
        <p class="text-xs sm:text-sm text-slate-300 font-normal mt-0.5">
          Subscribe to our newsletter and get 10% off your first order.
        </p>
      </div>
    </div>

    <!-- Right: Subscription Form -->
    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w-full max-w-md flex items-center bg-white rounded-lg p-1.5 shadow-lg">
      @csrf
      <input type="email" 
             name="email" 
             required 
             placeholder="Enter your email address" 
             class="w-full text-xs sm:text-sm text-slate-800 placeholder-slate-400 px-3.5 py-2 outline-none">
      <button type="submit" class="bg-hub-blue hover:bg-hub-blueHover text-white text-xs sm:text-sm font-semibold px-6 py-2.5 rounded-md transition-colors shrink-0">
        Subscribe
      </button>
    </form>

  </div>
</section>

<!-- 2. MAIN FOOTER (Desktop & Mobile) -->
<footer id="contact-section" class="bg-white border-t border-slate-200 text-slate-600 pt-14 pb-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- DESKTOP GRID -->
    <div class="hidden lg:grid grid-cols-12 gap-8 pb-12 border-b border-slate-200">
      
      <!-- Column 1: Brand & About (3 cols) -->
      <div class="col-span-3 space-y-4">
        <a href="{{ $hubRoute('store.index') }}" class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-hub-blue flex items-center justify-center text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
          </div>
          <span class="text-xl font-bold text-slate-900">General<span class="text-hub-blue">Hub</span></span>
        </a>
        <p class="text-xs text-slate-500 leading-relaxed">
          Your one-stop destination for quality products across multiple categories.
        </p>
        
        <!-- Social Icons -->
        <div class="flex items-center gap-2.5 pt-1 text-slate-400">
          <a href="#" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:text-hub-blue hover:border-hub-blue transition-colors" aria-label="Facebook">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:text-hub-blue hover:border-hub-blue transition-colors" aria-label="Twitter">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:text-hub-blue hover:border-hub-blue transition-colors" aria-label="Instagram">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center hover:text-hub-blue hover:border-hub-blue transition-colors" aria-label="YouTube">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
        </div>
      </div>

      <!-- Column 2: Shop (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Shop</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="{{ $hubRoute('store.shop') }}" class="hover:text-hub-blue transition-colors">All Categories</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['collection' => 'featured']) }}" class="hover:text-hub-blue transition-colors">Featured Products</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['collection' => 'bestselling']) }}" class="hover:text-hub-blue transition-colors">Best Sellers</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['sort' => 'latest']) }}" class="hover:text-hub-blue transition-colors">New Arrivals</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['collection' => 'deals']) }}" class="hover:text-hub-blue transition-colors">Deals of the Day</a></li>
        </ul>
      </div>

      <!-- Column 3: Customer Service (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Customer Service</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="#track-order" class="hover:text-hub-blue transition-colors">Track Order</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Returns &amp; Refunds</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Shipping Policy</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">FAQs</a></li>
          <li><a href="#contact-section" class="hover:text-hub-blue transition-colors">Contact Us</a></li>
        </ul>
      </div>

      <!-- Column 4: Company (2 cols) -->
      <div id="about-section" class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Company</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-hub-blue transition-colors">About Us</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Careers</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Press &amp; Media</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Affiliate Program</a></li>
          <li><a href="#" class="hover:text-hub-blue transition-colors">Sitemap</a></li>
        </ul>
      </div>

      <!-- Column 5: Contact Us (3 cols) -->
      <div class="col-span-3 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Contact Us</h4>
        <div class="space-y-2 text-xs text-slate-500">
          <div class="flex items-center gap-2 text-slate-800 font-semibold">
            <span>📞</span>
            <span>+1 (800) 123-4567</span>
          </div>
          <div class="flex items-center gap-2">
            <span>✉️</span>
            <span>support@generalhub.com</span>
          </div>
          <div class="flex items-start gap-2">
            <span>📍</span>
            <span>123 Commerce St, Suite 500, New York, NY 10001</span>
          </div>
        </div>
      </div>

    </div>

    <!-- MOBILE ACCORDION FOOTER -->
    <div class="lg:hidden divide-y divide-slate-200 pb-8">
      
      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Shop</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="{{ $hubRoute('store.shop') }}" class="hover:text-hub-blue">All Categories</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['collection' => 'featured']) }}" class="hover:text-hub-blue">Featured Products</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['collection' => 'bestselling']) }}" class="hover:text-hub-blue">Best Sellers</a></li>
          <li><a href="{{ $hubRoute('store.shop', ['sort' => 'latest']) }}" class="hover:text-hub-blue">New Arrivals</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Customer Service</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-hub-blue">Track Order</a></li>
          <li><a href="#" class="hover:text-hub-blue">Returns &amp; Refunds</a></li>
          <li><a href="#" class="hover:text-hub-blue">Shipping Policy</a></li>
          <li><a href="#" class="hover:text-hub-blue">FAQs</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Company</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-hub-blue">About Us</a></li>
          <li><a href="#" class="hover:text-hub-blue">Careers</a></li>
          <li><a href="#" class="hover:text-hub-blue">Press &amp; Media</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Account</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="{{ $hubRoute('account') }}" class="hover:text-hub-blue">My Account</a></li>
          <li><a href="{{ $hubRoute('store.login.show') }}" class="hover:text-hub-blue">Sign In / Register</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Contact Us</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <div class="pt-3 pl-2 space-y-1.5 text-xs text-slate-500">
          <p class="font-semibold text-slate-800">+1 (800) 123-4567</p>
          <p>support@generalhub.com</p>
          <p>123 Commerce St, Suite 500, New York, NY 10001</p>
        </div>
      </details>

    </div>

    <!-- Bottom Copyright & Payment Methods -->
    <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
      <div>
        &copy; {{ date('Y') }} GeneralHub. All rights reserved.
      </div>
      
      <!-- Payment Methods -->
      <div class="flex items-center gap-2">
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">VISA</span>
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">MC</span>
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">AMEX</span>
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">PayPal</span>
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">Pay</span>
        <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded font-bold text-[10px] text-slate-600">GPay</span>
      </div>
    </div>

  </div>
</footer>
