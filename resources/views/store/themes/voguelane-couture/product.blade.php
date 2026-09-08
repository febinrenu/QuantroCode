@extends('store.themes.voguelane-couture._shell')

@php
  $themePreview = request('preview_theme') ?: (session('preview_theme') ?? 'voguelane');
  $vogRoute = function(string $name, array $parameters = []) use ($themePreview) {
      if ($themePreview && !isset($parameters['preview_theme'])) {
          $parameters['preview_theme'] = $themePreview;
      }
      return route($name, $parameters);
  };

  $vm = $product ?? [];
  $price = $vm['final_price'] ?? ($vm['price'] ?? 0);
  $priceFormatted = $vm['final_price_formatted'] ?? ($vm['display_price_formatted'] ?? (($vm['currency'] ?? '$') . number_format($price, 2)));
  $comparePriceFormatted = $vm['compare_at_price_formatted'] ?? ($vm['base_price_formatted'] ?? null);
  $isOnSale = !empty($vm['is_on_sale']) || !empty($vm['compare_at_price']);
  $discountPercent = $vm['discount_percent'] ?? 0;
@endphp

@section('title', ($vm['name'] ?? 'Product Details') . ' — VogueLane')

@section('content')

<!-- Breadcrumbs -->
<div class="bg-vog-ivory border-b border-vog-border py-4">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <nav class="flex items-center gap-2 text-xs text-slate-400 font-medium uppercase tracking-wider">
      <a href="{{ $vogRoute('store.index') }}" class="hover:text-slate-900 transition-colors">Home</a>
      <span>&rsaquo;</span>
      <a href="{{ $vogRoute('store.shop') }}" class="hover:text-slate-900 transition-colors">Shop</a>
      @if(!empty($vm['category_name']))
        <span>&rsaquo;</span>
        <a href="{{ $vogRoute('store.shop', ['category' => $vm['category_name']]) }}" class="hover:text-slate-900 transition-colors">{{ $vm['category_name'] }}</a>
      @endif
      <span>&rsaquo;</span>
      <span class="text-slate-900 font-semibold truncate max-w-xs">{{ $vm['name'] }}</span>
    </nav>
  </div>
</div>

