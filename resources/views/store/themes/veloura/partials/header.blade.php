@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $homeUrl = $velRoute('store.index');
  $shopUrl = $velRoute('store.shop');
  $cartUrl = $velRoute('store.cart');
  $accountUrl = url('/online_store/account' . ($themePreview ? '?preview_theme=' . $themePreview : ''));

  $categoriesList = [
      ['name' => 'Fragrance', 'category' => 'Fragrance'],
      ['name' => 'Skincare', 'category' => 'Skincare'],
      ['name' => 'Makeup', 'category' => 'Makeup'],
      ['name' => 'Bath & Body', 'category' => 'Bath & Body'],
      ['name' => 'Hair Care', 'category' => 'Hair Care'],
      ['name' => 'Gift Sets', 'category' => 'Gift Sets'],
      ['name' => 'New In', 'collection' => 'new-in'],
      ['name' => 'Bestsellers', 'collection' => 'bestsellers'],
  ];
@endphp

<header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-vel-border shadow-xs">

  <!-- Main Header Row -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20 gap-4 sm:gap-8">

      <!-- Mobile Menu Toggle -->
      <button type="button"
              @click="mobileNavOpen = true"
              class="lg:hidden p-2 text-vel-charcoal hover:text-vel-rose transition-colors"
              aria-label="Open menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>

      <!-- Brand Logo / Wordmark -->
      <div class="flex-shrink-0 flex items-center">
        <a href="{{ $homeUrl }}" class="flex flex-col items-center group">
          <span class="font-serif-luxury text-2xl sm:text-3xl font-bold tracking-widest text-vel-charcoal group-hover:text-vel-rose transition-colors">
            VELOURA
          </span>
          <span class="text-[9px] font-semibold tracking-[0.25em] text-vel-muted uppercase group-hover:text-vel-roseDark transition-colors">
            BEAUTY &bull; PARIS
          </span>
        </a>
      </div>

      <!-- Search Bar (Desktop) -->
      <div class="hidden md:flex flex-1 max-w-lg mx-auto">
        <form action="{{ route('store.shop') }}" method="GET" class="w-full relative">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          <input type="search"
                 name="q"
                 value="{{ request('q') }}"
                 placeholder="Search fragrances, skincare, makeup..."
                 class="w-full bg-vel-blush/80 border border-vel-border rounded-full pl-11 pr-5 py-2.5 text-xs text-vel-charcoal placeholder-vel-muted focus:outline-none focus:border-vel-rose focus:bg-white focus:ring-1 focus:ring-vel-rose transition-all">
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-vel-muted pointer-events-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </span>
        </form>
      </div>

      <!-- Header Action Icons -->
      <div class="flex items-center gap-4 sm:gap-6 text-vel-charcoal">

        <!-- Account -->
        <a href="{{ $accountUrl }}"
           class="hidden sm:flex items-center gap-1.5 text-xs font-semibold hover:text-vel-rose transition-colors"
           title="Account">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          <span class="hidden lg:inline">Sign In</span>
        </a>

        <!-- Wishlist -->
        <a href="{{ $shopUrl }}"
           class="hidden sm:flex items-center gap-1.5 text-xs font-semibold hover:text-vel-rose transition-colors"
           title="Wishlist">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        </a>

        <!-- Shopping Bag / Cart with reactive Alpine miniCart -->
        <a href="{{ $cartUrl }}"
           class="flex items-center gap-2 p-1.5 text-vel-charcoal hover:text-vel-rose transition-colors group"
           x-data="{ count: 0 }"
           x-init="count = (window.CartLS ? window.CartLS.count() : 0); window.addEventListener('cart-updated', () => { count = window.CartLS ? window.CartLS.count() : 0 })">
          <div class="relative">
            <svg class="w-6 h-6 group-hover:scale-105 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <span x-show="count > 0"
                  x-text="count"
                  class="absolute -top-1.5 -right-2 min-w-[18px] h-[18px] px-1 bg-vel-rose text-white text-[10px] font-bold rounded-full flex items-center justify-center shadow-xs">
              0
            </span>
          </div>
          <span class="hidden sm:inline text-xs font-bold text-vel-charcoal group-hover:text-vel-rose transition-colors">
            Bag
          </span>
        </a>

      </div>

    </div>
  </div>

  <!-- Primary Navigation Bar (Desktop) -->
  <nav class="hidden lg:block border-t border-vel-borderLight bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-center gap-8 py-3 text-xs font-semibold tracking-wider uppercase text-vel-charcoal">
        @foreach($categoriesList as $catItem)
          @php
            $linkUrl = isset($catItem['category'])
                ? $velRoute('store.shop', ['category' => $catItem['category']])
                : $velRoute('store.shop', ['collection' => $catItem['collection']]);
            $isActive = (isset($catItem['category']) && request('category') === $catItem['category'])
                     || (isset($catItem['collection']) && request('collection') === $catItem['collection']);
          @endphp
          <a href="{{ $linkUrl }}"
             class="relative py-1 hover:text-vel-rose transition-colors {{ $isActive ? 'text-vel-rose font-extrabold' : '' }}">
            {{ $catItem['name'] }}
            @if($isActive)
              <span class="absolute bottom-0 left-0 w-full h-0.5 bg-vel-rose"></span>
            @endif
          </a>
        @endforeach
      </div>
    </div>
  </nav>

</header>
