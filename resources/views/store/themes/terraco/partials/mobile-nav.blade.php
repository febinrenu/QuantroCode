{{-- Terraco mobile nav — deliberately lean: home / search / cart only. No wishlist, no account icon. --}}
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-terra-bg/95 backdrop-blur border-t border-terra-line pb-[env(safe-area-inset-bottom)]">
  <div class="grid grid-cols-3 h-16">
    <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.index') ? 'text-terra-slate' : 'text-terra-inkSoft' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
      <span class="text-[10px] tracking-wide">{{ __('messages.Home') }}</span>
    </a>
    <a href="{{ route('store.shop') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.shop') ? 'text-terra-slate' : 'text-terra-inkSoft' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/></svg>
      <span class="text-[10px] tracking-wide">{{ __('messages.Search') ?? 'Search' }}</span>
    </a>
    <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.cart') ? 'text-terra-slate' : 'text-terra-inkSoft' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      <span class="cart-count absolute top-0.5 right-[calc(50%-22px)] min-w-[16px] h-4 px-1 rounded-full bg-terra-slate text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
      <span class="text-[10px] tracking-wide">{{ __('messages.Cart') }}</span>
    </a>
  </div>
</nav>
