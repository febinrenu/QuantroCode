@extends('store.themes.paperloom._shell')

@section('title', 'PaperLoom — Books, Study & Stationery')

@section('content')

@php
  use App\Models\Product;
  use App\Models\Category;

  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $plRoute('store.shop');

  // Load active PaperLoom products
  $highlights = Product::where('code', 'like', 'PPL-%')
      ->whereIn('code', [
          'PPL-BOK-001', 'PPL-NOT-001', 'PPL-PEN-001', 'PPL-ART-001',
          'PPL-STK-001', 'PPL-DSK-001', 'PPL-LMP-001', 'PPL-HLT-001'
      ])
      ->take(8)
      ->get();

  $staffPicks = Product::where('code', 'like', 'PPL-%')
      ->whereIn('code', [
          'PPL-BOK-002', 'PPL-BOK-003', 'PPL-PEN-002',
          'PPL-NOT-002', 'PPL-ACC-001', 'PPL-BOK-004'
      ])
      ->take(6)
      ->get();

  $interestCategories = [
      ['name' => 'Fiction', 'slug' => 'Fiction', 'desc' => 'Novels & Classics', 'icon' => 'cat-fiction.jpg'],
      ['name' => 'Non-Fiction', 'slug' => 'Non-Fiction', 'desc' => 'History & Science', 'icon' => 'cat-non-fiction.jpg'],
      ['name' => 'Children', 'slug' => 'Children', 'desc' => 'Picture Books', 'icon' => 'cat-children.jpg'],
      ['name' => 'Academic', 'slug' => 'Academic', 'desc' => 'Study & Textbooks', 'icon' => 'cat-academic.jpg'],
      ['name' => 'Notebooks', 'slug' => 'Notebooks', 'desc' => 'Planners & Spiral', 'icon' => 'cat-notebooks.jpg'],
      ['name' => 'Journals', 'slug' => 'Journals', 'desc' => 'Leather & Guided', 'icon' => 'cat-journals.jpg'],
      ['name' => 'Art Supplies', 'slug' => 'Art Supplies', 'desc' => 'Paints & Pencils', 'icon' => 'cat-art-supplies.jpg'],
      ['name' => 'Desk Accessories', 'slug' => 'Desk Accessories', 'desc' => 'Lamps & Storage', 'icon' => 'cat-desk-accessories.jpg'],
  ];

  $studyEssentials = [
      ['name' => 'Planners & Agendas', 'category' => 'Notebooks', 'icon' => 'weekly-planner-sage.jpg'],
      ['name' => 'Highlighters & Markers', 'category' => 'Stationery', 'icon' => 'zebra-midliner-highlighters.jpg'],
      ['name' => 'Binder Sets & Folders', 'category' => 'Academic', 'icon' => 'academic-binder-set.jpg'],
      ['name' => 'Desk Calendars', 'category' => 'Desk Accessories', 'icon' => 'desk-calendar-wood.jpg'],
      ['name' => 'Calculators & Tools', 'category' => 'Academic', 'icon' => 'scientific-calculator.jpg'],
      ['name' => 'Index Tabs & Flags', 'category' => 'Stationery', 'icon' => 'morandi-index-tabs.jpg'],
      ['name' => 'Desk Organizers', 'category' => 'Desk Accessories', 'icon' => 'desk-organizer-bamboo.jpg'],
  ];
@endphp

