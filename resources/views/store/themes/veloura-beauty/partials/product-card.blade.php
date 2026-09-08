@php
  use App\Support\Storefront\StorefrontPresenter;

  $p = is_array($product) ? (object) $product : $product;
  $productId = $p->id ?? 0;
  $productName = $p->name ?? ($p->title ?? 'Veloura Beauty Product');
  $productPrice = (float) ($p->final_price ?? ($p->display_price ?? ($p->price ?? 0)));
  $basePrice = (float) ($p->compare_at_price ?? ($p->base_price ?? ($p->price ?? $productPrice)));

  $discount = 0;
  if ($basePrice > $productPrice && $basePrice > 0) {
      $discount = (int) round((($basePrice - $productPrice) / $basePrice) * 100);
  } elseif (!empty($p->discount_percent)) {
      $discount = (int) $p->discount_percent;
  }

  $primaryFile = (is_object($p) && method_exists($p, 'primaryProductImageFilename'))
      ? $p->primaryProductImageFilename()
      : ($p->image ?? '');

  if (!empty($primaryFile)) {
      $imgSrc = global_asset('images/themes/veloura/' . $primaryFile);
      if (!file_exists(public_path('images/themes/veloura/' . $primaryFile))) {
          $imgSrc = global_asset(upload_path('products') . '/' . $primaryFile);
      }
  } elseif (!empty($p->image_url)) {
      $imgSrc = $p->image_url;
  } else {
      $imgSrc = global_asset('images/themes/veloura/generic-beauty.jpg');
  }

  $categoryName = $p->category_name ?? ($p->category->name ?? ($p->category ?? 'Beauty'));
  $rating = '4.9';
  $reviews = '240+';

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $productUrl = route('store.product.show', array_filter([
      'slugOrId' => $productId,
      'preview_theme' => ($themePreview && $themePreview !== 'monochra') ? $themePreview : null
  ]));
@endphp

<div class="group bg-white rounded-2xl border border-vel-border overflow-hidden flex flex-col justify-between vel-card relative shadow-xs hover:border-vel-rose hover:shadow-md">

  <!-- Image Container -->
  <div class="relative aspect-square w-full bg-[#F9F3EC] overflow-hidden flex items-center justify-center p-4">

    <!-- Badges (Discount / Clean Beauty) -->
    <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5 items-start">
      @if($discount > 0)
        <span class="px-2 py-0.5 bg-rose-700 text-white text-[10px] font-extrabold rounded-md shadow-xs uppercase tracking-wider">
          -{{ $discount }}%
        </span>
      @endif
      <span class="px-2 py-0.5 bg-white/95 backdrop-blur-xs text-vel-roseDark text-[9px] font-extrabold rounded-md shadow-xs border border-vel-border">
        Clean
      </span>
    </div>

    <!-- Wishlist Button -->
    <button type="button"
            onclick="event.preventDefault(); this.classList.toggle('text-rose-500'); this.classList.toggle('text-slate-400')"
            class="absolute top-3 right-3 z-10 w-8 h-8 rounded-full bg-white/95 backdrop-blur-xs border border-vel-border flex items-center justify-center text-slate-400 hover:text-rose-500 hover:scale-110 transition-all shadow-xs"
            title="Add to Wishlist">
      <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
    </button>

    <!-- Product Image -->
    <a href="{{ $productUrl }}" class="w-full h-full flex items-center justify-center">
      <img src="{{ $imgSrc }}"
           alt="{{ $productName }}"
           loading="lazy"
           class="max-w-full max-h-full object-contain group-hover:scale-108 transition-transform duration-500">
    </a>
  </div>

  <!-- Content / Info -->
  <div class="p-4 flex flex-col flex-1 justify-between gap-3 bg-white">

    <div class="space-y-1.5">
      <!-- Category & Rating -->
      <div class="flex items-center justify-between text-[11px]">
        <span class="text-vel-muted uppercase tracking-widest font-semibold text-[10px]">
          {{ $categoryName }}
        </span>
        <div class="flex items-center gap-1 text-amber-500 font-bold">
          <span>★</span>
          <span class="text-vel-charcoal">{{ $rating }}</span>
        </div>
      </div>

      <!-- Title -->
      <h3 class="font-serif-luxury text-sm font-bold text-vel-charcoal leading-snug line-clamp-2 group-hover:text-vel-rose transition-colors">
        <a href="{{ $productUrl }}">
          {{ $productName }}
        </a>
      </h3>
    </div>

    <!-- Pricing & Add to Cart -->
    <div class="pt-2 border-t border-vel-borderLight flex items-center justify-between gap-2">
      <div class="flex flex-col">
        <span class="text-sm sm:text-base font-bold text-vel-charcoal">
          {{ $s->currency_code ?? '$' }}{{ number_format($productPrice, 2) }}
        </span>
        @if($basePrice > $productPrice)
          <span class="text-[11px] text-slate-400 line-through">
            {{ $s->currency_code ?? '$' }}{{ number_format($basePrice, 2) }}
          </span>
        @endif
      </div>

      <!-- Standard .js-add-to-cart button -->
      <button type="button"
              class="js-add-to-cart px-3.5 py-2 bg-vel-rose hover:bg-vel-roseDark text-white text-xs font-bold rounded-xl shadow-xs active:scale-95 transition-all flex items-center gap-1.5 shrink-0"
              data-id="{{ $productId }}"
              data-name="{{ $productName }}"
              data-price="{{ $productPrice }}"
              data-image="{{ $imgSrc }}"
              data-currency="{{ $s->currency_code ?? '$' }}"
              data-qty="1"
              data-stock="100"
              data-added-label="Added!">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <span class="hidden sm:inline">Add</span>
      </button>
    </div>

  </div>

</div>
