@extends('store.themes.zanova-flash._shell')

@section('title', 'Shopping Cart — ZANOVA Marketplace')

@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8"
     x-data="miniCart()">

    <!-- Title & Free Shipping Bar -->
    <div class="space-y-4">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
            <span>Shopping Cart</span>
            <span class="text-xs font-bold text-slate-500 bg-slate-200 px-2.5 py-1 rounded-full" x-text="count + ' items'"></span>
        </h1>

        <!-- Free Shipping Tracker -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-zanova-border shadow-xs max-w-2xl">
            <div class="flex items-center justify-between text-xs font-bold mb-2">
                <template x-if="freeShippingRemaining > 0">
                    <span class="text-slate-700">
                        Add <span class="text-zanova-purple font-black" x-text="'$' + freeShippingRemaining"></span> more for <strong class="text-emerald-600">FREE SHIPPING!</strong>
                    </span>
                </template>
                <template x-if="freeShippingRemaining == 0">
                    <span class="text-emerald-600 font-extrabold flex items-center gap-1.5">
                        <span>🎉</span>
                        <span>Congratulations! You qualify for FREE SHIPPING!</span>
                    </span>
                </template>
                <span class="text-slate-400 font-mono" x-text="Math.round(progress) + '%'"></span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                <div class="bg-gradient-to-r from-zanova-yellow via-amber-400 to-emerald-500 h-full rounded-full transition-all duration-500"
                     :style="'width: ' + progress + '%'"></div>
            </div>
        </div>
    </div>

    <!-- Main Grid: Items Table (Left) + Order Summary (Right) -->
    <template x-if="items.length > 0">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- Items Table (2 Cols) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-zanova-border shadow-xs overflow-hidden">
                <div class="divide-y divide-slate-100">
                    <template x-for="item in items" :key="item.id + (item.variant_id || '')">
                        <div class="p-5 sm:p-6 flex flex-col sm:flex-row items-center justify-between gap-4">

                            <!-- Thumbnail & Title -->
                            <div class="flex items-center gap-4 w-full sm:w-1/2">
                                <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 p-2 shrink-0 flex items-center justify-center">
                                    <img :src="'/images/themes/zanova/' + item.image"
                                         :alt="item.name"
                                         class="w-full h-full object-contain"
                                         onerror="this.src='/images/themes/zanova/znv-wireless-earbuds.jpg'">
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-xs font-bold text-slate-900 leading-snug" x-text="item.name"></h3>
                                    <p class="text-[0.72rem] text-slate-400 font-mono" x-text="'SKU: ' + (item.code || item.id)"></p>
                                    <p class="text-xs font-extrabold text-slate-900" x-text="'$' + Number(item.price).toFixed(2)"></p>
                                </div>
                            </div>

                            <!-- Quantity Controller -->
                            <div class="flex items-center gap-3">
                                <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 overflow-hidden shadow-2xs">
                                    <button type="button"
                                            @click="updateQty(item.id, item.variant_id, item.quantity - 1)"
                                            class="px-3 py-1.5 text-slate-600 hover:bg-slate-200 font-black text-xs">
                                        -
                                    </button>
                                    <span class="px-3 py-1.5 text-xs font-black text-slate-900 bg-white" x-text="item.quantity"></span>
                                    <button type="button"
                                            @click="updateQty(item.id, item.variant_id, item.quantity + 1)"
                                            class="px-3 py-1.5 text-slate-600 hover:bg-slate-200 font-black text-xs">
                                        +
                                    </button>
                                </div>
                            </div>

                            <!-- Total & Remove -->
                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                <span class="text-sm font-black text-slate-900" x-text="'$' + (Number(item.price) * Number(item.quantity)).toFixed(2)"></span>
                                <button type="button"
                                        @click="removeItem(item.id, item.variant_id)"
                                        class="text-slate-400 hover:text-rose-500 transition-colors p-1"
                                        aria-label="Remove item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            <!-- Order Summary Card (1 Col) -->
            <div class="bg-white rounded-2xl p-6 border border-zanova-border shadow-xs space-y-6">
                <h2 class="text-base font-extrabold text-slate-900">Order Summary</h2>

                <div class="space-y-3 text-xs text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Items Subtotal</span>
                        <span class="font-bold text-slate-900" x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Standard Shipping</span>
                        <span class="font-bold" :class="freeShippingRemaining == 0 ? 'text-emerald-600 font-black' : 'text-slate-900'" x-text="freeShippingRemaining == 0 ? 'FREE' : '$5.99'"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Estimated Tax</span>
                        <span class="font-bold text-slate-900">$0.00</span>
                    </div>
                </div>

                <!-- Promo Code -->
                <div class="pt-2 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Have a Promo Code?</label>
                    <div class="flex items-center gap-2">
                        <input type="text"
                               placeholder="e.g. WELCOME10"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-900 focus:outline-hidden focus:border-zanova-yellow">
                        <button type="button"
                                class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-black transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Total -->
                <div class="pt-4 border-t border-slate-100 flex items-baseline justify-between">
                    <span class="text-sm font-extrabold text-slate-900">Total</span>
                    <span class="text-2xl font-black text-slate-900" x-text="'$' + (subtotal + (freeShippingRemaining == 0 ? 0 : 5.99)).toFixed(2)"></span>
                </div>

                <!-- Checkout CTA -->
                <div class="space-y-3">
                    <a href="{{ url('/online_store/checkout' . $previewParam) }}"
                       class="w-full py-3.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>Proceed to Checkout</span>
                        <span>→</span>
                    </a>

                    <a href="{{ url('/online_store/shop' . $previewParam) }}"
                       class="w-full py-2.5 text-center text-xs font-bold text-slate-500 hover:text-zanova-navy block transition-colors">
                        ← Continue Shopping
                    </a>
                </div>

            </div>

        </div>
    </template>

    <!-- Empty State -->
    <template x-if="items.length === 0">
        <div class="py-16 text-center bg-white rounded-3xl border border-zanova-border shadow-xs p-8 max-w-lg mx-auto">
            <div class="w-20 h-20 rounded-2xl bg-amber-50 text-zanova-yellow mx-auto flex items-center justify-center text-3xl mb-5 shadow-inner">
                🛒
            </div>
            <h2 class="text-lg font-black text-slate-900">Your Cart is Currently Empty</h2>
            <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                Explore our electronics, fashion, home, and beauty deals and add your favorite products!
            </p>
            <div class="mt-6">
                <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
                   class="px-6 py-3 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md inline-flex items-center gap-2">
                    <span>Explore Mega Deals</span>
                    <span>🔥</span>
                </a>
            </div>
        </div>
    </template>

</div>
@endsection
