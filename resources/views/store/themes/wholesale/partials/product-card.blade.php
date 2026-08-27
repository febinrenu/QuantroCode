@php
  /** @var \App\Models\Product $p */
  $productSlug = $p->slug ?? (string) $p->id;
  $galleryFilenames = $p->productGalleryFilenames();
  $galleryUrls = collect($galleryFilenames)
    ->map(fn ($f) => $f ? global_asset(upload_path('products') . '/' . $f) : null)
    ->filter()
    ->values()
    ->all();
  $primaryFile = $p->primaryProductImageFilename();
  $imgUrl = $primaryFile ? global_asset(upload_path('products') . '/' . $primaryFile) : global_asset(upload_path('products') . '/no-image.png');
  $descShort = \Illuminate\Support\Str::limit(strip_tags($p->note ?? ''), 400);
  $minPrice  = (float) ($p->display_price ?? ($p->price ?? 0));
  $variants  = $p->relationLoaded('variants') ? $p->variants : collect($p->variants ?? []);
  $variants  = collect($variants);
  $variantPayload = $variants->map(function($v) use ($currency) {
    $final = (float) ($v->display_price ?? ($v->price ?? 0));
    return [
      'id' => (int) ($v->id ?? 0),
      'name' => (string) ($v->name ?? ''),
      'price' => (float) ($v->price ?? 0),
      'display_price' => $final,
      'display_price_formatted' => $currency . number_format($final, 2, '.', ','),
      'image' => !empty($v->image) ? global_asset(upload_path('products') . '/' . $v->image) : null,
      'stock' => (int) max(0, $v->stock ?? $v->qty ?? 0),
    ];
  })->values();
  $productStock = $variants->isEmpty() ? (int) max(0, $p->stock ?? 0) : null;

  $isPreorder = (bool) ($p->is_preorder ?? false);
  $preorderDate = $p->preorder_available_date ? $p->preorder_available_date->format('M d, Y') : null;

  $allowOverselling = isset($s) ? (bool) ($s->allow_overselling ?? true) : true;
  $hidePrices = !Auth::guard('store')->check() && isset($s) && ($s->hide_prices_for_guests ?? false);

  $isPreorderActive = false;
  if ($isPreorder) {
    $outOfStock = $variants->isEmpty()
      ? ($productStock !== null && $productStock <= 0)
      : !$variantPayload->contains(fn($v) => ($v['stock'] ?? 0) > 0);
    if ($outOfStock) { $isPreorderActive = true; }
  }

  if ($isPreorderActive) {
    $isAvailable = true;
    $availabilityLabel = $preorderDate
      ? __('messages.PreorderAvailableOn', ['date' => $preorderDate])
      : __('messages.PreorderAvailable');
    $stockBadgeClass = 'ws-badge-warn';
  } elseif ($allowOverselling) {
    $isAvailable = true;
    $availabilityLabel = __('messages.InStock');
    $stockBadgeClass = 'ws-badge-success';
  } else {
    if ($variants->isEmpty()) {
      $isAvailable = $productStock !== null && $productStock > 0;
      $availabilityLabel = $productStock !== null
        ? ($productStock > 0 ? $productStock . ' in stock' : __('messages.OutOfStock'))
        : null;
    } else {
      $isAvailable = $variantPayload->contains(fn($v) => ($v['stock'] ?? 0) > 0);
      $availabilityLabel = $isAvailable ? __('messages.InStock') : __('messages.OutOfStock');
    }
    $stockBadgeClass = $isAvailable ? 'ws-badge-success' : 'ws-badge-danger';
  }

  $sku = $p->code ?: ('SKU-' . str_pad($p->id, 5, '0', STR_PAD_LEFT));
  $unitName = $p->unit?->name ?? $p->unitSale?->name ?? null;
@endphp

