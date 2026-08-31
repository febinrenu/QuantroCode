<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.elegance-boutique._shell', ['pageTitle' => ( __('messages.YourCart') ?? 'Your Cart') . ' — ' . ($s->store_name ?? 'Élégance')])
</head>
<body class="bg-el-cream text-el-ink antialiased">

@include('store.themes.elegance-boutique.partials.header', ['categories' => $categories])

<main class="pb-24 md:pb-0">
  <div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="font-serif text-3xl text-el-ink mb-8 flex items-center gap-2">
      <svg class="w-6 h-6 text-el-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      {{ __('messages.YourCart') ?? 'Your Cart' }}
    </h1>

    <div x-data="miniCart()">
      <template x-if="!items.length">
        <div class="text-center py-20 bg-white border border-el-ink/15">
          <svg class="w-14 h-14 mx-auto text-el-ink/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <p class="mt-4 text-el-inkSoft">{{ __('messages.YourCartIsEmpty') ?? 'Your cart is empty.' }}</p>
          <a href="{{ route('store.shop') }}" class="mt-4 inline-flex h-11 px-6 bg-el-black text-white font-bold text-xs eyebrow items-center">{{ 'Start Shopping' }}</a>
        </div>
      </template>

      <div class="bg-white border border-el-ink/15 divide-y divide-el-ink/10">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-4 p-4">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 object-cover border border-el-ink/10">
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-el-ink truncate" x-text="it.name"></div>
              <div class="text-sm font-bold text-el-ink" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>
            <div class="flex items-center border border-el-ink/20 h-9">
              <button type="button" class="w-8 h-full text-el-inkSoft" @click="dec(it)">&minus;</button>
              <input type="number" class="w-10 text-center h-full text-sm" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="w-8 h-full text-el-inkSoft" @click="inc(it)">+</button>
            </div>
            <div class="w-20 text-right text-sm font-bold text-el-ink" x-text="lineTotal(it)"></div>
            <button type="button" class="text-el-ink/30 hover:text-red-500" @click="remove(it)" aria-label="Remove">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>
      </div>

      <div class="bg-white border border-el-ink/15 p-5 mt-4" x-show="items.length">
        <div class="flex justify-between text-sm text-el-inkSoft"><span>{{ __('messages.Subtotal') ?? 'Subtotal' }}</span><strong class="text-el-ink" x-text="money(subtotal)"></strong></div>
        <div class="flex justify-between text-base mt-2"><span class="font-bold text-el-ink">{{ __('messages.Total') ?? 'Total' }}</span><strong class="text-el-gold text-lg" x-text="money(grand)"></strong></div>
        <div class="flex gap-2 mt-5">
          <button type="button" class="h-11 px-5 border border-el-ink/20 text-xs eyebrow font-bold text-el-inkSoft" @click="clear">{{ __('messages.ClearCart') ?? 'Clear Cart' }}</button>
          <button type="button" class="flex-1 h-11 bg-el-black text-white font-bold text-xs eyebrow hover:bg-el-gold hover:text-el-black" @click="checkout('{{ route('checkout') }}')">
            {{ 'Proceed to Checkout' }} &rarr;
          </button>
        </div>
      </div>
    </div>

    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-8 text-xs eyebrow font-bold text-el-ink hover:text-el-gold">
      <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7"/></svg>
      {{ __('messages.ContinueShopping') ?? 'Continue Shopping' }}
    </a>
  </div>
</main>

@include('store.themes.elegance-boutique.partials.footer', ['categories' => $categories])
@include('store.themes.elegance-boutique.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
