@extends('store.themes.veloura-beauty._shell')

@section('title', ($s->store_name ?? 'Veloura Beauty') . ' — Scent. Glow. Indulge.')

@section('content')
@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'veloura');
  $velRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $velRoute('store.shop');
  $accountUrl = url('/online_store/account' . ($themePreview ? '?preview_theme=' . $themePreview : ''));

  $rituals = [
      ['name' => 'Perfume', 'category' => 'Fragrance', 'img' => 'cat-perfume.jpg', 'desc' => 'Haute Parfumerie'],
      ['name' => 'Skincare', 'category' => 'Skincare', 'img' => 'cat-skincare.jpg', 'desc' => 'Radiant Glow'],
      ['name' => 'Makeup', 'category' => 'Makeup', 'img' => 'cat-makeup.jpg', 'desc' => 'Silken Textures'],
      ['name' => 'Bath & Body', 'category' => 'Bath & Body', 'img' => 'cat-bath-body.jpg', 'desc' => 'Aromatherapy'],
      ['name' => 'Hair Care', 'category' => 'Hair Care', 'img' => 'cat-haircare.jpg', 'desc' => 'Gloss & Repair'],
      ['name' => 'Gift Sets', 'category' => 'Gift Sets', 'img' => 'cat-giftsets.jpg', 'desc' => 'Luxury Coffrets'],
      ['name' => "Men's Grooming", 'category' => "Men's Grooming", 'img' => 'cat-mens-grooming.jpg', 'desc' => 'Refined Care'],
      ['name' => 'Clean Beauty', 'category' => 'Clean Beauty', 'img' => 'cat-clean-beauty.jpg', 'desc' => '100% Botanical'],
  ];

  $promoBanners = [
      [
          'title' => 'Fragrance Wardrobe',
          'tagline' => 'Find a scent for every mood and season.',
          'cta' => 'Discover Scents',
          'category' => 'Fragrance',
          'img' => 'promo-fragrance-wardrobe.jpg',
      ],
      [
          'title' => 'Hydration Essentials',
          'tagline' => 'Deep multi-layer hydration for dewy, radiant skin.',
          'cta' => 'Explore Skincare',
          'category' => 'Skincare',
          'img' => 'promo-hydration-essentials.jpg',
      ],
      [
          'title' => 'Glow Makeup Edit',
          'tagline' => 'Flawless everyday looks, crafted effortlessly.',
          'cta' => 'Shop Makeup',
          'category' => 'Makeup',
          'img' => 'promo-glow-makeup.jpg',
      ],
  ];

  $routineSteps = [
      [
          'step' => '01',
          'title' => 'Cleanse',
          'product' => 'Purifying Gentle Foam Cleanser',
          'desc' => 'Melt impurities while respecting skin barrier.',
          'price' => '$36.00',
          'img' => 'purifying-foam-cleanser.jpg',
          'category' => 'Skincare',
      ],
      [
          'step' => '02',
          'title' => 'Treat',
          'product' => 'Glow Elixir 15% Vitamin C Serum',
          'desc' => 'Brighten, firm, and protect against oxidation.',
          'price' => '$68.00',
          'img' => 'glow-elixir-serum.jpg',
          'category' => 'Skincare',
      ],
      [
          'step' => '03',
          'title' => 'Moisturize',
          'product' => 'Rose Hydration Replenishing Crème',
          'desc' => '24-hour continuous moisture infusion.',
          'price' => '$58.00',
          'img' => 'rose-hydration-moisturizer.jpg',
          'category' => 'Skincare',
      ],
      [
          'step' => '04',
          'title' => 'Finish',
          'product' => 'Invisible Sheer Glow Daily SPF 50+',
          'desc' => 'Ultra-light mineral shield with subtle sheen.',
          'price' => '$42.00',
          'img' => 'mineral-glow-spf.jpg',
          'category' => 'Skincare',
      ],
  ];

  $featuredCollections = [
      ['title' => 'Veloura Rose Collection', 'desc' => 'Rare Grasse rose infusions', 'img' => 'col-veloura-rose.jpg', 'category' => 'Skincare'],
      ['title' => 'Golden Hour Glow', 'desc' => 'Sun-kissed botanical body oils', 'img' => 'col-golden-hour.jpg', 'category' => 'Bath & Body'],
      ['title' => 'The Signature Scents', 'desc' => 'Iconic artisanal perfumes', 'img' => 'col-signature-scents.jpg', 'category' => 'Fragrance'],
      ['title' => 'Ultimate Hydration', 'desc' => 'Hyaluronic & ceramide rituals', 'img' => 'col-ultimate-hydration.jpg', 'category' => 'Skincare'],
      ['title' => 'Bridal Beauty Edit', 'desc' => 'Luminous wedding-day perfection', 'img' => 'col-bridal-edit.jpg', 'category' => 'Makeup'],
      ['title' => 'Self-Care Rituals', 'desc' => 'Evening wind-down bath luxuries', 'img' => 'col-self-care.jpg', 'category' => 'Bath & Body'],
  ];

  $ingredients = [
      ['name' => 'Hyaluronic Acid', 'benefit' => 'Multi-depth intense hydration', 'img' => 'ing-hyaluronic-acid.jpg'],
      ['name' => 'Rose Extract', 'benefit' => 'Soothes & balances skin tone', 'img' => 'ing-rose-extract.jpg'],
      ['name' => 'Vitamin C', 'benefit' => 'Visibly brightens and evens tone', 'img' => 'ing-vitamin-c.jpg'],
      ['name' => 'Argan Oil', 'benefit' => 'Nourishing essential fatty acids', 'img' => 'ing-argan-oil.jpg'],
  ];

  $articles = [
      [
          'title' => 'How to Find Your Signature Scent',
          'readTime' => '4 min read',
          'date' => 'May 2026',
          'img' => 'journal-signature-scent.jpg',
          'excerpt' => 'Decode top notes, dry-down profiles, and fragrance layering secrets with our master perfumers.'
      ],
      [
          'title' => 'The Ultimate Guide to Glowing Skin',
          'readTime' => '5 min read',
          'date' => 'April 2026',
          'img' => 'journal-glowing-skin.jpg',
          'excerpt' => 'How clean botanical actives and targeted hydration build a long-lasting, glass-skin complexion.'
      ],
      [
          'title' => '5 Makeup Looks for Every Occasion',
          'readTime' => '6 min read',
          'date' => 'March 2026',
          'img' => 'journal-makeup-looks.jpg',
          'excerpt' => 'From French-girl effortless minimal glow to sultry sunset velvet glam in five effortless steps.'
      ],
  ];

  $testimonials = [
      [
          'name' => 'Elena Rostova',
          'role' => 'Beauty Editor & Verified VIP',
          'text' => 'The Veloura Élan perfume has become my unmistakable signature. It lasts effortlessly for over 14 hours with the most intoxicating rose and amber dry-down.',
          'avatar' => 'avatar-elena.jpg',
      ],
      [
          'name' => 'Sophia Laurent',
          'role' => 'Certified Esthetician',
          'text' => 'The Glow Elixir Vitamin C completely transformed my client skin routines. Incredible gentle formulation without any irritation, just pure luminosity.',
          'avatar' => 'avatar-sophia.jpg',
      ],
      [
          'name' => 'Charlotte Hayes',
          'role' => 'Verified Buyer',
          'text' => 'Unboxing the Rose Glow Ritual Box felt like receiving a gift from a Parisian boutique. Exquisite textures, divine packaging, and truly high-performance results.',
          'avatar' => 'avatar-charlotte.jpg',
      ],
  ];
