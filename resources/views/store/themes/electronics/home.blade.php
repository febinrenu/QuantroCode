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

{{-- Scoped Electronics Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/electronics/electronics.css')) !!}
</style>

<div class="theme-electronics">

  {{-- ===== CYBER TECH HERO SHOWCASE ===== --}}
  <section class="tech-hero">
    <div class="tech-container">
      <div class="tech-hero-grid">
        <div>
          <div class="tech-chip-badge">
            <x-store.icon name="lightning" class="w-3.5 h-3.5" />
            <span>Next-Gen Hardware & Consumer Electronics</span>
          </div>

          <h1 class="tech-hero-title">
            {{ $s->hero_title ?? 'Cutting-Edge Electronics & Gadgets' }}
          </h1>

          <p class="tech-hero-sub">
            {{ $s->hero_subtitle ?? 'Discover high-performance computing, smart devices, audio equipment, and authentic electronics with verified manufacturer warranty.' }}
          </p>

          {{-- Tech Search Bar --}}
          <form action="{{ route('store.shop') }}" method="GET" class="tech-search-bar">
            <input type="text" name="q" placeholder="Search devices, model number, specifications..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search Tech</span>
            </button>
          </form>

          <div class="tech-hero-btns">
            <a href="{{ route('store.shop') }}" class="tech-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Explore Tech Catalog</span>
            </a>
            <a href="{{ route('store.contact') }}" class="tech-btn-ghost">
              <x-store.icon name="shield-check" class="w-4 h-4" />
              <span>Warranty & Support</span>
            </a>
          </div>
        </div>

        {{-- Spec & Assurance Matrix --}}
        <div>
          <div class="tech-specs-card">
            <div style="font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.4rem;">
              <x-store.icon name="shield-check" class="w-4 h-4 text-cyan-400" />
              <span>Verified Hardware Specs</span>
            </div>
            <div class="tech-spec-row">
              <span>Authentic Sourcing</span>
              <strong style="color: #38bdf8;">100% GENUINE</strong>
            </div>
            <div class="tech-spec-row">
              <span>Manufacturer Warranty</span>
              <strong style="color: #34d399;">INCLUDED</strong>
            </div>
            <div class="tech-spec-row">
              <span>Global Voltage / Standard</span>
              <strong>COMPATIBLE</strong>
            </div>
            <div class="tech-spec-row">
              <span>Express Secure Shipping</span>
              <strong>TRACKED</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== TOP TECH BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="tech-section" style="padding-bottom: 0;">
      <div class="tech-container">
        <div class="tech-banner-grid">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="tech-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="tech-banner-img">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="tech-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="tech-banner-img">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TECH CATEGORIES ===== --}}
  @if($categories->count())
    <section class="tech-section">
      <div class="tech-container">
        <div class="tech-sec-head">
          <div>
            <h2 class="tech-sec-title">
              <x-store.icon name="grid" class="w-5 h-5 text-cyan-400" />
              <span>Technology Categories</span>
            </h2>
          </div>
          <a href="{{ route('store.shop') }}" class="tech-sec-link">
            <span>All Categories</span>
            <x-store.icon name="arrow-right" class="w-4 h-4" />
          </a>
        </div>

        <div class="tech-cat-grid">
          @foreach($categories->take(8) as $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="tech-cat-card">
              <div class="tech-cat-icon">⚡</div>
              <div>
                <div class="tech-cat-name">{{ $cat->name }}</div>
                <div style="font-size: 0.75rem; color: var(--tech-text-muted);">
                  @if($cat->subcategories && $cat->subcategories->count())
                    {{ $cat->subcategories->count() }} Subcategories
                  @else
                    View Hardware
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Hardware Showcase');
      @endphp

      @if($products->count())
        <section class="tech-section" style="padding-top: 0;">
          <div class="tech-container">
            <div class="tech-sec-head">
              <h2 class="tech-sec-title">
                <x-store.icon name="lightning" class="w-5 h-5 text-cyan-400" />
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="tech-sec-link">
                  <span>View All</span>
                  <x-store.icon name="arrow-right" class="w-4 h-4" />
                </a>
              @endif
            </div>

            <div class="tech-prod-grid">
              @foreach($products as $product)
                @include('store.themes.electronics.partials.product-card', [
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
    <section class="tech-section" style="padding-top: 0;">
      <div class="tech-container">
        <div class="tech-banner-grid">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="tech-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="tech-banner-img">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" class="tech-banner-card">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" class="tech-banner-img">
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
