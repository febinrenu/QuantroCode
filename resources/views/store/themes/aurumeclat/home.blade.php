<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.aurumeclat._shell', ['pageTitle' => ($s->seo_meta_title ?? $s->store_name ?? 'AurumÉclat') . ' — Fine Jewelry | Crafted to Be Treasured'])
</head>
<body class="bg-[#0E0D0B] text-aurum-goldLight antialiased selection:bg-aurum-gold selection:text-aurum-black">

@include('store.themes.aurumeclat.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.aurumeclat.partials.mobile-nav')

@php
  $currency = $s->currency_code ?? '$';
  $hidePrices = !Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
  
  // Fetch real jewelry products from the DB
  $jewelryCat = \App\Models\Category::where('code', 'CAT-IND-JWL')->orWhere('name', 'like', '%Jewel%')->first();
  $catId = $jewelryCat ? $jewelryCat->id : null;
  
  $allJewelryProducts = \App\Models\Product::query()
      ->where('deleted_at', '=', null)
      ->where('is_active', 1)
      ->where('hide_from_online_store', 0)
      ->when($catId, function($q) use ($catId) {
          $q->where('category_id', $catId);
      })
      ->with(['variants', 'images'])
      ->get();

  // Present via StorefrontPresenter
  $presentedJewelry = $allJewelryProducts->map(fn($p) => \App\Support\Storefront\StorefrontPresenter::product($p, $currency, $hidePrices));
  
  // Split into Bestsellers and New Arrivals
  $bestsellers = $presentedJewelry->take(5);
  $newArrivals = $presentedJewelry->skip(5)->take(5);
  if ($newArrivals->isEmpty()) {
      $newArrivals = $bestsellers;
  }
@endphp

