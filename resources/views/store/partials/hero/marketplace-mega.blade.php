{{-- Marketplace - Mega Store: deal-hub hero with category tile row --}}
<section class="store-hero py-14 relative overflow-hidden" style="background:rgb(var(--store-hero-invert-bg));">
  <div class="container">
    <div class="flex items-center justify-between flex-wrap gap-4 mb-8">
      <div>
        <span class="section-kicker" style="color:#fff;">{{ __('messages.Shop') }}</span>
        <h1 class="mt-2" style="color:#fff;font-family:var(--store-font-heading); font-weight:800; font-size:clamp(2rem,4.5vw,3.25rem);">
          {{ $block['title'] ?? $s->hero_title }}
        </h1>
        <p class="mt-2 max-w-md" style="color:rgb(255 255 255/.75);">{{ $block['subtitle'] ?? $s->hero_subtitle }}</p>
      </div>
      <a href="{{ route('store.shop') }}" class="btn btn-lg shrink-0" style="background:rgb(var(--color-accent-500));color:#fff;">Shop the Sale</a>
    </div>
    <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
      @foreach(['📱','👗','🏠','🎮','💄','🛒'] as $emoji)
        <div class="rounded-md flex items-center justify-center text-2xl aspect-square" style="background:rgb(255 255 255/.06); border:1px solid rgb(255 255 255/.12);">{{ $emoji }}</div>
      @endforeach
    </div>
  </div>
</section>
