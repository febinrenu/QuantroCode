<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.urbana._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Urbana')])
</head>
<body class="bg-brand-cream text-brand-ink antialiased">

@include('store.themes.urbana.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold font-heading text-brand-ink mb-6 flex items-center gap-2">
      <svg class="w-6 h-6 text-brand-blue" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 bg-white rounded-3xl border border-brand-blueLight shadow-soft">
          <svg class="w-14 h-14 mx-auto text-brand-blueLight" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-brand-ink/50">Your cart is feeling a little empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-12 px-7 rounded-full bg-brand-blue text-white font-semibold items-center shadow-soft">Start Shopping</a>
        </div>
      </template>

      <div class="bg-white rounded-3xl border border-brand-blueLight shadow-soft divide-y divide-brand-blueLight">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 rounded-2xl object-cover border border-brand-blueLight">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-brand-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-brand-coral" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-brand-blueLight rounded-full h-10">
              <button type="button" class="w-9 h-full text-brand-ink/60" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-9 h-full text-brand-ink/60" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-brand-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-brand-blueLight hover:text-brand-coral" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-white rounded-3xl border border-brand-blueLight shadow-soft p-6 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-brand-ink/60"><span>Subtotal</span><strong class="text-brand-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-brand-ink">Total</span><strong class="text-brand-blue text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-12 px-5 rounded-full border border-brand-blueLight text-sm font-semibold text-brand-ink/70" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-12 rounded-full bg-brand-coral text-white font-bold shadow-softCoral" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-semibold text-brand-blue">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.urbana.partials.footer', ['categories' => $categories])
@include('store.themes.urbana.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
