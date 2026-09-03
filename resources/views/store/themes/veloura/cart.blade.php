@extends('store.themes.veloura._shell')

@section('title', 'Shopping Bag — ' . ($s->store_name ?? 'Veloura Beauty'))

@section('content')
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $velRoute('store.shop');
  $checkoutUrl = url('/online_store/checkout' . ($themePreview ? '?preview_theme=' . $themePreview : ''));
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="miniCart()" x-cloak>

  <!-- Breadcrumbs & Heading -->
  <div class="mb-8 space-y-2">
    <nav class="flex items-center gap-2 text-xs text-vel-muted font-medium">
      <a href="{{ $velRoute('store.index') }}" class="hover:text-vel-rose transition-colors">Home</a>
      <span>/</span>
      <span class="text-vel-charcoal font-bold">Shopping Bag</span>
    </nav>

    <div class="flex items-baseline justify-between border-b border-vel-border pb-5">
      <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-vel-charcoal tracking-tight">
        Your Shopping Bag
      </h1>
      <span class="text-xs text-vel-muted font-medium">
        <span x-text="count">0</span> items selected
      </span>
    </div>
  </div>

  <!-- Populated Bag State -->
  <template x-if="items.length > 0">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

      <!-- Items Table List -->
      <div class="lg:col-span-8 bg-white rounded-3xl border border-vel-border p-6 sm:p-8 shadow-sm space-y-6">

        <div class="space-y-6 divide-y divide-vel-border">
          <template x-for="item in items" :key="item.id">
            <div class="pt-6 first:pt-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">

              <!-- Product Info & Thumb -->
              <div class="flex items-center gap-4 flex-1">
                <div class="w-20 h-20 rounded-2xl bg-vel-blush border border-vel-border overflow-hidden flex items-center justify-center p-2 shrink-0">
                  <img :src="item.image || '{{ global_asset('images/themes/veloura/generic-beauty.jpg') }}'"
                       :alt="item.name"
                       class="max-w-full max-h-full object-contain">
                </div>
                <div class="space-y-1">
                  <h3 class="font-serif-luxury text-sm font-bold text-vel-charcoal" x-text="item.name"></h3>
                  <div class="text-xs text-vel-muted font-medium">
                    Unit Price: <span class="font-bold text-vel-charcoal" x-text="formatPrice(item.price)"></span>
                  </div>
                </div>
              </div>

              <!-- Quantity Controls & Line Total -->
              <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">

                <!-- Stepper -->
                <div class="flex items-center border border-vel-border rounded-xl bg-vel-blush">
                  <button type="button"
                          @click="updateQty(item.id, item.qty - 1)"
                          class="px-3 py-1 text-xs font-bold hover:text-vel-rose transition-colors">
                    &minus;
                  </button>
                  <span x-text="item.qty" class="px-3 py-1 text-xs font-bold text-vel-charcoal min-w-[2rem] text-center"></span>
                  <button type="button"
                          @click="updateQty(item.id, item.qty + 1)"
                          class="px-3 py-1 text-xs font-bold hover:text-vel-rose transition-colors">
                    +
                  </button>
                </div>

                <!-- Total -->
                <div class="text-right min-w-[5rem]">
                  <span class="text-sm font-bold text-vel-charcoal" x-text="formatPrice(item.price * item.qty)"></span>
                </div>

                <!-- Remove -->
                <button type="button"
                        @click="remove(item.id)"
                        class="p-2 text-slate-400 hover:text-rose-600 transition-colors"
                        title="Remove item">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>

              </div>

            </div>
          </template>
        </div>

        <!-- Bag Action Links -->
        <div class="pt-6 border-t border-vel-border flex items-center justify-between text-xs">
          <a href="{{ $shopUrl }}" class="font-bold text-vel-rose hover:underline flex items-center gap-1">
            &larr; Continue Shopping
          </a>
          <button type="button"
                  @click="clear()"
                  class="text-slate-400 hover:text-rose-600 font-medium transition-colors">
            Clear Shopping Bag
          </button>
        </div>

      </div>

      <!-- Order Summary Card -->
      <div class="lg:col-span-4 bg-white rounded-3xl border border-vel-border p-6 sm:p-8 shadow-sm space-y-6 sticky top-28">

        <h2 class="font-serif-luxury text-xl font-bold text-vel-charcoal border-b border-vel-border pb-4">
          Order Summary
        </h2>

        <div class="space-y-3 text-xs text-vel-muted">
          <div class="flex items-center justify-between">
            <span>Bag Subtotal</span>
            <span class="font-bold text-vel-charcoal text-sm" x-text="formatPrice(subtotal)">$0.00</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Complimentary Shipping</span>
            <span class="text-emerald-600 font-bold">FREE</span>
          </div>
          <div class="flex items-center justify-between">
            <span>3 Luxury Samples</span>
            <span class="text-vel-rose font-bold">Included</span>
          </div>
          <div class="pt-3 border-t border-vel-border flex items-center justify-between text-sm font-bold text-vel-charcoal">
            <span>Estimated Total</span>
            <span class="text-xl font-serif-luxury text-vel-roseDeep" x-text="formatPrice(total)">$0.00</span>
          </div>
        </div>

        <div class="space-y-3 pt-2">
          <a href="{{ $checkoutUrl }}"
             class="block w-full py-4 bg-vel-charcoal hover:bg-vel-espresso text-white font-bold text-xs rounded-full shadow-lg active:scale-95 transition-all uppercase tracking-widest text-center">
            Proceed to Checkout &rarr;
          </a>

          <p class="text-[11px] text-center text-vel-muted font-light">
            🔒 Safe & Secure 256-Bit Encrypted Checkout
          </p>
        </div>

      </div>

    </div>
  </template>

  <!-- Empty Bag State -->
  <template x-if="items.length === 0">
    <div class="bg-white rounded-3xl border border-vel-border p-12 sm:p-16 text-center space-y-6 max-w-xl mx-auto shadow-sm">
      <div class="w-20 h-20 rounded-full bg-vel-roseLight flex items-center justify-center text-3xl mx-auto shadow-inner">
        🌸
      </div>
      <div class="space-y-2">
        <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal">
          Your Shopping Bag is Empty
        </h2>
        <p class="text-xs sm:text-sm text-vel-muted font-light max-w-md mx-auto">
          Explore our collection of haute parfums, botanical skincare, and silken cosmetics to build your personalized beauty ritual.
        </p>
      </div>
      <div>
        <a href="{{ $shopUrl }}"
           class="inline-block px-8 py-4 bg-vel-rose hover:bg-vel-roseDark text-white font-bold text-xs rounded-full shadow-md active:scale-95 transition-all uppercase tracking-widest">
          Discover Beauty Rituals &rarr;
        </a>
      </div>
    </div>
  </template>

</div>
@endsection
