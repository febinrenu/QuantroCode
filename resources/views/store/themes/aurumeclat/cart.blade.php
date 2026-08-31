<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => 'Your Shopping Bag — ' . ($s->store_name ?? 'AurumÉclat')])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#0E0D0B] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

<main class="pb-24">
  
  <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12">
    
    <div class="border-b border-aurum-border/60 pb-6 mb-8">
      <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-semibold block">AURUMÉCLAT BAG</span>
      <h1 class="font-serif text-3xl sm:text-4xl text-white font-normal mt-1">Your Selected Fine Pieces</h1>
    </div>

    <div x-data="miniCart()">
      
      <!-- Empty Bag State -->
      <template x-if="!items.length">
        <div class="text-center py-20 bg-[#12100E] border border-aurum-border p-8 space-y-4">
          <div class="text-4xl text-aurum-gold/40 font-serif">✦</div>
          <p class="text-white font-serif text-2xl">Your shopping bag is currently empty.</p>
          <p class="text-xs text-aurum-goldLight/60 font-light max-w-sm mx-auto leading-relaxed">
            Discover our curated collections of diamond rings, heirloom necklaces, and certified gemstones.
          </p>
          <div class="pt-2">
            <a href="{{ route('store.shop') }}" class="inline-block px-8 py-3 bg-aurum-gold text-aurum-black text-xs font-semibold tracking-widest uppercase hover:bg-aurum-goldLight transition-colors">
              EXPLORE FINE JEWELRY
            </a>
          </div>
        </div>
      </template>

      <!-- Cart Items List -->
      <div class="space-y-4" x-show="items.length">
        <template x-for="it in items" :key="it.id">
          <div class="flex items-center gap-5 p-5 bg-[#141210] border border-aurum-border">
            <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-20 h-20 object-contain bg-[#0A0908] p-1 border border-aurum-border/50">
            
            <div class="flex-1 min-w-0">
              <div class="text-sm sm:text-base font-serif text-white truncate font-medium" x-text="it.name"></div>
              <div class="text-xs font-semibold text-aurum-gold mt-0.5" x-text="hidePrices ? '' : money(it.price)"></div>
            </div>

            <!-- Qty Controls -->
            <div class="flex items-center border border-aurum-border bg-[#0E0D0B] h-9">
              <button type="button" class="px-2.5 h-full text-aurum-goldLight hover:text-aurum-gold text-xs" @click="dec(it)">−</button>
              <input type="number" class="w-10 text-center h-full text-xs text-white bg-transparent focus:outline-none" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
              <button type="button" class="px-2.5 h-full text-aurum-goldLight hover:text-aurum-gold text-xs" @click="inc(it)">+</button>
            </div>

            <div class="w-24 text-right text-sm font-serif font-semibold text-white" x-text="lineTotal(it)"></div>

            <button type="button" class="p-2 text-aurum-goldLight/60 hover:text-red-400 transition-colors" @click="remove(it)" aria-label="Remove item">
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>
            </button>
          </div>
        </template>

        <!-- Totals & Actions -->
        <div class="p-6 bg-[#141210] border border-aurum-border space-y-4">
          <div class="flex justify-between text-xs text-aurum-goldLight/70">
            <span>Complimentary Insured Shipping</span>
            <span class="text-emerald-400 font-medium">Free</span>
          </div>
          <div class="flex justify-between text-xs text-aurum-goldLight/70">
            <span>Subtotal</span>
            <strong class="text-white font-medium text-sm" x-text="money(subtotal)"></strong>
          </div>
          <div class="flex justify-between text-base pt-3 border-t border-aurum-border/60">
            <span class="font-serif text-white">Estimated Total</span>
            <strong class="text-aurum-gold font-serif text-xl font-bold" x-text="money(grand)"></strong>
          </div>

          <div class="flex flex-col sm:flex-row gap-3 pt-4">
            <button type="button" class="py-3 px-6 border border-aurum-border text-xs tracking-wider uppercase text-aurum-goldLight/70 hover:border-white hover:text-white transition-colors" @click="clear">
              Clear Bag
            </button>
            <button type="button" class="flex-1 py-3 px-6 bg-aurum-gold hover:bg-[#E5C158] text-aurum-black font-semibold text-xs tracking-[0.2em] uppercase transition-colors text-center" @click="checkout('{{ route('checkout') }}')">
              PROCEED TO SECURE CHECKOUT →
            </button>
          </div>
        </div>

      </div>

    </div>

    <div class="mt-8">
      <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 text-xs tracking-widest text-aurum-gold hover:text-white uppercase font-medium transition-colors">
        <span>&larr;</span>
        <span>CONTINUE BROWSING JEWELRY</span>
      </a>
    </div>

  </div>

</main>

@include('store.themes.aurumeclat.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
