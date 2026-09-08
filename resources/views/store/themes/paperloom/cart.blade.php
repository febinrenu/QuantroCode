@extends('store.themes.paperloom._shell')

@section('title', 'Your Shopping Bag — PaperLoom')

@section('content')

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $checkoutUrl = \Illuminate\Support\Facades\Route::has('checkout') ? $plRoute('checkout') : '#';
@endphp

<!-- Cart Container with Alpine miniCart -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14" x-data="miniCart()">

  <!-- Header -->
  <div class="border-b border-pl-border pb-6 mb-8 flex flex-col sm:flex-row sm:items-baseline justify-between gap-2">
    <div>
      <h1 class="font-serif-book text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
        Shopping Bag
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 font-normal mt-1">
        Review your books, stationery, and study selections before proceeding to checkout.
      </p>
    </div>
    <span class="text-xs font-semibold text-slate-500" x-text="items.length + ' item' + (items.length === 1 ? '' : 's')"></span>
  </div>

  <!-- Empty Cart State -->
  <template x-if="!items.length">
    <div class="text-center py-16 sm:py-24 max-w-md mx-auto space-y-5">
      <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center mx-auto text-slate-400 border border-pl-border shadow-xs text-3xl">
        📖
      </div>
      <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">Your bag is currently empty</h2>
      <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
        Discover inspiring books, undated planners, writing pens, and creative supplies in our curated catalog.
      </p>
      <div class="pt-2">
        <a href="{{ $plRoute('store.shop') }}" class="inline-block px-8 py-3.5 bg-pl-terracotta hover:bg-pl-terracottaHover text-white text-xs sm:text-sm font-bold rounded-full transition-colors shadow-sm">
          Explore Books & Stationery
        </a>
      </div>
    </div>
  </template>

  <!-- Non-empty Cart State -->
  <div x-show="items.length" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

    <!-- Cart Items List (8 cols on desktop) -->
    <div class="lg:col-span-8 space-y-6">

      <!-- Free Shipping Meter (Threshold $35) -->
      <div class="bg-white rounded-2xl p-4 sm:p-5 border border-pl-border space-y-2 shadow-xs">
        <div class="flex items-center justify-between text-xs font-semibold">
          <span class="text-slate-800" x-show="subtotal >= 35">
            ✨ You have unlocked <strong class="text-emerald-700">Free Express Shipping</strong>!
          </span>
          <span class="text-slate-800" x-show="subtotal < 35">
            Add <strong class="text-pl-terracotta" x-text="money(35 - subtotal)"></strong> more for <strong>Free Shipping</strong>
          </span>
          <span class="text-slate-400" x-text="Math.min(100, Math.round((subtotal / 35) * 100)) + '%'"></span>
        </div>
        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
          <div class="h-full bg-pl-forest rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, (subtotal / 35) * 100) + '%'"></div>
        </div>
      </div>

      <!-- Items List -->
      <div class="bg-white rounded-2xl border border-pl-border divide-y divide-pl-border/60 shadow-xs overflow-hidden">
        <template x-for="(item, idx) in items" :key="item.id || idx">
          <div class="p-5 sm:p-6 flex items-start gap-4 sm:gap-6">

            <!-- Item Thumbnail -->
            <div class="w-20 sm:w-24 aspect-square rounded-xl overflow-hidden bg-pl-cream border border-pl-border shrink-0 p-2 flex items-center justify-center">
              <img :src="item.image || '{{ global_asset('images/products/no-image.png') }}'"
                   :alt="item.name"
                   class="max-w-full max-h-full object-contain">
            </div>

            <!-- Item Meta & Controls -->
            <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

              <div class="space-y-1">
                <h3 class="text-sm font-semibold text-slate-900 leading-snug" x-text="item.name"></h3>
                <span class="text-xs font-bold text-pl-terracotta" x-text="money(item.price)"></span>
                <span class="block text-[11px] text-slate-400">In Stock • Dispatched within 24h</span>
              </div>

              <!-- Quantity Controls -->
              <div class="flex items-center gap-4">
                <div class="flex items-center border border-pl-border rounded-lg bg-pl-cream overflow-hidden h-9">
                  <button type="button"
                          @click="dec(item)"
                          class="w-8 h-full flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors font-bold text-xs">
                    &minus;
                  </button>
                  <input type="number"
                         :value="item.qty"
                         @change="setQty(item, $event.target.value)"
                         min="1"
                         class="w-10 h-full text-center bg-transparent text-xs font-bold text-slate-900 outline-none">
                  <button type="button"
                          @click="inc(item)"
                          class="w-8 h-full flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors font-bold text-xs">
                    +
                  </button>
                </div>

                <!-- Line Total -->
                <div class="text-right min-w-[70px]">
                  <span class="text-sm font-bold text-slate-900" x-text="lineTotal(item)"></span>
                </div>

                <!-- Remove Item -->
                <button type="button"
                        @click="remove(item)"
                        class="text-slate-400 hover:text-red-600 transition-colors p-1"
                        title="Remove item">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </button>
              </div>

            </div>

          </div>
        </template>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-between pt-2">
        <a href="{{ $plRoute('store.shop') }}" class="text-xs font-semibold text-slate-900 hover:text-pl-terracotta underline transition-colors">
          &larr; Continue Shopping
        </a>
        <button type="button" @click="clear()" class="text-xs text-slate-400 hover:text-red-600 underline">
          Clear Bag
        </button>
      </div>

    </div>

    <!-- Order Summary (4 cols on desktop) -->
    <div class="lg:col-span-4 bg-white rounded-2xl p-6 sm:p-7 border border-pl-border space-y-6 shadow-xs lg:sticky lg:top-28">
      <h2 class="font-serif-book text-xl font-bold text-slate-900 tracking-tight">
        Order Summary
      </h2>

      <div class="space-y-3 text-xs">
        <div class="flex justify-between text-slate-600">
          <span>Subtotal</span>
          <span class="font-semibold text-slate-900" x-text="money(subtotal)"></span>
        </div>
        <div class="flex justify-between text-slate-600">
          <span>Estimated Shipping</span>
          <span class="font-semibold text-slate-900" x-text="subtotal >= 35 ? 'Free' : money(4.99)"></span>
        </div>
        <div class="flex justify-between text-slate-600">
          <span>Tax</span>
          <span class="font-semibold text-slate-900">Calculated at checkout</span>
        </div>
        <div class="border-t border-pl-border pt-3 flex justify-between text-sm font-bold text-slate-900">
          <span>Estimated Total</span>
          <span x-text="money(subtotal >= 35 ? subtotal : (subtotal + 4.99))"></span>
        </div>
      </div>

      <!-- Checkout CTA -->
      <button type="button"
              @click="checkout('{{ $checkoutUrl }}')"
              class="w-full py-3.5 bg-pl-terracotta hover:bg-pl-terracottaHover text-white text-xs sm:text-sm font-bold uppercase tracking-wider rounded-xl shadow-md active:scale-95 transition-all flex items-center justify-center gap-2">
        <span>Proceed to Checkout</span>
        <span>&rarr;</span>
      </button>

      <!-- Trust Badges -->
      <div class="space-y-2 text-[11px] text-slate-500 pt-2 border-t border-pl-border">
        <div class="flex items-center gap-2">
          <span>🔒</span> <span>100% Secure Encrypted Checkout</span>
        </div>
        <div class="flex items-center gap-2">
          <span>📦</span> <span>Eco-Friendly Recycled Packaging</span>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection
