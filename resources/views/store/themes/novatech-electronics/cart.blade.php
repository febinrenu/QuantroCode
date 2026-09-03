@extends('store.themes.novatech-electronics._shell')

@section('title', 'Your Shopping Cart — NOVATECH')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ items: [], total: 0, coupon: '', discount: 0 }" x-init="items = CartLS.get(); total = CartLS.total(); window.addEventListener('cart-updated', () => { items = CartLS.get(); total = CartLS.total(); })">

    <!-- Page Header -->
    <div class="pb-6 border-b border-slate-200 mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Your Shopping Cart</h1>
        <p class="text-xs text-slate-500 mt-1">Review your selected items and proceed to secure checkout.</p>
    </div>

    <!-- Empty State -->
    <template x-if="items.length === 0">
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm max-w-lg mx-auto my-12 space-y-5">
            <div class="w-20 h-20 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-slate-900">Your cart is currently empty</h2>
            <p class="text-xs text-slate-500">Explore our wide selection of tech, smartphones, laptops and accessories to find your gear.</p>
            <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="inline-flex items-center space-x-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider transition-all shadow-md">
                <span>Start Shopping</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </template>

    <!-- Cart Layout with Items & Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-show="items.length > 0">

        <!-- Cart Items (Col span 2) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm divide-y divide-slate-100 overflow-hidden">
                <template x-for="item in items" :key="item.id">
                    <div class="p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center space-x-4 w-full sm:w-auto">
                            <div class="w-20 h-20 rounded-xl bg-slate-50 p-2 border border-slate-200 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                <img :src="item.image.startsWith('http') || item.image.startsWith('/') ? item.image : '/images/themes/novatech/' + item.image"
                                     :alt="item.name"
                                     class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-1" x-text="item.name"></h3>
                                <p class="text-xs font-mono text-slate-400 mt-0.5" x-text="item.code ? 'SKU: ' + item.code : ''"></p>
                                <p class="text-sm font-extrabold text-indigo-600 mt-1" x-text="'$' + parseFloat(item.price).toFixed(2)"></p>
                            </div>
                        </div>

                        <!-- Quantity Controller & Subtotal -->
                        <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto">
                            <div class="flex items-center rounded-xl border border-slate-200 bg-slate-50 p-1">
                                <button @click="CartLS.updateQty(item.id, item.quantity - 1)" class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center hover:bg-slate-100">-</button>
                                <span class="w-8 text-center text-xs font-bold text-slate-900" x-text="item.quantity"></span>
                                <button @click="CartLS.updateQty(item.id, item.quantity + 1)" class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center hover:bg-slate-100">+</button>
                            </div>

                            <span class="text-sm font-black text-slate-900 w-20 text-right" x-text="'$' + (parseFloat(item.price) * item.quantity).toFixed(2)"></span>

                            <!-- Remove item button -->
                            <button @click="CartLS.remove(item.id)" class="text-slate-400 hover:text-rose-500 p-1.5 transition-colors" aria-label="Remove item">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('store.shop', ['preview_theme' => 'novatech']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Continue Shopping</span>
                </a>
                <button @click="CartLS.clear()" class="text-xs font-semibold text-rose-500 hover:text-rose-700 transition-colors">
                    Clear Entire Cart
                </button>
            </div>
        </div>

        <!-- Order Summary (Col span 1) -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
                <h2 class="text-base font-black text-slate-900 uppercase tracking-wider">Order Summary</h2>

                <div class="space-y-3 text-xs divide-y divide-slate-100">
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-slate-500">Items Subtotal</span>
                        <span class="font-bold text-slate-900" x-text="'$' + parseFloat(total).toFixed(2)"></span>
                    </div>
                    <div class="flex items-center justify-between pt-3">
                        <span class="text-slate-500">Shipping</span>
                        <span class="font-bold text-emerald-600" x-text="total >= 75 ? 'FREE' : '$9.99'"></span>
                    </div>
                    <div class="flex items-center justify-between pt-3" x-show="discount > 0">
                        <span class="text-slate-500">Promo Discount</span>
                        <span class="font-bold text-rose-600" x-text="'-$' + parseFloat(discount).toFixed(2)"></span>
                    </div>
                    <div class="flex items-center justify-between pt-4 text-sm font-black">
                        <span class="text-slate-900 uppercase">Estimated Total</span>
                        <span class="text-xl text-indigo-600" x-text="'$' + (total >= 75 ? total - discount : total + 9.99 - discount).toFixed(2)"></span>
                    </div>
                </div>

                <!-- Coupon Code Widget -->
                <div class="pt-2">
                    <div class="flex gap-2">
                        <input type="text" x-model="coupon" placeholder="Discount code (e.g. NOVATECH15)" class="flex-1 px-3 py-2 text-xs border border-slate-200 rounded-xl uppercase focus:outline-none focus:border-indigo-600">
                        <button type="button" @click="if (coupon.trim().toUpperCase() === 'NOVATECH15') { discount = total * 0.15; CartLS.showToast('Promo code NOVATECH15 applied! (15% OFF)'); } else { CartLS.showToast('Invalid promo code', 'error'); }" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-colors">
                            Apply
                        </button>
                    </div>
                </div>

                <!-- Checkout Button -->
                <a href="{{ url('/online_store/checkout?preview_theme=novatech') }}" class="w-full block py-3.5 px-6 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-xs uppercase tracking-wider text-center transition-all shadow-lg shadow-indigo-500/25">
                    Proceed to Checkout
                </a>

                <!-- Security Assurance -->
                <div class="flex items-center justify-center space-x-2 text-[11px] font-semibold text-slate-400 text-center pt-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>256-Bit SSL Encrypted Checkout</span>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
