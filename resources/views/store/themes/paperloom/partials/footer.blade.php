@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'paperloom');
  $plRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };
  $shopUrl = $plRoute('store.shop');
@endphp

<footer class="w-full bg-[#C45D3E] text-white pt-16 pb-12 border-t border-[#A84A2E]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

    <!-- Top 5 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">

      <!-- Col 1: Brand & Bookstore Snapshot -->
      <div class="space-y-4 lg:col-span-1">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-white text-pl-terracotta flex items-center justify-center font-serif-book font-bold text-xl shadow-xs">
            P
          </div>
          <span class="font-serif-book font-bold text-2xl tracking-tight text-white">
            PaperLoom
          </span>
        </div>
        <p class="text-xs text-amber-100/90 leading-relaxed">
          Curated books, heirloom stationery, and study essentials crafted for lifelong readers and creative thinkers.
        </p>

        <!-- Mini Bookstore Thumbnail -->
        <div class="rounded-xl overflow-hidden border border-white/20 shadow-xs max-w-[200px]">
          <img src="{{ global_asset('images/products/bookstore-footer.jpg') }}"
               alt="PaperLoom Flagship Reading Room"
               class="w-full h-24 object-cover">
        </div>
      </div>

      <!-- Col 2: Shop Categories -->
      <div class="space-y-3">
        <h4 class="font-serif-book font-bold text-sm tracking-wide text-white uppercase">
          Explore Books
        </h4>
        <ul class="space-y-2 text-xs text-amber-100/80 font-medium">
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Books']) }}" class="hover:text-amber-200 transition-colors">Books</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Stationery']) }}" class="hover:text-amber-200 transition-colors">Stationery</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Art Supplies']) }}" class="hover:text-amber-200 transition-colors">Art Supplies</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Academic']) }}" class="hover:text-amber-200 transition-colors">Academic</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Kids']) }}" class="hover:text-amber-200 transition-colors">Kids</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Gifts']) }}" class="hover:text-amber-200 transition-colors">Gifts</a></li>
          <li><a href="{{ $plRoute('store.shop', ['collection' => 'sale']) }}" class="hover:text-amber-200 transition-colors text-amber-300 font-semibold">Sale</a></li>
        </ul>
      </div>

      <!-- Col 3: Stationery & Tools -->
      <div class="space-y-3">
        <h4 class="font-serif-book font-bold text-sm tracking-wide text-white uppercase">
          Writing & Study
        </h4>
        <ul class="space-y-2 text-xs text-amber-100/80 font-medium">
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Notebooks']) }}" class="hover:text-amber-200 transition-colors">Notebooks & Planners</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Journals']) }}" class="hover:text-amber-200 transition-colors">Leather Journals</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Art Supplies']) }}" class="hover:text-amber-200 transition-colors">Fine Art Sets</a></li>
          <li><a href="{{ $plRoute('store.shop', ['category' => 'Desk Accessories']) }}" class="hover:text-amber-200 transition-colors">Desk Organizers</a></li>
          <li><a href="{{ $plRoute('store.shop', ['collection' => 'bestselling']) }}" class="hover:text-amber-200 transition-colors">Bestseller Curations</a></li>
          <li><a href="{{ $plRoute('store.shop', ['collection' => 'new-arrivals']) }}" class="hover:text-amber-200 transition-colors">New Releases</a></li>
        </ul>
      </div>

      <!-- Col 4: Community & Club -->
      <div class="space-y-3">
        <h4 class="font-serif-book font-bold text-sm tracking-wide text-white uppercase">
          Community
        </h4>
        <ul class="space-y-2 text-xs text-amber-100/80 font-medium">
          <li><a href="{{ $plRoute('store.shop', ['q' => 'reading-club']) }}" class="hover:text-amber-200 transition-colors">PaperLoom Club</a></li>
          <li><a href="{{ $plRoute('store.shop', ['q' => 'author-events']) }}" class="hover:text-amber-200 transition-colors">Author Events & Signings</a></li>
          <li><a href="{{ $plRoute('store.shop', ['q' => 'workshops']) }}" class="hover:text-amber-200 transition-colors">Bookbinding Workshops</a></li>
          <li><a href="{{ $plRoute('store.shop', ['q' => 'gift-cards']) }}" class="hover:text-amber-200 transition-colors">Book Lover Gift Cards</a></li>
          <li><a href="{{ $plRoute('store.shop', ['q' => 'student-discount']) }}" class="hover:text-amber-200 transition-colors">Student & Educator Discount</a></li>
        </ul>
      </div>

      <!-- Col 5: Help & Reading Room Contact -->
      <div class="space-y-3">
        <h4 class="font-serif-book font-bold text-sm tracking-wide text-white uppercase">
          Reading Room
        </h4>
        <div class="space-y-2 text-xs text-amber-100/90 leading-relaxed">
          <p>📍 142 Artisan Boulevard, Bloomsbury Book Quarter</p>
          <p>📞 +1 (800) 555-LOOM</p>
          <p>✉️ hello@paperloom.com</p>
          <p>⏰ Mon - Sun: 8:00 AM – 9:00 PM</p>
        </div>
      </div>

    </div>

    <!-- Bottom Bar -->
    <div class="pt-8 border-t border-white/20 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-amber-100/70">
      <div>
        © 2026 PaperLoom Bookstore & Stationery Co. All rights reserved.
      </div>
      <div class="flex items-center gap-6">
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Privacy Policy</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Terms of Service</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Accessibility</a>
        <a href="{{ $shopUrl }}" class="hover:text-white transition-colors">Cookie Settings</a>
      </div>
    </div>

  </div>
</footer>
