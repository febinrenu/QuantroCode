<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => $product['name'] . ' — ' . ($s->store_name ?? 'AurumÉclat')])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#090807] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'aurumeclat');
  $aurumRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

@php
  $currency = $s->currency_code ?? '$';
  $slugName = \Illuminate\Support\Str::slug($product['name']);
  $imgSrc = $product['image_url'];
  if (!$imgSrc || str_contains($imgSrc, 'no-image.png')) {
      if (file_exists(public_path('images/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/products/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg');
      }
  }

  $gallery = array_values(array_filter(array_merge([$imgSrc], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [$imgSrc]; }
@endphp

<main class="pb-24">
  
  <!-- Breadcrumb -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-xs text-aurum-goldLight/60 font-light flex items-center gap-2 border-b border-aurum-border/40">
    <a href="{{ $aurumRoute('store.index') }}" class="hover:text-aurum-gold">Home</a> /
    <a href="{{ $aurumRoute('store.shop') }}" class="hover:text-aurum-gold">Fine Jewelry</a> /
    @if($product['category_name'])
      <a href="{{ $aurumRoute('store.shop', ['category' => $p->category_id ?? '']) }}" class="hover:text-aurum-gold">{{ $product['category_name'] }}</a> /
    @endif
    <span class="text-white font-normal">{{ $product['name'] }}</span>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 grid lg:grid-cols-12 gap-10 lg:gap-14"
       x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0, qty: 1 }'>

    <!-- Gallery Column (7 cols) -->
    <div class="lg:col-span-7 space-y-4">
      <div class="aspect-square bg-[#120F0C] border border-aurum-border overflow-hidden flex items-center justify-center p-6 relative">
        <template x-if="gallery[activeImg]">
          <img :src="gallery[activeImg]" class="w-full h-full object-contain" alt="{{ $product['name'] }}">
        </template>
        <template x-if="!gallery[activeImg]">
          <div class="text-7xl font-serif text-aurum-gold/30">✦</div>
        </template>

        <!-- Hallmark Badge -->
        <span class="absolute top-4 left-4 bg-[#1A1612] border border-aurum-gold/50 text-aurum-gold text-[10px] tracking-widest uppercase font-semibold px-3 py-1 shadow">
          IGI / GIA CERTIFIED
        </span>
      </div>

      <!-- Thumbnail Strip -->
      @if(count($gallery) > 1)
        <div class="flex items-center gap-3 overflow-x-auto pb-2">
          @foreach($gallery as $idx => $gUrl)
            <button type="button" 
                    @click="activeImg = {{ $idx }}" 
                    :class="activeImg === {{ $idx }} ? 'border-aurum-gold' : 'border-aurum-border opacity-60 hover:opacity-100'"
                    class="w-16 h-16 bg-[#120F0C] border p-1 shrink-0 transition-all">
              <img src="{{ $gUrl }}" class="w-full h-full object-cover" alt="Thumbnail {{ $idx + 1 }}">
            </button>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Details / Buy Box Column (5 cols) -->
    <div class="lg:col-span-5 space-y-6">
      
      <div>
        <div class="text-[11px] tracking-[0.2em] text-aurum-gold uppercase font-semibold">
          {{ $product['category_name'] ?? 'AURUMÉCLAT HIGH JEWELRY' }}
        </div>
        <h1 class="font-serif text-3xl sm:text-4xl text-white font-normal leading-tight mt-1.5">
          {{ $product['name'] }}
        </h1>
        <div class="text-xs text-aurum-goldLight/60 font-light mt-1">
          SKU: {{ $product['sku'] }}
        </div>
      </div>

      <!-- Rating & Reviews -->
      <div class="flex items-center gap-2 py-2 border-y border-aurum-border/60 text-xs">
        <span class="text-aurum-gold">★★★★★</span>
        <span class="text-white/80 font-medium">5.0</span>
        <span class="text-aurum-goldLight/40">•</span>
        <span class="text-aurum-goldLight/70 font-light">Certified Hallmark Guaranteed</span>
      </div>

      <!-- Price Box -->
      @if(!$product['hide_prices'])
        <div class="space-y-1">
          <div class="flex items-baseline gap-3">
            <span class="font-serif text-3xl sm:text-4xl font-semibold text-white">
              {{ $product['final_price_formatted'] }}
            </span>
            @if($product['compare_at_price_formatted'])
              <span class="text-sm text-aurum-goldLight/40 line-through font-light">
                {{ $product['compare_at_price_formatted'] }}
              </span>
              <span class="text-xs text-aurum-wine font-semibold uppercase">
                Save {{ $product['discount_percent'] }}%
              </span>
            @endif
          </div>
          <div class="text-[11px] text-aurum-goldLight/60 font-light">
            Price includes insured white-glove transport &amp; luxury presentation box.
          </div>
        </div>
      @endif

      <!-- Description -->
      <div class="text-xs sm:text-sm text-aurum-goldLight/80 font-light leading-relaxed space-y-3 pt-2">
        <p>{{ $product['description'] ?: 'Meticulously set in solid hallmarked precious metal with certified brilliant stones. Handcrafted by master artisans with heirloom-grade precision.' }}</p>
      </div>

      <!-- Metal Purity & Specifications -->
      <div class="bg-[#12100E] border border-aurum-border p-4 space-y-2 text-xs">
        <div class="flex justify-between py-1 border-b border-aurum-border/40">
          <span class="text-aurum-goldLight/60">Metal Authenticity</span>
          <span class="text-white font-medium">18K / 22K Solid Gold</span>
        </div>
        <div class="flex justify-between py-1 border-b border-aurum-border/40">
          <span class="text-aurum-goldLight/60">Gemstone Quality</span>
          <span class="text-white font-medium">VS-VVS Clarity • Colorless F-G</span>
        </div>
        <div class="flex justify-between py-1">
          <span class="text-aurum-goldLight/60">Service Inclusions</span>
          <span class="text-aurum-gold font-medium">Lifetime Complimentary Polish</span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="space-y-3 pt-2">
        <div class="flex items-center gap-3">
          
          <!-- Quantity -->
          <div class="flex items-center border border-aurum-border bg-[#141210] h-12">
            <button type="button" @click="if (qty > 1) qty--" class="w-10 h-full text-aurum-gold hover:text-white transition-colors">-</button>
            <span x-text="qty" class="w-10 text-center text-xs font-semibold text-white"></span>
            <button type="button" @click="qty++" class="w-10 h-full text-aurum-gold hover:text-white transition-colors">+</button>
          </div>

          <!-- Add to Bag Button -->
          <button type="button"
                  class="js-add-to-cart flex-1 h-12 bg-aurum-gold hover:bg-[#E5C158] text-aurum-black text-xs font-semibold tracking-[0.2em] uppercase transition-all duration-300 shadow-[0_4px_20px_rgba(212,175,55,0.25)] flex items-center justify-center"
                  data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                  data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                  data-id="{{ $product['id'] }}"
                  data-slug="{{ $product['slug'] }}"
                  data-name="{{ e($product['name']) }}"
                  data-price="{{ number_format($product['final_price'], 2, '.', '') }}"
                  data-image="{{ $imgSrc }}"
                  data-currency="{{ $product['currency'] }}"
                  :data-qty="qty"
                  data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                  data-added-label="{{ __('messages.Added') }}">
            {{ $product['is_preorder_active'] ? 'PRE-ORDER NOW' : 'ADD TO SHOPPING BAG' }}
          </button>
        </div>

        <a href="#boutique-section" class="block w-full py-2.5 text-center border border-aurum-gold/40 text-aurum-gold text-xs tracking-wider uppercase font-medium hover:bg-aurum-gold/10 transition-colors">
          BOOK BOUTIQUE VIEWING
        </a>
      </div>

      <!-- Trust Badges -->
      <div class="pt-5 border-t border-aurum-border/60 grid grid-cols-2 gap-3.5 text-xs text-aurum-goldLight/70 font-light">
        <div class="flex items-center gap-2">
          <span>💎</span>
          <span>Certified Natural Diamonds</span>
        </div>
        <div class="flex items-center gap-2">
          <span>📦</span>
          <span>Complimentary Insured Shipping</span>
        </div>
        <div class="flex items-center gap-2">
          <span>✨</span>
          <span>Lifetime Polish &amp; Care</span>
        </div>
        <div class="flex items-center gap-2">
          <span>🔄</span>
          <span>30-Day Maison Returns</span>
        </div>
      </div>

    </div>

  </div>

</main>

@include('store.themes.aurumeclat.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
