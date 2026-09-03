@extends('store.themes.homely._shell')

@section('title', 'Your Cart — Homely')

@section('content')
@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 sm:py-12">
    <!-- Header -->
    <div class="border-b border-homely-borderLight pb-6 mb-8">
        <h1 class="font-serif text-3xl sm:text-4xl font-bold text-homely-primary">
            Shopping Cart
        </h1>
        <p class="text-xs sm:text-sm text-stone-500 mt-1">
            Review your conscious home selections before checkout.
        </p>
    </div>

    <!-- Free Shipping Progress Tracker ($69 threshold) -->
    <div class="mb-8 p-5 rounded-2xl bg-white border border-homely-borderLight shadow-2xs space-y-2.5">
        <div class="flex items-center justify-between text-xs font-semibold">
            <span class="flex items-center gap-1.5 text-homely-primary" x-show="cart.subtotal < 69">
                <span>🚚</span>
                <span>Add <strong class="text-homely-terracotta" x-text="'$' + Math.max(0, 69 - cart.subtotal).toFixed(2)"></strong> more to qualify for <strong>FREE Shipping</strong></span>
            </span>
            <span class="flex items-center gap-1.5 text-emerald-700" x-show="cart.subtotal >= 69">
                <span>🎉</span>
                <span><strong>Congratulations!</strong> You qualify for <strong>FREE Shipping</strong>!</span>
            </span>
            <span class="text-stone-400" x-text="'$' + cart.subtotal.toFixed(2) + ' / $69.00'"></span>
        </div>
        <div class="w-full h-2.5 rounded-full bg-stone-100 overflow-hidden">
            <div class="h-full bg-homely-primary transition-all duration-500 rounded-full"
                 :style="'width: ' + Math.min(100, (cart.subtotal / 69) * 100) + '%'"></div>
        </div>
    </div>

    <!-- Cart Items & Summary Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Cart Items List (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            <!-- Empty Cart State -->
            <template x-if="cart.items.length === 0">
                <div class="py-16 px-6 text-center space-y-4 bg-white rounded-3xl border border-homely-borderLight">
                    <div class="w-16 h-16 mx-auto rounded-full bg-homely-sand flex items-center justify-center text-2xl text-homely-primary">
                        🛒
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-homely-primary">Your cart is empty</h3>
                    <p class="text-xs sm:text-sm text-stone-500 max-w-sm mx-auto">
                        Explore our handcrafted home essentials and bring nature into your living space.
                    </p>
                    <div class="pt-2">
                        <a href="{{ url('/online_store/shop' . $previewParam) }}" 
                           class="inline-block px-7 py-3 rounded-full bg-homely-primary hover:bg-homely-primaryDark text-white text-xs font-bold uppercase tracking-wider transition-all shadow-sm">
                            EXPLORE SHOP
                        </a>
                    </div>
                </div>
            </template>

            <!-- Items Loop -->
            <template x-for="(item, index) in cart.items" :key="index">
                <div class="p-4 sm:p-5 rounded-2xl bg-white border border-homely-borderLight flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-2xs">
                    <!-- Image & Name -->
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-20 h-20 rounded-xl bg-stone-50 p-2 border border-stone-100 flex-shrink-0 flex items-center justify-center">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-contain">
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase font-bold text-homely-muted" x-text="item.category || 'Home & Living'"></span>
                            <h4 class="text-sm font-bold text-homely-text" x-text="item.name"></h4>
                            <div class="text-xs font-semibold text-stone-600" x-text="'$' + parseFloat(item.price).toFixed(2)"></div>
                        </div>
                    </div>

                    <!-- Quantity Stepper & Line Total -->
                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-stone-100">
                        <!-- Stepper -->
                        <div class="flex items-center border border-homely-border rounded-full px-2.5 py-1 bg-stone-50">
                            <button type="button" 
                                    @click="updateQuantity(index, item.quantity - 1)" 
                                    class="w-6 h-6 text-stone-500 hover:text-homely-primary font-bold text-xs">
                                -
                            </button>
                            <span class="w-8 text-center text-xs font-bold" x-text="item.quantity"></span>
                            <button type="button" 
                                    @click="updateQuantity(index, item.quantity + 1)" 
                                    class="w-6 h-6 text-stone-500 hover:text-homely-primary font-bold text-xs">
                                +
                            </button>
                        </div>

                        <!-- Item Total Price -->
                        <div class="w-20 text-right text-sm font-bold text-homely-text"
                             x-text="'$' + (item.price * item.quantity).toFixed(2)">
                        </div>

                        <!-- Remove Button -->
                        <button type="button" 
                                @click="removeFromCart(index)" 
                                class="p-1.5 text-stone-400 hover:text-rose-600 transition-colors"
                                title="Remove item">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Order Summary (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-7 border border-homely-borderLight shadow-xs space-y-6">
            <h3 class="font-serif text-xl font-bold text-homely-primary">
                Order Summary
            </h3>

            <div class="space-y-3 text-xs text-stone-600 divide-y divide-stone-100">
                <div class="flex justify-between pt-1">
                    <span>Subtotal (<span x-text="cart.totalCount"></span> items)</span>
                    <span class="font-bold text-homely-text" x-text="'$' + cart.subtotal.toFixed(2)"></span>
                </div>
                <div class="flex justify-between pt-3">
                    <span>Estimated Shipping</span>
                    <span class="font-bold" x-text="cart.subtotal >= 69 || cart.subtotal === 0 ? 'FREE' : '$6.50'"></span>
                </div>
                <div class="flex justify-between pt-3">
                    <span>Tax</span>
                    <span class="font-bold text-stone-400">Calculated at checkout</span>
                </div>
                <div class="flex justify-between pt-3 text-sm font-bold text-homely-text">
                    <span>Total</span>
                    <span class="text-base font-extrabold text-homely-primary" 
                          x-text="'$' + (cart.subtotal + (cart.subtotal >= 69 || cart.subtotal === 0 ? 0 : 6.50)).toFixed(2)"></span>
                </div>
            </div>

            <!-- Checkout CTA -->
            <button type="button" 
                    :disabled="cart.items.length === 0"
                    @click="showToast('Proceeding to secure checkout...')"
                    class="w-full py-3.5 px-6 rounded-full bg-homely-primary hover:bg-homely-primaryDark disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold uppercase tracking-wider transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <span>PROCEED TO CHECKOUT</span>
                <span>&rarr;</span>
            </button>

            <!-- Trust badges -->
            <div class="pt-2 text-center text-[11px] text-stone-400 space-y-1">
                <p>🔒 256-bit SSL encrypted secure checkout</p>
                <p>🌿 Plastic-free sustainable packaging</p>
            </div>
        </div>
    </div>
</div>
@endsection
