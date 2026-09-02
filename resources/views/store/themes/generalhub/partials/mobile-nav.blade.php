{{-- GeneralHub Mobile Navigation Drawer --}}
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

<div id="mobile-menu-drawer" class="fixed inset-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden" aria-hidden="true">
  <!-- Backdrop -->
  <div id="mobile-menu-backdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

  <!-- Drawer Container -->
  <div class="relative w-4/5 max-w-xs h-full bg-white flex flex-col z-10 overflow-y-auto shadow-2xl">
    
    <!-- Top Header -->
    <div class="p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
      <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-md bg-hub-blue flex items-center justify-center text-white">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
        </div>
        <span class="font-bold text-slate-900 text-lg">General<span class="text-hub-blue">Hub</span></span>
      </div>
      <button type="button" id="mobile-menu-close-btn" class="p-1.5 text-slate-500 hover:text-slate-900 rounded-md hover:bg-slate-200 transition-colors" aria-label="Close menu">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
      </button>
    </div>

    <!-- Quick Navigation Highlights -->
    <div class="p-4 border-b border-slate-100 bg-hub-blueSoft/50 space-y-2">
      <a href="{{ $hubRoute('store.shop', ['collection' => 'bestselling']) }}" class="flex items-center gap-2.5 text-xs font-semibold text-slate-800 hover:text-hub-blue">
        <span class="text-amber-500">⭐</span> <span>Best Sellers</span>
      </a>
      <a href="{{ $hubRoute('store.shop', ['sort' => 'latest']) }}" class="flex items-center gap-2.5 text-xs font-semibold text-slate-800 hover:text-hub-blue">
        <span class="text-emerald-500">✨</span> <span>New Arrivals</span>
      </a>
      <a href="{{ $hubRoute('store.shop', ['collection' => 'deals']) }}" class="flex items-center gap-2.5 text-xs font-semibold text-slate-800 hover:text-hub-blue">
        <span class="text-rose-500">🏷️</span> <span>Deals of the Day</span>
      </a>
    </div>

    <!-- Main Categories List -->
    <div class="p-4 flex-1">
      <div class="text-[11px] font-bold tracking-wider text-slate-400 uppercase mb-3">Shop by Category</div>
      <nav class="space-y-1 text-xs font-medium text-slate-700">
        <a href="{{ $hubRoute('store.shop', ['category' => 'Electronics']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>🎧 Electronics</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Fashion']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>👕 Fashion</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Home & Living']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>🛋️ Home &amp; Living</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Beauty']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>💄 Beauty</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Accessories']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>👜 Accessories</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Sports']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>⚽ Sports</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Toys & Games']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>🧸 Toys &amp; Games</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
        <a href="{{ $hubRoute('store.shop', ['category' => 'Daily Essentials']) }}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 hover:text-hub-blue">
          <span>🧴 Daily Essentials</span> <span class="text-slate-400">&rsaquo;</span>
        </a>
      </nav>
    </div>

    <!-- Account Footer -->
    <div class="p-4 bg-slate-50 border-t border-slate-200 text-xs">
      @if(Auth::guard('store')->check())
        <a href="{{ $hubRoute('account') }}" class="block w-full text-center py-2.5 bg-hub-blue text-white font-semibold rounded-lg hover:bg-hub-blueHover transition-colors">
          My Account
        </a>
      @else
        <a href="{{ $hubRoute('store.login.show') }}" class="block w-full text-center py-2.5 bg-hub-blue text-white font-semibold rounded-lg hover:bg-hub-blueHover transition-colors">
          Sign In / Register
        </a>
      @endif
    </div>

  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('mobile-menu-close-btn');
    const backdrop = document.getElementById('mobile-menu-backdrop');
    const drawer = document.getElementById('mobile-menu-drawer');

    function toggle(show) {
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

    if (openBtn) openBtn.addEventListener('click', () => toggle(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggle(false));
    if (backdrop) backdrop.addEventListener('click', () => toggle(false));
  });
</script>
