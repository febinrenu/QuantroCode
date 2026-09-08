@php
    $previewTheme = request('preview_theme', 'naturae');
    $storeUrl = url('online_store') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
    $shopUrl = url('online_store/shop') . ($previewTheme ? '?preview_theme=' . $previewTheme : '');
@endphp

<footer class="bg-naturae-dark text-naturae-bg pt-16 pb-12 border-t border-white/5 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">

            <!-- Col 1 & 2: Brand Info -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ $storeUrl }}" class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-white text-naturae-dark flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A9.49 9.49 0 0 0 12 21a10 10 0 0 0 10-10c0-1.5-.32-2.92-.88-4.21A10.74 10.74 0 0 0 17 8zm-4.32 10.94a7.51 7.51 0 0 1-3.68-1.57C11.39 12.87 13.9 9.5 17 8.2a8 8 0 0 1-4.32 10.74z" />
                        </svg>
                    </div>
                    <span class="font-serif text-xl font-bold tracking-[0.2em] text-white uppercase">
                        NATURAE
                    </span>
                </a>
                <p class="text-xs text-naturae-bg/70 leading-relaxed max-w-sm">
                    Thoughtfully crafted organic wellness and botanical beauty essentials. 100% plant-based, cruelty-free, and ethically formulated for holistic everyday care.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white/10 text-emerald-300 border border-emerald-400/20">
                        🌱 100% Organic Ingredients
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-white/10 text-emerald-300 border border-emerald-400/20">
                        🐰 Cruelty-Free Certified
                    </span>
                </div>
            </div>

            <!-- Col 3: Shop -->
            <div>
                <h4 class="font-serif text-sm font-semibold text-white uppercase tracking-wider mb-4">Shop</h4>
                <ul class="space-y-2.5 text-xs text-naturae-bg/70">
                    <li><a href="{{ url('online_store/shop?category=Skincare' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Skincare</a></li>
                    <li><a href="{{ url('online_store/shop?category=Hair+Care' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Hair Care</a></li>
                    <li><a href="{{ url('online_store/shop?category=Bath+%26+Body' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Bath & Body</a></li>
                    <li><a href="{{ url('online_store/shop?category=Wellness' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Wellness</a></li>
                    <li><a href="{{ url('online_store/shop?category=Organic+Tea' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Organic Tea</a></li>
                    <li><a href="{{ url('online_store/shop?category=Gift+Sets' . ($previewTheme ? '&preview_theme=' . $previewTheme : '')) }}" class="hover:text-white transition">Gift Sets</a></li>
                </ul>
            </div>

            <!-- Col 4: Customer Care -->
            <div>
                <h4 class="font-serif text-sm font-semibold text-white uppercase tracking-wider mb-4">Customer Care</h4>
                <ul class="space-y-2.5 text-xs text-naturae-bg/70">
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Shipping Policy</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Easy Returns & Exchanges</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Track Your Order</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Sustainability Pledge</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">FAQ & Help Center</a></li>
                    <li><a href="{{ $shopUrl }}" class="hover:text-white transition">Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 5: Newsletter -->
            <div>
                <h4 class="font-serif text-sm font-semibold text-white uppercase tracking-wider mb-4">Join Our Community</h4>
                <p class="text-xs text-naturae-bg/70 mb-3 leading-relaxed">
                    Subscribe for exclusive wellness rituals, seasonal discounts, and 15% off your first order.
                </p>
                <form onsubmit="event.preventDefault(); alert('Thank you for subscribing to Naturae wellness updates!');" class="space-y-2">
                    <input type="email"
                           placeholder="Enter your email"
                           required
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-3.5 py-2 text-xs text-white placeholder-naturae-bg/50 focus:outline-none focus:border-white focus:bg-white/15 transition">
                    <button type="submit"
                            class="w-full bg-naturae-sage hover:bg-emerald-600 text-white font-medium text-xs py-2 rounded-lg transition uppercase tracking-wider shadow-sm">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>

        <!-- Bottom Copyright & Badges -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-naturae-bg/50">
            <div>
                &copy; {{ date('Y') }} Naturae Organic Wellness Inc. All rights reserved.
            </div>
            <div class="flex items-center gap-4 text-xs">
                <span>Privacy Policy</span>
                <span>•</span>
                <span>Terms of Service</span>
                <span>•</span>
                <span>Eco-Certified 2026</span>
            </div>
        </div>

    </div>
</footer>
