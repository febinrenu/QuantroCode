{{-- AurumÉclat Luxury Header --}}
@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'aurumeclat');
  $aurumRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<!-- TOP ANNOUNCEMENT BAR (Desktop) -->
<div class="hidden lg:block bg-[#0A0908] border-b border-aurum-border/60 text-[11px] py-2.5 px-6">
  <div class="max-w-7xl mx-auto flex items-center justify-between text-aurum-goldLight/75">
    
    <div class="flex items-center gap-2">
      <svg class="w-3.5 h-3.5 text-aurum-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      <span class="font-medium text-white/90">Private Appointments</span>
      <span class="text-white/40">•</span>
      <span class="text-aurum-goldLight/60">Book Your Time</span>
    </div>

    <div class="flex items-center gap-2">
      <svg class="w-3.5 h-3.5 text-aurum-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon></svg>
      <span class="font-medium text-white/90">IGI Certified Diamonds</span>
      <span class="text-white/40">•</span>
      <span class="text-aurum-goldLight/60">Authenticity Guaranteed</span>
    </div>

    <div class="flex items-center gap-2">
      <svg class="w-3.5 h-3.5 text-aurum-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
      <span class="font-medium text-white/90">Lifetime Polishing</span>
      <span class="text-white/40">•</span>
      <span class="text-aurum-goldLight/60">Complimentary Forever</span>
    </div>

    <div class="flex items-center gap-2">
      <svg class="w-3.5 h-3.5 text-aurum-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
      <span class="font-medium text-white/90">Free Insured Shipping</span>
      <span class="text-white/40">•</span>
      <span class="text-aurum-goldLight/60">On All Orders</span>
    </div>

  </div>
</div>

<!-- MAIN UPPER HEADER -->
<header class="sticky top-0 z-40 bg-[#0E0D0B]/95 backdrop-blur-md border-b border-aurum-border">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
    
    <!-- Left: Currency & Boutique (Desktop) / Hamburger (Mobile) -->
    <div class="flex items-center gap-6">
      <button type="button" id="mobile-menu-btn" class="lg:hidden text-aurum-goldLight hover:text-aurum-gold p-1 focus:outline-none" aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
      </button>

      <div class="hidden lg:flex items-center gap-4 text-xs text-aurum-goldLight/80">
        <div class="relative flex items-center gap-1 cursor-pointer hover:text-aurum-gold transition-colors">
          <span>USD $</span>
          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
        <span class="text-aurum-border">|</span>
        <a href="#boutique-section" class="flex items-center gap-1.5 hover:text-aurum-gold transition-colors">
          <svg class="w-3.5 h-3.5 text-aurum-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
          <span>Find a Boutique</span>
        </a>
      </div>
    </div>

    <!-- Center: Brand Logo -->
    <div class="text-center">
      <a href="{{ $aurumRoute('store.index') }}" class="inline-block group">
        <div class="flex items-center justify-center gap-2">
          <span class="text-aurum-gold text-xs">✦</span>
          <span class="font-serif tracking-[0.25em] text-xl sm:text-2xl lg:text-[26px] font-medium text-white group-hover:text-aurum-gold transition-colors uppercase">
            AURUMÉCLAT
          </span>
          <span class="text-aurum-gold text-xs">✦</span>
        </div>
        <div class="text-[9px] sm:text-[10px] tracking-[0.35em] text-aurum-goldLight/70 uppercase font-light -mt-0.5">
          FINE JEWELRY
        </div>
      </a>
    </div>

    <!-- Right: Utility Actions (Search, Wishlist, Account, Cart) -->
    <div class="flex items-center gap-3 sm:gap-5 text-aurum-goldLight">
      
      <!-- Search Toggle -->
      <button type="button" id="search-modal-btn" class="p-1 hover:text-aurum-gold transition-colors" aria-label="Search">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      </button>

      <!-- Wishlist -->
      <a href="{{ $aurumRoute('store.shop', ['collection' => 'bestselling']) }}" class="hidden sm:inline-block p-1 hover:text-aurum-gold transition-colors" aria-label="Wishlist">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
      </a>

      <!-- Account -->
      @if(Auth::guard('store')->check())
        <a href="{{ $aurumRoute('account') }}" class="p-1 hover:text-aurum-gold transition-colors" aria-label="My Account">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </a>
      @else
        <a href="{{ $aurumRoute('store.login.show') }}" class="p-1 hover:text-aurum-gold transition-colors" aria-label="Sign In">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </a>
      @endif

      <!-- Bag / Cart -->
      <a href="{{ $aurumRoute('store.cart') }}" class="relative p-1 text-aurum-goldLight hover:text-aurum-gold transition-colors" aria-label="Shopping Bag">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <path d="M16 10a4 4 0 0 1-8 0"></path>
        </svg>
        <span class="js-cart-count absolute -top-1 -right-1 bg-aurum-gold text-aurum-black text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">0</span>
      </a>

    </div>
  </div>

  <!-- SECONDARY CATEGORY NAVIGATION (Desktop) -->
  <nav class="hidden lg:block border-t border-aurum-border/75 bg-[#0C0B0A]">
    <div class="max-w-7xl mx-auto px-6">
      <ul class="flex items-center justify-center gap-7 xl:gap-9 py-3 text-[11px] font-medium tracking-[0.16em] uppercase text-aurum-goldLight/85">
        <li>
          <a href="{{ $aurumRoute('store.shop', ['sort' => 'latest']) }}" class="hover:text-aurum-gold transition-colors">NEW ARRIVALS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'ring']) }}" class="hover:text-aurum-gold transition-colors">RINGS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'necklace']) }}" class="hover:text-aurum-gold transition-colors">NECKLACES</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'earring']) }}" class="hover:text-aurum-gold transition-colors">EARRINGS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'bracelet']) }}" class="hover:text-aurum-gold transition-colors">BRACELETS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'bridal']) }}" class="hover:text-aurum-gold transition-colors text-aurum-gold">BRIDAL</a>
        </li>
        <li>
          <a href="#custom-design-section" class="hover:text-aurum-gold transition-colors">CUSTOM DESIGN</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'diamond']) }}" class="hover:text-aurum-gold transition-colors">DIAMONDS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'gold coin']) }}" class="hover:text-aurum-gold transition-colors">GOLD COINS</a>
        </li>
        <li>
          <a href="{{ $aurumRoute('store.shop') }}" class="hover:text-aurum-gold transition-colors">COLLECTIONS</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
