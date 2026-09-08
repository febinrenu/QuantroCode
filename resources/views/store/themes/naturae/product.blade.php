@extends('store.themes.naturae._shell')

@php
    $previewTheme = request('preview_theme', 'naturae');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');

    // Resolve Eloquent model vs View Model array
    $prodObj = $p ?? null;
    $prodArray = is_array($product ?? null) ? $product : null;

    $prodId = $prodObj ? $prodObj->id : ($prodArray['id'] ?? request('id', 0));
    $prodName = $prodObj ? $prodObj->name : ($prodArray['name'] ?? 'Naturae Pure Essential');
    $prodCode = $prodObj ? $prodObj->code : ($prodArray['code'] ?? 'NAT-000');
    $prodDesc = $prodObj ? ($prodObj->note ?: $prodObj->description) : ($prodArray['description'] ?? 'Thoughtfully crafted with certified organic botanical ingredients. Formulated to replenish and harmonize your everyday wellness with gentle natural efficacy.');
    $catName = ($prodObj && $prodObj->category) ? $prodObj->category->name : ($prodArray['category_name'] ?? 'Botanical Wellness');
    $isFeatured = $prodObj ? $prodObj->is_featured : ($prodArray['is_featured'] ?? false);
    $currencySym = $s->currency_code ?? '$';

    // Price
    if ($prodObj) {
        $finalPrice = (float) ($prodObj->final_display_price ?? ($prodObj->after_discount ?? ($prodObj->price ?? 0)));
        $imgName = $prodObj->image ?? '';
        if ($imgName && file_exists(public_path('images/themes/naturae/' . $imgName))) {
            $imageUrl = global_asset('images/themes/naturae/' . $imgName);
        } elseif ($imgName && file_exists(public_path('images/products/' . $imgName))) {
            $imageUrl = global_asset('images/products/' . $imgName);
        } else {
            $imageUrl = global_asset('images/themes/naturae/nat-aloe-cleanser.jpg');
        }
    } else {
        $finalPrice = (float) ($prodArray['final_price'] ?? ($prodArray['price'] ?? 0));
        $imageUrl = $prodArray['image_url'] ?? global_asset('images/themes/naturae/nat-aloe-cleanser.jpg');
    }
@endphp

@section('title', $prodName . ' — Naturae Pure Organic Essentials')

@section('content')

<!-- Breadcrumbs -->
<div class="bg-white border-b border-naturae-border/80 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-naturae-muted" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ $storeUrl }}" class="hover:text-naturae-forest transition">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ $shopUrl }}" class="hover:text-naturae-forest transition">Catalog</a></li>
                @if($catName)
                    <li><span>/</span></li>
                    <li>
                        <a href="{{ url('online_store/shop?category=' . urlencode($catName) . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-naturae-forest transition">
                            {{ $catName }}
                        </a>
                    </li>
                @endif
                <li><span>/</span></li>
                <li class="text-naturae-forest font-medium truncate max-w-xs">{{ $prodName }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Details Section -->
<section class="py-12 bg-naturae-bg" x-data="{ qty: 1, added: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 bg-white p-6 sm:p-10 rounded-3xl border border-naturae-border shadow-sm">

            <!-- Left: Product Image (5 Cols) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-naturae-sand/40 border border-naturae-border">
                    <img src="{{ $imageUrl }}"
                         alt="{{ $prodName }}"
                         class="w-full h-full object-cover object-center">

                    @if($isFeatured)
                        <span class="absolute top-4 left-4 bg-naturae-forest/90 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                            Best Seller
                        </span>
                    @endif
                </div>

                <!-- Trust Guarantee Pills -->
                <div class="grid grid-cols-3 gap-2 text-center text-[11px] text-naturae-muted">
                    <div class="p-2.5 rounded-xl bg-naturae-sand/50 border border-naturae-border/50">
                        <span class="block text-sm mb-0.5">🌱</span>
                        <span>100% Organic</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-naturae-sand/50 border border-naturae-border/50">
                        <span class="block text-sm mb-0.5">🐰</span>
                        <span>Cruelty-Free</span>
                    </div>
                    <div class="p-2.5 rounded-xl bg-naturae-sand/50 border border-naturae-border/50">
                        <span class="block text-sm mb-0.5">♻️</span>
                        <span>Eco-Packaging</span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Purchase Area (7 Cols) -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    @if($catName)
                        <span class="text-xs font-bold uppercase tracking-widest text-naturae-sage">
                            {{ $catName }}
                        </span>
                    @endif

                    <h1 class="font-serif text-3xl sm:text-4xl font-bold text-naturae-forest mt-1.5 leading-tight">
                        {{ $prodName }}
                    </h1>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mt-3">
                        <div class="flex text-amber-500 text-sm">
                            ★★★★★
                        </div>
                        <span class="text-xs text-naturae-muted font-medium">4.9 / 5.0 (148 verified botanical reviews)</span>
                    </div>

                    <!-- Price -->
                    <div class="mt-4 flex items-baseline gap-3">
                        <span class="font-serif text-3xl font-bold text-naturae-forest">
                            {{ $currencySym }}{{ number_format($finalPrice, 2) }}
                        </span>
                        <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded font-semibold">
                            In Stock • Ready to Dispatch
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mt-5 text-sm text-naturae-text/80 leading-relaxed border-t border-b border-naturae-border py-4 space-y-3">
                        <p>
                            {{ $prodDesc }}
                        </p>

                        <div class="space-y-1.5 text-xs text-naturae-forest font-medium">
                            <div class="flex items-center gap-2">
                                <span class="text-naturae-sage">✓</span>
                                <span>Free from parabens, phthalates, synthetic sulfates & artificial dyes</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-naturae-sage">✓</span>
                                <span>Cold-pressed botanical extracts & therapeutic grade essential oils</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-naturae-sage">✓</span>
                                <span>Dermatologically tested & suitable for sensitive skin</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="mt-6 space-y-4">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">

                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-naturae-border rounded-xl bg-naturae-bg">
                                <button type="button"
                                        @click="if(qty > 1) qty--"
                                        class="w-11 h-12 flex items-center justify-center text-naturae-forest hover:bg-naturae-sand rounded-l-xl font-bold transition">
                                    -
                                </button>
                                <span class="w-12 text-center text-sm font-bold text-naturae-forest" x-text="qty"></span>
                                <button type="button"
                                        @click="qty++"
                                        class="w-11 h-12 flex items-center justify-center text-naturae-forest hover:bg-naturae-sand rounded-r-xl font-bold transition">
                                    +
                                </button>
                            </div>

                            <!-- Add to Cart Button -->
                            <button type="button"
                                    @click="if (window.CartLS) { window.CartLS.add({ id: '{{ $prodId }}', name: '{{ addslashes($prodName) }}', price: {{ $finalPrice }}, image: '{{ $imageUrl }}', currency: '{{ $currencySym }}' }, qty); added = true; setTimeout(() => added = false, 1500); }"
                                    class="flex-1 bg-naturae-forest hover:bg-naturae-green text-white font-semibold py-3.5 px-6 rounded-xl uppercase tracking-widest text-xs sm:text-sm flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition transform active:scale-98">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span x-text="added ? 'Added to Bag!' : 'Add to Shopping Bag'">Add to Shopping Bag</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Shipping & Support Note -->
                <div class="pt-6 border-t border-naturae-border/80 flex items-center justify-between text-xs text-naturae-muted">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-naturae-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Free delivery on orders over $99</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-naturae-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>30-Day Purity Guarantee</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection
