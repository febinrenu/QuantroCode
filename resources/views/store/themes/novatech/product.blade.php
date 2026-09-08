<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.novatech._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'NovaTech')])
</head>
<body class="bg-nova-bg text-slate-100 antialiased bg-nova-radial bg-no-repeat">

@include('store.themes.novatech.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-slate-500 flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-nova-violetLight">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-nova-violetLight">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-nova-violetLight">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-slate-300">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-10"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="aspect-square rounded-2xl overflow-hidden nt-glass flex items-center justify-center">
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
            <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-lg overflow-hidden border-2" :class="activeImg === i ? 'border-nova-violet' : 'border-white/10'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs font-semibold text-nova-violetLight uppercase">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-2xl lg:text-3xl font-black text-white mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-slate-500 mt-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-nova-amber">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-slate-500">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-black text-white" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-black text-white" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-slate-500 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-nova-violetLight font-semibold underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold uppercase text-slate-400 mb-2">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 rounded-full border text-sm font-semibold"
                      :class="variantIdx === i ? 'border-nova-violet bg-nova-violet/20 text-nova-violetLight' : 'border-white/10 text-slate-300'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-nova-cyan"></span><span class="text-nova-cyan font-medium">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-nova-amber"></span><span class="text-nova-amber font-medium">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-nova-violet"></span><span class="text-nova-violetLight font-medium">Available for pre-order</span>
        @else
          <span class="w-2 h-2 rounded-full bg-slate-600"></span><span class="text-slate-500 font-medium">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center nt-glass rounded-full h-12">
            <button type="button" class="w-10 h-full text-slate-300" onclick="const i=document.getElementById('nv-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="nv-qty" type="number" value="1" min="1" class="w-12 text-center h-full bg-transparent border-x border-white/10 text-white">
            <button type="button" class="w-10 h-full text-slate-300" onclick="const i=document.getElementById('nv-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 rounded-full bg-nova-violet text-white font-bold hover:bg-nova-violetDark hover:shadow-glow disabled:opacity-40 transition-all"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('nv-qty') ? document.getElementById('nv-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-slate-500 mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-slate-300">
          <svg class="w-5 h-5 text-nova-cyan" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-white/10">
          <h3 class="text-sm font-bold uppercase text-slate-400 mb-2">Description</h3>
          <p class="text-sm text-slate-300 leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-white/10 grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-slate-300"><svg class="w-5 h-5 text-nova-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-slate-300"><svg class="w-5 h-5 text-nova-violet" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-10 border-t border-white/10">
      <h2 class="text-xl font-black text-white mb-5">You may also like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $rp)
          @include('store.themes.novatech.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.novatech.partials.footer', ['categories' => $categories])
@include('store.themes.novatech.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
