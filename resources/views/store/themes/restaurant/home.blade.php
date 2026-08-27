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

  $dishEmojis = ['🍕', '🍔', '🥗', '🍣', '🍜', '🌮', '🥩', '🍰', '☕', '🍹'];
@endphp

{{-- Scoped Restaurant Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/restaurant/restaurant.css')) !!}
</style>

<div class="theme-restaurant">

  {{-- ===== BISTRO & DELIVERY HERO ===== --}}
  <section class="res-hero">
    <div class="res-container">
      <div class="res-hero-grid">
        <div>
          <div class="res-kicker">
            <x-store.icon name="truck" class="w-3.5 h-3.5" />
            <span>Artisan Kitchen & Direct Delivery</span>
          </div>

          <h1 class="res-hero-title">
            {{ $s->hero_title ?? 'Freshly Prepared Dishes & Culinary Favorites' }}
          </h1>

          <p class="res-hero-sub">
            {{ $s->hero_subtitle ?? 'Explore our handcrafted menu, signature specials, and freshly prepared meals delivered hot and fast to your table.' }}
          </p>

          {{-- Food Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="res-search-box">
            <input type="text" name="q" placeholder="Search dishes, drinks, specials..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search</span>
            </button>
          </form>
        </div>

        {{-- Kitchen Live Info Card --}}
        <div>
          <div class="res-info-card">
            <div class="res-info-row">
              <div class="res-info-icon">⏱️</div>
              <div>
                <div class="res-info-lbl">Est. Preparation Time</div>
                <div class="res-info-val">20 – 35 Mins</div>
              </div>
            </div>
            <div class="res-info-row">
              <div class="res-info-icon">🛵</div>
              <div>
                <div class="res-info-lbl">Contactless Delivery</div>
                <div class="res-info-val">Fresh & Temperature Controlled</div>
              </div>
            </div>
            <div class="res-info-row">
              <div class="res-info-icon">👨‍🍳</div>
              <div>
                <div class="res-info-lbl">Culinary Quality</div>
                <div class="res-info-val">Made to Order Everyday</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== STICKY CATEGORY NAVIGATION RAIL ===== --}}
  @if($categories->count())
    <div class="res-cat-bar">
      <div class="res-container">
        <div class="res-cat-list">
          <a href="{{ route('store.shop') }}" class="res-cat-btn" style="background: var(--res-rose); color: #fff;">
            <span>🍽️ Full Menu</span>
          </a>
          @foreach($categories as $idx => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="res-cat-btn">
              <span>{{ $dishEmojis[$idx % count($dishEmojis)] }}</span>
              <span>{{ $cat->name }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  {{-- ===== TOP BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="res-section" style="padding-top: 1.5rem; padding-bottom: 1rem;">
      <div class="res-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 12px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 12px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== CONTENT BLOCKS (Collections & Menu Sections) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Chef Specials');
      @endphp

      @if($products->count())
        <section class="res-section" style="padding-top: 1.5rem;">
          <div class="res-container">
            <div class="res-sec-head">
              <h2 class="res-sec-title">
                <span>🔥</span>
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--res-rose); text-decoration: none;">
                  See all items &rarr;
                </a>
              @endif
            </div>

            <div class="res-menu-grid">
              @foreach($products as $product)
                @include('store.themes.restaurant.partials.product-card', [
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
    <section class="res-section" style="padding-top: 0;">
      <div class="res-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 12px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 12px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
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
