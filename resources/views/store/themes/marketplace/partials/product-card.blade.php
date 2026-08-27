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

  $hasDiscount = !empty($p->discount) && (float)$p->discount > 0;
  $discMethod = (string)($p->discount_method ?? '1');
  $brandName = $p->brand?->name ?? null;
@endphp

<article class="mp-card product-card">
  <div class="mp-badge-stack">
    @if($hasDiscount)
      <span class="mp-badge-deal">
        {{ $discMethod === '1' ? rtrim(rtrim(number_format($p->discount, 1), '0'), '.') . '% OFF' : 'DEAL' }}
      </span>
    @elseif($isPreorderActive)
      <span class="mp-badge-pre">{{ __('messages.PreOrder') }}</span>
    @elseif(!$isAvailable)
      <span class="mp-badge-out">{{ __('messages.OutOfStock') }}</span>
    @endif
  </div>

  <div class="mp-media">
    <a href="#" class="mp-img-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="mp-img">
    </a>

    <button type="button" class="mp-quick-btn js-quick-view"
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
      <x-store.icon name="eye" class="w-3.5 h-3.5" />
    </button>
  </div>

  <div class="mp-body product-body">
    <div class="mp-meta-row">
      @if($brandName)
        <span class="mp-brand">{{ $brandName }}</span>
      @elseif($p->category)
        <span class="mp-cat">{{ $p->category->name }}</span>
      @endif
      <span class="mp-rating">★ 4.8</span>
    </div>

    <h3 class="mp-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    <div class="mp-price-row">
      @if(empty($hidePrices))
        <div class="mp-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}</div>
      @else
        <a href="{{ route('store.login.show') }}" class="text-xs text-blue-600 font-bold underline">Login for price</a>
      @endif
    </div>

    <div class="mp-shipping-tag">
      <span class="mp-fast-dot"></span> Express Delivery Eligible
    </div>

    @if(empty($hidePrices))
      <div class="mp-action-row">
        <button type="button"
                class="mp-btn-add js-add-to-cart"
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
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Add to Cart' }}</span>
        </button>
      </div>
    @endif
    <div class="js-add-status mp-add-status"></div>
  </div>
</article>
