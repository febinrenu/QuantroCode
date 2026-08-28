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

  $authorName = $p->brand?->name ?? null;
  $isbn = $p->code ?: null;
@endphp

<article class="book-card product-card" :class="{ 'book-card-list': viewMode === 'list' }">
  <div class="book-cover-wrap">
    <a href="#" class="book-cover-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="book-cover-img">
    </a>

    @if($isPreorderActive)
      <span class="book-badge-pre">{{ __('messages.PreOrder') }}</span>
    @elseif(!$isAvailable)
      <span class="book-badge-out">{{ __('messages.OutOfStock') }}</span>
    @endif

    <button type="button" class="book-synopsis-btn js-quick-view"
            title="Read Synopsis & Details"
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
      <x-store.icon name="eye" class="w-3.5 h-3.5" /> Synopsis
    </button>
  </div>

  <div class="book-info product-body">
    @if($p->category)
      <span class="book-genre">{{ $p->category->name }}</span>
    @endif

    <h3 class="book-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    @if($authorName)
      <div class="book-author">By <span>{{ $authorName }}</span></div>
    @endif

    @if($isbn)
      <div class="book-isbn font-mono">ISBN/SKU: {{ $isbn }}</div>
    @endif

    @if($descShort)
      <p class="book-excerpt">{{ \Illuminate\Support\Str::limit($descShort, 100) }}</p>
    @endif

    @if($variants->isNotEmpty())
      <div class="book-editions-tag">{{ $variants->count() }} Editions Available</div>
    @endif

    <div class="book-bottom-row">
      <div class="book-price-box">
        @if(empty($hidePrices))
          <div class="book-price font-mono price">{{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}</div>
        @else
          <a href="{{ route('store.login.show') }}" class="text-xs text-amber-800 font-serif underline">Member price</a>
        @endif
      </div>

      @if(empty($hidePrices))
        <button type="button"
                class="book-btn-add js-add-to-cart"
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
          <span>{{ $isPreorderActive ? __('messages.PreOrder') : 'Add to Shelf' }}</span>
        </button>
      @endif
    </div>
    <div class="js-add-status book-add-status"></div>
  </div>
</article>
