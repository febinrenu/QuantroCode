<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.crystalglass._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'CrystalGlass')])
</head>
<body class="text-brand-ink antialiased">
<div class="cg-mesh"><div class="cg-blob cg-blob-1"></div><div class="cg-blob cg-blob-2"></div><div class="cg-blob cg-blob-3"></div></div>

@include('store.themes.crystalglass.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0 relative z-10">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-black text-brand-ink mb-6 tracking-tight flex items-center gap-2">
      <svg class="w-6 h-6 text-brand-violetDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 glass-strong rounded-3xl shadow-glass">
          <svg class="w-14 h-14 mx-auto text-brand-ink/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-brand-ink/40 tracking-wide">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white font-semibold items-center tracking-wide">Start Shopping</a>
        </div>
      </template>

      <div class="glass-strong rounded-3xl shadow-glass divide-y divide-white/40">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 rounded-2xl object-cover border border-white/50">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-brand-ink truncate tracking-wide" x-text="it.name"></div>
              <div class="text-sm font-bold text-brand-violetDark" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-white/60 bg-white/40 rounded-full h-9">
              <button type="button" class="w-8 h-full text-brand-ink/60" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-brand-ink/60" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-brand-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-brand-ink/30 hover:text-red-500" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="glass-strong rounded-3xl shadow-glass p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-brand-ink/60 tracking-wide"><span>Subtotal</span><strong class="text-brand-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2 tracking-wide"><span class="font-bold text-brand-ink">Total</span><strong class="text-brand-violetDark text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 rounded-full border border-white/60 bg-white/40 text-sm font-semibold text-brand-ink/70 tracking-wide" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white font-bold tracking-wide" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-semibold text-brand-violetDark tracking-wide">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.crystalglass.partials.footer', ['categories' => $categories])
@include('store.themes.crystalglass.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
