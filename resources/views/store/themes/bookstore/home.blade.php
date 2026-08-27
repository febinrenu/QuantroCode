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

  $genreIcons = ['📚', '📖', '📜', '🖋️', '🎓', '🎨', '🔍', '🧠', '🌟', '🧭'];
@endphp

{{-- Scoped Bookstore Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/bookstore/bookstore.css')) !!}
</style>

<div class="theme-bookstore" x-data="{ viewMode: 'grid' }">

  {{-- ===== LITERARY EDITORIAL HERO ===== --}}
  <section class="bk-hero">
    <div class="bk-container">
      <div class="bk-hero-grid">
        <div>
          <div class="bk-kicker">
            <x-store.icon name="book" class="w-3.5 h-3.5" />
            <span>Independent Bookseller & Literary Catalog</span>
          </div>

          <h1 class="bk-hero-title">
            {{ $s->hero_title ?? 'Curated Books, Rare Editions & Literary Works' }}
          </h1>

          <p class="bk-hero-sub">
            {{ $s->hero_subtitle ?? 'Explore captivating fiction, thought-provoking non-fiction, academic texts, and timeless literature curated for curious minds.' }}
          </p>

          {{-- Book / ISBN / Author Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="bk-search-box">
            <input type="text" name="q" placeholder="Search by Book Title, Author, Genre or ISBN..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Search Books</span>
            </button>
          </form>

          <div class="bk-hero-actions">
            <a href="{{ route('store.shop') }}" class="bk-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Browse Full Library</span>
            </a>
            <a href="{{ route('store.contact') }}" class="bk-btn-outline">
              <x-store.icon name="mail" class="w-4 h-4" />
              <span>Reader Inquiries</span>
            </a>
          </div>
        </div>

        {{-- Editorial Spotlight Card --}}
        <div>
          <div class="bk-curated-panel">
            <div class="bk-curated-title">Staff Recommendations</div>
            <div class="bk-curated-sub">
              Carefully vetted literary collections, verified editions, and priority shelf dispatch.
            </div>
            <div class="bk-feature-row">
              <span>Catalog Indexing</span>
              <strong>AUTHENTIC EDITIONS</strong>
            </div>
            <div class="bk-feature-row">
              <span>Reading Samples</span>
              <strong>SYNOPSIS READY</strong>
            </div>
            <div class="bk-feature-row">
              <span>Careful Packaging</span>
              <strong>PROTECTIVE WRAP</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== GENRE / CATEGORY SHELF ===== --}}
  @if($categories->count())
    <section class="bk-section">
      <div class="bk-container">
        <div class="bk-sec-head">
          <h2 class="bk-sec-title">
            <span>Explore by Genre</span>
          </h2>
          <a href="{{ route('store.shop') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--bk-primary); text-decoration: none;">
            All Genres &rarr;
          </a>
        </div>

        <div class="bk-genre-shelf">
          @foreach($categories->take(8) as $idx => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="bk-genre-card">
              <div class="bk-genre-icon">{{ $genreIcons[$idx % count($genreIcons)] }}</div>
              <div class="bk-genre-name">{{ $cat->name }}</div>
              <div style="font-size: 0.75rem; color: var(--bk-text-muted); margin-top: 0.25rem;">
                @if($cat->subcategories && $cat->subcategories->count())
                  {{ $cat->subcategories->count() }} Sub-genres
                @else
                  Explore Titles
                @endif
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="bk-section" style="padding-top: 0; padding-bottom: 1.5rem;">
      <div class="bk-container">
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
    </section>
  @endif

  {{-- ===== CONTENT BLOCKS (Collections & Lineups with Grid/List Toggle) ===== --}}
  @foreach($blocks as $block)
    @if(($block['type'] ?? '') === 'collection')
      @php
        $products = collect($block['products'] ?? []);
        $collection = $block['collection'] ?? null;
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Featured Titles');
      @endphp

      @if($products->count())
        <section class="bk-section" style="padding-top: 0;">
          <div class="bk-container">
            <div class="bk-sec-head">
              <h2 class="bk-sec-title">
                <span>{{ $colTitle }}</span>
              </h2>

              <div class="bk-view-toggle">
                <button type="button" class="bk-toggle-btn" :class="{ 'active': viewMode === 'grid' }" @click="viewMode = 'grid'">
                  <x-store.icon name="grid" class="w-3.5 h-3.5" />
                  <span>Grid</span>
                </button>
                <button type="button" class="bk-toggle-btn" :class="{ 'active': viewMode === 'list' }" @click="viewMode = 'list'">
                  <x-store.icon name="menu" class="w-3.5 h-3.5" />
                  <span>List</span>
                </button>
              </div>
            </div>

            <div class="bk-prod-grid" :class="{ 'list-view': viewMode === 'list' }">
              @foreach($products as $product)
                @include('store.themes.bookstore.partials.product-card', [
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
    <section class="bk-section" style="padding-top: 0;">
      <div class="bk-container">
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
    </section>
  @endif

</div>

{{-- Shared QuickView, Variant Picker, Cart, and Toast scripts --}}
@include('store.partials.home-modals-scripts', [
  'currency' => $currency,
  'nlBtn' => __('messages.Subscribe')
])

@endsection
