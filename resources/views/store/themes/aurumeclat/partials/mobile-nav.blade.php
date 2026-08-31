{{-- AurumÉclat Mobile Navigation Drawer --}}
<div id="mobile-menu-drawer" class="fixed inset-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden" aria-hidden="true">
  <!-- Backdrop -->
  <div id="mobile-menu-backdrop" class="fixed inset-0 bg-black/80 backdrop-blur-sm"></div>

  <!-- Drawer Container -->
  <div class="relative w-4/5 max-w-xs h-full bg-[#0E0D0B] border-r border-aurum-border flex flex-col z-10 overflow-y-auto">
    
    <!-- Top Header -->
    <div class="p-5 border-b border-aurum-border flex items-center justify-between">
      <div>
        <div class="font-serif tracking-[0.2em] text-lg font-medium text-white uppercase">AURUMÉCLAT</div>
        <div class="text-[9px] tracking-[0.3em] text-aurum-goldLight/70 uppercase">FINE JEWELRY</div>
      </div>
      <button type="button" id="mobile-menu-close-btn" class="p-1 text-aurum-goldLight hover:text-aurum-gold" aria-label="Close menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    </div>

    <!-- Quick Search -->
    <div class="p-4 border-b border-aurum-border/50">
      <form action="{{ route('store.shop') }}" method="GET" class="relative">
        <input type="text" name="q" placeholder="Search fine jewelry..." class="w-full bg-[#161411] border border-aurum-border text-xs text-white placeholder-aurum-goldLight/40 px-3 py-2.5 rounded-none focus:outline-none focus:border-aurum-gold">
        <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-aurum-goldLight/60 hover:text-aurum-gold">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
      </form>
    </div>

    <!-- Quick Category Circular Shortcuts -->
    <div class="p-4 grid grid-cols-4 gap-2 border-b border-aurum-border/50 text-center">
      <a href="#gold-rate-section" class="flex flex-col items-center gap-1.5 group">
        <div class="w-11 h-11 rounded-full bg-[#181613] border border-aurum-gold/40 flex items-center justify-center text-aurum-gold group-hover:border-aurum-gold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg>
        </div>
        <span class="text-[10px] text-aurum-goldLight/80">Gold Rate</span>
      </a>
      <a href="{{ route('store.shop', ['q' => 'diamond']) }}" class="flex flex-col items-center gap-1.5 group">
        <div class="w-11 h-11 rounded-full bg-[#181613] border border-aurum-gold/40 flex items-center justify-center text-aurum-gold group-hover:border-aurum-gold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon></svg>
        </div>
        <span class="text-[10px] text-aurum-goldLight/80">Diamonds</span>
      </a>
      <a href="#custom-design-section" class="flex flex-col items-center gap-1.5 group">
        <div class="w-11 h-11 rounded-full bg-[#181613] border border-aurum-gold/40 flex items-center justify-center text-aurum-gold group-hover:border-aurum-gold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        </div>
        <span class="text-[10px] text-aurum-goldLight/80">Custom</span>
      </a>
      <a href="{{ route('store.shop', ['q' => 'bridal']) }}" class="flex flex-col items-center gap-1.5 group">
        <div class="w-11 h-11 rounded-full bg-[#181613] border border-aurum-gold/40 flex items-center justify-center text-aurum-gold group-hover:border-aurum-gold">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="12" r="4"></circle><circle cx="15" cy="12" r="4"></circle></svg>
        </div>
        <span class="text-[10px] text-aurum-goldLight/80">Bridal</span>
      </a>
    </div>

    <!-- Navigation Links -->
    <nav class="p-5 flex-1 space-y-3.5 text-xs font-medium tracking-[0.14em] uppercase text-aurum-goldLight/90">
      <div><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="block py-1 hover:text-aurum-gold">NEW ARRIVALS</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'ring']) }}" class="block py-1 hover:text-aurum-gold">RINGS</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'necklace']) }}" class="block py-1 hover:text-aurum-gold">NECKLACES</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'earring']) }}" class="block py-1 hover:text-aurum-gold">EARRINGS</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'bracelet']) }}" class="block py-1 hover:text-aurum-gold">BRACELETS</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'bridal']) }}" class="block py-1 text-aurum-gold font-semibold">BRIDAL &amp; WEDDING</a></div>
      <div><a href="#custom-design-section" class="block py-1 hover:text-aurum-gold">CUSTOM DESIGN</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'diamond']) }}" class="block py-1 hover:text-aurum-gold">DIAMONDS</a></div>
      <div><a href="{{ route('store.shop', ['q' => 'gold coin']) }}" class="block py-1 hover:text-aurum-gold">GOLD COINS</a></div>
      <div><a href="{{ route('store.shop') }}" class="block py-1 hover:text-aurum-gold">COLLECTIONS</a></div>
    </nav>

    <!-- Bottom Actions -->
    <div class="p-5 bg-[#0A0908] border-t border-aurum-border space-y-3 text-xs">
      <a href="#private-appointment-section" class="block w-full text-center py-2.5 bg-aurum-gold text-aurum-black font-semibold tracking-wider text-[11px] uppercase">
        BOOK APPOINTMENT
      </a>
      <div class="pt-2 flex items-center justify-between text-[11px] text-aurum-goldLight/70">
        <a href="{{ route('store.login.show') }}" class="hover:text-aurum-gold">Account / Sign In</a>
        <a href="#boutique-section" class="hover:text-aurum-gold">Find Boutique</a>
      </div>
    </div>

  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('mobile-menu-close-btn');
    const backdrop = document.getElementById('mobile-menu-backdrop');
    const drawer = document.getElementById('mobile-menu-drawer');

    function toggleMenu(show) {
      if (show) {
        drawer.classList.remove('-translate-x-full');
        drawer.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      } else {
        drawer.classList.add('-translate-x-full');
        drawer.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
      }
    }

    if (openBtn) openBtn.addEventListener('click', () => toggleMenu(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggleMenu(false));
    if (backdrop) backdrop.addEventListener('click', () => toggleMenu(false));
  });
</script>
