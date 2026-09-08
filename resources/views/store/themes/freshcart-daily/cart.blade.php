<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.freshcart-daily._shell', ['pageTitle' => ( __('messages.YourCart') ?? 'Your Cart') . ' — ' . ($s->store_name ?? 'FreshCart')])
</head>
<body class="bg-fc-cream text-fc-ink antialiased">

@include('store.themes.freshcart-daily.partials.header', ['categories' => $categories])

<main class="pb-24 md:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="font-heading text-2xl font-extrabold text-fc-ink mb-8 flex items-center gap-2">
      <svg class="w-6 h-6 text-fc-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      {{ __('messages.YourCart') ?? 'Your Cart' }}
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 bg-white border border-fc-green/15 rounded-xl2">
          <svg class="w-14 h-14 mx-auto text-fc-green/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-fc-inkSoft">{{ __('messages.YourCartIsEmpty') ?? 'Your cart is empty.' }}</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 bg-fc-green text-white font-bold text-xs rounded-full items-center">{{ 'Start Shopping' }}</a>
        </div>
      </template>

      <div class="bg-white border border-fc-green/15 rounded-xl2 divide-y divide-fc-green/10 overflow-hidden">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover rounded-lg border border-fc-green/10">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-fc-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-fc-green" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-fc-green/20 rounded-full h-9">
              <button type="button" class="w-8 h-full text-fc-inkSoft" @click="dec(it)">&minus;</button>
              <input type="number" class="w-10 text-center h-full text-sm" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-fc-inkSoft" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-fc-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-fc-green/40 hover:text-fc-red" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-white border border-fc-green/15 rounded-xl2 p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-fc-inkSoft"><span>{{ __('messages.Subtotal') ?? 'Subtotal' }}</span><strong class="text-fc-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-fc-ink">{{ __('messages.Total') ?? 'Total' }}</span><strong class="text-fc-green text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 border border-fc-green/25 rounded-full text-xs font-bold text-fc-inkSoft" @click="clear">{{ __('messages.ClearCart') ?? 'Clear Cart' }}</button>
          <button type="button" class="flex-1 h-11 bg-fc-green text-white font-bold text-xs rounded-full" @click="checkout('{{ route('checkout') }}')">
            {{ 'Proceed to Checkout' }} &rarr;
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-8 text-xs font-bold text-fc-green">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      {{ __('messages.ContinueShopping') ?? 'Continue Shopping' }}
    </a>
  </div>
</main>

@include('store.themes.freshcart-daily.partials.footer', ['categories' => $categories])
@include('store.themes.freshcart-daily.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
