@php $ntClient = Auth::guard('store')->user(); @endphp
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur border-t border-leaf-light shadow-navUp pb-[env(safe-area-inset-bottom)] rounded-t-3xl overflow-hidden">
  <div class="grid grid-cols-5 h-[68px]">
    <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.index') ? 'text-terracotta-dark' : 'text-bark/50' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
      <span class="text-[10px] font-medium">{{ __('messages.Home') }}</span>
    </a>
    <a href="{{ route('store.shop') }}" class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.shop') ? 'text-terracotta-dark' : 'text-bark/50' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8c2-3 5-5 8-5s6 2 8 5M4 8c1 5 4 9 8 11 4-2 7-6 8-11M4 8h16"/></svg>
      <span class="text-[10px] font-medium">{{ __('messages.Shop') }}</span>
    </a>
    <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="flex flex-col items-center justify-center gap-1 text-bark/50">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-4-2-7-6-7-11 0-3 2-6 7-8 5 2 7 5 7 8 0 5-3 9-7 11Z"/><path stroke-linecap="round" d="M12 21V9"/></svg>
      <span class="text-[10px] font-medium">Value</span>
    </a>
    <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center justify-center gap-1 {{ request()->routeIs('store.cart') ? 'text-terracotta-dark' : 'text-bark/50' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l-1.4 10.2a2 2 0 0 1-2 1.8H8.4a2 2 0 0 1-2-1.8L5 8Z"/><path stroke-linecap="round" d="M8 8a4 4 0 0 1 8 0"/></svg>
      <span class="cart-count absolute top-0.5 right-6 min-w-[16px] h-4 px-1 rounded-full bg-leaf-deep text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
      <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
    </a>
    @if($ntClient)
      <a href="{{ url('/online_store/account') }}" class="flex flex-col items-center justify-center gap-1 text-bark/50">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">{{ __('messages.Account') }}</span>
      </a>
    @else
      <a href="{{ url('/online_store/login') }}" class="flex flex-col items-center justify-center gap-1 text-bark/50">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">{{ __('messages.SignIn') }}</span>
      </a>
    @endif
  </div>
</nav>
