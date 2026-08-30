@extends('layouts.store')

@section('content')
@php
  $gallery = array_values(array_filter(array_merge([$product['image_url']], $product['gallery_urls'] ?? [])));
  if (empty($gallery)) { $gallery = [null]; }
@endphp

<div class="container py-3 text-xs text-fg-muted flex items-center gap-2">
  <a href="{{ route('store.index') }}" class="hover:text-accent-500">{{ __('messages.Home') }}</a> /
  <a href="{{ route('store.shop') }}" class="hover:text-accent-500">{{ __('messages.Shop') }}</a> /
  <span class="text-fg-secondary">{{ $product['name'] }}</span>
</div>

<div class="container py-6 grid lg:grid-cols-2 gap-10"
     x-data='{ variantIdx: 0, variants: @json($product["variants"], JSON_HEX_APOS | JSON_HEX_QUOT), gallery: @json($gallery, JSON_HEX_APOS | JSON_HEX_QUOT), activeImg: 0 }'>

  <div>
    <div class="aspect-square rounded-lg overflow-hidden bg-bg-elevated border border-line-subtle flex items-center justify-center">
      <template x-if="gallery[activeImg]">
        <img :src="gallery[activeImg]" class="w-full h-full object-cover" alt="{{ $product['name'] }}">
      </template>
      <template x-if="!gallery[activeImg]">
        <div class="text-6xl font-black opacity-30" style="color: {{ $product['placeholder_color'] }}">{{ strtoupper(substr($product['name'],0,1)) }}</div>
      </template>
    </div>
    @if(count($gallery) > 1)
      <div class="flex gap-2 mt-3">
        <template x-for="(img, i) in gallery" :key="i">
          <button type="button" @click="activeImg = i" class="w-16 h-16 rounded-md overflow-hidden border-2" :class="activeImg === i ? 'border-accent-500' : 'border-line-subtle'">
            <img :src="img" class="w-full h-full object-cover">
          </button>
        </template>
      </div>
    @endif
  </div>

  <div>
    @if($product['brand_name'])
      <span class="text-xs font-semibold text-accent-500 uppercase">{{ $product['brand_name'] }}</span>
    @endif
    <h1 class="text-2xl lg:text-3xl font-bold mt-1">{{ $product['name'] }}</h1>
    <div class="text-xs text-fg-muted mt-1">SKU: {{ $product['sku'] }}</div>

    @if(!$product['hide_prices'])
      <div class="flex items-baseline gap-2 mt-4">
        <span class="text-3xl font-bold font-mono" x-show="!variants.length" x-text="'{{ $product['final_price_formatted'] }}'"></span>
        <template x-if="variants.length">
          <span class="text-3xl font-bold font-mono" x-text="variants[variantIdx].display_price_formatted"></span>
        </template>
        @if($product['compare_at_price_formatted'])
          <span class="text-base text-fg-muted line-through">{{ $product['compare_at_price_formatted'] }}</span>
        @endif
      </div>
    @else
      <a href="{{ route('store.login.show') }}" class="block mt-4 text-accent-500 font-semibold underline">{{ __('messages.SignIn') }}</a>
    @endif

    @if(count($product['variants']))
      <div class="mt-5">
        <div class="text-xs font-bold uppercase text-fg-muted mb-2">{{ __('messages.Variant') ?? 'Options' }}</div>
        <div class="flex flex-wrap gap-2">
          <template x-for="(v, i) in variants" :key="v.id">
            <button type="button" @click="variantIdx = i" class="btn btn-sm" :class="variantIdx === i ? 'btn-primary' : 'btn-secondary'" x-text="v.name"></button>
          </template>
        </div>
      </div>
    @endif

    <div class="mt-4 flex items-center gap-2 text-sm">
      <span class="stock-dot {{ $product['stock_status'] === 'out_of_stock' ? 'stock-dot-out' : ($product['stock_status'] === 'low_stock' ? 'stock-dot-warn' : 'stock-dot-ok') }}"></span>
      <span>
        @if($product['stock_status'] === 'in_stock') {{ __('messages.InStock') }}
        @elseif($product['stock_status'] === 'low_stock') {{ __('messages.X_in_stock', ['count' => $product['stock']]) }}
        @elseif($product['stock_status'] === 'preorder') {{ __('messages.PreorderAvailable') }}
        @else {{ __('messages.OutOfStock') }}
        @endif
      </span>
    </div>

    @if(!$product['hide_prices'])
      <div class="mt-6 flex gap-3">
        <div class="flex items-center border border-line-subtle rounded-md h-11">
          <button type="button" class="w-9 h-full text-fg-muted" onclick="const i=document.getElementById('gp-qty'); i.value = Math.max(1, parseInt(i.value||1)-1)">−</button>
          <input id="gp-qty" type="number" value="1" min="1" class="w-12 text-center h-full border-x border-line-subtle bg-transparent">
          <button type="button" class="w-9 h-full text-fg-muted" onclick="const i=document.getElementById('gp-qty'); i.value = parseInt(i.value||1)+1">+</button>
        </div>
        <button type="button"
                class="js-add-to-cart product-card btn btn-primary flex-1 h-11"
                @if(!$product['is_available']) disabled @endif
                data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                data-id="{{ $product['id'] }}"
                data-slug="{{ $product['slug'] }}"
                data-name="{{ e($product['name']) }}"
                :data-price="variants.length ? variants[variantIdx].price : {{ $product['final_price'] }}"
                data-image="{{ $product['image_url'] }}"
                data-currency="{{ $product['currency'] }}"
                x-bind:data-qty="document.getElementById('gp-qty') ? document.getElementById('gp-qty').value : 1"
                data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                data-added-label="{{ __('messages.Added') }}">
          <x-store.icon name="cart" class="w-4 h-4" />
          {{ $product['is_preorder_active'] ? __('messages.PreOrderNow') : __('messages.AddToCart') }}
        </button>
      </div>
      <div class="js-add-status text-xs text-fg-muted mt-2"></div>
    @endif

    @if($product['warranty_text'])
      <div class="mt-6 flex items-center gap-2 text-sm text-fg-secondary">
        <x-store.icon name="shield-check" class="w-5 h-5 text-success" />
        {{ $product['warranty_text'] }}
      </div>
    @endif

    @if($product['description'])
      <div class="mt-8 pt-6 border-t border-line-subtle">
        <h3 class="text-sm font-bold uppercase text-fg-muted mb-2">{{ __('messages.Description') }}</h3>
        <p class="text-sm text-fg-secondary leading-relaxed">{{ $product['description'] }}</p>
      </div>
    @endif
  </div>
</div>

@if(count($related))
  <section class="container py-10 border-t border-line-subtle">
    <h2 class="section-title mb-5">{{ __('messages.RelatedProducts') ?? 'You may also like' }}</h2>
    <div class="store-product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      @foreach($related as $rp)
        <article class="product-card">
          <a href="{{ $rp['url'] }}" class="product-media">
            @if($rp['image_url'])
              <img src="{{ $rp['image_url'] }}" alt="{{ $rp['name'] }}" loading="lazy">
            @else
              <div class="w-full h-full flex items-center justify-center text-2xl font-black opacity-30" style="color:{{ $rp['placeholder_color'] }}">{{ strtoupper(substr($rp['name'],0,1)) }}</div>
            @endif
          </a>
          <div class="product-body">
            <h3 class="product-title"><a href="{{ $rp['url'] }}">{{ $rp['name'] }}</a></h3>
            @if(!$rp['hide_prices'])
              <div class="price">{{ $rp['final_price_formatted'] }}</div>
            @endif
          </div>
        </article>
      @endforeach
    </div>
  </section>
@endif
@endsection
