<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.voguelane._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Voguelane')])
</head>
<body class="bg-white text-black antialiased">

@include('store.themes.voguelane.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <section class="bg-black text-white">
    <div class="px-4 lg:px-8 py-10">
      <span class="eyebrow text-brand-magenta text-xs font-bold">Bag</span>
      <h1 class="font-display text-6xl lg:text-7xl mt-1 flex items-center gap-4">
        YOUR CART
        <svg class="w-10 h-10 lg:w-12 lg:h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      </h1>
    </div>
  </section>

  <div class="px-4 lg:px-8 py-10 max-w-3xl">
    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 border border-black/10">
          <svg class="w-14 h-14 mx-auto text-black/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-black/40 uppercase tracking-wide text-sm">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-12 px-7 bg-black text-white font-bold uppercase tracking-wide items-center hover:bg-brand-magenta transition-colors">Start Shopping</a>
        </div>
      </template>

      <div class="border border-black/10 divide-y divide-black/10">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-20 object-cover border border-black/10">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-black truncate" x-text="it.name"></div>
              <div class="text-sm font-display text-lg" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-black h-9">
              <button type="button" class="w-8 h-full text-black" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-black" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-black" x-text="lineTotal(it)"></div>
            <button type="button" class="text-black/30 hover:text-brand-magenta" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="border border-black/10 p-6 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-black/50 uppercase tracking-wide"><span>Subtotal</span><strong class="text-black" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold uppercase tracking-wide">Total</span><strong class="font-display text-2xl" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-6">
          <button type="button" class="h-12 px-5 border border-black text-sm font-bold uppercase tracking-wide" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-12 bg-black text-white font-bold uppercase tracking-wide hover:bg-brand-magenta transition-colors" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-bold text-brand-magenta uppercase tracking-wide">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.voguelane.partials.footer', ['categories' => $categories])
@include('store.themes.voguelane.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
