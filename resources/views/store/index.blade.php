@extends('layouts.store')

@section('content')

@php
  /** @var \App\Models\StoreSetting $s */
  $currency = $s->currency_code ?? '$';
  $nlBtn    = __('messages.Subscribe');
  /** @var \Illuminate\Support\Collection $banners */
  $byPos = collect($banners ?? [])->groupBy('position');
  $printedCenter = false;

  $renderBanners = function($list, $wrapClass = 'block rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow') {
      foreach ($list ?? collect() as $b) {
          $src  = $b->image_url ?? ($b->image ? global_asset($b->image) : global_asset(upload_path('banners') . '/no-image.png'));
          $href = $b->link ?: route('store.shop');
          echo '<a href="'.e($href).'" class="'.e($wrapClass).'"><img src="'.e($src).'" class="w-full h-auto object-cover" alt="'.e($b->title ?? __('messages.Banner')).'"></a>';
      }
  };
@endphp

{{-- ===== TOP ===== --}}
@if(($byPos['top_left'] ?? collect())->count() || ($byPos['top_right'] ?? collect())->count())
  <section class="py-6">
    <div class="container">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>{!! $renderBanners($byPos['top_left'] ?? collect()) !!}</div>
        <div>{!! $renderBanners($byPos['top_right'] ?? collect()) !!}</div>
      </div>
    </div>
  </section>
@endif

