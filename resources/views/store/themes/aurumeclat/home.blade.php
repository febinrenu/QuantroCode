<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'AurumÉclat') . ' — Fine Jewelry | Crafted to Be Treasured'])
</head>
<body class="bg-[#090807] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'aurumeclat');
  $aurumRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
@endphp

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  
  // Specific Bestselling Pieces as defined in the visual reference
  $bestsellerCodes = ['JWL-RNG-001', 'JWL-NCK-001', 'JWL-EAR-001', 'JWL-BRC-001', 'JWL-COI-001'];
  $bestsellerProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $bestsellerCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $bestsellerCodes));

  $bestsellers = $bestsellerProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));

  // Specific New Arrivals as defined in the visual reference
  $newArrivalCodes = ['JWL-NCK-002', 'JWL-RNG-002', 'JWL-EAR-002', 'JWL-RNG-003', 'JWL-RNG-004'];
  $newArrivalProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->whereIn('code', $newArrivalCodes)
      ->with(['variants', 'images'])
      ->get()
      ->sortBy(fn($p) => array_search($p->code, $newArrivalCodes));

  $newArrivals = $newArrivalProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
@endphp

<main class="overflow-x-hidden">

  <!-- ==================== 1. HERO SECTION ==================== -->
  <section class="relative bg-gradient-to-b from-[#070605] via-[#100D0A] to-[#0A0908] border-b border-aurum-border/60 overflow-hidden">
    
    <!-- Ambient Golden Glow -->
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-aurum-gold/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16 grid lg:grid-cols-12 gap-8 lg:gap-12 items-center">
      
      <!-- Left Column: Copy & Actions -->
      <div class="lg:col-span-6 space-y-6 sm:space-y-7 z-10">
        
        <div>
          <span class="font-serif italic text-2xl sm:text-3xl lg:text-[34px] text-aurum-goldLight/90 tracking-wide block">
            Crafted to Be
          </span>
          <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl xl:text-[76px] font-normal leading-[0.95] text-white tracking-tight mt-1">
            <span class="gold-gradient-text font-serif font-medium">Treasured</span>
          </h1>
        </div>

        <p class="text-xs sm:text-sm text-aurum-goldLight/75 font-light leading-relaxed max-w-md">
          Timeless designs. Ethical sourcing.<br class="hidden sm:inline">
          Heirloom quality, for a lifetime.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap items-center gap-4 pt-1">
          <a href="{{ $aurumRoute('store.shop') }}" class="h-11 sm:h-12 px-7 sm:px-8 inline-flex items-center justify-center bg-aurum-gold hover:bg-[#E5C158] text-aurum-black text-[11px] sm:text-xs font-semibold tracking-[0.2em] uppercase transition-all duration-300 shadow-[0_4px_20px_rgba(212,175,55,0.25)]">
            SHOP FINE JEWELRY
          </a>
          <a href="#private-appointment-section" class="h-11 sm:h-12 px-6 sm:px-7 inline-flex items-center justify-center border border-aurum-gold/60 hover:border-aurum-gold hover:bg-aurum-gold/10 text-white text-[11px] sm:text-xs font-medium tracking-[0.18em] uppercase transition-all duration-300">
            BOOK PRIVATE APPOINTMENT
          </a>
        </div>

        <!-- Hero Bottom Trust Badges (Desktop) -->
        <div class="pt-6 border-t border-aurum-border/60 flex flex-wrap items-center gap-6 text-[11px] text-aurum-goldLight/70 font-light">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="6" width="18" height="12" rx="1"></rect><line x1="8" y1="6" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="18"></line></svg>
            <span>18K &amp; 22K Solid Gold</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon></svg>
            <span>IGI / GIA Certified</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
            <span>Lifetime Service Promise</span>
          </div>
        </div>

      </div>

      <!-- Right Column: Editorial Hero Imagery Matching Reference -->
      <div class="lg:col-span-6 relative">
        <div class="relative mx-auto max-w-md lg:max-w-none aspect-[3/4] overflow-hidden border border-aurum-border/70 shadow-2xl bg-[#120E0A]">
          <img src="{{ global_asset('images/themes/aurumeclat/hero-model.jpg') }}" 
               alt="AurumÉclat High Jewelry Haute Couture" 
               class="w-full h-full object-cover object-top filter brightness-95">
          <div class="absolute inset-0 bg-gradient-to-t from-[#0A0908] via-transparent to-transparent opacity-60"></div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==================== 2. MOBILE CIRCULAR QUICK ACTIONS ==================== -->
  <div class="lg:hidden bg-[#FAF8F5] text-[#1A1815] py-5 px-4 border-b border-[#E2D7C5]">
    <div class="grid grid-cols-4 gap-2 text-center">
      <a href="#gold-rate-section" class="flex flex-col items-center gap-1.5 group">
        <div class="w-12 h-12 rounded-full bg-white border border-[#D4AF37]/50 flex items-center justify-center text-[#B8860B] shadow-sm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 3"></path></svg>
        </div>
        <span class="text-[10px] text-[#4A453E] font-medium">Gold Rate</span>
      </a>

      <a href="{{ $aurumRoute('store.shop', ['q' => 'diamond']) }}" class="flex flex-col items-center gap-1.5 group">
        <div class="w-12 h-12 rounded-full bg-white border border-[#D4AF37]/50 flex items-center justify-center text-[#B8860B] shadow-sm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon></svg>
        </div>
        <span class="text-[10px] text-[#4A453E] font-medium">Diamonds</span>
      </a>

      <a href="#custom-design-section" class="flex flex-col items-center gap-1.5 group">
        <div class="w-12 h-12 rounded-full bg-white border border-[#D4AF37]/50 flex items-center justify-center text-[#B8860B] shadow-sm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        </div>
        <span class="text-[10px] text-[#4A453E] font-medium">Custom Design</span>
      </a>

      <a href="{{ $aurumRoute('store.shop', ['q' => 'bridal']) }}" class="flex flex-col items-center gap-1.5 group">
        <div class="w-12 h-12 rounded-full bg-white border border-[#D4AF37]/50 flex items-center justify-center text-[#B8860B] shadow-sm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="12" r="4"></circle><circle cx="15" cy="12" r="4"></circle></svg>
        </div>
        <span class="text-[10px] text-[#4A453E] font-medium">Bridal</span>
      </a>
    </div>
  </div>

  <!-- ==================== 3. QUICK HIGHLIGHT CARDS STRIP (Cream Section) ==================== -->
  <section id="gold-rate-section" class="bg-[#EAE4D7] text-[#1A1815] py-10 lg:py-12 border-b border-[#D8CDBB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Card 1: Today's Gold Rate -->
        <div class="bg-[#FAF7F2] p-5 rounded-none border border-[#DDD3C1] shadow-sm flex flex-col justify-between relative overflow-hidden">
          <div>
            <div class="flex items-center justify-between text-[11px] tracking-wider text-aurum-textMuted uppercase font-medium">
              <span>Today's Gold Rate</span>
              <span class="text-xs text-aurum-textMuted/60 cursor-pointer">×</span>
            </div>
            <div class="mt-2.5 flex items-baseline gap-2">
              <span class="text-xs font-semibold text-aurum-textDark">24K (999)</span>
              <span class="font-serif text-2xl font-bold text-aurum-textDark">$2,362</span>
              <span class="text-[11px] text-aurum-textMuted font-light">/oz</span>
            </div>
            <div class="text-[11px] text-aurum-textMuted mt-0.5">
              22K (916) &nbsp;<span class="font-semibold text-aurum-textDark">$2,168</span> /oz
            </div>
          </div>
          
          <!-- Golden Area Sparkline Graph -->
          <div class="mt-4 pt-2">
            <svg viewBox="0 0 200 40" class="w-full h-8 text-[#C5A059]" fill="none">
              <path d="M0 35 Q 40 32, 70 25 T 140 18 T 200 5 L 200 40 L 0 40 Z" fill="rgba(212,175,55,0.2)"></path>
              <path d="M0 35 Q 40 32, 70 25 T 140 18 T 200 5" stroke="#B8860B" stroke-width="2"></path>
            </svg>
            <a href="{{ $aurumRoute('store.shop', ['q' => 'gold coin']) }}" class="mt-2 inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
              <span>VIEW LIVE GOLD RATE</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Card 2: Certified Diamonds -->
        <div class="bg-[#FAF7F2] p-5 rounded-none border border-[#DDD3C1] shadow-sm flex flex-col justify-between relative overflow-hidden">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="font-serif text-lg font-bold text-aurum-textDark">Certified Diamonds</h3>
              <p class="text-[11px] text-aurum-textMuted mt-1 leading-relaxed font-light">
                IGI / GIA Certified<br>
                Conflict-Free<br>
                100% Natural
              </p>
            </div>
            <!-- Diamond Image Asset -->
            <div class="w-16 h-16 shrink-0 -mt-1 -mr-1">
              <img src="{{ global_asset('images/themes/aurumeclat/diamond-cut.jpg') }}" alt="Brilliant Diamond" class="w-full h-full object-contain filter drop-shadow">
            </div>
          </div>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'diamond']) }}" class="mt-4 inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
            <span>EXPLORE DIAMONDS</span>
            <span>&rarr;</span>
          </a>
        </div>

        <!-- Card 3: Custom Design Consultation -->
        <div id="custom-design-section" class="bg-gradient-to-br from-[#D9C4A0] via-[#C9B189] to-[#B89B6C] p-5 rounded-none border border-[#C5A059] shadow-sm flex flex-col justify-between text-[#1A1815]">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="font-serif text-lg font-bold text-[#1F1A12]">Custom Design<br>Consultation</h3>
              <p class="text-[11px] text-[#3D3528] mt-1 leading-relaxed font-light">
                Bring your dream to life
              </p>
            </div>
            <!-- Golden Atelier Emblem -->
            <div class="w-12 h-12 rounded-full border border-[#8C6D23]/40 flex items-center justify-center text-[#4A3B18] text-xl font-serif">
              ✦
            </div>
          </div>
          <a href="#private-appointment-section" class="mt-4 inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-[#1F1A12] uppercase hover:underline">
            <span>BOOK CONSULTATION</span>
            <span>&rarr;</span>
          </a>
        </div>

        <!-- Card 4: Bridal & Wedding -->
        <div class="bg-[#FAF7F2] p-5 rounded-none border border-[#DDD3C1] shadow-sm flex flex-col justify-between relative overflow-hidden">
          <div class="flex justify-between items-start">
            <div>
              <h3 class="font-serif text-lg font-bold text-aurum-textDark">Bridal &amp; Wedding</h3>
              <p class="text-[11px] text-aurum-textMuted mt-1 leading-relaxed font-light">
                Celebrate forever
              </p>
            </div>
            <!-- Bridal Rings Image Asset -->
            <div class="w-16 h-16 shrink-0 -mt-1 -mr-1">
              <img src="{{ global_asset('images/themes/aurumeclat/bridal-rings.jpg') }}" alt="Bridal & Wedding Rings" class="w-full h-full object-contain filter drop-shadow">
            </div>
          </div>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'bridal']) }}" class="mt-4 inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
            <span>EXPLORE BRIDAL</span>
            <span>&rarr;</span>
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 4. SHOP BY SIGNATURE COLLECTION ==================== -->
  <section class="bg-[#EAE4D7] text-[#1A1815] pt-12 pb-16 lg:pb-20 border-b border-[#D8CDBB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Title -->
      <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10">
        <div class="flex items-center justify-center gap-3 text-aurum-goldDark text-xs mb-1.5">
          <span>—</span><span class="text-xs">✦</span><span>—</span>
        </div>
        <h2 class="font-serif text-xl sm:text-2xl lg:text-3xl font-medium tracking-[0.15em] text-aurum-textDark uppercase">
          SHOP BY SIGNATURE COLLECTION
        </h2>
      </div>

      <!-- 8 Arched Collection Cards Grid -->
      @php
        $collections = [
          ['name' => 'DIAMOND RINGS', 'q' => 'ring', 'img' => global_asset('images/themes/aurumeclat/col-diamond-rings.jpg')],
          ['name' => 'BRIDAL SETS', 'q' => 'bridal', 'img' => global_asset('images/themes/aurumeclat/col-bridal-sets.jpg')],
          ['name' => 'NECKLACES', 'q' => 'necklace', 'img' => global_asset('images/themes/aurumeclat/col-necklaces.jpg')],
          ['name' => 'EARRINGS', 'q' => 'earring', 'img' => global_asset('images/themes/aurumeclat/col-earrings.jpg')],
          ['name' => 'BANGLES', 'q' => 'bangle', 'img' => global_asset('images/themes/aurumeclat/col-bangles.jpg')],
          ['name' => "MEN'S JEWELRY", 'q' => 'signet', 'img' => global_asset('images/themes/aurumeclat/col-mens-jewelry.jpg')],
          ['name' => 'PEARLS', 'q' => 'pearl', 'img' => global_asset('images/themes/aurumeclat/col-pearls.jpg')],
          ['name' => 'GEMSTONES', 'q' => 'sapphire', 'img' => global_asset('images/themes/aurumeclat/col-gemstones.jpg')],
        ];
      @endphp

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-5">
        @foreach($collections as $col)
          <a href="{{ $aurumRoute('store.shop', ['q' => $col['q']]) }}" class="group block relative overflow-hidden bg-[#120F0C] border border-[#DDD3C1] aspect-[4/3] rounded-t-[40px] rounded-b-none shadow-sm hover:shadow-lg transition-all duration-300">
            <img src="{{ $col['img'] }}" alt="{{ $col['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 brightness-90 group-hover:brightness-100">
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
            <div class="absolute bottom-3.5 inset-x-2 text-center">
              <span class="font-serif tracking-[0.16em] text-[10px] sm:text-xs font-semibold text-white group-hover:text-aurum-gold transition-colors uppercase">
                {{ $col['name'] }}
              </span>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Explore All Button -->
      <div class="text-center mt-9">
        <a href="{{ $aurumRoute('store.shop') }}" class="inline-flex items-center justify-center px-8 py-3 bg-[#D4C3A3] hover:bg-[#C9B592] text-[#1A1815] text-[11px] font-semibold tracking-[0.2em] uppercase transition-colors">
          EXPLORE ALL COLLECTIONS
        </a>
      </div>

    </div>
  </section>

  <!-- ==================== 5. BESTSELLING PIECES (Dark Luxury) ==================== -->
  <section class="bg-[#090807] text-aurum-goldLight py-14 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header with Arrows -->
      <div class="flex items-end justify-between mb-8 pb-3 border-b border-aurum-border/60">
        <div>
          <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-medium block mb-1">
            CURATED HIGH-JEWELRY
          </span>
          <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal text-white">
            Bestselling Pieces
          </h2>
        </div>

        <div class="flex items-center gap-4">
          <a href="{{ $aurumRoute('store.shop', ['sort' => 'bestselling']) }}" class="text-xs tracking-widest text-aurum-gold hover:text-white uppercase font-medium transition-colors">
            VIEW ALL &gt;
          </a>
          <div class="hidden sm:flex items-center gap-1.5">
            <button type="button" class="w-8 h-8 rounded-full border border-aurum-border flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold transition-colors" aria-label="Previous">
              ‹
            </button>
            <button type="button" class="w-8 h-8 rounded-full border border-aurum-border flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold transition-colors" aria-label="Next">
              ›
            </button>
          </div>
        </div>
      </div>

      <!-- 5-Column Product Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 sm:gap-5">
        @foreach($bestsellers as $product)
          @include('store.themes.aurumeclat.partials.product-card', ['product' => $product])
        @endforeach
      </div>

    </div>
  </section>

  <!-- ==================== 6. HERITAGE MONOGRAM & 4-PILLAR GRID ==================== -->
  <section class="bg-[#100D0A] border-b border-aurum-border py-12 lg:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 lg:gap-8 items-center text-center">
        
        <!-- Pillar 1 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-base sm:text-lg text-white font-medium">The Bridal Edit</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Celebrate your forever</p>
          <a href="{{ $aurumRoute('store.shop', ['q' => 'bridal']) }}" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            EXPLORE
          </a>
        </div>

        <!-- Pillar 2 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-base sm:text-lg text-white font-medium">Timeless Heirlooms</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Made to be passed down</p>
          <a href="{{ $aurumRoute('store.shop') }}" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            DISCOVER
          </a>
        </div>

        <!-- Center Monogram Crest -->
        <div class="col-span-2 lg:col-span-1 flex flex-col items-center justify-center my-2 lg:my-0">
          <div class="w-16 h-16 rounded-full border-2 border-aurum-gold/60 flex items-center justify-center text-aurum-gold font-serif text-2xl font-bold bg-[#181410] shadow-lg">
            A
          </div>
          <span class="text-[8px] tracking-[0.25em] text-aurum-gold uppercase font-medium mt-2">
            CRAFTED WITH PASSION • ROOTED IN HERITAGE
          </span>
        </div>

        <!-- Pillar 3 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-base sm:text-lg text-white font-medium">Custom Crafted</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Your vision, our artistry</p>
          <a href="#custom-design-section" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            START DESIGN
          </a>
        </div>

        <!-- Pillar 4 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-base sm:text-lg text-white font-medium">Certified Purity</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Trust in every detail</p>
          <a href="#gold-rate-section" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            LEARN MORE
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 7. TWO-COLUMN EDITORIAL FEATURE ==================== -->
  <section id="private-appointment-section" class="bg-[#090807] py-14 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
        
        <!-- Left: Design Your Piece -->
        <div class="relative bg-[#120F0C] border border-aurum-border p-8 sm:p-10 flex flex-col justify-between min-h-[360px] overflow-hidden group">
          <div class="absolute inset-0 opacity-25 group-hover:opacity-35 transition-opacity bg-cover bg-center" style="background-image: url('{{ global_asset('images/themes/aurumeclat/atelier-sketch.jpg') }}');"></div>
          <div class="relative z-10 space-y-3">
            <h3 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-white font-normal leading-tight">
              Design Your Piece
            </h3>
            <div class="text-xs text-aurum-goldLight/90 font-medium">Make it uniquely yours</div>
            <p class="text-xs text-aurum-goldLight/70 font-light leading-relaxed max-w-sm">
              From concept to creation, we craft jewelry as unique as your story.
            </p>
          </div>
          <div class="relative z-10 pt-6">
            <a href="#custom-design-section" class="inline-flex items-center gap-2 text-xs tracking-widest text-aurum-gold font-semibold uppercase hover:underline">
              <span>START CUSTOM DESIGN</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Right: Book a Private Appointment -->
        <div class="relative bg-[#120F0C] border border-aurum-border p-8 sm:p-10 flex flex-col justify-between min-h-[360px] overflow-hidden group">
          <div class="absolute inset-0 opacity-25 group-hover:opacity-35 transition-opacity bg-cover bg-center" style="background-image: url('{{ global_asset('images/themes/aurumeclat/boutique-salon.jpg') }}');"></div>
          <div class="relative z-10 space-y-3">
            <h3 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-white font-normal leading-tight">
              Book a Private Appointment
            </h3>
            <div class="text-xs text-aurum-goldLight/90 font-medium">One-on-one. In-store or virtual.</div>
            <ul class="text-xs text-aurum-goldLight/80 font-light space-y-1.5 pt-1">
              <li class="flex items-center gap-2">✦ <span>Personalized Styling</span></li>
              <li class="flex items-center gap-2">✦ <span>Diamond Education</span></li>
              <li class="flex items-center gap-2">✦ <span>Custom Creations</span></li>
            </ul>
          </div>
          <div class="relative z-10 pt-6">
            <a href="#boutique-section" class="inline-block px-7 py-3 bg-[#D4C3A3] text-aurum-black text-[11px] font-semibold tracking-widest uppercase hover:bg-aurum-gold transition-colors">
              BOOK APPOINTMENT
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 8. NEW ARRIVALS ==================== -->
  <section class="bg-[#090807] text-aurum-goldLight py-14 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex items-end justify-between mb-8 pb-3 border-b border-aurum-border/60">
        <div>
          <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-medium block mb-1">
            FRESH FROM THE MAISON
          </span>
          <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal text-white">
            NEW ARRIVALS
          </h2>
        </div>

        <div class="flex items-center gap-4">
          <a href="{{ $aurumRoute('store.shop', ['sort' => 'latest']) }}" class="text-xs tracking-widest text-aurum-gold hover:text-white uppercase font-medium transition-colors">
            VIEW ALL &gt;
          </a>
          <div class="hidden sm:flex items-center gap-1.5">
            <button type="button" class="w-8 h-8 rounded-full border border-aurum-border flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold transition-colors" aria-label="Previous">
              ‹
            </button>
            <button type="button" class="w-8 h-8 rounded-full border border-aurum-border flex items-center justify-center text-white/70 hover:text-aurum-gold hover:border-aurum-gold transition-colors" aria-label="Next">
              ›
            </button>
          </div>
        </div>
      </div>

      <!-- 5-Column Product Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5 sm:gap-5">
        @foreach($newArrivals as $product)
          @include('store.themes.aurumeclat.partials.product-card', ['product' => $product])
        @endforeach
      </div>

    </div>
  </section>

  <!-- ==================== 9. TRUST & GUARANTEES STRIP ==================== -->
  <section class="bg-[#0F0C09] border-b border-aurum-border py-9">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 text-center">
        
        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">IGI / GIA Certified</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">100% Genuine</p>
        </div>

        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">18K &amp; 22K Solid Gold</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Hallmarked Jewelry</p>
        </div>

        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">Secure Insured Delivery</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Safe &amp; Discreet</p>
        </div>

        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">Lifetime Service</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Polish • Resize • Repair</p>
        </div>

        <div class="space-y-1 col-span-2 sm:col-span-1">
          <div class="font-serif text-sm font-semibold text-white">Easy Returns</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">30-Day Policy</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 10. CLIENT TESTIMONIALS ==================== -->
  <section class="bg-[#090807] py-14 lg:py-18 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-2xl mx-auto mb-10">
        <div class="flex items-center justify-center gap-3 text-aurum-gold text-xs mb-1.5">
          <span>—</span><span class="text-xs">✦</span><span>—</span>
        </div>
        <h2 class="font-serif text-xl sm:text-2xl lg:text-3xl text-white font-medium tracking-wide uppercase">
          WHAT OUR CLIENTS SAY
        </h2>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        
        <!-- Review 1 -->
        <div class="bg-[#120F0C] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/aurumeclat/avatar-elena.jpg') }}" alt="Elena Rostova" class="w-11 h-11 rounded-full object-cover border border-aurum-gold/50">
            <div>
              <div class="text-xs font-semibold text-white">Elena Rostova</div>
              <div class="text-[10px] text-aurum-goldLight/50">Geneva, Switzerland</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "The craftsmanship is extraordinary. My ring is more beautiful than I imagined."
          </p>
        </div>

        <!-- Review 2 -->
        <div class="bg-[#120F0C] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/aurumeclat/avatar-marcus.jpg') }}" alt="Marcus Vance" class="w-11 h-11 rounded-full object-cover border border-aurum-gold/50">
            <div>
              <div class="text-xs font-semibold text-white">Marcus Vance</div>
              <div class="text-[10px] text-aurum-goldLight/50">London, United Kingdom</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "AurumÉclat made our engagement moment truly unforgettable."
          </p>
        </div>

        <!-- Review 3 -->
        <div class="bg-[#120F0C] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="{{ global_asset('images/themes/aurumeclat/avatar-sophia.jpg') }}" alt="Sophia Chen" class="w-11 h-11 rounded-full object-cover border border-aurum-gold/50">
            <div>
              <div class="text-xs font-semibold text-white">Sophia Chen</div>
              <div class="text-[10px] text-aurum-goldLight/50">New York, USA</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "The team was patient, kind, and helped me design the perfect necklace."
          </p>
        </div>

      </div>

    </div>
  </section>

  <!-- ==================== 11. MOBILE VIP CLUB CARD ==================== -->
  <div class="lg:hidden p-4 sm:p-6 bg-[#090807]">
    <div class="bg-gradient-to-br from-[#3D1420] via-[#280A12] to-[#140408] border border-[#5E1E2E] p-6 text-center rounded-none shadow-xl space-y-4">
      <div class="font-serif text-2xl text-white font-medium tracking-wide">
        AurumÉclat Club
      </div>
      <p class="text-xs text-aurum-goldLight/80 font-light">
        Join our exclusive membership for special privileges.
      </p>

      <div class="grid grid-cols-3 gap-2 pt-2 text-center">
        <div class="flex flex-col items-center gap-1">
          <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/80 leading-tight mt-1">Early Access<br><span class="text-white/40">New Collections</span></span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/80 leading-tight mt-1">VIP<br><span class="text-white/40">Invitations</span></span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/80 leading-tight mt-1">Complimentary<br><span class="text-white/40">Services</span></span>
        </div>
      </div>

      <div class="pt-2">
        <a href="{{ $aurumRoute('store.register.show') }}" class="inline-block w-full py-2.5 bg-aurum-gold text-aurum-black font-semibold text-xs tracking-widest uppercase">
          JOIN THE CLUB
        </a>
      </div>
    </div>
  </div>

</main>

@include('store.themes.aurumeclat.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
