{{-- Cosmetics & Beauty - Glow: soft blob-masked imagery, floating badges --}}
<section class="store-hero py-16 relative overflow-hidden"
         style="background:radial-gradient(60% 100% at 0% 0%, rgb(var(--color-accent-500)/.14), transparent 60%), radial-gradient(60% 100% at 100% 100%, rgb(var(--color-accent-400)/.18), transparent 60%);">
  <div class="container">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="section-kicker">{{ __('messages.Shop') }}</span>
        <h1 class="mt-3 mb-4" style="font-family:var(--store-font-heading);font-style:italic;font-weight:500;font-size:clamp(2.5rem,5vw,4rem);color:rgb(var(--color-fg-primary));">
          {{ $block['title'] ?? $s->hero_title }}
        </h1>
        <p class="section-subtitle mb-6 max-w-md">{{ $block['subtitle'] ?? $s->hero_subtitle }}</p>
        <div class="flex items-center gap-3 mb-6 flex-wrap">
          <span class="chip" style="border-radius:999px;">Cruelty-free</span>
          <span class="chip" style="border-radius:999px;">Clean formulas</span>
        </div>
        <a href="{{ route('store.shop') }}" class="btn btn-primary btn-lg" style="border-radius:999px;">{{ __('messages.ShopNow') }}</a>
      </div>
      <div class="relative flex justify-center">
        <div class="overflow-hidden" style="border-radius:62% 38% 55% 45% / 45% 55% 45% 55%; width:min(100%,420px); aspect-ratio:1/1;">
          <img class="w-full h-full object-cover" src="{{ $heroUrl }}" alt="Hero">
        </div>
      </div>
    </div>
  </div>
</section>
