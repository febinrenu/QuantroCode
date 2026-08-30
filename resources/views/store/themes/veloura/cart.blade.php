<!doctype html>
<html lang="en">
<head>
@include('store.themes.veloura._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Veloura')])
</head>
<body class="bg-vel-black text-vel-ink antialiased">

@include('store.themes.veloura.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-10">
    <span class="eyebrow text-vel-gold text-xs font-bold">Your Selections</span>
    <h1 class="font-serif text-3xl font-bold text-vel-ink mt-2 mb-8 flex items-center gap-3">
      <svg class="w-7 h-7 text-vel-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-24 bg-vel-charcoal border border-vel-line">
          <svg class="w-14 h-14 mx-auto text-vel-line" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-vel-mute font-serif text-lg">Your cart is currently empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-6 inline-flex h-11 px-7 bg-vel-gold text-vel-black font-semibold text-sm items-center hover:bg-vel-goldSoft transition-colors">Continue Browsing</a>
        </div>
      </template>

      <div class="bg-vel-charcoal border border-vel-line divide-y divide-vel-line">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover border border-vel-line">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-vel-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-vel-gold" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-vel-line h-9">
              <button type="button" class="w-8 h-full text-vel-mute hover:text-vel-gold" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-vel-black text-vel-ink" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-vel-mute hover:text-vel-gold" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-vel-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-vel-line hover:text-vel-burgundy" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-vel-charcoal border border-vel-line p-6 mt-5" x-show="items.length">
        <div class="flex justify-between text-sm text-vel-mute"><span>Subtotal</span><strong class="text-vel-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-3"><span class="font-bold text-vel-ink">Total</span><strong class="text-vel-gold text-lg font-serif" x-text="money(grand)"></strong></div>
        <div class="flex gap-3 mt-6">
          <button type="button" class="h-11 px-5 border border-vel-line text-sm font-semibold text-vel-mute hover:text-vel-ink" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 bg-vel-gold text-vel-black font-bold hover:bg-vel-goldSoft transition-colors" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-8 text-sm font-semibold text-vel-gold hover:text-vel-goldSoft">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.veloura.partials.footer', ['categories' => $categories])
@include('store.themes.veloura.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
