<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.elegance._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'Elegance')])
</head>
<body class="bg-brand-cream text-brand-charcoal antialiased">

@include('store.themes.elegance.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-7xl mx-auto px-6 py-4 text-xs text-brand-charcoalSoft flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-brand-gold">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-brand-gold">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-brand-gold">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-brand-charcoal">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-8 grid lg:grid-cols-2 gap-16"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="aspect-[4/5] overflow-hidden bg-brand-paper flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-serif" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-3 mt-4">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden border" :class="activeImg === i ? 'border-brand-gold' : 'border-brand-hairline'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="eyebrow text-xs font-semibold text-brand-gold">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="font-serif text-3xl lg:text-4xl mt-2 text-brand-charcoal">{{ $product['name'] }}</h1>
      <div class="text-xs text-brand-charcoalSoft mt-2">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-5">
        <div class="flex gap-0.5 text-brand-gold">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-brand-charcoalSoft">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-6 pt-6 border-t el-hairline">
          <span class="text-3xl font-serif text-brand-charcoal" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-serif text-brand-charcoal" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-brand-charcoalSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-6 pt-6 border-t el-hairline text-brand-gold font-semibold underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-6">
          <div class="text-[11px] eyebrow font-bold text-brand-gold mb-3">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border text-sm font-medium"
                      :class="variantIdx === i ? 'border-brand-charcoal bg-brand-charcoal text-brand-cream' : 'border-brand-hairline text-brand-charcoalSoft'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-6 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-1.5 h-1.5 rounded-full bg-brand-gold"></span><span class="text-brand-charcoal font-medium">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-1.5 h-1.5 rounded-full bg-brand-gold"></span><span class="text-brand-charcoal font-medium">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-1.5 h-1.5 rounded-full bg-brand-charcoalSoft"></span><span class="text-brand-charcoal font-medium">Available for pre-order</span>
        @else
          <span class="w-1.5 h-1.5 rounded-full bg-brand-charcoalSoft"></span><span class="text-brand-charcoalSoft font-medium">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-8 flex gap-3">
          <div class="flex items-center border border-brand-hairline h-12">
            <button type="button" class="w-10 h-full text-brand-charcoalSoft" onclick="const i=document.getElementById('el-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="el-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-brand-hairline bg-transparent">
            <button type="button" class="w-10 h-full text-brand-charcoalSoft" onclick="const i=document.getElementById('el-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 bg-brand-charcoal text-brand-cream text-xs eyebrow font-semibold hover:bg-brand-gold disabled:opacity-40 transition-colors"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('el-qty') ? document.getElementById('el-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-brand-charcoalSoft mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-8 flex items-center gap-2 text-sm text-brand-charcoalSoft">
          <svg class="w-5 h-5 text-brand-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t el-hairline">
          <h3 class="text-[11px] eyebrow font-bold text-brand-gold mb-3">Description</h3>
          <p class="text-sm text-brand-charcoalSoft leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t el-hairline grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-brand-charcoalSoft"><svg class="w-5 h-5 text-brand-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-brand-charcoalSoft"><svg class="w-5 h-5 text-brand-gold" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-7xl mx-auto px-6 py-16 border-t el-hairline">
      <h2 class="font-serif text-2xl italic text-brand-charcoal mb-10">You may also like</h2>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
        @foreach($related as $rp)
          @include('store.themes.elegance.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.elegance.partials.footer', ['categories' => $categories])
@include('store.themes.elegance.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
