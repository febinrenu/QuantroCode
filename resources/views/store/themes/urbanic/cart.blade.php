@extends('store.themes.urbanic._shell')

@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $checkoutUrl = url('online_store/checkout') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8"
     x-data="urbanicCartPage()">

    <!-- Page Title & Progress -->
    <div class="border-b border-slate-200 pb-5">
        <h1 class="text-2xl sm:text-3xl font-black text-urb-dark uppercase tracking-tight">
            Shopping Bag (<span x-text="items.reduce((sum, item) => sum + (item.quantity || 1), 0)"></span>)
        </h1>

        <!-- Free Shipping Progress Tracker ($75 Threshold) -->
        <div class="mt-4 bg-orange-50 rounded-2xl p-4 border border-orange-100 max-w-xl space-y-2">
            <div class="flex items-center justify-between text-xs font-bold text-urb-dark">
                <span x-show="subtotal >= 75" class="text-emerald-600 flex items-center gap-1.5">
                    <span>🎉</span> You've unlocked <strong>Free Standard Shipping</strong>!
                </span>
                <span x-show="subtotal < 75" class="text-slate-700">
                    Add <strong class="text-orange-600" x-text="'$' + (75 - subtotal).toFixed(2)"></strong> more to get <strong>Free Shipping</strong>!
                </span>
                <span class="text-slate-400 font-bold" x-text="Math.min(100, Math.round((subtotal / 75) * 100)) + '%'"></span>
            </div>
            <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                <div class="bg-orange-500 h-full transition-all duration-500 rounded-full"
                     :style="'width: ' + Math.min(100, (subtotal / 75) * 100) + '%'"></div>
            </div>
        </div>
    </div>

    <!-- Empty Cart State -->
    <div x-show="items.length === 0"
         x-cloak
         class="py-20 text-center space-y-5 bg-slate-50 rounded-3xl border border-slate-200">
        <div class="w-20 h-20 mx-auto rounded-full bg-white flex items-center justify-center text-4xl shadow-sm">
            🛍️
        </div>
        <div class="space-y-1">
            <h2 class="text-xl font-black text-urb-dark">Your bag is empty</h2>
            <p class="text-xs sm:text-sm text-slate-500 max-w-sm mx-auto">
                Explore the latest summer fashion drops and add your favorite pieces to your bag.
            </p>
        </div>
        <a href="{{ $shopUrl }}"
           class="inline-block px-8 py-3.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-black uppercase tracking-wider rounded-full shadow-lg transition-all hover:scale-105">
            Start Shopping
        </a>
    </div>

    <!-- Filled Cart Grid -->
    <div x-show="items.length > 0"
         x-cloak
         class="grid grid-cols-1 lg:grid-cols-3 gap-8 sm:gap-10">

        <!-- Left 2 Cols: Cart Item List -->
        <div class="lg:col-span-2 space-y-4">

            <template x-for="(item, index) in items" :key="item.id || index">
                <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex items-center gap-4 sm:gap-6 justify-between">

                    <!-- Product Thumbnail -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-slate-50 rounded-2xl p-2 border border-slate-100 shrink-0 flex items-center justify-center overflow-hidden">
                        <img :src="item.image || '{{ global_asset('images/themes/urbanic/urb-oversize-tee.jpg') }}'"
                             :alt="item.name"
                             class="w-full h-full object-contain">
                    </div>

                    <!-- Title & Unit Price -->
                    <div class="flex-1 min-w-0 space-y-1">
                        <h3 class="text-xs sm:text-sm font-bold text-urb-dark truncate" x-text="item.name"></h3>
                        <p class="text-xs font-medium text-slate-400" x-text="'$' + Number(item.price).toFixed(2) + ' each'"></p>
                    </div>

                    <!-- Quantity Counter -->
                    <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-1 shrink-0">
                        <button type="button"
                                @click="decreaseQty(item)"
                                class="w-7 h-7 rounded-lg bg-white hover:bg-slate-200 text-urb-dark font-black flex items-center justify-center text-xs transition">
                            -
                        </button>
                        <span class="w-8 text-center text-xs font-black text-urb-dark" x-text="item.quantity"></span>
                        <button type="button"
                                @click="increaseQty(item)"
                                class="w-7 h-7 rounded-lg bg-white hover:bg-slate-200 text-urb-dark font-black flex items-center justify-center text-xs transition">
                            +
                        </button>
                    </div>

                    <!-- Total Price -->
                    <div class="text-right shrink-0 min-w-[70px]">
                        <span class="text-sm sm:text-base font-black text-urb-dark"
                              x-text="'$' + (Number(item.price) * Number(item.quantity)).toFixed(2)"></span>
                    </div>

                    <!-- Delete Button -->
                    <button type="button"
                            @click="removeItem(item)"
                            class="p-2 text-slate-400 hover:text-rose-500 transition rounded-lg hover:bg-rose-50"
                            aria-label="Remove item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>

                </div>
            </template>

        </div>

        <!-- Right 1 Col: Order Summary Box -->
        <div class="lg:col-span-1">
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 space-y-6 sticky top-24 shadow-xs">

                <h2 class="text-base font-black text-urb-dark uppercase tracking-tight border-b border-slate-200 pb-3">
                    Order Summary
                </h2>

                <div class="space-y-3 text-xs font-medium text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Bag Subtotal</span>
                        <span class="font-bold text-urb-dark" x-text="'$' + subtotal.toFixed(2)"></span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Estimated Shipping</span>
                        <span class="font-bold text-emerald-600" x-text="subtotal >= 75 ? 'FREE' : '$4.99'"></span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Sales Tax (Estimated)</span>
                        <span class="font-bold text-urb-dark" x-text="'$' + (subtotal * 0.08).toFixed(2)"></span>
                    </div>

                    <div class="border-t border-slate-200 pt-3 flex items-center justify-between text-base font-black text-urb-dark">
                        <span>Total</span>
                        <span class="text-xl text-orange-600"
                              x-text="'$' + (subtotal + (subtotal >= 75 ? 0 : 4.99) + (subtotal * 0.08)).toFixed(2)"></span>
                    </div>
                </div>

                <!-- Checkout CTA -->
                <a href="{{ $checkoutUrl }}"
                   class="block w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-xl hover:shadow-2xl text-center transition-all hover:scale-105">
                    Proceed To Checkout
                </a>

                <!-- Guarantee Badges -->
                <div class="space-y-2 pt-2 text-[11px] text-slate-500 font-medium">
                    <div class="flex items-center gap-2">
                        <span>🔒</span> <span>100% Secure Checkout Guaranteed</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>💳</span> <span>All Major Cards & Digital Wallets Accepted</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<script>
    function urbanicCartPage() {
        return {
            items: [],

            init() {
                this.loadCart();
                window.addEventListener('cart-updated', () => this.loadCart());
                window.addEventListener('storage', () => this.loadCart());
            },

            loadCart() {
                if (window.CartLS) {
                    this.items = window.CartLS.get();
                } else {
                    try {
                        const raw = localStorage.getItem('cart_' + (window.tenantDomain || window.location.hostname));
                        this.items = raw ? JSON.parse(raw) : [];
                    } catch (e) {
                        this.items = [];
                    }
                }
            },

            get subtotal() {
                return this.items.reduce((sum, item) => sum + (Number(item.price) * Number(item.quantity || 1)), 0);
            },

            increaseQty(item) {
                if (window.CartLS) {
                    window.CartLS.add(item.id, 1, item);
                } else {
                    item.quantity = (item.quantity || 1) + 1;
                    this.saveCart();
                }
                this.loadCart();
            },

            decreaseQty(item) {
                if (window.CartLS) {
                    if (item.quantity > 1) {
                        window.CartLS.add(item.id, -1, item);
                    } else {
                        window.CartLS.remove(item.id);
                    }
                } else {
                    if (item.quantity > 1) {
                        item.quantity -= 1;
                    } else {
                        this.items = this.items.filter(i => i.id !== item.id);
                    }
                    this.saveCart();
                }
                this.loadCart();
            },

            removeItem(item) {
                if (window.CartLS) {
                    window.CartLS.remove(item.id);
                } else {
                    this.items = this.items.filter(i => i.id !== item.id);
                    this.saveCart();
                }
                this.loadCart();
            },

            saveCart() {
                const key = 'cart_' + (window.tenantDomain || window.location.hostname);
                localStorage.setItem(key, JSON.stringify(this.items));
                window.dispatchEvent(new CustomEvent('cart-updated'));
            }
        };
    }
</script>

@endsection
