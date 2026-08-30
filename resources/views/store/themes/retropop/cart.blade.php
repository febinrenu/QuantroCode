<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.retropop._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Retropop')])
</head>
<body class="bg-pop-cream text-pop-ink antialiased">

@include('store.themes.retropop.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl lg:text-3xl font-heading font-extrabold text-pop-ink mb-6 flex items-center gap-2">
      <svg class="w-7 h-7 text-pop-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 bg-white rounded-groovy border-2 border-pop-ink/10 shadow-card">
          <svg class="w-14 h-14 mx-auto text-pop-ink/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-pop-ink/40 font-medium">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-12 px-7 rounded-full bg-pop-orange text-white font-heading font-bold items-center shadow-pop hover:shadow-popHover hover:-translate-y-0.5 transition-all">Start Shopping</a>
        </div>
      </template>

      <div class="bg-white rounded-groovy border-2 border-pop-ink/10 divide-y-2 divide-pop-ink/5 shadow-card overflow-hidden">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 rounded-2xl object-cover border-2 border-pop-ink/10">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-heading font-bold text-pop-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-extrabold text-pop-orange" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border-2 border-pop-ink/10 rounded-full h-9">
              <button type="button" class="w-8 h-full text-pop-ink/50" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-pop-ink/50" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-extrabold text-pop-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-pop-ink/20 hover:text-pop-orange" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-white rounded-groovy border-2 border-pop-ink/10 p-6 mt-4 shadow-card" x-show="items.length">
        <div class="flex justify-between text-sm font-semibold text-pop-ink/60"><span>Subtotal</span><strong class="text-pop-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-heading font-bold text-pop-ink">Total</span><strong class="text-pop-orange text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-12 px-5 rounded-full border-2 border-pop-ink/10 text-sm font-bold text-pop-ink/60" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-12 rounded-full bg-pop-orange text-white font-heading font-bold shadow-pop hover:shadow-popHover hover:-translate-y-0.5 active:translate-y-0 active:shadow-none transition-all" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-heading font-bold text-pop-orange">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.retropop.partials.footer', ['categories' => $categories])
@include('store.themes.retropop.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
