@extends('store.themes.nexora._shell')

@section('title', 'Shopping Cart — Nexora')

@section('content')
@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $checkoutUrl = url('/online_store/checkout' . ($previewTheme ? '?preview_theme=' . $previewTheme : ''));
@endphp

<!-- Cart Header -->
<div class="bg-white border-b border-slate-200/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-black text-nex-navy uppercase tracking-tight">
            Shopping Cart
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
            Review your selected marketplace items before proceeding to checkout.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="miniCart()" x-cloak>

    <!-- Empty Cart State -->
    <template x-if="!items.length">
        <div class="bg-white rounded-3xl p-12 text-center max-w-lg mx-auto border border-slate-200 shadow-sm space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-nex-blue mx-auto flex items-center justify-center text-3xl">
                🛒
            </div>
            <h2 class="text-2xl font-black text-nex-navy">Your cart is empty</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
                You haven't added any products to your shopping cart yet.
            </p>
            <div class="pt-2">
                <a href="{{ $shopUrl }}"
                   class="inline-block px-8 py-3.5 bg-nex-blue hover:bg-nex-bluedark text-white font-extrabold text-xs uppercase tracking-widest rounded-2xl transition shadow-md">
                    Explore Marketplace
                </a>
            </div>
        </div>
    </template>

    <!-- Populated Cart State -->
    <div x-show="items.length" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

        <!-- Left: Items List (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Free Shipping Progress Tracker ($99 Threshold) -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center justify-between text-xs mb-2 font-bold">
                    <span class="text-emerald-700" x-show="subtotal >= 99">
                        🎉 Congratulations! You have unlocked FREE Express Shipping.
                    </span>
                    <span class="text-nex-navy" x-show="subtotal < 99">
                        Add <strong class="text-nex-blue" x-text="money(99 - subtotal)"></strong> more to qualify for <strong>FREE Shipping</strong>!
                    </span>
                    <span class="text-slate-400" x-text="Math.min(100, Math.round((subtotal / 99) * 100)) + '%'"></span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2.5 rounded-full transition-all duration-500"
                         :style="'width: ' + Math.min(100, (subtotal / 99) * 100) + '%'"></div>
                </div>
            </div>

            <!-- Items Container -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden divide-y divide-slate-100">
                <template x-for="(item, idx) in items" :key="item.id || idx">
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">

                        <!-- Thumbnail (Large & Crisp) -->
                        <div class="w-20 h-20 rounded-2xl bg-white border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center p-1.5">
                            <img :src="item.image || '{{ global_asset('images/themes/nexora/nex-airpods-pro.jpg') }}'"
                                 :alt="item.name"
                                 class="max-w-full max-h-full object-contain">
                        </div>

                        <!-- Product Title & Price -->
                        <div class="flex-1 text-center sm:text-left space-y-1">
                            <h3 class="font-bold text-sm sm:text-base text-nex-navy leading-snug" x-text="item.name"></h3>
                            <p class="text-xs text-slate-500">
                                <span class="font-bold text-nex-navy" x-text="money(item.price)"></span> each
                            </p>
                        </div>

                        <!-- Quantity Modifiers & Line Total -->
                        <div class="flex items-center gap-4 sm:gap-6">

                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 overflow-hidden h-9">
                                <button type="button"
                                        @click="dec(item)"
                                        class="w-8 h-full flex items-center justify-center text-nex-navy hover:bg-slate-200 font-bold text-xs transition">
                                    -
                                </button>
                                <span class="w-10 text-center text-xs font-black text-nex-navy" x-text="item.qty || 1"></span>
                                <button type="button"
                                        @click="inc(item)"
                                        class="w-8 h-full flex items-center justify-center text-nex-navy hover:bg-slate-200 font-bold text-xs transition">
                                    +
                                </button>
                            </div>

                            <!-- Line Total -->
                            <div class="font-black text-sm sm:text-base text-nex-navy w-24 text-right" x-text="lineTotal(item)"></div>

                            <!-- Remove Button -->
                            <button type="button"
                                    @click="remove(item)"
                                    class="text-slate-400 hover:text-rose-600 transition p-1.5 rounded-lg hover:bg-rose-50"
                                    title="Remove item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </template>
            </div>

            <!-- Footer Actions: Continue & Clear -->
            <div class="flex justify-between items-center pt-2">
                <a href="{{ $shopUrl }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-nex-navy hover:text-nex-blue transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Continue Shopping</span>
                </a>

                <button type="button"
                        @click="clear()"
                        class="text-xs font-semibold text-slate-400 hover:text-rose-600 transition">
                    Clear Cart
                </button>
            </div>

        </div>

        <!-- Right: Order Summary Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-xs space-y-5">
                <h2 class="text-base font-black text-nex-navy uppercase tracking-wider pb-3 border-b border-slate-100">
                    Order Summary
                </h2>

                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-bold text-nex-navy" x-text="money(subtotal)">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Shipping</span>
                        <span class="font-bold" :class="subtotal >= 99 ? 'text-emerald-700' : 'text-nex-navy'" x-text="subtotal >= 99 ? 'FREE' : '$4.99'">
                            $4.99
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Taxes</span>
                        <span class="text-slate-400">Calculated at checkout</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-between items-baseline">
                    <span class="text-sm font-black text-nex-navy">Estimated Total</span>
                    <span class="text-2xl font-black text-nex-navy" x-text="money(subtotal + (subtotal >= 99 || subtotal === 0 ? 0 : 4.99))">
                        $0.00
                    </span>
                </div>

                <!-- Checkout CTA (Royal Blue) -->
                <button type="button"
                        @click="checkout('{{ $checkoutUrl }}')"
                        class="w-full bg-nex-blue hover:bg-nex-bluedark text-white py-3.5 px-6 rounded-2xl font-extrabold uppercase tracking-widest text-xs flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition">
                    <span>Proceed to Checkout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>

                <div class="pt-2 text-center text-[11px] text-slate-400 space-y-1">
                    <p>🔒 256-bit SSL encrypted safe checkout</p>
                    <p>⚡ 30-day money-back guarantee</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
