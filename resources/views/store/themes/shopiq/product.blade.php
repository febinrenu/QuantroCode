<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.shopiq._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'ShopIQ')])
</head>
<body class="bg-brand-bg text-brand-ink antialiased">

@include('store.themes.shopiq.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }

  if (!empty($product['is_on_sale'])) {
      $iqPdpBadge = ['label' => 'Best Value', 'classes' => 'bg-brand-amber text-white'];
  } elseif (!empty($product['is_featured'])) {
      $iqPdpBadge = ['label' => 'Staff Pick', 'classes' => 'bg-brand-teal text-white'];
  } else {
      $iqPdpBadge = ['label' => 'Trending', 'classes' => 'bg-brand-violet text-white'];
  }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-slate-400 flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-brand-teal">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-brand-teal">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-brand-teal">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-slate-600">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-10"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    {{-- Gallery --}}
    <div>
      <div class="relative aspect-square rounded-2xl overflow-hidden bg-white border border-brand-line flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-black" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
        <span class="iq-badge absolute top-3 left-3 {{ $iqPdpBadge['classes'] }} text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full inline-flex items-center gap-1">
          <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
          {{ $iqPdpBadge['label'] }}
        </span>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-lg overflow-hidden border-2" :class="activeImg === i ? 'border-brand-teal' : 'border-brand-line'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs font-semibold text-brand-teal uppercase">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-2xl lg:text-3xl font-black text-brand-navy mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-slate-400 mt-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-brand-amber">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-slate-400">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-black text-brand-navy" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-black text-brand-navy" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-slate-400 line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
        @if($product['is_on_sale'])
          <div class="mt-1.5 inline-flex items-center gap-1.5 text-xs font-semibold text-brand-tealDark bg-brand-tealLight px-2 py-1 rounded-full">
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3v18h18"/><path d="m7 14 4-4 3 3 5-6"/></svg>
            Our price analysis flags this as a Best Value pick right now
          </div>
        @endif
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-brand-teal font-semibold underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold uppercase text-slate-500 mb-2">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 rounded-lg border text-sm font-semibold"
                      :class="variantIdx === i ? 'border-brand-teal bg-brand-tealLight text-brand-tealDark' : 'border-brand-line text-slate-600'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-brand-teal"></span><span class="text-brand-tealDark font-medium">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-brand-amber"></span><span class="text-brand-amber font-medium">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-brand-navy"></span><span class="text-brand-navy font-medium">Available for pre-order</span>
        @else
          <span class="w-2 h-2 rounded-full bg-slate-400"></span><span class="text-slate-400 font-medium">Out of stock</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-brand-line rounded-lg h-12">
            <button type="button" class="w-10 h-full text-slate-500" onclick="const i=document.getElementById('iq-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="iq-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-brand-line">
            <button type="button" class="w-10 h-full text-slate-500" onclick="const i=document.getElementById('iq-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 rounded-lg bg-brand-teal text-white font-bold hover:bg-brand-tealDark disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('iq-qty') ? document.getElementById('iq-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-slate-400 mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-slate-600">
          <svg class="w-5 h-5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-brand-line">
          <h3 class="text-sm font-bold uppercase text-slate-500 mb-2">Description</h3>
          <p class="text-sm text-slate-600 leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-brand-line grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-slate-600"><svg class="w-5 h-5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-slate-600"><svg class="w-5 h-5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-10 border-t border-brand-line">
      <h2 class="text-xl font-black text-brand-navy mb-5 flex items-center gap-2">
        <svg class="w-5 h-5 text-brand-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>
        Compare with similar picks
      </h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $iqI => $rp)
          @include('store.themes.shopiq.partials.product-card', ['product' => $rp, 'idx' => $iqI])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.shopiq.partials.footer', ['categories' => $categories])
@include('store.themes.shopiq.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
