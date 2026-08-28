{{-- Grocery & Supermarket - Fresh: ribbon banner + produce icon collage --}}
<section class="store-hero relative overflow-hidden">
  <div class="py-2 text-center text-sm font-semibold" style="background:rgb(var(--color-accent-500));color:#fff;">
    Fresh picks delivered daily
  </div>
  <div class="container py-14">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="section-kicker">{{ __('messages.Shop') }}</span>
        <h1 class="mt-3 mb-4" style="font-family:var(--store-font-heading); font-size:clamp(2.5rem,5vw,4rem); color:rgb(var(--color-fg-primary));">
          {{ $block['title'] ?? $s->hero_title ?: $heroDefaults['title'] ?? '' }}
        </h1>
        <p class="section-subtitle mb-6 max-w-md">{{ $block['subtitle'] ?? $s->hero_subtitle ?: $heroDefaults['subtitle'] ?? '' }}</p>
        <a href="{{ route('store.shop') }}" class="btn btn-primary btn-lg" style="border-radius:999px;">{{ __('messages.ShopNow') }}</a>
      </div>
      <div class="flex items-center justify-center gap-4 flex-wrap">
        <div class="rounded-full flex items-center justify-center text-4xl" style="width:110px;height:110px;background:rgb(var(--color-bg-surface));border:2px solid rgb(var(--color-accent-500));">🥦</div>
        <div class="rounded-full flex items-center justify-center text-4xl mt-8" style="width:130px;height:130px;background:rgb(var(--color-bg-surface));border:2px solid rgb(var(--color-accent-500));">🍎</div>
        <div class="rounded-full flex items-center justify-center text-4xl" style="width:100px;height:100px;background:rgb(var(--color-bg-surface));border:2px solid rgb(var(--color-accent-500));">🥕</div>
      </div>
    </div>
  </div>
</section>
