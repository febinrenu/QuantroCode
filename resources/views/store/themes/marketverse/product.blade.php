<!doctype html>
<html lang="en">
<head>
@include('store.themes.marketverse._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'MarketVerse')])
</head>
<body class="bg-mv-cream text-mv-ink antialiased">

@include('store.themes.marketverse.partials.header', ['categories' => $categories, 'showCategoryBar' => false])

@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? []) ));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<main class="pb-24 lg:pb-0">
  <div class="max-w-[1600px] mx-auto px-4 py-3 text-xs text-mv-slate flex items-center gap-2 mv-mono">
    <a href="{{ route('store.index') }}" class="hover:text-mv-accentDark">HOME</a> /
    <a href="{{ route('store.shop') }}" class="hover:text-mv-accentDark">SHOP</a>
    @if($product['category_name'])
      / <a href="{{ route('store.shop', ['category' => $p->category_id]) }}" class="hover:text-mv-accentDark">{{ strtoupper($product['category_name']) }}</a>
    @endif
    / <span class="text-mv-ink">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-[1600px] mx-auto px-4 py-6 grid lg:grid-cols-2 gap-10"
       x-data="{ variantIdx: 0, variants: @json($product['variants']), gallery: @json($gallery), activeImg: 0 }">

    {{-- Gallery --}}
    <div>
      <div class="aspect-square rounded-lg overflow-hidden bg-white border-2 border-mv-line flex items-center justify-center">
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
            <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-md overflow-hidden border-2" :class="activeImg === i ? 'border-mv-accent' : 'border-mv-line'">
              <img :src="img" class="w-full h-full object-cover">
            </button>
          </template>
        </div>
      @endif
    </div>

    {{-- Buy box --}}
    <div>
      <div class="flex items-center gap-2 flex-wrap">
        @if($product['brand_name'])
          <span class="bg-mv-ink text-mv-accentLight text-[10px] font-bold px-2 py-0.5 rounded mv-chip uppercase">{{ $product['brand_name'] }}</span>
        @endif
        @if($product['category_name'])
          <span class="bg-mv-accentSoft text-mv-accentDark text-[10px] font-bold px-2 py-0.5 rounded mv-chip uppercase">{{ $product['category_name'] }}</span>
        @endif
      </div>
      <h1 class="text-2xl lg:text-3xl font-black text-mv-ink mt-2">{{ $product['name'] }}</h1>
      <div class="text-xs text-mv-slate mt-1 mv-mono">SKU: {{ $product['sku'] }}</div>

      <div class="flex items-center gap-2 mt-4">
        <div class="flex gap-0.5 text-mv-accent">
          @for($i=0;$i<5;$i++)<svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14l-5-4.87 6.91-1.01z"/></svg>@endfor
        </div>
        <span class="text-xs text-mv-slate">(based on verified purchases)</span>
      </div>

      @if(!$product['hide_prices'])
        <div class="flex items-baseline gap-2 mt-4">
          <span class="mv-mono text-3xl font-black text-mv-ink" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
          <template x-if="variants.length">
            <span class="mv-mono text-3xl font-black text-mv-ink" x-text="variants[variantIdx].display_price_formatted"></span>
          </template>
          @if($product['compare_at_price_formatted'])
            <span class="mv-mono text-base text-mv-slate line-through">{{ $product['compare_at_price_formatted'] }}</span>
          @endif
          @if($product['is_on_sale'])
            <span class="bg-mv-accent text-white text-xs font-bold px-2 py-0.5 rounded mv-mono">-{{ $product['discount_percent'] }}%</span>
          @endif
        </div>
      @else
        <a href="{{ url('/online_store/login') }}" class="block mt-4 text-mv-accentDark font-bold underline">Sign in to see pricing</a>
      @endif

      @if(count($product['variants']))
        <div class="mt-5">
          <div class="text-xs font-bold uppercase text-mv-slate mb-2 mv-mono">Options</div>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, i) in variants" :key="v.id">
              <button type="button" @click="variantIdx = i"
                      class="h-10 px-4 rounded-md border-2 text-sm font-bold"
                      :class="variantIdx === i ? 'border-mv-accent bg-mv-accentSoft text-mv-accentDark' : 'border-mv-line text-mv-ink'"
                      x-text="v.name"></button>
            </template>
          </div>
        </div>
      @endif

      <div class="mt-4 flex items-center gap-2 text-sm">
        @if($product['stock_status'] === 'in_stock')
          <span class="w-2 h-2 rounded-full bg-green-600"></span><span class="text-green-700 font-bold mv-mono">IN STOCK</span>
        @elseif($product['stock_status'] === 'low_stock')
          <span class="w-2 h-2 rounded-full bg-amber-500"></span><span class="text-amber-700 font-bold mv-mono">LOW STOCK — {{ $product['stock'] }} LEFT</span>
        @elseif($product['stock_status'] === 'preorder')
          <span class="w-2 h-2 rounded-full bg-mv-accent"></span><span class="text-mv-accentDark font-bold mv-mono">AVAILABLE FOR PRE-ORDER</span>
        @else
          <span class="w-2 h-2 rounded-full bg-slate-400"></span><span class="text-slate-500 font-bold mv-mono">OUT OF STOCK</span>
        @endif
      </div>

      @if(!$product['hide_prices'])
        <div class="mt-6 flex gap-3">
          <div class="flex items-center border-2 border-mv-line rounded-md h-12">
            <button type="button" class="w-10 h-full text-mv-slate" onclick="const i=document.getElementById('mv-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
            <input id="mv-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x-2 border-mv-line mv-mono">
            <button type="button" class="w-10 h-full text-mv-slate" onclick="const i=document.getElementById('mv-qty'); i.value = parseInt(i.value||1)+1">+</button>
          </div>
          <button type="button"
                  class="js-add-to-cart product-card flex-1 h-12 rounded-md bg-mv-ink text-white font-bold hover:bg-mv-accentDark disabled:opacity-40 transition-colors"
                  @if(!$product['is_available']) disabled @endif
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                  data-image="{{ $product['image_url'] }}"
                  data-currency="{{ $product['currency'] }}"
                  x-bind:data-qty="document.getElementById('mv-qty') ? document.getElementById('mv-qty').value : 1"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'Pre-order Now' : 'Add to Cart' }}
          </button>
        </div>
        <div class="js-add-status text-xs text-mv-slate mt-2"></div>
      @endif

      @if($product['warranty_text'])
        <div class="mt-6 flex items-center gap-2 text-sm text-mv-ink">
          <svg class="w-5 h-5 text-mv-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
          {{ $product['warranty_text'] }}
        </div>
      @endif

      @if($product['description'])
        <div class="mt-8 pt-6 border-t-2 border-mv-line">
          <h3 class="text-sm font-bold uppercase text-mv-slate mb-2 mv-mono">Description</h3>
          <p class="text-sm text-mv-ink/80 leading-relaxed">{{ $product['description'] }}</p>
        </div>
      @endif

      <div class="mt-6 pt-6 border-t-2 border-mv-line grid grid-cols-2 gap-4 text-sm">
        <div class="flex items-center gap-2 text-mv-ink"><svg class="w-5 h-5 text-mv-accentDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 5v3h-7z"/></svg>Free delivery over $99</div>
        <div class="flex items-center gap-2 text-mv-ink"><svg class="w-5 h-5 text-mv-accentDark" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6-8.485"/><path d="M21 3v6h-6"/></svg>30-day easy returns</div>
      </div>

      @if($product['weight'])
        <div class="mt-4 text-xs text-mv-slate mv-mono">WEIGHT: {{ $product['weight'] }}</div>
      @endif
    </div>
  </div>

  {{-- Related products --}}
  @if(count($related))
    <section class="max-w-[1600px] mx-auto px-4 py-10 border-t-2 border-mv-line">
      <h2 class="text-xl font-black text-mv-ink mb-5">You may also like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-3">
        @foreach($related as $rp)
          @include('store.themes.marketverse.partials.product-card', ['product' => $rp])
        @endforeach
      </div>
    </section>
  @endif
</main>

@include('store.themes.marketverse.partials.footer', ['categories' => $categories])
@include('store.themes.marketverse.partials.mobile-nav')

<script src="{{ global_asset('js/storefront.min.js') }}" defer></script>
</body>
</html>