<main class="overflow-x-hidden">

  <!-- ==================== 1. HERO SECTION ==================== -->
  <section class="relative bg-gradient-to-b from-[#0B0A08] via-[#12100D] to-[#0E0D0B] border-b border-aurum-border/60 overflow-hidden">
    
    <!-- Background Ambient Glow -->
    <div class="absolute top-1/4 left-1/3 w-96 h-96 bg-aurum-gold/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 grid lg:grid-cols-12 gap-10 items-center">
      
      <!-- Left Column: Copy & Actions -->
      <div class="lg:col-span-6 space-y-6 sm:space-y-8 z-10">
        
        <div>
          <span class="font-serif italic text-2xl sm:text-3xl text-aurum-goldLight/90 tracking-wide block">
            Crafted to Be
          </span>
          <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl xl:text-[80px] font-normal leading-[0.95] text-white tracking-tight mt-1">
            <span class="gold-gradient-text font-serif">Treasured</span>
          </h1>
        </div>

        <p class="text-xs sm:text-sm text-aurum-goldLight/75 font-light leading-relaxed max-w-md">
          Timeless designs. Ethical sourcing.<br class="hidden sm:inline">
          Heirloom quality, for a lifetime.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap items-center gap-4 pt-2">
          <a href="{{ route('store.shop') }}" class="h-11 sm:h-12 px-7 sm:px-8 inline-flex items-center justify-center bg-aurum-gold hover:bg-[#E5C158] text-aurum-black text-[11px] sm:text-xs font-semibold tracking-[0.2em] uppercase transition-all duration-300 shadow-[0_4px_20px_rgba(212,175,55,0.25)]">
            SHOP FINE JEWELRY
          </a>
          <a href="#private-appointment-section" class="h-11 sm:h-12 px-6 sm:px-7 inline-flex items-center justify-center border border-aurum-gold/60 hover:border-aurum-gold hover:bg-aurum-gold/10 text-white text-[11px] sm:text-xs font-medium tracking-[0.18em] uppercase transition-all duration-300">
            BOOK PRIVATE APPOINTMENT
          </a>
        </div>

        <!-- Hero Bottom Trust Badges (Desktop/Tablet) -->
        <div class="pt-6 border-t border-aurum-border/60 flex flex-wrap items-center gap-6 text-[11px] text-aurum-goldLight/70 font-light">
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v8m-4-4h8"></path></svg>
            <span>18K &amp; 22K Solid Gold</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon></svg>
            <span>IGI / GIA Certified</span>
          </div>
          <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-aurum-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
            <span>Lifetime Service Promise</span>
          </div>
        </div>

      </div>

      <!-- Right Column: Editorial Hero Imagery -->
      <div class="lg:col-span-6 relative">
        <div class="relative mx-auto max-w-md lg:max-w-none aspect-[4/5] overflow-hidden border border-aurum-border/60 shadow-2xl">
          <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?auto=format&fit=crop&w=1200&q=85" 
               alt="Fine Jewelry High Craftsmanship" 
               class="w-full h-full object-cover object-center filter brightness-95">
          <div class="absolute inset-0 bg-gradient-to-t from-[#0E0D0B] via-transparent to-transparent opacity-60"></div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==================== 2. QUICK HIGHLIGHTS STRIP ==================== -->
  <section id="gold-rate-section" class="bg-[#F7F3EC] text-[#1A1815] py-10 lg:py-14 border-b border-aurum-sandBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Today's Gold Rate -->
        <div class="bg-white p-5 rounded-none border border-[#E8DFC8] shadow-sm flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between text-[11px] tracking-wider text-aurum-textMuted uppercase font-medium">
              <span>Today's Gold Rate</span>
              <span class="text-emerald-700 font-semibold">+0.42%</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="text-xs font-semibold text-aurum-textDark">24K (999)</span>
              <span class="font-serif text-2xl font-bold text-aurum-textDark">$2,362</span>
              <span class="text-[11px] text-aurum-textMuted font-light">/oz</span>
            </div>
            <div class="text-[11px] text-aurum-textMuted mt-1">
              22K (916) &nbsp;<span class="font-semibold text-aurum-textDark">$2,165</span> /oz
            </div>
            <!-- Sparkline Line -->
            <div class="mt-3 h-6 w-full flex items-end gap-1">
              <span class="h-2 w-full bg-amber-200"></span>
              <span class="h-3 w-full bg-amber-200"></span>
              <span class="h-2.5 w-full bg-amber-300"></span>
              <span class="h-4 w-full bg-amber-400"></span>
              <span class="h-5 w-full bg-amber-500"></span>
              <span class="h-6 w-full bg-amber-600"></span>
            </div>
          </div>
          <a href="{{ route('store.shop', ['q' => 'gold coin']) }}" class="mt-4 inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
            <span>VIEW LIVE GOLD RATE</span>
            <span>&rarr;</span>
          </a>
        </div>

        <!-- Card 2: Certified Diamonds -->
        <div class="bg-white p-5 rounded-none border border-[#E8DFC8] shadow-sm flex flex-col justify-between">
          <div>
            <div class="text-[11px] tracking-wider text-aurum-textMuted uppercase font-medium">Authenticity</div>
            <h3 class="font-serif text-xl font-bold text-aurum-textDark mt-1">Certified Diamonds</h3>
            <p class="text-xs text-aurum-textMuted mt-1.5 leading-relaxed font-light">
              IGI / GIA Certified<br>
              Conflict-Free • 100% Natural
            </p>
          </div>
          <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('store.shop', ['q' => 'diamond']) }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
              <span>EXPLORE DIAMONDS</span>
              <span>&rarr;</span>
            </a>
            <div class="text-xl text-amber-600">💎</div>
          </div>
        </div>

        <!-- Card 3: Custom Design Consultation -->
        <div id="custom-design-section" class="bg-white p-5 rounded-none border border-[#E8DFC8] shadow-sm flex flex-col justify-between">
          <div>
            <div class="text-[11px] tracking-wider text-aurum-textMuted uppercase font-medium">Bespoke Atelier</div>
            <h3 class="font-serif text-xl font-bold text-aurum-textDark mt-1">Custom Design</h3>
            <p class="text-xs text-aurum-textMuted mt-1.5 leading-relaxed font-light">
              Bring your dream piece to life with our master jewelers.
            </p>
          </div>
          <div class="mt-4 flex items-center justify-between">
            <a href="#private-appointment-section" class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
              <span>BOOK CONSULTATION</span>
              <span>&rarr;</span>
            </a>
            <div class="text-xl text-amber-600">✨</div>
          </div>
        </div>

        <!-- Card 4: Bridal & Wedding -->
        <div class="bg-white p-5 rounded-none border border-[#E8DFC8] shadow-sm flex flex-col justify-between">
          <div>
            <div class="text-[11px] tracking-wider text-aurum-textMuted uppercase font-medium">Eternal Love</div>
            <h3 class="font-serif text-xl font-bold text-aurum-textDark mt-1">Bridal &amp; Wedding</h3>
            <p class="text-xs text-aurum-textMuted mt-1.5 leading-relaxed font-light">
              Celebrate forever with heirloom engagement &amp; eternity bands.
            </p>
          </div>
          <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('store.shop', ['q' => 'bridal']) }}" class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider text-aurum-goldDark uppercase hover:underline">
              <span>EXPLORE BRIDAL</span>
              <span>&rarr;</span>
            </a>
            <div class="text-xl text-amber-600">💍</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 3. SHOP BY SIGNATURE COLLECTION ==================== -->
  <section class="bg-[#F7F3EC] text-[#1A1815] pb-16 lg:pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Title -->
      <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
        <div class="flex items-center justify-center gap-3 text-aurum-goldDark text-xs mb-2">
          <span>—</span><span>✦</span><span>—</span>
        </div>
        <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal tracking-wide text-aurum-textDark uppercase">
          Shop by Signature Collection
        </h2>
      </div>

      <!-- 8 Arched / Curved Collection Cards Grid -->
      @php
        $collections = [
          ['name' => 'DIAMOND RINGS', 'q' => 'ring', 'img' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'BRIDAL SETS', 'q' => 'bridal', 'img' => 'https://images.unsplash.com/photo-1543290954-bc6543611b40?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'NECKLACES', 'q' => 'necklace', 'img' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'EARRINGS', 'q' => 'earring', 'img' => 'https://images.unsplash.com/photo-1630019852942-f89202989a59?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'BANGLES', 'q' => 'bangle', 'img' => 'https://images.unsplash.com/photo-1611591475102-468ae0842065?auto=format&fit=crop&w=600&q=80'],
          ['name' => "MEN'S JEWELRY", 'q' => 'signet', 'img' => 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'PEARLS', 'q' => 'pearl', 'img' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?auto=format&fit=crop&w=600&q=80'],
          ['name' => 'GEMSTONES', 'q' => 'sapphire', 'img' => 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?auto=format&fit=crop&w=600&q=80'],
        ];
      @endphp

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        @foreach($collections as $col)
          <a href="{{ route('store.shop', ['q' => $col['q']]) }}" class="group block relative overflow-hidden bg-[#161411] border border-[#E5DAC8] aspect-[4/3] rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
            <img src="{{ $col['img'] }}" alt="{{ $col['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 brightness-90 group-hover:brightness-100">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <div class="absolute bottom-3 inset-x-3 text-center">
              <span class="font-serif tracking-[0.18em] text-[11px] sm:text-xs font-semibold text-white group-hover:text-aurum-gold transition-colors uppercase">
                {{ $col['name'] }}
              </span>
            </div>
          </a>
        @endforeach
      </div>

      <!-- Explore All Button -->
      <div class="text-center mt-10">
        <a href="{{ route('store.shop') }}" class="inline-flex items-center justify-center px-8 py-3 bg-[#E8D5B5] hover:bg-[#DFC7A2] text-[#1A1815] text-xs font-semibold tracking-[0.2em] uppercase transition-colors">
          EXPLORE ALL COLLECTIONS
        </a>
      </div>

    </div>
  </section>

  <!-- ==================== 4. BESTSELLING PIECES ==================== -->
  <section class="bg-[#0E0D0B] text-aurum-goldLight py-16 lg:py-20 border-t border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header with Arrows -->
      <div class="flex items-end justify-between mb-10 pb-4 border-b border-aurum-border/60">
        <div>
          <span class="text-[10px] sm:text-[11px] tracking-[0.25em] text-aurum-gold uppercase font-medium block mb-1">
            CURATED HIGH-JEWELRY
          </span>
          <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal text-white">
            Bestselling Pieces
          </h2>
        </div>

        <div class="flex items-center gap-4">
          <a href="{{ route('store.shop', ['sort' => 'bestselling']) }}" class="hidden sm:inline-block text-xs tracking-widest text-aurum-gold hover:text-white uppercase font-medium transition-colors">
            VIEW ALL →
          </a>
          <div class="flex items-center gap-1.5">
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
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">
        @foreach($bestsellers as $product)
          @include('store.themes.aurumeclat.partials.product-card', ['product' => $product])
        @endforeach
      </div>

    </div>
  </section>

  <!-- ==================== 5. HERITAGE MONOGRAM & 4-PILLAR GRID ==================== -->
  <section class="bg-[#12100E] border-y border-aurum-border py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 lg:grid-cols-5 gap-8 items-center text-center">
        
        <!-- Pillar 1 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-lg text-white font-medium">The Bridal Edit</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Celebrate your forever</p>
          <a href="{{ route('store.shop', ['q' => 'bridal']) }}" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            EXPLORE
          </a>
        </div>

        <!-- Pillar 2 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-lg text-white font-medium">Timeless Heirlooms</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Made to be passed down</p>
          <a href="{{ route('store.shop') }}" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            DISCOVER
          </a>
        </div>

        <!-- Center Monogram Crest -->
        <div class="col-span-2 lg:col-span-1 flex flex-col items-center justify-center my-2 lg:my-0">
          <div class="w-16 h-16 rounded-full border-2 border-aurum-gold/60 flex items-center justify-center text-aurum-gold font-serif text-2xl font-bold bg-[#1A1713] shadow-lg">
            A
          </div>
          <span class="text-[9px] tracking-[0.25em] text-aurum-gold uppercase font-medium mt-2">
            ROOTED IN HERITAGE
          </span>
        </div>

        <!-- Pillar 3 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-lg text-white font-medium">Custom Crafted</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Your vision, our artistry</p>
          <a href="#custom-design-section" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            START DESIGN
          </a>
        </div>

        <!-- Pillar 4 -->
        <div class="space-y-1.5">
          <h4 class="font-serif text-lg text-white font-medium">Certified Purity</h4>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Trust in every detail</p>
          <a href="#gold-rate-section" class="inline-block text-[10px] tracking-widest text-aurum-gold uppercase font-semibold hover:underline pt-1">
            LEARN MORE
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 6. TWO-COLUMN EDITORIAL FEATURE ==================== -->
  <section id="private-appointment-section" class="bg-[#0E0D0B] py-16 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-2 gap-8">
        
        <!-- Left Column: Design Your Piece -->
        <div class="relative bg-[#151310] border border-aurum-border p-8 sm:p-10 flex flex-col justify-between min-h-[380px] overflow-hidden group">
          <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1598560917505-59a3ad559071?auto=format&fit=crop&w=800&q=80');"></div>
          <div class="relative z-10 space-y-4">
            <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-semibold">BESPOKE JEWELRY</span>
            <h3 class="font-serif text-3xl sm:text-4xl text-white font-normal leading-tight">
              Design Your Piece
            </h3>
            <p class="text-xs sm:text-sm text-aurum-goldLight/70 font-light leading-relaxed max-w-sm">
              Make it uniquely yours. From concept to creation, we craft jewelry as unique as your story.
            </p>
          </div>
          <div class="relative z-10 pt-6">
            <a href="#custom-design-section" class="inline-flex items-center gap-2 text-xs tracking-widest text-aurum-gold font-semibold uppercase hover:underline">
              <span>START CUSTOM DESIGN</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Right Column: Book Private Appointment -->
        <div class="relative bg-[#151310] border border-aurum-border p-8 sm:p-10 flex flex-col justify-between min-h-[380px] overflow-hidden group">
          <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1524758631624-e2822e304c36?auto=format&fit=crop&w=800&q=80');"></div>
          <div class="relative z-10 space-y-4">
            <span class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-semibold">VIP SALON</span>
            <h3 class="font-serif text-3xl sm:text-4xl text-white font-normal leading-tight">
              Book a Private Appointment
            </h3>
            <ul class="text-xs sm:text-sm text-aurum-goldLight/80 font-light space-y-2">
              <li class="flex items-center gap-2">✦ <span>Personalized Styling &amp; Curations</span></li>
              <li class="flex items-center gap-2">✦ <span>Diamond Education &amp; Inspection</span></li>
              <li class="flex items-center gap-2">✦ <span>Bespoke Bridal Consultations</span></li>
            </ul>
          </div>
          <div class="relative z-10 pt-6">
            <a href="#boutique-section" class="inline-block px-7 py-3 bg-aurum-gold text-aurum-black text-xs font-semibold tracking-widest uppercase hover:bg-aurum-goldLight transition-colors">
              BOOK APPOINTMENT
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== 7. NEW ARRIVALS ==================== -->
  <section class="bg-[#0E0D0B] text-aurum-goldLight py-16 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="flex items-end justify-between mb-10 pb-4 border-b border-aurum-border/60">
        <div>
          <span class="text-[10px] sm:text-[11px] tracking-[0.25em] text-aurum-gold uppercase font-medium block mb-1">
            FRESH FROM THE MAISON
          </span>
          <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-normal text-white">
            New Arrivals
          </h2>
        </div>

        <div class="flex items-center gap-4">
          <a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hidden sm:inline-block text-xs tracking-widest text-aurum-gold hover:text-white uppercase font-medium transition-colors">
            VIEW ALL →
          </a>
          <div class="flex items-center gap-1.5">
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
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">
        @foreach($newArrivals as $product)
          @include('store.themes.aurumeclat.partials.product-card', ['product' => $product])
        @endforeach
      </div>

    </div>
  </section>

  <!-- ==================== 8. TRUST & GUARANTEES STRIP ==================== -->
  <section class="bg-[#12100E] border-b border-aurum-border py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 text-center">
        
        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">IGI / GIA Certified</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">100% Genuine Stones</p>
        </div>

        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">18K &amp; 22K Solid Gold</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Hallmarked Jewelry</p>
        </div>

        <div class="space-y-1">
          <div class="font-serif text-sm font-semibold text-white">Secure Insured Delivery</div>
          <p class="text-[11px] text-aurum-goldLight/60 font-light">Safe &amp; Discreet Packaging</p>
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

  <!-- ==================== 9. CLIENT TESTIMONIALS ==================== -->
  <section class="bg-[#0E0D0B] py-16 lg:py-20 border-b border-aurum-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-2xl mx-auto mb-12">
        <div class="text-[10px] tracking-[0.25em] text-aurum-gold uppercase font-semibold mb-2">PRAISE &amp; PATRONAGE</div>
        <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl text-white font-normal">
          What Our Clients Say
        </h2>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        
        <!-- Review 1 -->
        <div class="bg-[#141210] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=120&q=80" alt="Elena V." class="w-10 h-10 rounded-full object-cover border border-aurum-gold/40">
            <div>
              <div class="text-xs font-semibold text-white">Elena Rostova</div>
              <div class="text-[10px] text-aurum-goldLight/50">Geneva, Switzerland</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "The solitaire ring exceeded every expectation. The diamond's fire and setting quality rival heritage high-jewelry houses."
          </p>
        </div>

        <!-- Review 2 -->
        <div class="bg-[#141210] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80" alt="Marcus T." class="w-10 h-10 rounded-full object-cover border border-aurum-gold/40">
            <div>
              <div class="text-xs font-semibold text-white">Marcus Vance</div>
              <div class="text-[10px] text-aurum-goldLight/50">London, United Kingdom</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "The custom design process for our 10th anniversary necklace was seamless. Truly white-glove craftsmanship and care."
          </p>
        </div>

        <!-- Review 3 -->
        <div class="bg-[#141210] border border-aurum-border p-6 space-y-4">
          <div class="flex items-center gap-3">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80" alt="Sophia L." class="w-10 h-10 rounded-full object-cover border border-aurum-gold/40">
            <div>
              <div class="text-xs font-semibold text-white">Sophia Chen</div>
              <div class="text-[10px] text-aurum-goldLight/50">New York, USA</div>
            </div>
          </div>
          <div class="text-aurum-gold text-xs">★★★★★</div>
          <p class="text-xs text-aurum-goldLight/80 font-light leading-relaxed italic font-serif text-[13px]">
            "The emerald drop earrings are breathtaking in person. Insured packaging was immaculate and discreet."
          </p>
        </div>

      </div>

    </div>
  </section>

  <!-- ==================== 10. MOBILE VIP CLUB CARD ==================== -->
  <div class="lg:hidden p-4 sm:p-6 bg-[#0B0A08]">
    <div class="bg-gradient-to-br from-[#38111B] via-[#240A11] to-[#14060A] border border-[#5E1E2E] p-6 text-center rounded-none shadow-xl space-y-4">
      <div class="font-serif text-2xl text-white font-medium tracking-wide">
        AurumÉclat Club
      </div>
      <p class="text-xs text-aurum-goldLight/80 font-light">
        Join our exclusive membership for special privileges.
      </p>

      <div class="grid grid-cols-3 gap-2 pt-2 text-center">
        <div class="flex flex-col items-center gap-1">
          <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/70 leading-tight">Early Access</span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/70 leading-tight">VIP Invitations</span>
        </div>

        <div class="flex flex-col items-center gap-1">
          <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-aurum-gold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
          </div>
          <span class="text-[9px] text-aurum-goldLight/70 leading-tight">Complimentary Services</span>
        </div>
      </div>

      <div class="pt-2">
        <a href="{{ route('store.register.show') }}" class="inline-block w-full py-2.5 bg-aurum-gold text-aurum-black font-semibold text-xs tracking-widest uppercase">
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
