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

{{-- Scoped Marketplace Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/marketplace/marketplace.css')) !!}
</style>

<div class="theme-marketplace">

  {{-- ===== MEGA-STORE HERO & DEPARTMENT SIDEBAR ===== --}}
  <section class="mp-hero">
    <div class="mp-container">
      <div class="mp-hero-grid">

        {{-- Department Mega-List Sidebar --}}
        <div>
          <div class="mp-dept-card">
            <div class="mp-dept-head">
              <x-store.icon name="menu" class="w-4 h-4" />
              <span>All Departments</span>
            </div>
            <div class="mp-dept-list">
              @foreach($categories->take(7) as $cat)
                <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="mp-dept-item">
                  <span>{{ $cat->name }}</span>
                  <span class="mp-dept-count">
                    @if($cat->subcategories && $cat->subcategories->count())
                      {{ $cat->subcategories->count() }} &rsaquo;
                    @else
                      &rsaquo;
                    @endif
                  </span>
                </a>
              @endforeach
              @if($categories->count() > 7)
                <a href="{{ route('store.shop') }}" class="mp-dept-item" style="color: var(--mp-link); font-weight: 700; border-top: 1px solid #f1f5f9;">
                  <span>See All {{ $categories->count() }} Categories</span>
                  <span>&rarr;</span>
                </a>
              @endif
            </div>
          </div>
        </div>

        {{-- Marketplace Hero Showcase --}}
        <div>
          <div class="mp-hero-showcase">
            <div class="mp-kicker">
              <x-store.icon name="lightning" class="w-3.5 h-3.5" />
              <span>Mega Marketplace & Direct Retail Hub</span>
            </div>

            <h1 class="mp-hero-title">
              {{ $s->hero_title ?? 'Millions of Products at Everyday Low Prices' }}
            </h1>

            <p class="mp-hero-sub">
              {{ $s->hero_subtitle ?? 'Explore verified marketplace sellers, daily mega deals, fast tracked delivery, and endless inventory across all major categories.' }}
            </p>

            {{-- Mega Search Bar --}}
            <form action="{{ route('store.shop') }}" method="GET" class="mp-search-bar">
              <input type="text" name="q" placeholder="Search across all departments..." autocomplete="off">
              <button type="submit">
                <x-store.icon name="search" class="w-4 h-4" />
                <span>Search</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ===== DEAL OF THE DAY STRIP ===== --}}
  <div class="mp-container" style="margin-top: 1.5rem;">
    <div class="mp-deal-strip">
      <div class="mp-deal-title">
        <span class="mp-deal-pill">TODAY'S DEALS</span>
        <span>Featured Marketplace Value & Clearance</span>
      </div>
      <a href="{{ route('store.shop') }}" class="mp-deal-link">
        <span>Explore all deals &rarr;</span>
      </a>
    </div>
  </div>

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <div class="mp-container" style="margin-bottom: 1.5rem;">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
        @foreach($byPos['top_left'] ?? collect() as $banner)
          <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 8px; overflow: hidden;">
            <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
          </a>
        @endforeach
        @foreach($byPos['top_right'] ?? collect() as $banner)
          <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 8px; overflow: hidden;">
            <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
          </a>
        @endforeach
      </div>
    </div>
  @endif

  {{-- ===== CONTENT BLOCKS (Collections & High-Density Lineups) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Marketplace Showcase');
      @endphp

      @if($products->count())
        <section class="mp-section">
          <div class="mp-container">
            <div class="mp-sec-box">
              <div class="mp-sec-head">
                <h2 class="mp-sec-title">{{ $colTitle }}</h2>
                @if($collection && $collection->slug)
                  <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" class="mp-sec-link">
                    See more &rarr;
                  </a>
                @endif
              </div>

              <div class="mp-prod-grid">
                @foreach($products as $product)
                  @include('store.themes.marketplace.partials.product-card', [
                    'p' => $product,
                    'currency' => $currency
                  ])
                @endforeach
              </div>
            </div>
          </div>
        </section>
      @endif
    @endif
  @endforeach

  {{-- ===== CENTER BANNERS ===== --}}
  @if(($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count())
    <div class="mp-container" style="margin-bottom: 2rem;">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
        @foreach($byPos['center_left'] ?? collect() as $banner)
          <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 8px; overflow: hidden;">
            <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
          </a>
        @endforeach
        @foreach($byPos['center_right'] ?? collect() as $banner)
          <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 8px; overflow: hidden;">
            <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
          </a>
        @endforeach
      </div>
    </div>
  @endif

</div>

{{-- Shared QuickView, Variant Picker, Cart, and Toast scripts --}}
@include('store.partials.home-modals-scripts', [
  'currency' => $currency,
  'nlBtn' => __('messages.Subscribe')
])

@endsection