<!-- Product Detail Hero -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ 
  qty: 1,
  selectedColor: 'Default',
  selectedSize: 'M',
  mainImage: '{{ $vm['image_url'] ?? global_asset('images/products/' . ($vm['image'] ?? 'no-image.png')) }}',
  setQty(val) {
    this.qty = Math.max(1, parseInt(val) || 1);
    const btn = document.getElementById('main-add-to-cart-btn');
    if (btn) btn.dataset.qty = this.qty;
  }
}">
  
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
    
    <!-- Left: Image Gallery (7 cols on desktop) -->
    <div class="lg:col-span-7 space-y-4">
      <div class="aspect-[3/4] bg-vog-warm rounded-2xl overflow-hidden border border-vog-border shadow-xs">
        <img :src="mainImage" 
             alt="{{ $vm['name'] }}" 
             class="w-full h-full object-cover object-center transition-all duration-300">
      </div>

      <!-- Thumbnails -->
      @if(!empty($vm['gallery_urls']) && count($vm['gallery_urls']) > 1)
        <div class="flex items-center gap-3 overflow-x-auto pb-2">
          @foreach($vm['gallery_urls'] as $img)
            <button type="button" 
                    @click="mainImage = '{{ $img }}'"
                    class="w-20 aspect-[3/4] rounded-lg overflow-hidden border-2 transition-all shrink-0"
                    :class="mainImage === '{{ $img }}' ? 'border-slate-900 shadow-sm' : 'border-vog-border opacity-70 hover:opacity-100'">
              <img src="{{ $img }}" alt="{{ $vm['name'] }}" class="w-full h-full object-cover">
            </button>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Right: Product Information & Purchase (5 cols on desktop) -->
    <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-28">
      
      <!-- Category & Rating -->
      <div class="flex items-center justify-between">
        @if(!empty($vm['category_name']))
          <span class="text-xs font-bold uppercase tracking-widest text-vog-tan">
            {{ $vm['category_name'] }}
          </span>
        @endif
        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-medium">
          <span class="text-amber-400">★★★★★</span>
          <span>(24 reviews)</span>
        </div>
      </div>

      <!-- Title -->
      <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-slate-900 leading-tight">
        {{ $vm['name'] }}
      </h1>

      <!-- Price -->
      <div class="flex items-baseline gap-3">
        <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">
          {{ $priceFormatted }}
        </span>
        @if($isOnSale && $comparePriceFormatted)
          <span class="text-base text-slate-400 line-through font-normal">
            {{ $comparePriceFormatted }}
          </span>
          <span class="px-2 py-0.5 text-xs font-bold uppercase tracking-wider bg-vog-sale text-white rounded-md">
            Save {{ $discountPercent ? $discountPercent . '%' : '20%' }}
          </span>
        @endif
      </div>

      <!-- Description Note -->
      <div class="text-xs sm:text-sm text-slate-600 leading-relaxed pt-1">
        <p>{{ $vm['description'] ?: 'Crafted from premium sustainable materials with an obsession for refined tailoring and modern silhouette.' }}</p>
      </div>

      <!-- Color Swatches -->
      <div class="space-y-2 pt-2 border-t border-vog-border">
        <div class="flex items-center justify-between text-xs">
          <span class="font-semibold text-slate-900 uppercase tracking-wider">Color:</span>
          <span class="text-slate-500 font-medium" x-text="selectedColor"></span>
        </div>
        <div class="flex items-center gap-3">
          <button type="button" @click="selectedColor = 'Ivory'" class="w-8 h-8 rounded-full bg-[#F5F2EB] border-2 transition-all" :class="selectedColor === 'Ivory' ? 'border-slate-900 scale-110' : 'border-black/10'"></button>
          <button type="button" @click="selectedColor = 'Camel'" class="w-8 h-8 rounded-full bg-[#C49A6C] border-2 transition-all" :class="selectedColor === 'Camel' ? 'border-slate-900 scale-110' : 'border-black/10'"></button>
          <button type="button" @click="selectedColor = 'Noir Black'" class="w-8 h-8 rounded-full bg-[#111111] border-2 transition-all" :class="selectedColor === 'Noir Black' ? 'border-slate-900 scale-110' : 'border-black/10'"></button>
        </div>
      </div>

      <!-- Size Selection -->
      <div class="space-y-2 pt-2">
        <div class="flex items-center justify-between text-xs">
          <span class="font-semibold text-slate-900 uppercase tracking-wider">Select Size:</span>
          <a href="#" class="text-vog-tan hover:underline">Size Guide</a>
        </div>
        <div class="grid grid-cols-5 gap-2">
          @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
            <button type="button" 
                    @click="selectedSize = '{{ $size }}'"
                    class="py-2.5 text-xs font-bold rounded-lg border transition-all text-center"
                    :class="selectedSize === '{{ $size }}' ? 'bg-vog-black text-white border-vog-black shadow-xs' : 'bg-white text-slate-800 border-vog-border hover:border-slate-400'">
              {{ $size }}
            </button>
          @endforeach
        </div>
      </div>

      <!-- Purchase Actions -->
      <div class="space-y-4 pt-4 border-t border-vog-border">
        
        <!-- Quantity Stepper & Add to Cart -->
        <div class="flex items-center gap-3">
          
          <div class="flex items-center border border-vog-border rounded-xl bg-vog-ivory overflow-hidden h-12 shrink-0">
            <button type="button" 
                    @click="setQty(qty - 1)" 
                    class="w-10 h-full flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors font-bold text-sm">
              &minus;
            </button>
            <input type="number" 
                   x-model="qty" 
                   @input="setQty($event.target.value)"
                   min="1" 
                   class="w-12 h-full text-center bg-transparent text-xs sm:text-sm font-bold text-slate-900 outline-none">
            <button type="button" 
                    @click="setQty(qty + 1)" 
                    class="w-10 h-full flex items-center justify-center text-slate-700 hover:bg-slate-200 transition-colors font-bold text-sm">
              +
            </button>
          </div>

          <!-- Add to Bag Button -->
          <button type="button" 
                  id="main-add-to-cart-btn"
                  class="js-add-to-cart flex-1 h-12 bg-vog-black hover:bg-neutral-800 text-white text-xs sm:text-sm font-bold uppercase tracking-wider rounded-xl shadow-md flex items-center justify-center gap-2 active:scale-95 transition-all"
                  data-out-of-stock="{{ !empty($vm['is_available']) ? '0' : '1' }}"
                  data-is-preorder="{{ !empty($vm['is_preorder_active']) ? '1' : '0' }}"
                  data-id="{{ $vm['id'] }}"
                  data-slug="{{ $vm['slug'] ?? $vm['id'] }}"
                  data-name="{{ $vm['name'] }}"
                  data-price="{{ $price }}"
                  data-image="{{ $vm['image_url'] ?? '' }}"
                  data-currency="{{ $vm['currency'] ?? '$' }}"
                  data-qty="1"
                  data-stock="{{ $vm['stock'] ?? 100 }}"
                  data-added-label="Added to Bag">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
            </svg>
            <span>Add to Bag</span>
          </button>

        </div>

      </div>

      <!-- Trust Badges -->
      <div class="bg-vog-ivory rounded-2xl p-4 border border-vog-border space-y-3 text-xs">
        <div class="flex items-center gap-3 text-slate-700">
          <span class="text-vog-tan font-bold">✓</span>
          <span>Complimentary gift packaging on all orders</span>
        </div>
        <div class="flex items-center gap-3 text-slate-700">
          <span class="text-vog-tan font-bold">✓</span>
          <span>Free express shipping on orders over $80</span>
        </div>
        <div class="flex items-center gap-3 text-slate-700">
          <span class="text-vog-tan font-bold">✓</span>
          <span>Easy 30-day returns and exchanges</span>
        </div>
      </div>

    </div>

  </div>

  <!-- Related Products Section -->
  @if(!empty($related) && count($related) > 0)
    <section class="pt-16 sm:pt-20 border-t border-vog-border mt-16 sm:mt-20">
      <div class="flex items-end justify-between mb-8">
        <div>
          <span class="text-xs font-bold uppercase tracking-widest text-vog-tan">Complete The Look</span>
          <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight mt-1">
            You May Also Like
          </h2>
        </div>
        <a href="{{ $vogRoute('store.shop') }}" class="text-xs sm:text-sm font-semibold text-slate-900 hover:text-vog-tan underline transition-colors">
          View All
        </a>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
        @foreach($related as $relProduct)
          @include('store.themes.voguelane-couture.partials.product-card', ['product' => $relProduct])
        @endforeach
      </div>
    </section>
  @endif

</div>

@endsection
