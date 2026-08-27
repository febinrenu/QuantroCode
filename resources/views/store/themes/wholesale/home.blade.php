@extends('layouts.store')

@section('content')

@php
  /** @var \App\Models\StoreSetting $s */
  $currency = $s->currency_code ?? '$';
  $categories = collect($categories ?? []);
  $blocks = collect($blocks ?? []);
  $banners = collect($banners ?? []);
  $byPos = $banners->groupBy('position');
  $printedCenter = false;

  $bannerUrl = function ($banner) {
      if (!empty($banner->image_url)) {
          return $banner->image_url;
      }
      if (!empty($banner->image)) {
          return global_asset($banner->image);
      }
      return global_asset(upload_path('banners') . '/no-image.png');
  };
@endphp

{{-- Scoped Wholesale Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/wholesale/wholesale.css')) !!}
</style>

<div class="theme-wholesale">

  {{-- ===== HERO PROCUREMENT BANNER ===== --}}
  <section class="ws-hero">
    <div class="ws-container">
      <div class="ws-hero-grid">
        <div>
          <div class="ws-kicker">
            <x-store.icon name="shield-check" class="w-3.5 h-3.5" />
            <span>B2B & Wholesale Purchasing Portal</span>
          </div>

          <h1 class="ws-hero-title">
            {{ $s->hero_title ?? 'Commercial Procurement & Bulk Supplies' }}
          </h1>

          <p class="ws-hero-sub">
            {{ $s->hero_subtitle ?? 'Direct wholesale pricing, real-time inventory visibility, and high-volume order processing for enterprise buyers.' }}
          </p>

          {{-- Quick SKU / Product Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="ws-hero-search">
            <input type="text" name="q" placeholder="Enter Product Name, SKU or Part Code..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search Catalog</span>
            </button>
          </form>

          <div class="ws-quick-actions">
            <a href="{{ route('store.shop') }}" class="ws-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Browse Full Catalog</span>
            </a>
            <a href="{{ route('store.contact') }}" class="ws-btn-outline">
              <x-store.icon name="mail" class="w-4 h-4" />
              <span>Request Quote / Net Terms</span>
            </a>
          </div>
        </div>

        {{-- Procurement Live Stats Panel --}}
        <div>
          <div class="ws-procure-card">
            <div class="ws-procure-header">
              <div class="ws-procure-title">
                <x-store.icon name="package" class="w-4 h-4 text-accent-400" />
                <span>Procurement Engine</span>
              </div>
              <span class="ws-procure-badge">ACTIVE PORTAL</span>
            </div>

            <div class="ws-procure-list">
              <div class="ws-procure-item">
                <span>Direct Warehouse Dispatch</span>
                <strong>24-48 HR</strong>
              </div>
              <div class="ws-procure-item">
                <span>Tiered Volume Pricing</span>
                <strong>SUPPORTED</strong>
              </div>
              <div class="ws-procure-item">
                <span>Catalog SKU Search</span>
                <strong>INDEXED</strong>
              </div>
              <div class="ws-procure-item">
                <span>Minimum Order Quantity</span>
                <strong>FLEXIBLE</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="ws-section" style="padding-bottom: 0;">
      <div class="ws-container">
        <div class="ws-banner-grid">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ws-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ws-banner-img">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ws-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ws-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== CATEGORY MATRIX ===== --}}
  @if($categories->count())
    <section class="ws-section">
      <div class="ws-container">
        <div class="ws-section-head">
          <div>
            <h2 class="ws-section-title">Procurement Categories</h2>
            <div class="ws-section-sub">Browse commercial inventory segmented by industry category</div>
          </div>
          <a href="{{ route('store.shop') }}" class="ws-section-link">
            <span>View All Categories</span>
            <x-store.icon name="arrow-right" class="w-4 h-4" />
          </a>
        </div>

        <div class="ws-cat-grid">
          @foreach($categories->take(8) as $index => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="ws-cat-card">
              <div>
                <span class="ws-cat-code">CAT-{{ str_pad($cat->id, 2, '0', STR_PAD_LEFT) }}</span>
                <div class="ws-cat-name">{{ $cat->name }}</div>
              </div>
              <div class="ws-cat-sub">
                @if($cat->subcategories && $cat->subcategories->count())
                  {{ $cat->subcategories->count() }} Sub-departments
                @else
                  Explore Products &rarr;
                @endif
              </div>
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Commercial Lineup');
      @endphp

      @if($products->count())
        <section class="ws-section" style="padding-top: 0;">
          <div class="ws-container">
            <div class="ws-section-head">
              <div>
                <h2 class="ws-section-title">{{ $colTitle }}</h2>
                <div class="ws-section-sub">Live stock status, unit rates, and bulk quantity controls</div>
              </div>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="ws-section-link">
                  <span>View All in Collection</span>
                  <x-store.icon name="arrow-right" class="w-4 h-4" />
                </a>
              @endif
            </div>

            <div class="ws-prod-grid">
              @foreach($products as $product)
                @include('store.themes.wholesale.partials.product-card', [
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
    <section class="ws-section" style="padding-top: 0;">
      <div class="ws-container">
        <div class="ws-banner-grid">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ws-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ws-banner-img">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ws-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ws-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== BUSINESS CTA STRIP ===== --}}
  <section class="ws-section" style="padding-top: 0;">
    <div class="ws-container">
      <div class="ws-bulk-strip">
        <div>
          <h2 class="ws-bulk-title">Require Custom Commercial Terms or Pallet Orders?</h2>
          <p class="ws-bulk-copy">
            Our B2B procurement specialists provide volume-based discounts, recurring supply agreements, and tax-exempt invoicing for registered business accounts.
          </p>
        </div>
        <a href="{{ route('store.contact') }}" class="ws-btn-primary" style="white-space: nowrap;">
          <x-store.icon name="phone" class="w-4 h-4" />
          <span>Contact Wholesale Team</span>
        </a>
      </div>
    </div>
  </section>

</div>

{{-- Shared QuickView, Variant Picker, Cart, and Toast scripts --}}
@include('store.partials.home-modals-scripts', [
  'currency' => $currency,
  'nlBtn' => __('messages.Subscribe')
])

@endsection
