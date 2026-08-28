{{-- Fashion & Apparel - The Edit: full-bleed editorial poster --}}
<section class="store-hero relative overflow-hidden" style="min-height:520px;background:rgb(var(--store-hero-invert-bg));">
  <img src="{{ $heroUrl }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover" style="opacity:.4;">
  <div class="absolute inset-0" style="background:linear-gradient(180deg, rgb(var(--store-hero-invert-bg) / .15), rgb(var(--store-hero-invert-bg) / .92));"></div>
  <div class="container relative flex flex-col justify-end" style="min-height:520px;padding-block:3rem;">
    <span class="section-kicker" style="color:#fff;">{{ __('messages.Shop') }}</span>
    <h1 class="mt-2 mb-6" style="color:#fff;font-size:clamp(2.75rem,7vw,5.5rem);line-height:0.95;text-transform:uppercase;letter-spacing:-0.02em;">
      {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
    </h1>
    <div class="flex items-end justify-between gap-6 flex-wrap">
      <p class="max-w-md" style="color:rgb(255 255 255 / .8);">{{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}</p>
      <a href="{{ route('store.shop') }}" class="btn btn-lg" style="background:#fff;color:rgb(var(--store-hero-invert-bg));border-radius:0;text-transform:uppercase;letter-spacing:.08em;">
        {{ __('messages.ShopNow') }}
      </a>
    </div>
  </div>
</section>
