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
@endphp

{{-- Scoped Auto Parts Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/auto_parts/auto_parts.css')) !!}
</style>

<div class="theme-auto-parts">

  {{-- ===== INDUSTRIAL PART FINDER HERO ===== --}}
  <section class="ap-hero">
    <div class="ap-container">
      <div class="ap-hero-grid">
        <div>
          <div class="ap-kicker">
            <x-store.icon name="shield-check" class="w-3.5 h-3.5" />
            <span>OEM & Aftermarket Auto Parts & Hardware Supply</span>
          </div>

          <h1 class="ap-hero-title">
            {{ $s->hero_title ?? 'Heavy-Duty Auto Parts & Industrial Hardware' }}
          </h1>

          <p class="ap-hero-sub">
            {{ $s->hero_subtitle ?? 'Direct catalog sourcing for automotive replacement components, workshop tooling, fasteners, and industrial mechanical supplies.' }}
          </p>

          {{-- Part Number / SKU Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="ap-search-box">
            <input type="text" name="q" placeholder="Enter Part#, SKU, GTIN or Keyword..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Find Part</span>
            </button>
          </form>

          <div class="ap-hero-actions">
            <a href="{{ route('store.shop') }}" class="ap-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Browse Parts Inventory</span>
            </a>
            <a href="{{ route('store.contact') }}" class="ap-btn-outline">
              <x-store.icon name="phone" class="w-4 h-4" />
              <span>Fleet & Workshop Accounts</span>
            </a>
          </div>
        </div>

        {{-- Part Specification & Warehouse Panel --}}
        <div>
          <div class="ap-spec-panel">
            <div class="ap-spec-header">
              <x-store.icon name="truck" class="w-4 h-4 text-amber-500" />
              <span>Parts Logistics & Distribution</span>
            </div>
            <div class="ap-spec-item">
              <span>Catalog Part Index</span>
              <strong>VERIFIED</strong>
            </div>
            <div class="ap-spec-item">
              <span>Warehouse Stock Sync</span>
              <strong style="color: #22c55e;">REAL-TIME</strong>
            </div>
            <div class="ap-spec-item">
              <span>Commercial Trade Invoicing</span>
              <strong>SUPPORTED</strong>
            </div>
            <div class="ap-spec-item">
              <span>Same-Day Depot Dispatch</span>
              <strong>ACTIVE</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="ap-section" style="padding-bottom: 0;">
      <div class="ap-container">
        <div class="ap-banner-grid">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ap-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ap-banner-img">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ap-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ap-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== HARDWARE CATEGORIES ===== --}}
  @if($categories->count())
    <section class="ap-section">
      <div class="ap-container">
        <div class="ap-sec-head">
          <div>
            <h2 class="ap-sec-title">
              <x-store.icon name="grid" class="w-5 h-5 text-amber-500" />
              <span>Part & Hardware Categories</span>
            </h2>
          </div>
          <a href="{{ route('store.shop') }}" class="ap-sec-link">
            <span>All Categories</span>
            <x-store.icon name="arrow-right" class="w-4 h-4" />
          </a>
        </div>

        <div class="ap-cat-grid">
          @foreach($categories->take(8) as $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="ap-cat-card">
              <div class="ap-cat-icon">⚙️</div>
              <div>
                <div class="ap-cat-name">{{ $cat->name }}</div>
                <div style="font-size: 0.75rem; color: var(--ap-text-muted);">
                  @if($cat->subcategories && $cat->subcategories->count())
                    {{ $cat->subcategories->count() }} Part Groups
                  @else
                    View Parts
                  @endif
                </div>
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Hardware');
      @endphp

      @if($products->count())
        <section class="ap-section" style="padding-top: 0;">
          <div class="ap-container">
            <div class="ap-sec-head">
              <h2 class="ap-sec-title">
                <x-store.icon name="package" class="w-5 h-5 text-amber-500" />
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="ap-sec-link">
                  <span>View Full List</span>
                  <x-store.icon name="arrow-right" class="w-4 h-4" />
                </a>
              @endif
            </div>

            <div class="ap-prod-grid">
              @foreach($products as $product)
                @include('store.themes.auto_parts.partials.product-card', [
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
    <section class="ap-section" style="padding-top: 0;">
      <div class="ap-container">
        <div class="ap-banner-grid">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ap-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ap-banner-img">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="ap-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="ap-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TRADE & FLEET SUPPLY CTA ===== --}}
  <section class="ap-section" style="padding-top: 0;">
    <div class="ap-container">
      <div class="ap-fleet-strip">
        <div>
          <h2 class="ap-fleet-title">Commercial Trade & Fleet Parts Supply</h2>
          <p class="ap-fleet-sub">
            Maintain your commercial vehicle fleet or workshop inventory with scheduled stock replenishment, volume trade pricing, and priority depot logistics.
          </p>
        </div>
        <a href="{{ route('store.contact') }}" class="ap-btn-primary" style="white-space: nowrap;">
          <x-store.icon name="phone" class="w-4 h-4" />
          <span>Contact Parts Desk</span>
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
