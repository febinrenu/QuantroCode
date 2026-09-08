@extends('store.themes.naturae-wellness._shell')

@section('title', 'Shopping Bag — Naturae Pure Organic Essentials')

@section('content')
@php
    $previewTheme = request('preview_theme', 'naturae');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $checkoutUrl = url('/online_store/checkout' . ($previewTheme ? '?preview_theme=' . $previewTheme : ''));
@endphp

<!-- Cart Header -->
<div class="bg-naturae-sand/80 border-b border-naturae-border/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-naturae-forest">
            Your Shopping Bag
        </h1>
        <p class="text-xs sm:text-sm text-naturae-muted mt-1">
            Review your selected botanical and organic wellness essentials.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="miniCart()" x-cloak>

    <!-- Empty Cart State -->
    <template x-if="!items.length">
        <div class="bg-white rounded-3xl p-12 text-center max-w-lg mx-auto border border-naturae-border shadow-sm space-y-4">
            <div class="w-16 h-16 rounded-full bg-naturae-sand text-naturae-forest mx-auto flex items-center justify-center text-2xl">
                🛍️
            </div>
            <h2 class="font-serif text-2xl font-bold text-naturae-forest">Your bag is empty</h2>
            <p class="text-xs text-naturae-muted leading-relaxed">
                You have not added any natural wellness essentials to your shopping bag yet.
            </p>
            <div class="pt-2">
                <a href="{{ $shopUrl }}"
                   class="inline-block px-8 py-3.5 bg-naturae-forest hover:bg-naturae-green text-white font-semibold text-xs uppercase tracking-widest rounded-xl transition shadow-md">
                    Explore Botanical Catalog
                </a>
            </div>
        </div>
    </template>

    <!-- Populated Cart State -->
    <div x-show="items.length" class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- Left: Cart Items (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Free Shipping Progress -->
            <div class="bg-white p-4 rounded-2xl border border-naturae-border shadow-sm">
                <div class="flex items-center justify-between text-xs mb-2">
                    <span class="font-semibold text-emerald-700" x-show="subtotal >= 99">
                        🎉 Congratulations! You qualified for Free Shipping.
                    </span>
                    <span class="text-naturae-forest font-medium" x-show="subtotal < 99">
                        Add <strong class="text-naturae-forest" x-text="money(99 - subtotal)"></strong> more to get <strong>FREE Standard Shipping</strong>!
                    </span>
                    <span class="text-naturae-muted font-bold" x-text="Math.min(100, Math.round((subtotal / 99) * 100)) + '%'"></span>
                </div>
                <div class="w-full bg-naturae-sand rounded-full h-2 overflow-hidden">
                    <div class="bg-naturae-forest h-2 rounded-full transition-all duration-500" :style="'width: ' + Math.min(100, (subtotal / 99) * 100) + '%'"></div>
                </div>
            </div>

            <!-- Items List -->
            <div class="bg-white rounded-3xl border border-naturae-border overflow-hidden shadow-sm divide-y divide-naturae-border/60">
                <template x-for="(item, idx) in items" :key="item.id || idx">
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-center gap-4 sm:gap-6">
                        <!-- Image -->
                        <div class="w-20 h-20 rounded-xl bg-naturae-sand/40 overflow-hidden flex-shrink-0 border border-naturae-border flex items-center justify-center p-1">
                            <img :src="item.image || '{{ global_asset('images/themes/naturae/nat-aloe-cleanser.jpg') }}'"
                                 :alt="item.name"
                                 class="max-w-full max-h-full object-contain">
                        </div>

                        <!-- Title & Price -->
                        <div class="flex-1 text-center sm:text-left space-y-1">
                            <h3 class="font-serif text-base font-semibold text-naturae-forest" x-text="item.name"></h3>
                            <p class="text-xs text-naturae-muted">
                                <span class="font-semibold text-naturae-forest" x-text="money(item.price)"></span> each
                            </p>
                        </div>

                        <!-- Qty Controls & Line Total -->
                        <div class="flex items-center gap-4 sm:gap-6">
                            <!-- Qty Buttons -->
                            <div class="flex items-center border border-naturae-border rounded-lg bg-naturae-bg overflow-hidden h-9">
                                <button type="button"
                                        @click="dec(item)"
                                        class="w-8 h-full flex items-center justify-center text-naturae-forest hover:bg-naturae-sand font-bold text-xs transition">
                                    -
                                </button>
                                <span class="w-10 text-center text-xs font-bold text-naturae-forest" x-text="item.qty || 1"></span>
                                <button type="button"
                                        @click="inc(item)"
                                        class="w-8 h-full flex items-center justify-center text-naturae-forest hover:bg-naturae-sand font-bold text-xs transition">
                                    +
                                </button>
                            </div>

                            <!-- Line Total -->
                            <div class="font-serif text-base font-bold text-naturae-forest w-20 text-right" x-text="lineTotal(item)"></div>

                            <!-- Remove Button -->
                            <button type="button"
                                    @click="remove(item)"
                                    class="text-naturae-muted hover:text-rose-600 transition p-1.5 rounded-lg hover:bg-rose-50"
                                    title="Remove item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Back to Shop & Clear Bag -->
            <div class="flex justify-between items-center pt-2">
                <a href="{{ $shopUrl }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-naturae-forest hover:text-naturae-sage transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Continue Shopping</span>
                </a>

                <button type="button"
                        @click="clear()"
                        class="text-xs text-naturae-muted hover:text-rose-600 transition">
                    Clear Bag
                </button>
            </div>

        </div>

        <!-- Right: Order Summary (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-naturae-border shadow-sm space-y-4">
                <h2 class="font-serif text-lg font-bold text-naturae-forest uppercase tracking-wider pb-3 border-b border-naturae-border">
                    Order Summary
                </h2>

                <div class="space-y-2 text-xs text-naturae-text/80">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold text-naturae-forest" x-text="money(subtotal)">$0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Shipping</span>
                        <span class="font-semibold" :class="subtotal >= 99 ? 'text-emerald-700' : 'text-naturae-forest'" x-text="subtotal >= 99 ? 'FREE' : '$6.50'">
                            $6.50
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Taxes</span>
                        <span class="text-naturae-muted">Calculated at checkout</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-naturae-border flex justify-between items-baseline font-serif">
                    <span class="text-base font-bold text-naturae-forest">Estimated Total</span>
                    <span class="text-2xl font-bold text-naturae-forest" x-text="money(subtotal + (subtotal >= 99 || subtotal === 0 ? 0 : 6.50))">
                        $0.00
                    </span>
                </div>

                <!-- Checkout CTA -->
                <button type="button"
                        @click="checkout('{{ $checkoutUrl }}')"
                        class="w-full bg-naturae-forest hover:bg-naturae-green text-white py-3.5 px-6 rounded-xl font-semibold uppercase tracking-widest text-xs flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition">
                    <span>Proceed to Checkout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>

                <div class="pt-4 text-center text-[11px] text-naturae-muted space-y-1">
                    <p>🔒 256-bit SSL encrypted safe checkout</p>
                    <p>🌱 Carbon-neutral delivery on all orders</p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
