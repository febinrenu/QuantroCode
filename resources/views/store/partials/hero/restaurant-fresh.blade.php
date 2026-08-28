{{-- Restaurant & Delivery - Fresh Bite: plated dish hero, dual CTA, scalloped shape --}}
<section class="store-hero py-16 relative overflow-hidden text-center"
         style="background:rgb(var(--color-accent-500)); color:#fff; border-radius:0 0 40% 40% / 0 0 24px 24px;">
  <div class="container">
    <div class="mx-auto mb-6 rounded-full overflow-hidden" style="width:180px;height:180px;box-shadow:0 0 0 6px #fff, 0 0 0 8px rgb(255 255 255/.3);">
      <img class="w-full h-full object-cover" src="{{ $heroUrl }}" alt="Hero">
    </div>
    <span class="section-kicker" style="color:#fff;">{{ __('messages.Shop') }}</span>
    <h1 class="mt-3 mb-4 mx-auto max-w-xl" style="color:#fff;font-family:var(--store-font-heading); font-size:clamp(2.25rem,5vw,3.75rem);">
      {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
    </h1>
    <p class="mb-8 mx-auto max-w-md" style="color:rgb(255 255 255/.85);">{{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}</p>
    <div class="flex items-center justify-center gap-3 flex-wrap">
      <a href="{{ route('store.shop') }}" class="btn btn-lg" style="background:#fff;color:rgb(var(--color-accent-500));border-radius:999px;">Order Now</a>
      <a href="{{ route('store.shop') }}" class="btn btn-lg" style="background:transparent;border:1px solid #fff;color:#fff;border-radius:999px;">View Menu</a>
    </div>
  </div>
</section>
