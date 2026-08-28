{{-- Electronics & Gadgets - Circuit: dark grid background, floating spec card --}}
<section class="store-hero py-16 relative overflow-hidden"
         style="background:rgb(var(--store-hero-invert-bg)); background-image:linear-gradient(rgb(255 255 255/.04) 1px,transparent 1px),linear-gradient(90deg,rgb(255 255 255/.04) 1px,transparent 1px); background-size:28px 28px;">
  <div class="container">
    <div class="store-hero-grid grid lg:grid-cols-2 gap-10 items-center">
      <div>
        <span class="section-kicker" style="color:rgb(var(--color-accent-500));">// {{ __('messages.Shop') }}</span>
        <h1 class="mt-3 mb-4" style="color:#fff;font-family:'Consolas','JetBrains Mono',monospace; font-size:clamp(2.25rem,4.5vw,3.5rem); text-shadow:0 0 18px rgb(var(--color-accent-500)/.6);">
          {{ $block['title'] ?? $s->hero_title }}
        </h1>
        <p class="mb-6 max-w-md" style="color:rgb(255 255 255/.72);">{{ $block['subtitle'] ?? $s->hero_subtitle }}</p>
        <a href="{{ route('store.shop') }}" class="btn btn-lg" style="background:rgb(var(--color-accent-500));color:#fff;box-shadow:0 0 24px rgb(var(--color-accent-500)/.5);">{{ __('messages.ShopNow') }}</a>
      </div>
      <div class="relative">
        <div class="rounded-lg overflow-hidden" style="border:1px solid rgb(var(--color-accent-500)/.4);">
          <img class="w-full h-auto object-cover max-h-[380px]" src="{{ $heroUrl }}" alt="Hero">
        </div>
        <div class="absolute -bottom-4 -left-4 px-4 py-3 rounded-md"
             style="background:rgb(var(--color-bg-elevated));border:1px solid rgb(var(--color-accent-500)/.5);font-family:monospace;font-size:.75rem;color:rgb(var(--color-accent-500));">
          &gt; specs.load() // in stock
        </div>
      </div>
    </div>
  </div>
</section>
