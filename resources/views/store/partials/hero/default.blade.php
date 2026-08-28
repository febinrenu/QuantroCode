<section class="store-hero py-12 lg:py-16 relative overflow-hidden"
         style="background:
           radial-gradient(1200px 360px at 15% 50%, rgb(var(--color-accent-500) / .10) 0%, transparent 55%),
           radial-gradient(900px 280px at 85% 50%, rgb(var(--color-accent-500) / .06) 0%, transparent 55%);">
  <div class="container">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
      <div>
        <span class="section-kicker">{{ __('messages.Shop') }}</span>
        <h1 class="mt-3 mb-4 text-4xl lg:text-5xl font-bold tracking-tight text-fg-primary">
          {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
        </h1>
        <p class="section-subtitle mb-6 max-w-xl">
          {{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}
        </p>
        <a href="{{ route('store.shop') }}" class="btn btn-primary btn-lg">
          <x-store.icon name="lightning" class="w-5 h-5" />{{ __('messages.ShopNow') }}
        </a>
      </div>
      <div class="relative">
        <div class="rounded-xl overflow-hidden shadow-lg border border-line-subtle">
          <img class="w-full h-auto object-cover max-h-[420px]" src="{{ $heroUrl }}" alt="Hero">
        </div>
      </div>
    </div>
  </div>
</section>
