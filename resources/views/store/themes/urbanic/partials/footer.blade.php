@php
    $previewTheme = request('preview_theme', 'urbanic');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $newArrivalsUrl = url('online_store/shop?collection=new-arrivals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $bestsellersUrl = url('online_store/shop?collection=bestsellers' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
    $saleUrl = url('online_store/shop?collection=deals' . ($previewTheme ? '&preview_theme=' . $previewTheme : ''));
@endphp

<footer class="bg-urb-dark text-slate-300 pt-14 pb-8 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Top Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 lg:gap-10">

            <!-- Col 1 & 2: Brand Story & Socials -->
            <div class="lg:col-span-2 space-y-5">
                <a href="{{ $storeUrl }}" class="flex flex-col group inline-block">
                    <span class="text-3xl font-black tracking-tight text-white leading-none">
                        URBANIC
                    </span>
                    <span class="text-[10px] font-extrabold tracking-[0.25em] text-orange-400 uppercase mt-1">
                        Stay Stylish
                    </span>
                </a>

                <p class="text-xs sm:text-sm text-slate-400 font-medium leading-relaxed max-w-sm">
                    Your ultimate destination for trendy fashion, accessories and more. Stay stylish.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center space-x-3 text-slate-400">
                    <!-- Instagram -->
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-orange-500 hover:text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>

                    <!-- Facebook -->
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-orange-500 hover:text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.597 0 9 1.583 9 4.615V8z"/></svg>
                    </a>

                    <!-- Twitter / X -->
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-orange-500 hover:text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>

                    <!-- Pinterest -->
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-orange-500 hover:text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 12-5.373 12-12 0-6.628-5.393-12-12-12z"/></svg>
                    </a>

                    <!-- YouTube -->
                    <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-orange-500 hover:text-white flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 3: SHOP -->
            <div class="space-y-3.5">
                <h4 class="text-xs font-black uppercase tracking-wider text-white">
                    Shop
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">All Categories</a></li>
                    <li><a href="{{ $newArrivalsUrl }}" class="hover:text-white transition">New Arrivals</a></li>
                    <li><a href="{{ $bestsellersUrl }}" class="hover:text-white transition">Best Sellers</a></li>
                    <li><a href="{{ $saleUrl }}" class="hover:text-white transition">Sale</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Gift Cards</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Brands</a></li>
                </ul>
            </div>

            <!-- Col 4: CUSTOMER CARE -->
            <div class="space-y-3.5">
                <h4 class="text-xs font-black uppercase tracking-wider text-white">
                    Customer Care
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Track Your Order</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Returns & Exchanges</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Shipping Info</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">FAQs</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Size Guide</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 5: ABOUT US -->
            <div class="space-y-3.5">
                <h4 class="text-xs font-black uppercase tracking-wider text-white">
                    About Us
                </h4>
                <ul class="space-y-2 text-xs text-slate-400 font-medium">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Our Story</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Careers</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Sustainability</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Blog</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Press</a></li>
                </ul>
            </div>

            <!-- Col 6: PAYMENT METHODS -->
            <div class="space-y-3.5">
                <h4 class="text-xs font-black uppercase tracking-wider text-white">
                    Payment Methods
                </h4>
                <div class="grid grid-cols-3 gap-2">
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-blue-800 italic">VISA</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-red-600">MC</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-blue-500">AMEX</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-blue-600 italic">PayPal</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-slate-900">Pay</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs">
                        <span class="text-[10px] font-black text-slate-700">GPay</span>
                    </div>
                    <div class="bg-white rounded-md py-1.5 px-2 flex items-center justify-center shadow-xs col-span-3">
                        <span class="text-[10px] font-black text-purple-700">shopPay</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">

            <!-- Country Selector -->
            <div class="flex items-center gap-1.5 text-slate-400">
                <span>🌐</span>
                <span>United States (USD)</span>
                <svg class="w-3 h-3 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Copyright -->
            <div class="text-center font-medium">
                © {{ date('Y') }} URBANIC. All Rights Reserved.
            </div>

            <!-- Privacy & Terms -->
            <div class="flex items-center space-x-4 text-slate-400">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <span>|</span>
                <a href="#" class="hover:text-white transition">Terms & Conditions</a>
            </div>

        </div>

    </div>
</footer>
