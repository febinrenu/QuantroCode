@extends('store.themes.homely._shell')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';

    // Normalize product variable
    $p = $p ?? ($product ?? null);
    $id = is_array($p) ? ($p['id'] ?? null) : ($p->id ?? null);
    $code = is_array($p) ? ($p['code'] ?? '') : ($p->code ?? '');
    $name = is_array($p) ? ($p['name'] ?? 'Homely Product') : ($p->name ?? 'Homely Product');
    $slug = is_array($p) ? ($p['slug'] ?? Str::slug($name)) : ($p->slug ?? Str::slug($name));
    $price = is_array($p) ? ($p['final_display_price'] ?? $p['price'] ?? 0) : ($p->final_display_price ?? $p->price ?? 0);
    $origPrice = is_array($p) ? ($p['original_price'] ?? $p['base_price'] ?? $price) : ($p->original_price ?? $p->base_price ?? $price);
    $image = is_array($p) ? ($p['image'] ?? '') : ($p->image ?? '');
    $description = is_array($p) ? ($p['description'] ?? '') : ($p->description ?? '');
    $categoryName = is_array($p) ? ($p['category']['name'] ?? 'Home & Living') : ($p->category->name ?? 'Home & Living');

    // Clean image path
    $imagePath = '/images/themes/homely/' . $image;
    if (!file_exists(public_path('images/themes/homely/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/homely/hom-glass-bud-vase.jpg';
        }
    }
@endphp

@section('title', $name . ' — Homely')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 space-y-12"
     x-data="{ 
        qty: 1, 
        activeTab: 'details'
     }">
    
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs text-stone-500">
        <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-homely-primary transition-colors">Home</a>
        <span>/</span>
        <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-homely-primary transition-colors">Shop</a>
        <span>/</span>
        <span class="text-homely-text font-semibold">{{ $name }}</span>
    </nav>

    <!-- Product Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        <!-- Product Image Gallery (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-10 border border-homely-borderLight shadow-xs">
            <div class="aspect-square w-full rounded-2xl overflow-hidden bg-[#FAF7F2] p-8 flex items-center justify-center">
                <img src="{{ $imagePath }}" 
                     alt="{{ $name }}" 
                     class="w-full h-full object-contain object-center transform hover:scale-105 transition-transform duration-500"
                     loading="eager">
            </div>
            
            <!-- Sustainable Badge Under Photo -->
            <div class="mt-6 pt-6 border-t border-homely-borderLight grid grid-cols-3 gap-4 text-center">
                <div class="space-y-1">
                    <span class="text-homely-primary text-base">🌿</span>
                    <p class="text-[11px] font-bold text-homely-text">100% Organic</p>
                    <p class="text-[10px] text-stone-400">Natural components</p>
                </div>
                <div class="space-y-1">
                    <span class="text-homely-terracotta text-base">✋</span>
                    <p class="text-[11px] font-bold text-homely-text">Handcrafted</p>
                    <p class="text-[10px] text-stone-400">Artisanal finish</p>
                </div>
                <div class="space-y-1">
                    <span class="text-homely-sage text-base">📦</span>
                    <p class="text-[11px] font-bold text-homely-text">Zero Plastic</p>
                    <p class="text-[10px] text-stone-400">Recycled package</p>
                </div>
            </div>
        </div>

        <!-- Product Actions & Buying Info (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="space-y-2">
                <span class="inline-block px-3 py-1 rounded-full bg-homely-sand text-homely-primary font-semibold text-[11px] uppercase tracking-wider">
                    {{ $categoryName }}
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-homely-primary leading-tight">
                    {{ $name }}
                </h1>
                
                <!-- Ratings -->
                <div class="flex items-center gap-2 text-xs pt-1">
                    <div class="flex text-amber-500">
                        @for($i = 0; $i < 5; $i++)
                            <span>★</span>
                        @endfor
                    </div>
                    <span class="font-semibold text-stone-700">4.9</span>
                    <span class="text-stone-400">•</span>
                    <a href="#reviews" class="text-stone-500 hover:text-homely-primary underline">128 verified reviews</a>
                </div>
            </div>

            <!-- Price -->
            <div class="flex items-baseline gap-3 py-3 border-y border-homely-borderLight">
                <span class="text-3xl font-bold text-homely-text">
                    ${{ number_format($price, 2) }}
                </span>
                @if($origPrice > $price)
                    <span class="text-lg text-stone-400 line-through">
                        ${{ number_format($origPrice, 2) }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">
                        Save ${{ number_format($origPrice - $price, 2) }}
                    </span>
                @endif
            </div>

            <!-- Description -->
            <p class="text-sm text-stone-600 leading-relaxed">
                {{ $description ?: 'A thoughtfully designed, sustainable essential crafted with premium natural materials to bring timeless warmth, organic texture, and conscious tranquility into your living space.' }}
            </p>

            <!-- Quantity & Add to Cart -->
            <div class="space-y-3 pt-2">
                <div class="flex items-center gap-4">
                    <!-- Qty Stepper -->
                    <div class="flex items-center border border-homely-border rounded-full bg-white px-3 py-2">
                        <button type="button" 
                                @click="if (qty > 1) qty--" 
                                class="w-7 h-7 text-stone-500 hover:text-homely-primary font-bold text-sm">
                            -
                        </button>
                        <span class="w-8 text-center text-sm font-semibold" x-text="qty"></span>
                        <button type="button" 
                                @click="qty++" 
                                class="w-7 h-7 text-stone-500 hover:text-homely-primary font-bold text-sm">
                            +
                        </button>
                    </div>

                    <!-- Add to Cart CTA -->
                    <button type="button"
                            @click="addToCart({
                                id: {{ json_encode($id) }},
                                code: {{ json_encode($code) }},
                                name: {{ json_encode($name) }},
                                price: {{ json_encode((float)$price) }},
                                original_price: {{ json_encode((float)$origPrice) }},
                                image: {{ json_encode($imagePath) }},
                                category: {{ json_encode($categoryName) }}
                            }, qty)"
                            class="flex-1 py-3.5 px-6 rounded-full bg-homely-primary hover:bg-homely-primaryDark text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>ADD TO CART</span>
                    </button>
                </div>
            </div>

            <!-- Guarantee Box -->
            <div class="p-4 rounded-2xl bg-homely-sand/70 border border-homely-border text-xs text-stone-600 space-y-2">
                <div class="flex items-center gap-2 text-homely-primary font-bold">
                    <span>🚚</span>
                    <span>Free shipping on all orders over $69</span>
                </div>
                <div class="flex items-center gap-2 text-stone-600">
                    <span>🔄</span>
                    <span>30-Day effortless return & satisfaction guarantee</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