<div class="space-y-12 sm:space-y-16 pb-16">

  <!-- =========================================================================
       1. HERO SECTION (3-Card Composition strictly matching reference)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

      <!-- Main Hero Card (8 cols on desktop) -->
      <div class="lg:col-span-8 rounded-3xl overflow-hidden relative bg-[#F3EFE6] border border-pl-border shadow-sm flex flex-col justify-between min-h-[440px] sm:min-h-[500px]">
        <!-- Background Editorial Image -->
        <img src="{{ global_asset('images/themes/paperloom/hero-main.jpg') }}"
             alt="PaperLoom Read, Write, Create"
             class="absolute inset-0 w-full h-full object-cover object-center">

        <!-- Gradient Overlay for readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#F8F5EE]/95 via-[#F8F5EE]/80 to-transparent sm:w-3/5"></div>

        <!-- Content -->
        <div class="relative z-10 p-6 sm:p-12 max-w-lg space-y-4 sm:space-y-6 my-auto">
          <span class="inline-block px-3 py-1 bg-pl-forest text-white rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider">
            Curated Bookstore & Stationery
          </span>
          <h1 class="font-serif-book text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight leading-[1.1]">
            Read, Write,<br>Create.
          </h1>
          <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
            Discover inspiring books and premium stationery for study, work, and everyday creativity.
          </p>

          <div class="pt-2 flex flex-wrap items-center gap-3">
            <a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}"
               class="px-6 sm:px-8 py-3.5 bg-pl-terracotta hover:bg-pl-terracottaHover text-white text-xs sm:text-sm font-bold rounded-full transition-all shadow-md active:scale-95">
              Shop Books
            </a>
            <a href="{{ $plRoute('store.shop', ['category' => 'Stationery']) }}"
               class="px-6 sm:px-8 py-3.5 bg-white/90 hover:bg-white text-slate-900 border border-pl-border text-xs sm:text-sm font-bold rounded-full transition-all shadow-xs active:scale-95">
              Explore Stationery
            </a>
          </div>
        </div>
      </div>

      <!-- Right Supporting Cards (4 cols on desktop, 2 stacked cards) -->
      <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-6">

        <!-- Top Card: Back to School Essentials -->
        <div class="flex-1 rounded-3xl overflow-hidden relative bg-[#1E3A34] text-white border border-pl-border p-6 sm:p-7 flex flex-col justify-between min-h-[220px] group">
          <img src="{{ global_asset('images/themes/paperloom/hero-bts.jpg') }}"
               alt="Back to School Essentials"
               class="absolute inset-0 w-full h-full object-cover opacity-35 group-hover:scale-105 transition-transform duration-700">
          <div class="relative z-10 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">Seasonal Special</span>
            <h3 class="font-serif-book text-2xl font-bold leading-tight">Back to School<br>Essentials</h3>
            <p class="text-xs text-slate-200">Everything you need to start strong.</p>
          </div>
          <div class="relative z-10 pt-4">
            <a href="{{ $plRoute('store.shop', ['category' => 'Academic']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-white transition-colors">
              <span>Shop Now</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

        <!-- Bottom Card: Curated Reading Picks -->
        <div class="flex-1 rounded-3xl overflow-hidden relative bg-[#F5EFE6] text-slate-900 border border-pl-border p-6 sm:p-7 flex flex-col justify-between min-h-[220px] group">
          <img src="{{ global_asset('images/themes/paperloom/hero-reading-picks.jpg') }}"
               alt="Curated Reading Picks"
               class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-700">
          <div class="relative z-10 space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-pl-terracotta">Editor's Choice</span>
            <h3 class="font-serif-book text-2xl font-bold leading-tight">Curated Reading<br>Picks</h3>
            <p class="text-xs text-slate-600">Editor's picks for every kind of reader.</p>
          </div>
          <div class="relative z-10 pt-4">
            <a href="{{ $plRoute('store.shop', ['collection' => 'staff-picks']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-pl-terracotta hover:text-pl-terracottaHover transition-colors">
              <span>Explore Now</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       2. SERVICE / TRUST STRIP (5 items)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-2xl border border-pl-border p-4 sm:p-6 shadow-xs">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-4 divide-y md:divide-y-0 md:divide-x divide-pl-border/60">

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4 first:pt-0 first:px-0">
          <div class="w-10 h-10 rounded-xl bg-pl-cream flex items-center justify-center text-lg text-slate-800 shrink-0">
            🚚
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Fast Delivery</h4>
            <p class="text-[11px] text-slate-500">Across the U.S.</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-pl-cream flex items-center justify-center text-lg text-slate-800 shrink-0">
            🎁
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Gift Wrapping</h4>
            <p class="text-[11px] text-slate-500">Make it special</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-pl-cream flex items-center justify-center text-lg text-slate-800 shrink-0">
            🎓
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Student Discounts</h4>
            <p class="text-[11px] text-slate-500">Save More</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-pl-cream flex items-center justify-center text-lg text-slate-800 shrink-0">
            🔒
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Secure Checkout</h4>
            <p class="text-[11px] text-slate-500">100% Safe</p>
          </div>
        </div>

        <div class="flex items-center gap-3 pt-2 md:pt-0 md:px-4">
          <div class="w-10 h-10 rounded-xl bg-pl-cream flex items-center justify-center text-lg text-slate-800 shrink-0">
            🔄
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900 leading-tight">Easy Returns</h4>
            <p class="text-[11px] text-slate-500">Hassle Free</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================================
       3. SHOP BY INTEREST (8 Round Category Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-6">
      <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
        Shop by Interest
      </h2>
      <a href="{{ $shopUrl }}" class="text-xs font-bold text-pl-terracotta hover:underline">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
      @foreach($interestCategories as $catItem)
        <a href="{{ $plRoute('store.shop', ['category' => $catItem['slug']]) }}"
           class="group bg-white rounded-2xl border border-pl-border p-4 text-center flex flex-col items-center justify-center gap-3 pl-card">
          <div class="w-16 h-16 rounded-2xl bg-pl-cream flex items-center justify-center overflow-hidden border border-pl-border/60 group-hover:bg-pl-sand transition-colors">
            <img src="{{ global_asset('images/themes/paperloom/' . $catItem['icon']) }}"
                 alt="{{ $catItem['name'] }}"
                 class="w-12 h-12 object-contain group-hover:scale-110 transition-transform">
          </div>
          <div>
            <h3 class="text-xs font-bold text-slate-900 group-hover:text-pl-terracotta transition-colors leading-tight">
              {{ $catItem['name'] }}
            </h3>
            <span class="text-[10px] text-slate-400 block mt-0.5">{{ $catItem['desc'] }}</span>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       4. THIS MONTH'S HIGHLIGHTS (8 Products in 4x2 Grid)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
      <div>
        <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
          This Month's Highlights
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
          Handpicked favorites for your studies, creativity & beyond.
        </p>
      </div>
      <a href="{{ $plRoute('store.shop', ['collection' => 'highlights']) }}" class="text-xs font-bold text-pl-terracotta hover:underline shrink-0">
        View All Highlights &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
      @foreach($highlights as $prod)
        @include('store.themes.paperloom.partials.product-card', ['product' => $prod])
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       5. PROMOTIONAL / EDITORIAL CARDS (3 Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Card 1: Back to School -->
      <div class="rounded-3xl overflow-hidden relative bg-[#2D524A] text-white border border-pl-border p-7 flex flex-col justify-between min-h-[280px] group shadow-xs">
        <img src="{{ global_asset('images/themes/paperloom/promo-back-to-school.jpg') }}"
             alt="Back to School"
             class="absolute inset-0 w-full h-full object-cover opacity-35 group-hover:scale-105 transition-transform duration-700">
        <div class="relative z-10 space-y-2">
          <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">New Semester</span>
          <h3 class="font-serif-book text-2xl sm:text-3xl font-bold leading-tight">Back to School<br>Ready, Set, Learn!</h3>
          <p class="text-xs text-slate-200">Backpacks, notebooks, pens & more – everything for a great start.</p>
        </div>
        <div class="relative z-10 pt-4">
          <a href="{{ $plRoute('store.shop', ['category' => 'Academic']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-amber-300 hover:text-white transition-colors">
            <span>Shop Now</span>
            <span>&rarr;</span>
          </a>
        </div>
      </div>

      <!-- Card 2: Writer's Corner -->
      <div class="rounded-3xl overflow-hidden relative bg-[#FAF6F0] text-slate-900 border border-pl-border p-7 flex flex-col justify-between min-h-[280px] group shadow-xs">
        <img src="{{ global_asset('images/themes/paperloom/promo-writers-corner.jpg') }}"
             alt="Writer's Corner"
             class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-700">
        <div class="relative z-10 space-y-2">
          <span class="text-[10px] font-bold uppercase tracking-wider text-pl-terracotta">Craft & Words</span>
          <h3 class="font-serif-book text-2xl sm:text-3xl font-bold leading-tight">Writer's Corner</h3>
          <p class="text-xs text-slate-600">Tools for thoughts that inspire.</p>
        </div>
        <div class="relative z-10 pt-4">
          <a href="{{ $plRoute('store.shop', ['category' => 'Journals']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-pl-terracotta hover:text-pl-terracottaHover transition-colors">
            <span>Explore Collection</span>
            <span>&rarr;</span>
          </a>
        </div>
      </div>

      <!-- Card 3: Kids Reading Club -->
      <div class="rounded-3xl overflow-hidden relative bg-[#F5EFE6] text-slate-900 border border-pl-border p-7 flex flex-col justify-between min-h-[280px] group shadow-xs">
        <img src="{{ global_asset('images/themes/paperloom/promo-kids-club.jpg') }}"
             alt="Kids Reading Club"
             class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-700">
        <div class="relative z-10 space-y-2">
          <span class="text-[10px] font-bold uppercase tracking-wider text-amber-700">Young Readers</span>
          <h3 class="font-serif-book text-2xl sm:text-3xl font-bold leading-tight">Kids Reading Club</h3>
          <p class="text-xs text-slate-600">Stories today, bright minds tomorrow.</p>
        </div>
        <div class="relative z-10 pt-4">
          <a href="{{ $plRoute('store.shop', ['category' => 'Children']) }}" class="inline-flex items-center gap-2 text-xs font-bold text-pl-terracotta hover:text-pl-terracottaHover transition-colors">
            <span>Explore Books</span>
            <span>&rarr;</span>
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       6. STAFF PICKS (6 Products)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
      <div>
        <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
          Staff Picks
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
          Our team's current literary and stationery favorites.
        </p>
      </div>
      <a href="{{ $plRoute('store.shop', ['collection' => 'staff-picks']) }}" class="text-xs font-bold text-pl-terracotta hover:underline shrink-0">
        View All &rarr;
      </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
      @foreach($staffPicks as $prod)
        @include('store.themes.paperloom.partials.product-card', ['product' => $prod])
      @endforeach
    </div>
  </section>

  <!-- =========================================================================
       7. STUDY & WORK ESSENTIALS (7 Quick Pill Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl border border-pl-border p-6 sm:p-8 shadow-xs space-y-6">
      <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-2">
        <div>
          <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
            Study & Work Essentials
          </h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Everything to keep you organized and productive.
          </p>
        </div>
        <a href="{{ $plRoute('store.shop', ['collection' => 'study-essentials']) }}" class="text-xs font-bold text-pl-terracotta hover:underline">
          Shop All Essentials &rarr;
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
        @foreach($studyEssentials as $ess)
          <a href="{{ $plRoute('store.shop', ['category' => $ess['category']]) }}"
             class="p-3.5 rounded-2xl bg-pl-cream hover:bg-pl-sand border border-pl-border/70 text-center flex flex-col items-center justify-between gap-2.5 transition-all group">
            <div class="w-14 h-14 rounded-xl bg-white flex items-center justify-center overflow-hidden border border-pl-border/60">
              <img src="{{ global_asset('images/themes/paperloom/' . $ess['icon']) }}"
                   alt="{{ $ess['name'] }}"
                   class="w-10 h-10 object-contain group-hover:scale-110 transition-transform">
            </div>
            <span class="text-xs font-semibold text-slate-800 leading-tight group-hover:text-pl-terracotta transition-colors">
              {{ $ess['name'] }}
            </span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- =========================================================================
       8. READING JOURNAL / INSPIRATION (3 Editorial Article Cards)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
      <div>
        <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
          Reading Journal / Inspiration
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
          Read, reflect, repeat.
        </p>
      </div>
      <a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}" class="text-xs font-bold text-pl-terracotta hover:underline shrink-0">
        View All Articles &rarr;
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Article 1 -->
      <article class="bg-white rounded-3xl border border-pl-border overflow-hidden pl-card flex flex-col justify-between">
        <div class="aspect-[16/10] overflow-hidden bg-pl-cream">
          <img src="{{ global_asset('images/themes/paperloom/article-reading-habit.jpg') }}"
               alt="How to Build a Reading Habit That Sticks"
               class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-6 space-y-2 flex-1 flex flex-col justify-between">
          <div>
            <span class="text-[11px] font-bold text-pl-terracotta uppercase tracking-wider block mb-1">Study & Habits</span>
            <h3 class="font-serif-book text-lg sm:text-xl font-bold text-slate-900 leading-snug">
              How to Build a Reading Habit That Sticks
            </h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
              Practical daily frameworks and routine tips to read 30+ books a year without stress.
            </p>
          </div>
          <div class="pt-4 border-t border-pl-border/60">
            <a href="{{ $plRoute('store.shop', ['q' => 'reading-habit']) }}" class="text-xs font-bold text-slate-900 hover:text-pl-terracotta transition-colors flex items-center gap-1.5">
              <span>Read More</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>
      </article>

      <!-- Article 2 -->
      <article class="bg-white rounded-3xl border border-pl-border overflow-hidden pl-card flex flex-col justify-between">
        <div class="aspect-[16/10] overflow-hidden bg-pl-cream">
          <img src="{{ global_asset('images/themes/paperloom/article-top-10-books.jpg') }}"
               alt="Top 10 Books You Shouldn't Miss This Month"
               class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-6 space-y-2 flex-1 flex flex-col justify-between">
          <div>
            <span class="text-[11px] font-bold text-pl-forest uppercase tracking-wider block mb-1">Book Reviews</span>
            <h3 class="font-serif-book text-lg sm:text-xl font-bold text-slate-900 leading-snug">
              Top 10 Books You Shouldn't Miss This Month
            </h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
              Handpicked must-reads across literary fiction, psychological thrillers, and biographies.
            </p>
          </div>
          <div class="pt-4 border-t border-pl-border/60">
            <a href="{{ $plRoute('store.shop', ['q' => 'top-books']) }}" class="text-xs font-bold text-slate-900 hover:text-pl-terracotta transition-colors flex items-center gap-1.5">
              <span>Read More</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>
      </article>

      <!-- Article 3 -->
      <article class="bg-white rounded-3xl border border-pl-border overflow-hidden pl-card flex flex-col justify-between">
        <div class="aspect-[16/10] overflow-hidden bg-pl-cream">
          <img src="{{ global_asset('images/themes/paperloom/article-desk-setup.jpg') }}"
               alt="Desk Setup Inspiration for Focus & Flow"
               class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-6 space-y-2 flex-1 flex flex-col justify-between">
          <div>
            <span class="text-[11px] font-bold text-amber-700 uppercase tracking-wider block mb-1">Workspace Aesthetic</span>
            <h3 class="font-serif-book text-lg sm:text-xl font-bold text-slate-900 leading-snug">
              Desk Setup Inspiration for Focus & Flow
            </h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
              Create a calming, distraction-free study space with natural light, wood textures, and warm lighting.
            </p>
          </div>
          <div class="pt-4 border-t border-pl-border/60">
            <a href="{{ $plRoute('store.shop', ['q' => 'desk-setup']) }}" class="text-xs font-bold text-slate-900 hover:text-pl-terracotta transition-colors flex items-center gap-1.5">
              <span>Read More</span>
              <span>&rarr;</span>
            </a>
          </div>
        </div>
      </article>

    </div>
  </section>

  <!-- =========================================================================
       9. JOIN THE PAPERLOOM CLUB (Deep Forest Green Banner)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-[#1E3A34] text-white rounded-3xl p-8 sm:p-12 border border-[#16282E] shadow-lg flex flex-col lg:flex-row items-center justify-between gap-8 relative overflow-hidden">

      <!-- Left Motif & Headline -->
      <div class="flex items-center gap-6 max-w-xl">
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white/10 flex items-center justify-center text-3xl sm:text-4xl shrink-0">
          🌿
        </div>
        <div class="space-y-1.5">
          <span class="text-xs font-bold uppercase tracking-wider text-amber-300 block">VIP Membership</span>
          <h3 class="font-serif-book text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight">
            Join the PaperLoom Club
          </h3>
          <p class="text-xs sm:text-sm text-slate-300 font-light">
            More than a membership, it's a community of readers & creators.
          </p>
        </div>
      </div>

      <!-- Perks Strip -->
      <div class="flex flex-wrap items-center gap-6 sm:gap-8 text-xs text-slate-200">
        <div class="flex items-center gap-2">
          <span>📦</span> <span>Early Access to New Arrivals</span>
        </div>
        <div class="flex items-center gap-2">
          <span>🏷️</span> <span>Member Discounts</span>
        </div>
        <div class="flex items-center gap-2">
          <span>📖</span> <span>Monthly Reading Guides</span>
        </div>
      </div>

      <!-- Action Button -->
      <a href="{{ $plRoute('store.shop', ['action' => 'club']) }}"
         class="px-8 py-3.5 bg-pl-cream hover:bg-white text-slate-900 rounded-full text-xs sm:text-sm font-bold tracking-wide transition-all shadow-md shrink-0 active:scale-95">
        Join Now – It's Free
      </a>

    </div>
  </section>

  <!-- =========================================================================
       10. TESTIMONIALS (Loved by Readers & Creators)
       ========================================================================= -->
  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-xl mx-auto mb-8 space-y-1">
      <h2 class="font-serif-book text-2xl sm:text-3xl font-bold text-slate-900">
        Loved by Readers & Creators
      </h2>
      <p class="text-xs sm:text-sm text-slate-500">
        What our book club and stationery lovers say.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      <!-- Review 1 -->
      <div class="bg-white rounded-3xl border border-pl-border p-6 sm:p-7 space-y-4 shadow-xs flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-amber-500 text-sm">★★★★★</div>
          <p class="text-xs sm:text-sm text-slate-700 italic leading-relaxed">
            "PaperLoom is my go-to for books and stationery. Beautiful products, fast shipping, and the packaging is always thoughtful."
          </p>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-pl-border/60">
          <div class="w-10 h-10 rounded-full bg-pl-terracotta text-white flex items-center justify-center text-xs font-bold">
            LM
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900">Linda M.</h4>
            <span class="text-[11px] text-emerald-700 font-semibold">Verified Buyer</span>
          </div>
        </div>
      </div>

      <!-- Review 2 -->
      <div class="bg-white rounded-3xl border border-pl-border p-6 sm:p-7 space-y-4 shadow-xs flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-amber-500 text-sm">★★★★★</div>
          <p class="text-xs sm:text-sm text-slate-700 italic leading-relaxed">
            "I love the curated picks and the quality of stationery. It makes studying and journaling so much more enjoyable!"
          </p>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-pl-border/60">
          <div class="w-10 h-10 rounded-full bg-pl-forest text-white flex items-center justify-center text-xs font-bold">
            AS
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900">Arjun S.</h4>
            <span class="text-[11px] text-emerald-700 font-semibold">Verified Buyer</span>
          </div>
        </div>
      </div>

      <!-- Review 3 -->
      <div class="bg-white rounded-3xl border border-pl-border p-6 sm:p-7 space-y-4 shadow-xs flex flex-col justify-between">
        <div class="space-y-3">
          <div class="text-amber-500 text-sm">★★★★★</div>
          <p class="text-xs sm:text-sm text-slate-700 italic leading-relaxed">
            "Great selection for kids' books and school supplies. My daughter loves the Reading Club box each month!"
          </p>
        </div>
        <div class="flex items-center gap-3 pt-4 border-t border-pl-border/60">
          <div class="w-10 h-10 rounded-full bg-pl-terracottaHover text-white flex items-center justify-center text-xs font-bold">
            SR
          </div>
          <div>
            <h4 class="text-xs font-bold text-slate-900">Sophie R.</h4>
            <span class="text-[11px] text-emerald-700 font-semibold">Verified Buyer</span>
          </div>
        </div>
      </div>

    </div>
  </section>

</div>

@endsection
