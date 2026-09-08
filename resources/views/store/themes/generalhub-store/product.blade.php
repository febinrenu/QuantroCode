<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','he','fa','ur']) ? 'rtl' : 'ltr' }}">
<head>
@include('store.themes.generalhub-store._shell', ['pageTitle' => ($product['name'] ?? 'Product') . ' — ' . ($s->store_name ?? 'GeneralHub')])
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased selection:bg-hub-blue selection:text-white">

@php
  $currency = $s->currency_code ?? '$';
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'generalhub');
  $hubRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };

  $slugName = \Illuminate\Support\Str::slug($product['name']);
  $imgSrc = $product['image_url'];
  if (!$imgSrc || str_contains($imgSrc, 'no-image.png')) {
      if (file_exists(public_path('images/themes/generalhub/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/themes/generalhub/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/products/' . $slugName . '.jpg');
      } elseif (file_exists(public_path('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg'))) {
          $imgSrc = global_asset('images/tenants/21f7a839-4846-4839-8938-d9fcfc0ab086/products/' . $slugName . '.jpg');
      }
  }

  $relatedVms = collect($related ?? []);
@endphp

@include('store.themes.generalhub-store.partials.header', ['categories' => $categories, 'showCategoryBar' => true])
@include('store.themes.generalhub-store.partials.mobile-nav')

<main class="pb-20">

  <!-- Breadcrumbs -->
  <div class="bg-white border-b border-slate-200 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-2 text-xs text-slate-500">
      <a href="{{ $hubRoute('store.index') }}" class="hover:text-hub-blue">Home</a>
      <span>/</span>
      <a href="{{ $hubRoute('store.shop') }}" class="hover:text-hub-blue">Shop</a>
      <span>/</span>
      @if($product['category_name'])
        <a href="{{ $hubRoute('store.shop', ['category' => $p->category_id ?? '']) }}" class="hover:text-hub-blue">{{ $product['category_name'] }}</a>
        <span>/</span>
      @endif
      <span class="text-slate-900 font-medium truncate max-w-xs">{{ $product['name'] }}</span>
    </div>
  </div>

  <!-- Product Details Section -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-sm grid lg:grid-cols-12 gap-10 lg:gap-14 items-start">
      
      <!-- Left: Image Gallery (6 cols) -->
      <div class="lg:col-span-6 space-y-4">
        <div class="aspect-square bg-slate-50 border border-slate-200 rounded-2xl p-6 flex items-center justify-center overflow-hidden">
          @if($imgSrc)
            <img id="main-product-img" src="{{ $imgSrc }}" alt="{{ $product['name'] }}" class="w-full h-full object-contain hover:scale-105 transition-transform duration-500">
          @else
            <div class="text-slate-300">
              <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
          @endif
        </div>
      </div>

      <!-- Right: Product Buy Box & Info (6 cols) -->
      <div class="lg:col-span-6 space-y-6">
        
        <!-- Category & SKU -->
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-hub-blue">
            {{ $product['category_name'] ?? 'General' }}
          </span>
          <span class="text-xs text-slate-400 font-mono">
            SKU: {{ $product['code'] ?? ('PR-' . $product['id']) }}
          </span>
        </div>

        <!-- Product Title -->
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
          {{ $product['name'] }}
        </h1>

        <!-- Rating & Reviews -->
        <div class="flex items-center gap-2 text-xs">
          <div class="flex text-amber-400 text-sm">★★★★★</div>
          <span class="text-slate-500 font-medium">4.9 (1,248 verified ratings)</span>
        </div>

        <!-- Pricing -->
        <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-2xl flex items-baseline gap-3">
          <span class="text-3xl font-extrabold text-slate-900">
            {{ $product['final_price_formatted'] }}
          </span>
          @if($product['compare_at_price_formatted'])
            <span class="text-sm text-slate-400 line-through">
              {{ $product['compare_at_price_formatted'] }}
            </span>
            <span class="px-2 py-0.5 bg-rose-500 text-white text-xs font-bold rounded-md">
              Save {{ $product['discount_percent'] }}%
            </span>
          @endif
        </div>

        <!-- Stock Status -->
        <div class="flex items-center gap-2 text-xs font-semibold text-emerald-600">
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
          <span>In Stock — Ready to ship within 24 hours</span>
        </div>

        <!-- Description -->
        <div class="text-xs sm:text-sm text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
          {{ $p->note ?? 'Experience unparalleled quality, engineered for modern daily life. Backed by full warranty and certified authenticity.' }}
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="space-y-4 pt-4 border-t border-slate-100">
          <div class="flex items-center gap-4">
            
            <!-- Quantity Picker -->
            <div class="flex items-center border border-slate-200 rounded-xl bg-white p-1">
              <button type="button" onclick="const q = document.getElementById('qty-input'); const b = document.getElementById('btn-product-add-to-cart'); if(q.value > 1) { q.value--; b.dataset.qty = q.value; }" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 rounded-lg text-base font-bold transition-colors">−</button>
              <input type="number" id="qty-input" value="1" min="1" onchange="const b = document.getElementById('btn-product-add-to-cart'); b.dataset.qty = Math.max(1, this.value);" class="w-12 text-center text-xs font-bold text-slate-900 outline-none">
              <button type="button" onclick="const q = document.getElementById('qty-input'); const b = document.getElementById('btn-product-add-to-cart'); q.value++; b.dataset.qty = q.value;" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-slate-100 rounded-lg text-base font-bold transition-colors">+</button>
            </div>

            <!-- Add to Cart Button -->
            <button type="button"
                    id="btn-product-add-to-cart"
                    class="js-add-to-cart flex-1 h-12 bg-hub-blue hover:bg-hub-blueHover text-white text-sm font-bold rounded-xl flex items-center justify-center gap-2.5 shadow-md hover:shadow-lg transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                    @if(!$product['is_available']) disabled @endif
                    data-out-of-stock="{{ $product['is_available'] ? '0' : '1' }}"
                    data-is-preorder="{{ $product['is_preorder_active'] ? '1' : '0' }}"
                    data-id="{{ $product['id'] }}"
                    data-slug="{{ $product['slug'] }}"
                    data-name="{{ e($product['name']) }}"
                    data-price="{{ number_format($product['final_price'], 2, '.', '') }}"
                    data-image="{{ $imgSrc }}"
                    data-currency="{{ $product['currency'] ?? '$' }}"
                    data-qty="1"
                    data-stock="{{ $product['stock'] !== null ? $product['stock'] : '' }}"
                    data-added-label="Added to Cart">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span>Add to Cart</span>
            </button>

          </div>
        </div>

        <!-- Trust Features Checklist -->
        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
          <div class="flex items-center gap-2">
            <span class="text-hub-blue">✓</span>
            <span>Free Delivery over $49</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-hub-blue">✓</span>
            <span>30-Day Money-Back Guarantee</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-hub-blue">✓</span>
            <span>100% Authentic Products</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-hub-blue">✓</span>
            <span>24/7 Dedicated Support</span>
          </div>
        </div>

      </div>

    </div>

    <!-- Related Products -->
    @if($relatedVms->isNotEmpty())
      <div class="mt-16">
        <h2 class="text-xl font-bold text-slate-900 mb-6">
          You Might Also Like
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          @foreach($relatedVms->take(4) as $pItem)
            @include('store.themes.generalhub-store.partials.product-card', ['product' => $pItem])
          @endforeach
        </div>
      </div>
    @endif

  </div>

</main>

@include('store.themes.generalhub-store.partials.footer')

<script src="/js/storefront.min.js"></script>
</body>
</html>
