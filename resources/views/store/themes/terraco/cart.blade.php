<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.terraco._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Terraco')])
</head>
<body class="bg-terra-bg text-terra-ink antialiased">

@include('store.themes.terraco.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-3xl mx-auto px-6 py-14">
    <h1 class="font-heading font-light text-4xl text-terra-ink mb-10 flex items-center gap-3">
      <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-24 border border-terra-line">
          <svg class="w-12 h-12 mx-auto text-terra-line" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-5 text-terra-inkSoft">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-6 inline-flex h-11 px-7 border border-terra-ink text-terra-ink text-sm font-medium items-center hover:bg-terra-ink hover:text-white transition-colors">Start Shopping</a>
        </div>
      </template>

      <div class="border border-terra-line divide-y divide-terra-line">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-5">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover border border-terra-line">
            <div class="flex-1 min-w-0">
              <div class="text-sm text-terra-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-medium text-terra-slate" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-terra-line h-9">
              <button type="button" class="w-8 h-full text-terra-inkSoft" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-terra-inkSoft" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-medium text-terra-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-terra-line hover:text-terra-rust" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="border border-terra-line p-6 mt-6" x-show="items.length">
        <div class="flex justify-between text-sm text-terra-inkSoft"><span>Subtotal</span><strong class="text-terra-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-3"><span class="text-terra-ink">Total</span><strong class="text-terra-slate text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-3 mt-6">
          <button type="button" class="h-11 px-5 border border-terra-line text-sm text-terra-inkSoft hover:border-terra-lineStrong" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 border border-terra-slate bg-terra-slate text-white font-medium tracking-wide hover:bg-terra-slateDark" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 mt-8 text-sm font-medium text-terra-slate">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.terraco.partials.footer', ['categories' => $categories])
@include('store.themes.terraco.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
