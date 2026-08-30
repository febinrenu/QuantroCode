<!doctype html>
<html lang="en">
<head>
@include('store.themes.terraco._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'Terraco')])
</head>
<body class="bg-terra-bg text-terra-ink antialiased">

@include('store.themes.terraco.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-6xl mx-auto px-6 py-5 text-xs text-terra-inkSoft flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-terra-slate">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-terra-slate">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-terra-slate">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-terra-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-6xl mx-auto px-6 py-8 grid lg:grid-cols-2 gap-16"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="aspect-square border border-terra-line bg-terra-surface flex items-center justify-center overflow-hidden">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-heading font-light" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden border" :class="activeImg === i ? 'border-terra-slate' : 'border-terra-line'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs eyebrow text-terra-slate">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="font-heading font-light text-4xl lg:text-5xl text-terra-ink mt-2 leading-tight">{{ $product['name'] }}</h1>
      <div class="text-xs text-terra-inkSoft mt-3">SKU: {{ $product['sku'] }}</div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-3 mt-6">
          <span class="text-3xl font-light font-heading text-terra-ink" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-light font-heading text-terra-ink" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-terra-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-6 text-terra-slate font-medium underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-7">
          <div class="text-xs eyebrow text-terra-inkSoft mb-3">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border text-sm"
                      :class="variantIdx === i ? 'border-terra-slate text-terra-slate' : 'border-terra-line text-terra-inkSoft'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-6 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-1.5 h-1.5 rounded-full bg-terra-slate"></span><span class="text-terra-slate">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-1.5 h-1.5 rounded-full bg-terra-rust"></span><span class="text-terra-rust">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-1.5 h-1.5 rounded-full bg-terra-ink"></span><span class="text-terra-ink">Available for pre-order</span>
        @else
          <span class="w-1.5 h-1.5 rounded-full bg-terra-inkSoft"></span><span class="text-terra-inkSoft">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-8 flex gap-3">
          <div class="flex items-center border border-terra-line h-12">
            <button type="button" class="w-10 h-full text-terra-inkSoft" onclick="const i=document.getElementById('tr-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="tr-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-terra-line bg-transparent">
            <button type="button" class="w-10 h-full text-terra-inkSoft" onclick="const i=document.getElementById('tr-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 border border-terra-slate bg-terra-slate text-white font-medium tracking-wide hover:bg-terra-slateDark disabled:opacity-30"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('tr-qty') ? document.getElementById('tr-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'PRE-ORDER NOW' : 'ADD TO CART' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-terra-inkSoft mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-8 flex items-center gap-2 text-sm text-terra-inkSoft">
          <svg class="w-5 h-5 text-terra-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-10 pt-8 border-t border-terra-line">
          <h3 class="text-xs eyebrow text-terra-inkSoft mb-3">Description</h3>
          <p class="text-sm text-terra-inkSoft leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-8 pt-8 border-t border-terra-line grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-terra-inkSoft"><svg class="w-5 h-5 text-terra-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-terra-inkSoft"><svg class="w-5 h-5 text-terra-slate" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-6xl mx-auto px-6 py-16 border-t border-terra-line">
      <h2 class="font-heading font-light text-2xl text-terra-ink mb-8">You may also like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($related as $rp)
          @include('store.themes.terraco.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.terraco.partials.footer', ['categories' => $categories])
@include('store.themes.terraco.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
