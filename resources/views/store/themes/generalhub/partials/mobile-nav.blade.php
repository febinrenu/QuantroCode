@php $ghClient = Auth::guard('store')->user(); @endphp
<nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur border-t border-slate-200 shadow-navUp pb-[env(safe-area-inset-bottom)]">
  <div class="grid grid-cols-5 h-16">
    <a href="{{ route('store.index') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.index') ? 'text-brand-blue' : 'text-slate-500' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
      <span class="text-[10px] font-medium">{{ __('messages.Home') }}</span>
    </a>
    <a href="{{ route('store.shop') }}" class="flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.shop') ? 'text-brand-blue' : 'text-slate-500' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      <span class="text-[10px] font-medium">{{ __('messages.Shop') }}</span>
    </a>
    <a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="flex flex-col items-center justify-center gap-0.5 text-slate-500">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41 11 3.83A2 2 0 0 0 9.59 3.24H4a1 1 0 0 0-1 1v5.59a2 2 0 0 0 .59 1.41l9.58 9.59a2 2 0 0 0 2.83 0l4.59-4.59a2 2 0 0 0 0-2.83Z"/><circle cx="7.5" cy="7.5" r="1.5"/></svg>
      <span class="text-[10px] font-medium">Deals</span>
    </a>
    <a href="{{ route('store.cart') }}" class="relative flex flex-col items-center justify-center gap-0.5 {{ request()->routeIs('store.cart') ? 'text-brand-blue' : 'text-slate-500' }}">
      <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      <span class="cart-count absolute top-1 right-6 min-w-[16px] h-4 px-1 rounded-full bg-brand-orange text-white text-[10px] font-bold inline-flex items-center justify-center">0</span>
      <span class="text-[10px] font-medium">{{ __('messages.Cart') }}</span>
    </a>
    @if($ghClient)
      <a href="{{ url('/online_store/account') }}" class="flex flex-col items-center justify-center gap-0.5 text-slate-500">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">{{ __('messages.Account') }}</span>
      </a>
    @else
      <a href="{{ url('/online_store/login') }}" class="flex flex-col items-center justify-center gap-0.5 text-slate-500">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 4-6 8-6s8 2 8 6"/></svg>
        <span class="text-[10px] font-medium">{{ __('messages.SignIn') }}</span>
      </a>
    @endif
  </div>
</nav>
