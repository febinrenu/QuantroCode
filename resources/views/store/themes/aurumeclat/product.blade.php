<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'AurumÉclat')])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#0E0D0B] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

@php
  $currency = $s->currency_code ?? '$';
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24">
  
  <!-- Breadcrumb -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 text-xs text-aurum-goldLight/60 font-light flex items-center gap-2 border-b border-aurum-border/40">
    <a href="{{ route('store.index') }}" class="hover:text-aurum-gold">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-aurum-gold">Fine Jewelry</a> /
    @if($product['category_name'])
      <a href="{{ route('store.shop', ['category' => $p->category_id ?? '']) }}" class="hover:text-aurum-gold">{{ $product['category_name'] }}</a> /
    @endif
    <span class="text-white font-normal">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14 grid lg:grid-cols-12 gap-12"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0, qty: 1 }'>

    <!-- Gallery Column (7 cols) -->
    <div class="lg:col-span-7 space-y-4">
      <div class="aspect-[4/4] sm:aspect-[4/3] bg-[#141210] border border-aurum-border overflow-hidden flex items-center justify-center p-6 relative">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-contain" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-7xl font-serif text-aurum-gold/30">✦</div>
        </template>

        <!-- Purity Tag -->
        <span class="absolute top-4 left-4 bg-[#1F1C17] border border-aurum-gold/40 text-aurum-gold text-[10px] tracking-widest uppercase font-semibold px-2.5 py-1">
          IGI / GIA CERTIFIED
        </span>
      </div>

      <!-- Thumbnail Strip -->
      @if(count($gallery) > 1)
        <div class="flex gap-3 overflow-x-auto pb-2">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-20 h-20 shrink-0 bg-[#141210] border p-1 transition-colors" :class="activeImg === i ? 'border-aurum-gold' : 'border-aurum-border'">
              <img :src="img" class="w-full h-full object-contain">
            </button>
          </template>
        </div>
      @endif
    </div>

    <!-- Buy Box Column (5 cols) -->
    <div class="lg:col-span-5 space-y-6">
      
      <div>
        <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-semibold block">
          {{ $product['category_name'] ?? 'AURUMÉCLAT HIGH JEWELRY' }}
        </span>
        <h1 class="font-serif text-3xl sm:text-4xl text-white font-normal mt-1 leading-tight">
          {{ $product['name'] }}
        </h1>
        <div class="text-[11px] text-aurum-goldLight/50 font-light mt-1.5 flex items-center gap-4">
          <span>SKU: {{ $product['sku'] ?? $product['code'] ?? 'JWL-AUR-001' }}</span>
          <span>•</span>
          <span class="text-emerald-400">In Stock &amp; Ready to Ship</span>
        </div>
      </div>

      <!-- Ratings -->
      <div class="flex items-center gap-2 pt-1">
        <div class="text-aurum-gold text-xs">★★★★★</div>
        <span class="text-xs text-aurum-goldLight/70 font-light">(128 verified connoisseur reviews)</span>
      </div>

      <!-- Price -->
      @if(!$product['hide_prices'])
        <div class="py-4 border-y border-aurum-border/60 flex items-baseline gap-3">
          <span class="text-3xl font-serif text-aurum-gold font-bold" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-serif text-aurum-gold font-bold" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-sm text-white/40 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @endif

      <!-- Metal / Variant Options -->
      <template x-if="variants.length">
        <div class="space-y-2">
          <div class="text-xs tracking-wider uppercase text-white font-semibold">Select Precious Metal:</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, idx) in variants" :key="v.id">
              <button type="button" @click="variantIdx = idx" class="px-4 py-2 text-xs border uppercase tracking-wider transition-colors" :class="variantIdx === idx ? 'border-aurum-gold bg-aurum-gold/15 text-white font-semibold' : 'border-aurum-border text-aurum-goldLight/70 hover:border-aurum-gold/50'">
                <span x-text="v.name"></span>
              </button>
            </template>
          </div>
        </div>
      </template>

      <!-- Description / Note -->
      @if(!empty($product['note']))
        <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed">
          {{ $product['note'] }}
        </p>
      @endif

      <!-- Quantity and Add to Bag -->
      <div class="space-y-3 pt-2">
        <div class="flex items-center gap-3">
          <div class="flex items-center border border-aurum-border bg-[#141210]">
            <button type="button" @click="if(qty > 1) qty--" class="px-3.5 py-3 text-aurum-goldLight hover:text-aurum-gold text-xs">-</button>
            <span class="px-4 text-xs text-white font-medium" x-text="qty"></span>
            <button type="button" @click="qty++" class="px-3.5 py-3 text-aurum-goldLight hover:text-aurum-gold text-xs">+</button>
          </div>

          <button type="button"
                  class="js-add-to-cart flex-1 py-3 px-6 bg-aurum-gold hover:bg-[#E5C158] text-aurum-black font-semibold text-xs tracking-[0.2em] uppercase transition-colors text-center disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  data-price="{{ number_format($product['final_price'], 2, '.', '') }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  :data-qty="qty"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'PRE-ORDER NOW' : 'ADD TO SHOPPING BAG' }}
          </button>
        </div>

        <a href="#boutique-section" class="block w-full py-2.5 text-center border border-aurum-gold/40 text-aurum-gold text-xs tracking-wider uppercase font-medium hover:bg-aurum-gold/10 transition-colors">
          BOOK BOUTIQUE VIEWING
        </a>
      </div>

      <!-- Trust Badges -->
      <div class="pt-6 border-t border-aurum-border/60 grid grid-cols-2 gap-4 text-xs text-aurum-goldLight/70 font-light">
        <div class="flex items-center gap-2">
          <span>💎</span>
          <span>Certified Natural Diamonds</span>
        </div>
        <div class="flex items-center gap-2">
          <span>📦</span>
          <span>Complimentary Insured Shipping</span>
        </div>
        <div class="flex items-center gap-2">
          <span>✨</span>
          <span>Lifetime Polish &amp; Care</span>
        </div>
        <div class="flex items-center gap-2">
          <span>🔄</span>
          <span>30-Day Maison Returns</span>
        </div>
      </div>

    </div>

  </div>

</main>

@include('store.themes.aurumeclat.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