<article class="ws-card product-card" x-data="{ bulkQty: 1 }">
  <div class="ws-card-top">
    <div class="ws-sku-badge" title="Product SKU / Code">
      <span class="ws-sku-label">SKU:</span>
      <span class="ws-sku-val font-mono">{{ $sku }}</span>
    </div>
    @if($availabilityLabel !== null && ($s->show_stock ?? true))
      <span class="ws-stock-pill {{ $stockBadgeClass }}">
        <span class="ws-dot"></span> {{ $availabilityLabel }}
      </span>
    @endif
  </div>

  <div class="ws-media-wrap">
    <a href="#" class="ws-img-link js-quick-view"
       data-id="{{ $p->id }}"
       data-slug="{{ $productSlug }}"
       data-name="{{ e($p->name) }}"
       data-price="{{ number_format($minPrice, 2, '.', '') }}"
       data-image="{{ $imgUrl }}"
       data-gallery='@json($galleryUrls)'
       data-currency="{{ $currency }}"
       data-description="{{ e($descShort) }}"
       data-stock="{{ $productStock !== null ? $productStock : '' }}"
       data-variants='@json($variantPayload)'
       aria-label="{{ __('messages.QuickView') }}: {{ $p->name }}"
       @click.prevent>
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="ws-img">
    </a>

    <button type="button" class="ws-quick-btn js-quick-view"
            title="{{ __('messages.QuickView') }}"
            data-id="{{ $p->id }}"
            data-slug="{{ $productSlug }}"
            data-name="{{ e($p->name) }}"
            data-price="{{ number_format($minPrice, 2, '.', '') }}"
            data-image="{{ $imgUrl }}"
            data-gallery='@json($galleryUrls)'
            data-currency="{{ $currency }}"
            data-description="{{ e($descShort) }}"
            data-stock="{{ $productStock !== null ? $productStock : '' }}"
            data-variants='@json($variantPayload)'
            aria-label="{{ __('messages.QuickView') }}">
      <x-store.icon name="eye" class="w-4 h-4" /> Specs
    </button>
  </div>

  <div class="ws-card-body product-body">
    <h3 class="ws-product-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    @if($p->brand)
      <div class="ws-brand-tag">Brand: <strong>{{ $p->brand->name }}</strong></div>
    @endif

    <div class="ws-pricing-row">
      @if(empty($hidePrices))
        <div class="ws-price-block">
          <span class="ws-price-label">Unit Price</span>
          <div class="ws-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}@if($unitName)<span class="ws-unit">/{{ $unitName }}</span>@endif</div>
        </div>
        @if(!empty($p->wholesale_price) && $p->wholesale_price > 0 && $p->wholesale_price < $minPrice)
          <div class="ws-bulk-tier">
            <span class="ws-tier-badge">Wholesale</span>
            <span class="ws-tier-price font-mono">{{ $currency }}{{ number_format($p->wholesale_price, 2, '.', ',') }}</span>
          </div>
        @endif
      @else
        <div class="ws-price-locked">
          <a href="{{ route('store.login.show') }}" class="text-xs text-accent-500 font-semibold underline">Sign in for B2B Pricing</a>
        </div>
      @endif
    </div>

    @if(empty($hidePrices))
      <div class="ws-actions-row">
        <div class="ws-stepper-wrap">
          <button type="button" class="ws-step-btn" @click="bulkQty = Math.max(1, bulkQty - 1)" aria-label="Decrease quantity">-</button>
          <input type="number" class="ws-qty-input font-mono" x-model.number="bulkQty" min="1" max="9999" @change="bulkQty = Math.max(1, parseInt($event.target.value) || 1)">
          <button type="button" class="ws-step-btn" @click="bulkQty = bulkQty + 1" aria-label="Increase quantity">+</button>
        </div>

        <button type="button"
                class="ws-btn-add js-add-to-cart"
                @if(!$isAvailable) disabled @endif
                :data-qty="bulkQty"
                data-out-of-stock="{{ $isAvailable ? '0' : '1' }}"
                data-is-preorder="{{ $isPreorderActive ? '1' : '0' }}"
                data-id="{{ $p->id }}"
                data-slug="{{ $productSlug }}"
                data-name="{{ e($p->name) }}"
                data-price="{{ number_format($minPrice, 2, '.', '') }}"
                data-image="{{ $imgUrl }}"
                data-gallery='@json($galleryUrls)'
                data-currency="{{ $currency }}"
                data-product-id="{{ $p->id }}"
                data-product-image="{{ $imgUrl }}"
                data-variants='@json($variantPayload)'
                data-stock="{{ $productStock !== null ? $productStock : '' }}"
                data-added-label="{{ __('messages.Added') }}">
          <x-store.icon name="cart" class="w-4 h-4" />
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Add Order' }}</span>
        </button>
      </div>
    @endif
    <div class="js-add-status ws-add-status"></div>
  </div>
</article>
