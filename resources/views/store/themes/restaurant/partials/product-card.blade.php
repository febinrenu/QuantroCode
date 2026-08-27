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
  $descShort = \Illuminate\Support\Str::limit(strip_tags($p->note ?? ''), 250);
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
@endphp

<article class="dish-card product-card" x-data="{ dishQty: 1 }">
  <div class="dish-body product-body">
    <div class="dish-meta">
      @if($p->category)
        <span class="dish-cat">{{ $p->category->name }}</span>
      @endif
      @if($variants->isNotEmpty())
        <span class="dish-options-badge">{{ $variants->count() }} Options</span>
      @endif
    </div>

    <h3 class="dish-title product-title" title="{{ $p->name }}">
      {{ $p->name }}
    </h3>

    @if($descShort)
      <p class="dish-desc">{{ \Illuminate\Support\Str::limit($descShort, 85) }}</p>
    @endif

    <div class="dish-price-action">
      <div class="dish-price font-mono price">
        @if(empty($hidePrices))
          {{ $currency }}{{ number_format($minPrice, 2, '.', ',') }}
          @if($unitName)<span class="dish-unit">/ {{ $unitName }}</span>@endif
        @else
          <a href="{{ route('store.login.show') }}" class="text-xs text-rose-600 font-semibold underline">Sign in</a>
        @endif
      </div>

      @if(empty($hidePrices))
        <div class="dish-ctrls">
          <div class="dish-stepper">
            <button type="button" class="dish-step-btn" @click="dishQty = Math.max(1, dishQty - 1)" aria-label="Decrease quantity">−</button>
            <input type="number" class="dish-qty-val font-mono" x-model.number="dishQty" min="1" max="99" @change="dishQty = Math.max(1, parseInt($event.target.value) || 1)">
            <button type="button" class="dish-step-btn" @click="dishQty = dishQty + 1" aria-label="Increase quantity">+</button>
          </div>

          <button type="button"
                  class="dish-btn-add js-add-to-cart"
                  @if(!$isAvailable) disabled @endif
                  :data-qty="dishQty"
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
        </div>
      @endif
    </div>
    <div class="js-add-status dish-add-status"></div>
  </div>

  <div class="dish-thumb-wrap">
    <a href="#" class="dish-thumb-link js-quick-view"
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
      <img src="{{ $imgUrl }}" alt="{{ $p->name }}" loading="lazy" class="dish-thumb-img">
    </a>

    @if(!$isAvailable)
      <span class="dish-badge-out">Sold Out</span>
    @elseif($isPreorderActive)
      <span class="dish-badge-pre">Pre-Order</span>
    @endif
  </div>
</article>
