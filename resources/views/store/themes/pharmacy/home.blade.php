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

  $medIcons = ['💊', '🩺', '🩹', '🧴', '🧪', '🌿', '💧', '🧼', '🧬', '🌡️'];
@endphp

{{-- Scoped Pharmacy Stylesheet --}}
<style>
  {!! file_get_contents(resource_path('views/store/themes/pharmacy/pharmacy.css')) !!}
</style>

<div class="theme-pharmacy">

  {{-- ===== CLINICAL HEALTHCARE HERO ===== --}}
  <section class="ph-hero">
    <div class="ph-container">
      <div class="ph-hero-grid">
        <div>
          <div class="ph-kicker">
            <x-store.icon name="shield-check" class="w-3.5 h-3.5" />
            <span>Licensed Community Pharmacy & Healthcare</span>
          </div>

          <h1 class="ph-hero-title">
            {{ $s->hero_title ?? 'Trusted Healthcare & Wellness Essentials' }}
          </h1>

          <p class="ph-hero-sub">
            {{ $s->hero_subtitle ?? 'Authentic healthcare supplies, daily vitamins, personal care products, and wellness essentials with verified safety and tamper-evident packaging.' }}
          </p>

          {{-- Medical / Product Search --}}
          <form action="{{ route('store.shop') }}" method="GET" class="ph-search-bar">
            <input type="text" name="q" placeholder="Search medicines, vitamins, care supplies..." autocomplete="off">
            <button type="submit">
              <x-store.icon name="search" class="w-4 h-4" />
              <span>Find Item</span>
            </button>
          </form>

          <div class="ph-hero-btns">
            <a href="{{ route('store.shop') }}" class="ph-btn-primary">
              <x-store.icon name="grid" class="w-4 h-4" />
              <span>Browse Pharmacy Catalog</span>
            </a>
            <a href="{{ route('store.contact') }}" class="ph-btn-ghost">
              <x-store.icon name="mail" class="w-4 h-4" />
              <span>Pharmacist Consultation</span>
            </a>
          </div>
        </div>

        {{-- Dispensary Trust Panel --}}
        <div>
          <div class="ph-trust-panel">
            <div class="ph-trust-row">
              <div class="ph-trust-icon">🛡️</div>
              <div>
                <div class="ph-trust-title">100% Genuine Supplies</div>
                <div class="ph-trust-sub">Direct manufacturer sourcing & batch verification</div>
              </div>
            </div>
            <div class="ph-trust-row">
              <div class="ph-trust-icon">❄️</div>
              <div>
                <div class="ph-trust-title">Temperature Controlled</div>
                <div class="ph-trust-sub">Optimal clinical storage & fast careful dispatch</div>
              </div>
            </div>
            <div class="ph-trust-row">
              <div class="ph-trust-icon">💬</div>
              <div>
                <div class="ph-trust-title">Qualified Support</div>
                <div class="ph-trust-sub">Healthcare guidance & product assistance</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- ===== PRESCRIPTION NOTICE & PLACEHOLDER ===== --}}
  <section class="ph-section" style="padding-bottom: 0;">
    <div class="ph-container">
      <div class="ph-rx-box">
        <div>
          <div class="ph-rx-title">
            <x-store.icon name="shield-check" class="w-5 h-5 text-teal-600" />
            <span>Prescription & Dispensing Notice</span>
          </div>
          <div class="ph-rx-sub">
            Prescription medications require validation. Present physical prescriptions directly at our dispensary or coordinate via our licensed pharmacist helpdesk.
          </div>
        </div>
        <a href="{{ route('store.contact') }}" class="ph-btn-primary" style="white-space: nowrap; border: 1px solid var(--ph-teal);">
          <x-store.icon name="mail" class="w-4 h-4" />
          <span>Consult Pharmacist</span>
        </a>
      </div>
    </div>
  </section>

  {{-- ===== HEALTH CATEGORIES ===== --}}
  @if($categories->count())
    <section class="ph-section">
      <div class="ph-container">
        <div class="ph-sec-head">
          <h2 class="ph-sec-title">
            <span>Healthcare Aisles</span>
          </h2>
          <a href="{{ route('store.shop') }}" style="font-size: 0.85rem; font-weight: 700; color: var(--ph-teal); text-decoration: none;">
            All Aisles &rarr;
          </a>
        </div>

        <div class="ph-cat-grid">
          @foreach($categories->take(8) as $idx => $cat)
            <a href="{{ route('store.shop', ['category' => $cat->id]) }}" class="ph-cat-card">
              <div class="ph-cat-icon">{{ $medIcons[$idx % count($medIcons)] }}</div>
              <div class="ph-cat-name">{{ $cat->name }}</div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- ===== TOP PROMO BANNERS ===== --}}
  @if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
    <section class="ph-section" style="padding-top: 0; padding-bottom: 1.5rem;">
      <div class="ph-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
          @foreach($byPos['top_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 10px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
            </a>
          @endforeach
          @foreach($byPos['top_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 10px; overflow: hidden;">
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
        $colTitle = $block['title'] ?? ($collection->title ?? $collection->name ?? 'Health Essentials');
      @endphp

      @if($products->count())
        <section class="ph-section" style="padding-top: 0;">
          <div class="ph-container">
            <div class="ph-sec-head">
              <h2 class="ph-sec-title">
                <x-store.icon name="package" class="w-5 h-5 text-teal-600" />
                <span>{{ $colTitle }}</span>
              </h2>
              @if($collection && $collection->slug)
                <a href="{{ route('store.shop', ['collection' => $collection->slug]) }}" style="font-size: 0.85rem; font-weight: 700; color: var(--ph-teal); text-decoration: none;">
                  View all items &rarr;
                </a>
              @endif
            </div>

            <div class="ph-prod-grid">
              @foreach($products as $product)
                @include('store.themes.pharmacy.partials.product-card', [
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
    <section class="ph-section" style="padding-top: 0;">
      <div class="ph-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
          @foreach($byPos['center_left'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 10px; overflow: hidden;">
              <img src="{{ $bannerUrl($banner) }}" alt="{{ $banner->title ?? 'Banner' }}" style="width: 100%; height: auto; display: block;">
            </a>
          @endforeach
          @foreach($byPos['center_right'] ?? collect() as $banner)
            <a href="{{ $banner->link ?: route('store.shop') }}" style="display: block; border-radius: 10px; overflow: hidden;">
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
