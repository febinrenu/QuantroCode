<!doctype html>
<html lang="en">
<head>
@include('store.themes.brutalex._shell', ['pageTitle' => strtoupper($product['name']) . ' — ' . ($s->store_name ?? 'BRUTALEX')])
</head>
<body class="bg-white text-ink-black antialiased">

@include('store.themes.brutalex.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-7xl mx-auto px-6 py-3 text-xs font-mono font-bold text-ink-black/50 flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-ink-red">HOME</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-ink-red">SHOP</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-ink-red">{{ strtoupper($product['category_name']) }}</a>
    @endif
    / <span class="text-ink-black">{{ strtoupper($product['name']) }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-6 grid lg:grid-cols-2 gap-10"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="aspect-square border-4 border-ink-black bx-shadow overflow-hidden flex items-center justify-center bg-ink-fog">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl bx-head" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden border-4" :class="activeImg === i ? 'border-ink-red' : 'border-ink-black'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs font-mono font-bold text-ink-red uppercase">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-2xl lg:text-4xl text-ink-black mt-1">{{ strtoupper($product['name']) }}</h1>
      <div class="text-xs font-mono font-bold text-ink-black/50 mt-2 border-2 border-ink-black inline-block px-2 py-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-5">
        <div class="flex gap-0.5 text-ink-red">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs font-mono text-ink-black/50">(verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-3 mt-5 font-mono">
          <span class="text-4xl font-bold text-ink-black" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-4xl font-bold text-ink-black" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-lg text-ink-black/40 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-5 text-ink-red font-bold uppercase underline text-sm">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-6">
          <div class="text-xs font-bold uppercase text-ink-black mb-2 border-b-2 border-ink-black pb-1 w-fit">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-11 px-4 border-4 text-sm font-mono font-bold uppercase"
                      :class="variantIdx === i ? 'border-ink-red bg-ink-red text-white' : 'border-ink-black text-ink-black'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-5 flex items-center gap-2 text-sm font-mono font-bold uppercase">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-3 h-3 bg-ink-black"></span><span class="text-ink-black">In Stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-3 h-3 bg-ink-red"></span><span class="text-ink-red">Low Stock — {{ $product['stock'] }} Left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-3 h-3 border-2 border-ink-black"></span><span class="text-ink-black">Available For Pre-Order</span>
        @else
          <span class="w-3 h-3 bg-ink-steel"></span><span class="text-ink-black/40">Out Of Stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-7 flex gap-3">
          <div class="flex items-center border-4 border-ink-black h-14">
            <button type="button" class="w-11 h-full text-ink-black font-bold text-lg" onclick="const i=document.getElementById('bx-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="bx-qty" type="number" value="1" min="1" class="w-14 text-center h-full border-x-4 border-ink-black font-mono font-bold">
            <button type="button" class="w-11 h-full text-ink-black font-bold text-lg" onclick="const i=document.getElementById('bx-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-14 bg-ink-black text-white font-bold uppercase border-4 border-ink-black bx-shadow-red bx-shadow-hover disabled:opacity-40 disabled:cursor-not-allowed"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('bx-qty') ? document.getElementById('bx-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add To Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs font-mono text-ink-black/50 mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm font-mono font-bold uppercase text-ink-black">
          <svg class="w-5 h-5 text-ink-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t-4 border-ink-black">
          <h3 class="text-sm font-bold uppercase text-ink-black mb-2">Description</h3>
          <p class="text-sm bx-copy text-ink-black/70 leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t-4 border-ink-black grid grid-cols-2 gap-4 text-sm font-mono font-bold">
        <div class="flex items-center gap-2 text-ink-black"><svg class="w-5 h-5 text-ink-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>FREE DELIVERY OVER $99</div>
        <div class="flex items-center gap-2 text-ink-black"><svg class="w-5 h-5 text-ink-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-DAY EASY RETURNS</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-7xl mx-auto px-6 py-10 border-t-4 border-ink-black">
      <h2 class="text-2xl text-ink-black mb-5">YOU MAY ALSO LIKE</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $rp)
          @include('store.themes.brutalex.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.brutalex.partials.footer', ['categories' => $categories])
@include('store.themes.brutalex.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
