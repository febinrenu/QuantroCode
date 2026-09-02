@extends('store.themes.paperloom._shell')

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $plRoute('store.shop');

  $prodObj = is_array($product) ? (object) $product : $product;
  $productId = $prodObj->id ?? ($p->id ?? 1);
  $title = $prodObj->name ?? ($p->name ?? 'Product Details');
  $price = (float) ($prodObj->final_price ?? ($prodObj->display_price ?? ($p->price ?? 0)));
  $priceFormatted = $prodObj->final_price_formatted ?? ($prodObj->display_price_formatted ?? ('$' . number_format($price, 2)));
  $comparePrice = $prodObj->compare_at_price_formatted ?? ($prodObj->base_price_formatted ?? null);
  $isOnSale = !empty($prodObj->is_on_sale) || ($comparePrice && $comparePrice !== $priceFormatted);
  $stockQty = $prodObj->stock ?? ($p->qte ?? 100);
  $imgSrc = $prodObj->image_url ?? ($p->image ? global_asset('images/products/' . $p->image) : global_asset('images/products/no-image.png'));

  // Related products
  $related = \App\Models\Product::where('code', 'like', 'PPL-%')
      ->where('id', '!=', $productId)
      ->take(4)
      ->get();
@endphp

@section('title', $title . ' — PaperLoom')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-14 sm:space-y-20">

  <!-- Breadcrumbs -->
  <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
    <a href="{{ $plRoute('store.index') }}" class="hover:text-pl-terracotta transition-colors">Home</a>
    <span>/</span>
    <a href="{{ $shopUrl }}" class="hover:text-pl-terracotta transition-colors">Books & Stationery</a>
    <span>/</span>
    <span class="text-slate-900 font-semibold truncate">{{ $title }}</span>
  </nav>

  <!-- Product Detail Showcase (2 Cols) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

    <!-- Left: Gallery & Main Showcase (6 cols) -->
    <div class="lg:col-span-6 space-y-4">
      <div class="aspect-square w-full rounded-3xl bg-white border border-pl-border overflow-hidden p-6 sm:p-10 shadow-xs flex items-center justify-center">
        <img src="{{ $imgSrc }}"
             alt="{{ $title }}"
             class="max-w-full max-h-full object-contain rounded-xl hover:scale-105 transition-transform duration-500">
      </div>

      <!-- Trust Strip below image -->
      <div class="grid grid-cols-3 gap-3 text-center">
        <div class="bg-white rounded-xl border border-pl-border p-3 space-y-1">
          <span class="text-lg">🌿</span>
          <span class="text-[11px] font-semibold text-slate-800 block">Eco-Friendly</span>
        </div>
        <div class="bg-white rounded-xl border border-pl-border p-3 space-y-1">
          <span class="text-lg">📦</span>
          <span class="text-[11px] font-semibold text-slate-800 block">Fast Dispatch</span>
        </div>
        <div class="bg-white rounded-xl border border-pl-border p-3 space-y-1">
          <span class="text-lg">🎁</span>
          <span class="text-[11px] font-semibold text-slate-800 block">Gift Wrap Ready</span>
        </div>
      </div>
    </div>

    <!-- Right: Purchase Options & Editorial Meta (6 cols) -->
    <div class="lg:col-span-6 space-y-6">

      <div class="space-y-2">
        <span class="inline-block px-3 py-1 bg-pl-cream border border-pl-border rounded-full text-[10px] font-bold text-pl-terracotta uppercase tracking-wider">
          PaperLoom Selection
        </span>
        <h1 class="font-serif-book text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight leading-tight">
          {{ $title }}
        </h1>

        <!-- Ratings -->
        <div class="flex items-center gap-2 pt-1">
          <div class="text-amber-500 text-sm">★★★★★</div>
          <span class="text-xs font-semibold text-slate-700">4.8</span>
          <span class="text-xs text-slate-400">• 480 Verified Buyer Reviews</span>
        </div>
      </div>

      <!-- Price Box -->
      <div class="p-4 sm:p-5 bg-white rounded-2xl border border-pl-border flex items-baseline gap-3">
        <span class="text-2xl sm:text-3xl font-bold text-slate-900">
          {{ $priceFormatted }}
        </span>
        @if($comparePrice && $comparePrice !== $priceFormatted)
          <span class="text-sm sm:text-base text-slate-400 line-through">
            {{ $comparePrice }}
          </span>
          <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
            Save on this item
          </span>
        @endif
      </div>

      <!-- Description -->
      <div class="space-y-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
        <p>
          {{ (isset($p->note) && $p->note) ? $p->note : 'Crafted with premium archival-grade materials, precision binding, and curated specifically for readers, writers, and students who appreciate enduring craftsmanship.' }}
        </p>
      </div>

      <!-- Quantity & Cart Actions (with Alpine Quantity State) -->
      <div class="space-y-4 pt-4 border-t border-pl-border" x-data="{ qty: 1 }">

        <div class="flex items-center gap-4">
          <span class="text-xs font-bold text-slate-700">Quantity:</span>
          <div class="flex items-center border border-pl-border rounded-xl bg-white overflow-hidden h-10 shadow-xs">
            <button type="button"
                    @click="qty = Math.max(1, qty - 1)"
                    class="w-10 h-full flex items-center justify-center text-slate-700 hover:bg-slate-100 font-bold text-sm">
              &minus;
            </button>
            <input type="number"
                   x-model.number="qty"
                   min="1"
                   class="w-12 h-full text-center bg-transparent text-xs font-bold text-slate-900 outline-none">
            <button type="button"
                    @click="qty = qty + 1"
                    class="w-10 h-full flex items-center justify-center text-slate-700 hover:bg-slate-100 font-bold text-sm">
              +
            </button>
          </div>
          <span class="text-xs text-emerald-700 font-semibold">
            ✓ In Stock ({{ $stockQty }} available)
          </span>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
          <button type="button"
                  class="js-add-to-cart flex-1 py-3.5 bg-pl-terracotta hover:bg-pl-terracottaHover active:scale-95 text-white rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2"
                  data-id="{{ $productId }}"
                  data-name="{{ $title }}"
                  data-price="{{ $price }}"
                  data-image="{{ $imgSrc }}"
                  data-currency="{{ $s->currency_code ?? '$' }}"
                  :data-qty="qty"
                  data-stock="{{ $stockQty }}"
                  data-added-label="Added to Bag!">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>Add to Shopping Bag</span>
          </button>

          <a href="{{ $plRoute('store.cart') }}"
             class="px-6 py-3.5 bg-white hover:bg-pl-cream text-slate-900 border border-pl-border rounded-xl text-xs sm:text-sm font-bold transition-colors text-center shadow-xs">
            View Bag
          </a>
        </div>

      </div>

      <!-- Specification Accordion -->
      <div class="border-t border-pl-border pt-4 space-y-3 text-xs text-slate-600">
        <div class="flex justify-between py-1.5 border-b border-pl-border/50">
          <span class="font-semibold text-slate-900">Format / Style</span>
          <span>Archival Quality Edition</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-pl-border/50">
          <span class="font-semibold text-slate-900">Shipping</span>
          <span>Dispatched within 24h</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-pl-border/50">
          <span class="font-semibold text-slate-900">Returns</span>
          <span>30-Day Hassle-Free Guarantee</span>
        </div>
      </div>

    </div>

  </div>

  <!-- Related PaperLoom Recommendations -->
  @if(isset($related) && $related->isNotEmpty())
    <section class="border-t border-pl-border pt-12 space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
            You May Also Enjoy
          </h2>
          <p class="text-xs text-slate-500 mt-1">
            Complementary reading and study selections.
          </p>
        </div>
        <a href="{{ $shopUrl }}" class="text-xs font-bold text-pl-terracotta hover:underline">
          View All &rarr;
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        @foreach($related as $relProd)
          @include('store.themes.paperloom.partials.product-card', ['product' => $relProd])
        @endforeach
      </div>
    </section>
  @endif

</div>

@endsection