@endphp

<div class="space-y-16 sm:space-y-24 pb-16">

  <!-- =========================================================================
       1. HERO SECTION
       ========================================================================= -->
  <section class="relative overflow-hidden vel-gradient-hero border-b border-vel-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 lg:py-24">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">

        <!-- Hero Text / Copy -->
        <div class="lg:col-span-6 space-y-6 sm:space-y-8 text-center lg:text-left">

          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/80 backdrop-blur-xs border border-vel-border text-vel-roseDeep text-xs font-bold uppercase tracking-widest shadow-xs">
            <span>✨</span> Maison Veloura Paris
          </div>

          <h1 class="font-serif-luxury text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-vel-charcoal leading-[1.15]">
            Scent.<br>
            <span class="text-vel-roseDark">Glow.</span><br>
            Indulge.
          </h1>

          <p class="text-sm sm:text-base text-vel-muted leading-relaxed max-w-lg mx-auto lg:mx-0 font-normal">
            Immerse yourself in clean botanical skincare, haute French parfumerie, and bespoke beauty rituals crafted to elevate your daily routine.
          </p>

          <!-- CTAs -->
          <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
            <a href="{{ $velRoute('store.shop', ['collection' => 'bestsellers']) }}"
               class="w-full sm:w-auto px-8 py-4 bg-vel-charcoal hover:bg-vel-espresso text-white font-bold text-xs rounded-full shadow-lg active:scale-95 transition-all uppercase tracking-widest text-center">
              Shop Bestsellers &rarr;
            </a>
            <a href="#rituals"
               class="w-full sm:w-auto px-8 py-4 bg-white/90 hover:bg-white text-vel-charcoal hover:text-vel-rose font-bold text-xs rounded-full border border-vel-border shadow-xs active:scale-95 transition-all uppercase tracking-widest text-center">
              Explore Rituals
            </a>
          </div>

          <!-- Feature Micro-Badges -->
          <div class="pt-6 border-t border-vel-border/60 flex items-center justify-center lg:justify-start gap-6 sm:gap-8 text-xs text-vel-muted font-medium">
            <span class="flex items-center gap-1.5">
              <span class="text-vel-rose">✓</span> Cruelty-Free
            </span>
            <span class="flex items-center gap-1.5">
              <span class="text-vel-rose">✓</span> 100% Clean
            </span>
            <span class="flex items-center gap-1.5">
              <span class="text-vel-rose">✓</span> Haute Formulations
            </span>
          </div>

        </div>

        <!-- Hero Image Composition -->
        <div class="lg:col-span-6 relative">
          <div class="relative mx-auto max-w-lg lg:max-w-none rounded-3xl overflow-hidden shadow-2xl border-4 border-white/80">
            <img src="{{ global_asset('images/themes/veloura/veloura-hero-main.jpg') }}"
                 alt="Veloura Luxury Beauty Rituals"
                 class="w-full h-auto max-h-[540px] object-cover hover:scale-105 transition-transform duration-700">

            <!-- Floating Floating Badge -->
            <div class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6 bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-vel-border shadow-xl max-w-xs flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-vel-roseLight flex items-center justify-center text-xl shrink-0">
                🌸
              </div>
              <div class="text-left">
                <span class="text-[10px] font-bold text-vel-rose uppercase tracking-wider block">Signature Release</span>
                <span class="font-serif-luxury text-xs font-bold text-vel-charcoal block">Élan Eau de Parfum</span>
                <span class="text-[11px] text-vel-muted">$135.00 &bull; 100ml</span>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================================
       2. SHOP BY BEAUTY RITUAL (8 Categories)
       ========================================================================= -->
  <section id="rituals" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12 space-y-2">
      <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
        Curated Categories
      </span>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl lg:text-4xl font-bold text-vel-charcoal tracking-tight">
        Shop by Beauty Ritual
      </h2>
      <p class="text-xs sm:text-sm text-vel-muted">
        Select a luxury ritual designed to nourish, revitalize, and awaken the senses.
      </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4">
      @foreach($rituals as $r)
        <a href="{{ $velRoute('store.shop', ['category' => $r['category']]) }}"
           class="group bg-white rounded-2xl border border-vel-border p-3 text-center flex flex-col items-center justify-between vel-card hover:border-vel-rose">

          <div class="aspect-square w-full rounded-xl overflow-hidden bg-vel-blush mb-3 flex items-center justify-center p-2">
            <img src="{{ global_asset('images/themes/veloura/' . $r['img']) }}"
                 alt="{{ $r['name'] }}"
                 loading="lazy"
                 class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
          </div>

          <div>
            <h3 class="font-serif-luxury text-xs font-bold text-vel-charcoal group-hover:text-vel-rose transition-colors">
              {{ $r['name'] }}
            </h3>
            <span class="text-[10px] text-vel-muted block">
              {{ $r['desc'] }}
            </span>
          </div>

        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       3. CURATED BEAUTY BESTSELLERS (Product Grid)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 sm:mb-10 pb-4 border-b border-vel-border">
      <div>
        <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
          Award-Winning Favorites
        </span>
        <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal tracking-tight">
          Curated Beauty Sellers
        </h2>
      </div>

      <a href="{{ $velRoute('store.shop', ['collection' => 'bestsellers']) }}"
         class="text-xs font-bold text-vel-roseDeep hover:text-vel-rose transition-colors flex items-center gap-1 uppercase tracking-wider">
        <span>View All Bestsellers</span>
        <span>&rarr;</span>
      </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @forelse($products->take(8) as $product)
        @include('store.themes.veloura-beauty.partials.product-card', ['product' => $product])
      @empty
        <div class="col-span-full py-12 text-center text-vel-muted">
          No beauty items found in catalog.
        </div>
      @endforelse
    </div>
  </section>

  <!-- =========================================================================
       4. PROMOTIONAL COLLECTIONS (3 Banner Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($promoBanners as $promo)
        <div class="group relative rounded-3xl overflow-hidden border border-vel-border shadow-md bg-vel-charcoal min-h-[360px] flex flex-col justify-end p-6 sm:p-8">

          <!-- Background Image with Overlay -->
          <img src="{{ global_asset('images/themes/veloura/' . $promo['img']) }}"
               alt="{{ $promo['title'] }}"
               class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 group-hover:opacity-75 transition-all duration-700">

          <div class="absolute inset-0 bg-gradient-to-t from-vel-charcoal via-vel-charcoal/40 to-transparent"></div>

          <!-- Content -->
          <div class="relative z-10 space-y-2">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-rose-200 block">
              Curated Edit
            </span>
            <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-white tracking-wide">
              {{ $promo['title'] }}
            </h3>
            <p class="text-xs text-slate-200 leading-relaxed font-light">
              {{ $promo['tagline'] }}
            </p>
            <div class="pt-3">
              <a href="{{ $velRoute('store.shop', ['category' => $promo['category']]) }}"
                 class="inline-block px-5 py-2.5 bg-white hover:bg-vel-rose text-vel-charcoal hover:text-white font-bold text-xs rounded-full shadow-md active:scale-95 transition-all uppercase tracking-wider">
                {{ $promo['cta'] }} &rarr;
              </a>
            </div>
          </div>

        </div>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       5. BUILD YOUR ROUTINE (4 Step Beauty Ritual)
       ========================================================================= -->
  <section class="bg-vel-cream py-16 sm:py-20 border-y border-vel-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
          The 4-Step Regimen
        </span>
        <h2 class="font-serif-luxury text-2xl sm:text-3xl lg:text-4xl font-bold text-vel-charcoal tracking-tight">
          Build Your Daily Beauty Routine
        </h2>
        <p class="text-xs sm:text-sm text-vel-muted">
          Synergistic clean actives formulated to layer seamlessly for lasting cellular radiance.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($routineSteps as $step)
          <div class="bg-white rounded-2xl border border-vel-border p-6 vel-card flex flex-col justify-between relative group">

            <!-- Step Number Badge -->
            <div class="flex items-center justify-between mb-4">
              <span class="font-serif-luxury text-2xl font-bold text-vel-roseDeep">
                {{ $step['step'] }}
              </span>
              <span class="px-2.5 py-1 bg-vel-roseLight text-vel-roseDeep text-[10px] font-bold rounded-full uppercase tracking-wider">
                {{ $step['title'] }}
              </span>
            </div>

            <!-- Step Image -->
            <div class="aspect-square w-full rounded-xl bg-vel-blush overflow-hidden mb-4 p-4 flex items-center justify-center">
              <img src="{{ global_asset('images/themes/veloura/' . $step['img']) }}"
                   alt="{{ $step['product'] }}"
                   class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
            </div>

            <!-- Details -->
            <div class="space-y-2">
              <h4 class="font-serif-luxury text-sm font-bold text-vel-charcoal line-clamp-1 group-hover:text-vel-rose transition-colors">
                {{ $step['product'] }}
              </h4>
              <p class="text-xs text-vel-muted line-clamp-2">
                {{ $step['desc'] }}
              </p>
              <div class="pt-2 flex items-center justify-between border-t border-vel-borderLight">
                <span class="text-xs font-bold text-vel-charcoal">
                  {{ $step['price'] }}
                </span>
                <a href="{{ $velRoute('store.shop', ['category' => $step['category']]) }}"
                   class="text-xs font-bold text-vel-rose hover:underline">
                  Explore Step &rarr;
                </a>
              </div>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- =========================================================================
       6. FEATURED COLLECTIONS (6 Editorial Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
      <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
        Themed Edits
      </span>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal tracking-tight">
        Featured Collections
      </h2>
      <p class="text-xs sm:text-sm text-vel-muted">
        Bespoke assortments curated by our Parisian creative studio.
      </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
      @foreach($featuredCollections as $col)
        <a href="{{ $velRoute('store.shop', ['category' => $col['category']]) }}"
           class="group bg-white rounded-2xl border border-vel-border overflow-hidden vel-card flex flex-col justify-between">
          <div class="aspect-square w-full bg-vel-blush overflow-hidden">
            <img src="{{ global_asset('images/themes/veloura/' . $col['img']) }}"
                 alt="{{ $col['title'] }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          </div>
          <div class="p-3 text-center">
            <h4 class="font-serif-luxury text-xs font-bold text-vel-charcoal group-hover:text-vel-rose transition-colors line-clamp-1">
              {{ $col['title'] }}
            </h4>
            <span class="text-[10px] text-vel-muted block mt-0.5 line-clamp-1">
              {{ $col['desc'] }}
            </span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       7. INGREDIENT SPOTLIGHT (4 Ingredients)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl border border-vel-border p-8 sm:p-12 shadow-sm space-y-8">
      <div class="text-center max-w-xl mx-auto space-y-1">
        <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
          Science & Nature
        </span>
        <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal">
          Ingredient Spotlight
        </h2>
        <p class="text-xs text-vel-muted">
          Clinically validated, sustainably harvested botanical actives.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($ingredients as $ing)
          <div class="flex items-center gap-4 p-4 rounded-2xl bg-vel-blush border border-vel-border">
            <img src="{{ global_asset('images/themes/veloura/' . $ing['img']) }}"
                 alt="{{ $ing['name'] }}"
                 class="w-14 h-14 rounded-xl object-cover shrink-0 shadow-xs">
            <div>
              <h4 class="font-serif-luxury text-xs font-bold text-vel-charcoal">
                {{ $ing['name'] }}
              </h4>
              <p class="text-[11px] text-vel-muted leading-tight mt-0.5">
                {{ $ing['benefit'] }}
              </p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- =========================================================================
       8. BEAUTY JOURNAL (3 Editorial Articles)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-vel-border">
      <div>
        <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
          Editorial Notes
        </span>
        <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal">
          The Beauty Journal
        </h2>
      </div>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-vel-rose hover:underline uppercase tracking-wider">
        Read All Articles &rarr;
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      @foreach($articles as $art)
        <div class="group bg-white rounded-2xl border border-vel-border overflow-hidden vel-card flex flex-col justify-between">
          <div class="aspect-video w-full overflow-hidden bg-vel-blush">
            <img src="{{ global_asset('images/themes/veloura/' . $art['img']) }}"
                 alt="{{ $art['title'] }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
          </div>
          <div class="p-6 space-y-3">
            <div class="flex items-center justify-between text-[11px] text-vel-muted font-medium">
              <span>{{ $art['date'] }}</span>
              <span>&bull;</span>
              <span>{{ $art['readTime'] }}</span>
            </div>
            <h3 class="font-serif-luxury text-base font-bold text-vel-charcoal leading-snug group-hover:text-vel-rose transition-colors">
              <a href="{{ $shopUrl }}">{{ $art['title'] }}</a>
            </h3>
            <p class="text-xs text-vel-muted leading-relaxed line-clamp-2">
              {{ $art['excerpt'] }}
            </p>
            <div class="pt-2">
              <a href="{{ $shopUrl }}" class="text-xs font-bold text-vel-roseDeep group-hover:text-vel-rose transition-colors">
                Read Story &rarr;
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       9. VELOURA CLUB (Membership Banner)
       ========================================================================= -->
  <section id="veloura-club" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="relative rounded-3xl overflow-hidden bg-vel-charcoal text-white p-8 sm:p-12 lg:p-16 border border-vel-espresso shadow-2xl">

      <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

        <div class="lg:col-span-7 space-y-4 text-center lg:text-left">
          <span class="px-3 py-1 bg-rose-900/60 text-rose-200 text-[10px] font-extrabold uppercase tracking-widest rounded-full border border-rose-700/50">
            VIP Inner Circle
          </span>
          <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold tracking-tight text-white">
            VELOURA CLUB
          </h2>
          <p class="text-sm text-slate-300 font-light max-w-lg leading-relaxed">
            &ldquo;More than beauty. It's an artful lifestyle.&rdquo; Enjoy complimentary birthday gifts, private concierge access, double points, and priority invitations to exclusive fragrance launches.
          </p>

          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 text-xs font-semibold text-rose-100">
            <div>✨ Exclusive Offers</div>
            <div>🎁 Birthday Coffret</div>
            <div>⚡ Early Access</div>
            <div>★ Double Points</div>
          </div>
        </div>

        <div class="lg:col-span-5 flex flex-col items-center justify-center gap-4">
          <a href="{{ $accountUrl }}"
             class="w-full sm:w-auto px-10 py-4 bg-vel-rose hover:bg-vel-roseDark text-white font-bold text-xs rounded-full shadow-lg active:scale-95 transition-all uppercase tracking-widest text-center">
            Join The Club Now
          </a>
          <span class="text-[11px] text-slate-400">Complimentary membership &bull; Cancel anytime</span>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       10. CUSTOMER TESTIMONIALS (Loved by Our Beauty Community)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
      <span class="text-xs font-bold text-vel-rose uppercase tracking-widest">
        Client Experiences
      </span>
      <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-vel-charcoal tracking-tight">
        Loved by Our Beauty Community
      </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($testimonials as $t)
        <div class="bg-white rounded-2xl border border-vel-border p-6 vel-card flex flex-col justify-between space-y-4">
          <div class="flex items-center gap-1 text-amber-500 text-sm">
            ★★★★★
          </div>
          <p class="text-xs text-vel-charcoal leading-relaxed italic">
            &ldquo;{{ $t['text'] }}&rdquo;
          </p>
          <div class="flex items-center gap-3 pt-3 border-t border-vel-borderLight">
            <img src="{{ global_asset('images/themes/veloura/' . $t['avatar']) }}"
                 alt="{{ $t['name'] }}"
                 class="w-10 h-10 rounded-full object-cover border border-vel-border">
            <div>
              <h4 class="font-serif-luxury text-xs font-bold text-vel-charcoal">
                {{ $t['name'] }}
              </h4>
              <span class="text-[10px] text-vel-muted block">
                {{ $t['role'] }}
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

</div>
@endsection
