<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.crystalglass._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'CrystalGlass')])
</head>
<body class="text-brand-ink antialiased">
<div class="cg-mesh"><div class="cg-blob cg-blob-1"></div><div class="cg-blob cg-blob-2"></div><div class="cg-blob cg-blob-3"></div></div>

@include('store.themes.crystalglass.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0 relative z-10">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-brand-ink/40 tracking-wide flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-brand-violetDark">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-brand-violetDark">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-brand-violetDark">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-brand-ink/70">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-10"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    <div>
      <div class="aspect-square rounded-3xl overflow-hidden glass-strong shadow-glass flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-black" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-2xl overflow-hidden border-2" :class="activeImg === i ? 'border-brand-violet' : 'border-white/40'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    <div class="glass-strong rounded-3xl p-6 lg:p-8 shadow-glass">
      @if($product['brand_name'])
        <span class="text-xs font-semibold text-brand-violetDark uppercase tracking-widest">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-2xl lg:text-3xl font-black text-brand-ink mt-1 tracking-tight">{{ $product['name'] }}</h1>
      <div class="text-xs text-brand-ink/40 mt-1 tracking-wide">SKU: {{ $product['sku'] }}</div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-black text-brand-ink" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-black text-brand-ink" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-brand-ink/40 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-brand-violetDark font-semibold underline tracking-wide">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold uppercase tracking-widest text-brand-ink/40 mb-2">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 rounded-full border text-sm font-semibold tracking-wide"
                      :class="variantIdx === i ? 'border-brand-violet bg-gradient-to-r from-brand-violet to-brand-pink text-white' : 'border-white/50 bg-white/50 text-brand-ink/70'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm tracking-wide">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-green-400"></span><span class="text-green-600 font-medium">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-amber-400"></span><span class="text-amber-600 font-medium">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-brand-violet"></span><span class="text-brand-violetDark font-medium">Available for pre-order</span>
        @else
          <span class="w-2 h-2 rounded-full bg-slate-300"></span><span class="text-brand-ink/40 font-medium">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-white/60 bg-white/50 rounded-full h-12">
            <button type="button" class="w-10 h-full text-brand-ink/60" onclick="const i=document.getElementById('cg-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="cg-qty" type="number" value="1" min="1" class="w-12 text-center h-full bg-transparent">
            <button type="button" class="w-10 h-full text-brand-ink/60" onclick="const i=document.getElementById('cg-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 rounded-full bg-gradient-to-r from-brand-violet to-brand-pink text-white font-bold tracking-wide hover:brightness-105 disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('cg-qty') ? document.getElementById('cg-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-brand-ink/40 mt-2 tracking-wide"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-brand-ink/70 tracking-wide">
          <svg class="w-5 h-5 text-brand-violetDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-white/50">
          <h3 class="text-sm font-bold uppercase tracking-widest text-brand-ink/40 mb-2">Description</h3>
          <p class="text-sm text-brand-ink/70 leading-relaxed tracking-wide">{{ $product['description'] }}</p>
        </div>
      @endif
    </div>
  </div>

  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-10 border-t border-white/30">
      <h2 class="text-xl font-black text-brand-ink mb-5 tracking-tight">You may also like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $rp)
          @include('store.themes.crystalglass.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.crystalglass.partials.footer', ['categories' => $categories])
@include('store.themes.crystalglass.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
