@extends('store.themes.marketverse._shell')

@php
  use App\Models\Product;

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $mvRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $mvRoute('store.shop');

  $prodObj = is_array($product) ? (object) $product : $product;
  $productId = $prodObj->id ?? ($p->id ?? 1);
  $title = $prodObj->name ?? ($p->name ?? 'Product Details');
  $productPrice = (float) ($prodObj->final_price ?? ($prodObj->display_price ?? ($p->price ?? 0)));
  $basePrice = (float) ($prodObj->base_price ?? ($p->base_price ?? $productPrice));

  $discount = 0;
  if ($basePrice > $productPrice && $basePrice > 0) {
      $discount = (int) round((($basePrice - $productPrice) / $basePrice) * 100);
  } elseif (!empty($p->discount_percent)) {
      $discount = (int) $p->discount_percent;
  }

  $primaryFile = method_exists($p, 'primaryProductImageFilename') ? $p->primaryProductImageFilename() : ($p->image ?? '');
  if (!empty($primaryFile)) {
      $imgSrc = global_asset('images/themes/marketverse/' . $primaryFile);
      if (!file_exists(public_path('images/themes/marketverse/' . $primaryFile))) {
          $imgSrc = global_asset(upload_path('products') . '/' . $primaryFile);
      }
  } else {
      $imgSrc = global_asset('images/themes/marketverse/generic-product.jpg');
  }

  $sellerName = $p->brand->name ?? 'Verified Marketplace Seller';
  $categoryName = $p->category->name ?? 'Marketplace';
  $currency = $s->currency_code ?? '$';

  // Related products
  $relatedProducts = Product::where('code', 'like', 'MKT-%')
      ->where('id', '!=', $productId)
      ->take(6)
      ->get();
@endphp

