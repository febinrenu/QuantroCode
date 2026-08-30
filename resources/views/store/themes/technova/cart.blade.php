<!doctype html>
<html lang="en">
<head>
@include('store.themes.technova._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'Technova')])
</head>
<body class="bg-tn-bg text-tn-ink antialiased">
<div class="tn-scanlines"></div>

@include('store.themes.technova.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-tn-ink mb-6 flex items-center gap-2 tn-bracket">
      <svg class="w-6 h-6 text-tn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      cat ./cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 tn-window tn-window-pad">
          <svg class="w-14 h-14 mx-auto text-tn-border" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-tn-mute">// your cart is empty</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 border border-tn-green bg-tn-green text-black font-bold items-center">start_shopping</a>
        </div>
      </template>

      <div class="tn-window divide-y divide-tn-border">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover border border-tn-border">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-tn-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-tn-green" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-tn-border h-9">
              <button type="button" class="w-8 h-full text-tn-mute hover:text-tn-green" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-black text-tn-ink" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-tn-mute hover:text-tn-green" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-tn-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-tn-border hover:text-tn-amber" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="tn-window tn-window-pad p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-tn-mute"><span>subtotal</span><strong class="text-tn-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-tn-ink">total</span><strong class="text-tn-green text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 border border-tn-border text-sm font-semibold text-tn-mute hover:text-tn-amber hover:border-tn-amber" @click="clear">clear_cart</button>
          <button type="button" class="flex-1 h-11 tn-glow-btn border border-tn-green bg-tn-green text-black font-bold" @click="checkout('{{ route('checkout') }}')">
            proceed_to_checkout &gt;
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-semibold text-tn-green">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      continue_shopping
    </a>
  </div>
</main>

@include('store.themes.technova.partials.footer', ['categories' => $categories])
@include('store.themes.technova.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
