@extends('store.themes.verde._shell')

@section('title', 'Shopping Bag | Verde Living')
@section('meta_description', 'Review your sustainable lifestyle items and proceed to our secure, carbon-neutral checkout.')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14" x-data="miniCart()">

    <!-- Header & Item Count -->
    <div class="border-b border-verde-borderLight pb-6 mb-8">
        <h1 class="font-serif text-3xl sm:text-4xl text-verde-dark font-medium">Your Shopping Bag</h1>
        <p class="text-xs text-stone-500 mt-1 font-light" x-show="count > 0">
            You have <span class="font-bold text-verde-dark" x-text="count"></span> <span x-text="count === 1 ? 'item' : 'items'"></span> in your sustainable curation.
        </p>
    </div>

    <!-- Active Cart Content -->
    <div x-cloak x-show="items.length > 0" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        
        <!-- Left: Item Table / Cards -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Free Shipping Progress Tracker ($75 Threshold) -->
            <div class="bg-white rounded-2xl p-5 border border-verde-borderLight shadow-xs">
                <div class="flex items-center justify-between text-xs font-semibold mb-2">
                    <span class="text-stone-700" x-show="freeShippingRemaining > 0">
                        Add <strong class="text-verde-btn">$<span x-text="freeShippingRemaining"></span></strong> more to unlock <strong class="text-emerald-700">FREE Carbon-Neutral Shipping</strong>!
                    </span>
                    <span class="text-emerald-700 font-bold flex items-center gap-1" x-show="freeShippingRemaining == 0">
                        <span>🎉</span> You've unlocked FREE Shipping!
                    </span>
                    <span class="text-stone-400" x-text="Math.round(progress) + '%'"></span>
                </div>
                <div class="w-full bg-verde-sand rounded-full h-2 overflow-hidden">
                    <div class="bg-verde-btn h-2 rounded-full transition-all duration-500" :style="'width: ' + progress + '%'"></div>
                </div>
            </div>

            <!-- Items List -->
            <div class="bg-white rounded-2xl border border-verde-borderLight divide-y divide-verde-borderLight overflow-hidden shadow-xs">
                <template x-for="item in items" :key="item.id + '-' + (item.variant_id || '')">
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-4">
                        
                        <!-- Thumbnail & Title -->
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-20 h-20 rounded-xl bg-[#FAF7F2] p-2 flex items-center justify-center flex-shrink-0 border border-verde-borderLight">
                                <img :src="'/images/themes/verde/' + item.image" 
                                     :alt="item.name" 
                                     class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-verde-dark" x-text="item.name"></h3>
                                <p class="text-xs text-stone-400 mt-0.5" x-text="item.category || 'Sustainable Living'"></p>
                                <p class="text-sm font-bold text-verde-dark mt-1" x-text="'$' + Number(item.price).toFixed(2)"></p>
                            </div>
                        </div>

                        <!-- Quantity Selector & Line Total -->
                        <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                            <!-- Qty Control -->
                            <div class="flex items-center border border-verde-border rounded-xl bg-white p-0.5">
                                <button type="button" 
                                        @click="updateQty(item.id, item.variant_id, item.quantity - 1)"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-stone-600 hover:bg-verde-sand text-xs font-bold transition-colors">
                                    -
                                </button>
                                <span class="w-8 text-center text-xs font-bold text-verde-dark" x-text="item.quantity"></span>
                                <button type="button" 
                                        @click="updateQty(item.id, item.variant_id, item.quantity + 1)"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center text-stone-600 hover:bg-verde-sand text-xs font-bold transition-colors">
                                    +
                                </button>
                            </div>

                            <!-- Line Total -->
                            <span class="text-sm font-bold text-verde-dark min-w-[70px] text-right" 
                                  x-text="'$' + (Number(item.price) * Number(item.quantity)).toFixed(2)">
                            </span>

                            <!-- Remove Button -->
                            <button type="button" 
                                    @click="removeItem(item.id, item.variant_id)"
                                    class="p-2 text-stone-400 hover:text-rose-500 rounded-lg transition-colors"
                                    title="Remove item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Continue Shopping Link -->
            <div class="pt-2">
                <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                   class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-verde-btn hover:text-verde-dark transition-colors">
                    <span>← Continue Mindful Shopping</span>
                </a>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl p-6 border border-verde-borderLight shadow-sm space-y-4">
                <h3 class="font-serif text-lg font-medium text-verde-dark border-b border-verde-borderLight pb-3">Order Summary</h3>
                
                <div class="space-y-2.5 text-xs text-stone-600">
                    <div class="flex justify-between">
                        <span>Items Subtotal</span>
                        <span class="font-bold text-verde-dark" x-text="'$' + subtotal.toFixed(2)">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Carbon-Neutral Shipping</span>
                        <span class="font-bold text-emerald-700" x-text="freeShippingRemaining == 0 ? 'FREE' : '$4.99'">$4.99</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Tax</span>
                        <span class="font-bold text-stone-500">Calculated at checkout</span>
                    </div>
                </div>

                <div class="border-t border-verde-borderLight pt-3 flex justify-between items-baseline">
                    <span class="text-sm font-bold text-verde-dark">Estimated Total</span>
                    <span class="text-xl font-extrabold text-verde-dark" 
                          x-text="'$' + (subtotal + (freeShippingRemaining == 0 ? 0 : 4.99)).toFixed(2)">
                        $0.00
                    </span>
                </div>

                <!-- Checkout CTA -->
                <a href="{{ url('/online_store/checkout' . $previewParam) }}" 
                   class="w-full py-4 bg-verde-btn hover:bg-verde-btnHover text-white font-bold text-xs uppercase tracking-[0.18em] rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-center">
                    <span>Proceed to Secure Checkout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>

                <!-- Security Assurance -->
                <p class="text-[0.68rem] text-center text-stone-400 font-light pt-2">
                    🔒 Guaranteed Safe & 256-Bit Encrypted Checkout
                </p>
            </div>
        </div>

    </div>

    <!-- Empty Cart State -->
    <div x-cloak x-show="items.length === 0" class="py-20 text-center space-y-6 bg-white rounded-3xl border border-verde-borderLight p-10 max-w-xl mx-auto shadow-xs">
        <div class="w-20 h-20 rounded-full bg-verde-sand text-verde-muted flex items-center justify-center mx-auto text-3xl">
            🌿
        </div>
        <div class="space-y-2">
            <h2 class="font-serif text-2xl font-medium text-verde-dark">Your bag is currently empty</h2>
            <p class="text-xs text-stone-500 max-w-sm mx-auto leading-relaxed">
                Explore our sustainable home decor, non-toxic living essentials, and organic skincare to fill your bag.
            </p>
        </div>
        <a href="{{ url('/online_store/shop' . $previewParam) }}" 
           class="inline-block px-8 py-3.5 bg-verde-btn text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-xs hover:bg-verde-btnHover transition-colors">
            Discover the Collection
        </a>
    </div>

</div>
@endsection
