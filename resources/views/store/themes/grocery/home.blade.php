@extends('layouts.store')

@section('content')

@php
  /** @var \App\Models\StoreSetting $s */
  $currency = $s->currency_code ?? '$';
  $categories = collect($categories ?? []);
  $blocks = collect($blocks ?? []);
  $banners = collect($banners ?? []);
  $byPos = $banners->groupBy('position');

  $bannerUrl = function ($banner) {
      if (!empty($banner->image_url)) {
          return $banner->image_url;
      }
      if (!empty($banner->image)) {
          return global_asset($banner->image);
      }
      return global_asset(upload_path('banners') . '/no-image.png');
  };

  $catEmojis = ['🍎', '🥦', '🥛', '🥖', '🥩', '🍹', '🍪', '🧼', '🧀', '🍗', '🍊', '🛒'];
@endphp

{{-- Scoped Grocery Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/grocery/grocery.css')) !!}
</style>

<div class="theme-grocery">

  {{-- ===== FRESH GROCERY HERO ===== --}}
  <section class="groc-hero">
    <div class="groc-container">
      <div class="groc-hero-grid">
        <div>
          <div class="groc-kicker">
            <x-store.icon name="truck" class="w-4 h-4" />
            <span>Fresh Supermarket & Daily Essentials</span>
          </div>

          <h1 class="groc-hero-title">
            {{ $s->hero_title ?? 'Fresh Groceries Delivered Daily' }}
          </h1>

          <p class="groc-hero-sub">
            {{ $s->hero_subtitle ?? 'Explore farm-fresh produce, dairy, bakery favorites, and daily home essentials delivered straight to your door.' }}
          </p>

          {{-- Grocery Search Bar --}}
          <form action="{{ route('store.shop') }}" method="GET" class="groc-hero-search">
            <input type="text" name="q" placeholder="Search vegetables, fruits, snacks, dairy..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search</span>
            </button>
          </form>
        </div>

        {{-- Grocery Trust Badges --}}
        <div>
          <div class="groc-perks-card">
            <div class="groc-perk-row">
              <div class="groc-perk-icon">⚡</div>
              <div>
                <div class="groc-perk-title">Fast Express Delivery</div>
                <div class="groc-perk-sub">Direct delivery from our local warehouse</div>
              </div>
            </div>
            <div class="groc-perk-row">
              <div class="groc-perk-icon">🌿</div>
              <div>
                <div class="groc-perk-title">Freshness Guaranteed</div>
                <div class="groc-perk-sub">Carefully selected items and clean packing</div>
              </div>
            </div>
            <div class="groc-perk-row">
              <div class="groc-perk-icon">🏷️</div>
              <div>
                <div class="groc-perk-title">Everyday Supermarket Value</div>
                <div class="groc-perk-sub">Unbeatable shelf pricing & bulk bundle offers</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== QUICK CATEGORY RAIL ===== --}}
  @if($categories->count())
    <section class="groc-cat-rail-sec">
      <div class="groc-container">
        <div class="groc-cat-rail-head">
          <div class="groc-cat-rail-title">
            <span>Explore Aisles</span>
          </div>
          <a href="{{ route('store.shop') }}" class="groc-sec-link">
            <span>All Aisles</span>
            <x-store.icon name="arrow-right" class="w-4 h-4" />
          </a>
        </div>

        <div class="groc-cat-rail">
          @foreach($categories->take(10) as $idx => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="groc-cat-pill">
              <div class="groc-cat-icon-box">
                {{ $catEmojis[$idx % count($catEmojis)] }}
              </div>
              <div class="groc-cat-pill-name">{{ $cat->name }}</div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="groc-section" style="padding-top: 0; padding-bottom: 1.5rem;">
      <div class="groc-container">
        <div class="groc-banner-grid">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="groc-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="groc-banner-img">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="groc-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="groc-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== CONTENT BLOCKS (Collections & Lineups) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Fresh Selections');
      @endphp

      @if($products->count())
        <section class="groc-section" style="padding-top: 0;">
          <div class="groc-container">
            <div class="groc-sec-head">
              <h2 class="groc-sec-title">
                <span>🛒</span>
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="groc-sec-link">
                  <span>See all</span>
                  <x-store.icon name="arrow-right" class="w-4 h-4" />
                </a>
              @endif
            </div>

            <div class="groc-prod-grid">
              @foreach($products as $product)
                @include('store.themes.grocery.partials.product-card', [
                  'p' => $product,
                  'currency' => $currency
                ])
              @endforeach
            </div>
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== CENTER BANNERS ===== --}}
  @if(($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count())
    <section class="groc-section" style="padding-top: 0;">
      <div class="groc-container">
        <div class="groc-banner-grid">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="groc-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="groc-banner-img">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="groc-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="groc-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

</div>

{{-- Shared QuickView, Variant Picker, Cart, and Toast scripts --}}
@include('store.partials.home-modals-scripts', [
  'currency' => $currency,
  'nlBtn' => __('messages.Subscribe')
])

@endsection
