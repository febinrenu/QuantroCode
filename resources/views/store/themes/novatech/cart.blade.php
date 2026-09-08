<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.novatech._shell', ['pageTitle' => 'Your Cart — ' . ($s->store_name ?? 'NovaTech')])
</head>
<body class="bg-nova-bg text-slate-100 antialiased bg-nova-radial bg-no-repeat">

@include('store.themes.novatech.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

<main class="pb-24 lg:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
      <svg class="w-6 h-6 text-nova-violetLight" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Your Cart
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 nt-glass rounded-2xl">
          <svg class="w-14 h-14 mx-auto text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-slate-400">Your cart is empty.</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 rounded-full bg-nova-violet text-white font-semibold items-center hover:bg-nova-violetDark">Start Shopping</a>
        </div>
      </template>

      <div class="nt-glass rounded-2xl divide-y divide-white/10">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 rounded-lg object-cover border border-white/10">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-white truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-nova-violetLight" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-white/10 rounded-full h-9">
              <button type="button" class="w-8 h-full text-slate-300" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-sm bg-transparent text-white" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-slate-300" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-white" x-text="lineTotal(it)"></div>
            <button type="button" class="text-slate-500 hover:text-nova-violet" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="nt-glass rounded-2xl p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-slate-400"><span>Subtotal</span><strong class="text-white" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-white">Total</span><strong class="text-nova-violetLight text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 rounded-full border border-white/10 text-sm font-semibold text-slate-300" @click="clear">Clear Cart</button>
          <button type="button" class="flex-1 h-11 rounded-full bg-nova-violet text-white font-bold hover:bg-nova-violetDark hover:shadow-glow transition-all" @click="checkout('{{ route('checkout') }}')">
            Proceed to Checkout →
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-semibold text-nova-violetLight">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      Continue Shopping
    </a>
  </div>
</main>

@include('store.themes.novatech.partials.footer', ['categories' => $categories])
@include('store.themes.novatech.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
