<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.medisphere-care._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'MediSphere')])
</head>
<body class="bg-ms-cream text-ms-ink antialiased">

@include('store.themes.medisphere-care.partials.header', ['categories' => $categories])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 md:pb-0">
  <div class="max-w-7xl mx-auto px-4 py-3 text-xs text-ms-inkSoft flex items-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-ms-teal">{{ __('messages.Home') }}</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-ms-teal">{{ __('messages.Shop') }}</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-ms-teal">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-ms-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 grid lg:grid-cols-2 gap-12"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    <div>
      <div class="aspect-square overflow-hidden bg-white border border-ms-teal/10 rounded-xl2 flex items-center justify-center p-6">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-contain" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-heading font-bold" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 overflow-hidden rounded border-2" :class="activeImg === i ? 'border-ms-teal' : 'border-ms-teal/15'">
              <img :src="img" class="w-full h-full object-contain">
            </button>
          </template>
        </div>
      @endif
    </div>

    <div>
      @if($product['brand_name'])
        <span class="text-xs font-bold text-ms-teal">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="font-heading text-3xl font-extrabold text-ms-ink mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-ms-inkSoft mt-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-ms-gold">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-ms-inkSoft">({{ 'based on verified purchases' }})</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-extrabold text-ms-ink" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-extrabold text-ms-ink" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-ms-inkSoft line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-ms-teal font-semibold underline">{{ 'Sign in to see pricing' }}</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold text-ms-inkSoft mb-2">{{ 'Options' }}</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 rounded border text-sm font-semibold"
                      :class="variantIdx === i ? 'border-ms-teal bg-ms-teal text-white' : 'border-ms-teal/25 text-ms-ink'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-ms-teal"></span><span class="text-ms-teal font-medium">{{ __('messages.InStock') ?? 'In stock' }}</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-ms-gold"></span><span class="text-ms-gold font-medium">{{ 'Low stock' }} — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-ms-teal"></span><span class="text-ms-teal font-medium">{{ 'Available for pre-order' }}</span>
        @else
          <span class="w-2 h-2 rounded-full bg-ms-inkSoft/50"></span><span class="text-ms-inkSoft font-medium">{{ __('messages.OutOfStock') ?? 'Out of stock' }}</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-ms-teal/25 rounded h-12">
            <button type="button" class="w-10 h-full text-ms-inkSoft" onclick="const i=document.getElementById('ms-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">&minus;</button>
            <input id="ms-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-ms-teal/25">
            <button type="button" class="w-10 h-full text-ms-inkSoft" onclick="const i=document.getElementById('ms-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 bg-ms-teal text-white text-xs font-bold rounded hover:bg-ms-tealDeep disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('ms-qty') ? document.getElementById('ms-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : __('messages.AddToCart') }}
          </button>
        </div>
        <div class="js-add-status text-xs text-ms-inkSoft mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-ms-inkSoft">
          <svg class="w-5 h-5 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-ms-teal/15">
          <h3 class="text-xs font-bold text-ms-inkSoft mb-2">{{ __('messages.Description') ?? 'Description' }}</h3>
          <p class="text-sm text-ms-inkSoft leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-ms-teal/15 grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-ms-inkSoft"><svg class="w-5 h-5 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 1 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>{{ '100% genuine, licensed pharmacy' }}</div>
        <div class="flex items-center gap-2 text-ms-inkSoft"><svg class="w-5 h-5 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>{{ 'Easy returns & refunds' }}</div>
      </div>
    </div>
  </div>

  @if(count($related))
    <section class="max-w-7xl mx-auto px-4 py-12 border-t border-ms-teal/10">
      <h2 class="font-heading text-xl font-extrabold text-ms-ink mb-6">{{ __('messages.YouMayAlsoLike') ?? 'You May Also Like' }}</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($related as $rp)
          @include('store.themes.medisphere-care.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.medisphere-care.partials.footer', ['categories' => $categories])
@include('store.themes.medisphere-care.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
