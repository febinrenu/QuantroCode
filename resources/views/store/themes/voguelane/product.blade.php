<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.voguelane._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'Voguelane')])
</head>
<body class="bg-white text-black antialiased">

@include('store.themes.voguelane.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="px-4 lg:px-8 py-3 text-xs font-semibold text-black/40 flex items-center gap-2 uppercase tracking-wide">
    <a href="{{ route('store.index') }}" class="hover:text-brand-magenta">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-brand-magenta">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-brand-magenta">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-black">{{ $product['name'] }}</span>
  </div>

  <div class="grid lg:grid-cols-2 gap-0 lg:gap-0"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    {{-- Gallery --}}
    <div class="px-4 lg:px-8">
      <div class="aspect-[4/5] overflow-hidden bg-brand-paper flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-7xl font-display" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-20 overflow-hidden border-2" :class="activeImg === i ? 'border-brand-magenta' : 'border-black/10'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div class="px-4 lg:px-8 py-8 lg:py-0">
      @if($product['brand_name'])
        <span class="text-xs font-bold text-brand-magenta uppercase tracking-widest">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="font-display text-5xl lg:text-6xl text-black mt-1 leading-[0.95]">{{ strtoupper($product['name']) }}</h1>
      <div class="text-xs text-black/40 mt-2 uppercase tracking-wide">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-5">
        <div class="flex gap-0.5 text-black">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-black/40">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-5">
          <span class="text-4xl font-display text-black" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-4xl font-display text-black" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-black/35 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-5 text-brand-magenta font-bold underline uppercase text-sm">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-6">
          <div class="text-xs font-bold uppercase tracking-widest text-black/50 mb-2">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border text-sm font-bold uppercase tracking-wide"
                      :class="variantIdx === i ? 'border-brand-magenta bg-brand-magenta text-white' : 'border-black text-black'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-5 flex items-center gap-2 text-sm font-bold uppercase tracking-wide">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-black"></span><span class="text-black">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-brand-magenta"></span><span class="text-brand-magenta">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-black"></span><span class="text-black">Available for pre-order</span>
        @else
          <span class="w-2 h-2 rounded-full bg-black/30"></span><span class="text-black/40">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-7 flex gap-3">
          <div class="flex items-center border border-black h-12">
            <button type="button" class="w-10 h-full text-black" onclick="const i=document.getElementById('vl-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="vl-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-black">
            <button type="button" class="w-10 h-full text-black" onclick="const i=document.getElementById('vl-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 bg-black text-white font-bold uppercase tracking-wide hover:bg-brand-magenta disabled:opacity-30 transition-colors"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('vl-qty') ? document.getElementById('vl-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-black/40 mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-7 flex items-center gap-2 text-sm font-semibold text-black/70">
          <svg class="w-5 h-5 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-black/10">
          <h3 class="text-xs font-bold uppercase tracking-widest text-black/50 mb-2">Description</h3>
          <p class="text-sm text-black/70 leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-black/10 grid grid-cols-2 gap-4 text-sm font-semibold">
        <div class="flex items-center gap-2 text-black/70"><svg class="w-5 h-5 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-black/70"><svg class="w-5 h-5 text-brand-magenta" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="px-4 lg:px-8 py-10 border-t border-black/10 mt-6">
      <h2 class="font-display text-3xl text-black mb-5">YOU MAY ALSO LIKE</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($related as $rp)
          @include('store.themes.voguelane.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.voguelane.partials.footer', ['categories' => $categories])
@include('store.themes.voguelane.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
