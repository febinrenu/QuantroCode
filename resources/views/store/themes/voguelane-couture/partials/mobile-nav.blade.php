{{-- VogueLane Mobile Navigation Drawer --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<div x-cloak 
     x-show="mobileMenuOpen" 
     class="relative z-50 lg:hidden" 
     aria-modal="true">
  
  <!-- Backdrop Overlay -->
  <div x-show="mobileMenuOpen" 
       x-transition:enter="transition-opacity ease-linear duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-linear duration-300"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="mobileMenuOpen = false" 
       class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

  <!-- Off-canvas Menu Panel -->
  <div class="fixed inset-0 flex z-50">
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative max-w-xs w-full bg-white shadow-2xl flex flex-col justify-between overflow-y-auto">
      
      <div>
        <!-- Drawer Header -->
        <div class="p-4 border-b border-vog-border flex items-center justify-between">
          <a href="{{ $vogRoute('store.index') }}" class="flex items-center">
            <span class="font-serif-luxury text-xl font-bold tracking-tight text-slate-900">
              Vogue<span class="text-vog-tan italic font-normal">Lane</span>
            </span>
          </a>
          <button type="button" 
                  @click="mobileMenuOpen = false" 
                  class="p-2 -mr-2 text-slate-500 hover:text-slate-900 focus:outline-none"
                  aria-label="Close menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Search Bar -->
        <div class="p-4 bg-vog-ivory border-b border-vog-border">
          <form action="{{ $vogRoute('store.shop') }}" method="GET" class="relative">
            @if($themePreview)
              <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
            @endif
            <input type="text" 
                   name="q" 
                   value="{{ request('q') }}"
                   placeholder="Search fashion..." 
                   class="w-full text-xs bg-white border border-vog-border rounded-lg pl-3.5 pr-8 py-2.5 outline-none focus:border-slate-900 text-slate-800">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
            </button>
          </form>
        </div>

        <!-- Navigation Links -->
        <div class="p-4 space-y-1 text-xs font-semibold uppercase tracking-wider text-slate-900">
          <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest px-2 py-1">Collections</div>
          <a href="{{ $vogRoute('store.shop', ['collection' => 'new-in']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>✨ New In</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Women']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Women</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Men']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Men</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Shoes']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Shoes</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Bags']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Bags</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Accessories']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Accessories</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Beauty']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Beauty</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['category' => 'Jewelry']) }}" class="flex items-center justify-between p-2.5 rounded-lg hover:bg-vog-ivory hover:text-vog-tan transition-colors">
            <span>Jewelry</span> <span class="text-slate-400">&rsaquo;</span>
          </a>
          <a href="{{ $vogRoute('store.shop', ['collection' => 'sale']) }}" class="flex items-center justify-between p-2.5 rounded-lg text-vog-sale font-bold hover:bg-red-50 transition-colors">
            <span>🏷️ Sale — Up to 40% Off</span> <span class="text-vog-sale">&rsaquo;</span>
          </a>
        </div>
      </div>

      <!-- Drawer Footer -->
      <div class="p-4 bg-vog-ivory border-t border-vog-border text-xs space-y-2.5">
        @if(Auth::guard('store')->check())
          <a href="{{ $vogRoute('account') }}" class="block w-full text-center py-2.5 bg-vog-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition-colors">
            My Account
          </a>
        @else
          <a href="{{ $vogRoute('store.login.show') }}" class="block w-full text-center py-2.5 bg-vog-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition-colors">
            Sign In / Register
          </a>
        @endif
        <div class="text-center text-[11px] text-slate-500 pt-1">
          <span>Free Shipping worldwide on $80+</span>
        </div>
      </div>

    </div>
  </div>
</div>
