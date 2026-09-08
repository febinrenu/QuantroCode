@php
  use App\Support\Storefront\StorefrontPresenter;

  $p = is_array($product) ? (object) $product : $product;
  $currency = $s->currency_code ?? '$';

  $productName = $p->name ?? 'Marketplace Item';
  $productId = $p->id ?? 0;
  $productSlug = $p->slug ?? (string) $productId;
  $productPrice = (float) ($p->display_price ?? $p->price ?? 0);
  $basePrice = (float) ($p->base_price ?? $p->price ?? 0);

  // Calculate discount
  $discount = 0;
  if ($basePrice > $productPrice && $basePrice > 0) {
      $discount = (int) round((($basePrice - $productPrice) / $basePrice) * 100);
  } elseif (!empty($p->discount_percent)) {
      $discount = (int) $p->discount_percent;
  }

  // Resolved Image URL
  $imgSrc = null;
  $primaryFile = method_exists($p, 'primaryProductImageFilename') ? $p->primaryProductImageFilename() : ($p->image ?? '');
  if (!empty($primaryFile)) {
      $imgSrc = global_asset('images/themes/marketverse/' . $primaryFile);
      if (!file_exists(public_path('images/themes/marketverse/' . $primaryFile))) {
          $imgSrc = global_asset(upload_path('products') . '/' . $primaryFile);
      }
  } else {
      $imgSrc = global_asset('images/themes/marketverse/generic-product.jpg');
  }

  // Seller store attribution
  $sellerName = $p->seller_name ?? ($p->brand->name ?? 'Verified Marketplace Seller');
  $rating = $p->rating ?? '4.8';
  $salesCount = $p->sales_count ?? '1.2k';

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'marketverse');
  $productUrl = route('store.product.show', array_filter([
      'slugOrId' => $productId,
      'preview_theme' => ($themePreview && $themePreview !== 'monochra') ? $themePreview : null
  ]));
@endphp

<div class="group bg-white rounded-2xl border border-mv-border overflow-hidden flex flex-col justify-between mv-card relative">

  <!-- Top Discount / Tag Badges -->
  <div class="relative aspect-square w-full bg-slate-50 overflow-hidden flex items-center justify-center p-3">

    @if($discount > 0)
      <span class="absolute top-2.5 left-2.5 z-10 px-2 py-0.5 bg-red-600 text-white text-[10px] font-extrabold rounded-md shadow-xs">
        -{{ $discount }}% OFF
      </span>
    @elseif(!empty($p->is_featured))
      <span class="absolute top-2.5 left-2.5 z-10 px-2 py-0.5 bg-mv-purple text-white text-[10px] font-extrabold rounded-md shadow-xs">
        HOT DEAL
      </span>
    @endif

    <!-- Quick View Overlay Link -->
    <a href="{{ $productUrl }}" class="absolute inset-0 z-0">
      <img src="{{ $imgSrc }}"
           alt="{{ $productName }}"
           class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-300">
    </a>
  </div>

  <!-- Content Section -->
  <div class="p-3.5 sm:p-4 flex flex-col flex-1 justify-between space-y-2">

    <div>
      <!-- Seller Attribution -->
      <div class="flex items-center justify-between text-[11px] text-slate-400 mb-1">
        <span class="truncate max-w-[120px] font-medium text-mv-purple">
          Sold by {{ $sellerName }}
        </span>
        <div class="flex items-center gap-0.5 text-amber-500 font-bold text-[10px]">
          <span>★</span>
          <span>{{ $rating }}</span>
        </div>
      </div>

      <!-- Title -->
      <a href="{{ $productUrl }}" class="block">
        <h3 class="text-xs sm:text-sm font-semibold text-slate-800 line-clamp-2 group-hover:text-mv-purple transition-colors leading-snug">
          {{ $productName }}
        </h3>
      </a>
    </div>

    <!-- Pricing & Add to Cart -->
    <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
      <div>
        <div class="flex items-baseline gap-1.5">
          <span class="text-sm sm:text-base font-extrabold text-slate-900">
            {{ $currency }}{{ number_format($productPrice, 2) }}
          </span>
          @if($basePrice > $productPrice)
            <span class="text-[11px] text-slate-400 line-through">
              {{ $currency }}{{ number_format($basePrice, 2) }}
            </span>
          @endif
        </div>
      </div>

      <!-- Add to Cart Button (Working .js-add-to-cart) -->
      <button type="button"
              class="js-add-to-cart px-3 py-1.5 bg-mv-purple hover:bg-mv-purpleDark text-white text-xs font-bold rounded-lg shadow-xs active:scale-95 transition-all flex items-center gap-1 shrink-0"
              data-id="{{ $productId }}"
              data-name="{{ $productName }}"
              data-price="{{ $productPrice }}"
              data-image="{{ $imgSrc }}"
              data-currency="{{ $currency }}"
              data-qty="1"
              data-stock="100"
              data-added-label="Added!">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        <span class="hidden sm:inline">Add</span>
      </button>
    </div>

  </div>

</div>
