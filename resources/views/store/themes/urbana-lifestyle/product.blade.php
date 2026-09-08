<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.urbana-lifestyle._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'Urbana')])
</head>
<body class="bg-urb-cream text-urb-ink antialiased">

@include('store.themes.urbana-lifestyle.partials.header', ['categories' => $categories])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 md:pb-0">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-urb-inkSoft flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-urb-green">{{ __('messages.Home') }}</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-urb-green">{{ __('messages.Shop') }}</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-urb-green">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-urb-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-12"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    <div>
      <div class="aspect-square overflow-hidden bg-white border border-urb-ink/10 flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-serif font-bold" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden border-2" :class="activeImg === i ? 'border-urb-green' : 'border-urb-ink/10'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    <div>
      @if($product['brand_name'])
        <span class="text-xs font-bold eyebrow text-urb-green">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="font-serif text-3xl lg:text-4xl text-urb-ink mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-urb-inkSoft mt-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-urb-gold">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-urb-inkSoft">({{ 'based on verified purchases' }})</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-bold text-urb-ink" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-bold text-urb-ink" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-urb-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-urb-green font-semibold underline">{{ 'Sign in to see pricing' }}</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold eyebrow text-urb-inkSoft mb-2">{{ 'Options' }}</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border text-sm font-semibold"
                      :class="variantIdx === i ? 'border-urb-green bg-urb-green text-white' : 'border-urb-ink/20 text-urb-ink'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-urb-green"></span><span class="text-urb-green font-medium">{{ __('messages.InStock') ?? 'In stock' }}</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-urb-gold"></span><span class="text-urb-gold font-medium">{{ 'Low stock' }} — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-urb-green"></span><span class="text-urb-green font-medium">{{ 'Available for pre-order' }}</span>
        @else
          <span class="w-2 h-2 rounded-full bg-urb-inkSoft/50"></span><span class="text-urb-inkSoft font-medium">{{ __('messages.OutOfStock') ?? 'Out of stock' }}</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-urb-ink/20 h-12">
            <button type="button" class="w-10 h-full text-urb-inkSoft" onclick="const i=document.getElementById('urb-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">&minus;</button>
            <input id="urb-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-urb-ink/20">
            <button type="button" class="w-10 h-full text-urb-inkSoft" onclick="const i=document.getElementById('urb-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 bg-urb-green text-white text-xs font-bold eyebrow hover:bg-urb-greenDeep disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('urb-qty') ? document.getElementById('urb-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : __('messages.AddToCart') }}
          </button>
        </div>
        <div class="js-add-status text-xs text-urb-inkSoft mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-urb-inkSoft">
          <svg class="w-5 h-5 text-urb-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-urb-ink/10">
          <h3 class="text-xs font-bold eyebrow text-urb-inkSoft mb-2">{{ __('messages.Description') ?? 'Description' }}</h3>
          <p class="text-sm text-urb-inkSoft leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-urb-ink/10 grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-urb-inkSoft"><svg class="w-5 h-5 text-urb-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>{{ 'Free delivery over $75' }}</div>
        <div class="flex items-center gap-2 text-urb-inkSoft"><svg class="w-5 h-5 text-urb-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>{{ '30-day easy returns' }}</div>
      </div>
    </div>
  </div>

  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-12 border-t border-urb-ink/10">
      <h2 class="font-serif text-2xl text-urb-ink mb-6">{{ __('messages.YouMayAlsoLike') ?? 'You May Also Like' }}</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-x-4 gap-y-6">
        @foreach($related as $rp)
          @include('store.themes.urbana-lifestyle.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.urbana-lifestyle.partials.footer', ['categories' => $categories])
@include('store.themes.urbana-lifestyle.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
