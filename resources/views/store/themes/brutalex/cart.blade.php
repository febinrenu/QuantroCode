<!doctype html>
<html lang="en">
<head>
@include('store.themes.brutalex._shell', ['pageTitle' => 'YOUR CART — ' . ($s->store_name ?? 'BRUTALEX')])
</head>
<body class="bg-white text-ink-black antialiased">

@include('store.themes.brutalex.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-6 py-8">
    <h1 class="text-3xl text-ink-black mb-6 flex items-center gap-3">
      <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      YOUR CART
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 border-4 border-ink-black bx-shadow-sm">
          <svg class="w-14 h-14 mx-auto text-ink-black/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 bx-copy text-ink-black/50">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-12 px-6 bg-ink-black text-white font-bold uppercase items-center border-4 border-ink-black bx-shadow-sm bx-shadow-hover">Start Shopping</a>
        </div>
      </template>

      <div class="border-4 border-ink-black divide-y-4 divide-ink-black bx-shadow-sm">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover border-4 border-ink-black">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-bold uppercase text-ink-black truncate" x-text="it.name"></div>
              <div class="text-sm font-mono font-bold text-ink-red" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border-4 border-ink-black h-10">
              <button type="button" class="w-9 h-full text-ink-black font-bold" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm font-mono font-bold" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-9 h-full text-ink-black font-bold" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-mono font-bold text-ink-black" x-text="lineTotal(it)"></div>
            <button type="button" class="text-ink-black/40 hover:text-ink-red" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="border-4 border-ink-black p-5 mt-4 bx-shadow-sm" x-show="items.length">
        <div class="flex justify-between text-sm font-mono text-ink-black/60 uppercase font-bold"><span>Subtotal</span><strong class="text-ink-black" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2 uppercase font-bold"><span class="text-ink-black">Total</span><strong class="text-ink-red text-xl font-mono" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-12 px-5 border-4 border-ink-black text-sm font-bold uppercase text-ink-black" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-12 bg-ink-red text-white font-bold uppercase border-4 border-ink-black bx-shadow-sm bx-shadow-hover" @click="checkout('{{ route('checkout') }}')">
            Proceed To Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-bold uppercase text-ink-red">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path stroke-linecap="square" stroke-linejoin="miter" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.brutalex.partials.footer', ['categories' => $categories])
@include('store.themes.brutalex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
