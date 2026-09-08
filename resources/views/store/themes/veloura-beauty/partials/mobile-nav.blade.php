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
      ['name' => 'Fragrance', 'category' => 'Fragrance', 'icon' => '🌸'],
      ['name' => 'Skincare', 'category' => 'Skincare', 'icon' => '✨'],
      ['name' => 'Makeup', 'category' => 'Makeup', 'icon' => '💄'],
      ['name' => 'Bath & Body', 'category' => 'Bath & Body', 'icon' => '🛁'],
      ['name' => 'Hair Care', 'category' => 'Hair Care', 'icon' => '🧴'],
      ['name' => 'Gift Sets', 'category' => 'Gift Sets', 'icon' => '🎁'],
      ['name' => "Men's Grooming", 'category' => "Men's Grooming", 'icon' => '🎩'],
      ['name' => 'Clean Beauty', 'category' => 'Clean Beauty', 'icon' => '🌿'],
      ['name' => 'New In', 'collection' => 'new-in', 'icon' => '⭐'],
      ['name' => 'Bestsellers', 'collection' => 'bestsellers', 'icon' => '🔥'],
  ];
@endphp

<!-- Mobile Slideout Drawer Backdrop & Menu -->
<div x-show="mobileNavOpen"
     x-cloak
     class="relative z-50 lg:hidden"
     role="dialog"
     aria-modal="true">

  <div x-show="mobileNavOpen"
       x-transition:enter="transition-opacity ease-linear duration-300"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-linear duration-300"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 bg-vel-charcoal/60 backdrop-blur-xs"></div>

  <div class="fixed inset-0 flex">
    <div x-show="mobileNavOpen"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="relative mr-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-2xl">

      <!-- Drawer Header -->
      <div class="flex items-center justify-between px-6 pb-4 border-b border-vel-border">
        <a href="{{ $homeUrl }}" class="flex flex-col">
          <span class="font-serif-luxury text-xl font-bold tracking-widest text-vel-charcoal">VELOURA</span>
          <span class="text-[8px] font-semibold tracking-[0.2em] text-vel-muted uppercase">BEAUTY &bull; PARIS</span>
        </a>
        <button type="button"
                @click="mobileNavOpen = false"
                class="p-2 text-vel-muted hover:text-vel-charcoal">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Mobile Search -->
      <div class="p-6 pb-2">
        <form action="{{ route('store.shop') }}" method="GET" class="relative">
          @if($themePreview)
            <input type="hidden" name="preview_theme" value="{{ $themePreview }}">
          @endif
          <input type="search"
                 name="q"
                 placeholder="Search beauty..."
                 class="w-full bg-vel-blush border border-vel-border rounded-xl pl-10 pr-4 py-2 text-xs text-vel-charcoal placeholder-vel-muted focus:outline-none focus:border-vel-rose">
          <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-vel-muted">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
          </span>
        </form>
      </div>

      <!-- Department Navigation Links -->
      <div class="px-6 py-4 space-y-1">
        <h4 class="text-[10px] font-extrabold uppercase tracking-wider text-vel-muted px-2 mb-2">
          Beauty Categories
        </h4>
        @foreach($categoriesList as $cat)
          @php
            $linkUrl = isset($cat['category'])
                ? $velRoute('store.shop', ['category' => $cat['category']])
                : $velRoute('store.shop', ['collection' => $cat['collection']]);
          @endphp
          <a href="{{ $linkUrl }}"
             @click="mobileNavOpen = false"
             class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold text-vel-charcoal hover:bg-vel-roseLight hover:text-vel-rose transition-colors">
            <span class="flex items-center gap-2.5">
              <span>{{ $cat['icon'] }}</span>
              <span>{{ $cat['name'] }}</span>
            </span>
            <span class="text-vel-muted">&rarr;</span>
          </a>
        @endforeach
      </div>

      <!-- User & Services Section -->
      <div class="mt-auto px-6 pt-4 border-t border-vel-border space-y-2 text-xs font-medium text-vel-muted">
        <a href="{{ $accountUrl }}" class="block px-3 py-2 text-vel-charcoal hover:text-vel-rose">Account / Sign In</a>
        <a href="{{ $cartUrl }}" class="block px-3 py-2 text-vel-charcoal hover:text-vel-rose">Shopping Bag</a>
        <a href="#veloura-club" class="block px-3 py-2 text-vel-rose font-bold">Join Veloura Club</a>
      </div>

    </div>
  </div>
</div>

<!-- Mobile Sticky Bottom Navigation Bar -->
<div class="fixed bottom-0 left-0 right-0 z-30 bg-white/95 backdrop-blur-md border-t border-vel-border lg:hidden py-2 px-4 shadow-lg">
  <div class="grid grid-cols-5 text-center text-[10px] font-semibold text-vel-charcoal">
    <a href="{{ $homeUrl }}" class="flex flex-col items-center gap-1 hover:text-vel-rose py-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      <span>Home</span>
    </a>
    <a href="{{ $shopUrl }}" class="flex flex-col items-center gap-1 hover:text-vel-rose py-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
      <span>Shop</span>
    </a>
    <a href="{{ $velRoute('store.shop', ['collection' => 'bestsellers']) }}" class="flex flex-col items-center gap-1 hover:text-vel-rose py-1 text-vel-rose">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
      <span>Bestsellers</span>
    </a>
    <a href="{{ $accountUrl }}" class="flex flex-col items-center gap-1 hover:text-vel-rose py-1">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      <span>Account</span>
    </a>
    <a href="{{ $cartUrl }}"
       class="flex flex-col items-center gap-1 hover:text-vel-rose py-1 relative"
       x-data="{ count: 0 }"
       x-init="count = (window.CartLS ? window.CartLS.count() : 0); window.addEventListener('cart-updated', () => { count = window.CartLS ? window.CartLS.count() : 0 })">
      <div class="relative">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <span x-show="count > 0"
              x-text="count"
              class="absolute -top-1 -right-2 min-w-[14px] h-[14px] px-0.5 bg-vel-rose text-white text-[8px] font-bold rounded-full flex items-center justify-center">
        </span>
      </div>
      <span>Bag</span>
    </a>
  </div>
</div>
