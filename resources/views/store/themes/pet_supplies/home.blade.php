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

  $petIcons = ['🐕', '🐈', '🦜', '🐹', '🐠', '🐰', '🐢', '🐾', '🦴', '🎾'];
@endphp

{{-- Scoped Pet Supplies Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/pet_supplies/pet_supplies.css')) !!}
</style>

<div class="theme-pet-supplies">

  {{-- ===== FRIENDLY PET HERO ===== --}}
  <section class="pet-hero">
    <div class="pet-container">
      <div class="pet-hero-grid">
        <div>
          <div class="pet-kicker">
            <x-store.icon name="heart" class="w-3.5 h-3.5" />
            <span>Premium Nutrition & Pet Wellness</span>
          </div>

          <h1 class="pet-hero-title">
            {{ $s->hero_title ?? 'Healthy Food, Treats & Toys for Happy Pets' }}
          </h1>

          <p class="pet-hero-sub">
            {{ $s->hero_subtitle ?? 'Wholesome nutrition, durable play essentials, and gentle grooming supplies selected with love for your companions.' }}
          </p>

          {{-- Pet Product Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="pet-search-bar">
            <input type="text" name="q" placeholder="Search pet food, treats, toys, care..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search</span>
            </button>
          </form>

          <div class="pet-hero-actions">
            <a href="{{ route('store.shop') }}" class="pet-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Shop All Pet Supplies</span>
            </a>
            <a href="{{ route('store.contact') }}" class="pet-btn-outline">
              <x-store.icon name="mail" class="w-4 h-4" />
              <span>Nutrition Advice</span>
            </a>
          </div>
        </div>

        {{-- Pet Care Guarantee Panel --}}
        <div>
          <div class="pet-care-panel">
            <div class="pet-care-row">
              <div class="pet-care-icon">🐾</div>
              <div>
                <div class="pet-care-title">Premium Ingredients</div>
                <div class="pet-care-sub">Wholesome veterinary-approved nutrition</div>
              </div>
            </div>
            <div class="pet-care-row">
              <div class="pet-care-icon">📦</div>
              <div>
                <div class="pet-care-title">Fast Doorstep Delivery</div>
                <div class="pet-care-sub">Heavy bags & supplies delivered with care</div>
              </div>
            </div>
            <div class="pet-care-row">
              <div class="pet-care-icon">❤️</div>
              <div>
                <div class="pet-care-title">Pet Satisfaction Guaranteed</div>
                <div class="pet-care-sub">Tail-wagging joy or prompt support</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== PET CATEGORIES ===== --}}
  @if($categories->count())
    <section class="pet-section">
      <div class="pet-container">
        <div class="pet-sec-head">
          <h2 class="pet-sec-title">
            <span>Shop by Pet Category</span>
          </h2>
          <a href="{{ route('store.shop') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--pet-orange); text-decoration: none;">
            All Categories &rarr;
          </a>
        </div>

        <div class="pet-cat-grid">
          @foreach($categories->take(8) as $idx => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="pet-cat-card">
              <div class="pet-cat-icon">{{ $petIcons[$idx % count($petIcons)] }}</div>
              <div class="pet-cat-name">{{ $cat->name }}</div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="pet-section" style="padding-top: 0; padding-bottom: 1.5rem;">
      <div class="pet-container">
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

  {{-- ===== CONTENT BLOCKS (Collections & Lineups) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Favorite Supplies');
      @endphp

      @if($products->count())
        <section class="pet-section" style="padding-top: 0;">
          <div class="pet-container">
            <div class="pet-sec-head">
              <h2 class="pet-sec-title">
                <x-store.icon name="package" class="w-5 h-5 text-orange-500" />
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--pet-orange); text-decoration: none;">
                  View all items &rarr;
                </a>
              @endif
            </div>

            <div class="pet-prod-grid">
              @foreach($products as $product)
                @include('store.themes.pet_supplies.partials.product-card', [
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
    <section class="pet-section" style="padding-top: 0;">
      <div class="pet-container">
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
