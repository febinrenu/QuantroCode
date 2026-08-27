{{-- Pet Supplies - PawLuxe: speech-bubble headline, paw-print pattern, mascot circle --}}
<section class="store-hero py-16 relative overflow-hidden"
         style="background-image:radial-gradient(circle at 10px 10px, rgb(var(--color-accent-500)/.16) 3px, transparent 3.2px),radial-gradient(circle at 24px 4px, rgb(var(--color-accent-500)/.16) 2px, transparent 2.2px),radial-gradient(circle at 4px 24px, rgb(var(--color-accent-500)/.16) 2px, transparent 2.2px),radial-gradient(circle at 24px 24px, rgb(var(--color-accent-500)/.16) 2px, transparent 2.2px); background-size:60px 60px; background-color:rgb(var(--color-bg-surface));">
  <div class="container">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <div class="inline-block px-5 py-4 mb-4" style="background:#fff;border-radius:1.5rem;box-shadow:0 4px 14px rgb(0 0 0/.08);">
          <h1 style="font-family:var(--store-font-heading); font-size:clamp(2rem,4.5vw,3.25rem); color:rgb(var(--color-fg-primary)); margin:0;">
            {{ $block['title'] ?? $s->hero_title }}
          </h1>
        </div>
        <p class="section-subtitle mb-6 max-w-md">{{ $block['subtitle'] ?? $s->hero_subtitle }}</p>
        <a href="{{ route('store.shop') }}" class="btn btn-primary btn-lg" style="border-radius:999px;">{{ __('messages.ShopNow') }}</a>
      </div>
      <div class="flex justify-center">
        <div class="rounded-full overflow-hidden flex items-center justify-center" style="width:240px;height:240px;background:#fff;border:6px solid rgb(var(--color-accent-500));">
          <img class="w-full h-full object-cover" src="{{ $heroUrl }}" alt="Hero">
        </div>
      </div>
    </div>
  </div>
</section>
