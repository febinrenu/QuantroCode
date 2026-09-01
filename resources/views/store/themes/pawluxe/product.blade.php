<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.pawluxe._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'PawLuxe')])
</head>
<body class="bg-pl-cream text-pl-ink antialiased">

@include('store.themes.pawluxe.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-[1360px] mx-auto px-5 py-3 text-xs text-pl-mute flex items-center justify-center gap-2">
    <a href="{{ route('store.index') }}" class="hover:text-pl-coral">Home</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-pl-coral">Shop</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id ?? ($product['category_id'] ?? null)]) }}" class="hover:text-pl-coral">{{ $product['category_name'] }}</a>
    @endif
    / <span class="text-pl-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-[1360px] mx-auto px-5 py-6 grid lg:grid-cols-2 gap-12"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

    {{-- Gallery --}}
    <div>
      <div class="aspect-square rounded-2xl overflow-hidden bg-white border border-pl-line flex items-center justify-center">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-6xl font-display font-bold" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
        </template>
      </div>
      @if(count($gallery) > 1)
        <div class="flex gap-2 mt-3 justify-center">
          <template x-for="(img, i) in gallery" :key="i">
            <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-lg overflow-hidden border-2" :class="activeImg === i ? 'border-pl-coral' : 'border-pl-line'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      @if($product['brand_name'])
        <span class="text-xs eyebrow font-bold text-pl-teal">{{ $product['brand_name'] }}</span>
      @endif
      <h1 class="text-3xl lg:text-4xl font-display font-bold text-pl-ink mt-1">{{ $product['name'] }}</h1>
      <div class="text-xs text-pl-mute mt-1">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-pl-coral">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-pl-mute">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="text-3xl font-bold text-pl-teal" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="text-3xl font-bold text-pl-teal" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="text-base text-pl-mute line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-pl-teal font-bold underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-[11px] eyebrow font-bold text-pl-teal mb-2">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 border rounded-lg text-sm font-bold"
                      :class="variantIdx === i ? 'border-pl-teal bg-pl-teal text-white' : 'border-pl-line text-pl-ink'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-pl-teal"></span><span class="text-pl-teal font-medium">In stock</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-pl-coral"></span><span class="text-pl-coral font-medium">Low stock — {{ $product['stock'] }} left</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-pl-teal"></span><span class="text-pl-teal font-medium">Available for pre-order</span>
        @else
          <span class="w-2 h-2 rounded-full bg-pl-mute"></span><span class="text-pl-mute font-medium">Sold out</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border border-pl-line rounded-lg h-12">
            <button type="button" class="w-10 h-full text-pl-mute" onclick="const i=document.getElementById('pl-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="pl-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-pl-line">
            <button type="button" class="w-10 h-full text-pl-mute" onclick="const i=document.getElementById('pl-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 bg-pl-coral text-white font-bold text-sm rounded-lg hover:brightness-95 disabled:opacity-40"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('pl-qty') ? document.getElementById('pl-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-pl-mute mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-pl-mute">
          <svg class="w-5 h-5 text-pl-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t border-pl-line">
          <h3 class="text-[11px] eyebrow font-bold text-pl-teal mb-2">Description</h3>
          <p class="text-sm text-pl-mute leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t border-pl-line grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-pl-mute"><svg class="w-5 h-5 text-pl-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 3h15v13H1zM16 8h4l3 5v3h-7z"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17.5" cy="18.5" r="1.5"/></svg>Free shipping over $59</div>
        <div class="flex items-center gap-2 text-pl-mute"><svg class="w-5 h-5 text-pl-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-[1360px] mx-auto px-5 py-12 border-t border-pl-line text-center">
      <h2 class="text-2xl font-display font-bold text-pl-ink mb-8">You May Also Like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 text-left">
        @foreach($related as $rp)
          @include('store.themes.pawluxe.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.pawluxe.partials.footer', ['categories' => $categories])
@include('store.themes.pawluxe.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
