{{-- Fitness & Supplements - Power: gym-poster typographic hero, stat row --}}
<section class="store-hero py-16 relative overflow-hidden text-center"
         style="background:rgb(var(--store-hero-invert-bg)); background-image:repeating-linear-gradient(45deg, rgb(var(--color-accent-500)/.1) 0px, rgb(var(--color-accent-500)/.1) 14px, transparent 14px, transparent 30px);">
  <div class="container">
    <span class="section-kicker" style="color:#fff;">{{ __('messages.Shop') }}</span>
    <h1 class="mt-3 mb-6 mx-auto" style="color:#fff;font-family:var(--store-font-heading); text-transform:uppercase; font-size:clamp(2.75rem,6.5vw,5rem); -webkit-text-stroke:1px rgb(var(--color-accent-500)); max-width:900px;">
      {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
    </h1>
    <p class="mb-8 mx-auto max-w-lg" style="color:rgb(255 255 255/.75);">{{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}</p>
    <a href="{{ route('store.shop') }}" class="btn btn-lg mb-10 inline-block" style="background:rgb(var(--color-accent-500));color:#fff;clip-path:polygon(6% 0,100% 0,94% 100%,0 100%);">{{ __('messages.ShopNow') }}</a>
    <div class="flex items-center justify-center gap-10 flex-wrap" style="color:#fff;">
      <div><div class="text-3xl font-black">10K+</div><div class="text-xs uppercase" style="letter-spacing:.15em;color:rgb(var(--color-accent-500));">Athletes</div></div>
      <div><div class="text-3xl font-black">500+</div><div class="text-xs uppercase" style="letter-spacing:.15em;color:rgb(var(--color-accent-500));">Products</div></div>
      <div><div class="text-3xl font-black">24/7</div><div class="text-xs uppercase" style="letter-spacing:.15em;color:rgb(var(--color-accent-500));">Support</div></div>
    </div>
  </div>
</section>
