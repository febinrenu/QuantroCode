{{-- Bookstore - Classic: two-column with a CSS-drawn book-spine shelf --}}
<section class="store-hero py-16 relative overflow-hidden" style="background:rgb(var(--color-bg-surface)); border-bottom:4px double rgb(var(--color-accent-500));">
  <div class="container">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="section-kicker">{{ __('messages.Shop') }}</span>
        <h1 class="mt-3 mb-4" style="font-family:var(--store-font-heading); font-size:clamp(2.5rem,5vw,4rem); color:rgb(var(--color-fg-primary));">
          {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
        </h1>
        <p class="section-subtitle mb-6 max-w-md">{{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}</p>
        <a href="{{ route('store.shop') }}" class="btn btn-primary btn-lg">{{ __('messages.ShopNow') }}</a>
      </div>
      <div class="flex items-end justify-center gap-2" style="height:220px;">
        <div style="width:34px;height:170px;background:rgb(var(--color-accent-500));border-radius:2px 2px 0 0;"></div>
        <div style="width:34px;height:210px;background:rgb(var(--color-fg-primary));border-radius:2px 2px 0 0;"></div>
        <div style="width:34px;height:150px;background:rgb(var(--color-accent-600));border-radius:2px 2px 0 0;"></div>
        <div style="width:34px;height:190px;background:rgb(var(--color-fg-secondary));border-radius:2px 2px 0 0;"></div>
        <div style="width:34px;height:130px;background:rgb(var(--color-accent-500));border-radius:2px 2px 0 0;"></div>
      </div>
    </div>
  </div>
</section>
