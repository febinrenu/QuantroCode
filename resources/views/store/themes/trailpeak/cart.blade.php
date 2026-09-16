<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.trailpeak._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'TrailPeak')])
</head>
<body class="bg-tp-cream text-tp-ink antialiased">

@include('store.themes.trailpeak.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-3xl mx-auto px-5 py-10 text-center">
    <h1 class="text-3xl font-display font-bold text-tp-ink mb-8 flex items-center justify-center gap-2">
      <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()" class="text-left">
      <template x-if="!items.length">
        <div class="text-center py-20 bg-white border border-tp-line rounded-lg">
          <svg class="w-14 h-14 mx-auto text-tp-line" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-tp-mute">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 bg-tp-orange text-white font-bold text-sm rounded items-center hover:brightness-95 transition">Start Shopping</a>
        </div>
      </template>

      <div class="bg-white border border-tp-line rounded-lg divide-y divide-tp-line overflow-hidden">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover rounded border border-tp-line">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-tp-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-tp-forest" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-tp-line rounded h-9">
              <button type="button" class="w-8 h-full text-tp-mute" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-tp-mute" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-tp-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-tp-mute hover:text-red-500" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-white border border-tp-line rounded-lg p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-tp-mute"><span>Subtotal</span><strong class="text-tp-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-tp-ink">Total</span><strong class="text-tp-forest text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 border border-tp-line rounded text-sm font-bold text-tp-mute hover:bg-tp-cream" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 bg-tp-orange text-white font-bold text-sm rounded hover:brightness-95 transition" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-8 text-sm font-bold text-tp-forest">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.trailpeak.partials.footer', ['categories' => $categories])
@include('store.themes.trailpeak.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
