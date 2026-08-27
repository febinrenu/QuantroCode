{{-- Jewelry & Watches - Luxe: centered, ornamental, no product-grid dependency --}}
<section class="store-hero py-24 relative overflow-hidden text-center">
  <div class="container max-w-3xl mx-auto">
    <div class="mx-auto mb-6" style="width:1px;height:64px;background:rgb(var(--color-accent-500));"></div>
    <span class="section-kicker">{{ __('messages.Shop') }}</span>
    <h1 class="mt-4 mb-6" style="font-family:var(--store-font-heading);font-style:italic;font-size:clamp(2.25rem,5vw,3.75rem);font-weight:600;color:rgb(var(--color-fg-primary));">
      {{ $block['title'] ?? $s->hero_title }}
    </h1>
    <p class="section-subtitle mb-8 mx-auto max-w-xl">{{ $block['subtitle'] ?? $s->hero_subtitle }}</p>
    <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-2 text-sm uppercase"
       style="letter-spacing:0.25em;color:rgb(var(--color-accent-500));border-bottom:1px solid rgb(var(--color-accent-500));padding-bottom:4px;">
      {{ __('messages.ShopNow') }} <x-store.icon name="arrow-right" class="w-4 h-4" />
    </a>
    <div class="mx-auto mt-10" style="width:1px;height:64px;background:rgb(var(--color-accent-500));"></div>
  </div>
</section>
