@extends('store.themes.naturae-wellness._shell')

@section('title', 'Naturae — Clean. Conscious. Care. Pure Essentials for a Better You')

@section('content')
@php
    $previewTheme = request('preview_theme', 'naturae');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $byPos = collect($banners ?? [])->groupBy('position');
    $bannerUrl = fn($b) => $b->image_url ?? global_asset(upload_path('banners').'/no-image.png');

    // Role-tagged Collection (Best Sellers) -- when a merchant has assigned
    // one, its own curated products win over the generic category listing.
    $nwRoleBestSellers = collect($collectionsByRole['best_sellers']['products'] ?? []);
    $nwBestSellersProducts = $nwRoleBestSellers->isNotEmpty() ? $nwRoleBestSellers : $products;
@endphp

<!-- ==========================================
     HERO SECTION (auto-rotating carousel; add slides via Store Settings > Hero Slides)
     ========================================== -->
@php $nwHeroSlides = $heroSlides ?? []; @endphp
<section class="relative bg-naturae-sand/70 border-b border-naturae-border/80 overflow-hidden py-12 md:py-20 lg:py-24 grid"
          x-data="{ nwHero: 0, nwHeroCount: {{ count($nwHeroSlides) }} }"
          @if(count($nwHeroSlides) > 1) x-init="setInterval(() => { nwHero = (nwHero + 1) % nwHeroCount }, 6000)" @endif>
    @foreach($nwHeroSlides as $nwI => $nwSlide)
    <div x-show="nwHero === {{ $nwI }}" @if(!$loop->first) x-cloak @endif
         x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="col-start-1 row-start-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

            <!-- Left Hero Content (7 Cols) -->
            <div class="lg:col-span-6 space-y-6 text-left">

                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-naturae-forest/10 border border-naturae-forest/20 text-naturae-forest text-xs font-bold tracking-widest uppercase">
                    <span>Clean. Conscious. Care.</span>
                </div>

                <!-- Main Heading -->
                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-naturae-forest tracking-tight leading-[1.15]">
                    {{ ($nwSlide['title'] ?? '') !== '' ? $nwSlide['title'] : 'Pure Essentials for a Better You' }}
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-naturae-text/80 leading-relaxed max-w-xl">
                    {{ ($nwSlide['subtitle'] ?? '') !== '' ? $nwSlide['subtitle'] : 'Thoughtfully crafted products made with natural ingredients for your everyday wellness and conscious living.' }}
                </p>

                <!-- Shop Now CTA Button -->
                <div class="pt-2 flex items-center gap-4">
                    <a href="{{ ($nwSlide['cta_link'] ?? '') !== '' ? $nwSlide['cta_link'] : $shopUrl }}"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-naturae-forest hover:bg-naturae-green text-white font-semibold text-xs sm:text-sm uppercase tracking-widest rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <span>{{ ($nwSlide['cta_text'] ?? '') !== '' ? $nwSlide['cta_text'] : 'Shop Now' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Feature Benefits Icons -->
                <div class="pt-6 border-t border-naturae-border/80 grid grid-cols-3 gap-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-naturae-forest/10 text-naturae-forest flex items-center justify-center flex-shrink-0 text-sm">
                            🌿
                        </div>
                        <span class="text-xs font-semibold text-naturae-text">Natural Ingredients</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-naturae-forest/10 text-naturae-forest flex items-center justify-center flex-shrink-0 text-sm">
                            ✨
                        </div>
                        <span class="text-xs font-semibold text-naturae-text">No Harsh Chemicals</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-naturae-forest/10 text-naturae-forest flex items-center justify-center flex-shrink-0 text-sm">
                            🐰
                        </div>
                        <span class="text-xs font-semibold text-naturae-text">Cruelty Free</span>
                    </div>
                </div>

            </div>

            <!-- Right Hero Image (5 Cols) -->
            <div class="lg:col-span-6 relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white/80 aspect-[4/3] sm:aspect-[16/11]">
                    <img src="{{ !empty($nwSlide['image_url']) ? $nwSlide['image_url'] : global_asset('images/themes/naturae/naturae-hero-main.jpg') }}"
                         alt="Naturae Pure Essentials Still Life"
                         class="w-full h-full object-cover object-center transform hover:scale-102 transition-transform duration-700">

                    <div class="absolute inset-0 bg-gradient-to-t from-naturae-dark/20 via-transparent to-transparent pointer-events-none"></div>
                </div>
            </div>

        </div>
    </div>
    @endforeach

    @if(count($nwHeroSlides) > 1)
      <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
        @foreach($nwHeroSlides as $nwI => $nwSlide)
          <button type="button" @click="nwHero = {{ $nwI }}" class="w-2 h-2 rounded-full transition-colors" :class="nwHero === {{ $nwI }} ? 'bg-naturae-forest' : 'bg-naturae-forest/30'" aria-label="Slide {{ $nwI + 1 }}"></button>
        @endforeach
      </div>
    @endif
</section>


<!-- ==========================================
     CIRCULAR CATEGORY ICONS
     ========================================== -->
<section class="py-14 bg-white border-b border-naturae-border/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-10">
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-naturae-forest uppercase tracking-wider">
                Shop By Category
            </h2>
            <p class="text-xs sm:text-sm text-naturae-muted mt-1">
                Explore our pure organic collections created for everyday wellbeing
            </p>
        </div>

        @php
            $catItems = [
                ['name' => 'Skincare', 'img' => 'cat-skincare.jpg', 'slug' => 'Skincare'],
                ['name' => 'Hair Care', 'img' => 'cat-haircare.jpg', 'slug' => 'Hair+Care'],
                ['name' => 'Bath & Body', 'img' => 'cat-bathbody.jpg', 'slug' => 'Bath+%26+Body'],
                ['name' => 'Wellness', 'img' => 'cat-wellness.jpg', 'slug' => 'Wellness'],
                ['name' => 'Home Care', 'img' => 'cat-homecare.jpg', 'slug' => 'Home+Care'],
                ['name' => 'Organic Tea', 'img' => 'cat-organictea.jpg', 'slug' => 'Organic+Tea'],
                ['name' => 'Gift Sets', 'img' => 'cat-giftsets.jpg', 'slug' => 'Gift+Sets'],
                ['name' => 'Accessories', 'img' => 'cat-accessories.jpg', 'slug' => 'Accessories'],
            ];
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-6 text-center">
            @foreach($catItems as $c)
                @php
                    $catLink = url('online_store/shop?category=' . $c['slug']) . ($previewTheme ? '&preview_theme=' . $previewTheme : '');
                @endphp
                <a href="{{ $catLink }}" class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border-2 border-naturae-border group-hover:border-naturae-forest transition-all duration-300 p-1 bg-naturae-sand/40 group-hover:shadow-md">
                        <img src="{{ global_asset('images/themes/naturae/' . $c['img']) }}"
                             alt="{{ $c['name'] }}"
                             class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <span class="mt-3 font-medium text-xs text-naturae-text group-hover:text-naturae-forest uppercase tracking-wider transition">
                        {{ $c['name'] }}
                    </span>
                </a>
            @endforeach
        </div>

    </div>
</section>


<!-- ==========================================
     3 PROMO BANNERS (fully customizable via Banners: image, badge, headline, subtitle, button, colors)
     ========================================== -->
@if($bannerGridEnabled ?? true)
@php
    // A banner's own bg_color/bg_color_2/text_color (set in the Banners admin)
    // override each tile's fixed gradient/text color; absent -> theme default.
    $bannerOverlayStyle = function ($b) {
        if (!$b || empty($b->bg_color)) return null;
        $css = !empty($b->bg_color_2)
            ? "background:linear-gradient(to top, {$b->bg_color}e6, {$b->bg_color_2}80, transparent);"
            : "background:linear-gradient(to top, {$b->bg_color}e6, {$b->bg_color}80, transparent);";
        return $css;
    };
    $bannerTextStyle = function ($b) {
        return ($b && !empty($b->text_color)) ? "color:{$b->text_color};" : null;
    };
    $topLeft = ($byPos['top_left'] ?? collect())->first();
    $topRight = ($byPos['top_right'] ?? collect())->first();
    $centerLeft = ($byPos['center_left'] ?? collect())->first();
@endphp
<section class="py-14 bg-naturae-bg border-b border-naturae-border/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Banner 1: New Arrivals -->
            <div class="group relative rounded-2xl overflow-hidden shadow-md bg-white border border-naturae-border flex flex-col">
                <div class="relative h-48 sm:h-56 overflow-hidden">
                    <img src="{{ $topLeft ? $bannerUrl($topLeft) : global_asset('images/themes/naturae/promo-new-arrivals.jpg') }}"
                         alt="{{ ($topLeft->title ?? null) ?: 'New Arrivals' }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-naturae-dark/70 via-transparent to-transparent" @if($bannerOverlayStyle($topLeft)) style="{{ $bannerOverlayStyle($topLeft) }}" @endif></div>
                    <div class="absolute bottom-4 left-4 text-white" @if($bannerTextStyle($topLeft)) style="{{ $bannerTextStyle($topLeft) }}" @endif>
                        <span class="text-[10px] font-bold uppercase tracking-widest bg-naturae-forest/80 px-2 py-0.5 rounded backdrop-blur-sm">{{ ($topLeft->badge_text ?? null) ?: 'New Arrivals' }}</span>
                        <h3 class="font-serif text-lg font-bold mt-1" style="color:inherit;">{{ ($topLeft->title ?? null) ?: "Fresh Picks You'll Love" }}</h3>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between bg-white mt-auto">
                    <p class="text-xs text-naturae-muted">{{ !empty($topLeft->subtitle ?? null) ? $topLeft->subtitle : 'Botanical additions to elevate your ritual.' }}</p>
                    <a href="{{ $topLeft ? ($topLeft->link ?: url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''))) : url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="inline-flex items-center gap-1 text-xs font-bold text-naturae-forest hover:text-naturae-sage uppercase tracking-wider transition">
                        <span>{{ ($topLeft->button_text ?? null) ?: 'Explore' }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Banner 2: Bundle & Save -->
            <div class="group relative rounded-2xl overflow-hidden shadow-md bg-white border border-naturae-border flex flex-col">
                <div class="relative h-48 sm:h-56 overflow-hidden">
                    <img src="{{ $topRight ? $bannerUrl($topRight) : global_asset('images/themes/naturae/promo-bundle-save.jpg') }}"
                         alt="{{ ($topRight->title ?? null) ?: 'Bundle & Save' }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-naturae-dark/70 via-transparent to-transparent" @if($bannerOverlayStyle($topRight)) style="{{ $bannerOverlayStyle($topRight) }}" @endif></div>
                    <div class="absolute bottom-4 left-4 text-white" @if($bannerTextStyle($topRight)) style="{{ $bannerTextStyle($topRight) }}" @endif>
                        <span class="text-[10px] font-bold uppercase tracking-widest bg-emerald-700/80 px-2 py-0.5 rounded backdrop-blur-sm">{{ ($topRight->badge_text ?? null) ?: 'Save Up To 25%' }}</span>
                        <h3 class="font-serif text-lg font-bold mt-1" style="color:inherit;">{{ ($topRight->title ?? null) ?: 'Wellness Bundles' }}</h3>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between bg-white mt-auto">
                    <p class="text-xs text-naturae-muted">{{ !empty($topRight->subtitle ?? null) ? $topRight->subtitle : 'Complete regimes with bundled savings.' }}</p>
                    <a href="{{ $topRight ? ($topRight->link ?: url('online_store/shop?category=Gift+Sets' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''))) : url('online_store/shop?category=Gift+Sets' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="inline-flex items-center gap-1 text-xs font-bold text-naturae-forest hover:text-naturae-sage uppercase tracking-wider transition">
                        <span>{{ ($topRight->button_text ?? null) ?: 'Shop Bundles' }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Banner 3: Eco-Friendly Living -->
            <div class="group relative rounded-2xl overflow-hidden shadow-md bg-white border border-naturae-border flex flex-col">
                <div class="relative h-48 sm:h-56 overflow-hidden">
                    <img src="{{ $centerLeft ? $bannerUrl($centerLeft) : global_asset('images/themes/naturae/promo-eco-living.jpg') }}"
                         alt="{{ ($centerLeft->title ?? null) ?: 'Eco-Friendly Living' }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-naturae-dark/70 via-transparent to-transparent" @if($bannerOverlayStyle($centerLeft)) style="{{ $bannerOverlayStyle($centerLeft) }}" @endif></div>
                    <div class="absolute bottom-4 left-4 text-white" @if($bannerTextStyle($centerLeft)) style="{{ $bannerTextStyle($centerLeft) }}" @endif>
                        <span class="text-[10px] font-bold uppercase tracking-widest bg-naturae-forest/80 px-2 py-0.5 rounded backdrop-blur-sm">{{ ($centerLeft->badge_text ?? null) ?: 'Sustainable' }}</span>
                        <h3 class="font-serif text-lg font-bold mt-1" style="color:inherit;">{{ ($centerLeft->title ?? null) ?: 'Eco-Friendly Living' }}</h3>
                    </div>
                </div>
                <div class="p-4 flex items-center justify-between bg-white mt-auto">
                    <p class="text-xs text-naturae-muted">{{ !empty($centerLeft->subtitle ?? null) ? $centerLeft->subtitle : 'Conscious choices for a peaceful home.' }}</p>
                    <a href="{{ $centerLeft ? ($centerLeft->link ?: url('online_store/shop?category=Home+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''))) : url('online_store/shop?category=Home+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}"
                       class="inline-flex items-center gap-1 text-xs font-bold text-naturae-forest hover:text-naturae-sage uppercase tracking-wider transition">
                        <span>{{ ($centerLeft->button_text ?? null) ?: 'Discover' }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endif


<!-- ==========================================
     BEST SELLERS SECTION
     ========================================== -->
<section class="py-16 bg-white border-b border-naturae-border/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Strip -->
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-10 pb-4 border-b border-naturae-border">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-naturae-sage">Loved By Community</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-naturae-forest mt-1">
                    Best Sellers
                </h2>
                <p class="text-xs sm:text-sm text-naturae-muted mt-1">
                    Our most cherished organic formulas and botanical essentials.
                </p>
            </div>

            <a href="{{ $shopUrl }}" class="mt-4 sm:mt-0 inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-naturae-forest hover:text-naturae-sage transition">
                <span>View All Products</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <!-- Products Grid (6 Columns on desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
            @forelse($nwBestSellersProducts as $product)
                @include('store.themes.naturae-wellness.partials.product-card', ['product' => $product])
            @empty
                <div class="col-span-full text-center py-12 text-naturae-muted text-sm">
                    No organic products found.
                </div>
            @endforelse
        </div>

    </div>
</section>


<!-- ==========================================
     TRUST / BENEFITS STRIP
     ========================================== -->
<section class="py-12 bg-naturae-sand/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 text-center sm:text-left">

            <!-- Benefit 1 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3.5">
                <div class="w-12 h-12 rounded-full bg-naturae-forest text-white flex items-center justify-center flex-shrink-0 text-xl shadow-sm">
                    📦
                </div>
                <div>
                    <h4 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider">Sustainable Packaging</h4>
                    <p class="text-xs text-naturae-muted mt-0.5">100% recyclable & plastic-free shipping boxes.</p>
                </div>
            </div>

            <!-- Benefit 2 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3.5">
                <div class="w-12 h-12 rounded-full bg-naturae-forest text-white flex items-center justify-center flex-shrink-0 text-xl shadow-sm">
                    🔒
                </div>
                <div>
                    <h4 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider">Secure Payments</h4>
                    <p class="text-xs text-naturae-muted mt-0.5">256-bit encrypted safe payment processing.</p>
                </div>
            </div>

            <!-- Benefit 3 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3.5">
                <div class="w-12 h-12 rounded-full bg-naturae-forest text-white flex items-center justify-center flex-shrink-0 text-xl shadow-sm">
                    🔄
                </div>
                <div>
                    <h4 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider">Hassle-Free Returns</h4>
                    <p class="text-xs text-naturae-muted mt-0.5">30-day organic purity satisfaction guarantee.</p>
                </div>
            </div>

            <!-- Benefit 4 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3.5">
                <div class="w-12 h-12 rounded-full bg-naturae-forest text-white flex items-center justify-center flex-shrink-0 text-xl shadow-sm">
                    💬
                </div>
                <div>
                    <h4 class="font-serif text-sm font-bold text-naturae-forest uppercase tracking-wider">Customer Support</h4>
                    <p class="text-xs text-naturae-muted mt-0.5">Dedicated botanical team ready to guide you.</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
