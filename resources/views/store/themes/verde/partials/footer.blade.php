@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<footer class="bg-[#182215] text-[#ECE6DC] pt-16 pb-12 border-t border-[#263522]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 5 Top Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-14 border-b border-[#2D3D28]">
            
            <!-- Col 1: About Verde Living -->
            <div class="lg:col-span-1 space-y-4">
                <h4 class="font-bold text-xs uppercase tracking-[0.14em] text-white">About Verde Living</h4>
                <p class="text-xs text-stone-300 leading-relaxed">
                    We believe small choices can create a big impact. Our products are made with care for you and the planet.
                </p>
                <!-- Social Media Links -->
                <div class="flex items-center gap-3 text-stone-400 pt-2">
                    <a href="#" class="w-8 h-8 rounded-full bg-[#243320] flex items-center justify-center hover:bg-verde-btn hover:text-white transition-colors" aria-label="Instagram">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#243320] flex items-center justify-center hover:bg-verde-btn hover:text-white transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#243320] flex items-center justify-center hover:bg-verde-btn hover:text-white transition-colors" aria-label="Pinterest">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.357-.056.23-.182.28-.419.168-1.564-.728-2.541-3.013-2.541-4.851 0-3.955 2.875-7.59 8.298-7.59 4.356 0 7.744 3.105 7.744 7.256 0 4.331-2.73 7.818-6.518 7.818-1.272 0-2.467-.662-2.877-1.446l-.784 2.994c-.285 1.096-1.057 2.47-1.573 3.313 1.152.356 2.375.549 3.644.549 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-[#243320] flex items-center justify-center hover:bg-verde-btn hover:text-white transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Shop -->
            <div>
                <h4 class="font-bold text-xs uppercase tracking-[0.14em] text-white mb-4">Shop</h4>
                <ul class="space-y-2.5 text-xs text-stone-300">
                    <li><a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">All Products</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">New Arrivals</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">Best Sellers</a></li>
                    <li><a href="{{ url('/online_store/shop?category=home-decor' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">Collections</a></li>
                    <li><a href="{{ url('/online_store/shop?category=gifts-sets' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">Gift Cards</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=sale' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">Sale</a></li>
                </ul>
            </div>

            <!-- Col 3: Customer Care -->
            <div>
                <h4 class="font-bold text-xs uppercase tracking-[0.14em] text-white mb-4">Customer Care</h4>
                <ul class="space-y-2.5 text-xs text-stone-300">
                    <li><a href="{{ url('/online_store/account/orders' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Track Your Order</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Returns & Exchanges</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Shipping Info</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">FAQs</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 4: Company -->
            <div>
                <h4 class="font-bold text-xs uppercase tracking-[0.14em] text-white mb-4">Company</h4>
                <ul class="space-y-2.5 text-xs text-stone-300">
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Our Story</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Sustainability</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=journal' . $previewAmp) }}" class="hover:text-emerald-300 transition-colors">Blog</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Careers</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-emerald-300 transition-colors">Wholesale</a></li>
                </ul>
            </div>

            <!-- Col 5: Stay In The Loop -->
            <div class="lg:col-span-1 space-y-3.5">
                <h4 class="font-bold text-xs uppercase tracking-[0.14em] text-white">Stay In The Loop</h4>
                <p class="text-xs text-stone-300">Exclusive offers, eco tips, and more.</p>

                <!-- Newsletter Form with Arrow Button -->
                <form action="{{ url('/online_store/newsletter/subscribe') }}" method="POST" class="relative">
                    @csrf
                    <input type="email" 
                           name="email" 
                           placeholder="Enter your email" 
                           required 
                           class="w-full bg-white text-stone-900 placeholder-stone-400 pl-4 pr-11 py-2.5 rounded-full text-xs focus:outline-hidden focus:ring-2 focus:ring-verde-btn shadow-xs">
                    <button type="submit" 
                            class="absolute right-1 top-1 bottom-1 w-8 rounded-full bg-verde-btn hover:bg-verde-btnHover text-white flex items-center justify-center transition-colors"
                            aria-label="Subscribe to newsletter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>

                <!-- Benefit Checkmarks -->
                <div class="space-y-1.5 text-[0.72rem] text-emerald-200/80 pt-1">
                    <div class="flex items-center gap-1.5">
                        <span>✓</span>
                        <span>10% Off Your First Order</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span>✓</span>
                        <span>Unsubscribe Anytime</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright & Payment Methods -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-stone-400">
            <!-- Left Country/Currency -->
            <div class="flex items-center gap-2">
                <span class="text-stone-300">🌐 United States (USD)</span>
                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>

            <!-- Center Copyright -->
            <div class="text-stone-400 text-center">
                © 2024 Verde Living. All Rights Reserved.
            </div>

            <!-- Right Payment Badges -->
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span class="px-2 py-1 bg-white text-[#1A1F71] font-extrabold text-[0.62rem] rounded shadow-xs">VISA</span>
                <span class="px-2 py-1 bg-white text-[#EB001B] font-extrabold text-[0.62rem] rounded shadow-xs">MC</span>
                <span class="px-2 py-1 bg-white text-[#006FCF] font-extrabold text-[0.62rem] rounded shadow-xs">AMEX</span>
                <span class="px-2 py-1 bg-white text-black font-extrabold text-[0.62rem] rounded shadow-xs">Pay</span>
                <span class="px-2 py-1 bg-white text-stone-800 font-extrabold text-[0.62rem] rounded shadow-xs">GPay</span>
                <span class="px-2 py-1 bg-white text-[#5A31F4] font-extrabold text-[0.62rem] rounded shadow-xs">ShopPay</span>
            </div>
        </div>
    </div>
</footer>
