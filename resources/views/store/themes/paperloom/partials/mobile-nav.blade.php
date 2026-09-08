@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $cartUrl = $plRoute('store.cart');
@endphp

<!-- Mobile Navigation Drawer Overlay -->
<div x-show="mobileMenuOpen"
     x-cloak
     class="fixed inset-0 z-50 lg:hidden flex"
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

  <!-- Slide-out Drawer -->
  <div x-show="mobileMenuOpen"
       x-transition:enter="transition ease-in-out duration-300 transform"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in-out duration-300 transform"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="relative max-w-xs w-full bg-[#FAF8F5] h-full shadow-2xl flex flex-col justify-between overflow-y-auto z-10 border-r border-pl-border">

    <!-- Drawer Header -->
    <div class="p-5 border-b border-pl-border flex items-center justify-between">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-pl-forest flex items-center justify-center text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
        </div>
        <span class="font-serif-book font-bold text-xl text-slate-900">PaperLoom</span>
      </div>

      <button type="button"
              @click="mobileMenuOpen = false"
              class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-white"
              aria-label="Close menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Search in Drawer -->
    <div class="p-4 border-b border-pl-border bg-white">
      <form action="{{ route('store.shop') }}" method="GET">
        @if($themePreview)
          <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
        @endif
        <div class="relative">
          <input type="text"
                 name="q"
                 placeholder="Search catalog..."
                 class="w-full pl-3 pr-9 py-2 bg-[#FAF8F5] border border-pl-border rounded-lg text-xs text-slate-900 focus:outline-none focus:border-pl-terracotta">
          <button type="submit" class="absolute right-2.5 top-2 text-slate-400 hover:text-pl-terracotta">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </button>
        </div>
      </form>
    </div>

    <!-- Nav List -->
    <div class="p-4 flex-1 space-y-6">

      <!-- Primary Links -->
      <div class="space-y-1 text-xs font-semibold text-slate-800 flex flex-col">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1">Categories</span>
        <a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Books</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Fiction']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Fiction</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Non-Fiction']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Non-Fiction</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Children']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Children's Books</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Academic']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Academic & Study</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Stationery']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Stationery</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Notebooks']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Notebooks & Planners</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Journals']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Journals & Diaries</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Art Supplies']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Art Supplies</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Desk Accessories']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Desk Accessories</a>
        <a href="{{ $plRoute('store.shop', ['category' => 'Gifts']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors">Gifts & Sets</a>
      </div>

      <!-- Highlights / Collections -->
      <div class="space-y-1 text-xs font-semibold text-slate-800 flex flex-col pt-3 border-t border-pl-border">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3 mb-1">Collections</span>
        <a href="{{ $plRoute('store.shop', ['collection' => 'new-arrivals']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors block">New Arrivals</a>
        <a href="{{ $plRoute('store.shop', ['collection' => 'bestselling']) }}" class="px-3 py-2 rounded-lg hover:bg-white hover:text-pl-terracotta transition-colors block">Best Sellers</a>
        <a href="{{ $plRoute('store.shop', ['collection' => 'sale']) }}" class="px-3 py-2 rounded-lg text-pl-terracotta font-bold hover:bg-white transition-colors block">Sale (Up to 40% Off)</a>
      </div>

      <!-- Member Box -->
      <div class="bg-pl-cream rounded-xl p-3.5 border border-pl-border text-center space-y-2">
        <span class="font-serif-book font-bold text-xs text-slate-900 block">PaperLoom Club</span>
        <p class="text-[11px] text-slate-600">Join to get 15% off first order + free reading tote.</p>
        <a href="{{ $plRoute('store.shop', ['action' => 'club']) }}" class="inline-block px-4 py-1.5 bg-pl-terracotta text-white rounded-full text-xs font-semibold hover:bg-pl-terracottaHover transition-colors">
          Join Free
        </a>
      </div>

    </div>

    <!-- Drawer Footer -->
    <div class="p-4 border-t border-pl-border bg-white text-xs text-slate-600 space-y-2">
      <div class="flex items-center justify-between">
        <span>Language / Currency</span>
        <span class="font-semibold text-slate-900">EN | USD</span>
      </div>
      <div class="pt-2 text-center text-[10px] text-slate-400">
        © 2026 PaperLoom Bookstore.
      </div>
    </div>

  </div>

</div>
