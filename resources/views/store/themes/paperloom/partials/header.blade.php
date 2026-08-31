@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $cartUrl = $plRoute('store.cart');
  $categories = $categories ?? collect();
@endphp

<header class="w-full bg-[#F8F5EE] border-b border-pl-border sticky top-0 z-40 shadow-xs">

  <!-- 1. Top Announcement Bar -->
  <div class="bg-[#16282E] text-white text-[11px] sm:text-xs py-2 px-4 sm:px-8 font-medium">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
      <div class="flex items-center gap-2">
        <span class="text-amber-400">📦</span>
        <span>Free shipping on orders over <strong>$35</strong></span>
      </div>

      <div class="hidden md:flex items-center gap-2 text-amber-200/90 font-semibold tracking-wide">
        <span>Back to School Collection Now Live</span>
      </div>

      <div class="flex items-center gap-4 text-slate-300">
        <a href="{{ $plRoute('store.shop', ['q' => 'locator']) }}" class="hover:text-white transition-colors">Store Locator</a>
        <span class="text-slate-600">•</span>
        <a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}" class="hover:text-white transition-colors">Reading List</a>
        <span class="text-slate-600">•</span>
        <a href="{{ $plRoute('store.shop', ['q' => 'help']) }}" class="hover:text-white transition-colors">Help</a>
      </div>
    </div>
  </div>

  <!-- 2. Main Header (Logo, Search, Utilities) -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4">
    <div class="flex items-center justify-between gap-4 lg:gap-8">

      <!-- Mobile Menu Toggle Button -->
      <button type="button"
              @click="mobileMenuOpen = true"
              class="lg:hidden p-2 -ml-2 text-slate-800 hover:text-pl-terracotta focus:outline-none"
              aria-label="Open Mobile Menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Brand Logo -->
      <a href="{{ $plRoute('store.index') }}" class="flex items-center gap-3 shrink-0 group">
        <div class="w-10 h-10 rounded-xl bg-pl-forest flex items-center justify-center text-white shadow-sm group-hover:bg-pl-terracotta transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
        </div>
        <div>
          <span class="font-serif-book text-2xl sm:text-3xl font-bold tracking-tight text-slate-900 leading-none block">
            PaperLoom
          </span>
          <span class="text-[10px] tracking-[0.16em] uppercase text-slate-500 font-semibold block mt-0.5">
            Books • Study • Stationery
          </span>
        </div>
      </a>

      <!-- Search Bar -->
      <div class="flex-1 max-w-2xl hidden md:block">
        <form action="{{ route('store.shop') }}" method="GET" class="relative">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          <div class="relative flex items-center">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Search books, journals, art supplies and more..."
                   class="w-full pl-4 pr-12 py-2.5 bg-white rounded-full border border-pl-border text-xs sm:text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:border-pl-terracotta focus:ring-2 focus:ring-pl-terracotta/20 shadow-xs transition-all">
            <button type="submit"
                    class="absolute right-1.5 w-8 h-8 rounded-full bg-pl-terracotta hover:bg-pl-terracottaHover text-white flex items-center justify-center transition-colors shadow-xs"
                    aria-label="Search">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </button>
          </div>
        </form>
      </div>

      <!-- Right Utility Actions -->
      <div class="flex items-center gap-3 sm:gap-5 text-slate-700">

        <!-- Account / Login -->
        <a href="{{ $plRoute('store.shop', ['action' => 'account']) }}" class="p-2 hover:text-pl-terracotta transition-colors flex items-center gap-1.5" title="Account">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </a>

        <!-- Wishlist -->
        <a href="{{ $plRoute('store.shop', ['action' => 'wishlist']) }}" class="p-2 hover:text-pl-terracotta transition-colors relative" title="Wishlist">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
        </a>

        <!-- Cart Bag with Live Badge -->
        <a href="{{ $cartUrl }}" class="p-2 hover:text-pl-terracotta transition-colors relative flex items-center" title="Shopping Bag">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <span class="cart-count absolute -top-1 -right-1 bg-pl-terracotta text-white font-bold text-[10px] w-4 h-4 rounded-full flex items-center justify-center shadow-xs">
            0
          </span>
        </a>

        <!-- Language / Currency -->
        <div class="hidden sm:flex items-center text-xs font-semibold text-slate-600 pl-2 border-l border-pl-border">
          <span>EN | USD</span>
        </div>

      </div>

    </div>
  </div>

  <!-- 3. Primary Navigation Bar -->
  <nav class="border-t border-pl-border/80 bg-[#FAF8F5] hidden lg:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between gap-6 py-2.5">

        <!-- Browse Genres Pill Button with Alpine Dropdown -->
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
          <button type="button"
                  @click="open = !open"
                  class="flex items-center gap-2.5 px-4 py-2 bg-pl-forest hover:bg-pl-forestLight text-white rounded-full text-xs font-semibold tracking-wide transition-all shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
            </svg>
            <span>Browse Genres</span>
            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown Menu -->
          <div x-show="open"
               x-cloak
               x-transition:enter="transition ease-out duration-150"
               x-transition:enter-start="opacity-0 translate-y-1"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="absolute left-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-xl border border-pl-border py-3 z-50">
            <div class="px-4 py-1.5 text-[11px] font-bold tracking-wider text-slate-400 uppercase">
              Book & Stationery Genres
            </div>
            @foreach(['Fiction', 'Non-Fiction', 'Children', 'Academic', 'Notebooks', 'Journals', 'Art Supplies', 'Desk Accessories', 'Gifts'] as $genreName)
              <a href="{{ $plRoute('store.shop', ['category' => $genreName]) }}"
                 class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-pl-cream hover:text-pl-terracotta transition-colors">
                {{ $genreName }}
              </a>
            @endforeach
          </div>
        </div>

        <!-- Navigation Links Strip -->
        <div class="flex items-center gap-7 text-xs font-medium text-slate-800">
          <a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}" class="hover:text-pl-terracotta transition-colors">Books</a>
          <a href="{{ $plRoute('store.shop', ['category' => 'Stationery']) }}" class="hover:text-pl-terracotta transition-colors">Stationery</a>
          <a href="{{ $plRoute('store.shop', ['category' => 'Kids']) }}" class="hover:text-pl-terracotta transition-colors">Kids</a>
          <a href="{{ $plRoute('store.shop', ['category' => 'Academic']) }}" class="hover:text-pl-terracotta transition-colors">Academic</a>
          <a href="{{ $plRoute('store.shop', ['category' => 'Art Supplies']) }}" class="hover:text-pl-terracotta transition-colors">Art Supplies</a>
          <a href="{{ $plRoute('store.shop', ['category' => 'Gifts']) }}" class="hover:text-pl-terracotta transition-colors">Gifts</a>
          <a href="{{ $plRoute('store.shop', ['collection' => 'new-arrivals']) }}" class="hover:text-pl-terracotta transition-colors">New Arrivals</a>
          <a href="{{ $plRoute('store.shop', ['collection' => 'bestselling']) }}" class="hover:text-pl-terracotta transition-colors">Best Sellers</a>
          <a href="{{ $plRoute('store.shop', ['collection' => 'sale']) }}" class="text-pl-terracotta font-bold hover:underline transition-all">Sale</a>
        </div>

        <!-- Quick Tagline -->
        <div class="text-[11px] text-slate-500 italic font-serif-book">
          Inspiring creative minds
        </div>

      </div>
    </div>
  </nav>

</header>
