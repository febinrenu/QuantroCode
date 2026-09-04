@extends('store.themes.novatech._shell')

@php
    $previewParam = '?preview_theme=novatech';
    $prod = $p ?? ($product ?? null);

    $id = is_array($prod) ? ($prod['id'] ?? null) : ($prod->id ?? null);
    $name = is_array($prod) ? ($prod['name'] ?? 'NovaTech Product') : ($prod->name ?? 'NovaTech Product');
    $code = is_array($prod) ? ($prod['code'] ?? '') : ($prod->code ?? '');
    $image = is_array($prod) ? ($prod['image'] ?? '') : ($prod->image ?? '');
    $price = is_array($prod) ? ($prod['final_display_price'] ?? $prod['price'] ?? 0) : ($prod->final_display_price ?? $prod->price ?? 0);
    $basePrice = is_array($prod) ? ($prod['base_price'] ?? $prod['price'] ?? $price) : ($prod->base_price ?? $prod->price ?? $price);

    // If price is 0, fallback to product price
    if ($price <= 0 && isset($prod->price) && $prod->price > 0) {
        $price = (float) $prod->price;
    }
    if ($basePrice <= 0 && isset($prod->price) && $prod->price > 0) {
        $basePrice = (float) $prod->price;
    }

    $hasDiscount = $basePrice > $price;
    $reviewsCount = 120 + (abs(crc32($name)) % 300);

    $imagePath = '/images/themes/novatech/' . $image;
    if (!file_exists(public_path('images/themes/novatech/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/novatech/nvt-wireless-earbuds.jpg';
        }
    }
@endphp

@section('title', $name . ' — NOVATECH')
@section('meta_description', 'Buy ' . $name . ' at NovaTech. Enjoy top performance, verified warranty, and express delivery.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12" x-data="{ qty: 1, activeTab: 'description' }">

    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
        <a href="{{ route('store.index', ['preview_theme' => 'novatech']) }}" class="hover:text-indigo-600 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="hover:text-indigo-600 transition-colors">Shop</a>
        <span>/</span>
        <span class="text-slate-900 font-bold truncate max-w-xs">{{ $name }}</span>
    </nav>

    <!-- Product Main View -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">

        <!-- Left: Image Gallery Showcase -->
        <div class="space-y-4">
            <div class="aspect-square w-full rounded-2xl bg-slate-50/60 border border-slate-200/80 p-8 flex items-center justify-center overflow-hidden relative">
                <img src="{{ $imagePath }}"
                     alt="{{ $name }}"
                     class="w-full h-full object-contain hover:scale-105 transition-transform duration-300"
                     onerror="this.onerror=null; this.src='/images/products/{{ $image }}';">

                @if($hasDiscount)
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-black bg-rose-50 text-rose-600 border border-rose-200 shadow-sm">
                        SAVE ${{ number_format($basePrice - $price, 2) }}
                    </span>
                @endif
            </div>

            <!-- Thumbnail Indicators -->
            <div class="grid grid-cols-4 gap-3">
                <div class="aspect-square rounded-xl border-2 border-indigo-600 bg-white p-2 flex items-center justify-center cursor-pointer shadow-sm">
                    <img src="{{ $imagePath }}" alt="Thumbnail 1" class="w-full h-full object-contain">
                </div>
            </div>
        </div>

        <!-- Right: Product Information & Purchase Panel -->
        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <!-- SKU & In Stock Badge -->
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                        SKU: <span class="text-slate-700 font-mono">{{ $code ?: 'NVT-' . $id }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        In Stock & Ready to Ship
                    </span>
                </div>

                <!-- Product Name -->
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $name }}
                </h1>

                <!-- Rating -->
                <div class="flex items-center space-x-2">
                    <div class="flex text-indigo-600">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs font-bold text-slate-700">5.0</span>
                    <span class="text-xs text-slate-400 font-semibold">({{ $reviewsCount }} customer reviews)</span>
                </div>

                <!-- Price Block -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-baseline space-x-3">
                    <span class="text-3xl font-black text-slate-900">
                        ${{ number_format($price, 2) }}
                    </span>
                    @if($hasDiscount)
                        <span class="text-base font-bold text-slate-400 line-through">
                            ${{ number_format($basePrice, 2) }}
                        </span>
                        <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                            {{ round((1 - ($price / $basePrice)) * 100) }}% OFF
                        </span>
                    @endif
                </div>

                <!-- Short Summary -->
                <p class="text-xs text-slate-600 leading-relaxed">
                    Designed for peak performance and durability. Features next-generation components, high-speed connectivity, ergonomic engineering, and seamless integration with the NovaTech ecosystem.
                </p>
            </div>

            <!-- Quantity & Add to Cart Actions -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-4">
                    <!-- Qty Selector -->
                    <div class="flex items-center rounded-xl border border-slate-200 bg-slate-50 p-1">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 font-black text-sm flex items-center justify-center hover:bg-slate-100 transition-colors">-</button>
                        <span class="w-10 text-center font-bold text-xs text-slate-900" x-text="qty"></span>
                        <button type="button" @click="qty = qty + 1" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-700 font-black text-sm flex items-center justify-center hover:bg-slate-100 transition-colors">+</button>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="button"
                            @click="CartLS.add({ id: {{ $id }}, name: '{{ addslashes($name) }}', price: {{ $price }}, image: '{{ $image ?: 'nvt-wireless-earbuds.jpg' }}', code: '{{ $code }}' }, qty)"
                            class="flex-1 py-3 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Add to Cart</span>
                    </button>
                </div>

                <!-- Buy Now / Fast Checkout -->
                <a href="{{ url('/online_store/cart?preview_theme=novatech') }}"
                   @click="CartLS.add({ id: {{ $id }}, name: '{{ addslashes($name) }}', price: {{ $price }}, image: '{{ $image ?: 'nvt-wireless-earbuds.jpg' }}', code: '{{ $code }}' }, qty)"
                   class="w-full block py-3 px-6 rounded-xl bg-slate-950 hover:bg-slate-900 text-white font-bold text-xs uppercase tracking-wider text-center transition-colors shadow-md">
                    Buy It Now
                </a>

                <!-- Guarantee Highlights -->
                <div class="grid grid-cols-3 gap-3 pt-3 text-center">
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="block text-sm mb-0.5">🚀</span>
                        <span class="text-[10px] font-bold text-slate-800">Free 2-Day Delivery</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="block text-sm mb-0.5">🛡️</span>
                        <span class="text-[10px] font-bold text-slate-800">1-Year Warranty</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="block text-sm mb-0.5">🔄</span>
                        <span class="text-[10px] font-bold text-slate-800">30-Day Returns</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Related Products -->
    @if(isset($related) && count($related) > 0)
        <section class="space-y-6 pt-6">
            <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">You May Also Like</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                @foreach($related as $relProduct)
                    @include('store.themes.novatech.partials.product-card', ['product' => $relProduct])
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
