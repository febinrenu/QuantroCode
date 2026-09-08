@extends('store.themes.technova-audio._shell')

@section('title', 'Shopping Cart | TechNova Electronics')

@section('content')
@php
    $previewTheme = request('preview_theme', 'technova');
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };

    $cartItems = $cart ?? [];
    $subtotal = 0;
    foreach ($cartItems as $item) {
        $subtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
    }
    $shippingThreshold = 49.00;
    $isFreeShipping = $subtotal >= $shippingThreshold;
    $progressPercent = min(100, round(($subtotal / $shippingThreshold) * 100));
@endphp

<div class="bg-slate-50 min-h-screen py-10" x-data="{ couponApplied: false, couponCode: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ $themeUrl('online_store') }}" class="hover:text-blue-600 transition">Home</a>
            <span>/</span>
            <span class="text-slate-700 font-semibold">Shopping Cart</span>
        </div>

        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight font-heading mb-8">
            Your Tech Bag (<span x-text="$store?.cart?.count ?? {{ count($cartItems) }}">{{ count($cartItems) }}</span>)
        </h1>

        @if(empty($cartItems))
            <!-- Empty Cart State -->
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-xl mx-auto shadow-tech-sm">
                <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-6 text-3xl">
                    🛒
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2 font-heading">Your Cart is Empty</h2>
                <p class="text-xs text-slate-500 mb-8 leading-relaxed">
                    Looks like you haven't added any flagship smartphones, laptops, audio gear, or accessories to your cart yet.
                </p>
                <a href="{{ $themeUrl('online_store/shop') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow-lg shadow-blue-600/20">
                    <span>Explore Products</span>
                    <span>&rarr;</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left: Cart Items List -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Free Shipping Progress Bar -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-tech-sm">
                        <div class="flex items-center justify-between text-xs mb-2">
                            @if($isFreeShipping)
                                <span class="font-bold text-emerald-600 flex items-center gap-1.5">
                                    <span>🎉</span>
                                    <span>You've unlocked Free Express Shipping!</span>
                                </span>
                            @else
                                <span class="font-bold text-slate-700">
                                    Add <span class="text-blue-600 font-extrabold">${{ number_format($shippingThreshold - $subtotal, 2) }}</span> more for Free Express Shipping!
                                </span>
                            @endif
                            <span class="font-mono text-slate-400 font-bold">{{ $progressPercent }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-600 to-cyan-400 transition-all duration-500" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                    </div>

                    <!-- Items Container -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 divide-y divide-slate-100 shadow-tech-sm overflow-hidden">
                        @foreach($cartItems as $cKey => $item)
                            @php
                                $itemPrice = $item['price'] ?? 0;
                                $itemQty = $item['quantity'] ?? 1;
                                $itemTotal = $itemPrice * $itemQty;
                                $itemImg = $item['image'] ?? global_asset('images/themes/technova/generic-electronics.jpg');
                                $pId = $item['product_id'] ?? ($item['id'] ?? 0);
                            @endphp
                            <div class="p-6 flex flex-col sm:flex-row items-center justify-between gap-6" id="cart-item-{{ $cKey }}">
                                <!-- Left info -->
                                <div class="flex items-center gap-4 w-full sm:w-auto">
                                    <div class="w-20 h-20 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0 relative">
                                        <img src="{{ $itemImg }}" alt="{{ $item['name'] ?? 'Product' }}" class="w-full h-full object-cover" onerror="this.src='{{ global_asset('images/themes/technova/generic-electronics.jpg') }}'" />
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-sm leading-snug hover:text-blue-600 transition">
                                            <a href="{{ $themeUrl('online_store/product/' . $pId) }}">{{ $item['name'] ?? 'Electronics Item' }}</a>
                                        </h3>
                                        <div class="text-xs text-slate-400 mt-1">
                                            Unit Price: <span class="font-bold text-slate-700">${{ number_format($itemPrice, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right controls -->
                                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center border border-slate-200 rounded-xl bg-white shadow-sm overflow-hidden">
                                        <button type="button"
                                                class="js-cart-qty px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition"
                                                data-cart-key="{{ $cKey }}"
                                                data-action="decrease">&minus;</button>
                                        <span class="px-3.5 py-1.5 text-xs font-extrabold text-slate-900">{{ $itemQty }}</span>
                                        <button type="button"
                                                class="js-cart-qty px-3 py-1.5 text-slate-600 hover:bg-slate-100 font-bold transition"
                                                data-cart-key="{{ $cKey }}"
                                                data-action="increase">&plus;</button>
                                    </div>

                                    <!-- Item Subtotal -->
                                    <div class="text-right">
                                        <div class="text-base font-extrabold text-slate-900 font-heading">
                                            ${{ number_format($itemTotal, 2) }}
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <button type="button"
                                            class="js-remove-from-cart text-slate-400 hover:text-red-500 p-2 rounded-lg hover:bg-red-50 transition"
                                            data-cart-key="{{ $cKey }}"
                                            title="Remove item">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-tech-sm space-y-6">
                        <h3 class="font-extrabold text-slate-900 text-lg tracking-tight font-heading border-b border-slate-100 pb-3">
                            Order Summary
                        </h3>

                        <!-- Promo Code Input -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Have a Promo Code?</label>
                            <div class="flex gap-2">
                                <input type="text" x-model="couponCode" placeholder="TECH10" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 uppercase" />
                                <button type="button" @click="if(couponCode) { couponApplied = true; alert('Promo code applied successfully!'); }" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition">
                                    Apply
                                </button>
                            </div>
                        </div>

                        <!-- Calculations Breakdown -->
                        <div class="space-y-3 text-xs border-t border-slate-100 pt-4">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-900">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Estimated Shipping</span>
                                <span class="font-bold {{ $isFreeShipping ? 'text-emerald-600' : 'text-slate-900' }}">
                                    {{ $isFreeShipping ? 'FREE' : '$9.99' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Estimated Sales Tax</span>
                                <span class="font-bold text-slate-900">${{ number_format($subtotal * 0.08, 2) }}</span>
                            </div>
                            <template x-if="couponApplied">
                                <div class="flex justify-between text-emerald-600 font-bold">
                                    <span>Discount (TECH10)</span>
                                    <span>-${{ number_format($subtotal * 0.10, 2) }}</span>
                                </div>
                            </template>
                        </div>

                        <!-- Total -->
                        <div class="border-t border-slate-200 pt-4 flex justify-between items-baseline">
                            <span class="text-sm font-extrabold text-slate-900 font-heading">Estimated Total</span>
                            <div class="text-right">
                                <span class="text-2xl font-extrabold text-slate-900 font-heading">
                                    ${{ number_format($subtotal + ($isFreeShipping ? 0 : 9.99) + ($subtotal * 0.08), 2) }}
                                </span>
                                <span class="block text-[10px] text-slate-400">USD with all taxes included</span>
                            </div>
                        </div>

                        <!-- Checkout CTA -->
                        <a href="{{ $themeUrl('checkout') }}" class="block w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition shadow-lg shadow-blue-600/20 text-center">
                            Proceed to Secure Checkout
                        </a>

                        <!-- Security Guarantees -->
                        <div class="pt-2 text-center text-[11px] text-slate-400 space-y-1">
                            <div>🔒 256-Bit SSL Encrypted Transaction</div>
                            <div>⚡ 100% Genuine Guaranteed with Direct Brand Warranty</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
