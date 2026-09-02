{{-- VogueLane Footer Component --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<footer class="bg-white border-t border-vog-border text-slate-600 pt-14 pb-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- DESKTOP FOOTER GRID -->
    <div class="hidden lg:grid grid-cols-12 gap-8 pb-12 border-b border-vog-border">
      
      <!-- Col 1: Brand & Bio (3 cols) -->
      <div class="col-span-3 space-y-4">
        <a href="{{ $vogRoute('store.index') }}" class="inline-block">
          <span class="font-serif-luxury text-2xl font-bold tracking-tight text-slate-900">
            Vogue<span class="text-vog-tan italic font-normal">Lane</span>
          </span>
        </a>
        <p class="text-xs text-slate-500 leading-relaxed pr-4">
          Your destination for timeless fashion and modern elegance. Curated luxury styles crafted for every moment.
        </p>
        
        <!-- Social Icons -->
        <div class="flex items-center gap-3 pt-2 text-slate-400">
          <a href="#" class="w-8 h-8 rounded-full border border-vog-border flex items-center justify-center hover:text-black hover:border-black transition-colors" aria-label="Instagram">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-vog-border flex items-center justify-center hover:text-black hover:border-black transition-colors" aria-label="Facebook">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-vog-border flex items-center justify-center hover:text-black hover:border-black transition-colors" aria-label="Pinterest">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0a12 12 0 0 0-4.37 23.18c-.05-.98-.1-2.48.02-3.55l1.04-4.42s-.26-.53-.26-1.31c0-1.23.71-2.15 1.6-2.15.76 0 1.12.57 1.12 1.25 0 .76-.48 1.9-0.73 2.96-.21.88.44 1.6 1.3 1.6 1.57 0 2.78-1.65 2.78-4.04 0-2.11-1.52-3.58-3.68-3.58-2.51 0-3.98 1.88-3.98 3.82 0 .76.29 1.57.66 2.01.07.09.08.17.06.26l-.25 1.02c-.04.16-.13.2-.3.12-1.12-.52-1.82-2.16-1.82-3.48 0-2.83 2.06-5.43 5.94-5.43 3.12 0 5.54 2.22 5.54 5.19 0 3.1-1.95 5.59-4.66 5.59-.91 0-1.77-.47-2.06-1.03l-.56 2.14c-.2 1.05-.75 2.37-1.12 3.2A12 12 0 1 0 12 0z"/></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full border border-vog-border flex items-center justify-center hover:text-black hover:border-black transition-colors" aria-label="TikTok">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-1.01v8.42c0 1.2-.23 2.4-.73 3.49-.69 1.48-1.84 2.72-3.25 3.51-1.44.81-3.11 1.2-4.76 1.11-2.02-.11-3.96-.99-5.36-2.45-1.47-1.54-2.26-3.66-2.17-5.78.09-2.07.96-4.07 2.45-5.52 1.46-1.42 3.45-2.22 5.5-2.23.36 0 .72.03 1.08.08v4.16c-.34-.07-.69-.1-1.04-.08-1.09.03-2.14.54-2.82 1.39-.7 1.08-.75 2.52-.15 3.65.59 1.11 1.79 1.77 3.05 1.66 1.08-.09 2.04-.79 2.44-1.8.23-.58.33-1.21.32-1.83V.02z"/></svg>
          </a>
        </div>
      </div>

      <!-- Col 2: Shop (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Shop</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="{{ $vogRoute('store.shop', ['collection' => 'new-in']) }}" class="hover:text-vog-tan transition-colors">New In</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" class="hover:text-vog-tan transition-colors">Women</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['category' => 'Men']) }}" class="hover:text-vog-tan transition-colors">Men</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['category' => 'Shoes']) }}" class="hover:text-vog-tan transition-colors">Shoes</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['category' => 'Bags']) }}" class="hover:text-vog-tan transition-colors">Bags</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['collection' => 'sale']) }}" class="hover:text-vog-sale transition-colors text-vog-sale font-semibold">Sale</a></li>
        </ul>
      </div>

      <!-- Col 3: Customer Care (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Customer Care</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-vog-tan transition-colors">Contact Us</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">FAQs</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Shipping &amp; Delivery</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Returns &amp; Refunds</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Size Guide</a></li>
        </ul>
      </div>

      <!-- Col 4: About (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">About</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-vog-tan transition-colors">Our Story</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Careers</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Sustainability</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Press</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Affiliates</a></li>
        </ul>
      </div>

      <!-- Col 5: Account (1.5 cols) -->
      <div class="col-span-1.5 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Account</h4>
        <ul class="space-y-2 text-xs text-slate-500">
          <li><a href="{{ $vogRoute('account') }}" class="hover:text-vog-tan transition-colors">My Account</a></li>
          <li><a href="{{ $vogRoute('account') }}" class="hover:text-vog-tan transition-colors">Orders</a></li>
          <li><a href="{{ $vogRoute('store.shop', ['collection' => 'featured']) }}" class="hover:text-vog-tan transition-colors">Wishlist</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Track Order</a></li>
          <li><a href="#" class="hover:text-vog-tan transition-colors">Gift Cards</a></li>
        </ul>
      </div>

      <!-- Col 6: Get in Touch (2 cols) -->
      <div class="col-span-2 space-y-3">
        <h4 class="text-xs font-bold tracking-wider text-slate-900 uppercase">Get In Touch</h4>
        <div class="space-y-2.5 text-xs text-slate-500">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            <span>hello@voguelane.com</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
            <span>+1 (800) 123-4567</span>
          </div>
        </div>
      </div>

    </div>

    <!-- MOBILE ACCORDION FOOTER -->
    <div class="lg:hidden divide-y divide-vog-border pb-8">
      
      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Customer Care</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-vog-tan">Contact Us</a></li>
          <li><a href="#" class="hover:text-vog-tan">FAQs</a></li>
          <li><a href="#" class="hover:text-vog-tan">Shipping &amp; Returns</a></li>
          <li><a href="#" class="hover:text-vog-tan">Size Guide</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>About VogueLane</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="#" class="hover:text-vog-tan">Our Story</a></li>
          <li><a href="#" class="hover:text-vog-tan">Careers</a></li>
          <li><a href="#" class="hover:text-vog-tan">Sustainability</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>My Account</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <ul class="pt-3 pl-2 space-y-2 text-xs text-slate-500">
          <li><a href="{{ $vogRoute('account') }}" class="hover:text-vog-tan">My Account</a></li>
          <li><a href="{{ $vogRoute('store.login.show') }}" class="hover:text-vog-tan">Sign In / Register</a></li>
        </ul>
      </details>

      <details class="group py-3">
        <summary class="flex items-center justify-between text-xs font-bold text-slate-900 uppercase cursor-pointer list-none">
          <span>Get in Touch</span>
          <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
        </summary>
        <div class="pt-3 pl-2 space-y-1.5 text-xs text-slate-500">
          <p class="font-medium text-slate-800">+1 (800) 123-4567</p>
          <p class="text-slate-600">hello@voguelane.com</p>
        </div>
      </details>

    </div>

    <!-- BOTTOM COPYRIGHT & LEGAL -->
    <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400">
      <p>&copy; {{ date('Y') }} VogueLane. All rights reserved.</p>
      <div class="flex items-center gap-4">
        <a href="#" class="hover:text-slate-700 transition-colors">Privacy Policy</a>
        <span>•</span>
        <a href="#" class="hover:text-slate-700 transition-colors">Terms &amp; Conditions</a>
        <span>•</span>
        <a href="#" class="hover:text-slate-700 transition-colors">Cookies</a>
      </div>
    </div>

  </div>
</footer>
