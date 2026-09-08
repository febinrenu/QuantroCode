<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.generalhub-store._shell', ['pageTitle' => 'Shopping Cart — ' . ($s->store_name ?? 'GeneralHub')])
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased selection:bg-hub-blue selection:text-white">

@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $checkoutUrl = \Illuminate\Support\Facades\Route::has('checkout') ? $hubRoute('checkout') : '#';
@endphp

@include('store.themes.generalhub-store.partials.header', ['categories' => $categories ?? [], 'showCategoryBar' => true])
@include('store.themes.generalhub-store.partials.mobile-nav')

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pb-24" x-data="miniCart()">

  <!-- Header -->
  <div class="mb-8">
    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Shopping Bag</h1>
    <p class="text-xs sm:text-sm text-slate-500 mt-1">Review your selected items before proceeding to secure checkout.</p>
  </div>

  <!-- Empty Cart State -->
  <template x-if="!items.length">
    <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
      <div class="w-16 h-16 rounded-full bg-blue-50 text-hub-blue flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
      </div>
      <h3 class="text-lg font-bold text-slate-900">Your cart is currently empty</h3>
      <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto mt-1">Looks like you haven't added anything to your cart yet.</p>
      <div class="mt-6">
        <a href="{{ $hubRoute('store.shop') }}" class="inline-block px-7 py-3 bg-hub-blue text-white text-xs sm:text-sm font-semibold rounded-xl hover:bg-hub-blueHover transition-colors shadow-sm">
          Start Shopping
        </a>
      </div>
    </div>
  </template>

  <!-- Cart Content Container -->
  <div class="grid lg:grid-cols-12 gap-8 items-start" x-show="items.length">
    
    <!-- Left: Cart Items (8 cols) -->
    <div class="lg:col-span-8 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm">
      
      <!-- Free Shipping Progress -->
      <div class="mb-6 p-4 bg-blue-50/70 border border-blue-100 rounded-2xl">
        <div class="flex items-center justify-between text-xs font-semibold text-hub-blue mb-1.5">
          <span>📦 Free Delivery on orders over $49</span>
          <span x-text="subtotal >= 49 ? 'Qualified for Free Shipping!' : 'Add ' + money(49 - subtotal) + ' more for Free Shipping'"></span>
        </div>
        <div class="w-full h-2 bg-blue-200/60 rounded-full overflow-hidden">
          <div class="h-full bg-hub-blue rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, (subtotal / 49) * 100) + '%;'"></div>
        </div>
      </div>

      <!-- Items List -->
      <div class="divide-y divide-slate-100">
        <template x-for="it in items" :key="it.id">
          <div class="py-4.5 flex items-center gap-4 first:pt-0 last:pb-0">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-contain border border-slate-100 shrink-0">
            
            <div class="flex-1 min-w-0">
              <div class="text-xs sm:text-sm font-semibold text-slate-900 truncate" x-text="it.name"></div>
              <div class="text-xs sm:text-sm font-bold text-hub-blue mt-0.5" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>

            <!-- Qty Control -->
            <div class="flex items-center border border-slate-200 rounded-xl h-9 bg-white">
              <button type="button" class="w-8 h-full text-slate-600 hover:bg-slate-50 font-bold transition-colors" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-xs font-bold bg-transparent outline-none" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-slate-600 hover:bg-slate-50 font-bold transition-colors" @click="inc(it)">+</button>
            </div>

            <!-- Total Price for Line -->
            <div class="w-20 sm:w-24 text-right text-xs sm:text-sm font-bold text-slate-900" x-text="lineTotal(it)"></div>

            <!-- Remove Button -->
            <button type="button" class="p-1.5 text-slate-400 hover:text-rose-500 rounded-lg hover:bg-rose-50 transition-colors" @click="remove(it)" aria-label="Remove item">
              <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

    </div>

    <!-- Right: Order Summary (4 cols) -->
    <div class="lg:col-span-4 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 sticky top-24">
      <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-4">
        Order Summary
      </h3>

      <div class="space-y-3 text-xs text-slate-600">
        <div class="flex items-center justify-between">
          <span>Subtotal</span>
          <span class="font-bold text-slate-900" x-text="money(subtotal)"></span>
        </div>
        <div class="flex items-center justify-between">
          <span>Shipping</span>
          <span class="text-emerald-600 font-semibold" x-text="subtotal >= 49 ? 'FREE' : money(5.99)"></span>
        </div>
        <div class="flex items-center justify-between text-sm font-extrabold text-slate-900 border-t border-slate-100 pt-3">
          <span>Total</span>
          <span class="text-lg text-hub-blue font-extrabold" x-text="money(grand + (subtotal >= 49 || subtotal === 0 ? 0 : 5.99))"></span>
        </div>
      </div>

      <!-- Checkout CTA -->
      <button type="button" 
              class="w-full h-12 bg-hub-blue hover:bg-hub-blueHover text-white text-xs sm:text-sm font-bold rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all active:scale-95 cursor-pointer"
              @click="checkout('{{ $checkoutUrl }}')">
        <span>Proceed to Checkout</span>
        <span>&rarr;</span>
      </button>

      <!-- Security Guarantee -->
      <div class="pt-4 border-t border-slate-100 space-y-2 text-center text-[11px] text-slate-400">
        <div class="flex items-center justify-center gap-1.5 text-slate-600 font-semibold">
          <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
          <span>100% Guaranteed Safe Checkout</span>
        </div>
        <p>Encrypted 256-Bit SSL Protection</p>
      </div>

    </div>

  </div>

</main>

@include('store.themes.generalhub-store.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
