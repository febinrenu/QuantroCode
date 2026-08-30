<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.technova._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'Technova')])
</head>
<body class="bg-tn-bg text-tn-ink antialiased">
<div class="tn-scanlines"></div>

@include('store.themes.technova.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-tn-mute flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-tn-green">~</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-tn-green">shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-tn-green">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-tn-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-10"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="tn-window aspect-square overflow-hidden flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-bold" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden border-2" :class="activeImg === i ? 'border-tn-green' : 'border-tn-border'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs font-semibold text-tn-amber uppercase tn-bracket">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-2xl lg:text-3xl font-bold text-tn-ink mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-tn-mute mt-1">sku: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-tn-amber">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-tn-mute">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-bold text-tn-green" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-bold text-tn-green" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-tn-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-tn-green font-semibold underline">sign_in --to-see-pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold uppercase text-tn-green mb-2 tn-bracket">options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border text-sm font-semibold"
                      :class="variantIdx === i ? 'border-tn-green bg-tn-green text-black' : 'border-tn-border text-tn-mute'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 bg-tn-green"></span><span class="text-tn-green font-medium">[in_stock]</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 bg-tn-amber"></span><span class="text-tn-amber font-medium">[low_stock: {{ $product['stock'] }} left]</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 bg-tn-green"></span><span class="text-tn-green font-medium">[available_for_preorder]</span>
        @else
          <span class="w-2 h-2 bg-tn-mute"></span><span class="text-tn-mute font-medium">[out_of_stock]</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-tn-border h-12">
            <button type="button" class="w-10 h-full text-tn-mute hover:text-tn-green" onclick="const i=document.getElementById('tn-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="tn-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-tn-border bg-black text-tn-ink">
            <button type="button" class="w-10 h-full text-tn-mute hover:text-tn-green" onclick="const i=document.getElementById('tn-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart tn-glow-btn product-card flex-1 h-12 border border-tn-green bg-tn-green text-black font-bold disabled:opacity-30"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('tn-qty') ? document.getElementById('tn-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'pre-order_now' : 'add_to_cart --confirm' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-tn-mute mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-tn-mute">
          <svg class="w-5 h-5 text-tn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-tn-border">
          <h3 class="text-sm font-bold uppercase text-tn-green mb-2 tn-bracket">description</h3>
          <p class="text-sm text-tn-mute leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-tn-border grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-tn-mute"><svg class="w-5 h-5 text-tn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>free delivery over $99</div>
        <div class="flex items-center gap-2 text-tn-mute"><svg class="w-5 h-5 text-tn-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-10 border-t border-tn-border">
      <h2 class="text-xl font-bold text-tn-ink mb-5 tn-bracket">related --products</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $rp)
          @include('store.themes.technova.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.technova.partials.footer', ['categories' => $categories])
@include('store.themes.technova.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
