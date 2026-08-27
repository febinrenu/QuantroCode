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

  $partNumber = $p->code ?: ('PART-' . str_pad($p->id, 6, '0', STR_PAD_LEFT));
  $unitName = $p->unit?->name ?? $p->unitSale?->name ?? null;

  $dimParts = array_filter([$p->length, $p->width, $p->height]);
  $dimString = !empty($dimParts) ? implode('×', $dimParts) . ' cm' : null;
@endphp

<article class="auto-card product-card">
  <div class="auto-card-header">
    <div class="auto-part-badge font-mono" title="Part Number / SKU">
      <span class="auto-part-lbl">PART#:</span>
      <span class="auto-part-no">{{ $partNumber }}</span>
    </div>

    @if($p->brand)
      <span class="auto-brand-tag">{{ $p->brand->name }}</span>
    @elseif(!empty($p->Type_barcode))
      <span class="auto-barcode-tag">{{ $p->Type_barcode }}</span>
    @endif
  </div>

  <div class="auto-media">
    <a href="#" class="auto-img-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="auto-img">
    </a>

    @if($isPreorderActive)
      <span class="auto-badge-pre">{{ __('messages.PreOrder') }}</span>
    @elseif(!$isAvailable)
      <span class="auto-badge-out">{{ __('messages.OutOfStock') }}</span>
    @endif

    <button type="button" class="auto-inspect-btn js-quick-view"
            title="Inspect Part Specs"
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
      <x-store.icon name="eye" class="w-3.5 h-3.5" /> Details
    </button>
  </div>

  <div class="auto-body product-body">
    <h3 class="auto-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    {{-- Hardware Specs Strip --}}
    <div class="auto-specs-bar">
      @if(!empty($p->weight) && $p->weight > 0)
        <span class="auto-spec font-mono">WT: {{ $p->weight }}kg</span>
      @endif
      @if($dimString)
        <span class="auto-spec font-mono">DIM: {{ $dimString }}</span>
      @endif
      @if($unitName)
        <span class="auto-spec font-mono">UNIT: {{ $unitName }}</span>
      @endif
      @if(!empty($p->gtin))
        <span class="auto-spec font-mono">GTIN: {{ $p->gtin }}</span>
      @endif
    </div>

    <div class="auto-pricing-box">
      @if(empty($hidePrices))
        <div class="auto-price-wrap">
          <span class="auto-price-tag">TRADE PRICE</span>
          <div class="auto-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}</div>
        </div>
      @else
        <div class="auto-price-locked">
          <a href="{{ route('store.login.show') }}" class="text-xs text-amber-500 font-semibold underline">Sign in for Trade Pricing</a>
        </div>
      @endif

      @if(empty($hidePrices))
        <button type="button"
                class="auto-btn-order js-add-to-cart"
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
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Order Part' }}</span>
        </button>
      @endif
    </div>
    <div class="js-add-status auto-add-status"></div>
  </div>
</article>
