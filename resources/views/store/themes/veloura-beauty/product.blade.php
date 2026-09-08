@extends('store.themes.veloura-beauty._shell')

@php
  use App\Models\Product;
  use App\Support\Storefront\StorefrontPresenter;

  // $p is the Eloquent Model instance passed by StoreFrontController@product
  // If $p is missing, resolve from $product or $productId
  $prodModel = $p ?? (isset($productId) ? Product::find($productId) : null);
  if (!$prodModel && isset($product)) {
      if (is_object($product) && $product instanceof Product) {
          $prodModel = $product;
      } elseif (is_numeric($product) || is_string($product)) {
          $prodModel = Product::where('id', $product)->orWhere('code', $product)->first();
      } elseif (is_array($product) && isset($product['id'])) {
          $prodModel = Product::find($product['id']);
      }
  }

  $productId = $prodModel->id ?? (is_array($product ?? null) ? ($product['id'] ?? 0) : 0);
  $productName = $prodModel->name ?? (is_array($product ?? null) ? ($product['name'] ?? 'Veloura Haute Beauty Product') : 'Veloura Haute Beauty Product');
  $productPrice = (float) ($prodModel->display_price ?? ($prodModel->price ?? (is_array($product ?? null) ? ($product['price'] ?? 0) : 0)));
  $basePrice = (float) ($prodModel->base_price ?? ($prodModel->price ?? (is_array($product ?? null) ? ($product['base_price'] ?? $productPrice) : $productPrice)));
  $productDescription = $prodModel->description ?? (is_array($product ?? null) ? ($product['description'] ?? '') : '');
  $categoryName = $prodModel->category->name ?? (is_array($product ?? null) ? ($product['category']['name'] ?? ($product['category'] ?? 'Luxury Beauty')) : 'Luxury Beauty');

  $discount = 0;
  if ($basePrice > $productPrice && $basePrice > 0) {
      $discount = (int) round((($basePrice - $productPrice) / $basePrice) * 100);
  } elseif (!empty($prodModel->discount_percent ?? (is_array($product ?? null) ? ($product['discount_percent'] ?? 0) : 0))) {
      $discount = (int) ($prodModel->discount_percent ?? $product['discount_percent']);
  }

  $primaryFile = (is_object($prodModel) && method_exists($prodModel, 'primaryProductImageFilename'))
      ? $prodModel->primaryProductImageFilename()
      : ($prodModel->image ?? (is_array($product ?? null) ? ($product['image'] ?? '') : ''));

  if (!empty($primaryFile)) {
      $imgSrc = global_asset('images/themes/veloura/' . $primaryFile);
      if (!file_exists(public_path('images/themes/veloura/' . $primaryFile))) {
          $imgSrc = global_asset(upload_path('products') . '/' . $primaryFile);
      }
  } else {
      $imgSrc = global_asset('images/themes/veloura/generic-beauty.jpg');
  }

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@section('title', $productName . ' — Veloura Beauty')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ qty: 1, activeTab: 'description' }">

  <!-- Breadcrumbs -->
  <nav class="flex items-center gap-2 text-xs text-vel-muted font-medium mb-8">
    <a href="{{ $velRoute('store.index') }}" class="hover:text-vel-rose transition-colors">Home</a>
    <span>/</span>
    <a href="{{ $velRoute('store.shop', ['category' => $categoryName]) }}" class="hover:text-vel-rose transition-colors">{{ $categoryName }}</a>
    <span>/</span>
    <span class="text-vel-charcoal font-bold truncate max-w-xs">{{ $productName }}</span>
  </nav>

  <!-- Main Product Detail Card -->
  <div class="bg-white rounded-3xl border border-vel-border overflow-hidden shadow-sm p-6 sm:p-10 mb-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

      <!-- Product Image Gallery -->
      <div class="lg:col-span-6 space-y-4">
        <div class="aspect-square w-full rounded-2xl bg-[#F9F3EC] border border-vel-border overflow-hidden flex items-center justify-center p-8">
          <img src="{{ $imgSrc }}"
               alt="{{ $productName }}"
               class="max-w-full max-h-full object-contain hover:scale-105 transition-transform duration-500">
        </div>
      </div>

      <!-- Product Meta / Purchasing Column -->
      <div class="lg:col-span-6 space-y-6">

        <!-- Category & Rating -->
        <div class="flex items-center justify-between">
          <span class="px-3 py-1 bg-vel-roseLight text-vel-roseDeep text-[10px] font-extrabold rounded-full uppercase tracking-wider">
            {{ $categoryName }} &bull; Clean Formula
          </span>
          <div class="flex items-center gap-1 text-amber-500 text-xs font-bold">
            <span>★★★★★</span>
            <span class="text-vel-charcoal font-medium">4.9 (180+ reviews)</span>
          </div>
        </div>

        <!-- Product Title -->
        <h1 class="font-serif-luxury text-2xl sm:text-3xl lg:text-4xl font-bold text-vel-charcoal leading-tight">
          {{ $productName }}
        </h1>

        <!-- Price -->
        <div class="flex items-baseline gap-3">
          <span class="text-2xl sm:text-3xl font-bold text-vel-charcoal">
            {{ $s->currency_code ?? '$' }}{{ number_format($productPrice, 2) }}
          </span>
          @if($basePrice > $productPrice)
            <span class="text-base text-slate-400 line-through">
              {{ $s->currency_code ?? '$' }}{{ number_format($basePrice, 2) }}
            </span>
          @endif
          @if($discount > 0)
            <span class="text-xs text-rose-700 font-extrabold bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200">
              Save {{ $discount }}%
            </span>
          @endif
          <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full">
            In Stock &bull; Ready to Dispatch
          </span>
        </div>

        <!-- Editorial Description -->
        <p class="text-xs sm:text-sm text-vel-muted leading-relaxed font-light">
          {{ $productDescription ?: 'An opulent, highly concentrated formula crafted with pure botanical extracts and active peptides. Designed to restore cellular vitality, deliver multi-layer hydration, and leave an exquisite satin glow.' }}
        </p>

        <!-- Quantity & Add to Bag Controls -->
        <div class="pt-4 border-t border-vel-border space-y-4">

          <div class="flex items-center gap-4">
            <span class="text-xs font-bold text-vel-charcoal">Quantity:</span>
            <div class="flex items-center border border-vel-border rounded-xl bg-vel-blush">
              <button type="button"
                      @click="qty = Math.max(1, qty - 1)"
                      class="px-3 py-2 text-xs font-bold hover:text-vel-rose transition-colors">
                &minus;
              </button>
              <span x-text="qty" class="px-4 py-2 text-xs font-bold text-vel-charcoal min-w-[2.5rem] text-center">
                1
              </span>
              <button type="button"
                      @click="qty = qty + 1"
                      class="px-3 py-2 text-xs font-bold hover:text-vel-rose transition-colors">
                +
              </button>
            </div>
          </div>

          <!-- Add to Bag Button -->
          <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <button type="button"
                    class="js-add-to-cart flex-1 py-4 bg-vel-rose hover:bg-vel-roseDark text-white font-bold text-xs rounded-full shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2 uppercase tracking-widest"
                    data-id="{{ $productId }}"
                    data-name="{{ $productName }}"
                    data-price="{{ $productPrice }}"
                    data-image="{{ $imgSrc }}"
                    data-currency="{{ $s->currency_code ?? '$' }}"
                    x-bind:data-qty="qty"
                    data-stock="100"
                    data-added-label="Added to Bag!">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
              <span>Add to Shopping Bag</span>
            </button>

            <a href="{{ $velRoute('store.cart') }}"
               class="px-8 py-4 bg-white hover:bg-vel-blush text-vel-charcoal font-bold text-xs rounded-full border border-vel-border shadow-xs active:scale-95 transition-all uppercase tracking-widest text-center">
              View Bag
            </a>
          </div>

        </div>

        <!-- Luxury Guarantees Strip -->
        <div class="pt-6 border-t border-vel-border grid grid-cols-2 gap-3 text-xs text-vel-muted">
          <div class="flex items-center gap-2">
            <span>✨</span> 3 Free Luxury Samples
          </div>
          <div class="flex items-center gap-2">
            <span>🌿</span> 100% Clean & Vegan
          </div>
          <div class="flex items-center gap-2">
            <span>🚚</span> Free Carbon-Neutral Shipping
          </div>
          <div class="flex items-center gap-2">
            <span>🔄</span> 30-Day Happiness Guarantee
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- Editorial Tabs: Description / Ingredients / Ritual How to Use -->
  <div class="bg-white rounded-3xl border border-vel-border p-6 sm:p-10 space-y-6 mb-16">
    <div class="flex items-center gap-6 border-b border-vel-border pb-4">
      <button type="button"
              @click="activeTab = 'description'"
              :class="activeTab === 'description' ? 'text-vel-rose font-bold border-b-2 border-vel-rose -mb-[18px] pb-4' : 'text-vel-muted hover:text-vel-charcoal'"
              class="text-xs uppercase tracking-wider transition-colors">
        Product Ritual
      </button>
      <button type="button"
              @click="activeTab = 'ingredients'"
              :class="activeTab === 'ingredients' ? 'text-vel-rose font-bold border-b-2 border-vel-rose -mb-[18px] pb-4' : 'text-vel-muted hover:text-vel-charcoal'"
              class="text-xs uppercase tracking-wider transition-colors">
        Botanical Actives
      </button>
      <button type="button"
              @click="activeTab = 'usage'"
              :class="activeTab === 'usage' ? 'text-vel-rose font-bold border-b-2 border-vel-rose -mb-[18px] pb-4' : 'text-vel-muted hover:text-vel-charcoal'"
              class="text-xs uppercase tracking-wider transition-colors">
        How to Apply
      </button>
    </div>

    <!-- Tab 1: Description -->
    <div x-show="activeTab === 'description'" class="text-xs sm:text-sm text-vel-muted leading-relaxed space-y-3">
      <p>
        {{ $productDescription ?: 'Formulated in our Parisian laboratories, this master formulation merges biocompatible hyaluronic hydration with soothing French Damask Rose nectar. Designed to be absorbed seamlessly without stickiness, imparting a supple, lit-from-within glow.' }}
      </p>
    </div>

    <!-- Tab 2: Ingredients -->
    <div x-show="activeTab === 'ingredients'" class="text-xs sm:text-sm text-vel-muted leading-relaxed space-y-2">
      <p class="font-bold text-vel-charcoal">Full Key Ingredients:</p>
      <p>Rosa Damascena Flower Water, Multi-Molecular Sodium Hyaluronate, 15% Ethyl Ascorbic Acid (Vitamin C), Niacinamide, Squalane (Olive-Derived), Camellia Sinensis Leaf Extract, Tocopherol, Centella Asiatica.</p>
    </div>

    <!-- Tab 3: Usage -->
    <div x-show="activeTab === 'usage'" class="text-xs sm:text-sm text-vel-muted leading-relaxed space-y-2">
      <p>Warm 3–4 drops between fingertips. Gently press onto freshly cleansed face, neck, and décolleté in upward sweeping motions. Follow with your favorite Veloura moisturizer or face oil for complete cellular radiance.</p>
    </div>
  </div>

  <!-- Related Products / Complete the Ritual -->
  @if(!empty($related) && count($related) > 0)
    <section class="space-y-8">
      <div class="flex items-end justify-between border-b border-vel-border pb-4">
        <div>
          <span class="text-xs font-bold text-vel-rose uppercase tracking-widest block">Complementary Care</span>
          <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal">Complete Your Ritual</h2>
        </div>
        <a href="{{ $velRoute('store.shop', ['category' => $categoryName]) }}" class="text-xs font-bold text-vel-charcoal hover:text-vel-rose uppercase tracking-wider transition-colors">
          View All &rarr;
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach(array_slice($related, 0, 4) as $relProd)
          @include('store.themes.veloura-beauty.partials.product-card', ['product' => $relProd])
        @endforeach
      </div>
    </section>
  @endif

</div>
@endsection
