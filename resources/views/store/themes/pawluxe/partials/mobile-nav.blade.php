@php $plClient = Auth::guard('store')->user(); @endphp
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur border-t border-pl-line pb-[env(safe-area-inset-bottom)]">
  <div class="grid grid-cols-5 h-16">
    <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.index') ? 'text-pl-coral' : 'text-pl-mute' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
      <span class="text-[10px] font-medium">Home</span>
    </a>
    <a href="{{ route('store.shop') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.shop') ? 'text-pl-coral' : 'text-pl-mute' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      <span class="text-[10px] font-medium">Shop</span>
    </a>
    <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="flex flex-col items-center justify-center gap-0.5 text-pl-mute">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 12.5c1.1 0 2-1.12 2-2.5S5.6 7.5 4.5 7.5 2.5 8.62 2.5 10s.9 2.5 2 2.5Zm5.5-4c1.1 0 2-1.24 2-2.75S11.1 3 10 3 8 4.24 8 5.75 8.9 8.5 10 8.5Zm4 0c1.1 0 2-1.24 2-2.75S15.1 3 14 3s-2 1.24-2 2.75 0.9 2.75 2 2.75Zm5.5 4c1.1 0 2-1.12 2-2.5s-.9-2.5-2-2.5-2 1.12-2 2.5.9 2.5 2 2.5ZM12 12c-2.9 0-6.5 2.09-6.5 5.06 0 1.32 1.06 2.44 2.55 2.44.9 0 1.7-.35 2.45-.7.55-.26 1.06-.5 1.5-.5s.95.24 1.5.5c.75.35 1.55.7 2.45.7 1.49 0 2.55-1.12 2.55-2.44C18.5 14.09 14.9 12 12 12Z"/></svg>
      <span class="text-[10px] font-medium">Shop by Pet</span>
    </a>
    <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.cart') ? 'text-pl-coral' : 'text-pl-mute' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      <span class="cart-count absolute top-1 right-6 min-w-[16px] h-4 px-1 rounded-full bg-pl-coral text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
      <span class="text-[10px] font-medium">Cart</span>
    </a>
    @if($plClient)
      <a href="{{ url('/online_store/account') }}" class="flex flex-col items-center justify-center gap-0.5 text-pl-mute">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">Account</span>
      </a>
    @else
      <a href="{{ url('/online_store/login') }}" class="flex flex-col items-center justify-center gap-0.5 text-pl-mute">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">Sign In</span>
      </a>
    @endif
  </div>
</nav>