@section('title', $title . ' — MarketVerse')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ qty: 1 }">

  <!-- Breadcrumbs -->
  <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-8">
    <a href="{{ $mvRoute('store.index') }}" class="hover:text-mv-purple transition-colors">Home</a>
    <span>/</span>
    <a href="{{ $mvRoute('store.shop', ['category' => $categoryName]) }}" class="hover:text-mv-purple transition-colors">{{ $categoryName }}</a>
    <span>/</span>
    <span class="text-slate-900 font-bold truncate max-w-xs">{{ $title }}</span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 bg-white rounded-3xl border border-mv-border p-6 sm:p-10 shadow-xs">

    <!-- Image Gallery (5 cols) -->
    <div class="lg:col-span-5 space-y-4">
      <div class="aspect-square w-full rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center p-6 relative">
        @if($discount > 0)
          <span class="absolute top-4 left-4 z-10 px-2.5 py-1 bg-red-600 text-white text-xs font-black rounded-md shadow-xs">
            -{{ $discount }}% OFF
          </span>
        @endif
        <img src="{{ $imgSrc }}"
             alt="{{ $title }}"
             class="w-full h-full object-contain hover:scale-105 transition-transform duration-300">
      </div>
    </div>

    <!-- Product Details (7 cols) -->
    <div class="lg:col-span-7 flex flex-col justify-between space-y-6">

      <div class="space-y-4">

        <!-- Seller Store Info -->
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 bg-mv-purpleLight text-mv-purple font-extrabold text-xs rounded-full">
              Verified Seller
            </span>
            <span class="text-xs font-bold text-slate-700">Sold by {{ $sellerName }}</span>
          </div>
          <div class="flex items-center gap-1 text-amber-500 font-bold text-xs">
            <span>★ 4.8</span>
            <span class="text-slate-400 font-normal">(1.2k ratings)</span>
          </div>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
          {{ $title }}
        </h1>

        <!-- Price Display -->
        <div class="flex items-baseline gap-3 pt-2">
          <span class="text-3xl font-black text-slate-900">
            {{ $currency }}{{ number_format($productPrice, 2) }}
          </span>
          @if($basePrice > $productPrice)
            <span class="text-base text-slate-400 line-through">
              {{ $currency }}{{ number_format($basePrice, 2) }}
            </span>
            <span class="text-xs font-extrabold text-red-600 bg-red-50 px-2 py-0.5 rounded">
              Save {{ $currency }}{{ number_format($basePrice - $productPrice, 2) }}
            </span>
          @endif
        </div>

        <!-- Description -->
        <div class="prose prose-sm text-slate-600 text-xs sm:text-sm leading-relaxed border-t border-slate-100 pt-4">
          <p>
            {{ $p->description ?? 'Experience premium marketplace quality backed by buyer protection, fast tracked delivery, and 100% authenticity guarantee.' }}
          </p>
        </div>

        <!-- Stock Status -->
        <div class="flex items-center gap-2 text-xs font-bold text-emerald-600">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span>In Stock • Ready to ship from verified warehouse</span>
        </div>

      </div>

      <!-- Actions (Quantity + Add to Cart) -->
      <div class="pt-6 border-t border-slate-100 space-y-4">

        <div class="flex flex-wrap items-center gap-4">

          <!-- Quantity Controls -->
          <div class="flex items-center border border-mv-border rounded-xl bg-slate-50 p-1">
            <button type="button"
                    @click="qty = Math.max(1, qty - 1)"
                    class="w-8 h-8 rounded-lg bg-white shadow-xs font-bold text-slate-700 hover:bg-slate-100 flex items-center justify-center">
              -
            </button>
            <input type="number"
                   x-model.number="qty"
                   min="1"
                   class="w-12 text-center text-xs font-bold bg-transparent text-slate-900 focus:outline-none">
            <button type="button"
                    @click="qty = qty + 1"
                    class="w-8 h-8 rounded-lg bg-white shadow-xs font-bold text-slate-700 hover:bg-slate-100 flex items-center justify-center">
              +
            </button>
          </div>

          <!-- Add to Cart (Working .js-add-to-cart) -->
          <button type="button"
                  class="js-add-to-cart flex-1 px-8 py-3.5 bg-mv-purple hover:bg-mv-purpleDark text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2"
                  data-id="{{ $productId }}"
                  data-name="{{ $title }}"
                  data-price="{{ $productPrice }}"
                  data-image="{{ $imgSrc }}"
                  data-currency="{{ $currency }}"
                  :data-qty="qty"
                  data-stock="100"
                  data-added-label="Added to Cart!">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <span>Add to Cart</span>
          </button>

          <!-- Buy Now -->
          <a href="{{ $mvRoute('store.cart') }}"
             class="px-8 py-3.5 bg-mv-orange hover:bg-mv-orangeHover text-white font-extrabold text-xs sm:text-sm rounded-xl shadow-lg active:scale-95 transition-all text-center">
            Buy Now
          </a>

        </div>

        <!-- Trust Badges -->
        <div class="grid grid-cols-3 gap-2 pt-2 text-center text-[10px] text-slate-500">
          <div class="p-2 bg-slate-50 rounded-xl">🛡️ Buyer Protection</div>
          <div class="p-2 bg-slate-50 rounded-xl">🚚 Fast Tracked Delivery</div>
          <div class="p-2 bg-slate-50 rounded-xl">🔄 30-Day Hassle-Free Returns</div>
        </div>

      </div>

    </div>

  </div>

  <!-- Related Marketplace Products -->
  @if(isset($relatedProducts) && count($relatedProducts) > 0)
    <div class="mt-14 space-y-6">
      <div class="flex items-center justify-between border-b border-mv-border pb-4">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
          More from this Department
        </h2>
        <a href="{{ $shopUrl }}" class="text-xs font-bold text-mv-purple hover:underline">
          View All &rarr;
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($relatedProducts as $rel)
          @include('store.themes.marketverse.partials.product-card', ['product' => $rel])
        @endforeach
      </div>
    </div>
  @endif

</div>
@endsection
