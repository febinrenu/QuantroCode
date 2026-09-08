@extends('store.themes.verde._shell')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';

    // Robust variable normalization for $p / $product
    $prod = $p ?? ($product ?? null);
    $id = is_array($prod) ? ($prod['id'] ?? null) : ($prod->id ?? null);
    $code = is_array($prod) ? ($prod['code'] ?? '') : ($prod->code ?? '');
    $name = is_array($prod) ? ($prod['name'] ?? 'Verde Living Product') : ($prod->name ?? 'Verde Living Product');
    $slug = is_array($prod) ? ($prod['slug'] ?? Str::slug($name)) : ($prod->slug ?? Str::slug($name));
    $price = is_array($prod) ? ($prod['final_display_price'] ?? $prod['price'] ?? 0) : ($prod->final_display_price ?? $prod->price ?? 0);
    $origPrice = is_array($prod) ? ($prod['original_price'] ?? $prod['base_price'] ?? $price) : ($prod->original_price ?? $prod->base_price ?? $price);
    $image = is_array($prod) ? ($prod['image'] ?? 'vrd-herbal-hand-wash.jpg') : ($prod->image ?? 'vrd-herbal-hand-wash.jpg');
    $categoryName = is_array($prod) ? ($prod['category']['name'] ?? ($prod['category_name'] ?? 'Sustainable Living')) : ($prod->category->name ?? 'Sustainable Living');
    $categorySlug = Str::slug($categoryName);
    
    $descRaw = is_array($prod) ? ($prod['description'] ?? '') : ($prod->description ?? '');
    $description = !empty($descRaw) ? $descRaw : 'Handcrafted with natural, sustainably harvested botanicals and clean ingredients. Non-toxic, cruelty-free, and packaged in recyclable or biodegradable materials.';

    // Normalise main image
    $imagePath = '/images/themes/verde/' . $image;
    if (!file_exists(public_path('images/themes/verde/' . $image))) {
        if (file_exists(public_path('images/products/' . $image))) {
            $imagePath = '/images/products/' . $image;
        } elseif (file_exists(public_path($image))) {
            $imagePath = '/' . ltrim($image, '/');
        } else {
            $imagePath = '/images/themes/verde/vrd-herbal-hand-wash.jpg';
        }
    }
@endphp

