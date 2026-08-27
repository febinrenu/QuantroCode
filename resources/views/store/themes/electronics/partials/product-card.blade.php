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

  $isAvailable = true;
  if (!$isPreorderActive && !$allowOverselling) {
    if ($variants->isEmpty()) {
      $isAvailable = $productStock !== null && $productStock > 0;
    } else {
      $isAvailable = $variantPayload->contains(fn($v) => ($v['stock'] ?? 0) > 0);
    }
  }

  $sku = $p->code ?: ('ELEC-' . str_pad($p->id, 5, '0', STR_PAD_LEFT));
  $warrantyText = null;
  if (!empty($p->warranty_period)) {
    $warrantyText = $p->warranty_period . ' ' . ($p->warranty_unit ?: 'Mo') . ' Warranty';
  } elseif (!empty($p->has_guarantee)) {
    $warrantyText = 'Official Guarantee';
  }
@endphp

<article class="tech-card product-card">
  <div class="tech-card-top">
    @if($p->brand)
      <span class="tech-brand-badge">{{ $p->brand->name }}</span>
    @else
      <span class="tech-sku-pill font-mono">{{ $sku }}</span>
    @endif

    @if($warrantyText)
      <span class="tech-warranty-pill" title="Hardware Warranty Coverage">
        <x-store.icon name="shield-check" class="w-3 h-3" /> {{ $warrantyText }}
      </span>
    @endif
  </div>

  <div class="tech-media-box">
    <a href="#" class="tech-img-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="tech-img">
    </a>

    @if($isPreorderActive)
      <span class="tech-badge-pre">{{ __('messages.PreOrder') }}</span>
    @elseif(!$isAvailable)
      <span class="tech-badge-out">{{ __('messages.OutOfStock') }}</span>
    @endif

    <button type="button" class="tech-quick-btn js-quick-view"
            title="Inspect Technical Specs"
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
      <x-store.icon name="eye" class="w-3.5 h-3.5" /> Specs
    </button>
  </div>

  <div class="tech-body product-body">
    <div class="tech-model-row">
      <span class="tech-model-code font-mono">MODEL: {{ $sku }}</span>
      @if($variants->isNotEmpty())
        <span class="tech-var-count">{{ $variants->count() }} configs</span>
      @endif
    </div>

    <h3 class="tech-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    {{-- Specs Pill Cluster (Authentic attributes only) --}}
    <div class="tech-specs-pills">
      @if(!empty($p->weight) && $p->weight > 0)
        <span class="tech-spec-tag font-mono">⚖️ {{ $p->weight }}kg</span>
      @endif
      @if(!empty($p->is_imei))
        <span class="tech-spec-tag">IMEI Verified</span>
      @endif
      @if($p->category)
        <span class="tech-spec-tag">{{ $p->category->name }}</span>
      @endif
    </div>

    <div class="tech-price-action-row">
      <div class="tech-price-block">
        @if(empty($hidePrices))
          <span class="tech-price-label">PRICE</span>
          <div class="tech-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}</div>
        @else
          <a href="{{ route('store.login.show') }}" class="text-xs text-cyan-400 font-semibold underline">Sign in for Price</a>
        @endif
      </div>

      @if(empty($hidePrices))
        <button type="button"
                class="tech-btn-buy js-add-to-cart"
                @if(!$isAvailable) disabled @endif
                data-qty="1"
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
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Add' }}</span>
        </button>
      @endif
    </div>
    <div class="js-add-status tech-add-status"></div>
  </div>
</article>