@forelse($blocks ?? [] as $block)
  @switch($block['type'])

    @case('hero')
      @php
        $heroImg = $block['image'] ?? $s->hero_image_path;
        $heroUrl = 'https://picsum.photos/seed/hero-store/960/520';
        if (!empty($heroImg) && is_string($heroImg) && !\Illuminate\Support\Str::startsWith($heroImg, ['http://', 'https://']) && file_exists(public_path($heroImg))) {
            $heroUrl = global_asset($heroImg);
        } elseif (file_exists(public_path('store_files/hero_image.jpg'))) {
            $heroUrl = global_asset('store_files/hero_image.jpg');
        }

        // Each storefront theme owns a structurally distinct hero layout
        // (not just a recolor of the same markup). Falls back to the
        // original default layout for 'default', 'real_estate', or any
        // theme that hasn't defined its own hero partial.
        $heroPartial = 'store.partials.hero.' . ($s->theme ?? 'default');
        if (! \Illuminate\Support\Facades\View::exists($heroPartial)) {
            $heroPartial = 'store.partials.hero.default';
        }

        // Until an admin fills in Hero Title/Subtitle, fall back to
        // theme-specific copy so an empty store never collapses every
        // theme into the same "photo + Shop Now button" look.
        $heroCopyDefaults = [
            'jewelry-luxe'       => ['title' => 'Timeless Pieces, Made to Last', 'subtitle' => 'Hand-finished fine jewelry and watches, crafted for the moments that matter.'],
            'fashion-edit'       => ['title' => 'THE EDIT: NEW SEASON', 'subtitle' => 'Curated apparel and footwear, cut for the way you actually move.'],
            'beauty-glow'        => ['title' => 'Glow That Starts With Skin', 'subtitle' => 'Clean-formula skincare and cosmetics, tested for real results.'],
            'electronics-tech'   => ['title' => 'Next-Gen Tech, In Stock', 'subtitle' => 'Specs that matter, gadgets that ship — browse the latest drops.'],
            'grocery-fresh'      => ['title' => 'Fresh Picks, Delivered Daily', 'subtitle' => 'Farm-sourced produce and pantry staples, at their peak.'],
            'fitness-power'      => ['title' => 'Train Harder. Recover Smarter.', 'subtitle' => 'Performance gear and supplements built for every rep.'],
            'bookstore-classic'  => ['title' => 'Stories Worth Shelving', 'subtitle' => 'Curated titles, stationery, and reads for every kind of shelf.'],
            'restaurant-fresh'   => ['title' => "Today's Menu, Made Fresh", 'subtitle' => 'Seasonal dishes and daily specials, ready when you are.'],
            'marketplace-mega'   => ['title' => 'Everything You Need, One Cart', 'subtitle' => 'Thousands of deals across every category, updated daily.'],
            'pawluxe-pets'       => ['title' => 'Spoil Them a Little More', 'subtitle' => 'Toys, treats, and essentials your best friend will love.'],
        ];
        $heroDefaults = $heroCopyDefaults[$s->theme ?? ''] ?? ['title' => __('messages.Shop'), 'subtitle' => ''];
      @endphp
      @include($heroPartial, ['s' => $s, 'block' => $block, 'heroUrl' => $heroUrl, 'currency' => $currency, 'heroDefaults' => $heroDefaults])

      {{-- ===== CENTER ===== --}}
      @if(!$printedCenter && ( ($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count() ))
        <section class="py-6">
          <div class="container">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
              <div>{!! $renderBanners($byPos['center_left'] ?? collect()) !!}</div>
              <div>{!! $renderBanners($byPos['center_right'] ?? collect()) !!}</div>
            </div>
          </div>
        </section>
        @php $printedCenter = true; @endphp
      @endif
      @break

    @case('collection')
      @php
        $col   = $block['collection'];
        $prods = $block['products'] ?? collect();
        $title = $block['title'] ?? ($col->title ?? $col->name ?? __('messages.Collection'));
      @endphp

      @if($prods->count())
      <section class="py-10 lg:py-14">
        <div class="container">
          <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-6">
            <div>
              <span class="section-kicker">{{ __('messages.Collection') }}</span>
              <h2 class="section-title mt-1">{{ $title }}</h2>
            </div>
            <a class="text-sm font-medium text-accent-500 hover:underline inline-flex items-center gap-1"
               href="{{ route('store.shop', ['collection' => $col->slug]) }}">
              {{ __('messages.ViewAll') }}
              <x-store.icon name="arrow-right" class="w-4 h-4" />
            </a>
          </div>

          <div class="store-product-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($prods as $p)
              @include('store.partials.product-card', ['p' => $p, 'currency' => $currency])
            @endforeach
          </div>
        </div>
      </section>
      @endif
      @break

    @case('newsletter')
      @php
        $nlTitle       = $s->newsletter_title       ?? __('messages.GetFreshDealsTitle');
        $nlSubtitle    = $s->newsletter_subtitle    ?? __('messages.GetFreshDealsSubtitle');
        $nlPlaceholder = $s->newsletter_placeholder ?? __('messages.NewsletterEmailPlaceholder');
      @endphp
      <section class="py-10 lg:py-14">
        <div class="container">
          <div class="rounded-xl border border-line-subtle p-8 lg:p-10"
               style="background: linear-gradient(135deg, rgb(var(--color-accent-500) / .06), rgb(var(--color-bg-surface)));">
            <div class="grid lg:grid-cols-5 gap-6 items-center">
              <div class="lg:col-span-2">
                <h3 class="text-2xl font-bold mb-2">{{ $nlTitle }}</h3>
                <p class="text-fg-secondary text-sm">{{ $nlSubtitle }}</p>
              </div>
              <div class="lg:col-span-3">
                <form id="newsletterForm" class="flex flex-col md:flex-row gap-2">
                  @csrf
                  <input name="email" type="email" id="newsletterEmail" class="input flex-1"
                         placeholder="{{ $nlPlaceholder }}" required>
                  <button id="newsletterBtn" class="btn btn-primary btn-lg shrink-0" type="submit">
                    <x-store.icon name="mail" class="w-5 h-5" />{{ $nlBtn }}
                  </button>
                </form>
                <div id="newsletterMsg" class="text-sm mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </section>
      @break

  @endswitch
@empty

  @if(!$printedCenter && ( ($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count() ))
    <section class="py-6">
      <div class="container">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
          <div>{!! $renderBanners($byPos['center_left'] ?? collect()) !!}</div>
          <div>{!! $renderBanners($byPos['center_right'] ?? collect()) !!}</div>
        </div>
      </div>
    </section>
    @php $printedCenter = true; @endphp
  @endif
@endforelse

@if(!$printedCenter && ( ($byPos['center_left'] ?? collect())->count() || ($byPos['center_right'] ?? collect())->count() ))
  <section class="py-6">
    <div class="container">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>{!! $renderBanners($byPos['center_left'] ?? collect()) !!}</div>
        <div>{!! $renderBanners($byPos['center_right'] ?? collect()) !!}</div>
      </div>
    </div>
  </section>
@endif

@if(($byPos['footer_left'] ?? collect())->count() || ($byPos['footer_right'] ?? collect())->count())
  <section class="py-10">
    <div class="container">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>{!! $renderBanners($byPos['footer_left'] ?? collect()) !!}</div>
        <div>{!! $renderBanners($byPos['footer_right'] ?? collect()) !!}</div>
      </div>
    </div>
  </section>
@endif

{{-- Quick-view + variant-picker + newsletter logic --}}
@include('store.partials.home-modals-scripts', ['currency' => $currency, 'nlBtn' => $nlBtn])

@endsection