@section('title', $name . ' | Verde Living')
@section('meta_description', Str::limit(strip_tags($description), 150))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-16">

    <!-- Breadcrumb Nav -->
    <nav class="flex items-center gap-2 text-xs text-stone-500">
        <a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-verde-primary transition-colors">Home</a>
        <span>/</span>
        <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-verde-primary transition-colors">Shop</a>
        <span>/</span>
        <a href="{{ url('/online_store/shop?category=' . $categorySlug . $previewAmp) }}" class="hover:text-verde-primary transition-colors">{{ $categoryName }}</a>
        <span>/</span>
        <span class="text-verde-primary font-semibold truncate max-w-xs">{{ $name }}</span>
    </nav>

    <!-- Main PDP Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14"
         x-data="{
             selectedQty: 1,
             selectedVariant: null,
             activeTab: 'details'
         }">
        
        <!-- Left: Gallery Showcase -->
        <div class="lg:col-span-7 space-y-4">
            <div class="w-full aspect-square rounded-3xl overflow-hidden bg-[#FAF7F2] p-8 border border-verde-borderLight flex items-center justify-center shadow-xs">
                <img src="{{ $imagePath }}" 
                     alt="{{ $name }}" 
                     class="w-full h-full object-contain object-center transform hover:scale-105 transition-transform duration-500">
            </div>

            <!-- Thumbnail Indicators -->
            <div class="flex items-center gap-3">
                <button type="button" class="w-20 h-20 rounded-2xl overflow-hidden bg-[#FAF7F2] p-2 border-2 border-verde-primary shadow-xs">
                    <img src="{{ $imagePath }}" class="w-full h-full object-contain" alt="Main view">
                </button>
                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-[#FAF7F2] p-2 border border-verde-borderLight flex items-center justify-center opacity-60">
                    <span class="text-xs text-stone-400">🌿 100% Eco</span>
                </div>
            </div>
        </div>

        <!-- Right: Product Information & Purchase Flow -->
        <div class="lg:col-span-5 flex flex-col justify-start space-y-6">
            
            <!-- Category & SKU -->
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-verde-btn">
                    {{ $categoryName }}
                </span>
                <span class="text-xs text-stone-400 font-mono">
                    SKU: {{ $code }}
                </span>
            </div>

            <!-- Product Title -->
            <h1 class="font-serif text-3xl sm:text-4xl text-verde-dark font-medium leading-tight">
                {{ $name }}
            </h1>

            <!-- Ratings & Reviews -->
            <div class="flex items-center gap-2">
                <div class="flex text-amber-500 text-sm">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-xs font-bold text-stone-700">5.0</span>
                <span class="text-xs text-stone-400">(Customer Verified)</span>
            </div>

            <!-- Price & Stock Status -->
            <div class="flex items-baseline gap-3 pt-1 border-b border-verde-borderLight pb-4">
                <span class="text-2xl sm:text-3xl font-bold text-verde-dark">
                    ${{ number_format((float)$price, 2) }}
                </span>
                @if($origPrice > $price)
                    <span class="text-sm text-stone-400 line-through">
                        ${{ number_format((float)$origPrice, 2) }}
                    </span>
                @endif
                <span class="ml-auto inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[0.7rem] font-bold bg-emerald-100 text-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    <span>In Stock (Ships Carbon-Neutral)</span>
                </span>
            </div>

            <!-- Description -->
            <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-light">
                {{ $description }}
            </p>

            <!-- Quantity & Add to Cart -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center gap-4">
                    <!-- Qty Selector -->
                    <div class="flex items-center border border-verde-border rounded-xl bg-white p-1 shadow-xs">
                        <button type="button" 
                                @click="if(selectedQty > 1) selectedQty--"
                                class="w-9 h-9 rounded-lg flex items-center justify-center text-stone-600 hover:bg-verde-sand font-bold text-sm transition-colors">
                            -
                        </button>
                        <span class="w-10 text-center text-sm font-bold text-verde-dark" x-text="selectedQty">1</span>
                        <button type="button" 
                                @click="selectedQty++"
                                class="w-9 h-9 rounded-lg flex items-center justify-center text-stone-600 hover:bg-verde-sand font-bold text-sm transition-colors">
                            +
                        </button>
                    </div>

                    <!-- Add to Bag CTA -->
                    <button type="button"
                            @click="CartLS.add({
                                id: {{ $id }},
                                code: '{{ $code }}',
                                name: '{{ addslashes($name) }}',
                                price: {{ (float) $price }},
                                final_display_price: {{ (float) $price }},
                                image: '{{ $image }}'
                            }, selectedQty)"
                            class="flex-grow py-3.5 px-6 bg-verde-btn hover:bg-verde-btnHover text-white font-bold text-xs uppercase tracking-[0.16em] rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Add to Shopping Bag</span>
                    </button>
                </div>
            </div>

            <!-- Sustainable Value Props -->
            <div class="grid grid-cols-2 gap-3 pt-6 border-t border-verde-borderLight text-xs text-stone-600">
                <div class="flex items-center gap-2 bg-white/80 p-3 rounded-xl border border-verde-borderLight">
                    <span class="text-base">🌱</span>
                    <span>100% Ethical & Sustainable</span>
                </div>
                <div class="flex items-center gap-2 bg-white/80 p-3 rounded-xl border border-verde-borderLight">
                    <span class="text-base">📦</span>
                    <span>Plastic-Free Recyclable Box</span>
                </div>
                <div class="flex items-center gap-2 bg-white/80 p-3 rounded-xl border border-verde-borderLight">
                    <span class="text-base">🚚</span>
                    <span>Free Shipping Over $75</span>
                </div>
                <div class="flex items-center gap-2 bg-white/80 p-3 rounded-xl border border-verde-borderLight">
                    <span class="text-base">🔄</span>
                    <span>30-Day Mindful Returns</span>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
