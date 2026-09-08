@php
    $previewTheme = request('preview_theme', 'nexora');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<!-- Footer (Deep Navy Palette) -->
<footer class="bg-nex-navydark text-slate-300 text-xs border-t border-slate-800/80 mt-16">

    <!-- Main Footer Links Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">

            <!-- Column 1: Brand & Bio -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ $storeUrl }}" class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-orange-500 to-rose-500 text-white flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6h-2c0-2.76-2.24-5-5-5S7 3.24 7 6H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.66 0 3 1.34 3 3H9c0-1.66 1.34-3 3-3zm7 17H5V8h14v12z"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black tracking-tight text-white uppercase leading-none">
                            NEXORA
                        </span>
                        <span class="text-[9px] font-extrabold tracking-[0.25em] text-blue-400 uppercase mt-0.5">
                            Shop Different
                        </span>
                    </div>
                </a>

                <p class="text-xs text-slate-400 font-medium leading-relaxed max-w-sm">
                    Nexora is your all-in-one destination for quality products at the best prices. Shop smart, live better.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center space-x-3 pt-2 text-slate-400">
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-nex-blue hover:text-white flex items-center justify-center transition">
                        <span class="text-xs font-bold">fb</span>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-nex-blue hover:text-white flex items-center justify-center transition">
                        <span class="text-xs font-bold">ig</span>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-nex-blue hover:text-white flex items-center justify-center transition">
                        <span class="text-xs font-bold">tw</span>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-nex-blue hover:text-white flex items-center justify-center transition">
                        <span class="text-xs font-bold">yt</span>
                    </a>
                </div>
            </div>

            <!-- Column 2: SHOP -->
            <div>
                <h4 class="font-extrabold text-xs uppercase tracking-widest text-white mb-4">
                    SHOP
                </h4>
                <ul class="space-y-2.5 text-slate-400 text-xs">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">All Categories</a></li>
                    <li><a href="{{ url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Best Sellers</a></li>
                    <li><a href="{{ url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">New Arrivals</a></li>
                    <li><a href="{{ url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Deals</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Brands</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Gift Cards</a></li>
                </ul>
            </div>

            <!-- Column 3: CUSTOMER CARE -->
            <div>
                <h4 class="font-extrabold text-xs uppercase tracking-widest text-white mb-4">
                    CUSTOMER CARE
                </h4>
                <ul class="space-y-2.5 text-slate-400 text-xs">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Track Your Order</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Returns & Refunds</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Shipping Info</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">FAQs</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Contact Us</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Size Guide</a></li>
                </ul>
            </div>

            <!-- Column 4: ABOUT US & PAYMENT -->
            <div>
                <h4 class="font-extrabold text-xs uppercase tracking-widest text-white mb-4">
                    ABOUT US
                </h4>
                <ul class="space-y-2.5 text-slate-400 text-xs mb-6">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Our Story</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Careers</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Blog</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Affiliates</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Terms & Conditions</a></li>
                </ul>

                <!-- Payment Methods Badges -->
                <h4 class="font-extrabold text-[11px] uppercase tracking-widest text-white mb-2">
                    PAYMENT METHODS
                </h4>
                <div class="flex flex-wrap gap-1.5 pt-1">
                    <span class="px-2 py-1 bg-white text-slate-900 font-extrabold text-[10px] rounded shadow-xs">VISA</span>
                    <span class="px-2 py-1 bg-white text-slate-900 font-extrabold text-[10px] rounded shadow-xs">MC</span>
                    <span class="px-2 py-1 bg-white text-blue-700 font-extrabold text-[10px] rounded shadow-xs">PayPal</span>
                    <span class="px-2 py-1 bg-white text-cyan-800 font-extrabold text-[10px] rounded shadow-xs">AMEX</span>
                    <span class="px-2 py-1 bg-white text-slate-900 font-extrabold text-[10px] rounded shadow-xs">Pay</span>
                    <span class="px-2 py-1 bg-white text-slate-900 font-extrabold text-[10px] rounded shadow-xs">GPay</span>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright & Currency Selector -->
        <div class="pt-8 mt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">

            <div class="flex items-center gap-2">
                <span>🌐 United States (USD) ▾</span>
            </div>

            <div>
                © {{ date('Y') }} Nexora. All Rights Reserved.
            </div>

            <!-- Floating Back to Top Button -->
            <button type="button"
                    onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-500 to-amber-500 text-white flex items-center justify-center hover:scale-110 transition shadow-md"
                    title="Back to Top"
                    aria-label="Back to Top">
                ↑
            </button>

        </div>
    </div>

</footer>
