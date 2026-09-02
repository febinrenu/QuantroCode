@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<footer class="bg-zanova-navy text-slate-300 pt-16 pb-12 border-t border-slate-800 text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Multi-Column Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8 pb-14 border-b border-slate-800">

            <!-- Col 1: Brand & Social -->
            <div class="lg:col-span-1 space-y-4">
                <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-zanova-yellow text-zanova-navy flex items-center justify-center font-black text-xl shadow-md">
                        Z
                    </div>
                    <div class="flex flex-col">
                        <span class="font-black text-xl tracking-tight text-white leading-none">ZANOVA</span>
                        <span class="text-[0.55rem] font-bold text-amber-400 tracking-wider mt-0.5 uppercase">Shop Beyond Limits</span>
                    </div>
                </a>

                <p class="text-[0.78rem] text-slate-400 leading-relaxed">
                    Quality products, unbeatable prices and exceptional service.
                </p>

                <!-- Social Icons -->
                <div class="flex items-center gap-2.5 pt-1 text-slate-400">
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center hover:bg-zanova-yellow hover:text-zanova-navy transition-all" aria-label="Facebook">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center hover:bg-zanova-yellow hover:text-zanova-navy transition-all" aria-label="Instagram">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center hover:bg-zanova-yellow hover:text-zanova-navy transition-all" aria-label="Twitter">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.936 9.936 0 0024 4.59z"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center hover:bg-zanova-yellow hover:text-zanova-navy transition-all" aria-label="YouTube">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center hover:bg-zanova-yellow hover:text-zanova-navy transition-all" aria-label="Pinterest">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345-.09.375-.291 1.199-.334 1.357-.056.23-.182.28-.419.168-1.564-.728-2.541-3.013-2.541-4.851 0-3.955 2.875-7.59 8.298-7.59 4.356 0 7.744 3.105 7.744 7.256 0 4.331-2.73 7.818-6.518 7.818-1.272 0-2.467-.662-2.877-1.446l-.784 2.994c-.285 1.096-1.057 2.47-1.573 3.313 1.152.356 2.375.549 3.644.549 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Shop -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-xs uppercase tracking-wider text-white">Shop</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">All Categories</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">New Arrivals</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=best-sellers' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">Best Sellers</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">Mega Deals</a></li>
                    <li><a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Gift Cards</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=clearance' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">Clearance Sale</a></li>
                </ul>
            </div>

            <!-- Col 3: Customer Service -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-xs uppercase tracking-wider text-white">Customer Service</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ url('/online_store/account/orders' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Track Your Order</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Returns & Exchanges</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Shipping Info</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">FAQs</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Contact Us</a></li>
                    <li><a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Support Center</a></li>
                </ul>
            </div>

            <!-- Col 4: Company -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-xs uppercase tracking-wider text-white">Company</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">About Us</a></li>
                    <li><a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Careers</a></li>
                    <li><a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Press</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=blog' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">Blog</a></li>
                    <li><a href="{{ url('/online_store' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Affiliate Program</a></li>
                </ul>
            </div>

            <!-- Col 5: My Account -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-xs uppercase tracking-wider text-white">My Account</h4>
                <ul class="space-y-2 text-slate-400">
                    <li><a href="{{ url('/online_store/account/orders' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">My Orders</a></li>
                    <li><a href="{{ url('/online_store/shop?collection=wishlist' . $previewAmp) }}" class="hover:text-zanova-yellow transition-colors">Wishlist</a></li>
                    <li><a href="{{ url('/online_store/account' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Addresses</a></li>
                    <li><a href="{{ url('/online_store/account' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Account Details</a></li>
                    <li><a href="{{ url('/online_store/account' . $previewParam) }}" class="hover:text-zanova-yellow transition-colors">Logout</a></li>
                </ul>
            </div>

            <!-- Col 6: We Accept Payment Badges -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-xs uppercase tracking-wider text-white">We Accept</h4>
                <div class="grid grid-cols-3 gap-2 pt-1">
                    <div class="bg-white text-[#1A1F71] font-black text-[0.7rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        VISA
                    </div>
                    <div class="bg-white text-[#EB001B] font-black text-[0.62rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        MC
                    </div>
                    <div class="bg-white text-[#006FCF] font-black text-[0.62rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        AMEX
                    </div>
                    <div class="bg-white text-[#003087] font-black text-[0.65rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        PayPal
                    </div>
                    <div class="bg-white text-black font-black text-[0.65rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        Pay
                    </div>
                    <div class="bg-white text-[#4285F4] font-black text-[0.65rem] px-2 py-1.5 rounded flex items-center justify-center shadow-xs">
                        G Pay
                    </div>
                    <div class="col-span-3 bg-[#5A31F4] text-white font-black text-[0.7rem] px-2 py-1 rounded flex items-center justify-center shadow-xs">
                        shop Pay
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright Bar -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-slate-500 text-[0.75rem]">
            <p>© 2024 Zanova. All Rights Reserved.</p>

            <div class="flex items-center gap-6">
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-slate-300 transition-colors">Terms & Conditions</a>
                <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hover:text-slate-300 transition-colors">Sitemap</a>
            </div>

            <!-- Scroll to Top Button -->
            <button type="button"
                    onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="w-8 h-8 rounded-lg bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy flex items-center justify-center shadow-md transition-transform hover:-translate-y-0.5"
                    aria-label="Back to top">
                <svg class="w-4 h-4 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>

    </div>
</footer>
