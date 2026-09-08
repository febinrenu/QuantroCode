@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<footer class="w-full bg-homely-primaryDark text-stone-300 pt-16 pb-12 border-t border-emerald-950 relative overflow-hidden">
    <!-- Subtle Botanical Leaf Watermark in Background -->
    <div class="absolute right-0 bottom-0 pointer-events-none opacity-5 translate-x-12 translate-y-12">
        <svg class="w-96 h-96 text-white" viewBox="0 0 100 100" fill="currentColor">
            <path d="M50 0C50 50 100 50 100 100C50 100 50 50 0 50C50 50 50 0 50 0Z"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-8 relative z-10">
        <!-- Main Footer Links Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-14 border-b border-white/10">
            <!-- 1. Brand Story Column -->
            <div class="lg:col-span-1 space-y-4">
                <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-md border border-white/20 flex items-center justify-center text-white bg-white/5">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/>
                            <path d="M12 18V12c0-2 2-3 4-3"/>
                            <path d="M12 14c-1.5 0-3-1-3-3"/>
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-xl font-bold tracking-wider text-white">HOMELY</span>
                        <span class="text-[8px] font-semibold tracking-[0.2em] text-stone-400 uppercase">LIVE BEAUTIFULLY</span>
                    </div>
                </a>

                <p class="text-xs text-stone-400 leading-relaxed">
                    We help you create a home that reflects your values and brings beauty to everyday living.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center gap-3 pt-2 text-stone-400">
                    <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 hover:text-white flex items-center justify-center transition-colors" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 hover:text-white flex items-center justify-center transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 hover:text-white flex items-center justify-center transition-colors" aria-label="Pinterest">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 hover:text-white flex items-center justify-center transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 2. Shop Links -->
            <div>
                <h4 class="text-xs font-bold text-white tracking-wider uppercase mb-4">SHOP</h4>
                <ul class="space-y-2.5 text-xs text-stone-400">
                    <li><a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-white transition-colors">All Products</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" class="hover:text-white transition-colors">New Arrivals</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" class="hover:text-white transition-colors">Best Sellers</a></li>
                    <li><a href="{{ url('/online_store/shop?category=decor' . $previewAmp) }}" class="hover:text-white transition-colors">Gift Cards</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=sale' . $previewAmp) }}" class="text-homely-terracotta hover:underline">Sale</a></li>
                </ul>
            </div>

            <!-- 3. Help & Info -->
            <div>
                <h4 class="text-xs font-bold text-white tracking-wider uppercase mb-4">HELP & INFO</h4>
                <ul class="space-y-2.5 text-xs text-stone-400">
                    <li><a href="#" class="hover:text-white transition-colors">Track Your Order</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Returns & Exchanges</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Shipping Information</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            <!-- 4. About Us -->
            <div>
                <h4 class="text-xs font-bold text-white tracking-wider uppercase mb-4">ABOUT US</h4>
                <ul class="space-y-2.5 text-xs text-stone-400">
                    <li><a href="#" class="hover:text-white transition-colors">Our Story</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Sustainability</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Press</a></li>
                </ul>
            </div>

            <!-- 5. Payment Methods -->
            <div>
                <h4 class="text-xs font-bold text-white tracking-wider uppercase mb-4">PAYMENT METHODS</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="px-2.5 py-1 bg-white rounded text-[#1A1F71] font-black text-[10px] tracking-tight">VISA</span>
                    <span class="px-2.5 py-1 bg-white rounded text-[#EB001B] font-bold text-[10px]">MC</span>
                    <span class="px-2.5 py-1 bg-white rounded text-[#006FCF] font-bold text-[10px]">AMEX</span>
                    <span class="px-2.5 py-1 bg-white rounded text-[#003087] font-bold text-[10px] italic">PayPal</span>
                    <span class="px-2.5 py-1 bg-white rounded text-black font-bold text-[10px]">Pay</span>
                    <span class="px-2.5 py-1 bg-white rounded text-stone-800 font-bold text-[10px]">G Pay</span>
                    <span class="px-2.5 py-1 bg-white rounded text-[#5A31F4] font-bold text-[10px]">shopPay</span>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright & Legal Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-400">
            <!-- Currency selector -->
            <div class="flex items-center gap-1.5 text-stone-300 hover:text-white cursor-pointer">
                <span>🇺🇸</span>
                <span>United States (USD)</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>

            <!-- Copyright -->
            <p>© {{ date('Y') }} Homely. All Rights Reserved.</p>

            <!-- Legal links -->
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                <span>|</span>
                <a href="#" class="hover:text-white transition-colors">Terms & Conditions</a>
            </div>
        </div>
    </div>
</footer>
