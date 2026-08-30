<!doctype html>
<html lang="en">
<head>
@include('store.themes.elegance._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Elegance')])
</head>
<body class="bg-brand-cream text-brand-charcoal antialiased">

@include('store.themes.elegance.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-3xl mx-auto px-6 py-14">
    <h1 class="font-serif text-3xl italic text-brand-charcoal mb-10">Your Cart</h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-24 border-t border-b el-hairline">
          <svg class="w-12 h-12 mx-auto text-brand-charcoalSoft" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-5 text-brand-charcoalSoft font-serif italic text-lg">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-6 inline-flex h-11 px-8 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold items-center hover:bg-brand-gold transition-colors">Start Shopping</a>
        </div>
      </template>

      <div class="border-t el-hairline">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-5 py-5 border-b el-hairline">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-serif text-brand-charcoal truncate" x-text="it.name"></div>
              <div class="text-sm font-semibold text-brand-gold" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-brand-hairline h-9">
              <button type="button" class="w-8 h-full text-brand-charcoalSoft" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-brand-charcoalSoft" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-semibold text-brand-charcoal" x-text="lineTotal(it)"></div>
            <button type="button" class="text-brand-charcoalSoft hover:text-brand-gold" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="pt-8 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-brand-charcoalSoft"><span>Subtotal</span><strong class="text-brand-charcoal" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-3 pt-3 border-t el-hairline"><span class="font-serif text-brand-charcoal">Total</span><strong class="text-brand-gold text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-3 mt-8">
          <button type="button" class="h-11 px-6 border border-brand-hairline text-sm font-medium text-brand-charcoalSoft hover:border-brand-charcoal hover:text-brand-charcoal transition-colors" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold transition-colors" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-10 text-xs eyebrow font-semibold text-brand-charcoal hover:text-brand-gold">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.elegance.partials.footer', ['categories' => $categories])
@include('store.themes.elegance.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
