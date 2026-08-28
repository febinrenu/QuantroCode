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
  $descShort = \Illuminate\Support\Str::limit(strip_tags($p->note ?? ''), 350);
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

  $unitName = $p->unit?->name ?? null;
  $brandName = $p->brand?->name ?? null;
  $sku = $p->code ?: ('MED-' . str_pad($p->id, 5, '0', STR_PAD_LEFT));
@endphp

<article class="med-card product-card">
  <div class="med-top">
    @if($brandName)
      <span class="med-brand-tag">{{ $brandName }}</span>
    @else
      <span class="med-sku font-mono">{{ $sku }}</span>
    @endif

    <span class="med-verified-pill" title="Quality Sealed">
      <x-store.icon name="shield-check" class="w-3 h-3" /> Sealed
    </span>
  </div>

  <div class="med-media">
    <a href="#" class="med-img-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="med-img">
    </a>

    @if($isPreorderActive)
      <span class="med-badge-pre">{{ __('messages.PreOrder') }}</span>
    @elseif(!$isAvailable)
      <span class="med-badge-out">{{ __('messages.OutOfStock') }}</span>
    @endif

    <button type="button" class="med-details-btn js-quick-view"
            title="Inspect Product Information"
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
      <x-store.icon name="eye" class="w-3.5 h-3.5" /> Info
    </button>
  </div>

  <div class="med-body product-body">
    @if($p->category)
      <div class="med-cat">{{ $p->category->name }}</div>
    @endif

    <h3 class="med-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    @if($unitName)
      <div class="med-unit-label">Package: {{ $unitName }}</div>
    @endif

    <div class="med-price-row">
      <div class="med-price-block">
        @if(empty($hidePrices))
          <div class="med-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}</div>
        @else
          <a href="{{ route('store.login.show') }}" class="text-xs text-teal-700 font-semibold underline">Login for price</a>
        @endif
      </div>

      @if(empty($hidePrices))
        <button type="button"
                class="med-btn-add js-add-to-cart"
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
          <x-store.icon name="cart" class="w-3.5 h-3.5" />
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Add' }}</span>
        </button>
      @endif
    </div>
    <div class="js-add-status med-add-status"></div>
  </div>
</article>
