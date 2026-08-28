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

{{-- Scoped Digital Products Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/digital_products/digital_products.css')) !!}
</style>

<div class="theme-digital-products">

  {{-- ===== DIGITAL SHOWCASE HERO ===== --}}
  <section class="digi-hero">
    <div class="digi-container">
      <div class="digi-hero-grid">
        <div>
          <div class="digi-kicker">
            <x-store.icon name="shield-check" class="w-3.5 h-3.5" />
            <span>Digital Marketplace & Software Hub</span>
          </div>

          <h1 class="digi-hero-title">
            {{ $s->hero_title ?? 'Premium Software & Digital Products' }}
          </h1>

          <p class="digi-hero-sub">
            {{ $s->hero_subtitle ?? 'Instant license delivery for professional software, development tools, digital assets, templates, and enterprise digital solutions.' }}
          </p>

          {{-- Digital Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="digi-search-box">
            <input type="text" name="q" placeholder="Search software, digital assets, license editions..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search Digital</span>
            </button>
          </form>

          <div class="digi-hero-actions">
            <a href="{{ route('store.shop') }}" class="digi-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Explore Digital Catalog</span>
            </a>
            <a href="{{ route('store.contact') }}" class="digi-btn-outline">
              <x-store.icon name="mail" class="w-4 h-4" />
              <span>Custom Licensing Inquiries</span>
            </a>
          </div>
        </div>

        {{-- Digital License Assurance Card --}}
        <div>
          <div class="digi-license-panel">
            <div class="digi-license-head">
              <x-store.icon name="shield-check" class="w-5 h-5 text-purple-400" />
              <span>Digital Delivery Guarantee</span>
            </div>
            <div class="digi-feature-list">
              <div class="digi-feature-item">
                <span>License Key Generation</span>
                <strong style="color: #a78bfa;">INSTANT</strong>
              </div>
              <div class="digi-feature-item">
                <span>Code Integrity & Safety</span>
                <strong style="color: #34d399;">100% VERIFIED</strong>
              </div>
              <div class="digi-feature-item">
                <span>Commercial Usage Rights</span>
                <strong>INCLUDED</strong>
              </div>
              <div class="digi-feature-item">
                <span>Direct Customer Support</span>
                <strong>24/7 ACCESS</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="digi-section" style="padding-bottom: 0;">
      <div class="digi-container">
        <div class="digi-banner-grid">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="digi-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="digi-banner-img">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="digi-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="digi-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== DIGITAL CATEGORIES ===== --}}
  @if($categories->count())
    <section class="digi-section">
      <div class="digi-container">
        <div class="digi-sec-head">
          <div>
            <h2 class="digi-sec-title">
              <x-store.icon name="grid" class="w-5 h-5 text-purple-400" />
              <span>Digital Categories</span>
            </h2>
          </div>
          <a href="{{ route('store.shop') }}" class="digi-sec-link">
            <span>All Categories</span>
            <x-store.icon name="arrow-right" class="w-4 h-4" />
          </a>
        </div>

        <div class="digi-cat-grid">
          @foreach($categories->take(8) as $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="digi-cat-card">
              <div class="digi-cat-icon">💾</div>
              <div>
                <div class="digi-cat-name">{{ $cat->name }}</div>
                <div style="font-size: 0.75rem; color: var(--digi-text-muted);">
                  @if($cat->subcategories && $cat->subcategories->count())
                    {{ $cat->subcategories->count() }} Sub-categories
                  @else
                    Browse Assets &rarr;
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Software Showcase');
      @endphp

      @if($products->count())
        <section class="digi-section" style="padding-top: 0;">
          <div class="digi-container">
            <div class="digi-sec-head">
              <h2 class="digi-sec-title">
                <x-store.icon name="shield-check" class="w-5 h-5 text-purple-400" />
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="digi-sec-link">
                  <span>View All</span>
                  <x-store.icon name="arrow-right" class="w-4 h-4" />
                </a>
              @endif
            </div>

            <div class="digi-prod-grid">
              @foreach($products as $product)
                @include('store.themes.digital_products.partials.product-card', [
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
    <section class="digi-section" style="padding-top: 0;">
      <div class="digi-container">
        <div class="digi-banner-grid">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="digi-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="digi-banner-img">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="digi-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="digi-banner-img">
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
