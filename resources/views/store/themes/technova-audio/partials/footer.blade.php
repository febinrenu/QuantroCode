@php
    $previewTheme = request('preview_theme', 'technova');
    $themeUrl = function($path, $params = []) use ($previewTheme) {
        if ($previewTheme) {
            $params['preview_theme'] = $previewTheme;
        }
        $query = http_build_query($params);
        return url($path) . ($query ? '?' . $query : '');
    };
@endphp

<!-- TechNova Footer -->
<footer class="bg-slate-900 text-slate-400 border-t border-slate-800 text-sm">
    <!-- Main Footer Columns -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            <!-- Col 1: Brand & Contact -->
            <div class="lg:col-span-1 space-y-4">
                <a href="{{ $themeUrl('online_store') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-white tracking-tight font-heading">
                        Tech<span class="text-blue-500">Nova</span>
                    </span>
                </a>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Premium modern electronics marketplace offering cutting-edge gadgets, flagship devices, and audio innovations with official global warranties.
                </p>
                <div class="pt-2 text-xs space-y-1 text-slate-300">
                    <div class="flex items-center gap-2">
                        <span class="text-blue-500">📞</span>
                        <span>+1 (800) 832-4668</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-500">✉️</span>
                        <span>support@technova.com</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-blue-500">📍</span>
                        <span>500 Innovation Way, Silicon Valley, CA</span>
                    </div>
                </div>
            </div>

            <!-- Col 2: Shop -->
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4 font-heading">Shop Tech</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Smartphones']) }}" class="hover:text-white transition">Smartphones & Foldables</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Laptops']) }}" class="hover:text-white transition">Laptops & Workstations</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Tablets']) }}" class="hover:text-white transition">Tablets & E-Readers</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Audio']) }}" class="hover:text-white transition">Headphones & Soundbars</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Gaming']) }}" class="hover:text-white transition">Gaming Consoles & Gear</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Smart Home']) }}" class="hover:text-white transition">Smart Home & Security</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['category' => 'Accessories']) }}" class="hover:text-white transition">Cables, Docks & Power</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'deals']) }}" class="text-red-400 hover:text-red-300 font-semibold transition">🔥 Clearance Deals</a></li>
                </ul>
            </div>

            <!-- Col 3: Customer Care -->
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4 font-heading">Customer Care</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'support']) }}" class="hover:text-white transition">Help & Support Center</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'tracking']) }}" class="hover:text-white transition">Track Your Order</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'returns']) }}" class="hover:text-white transition">Returns & Replacements</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'shipping']) }}" class="hover:text-white transition">Shipping & Delivery Info</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'warranty']) }}" class="hover:text-white transition">Official Brand Warranty</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'trade-in']) }}" class="hover:text-white transition">Device Trade-in Program</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'faqs']) }}" class="hover:text-white transition">Frequently Asked Questions</a></li>
                </ul>
            </div>

            <!-- Col 4: Company -->
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4 font-heading">Company</h4>
                <ul class="space-y-2.5 text-xs">
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'about']) }}" class="hover:text-white transition">About TechNova</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'careers']) }}" class="hover:text-white transition">Careers <span class="bg-blue-600 text-white text-[9px] px-1.5 py-0.5 rounded ml-1 font-bold">HIRING</span></a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'news']) }}" class="hover:text-white transition">Tech News & Blog</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'press']) }}" class="hover:text-white transition">Press Releases</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'affiliates']) }}" class="hover:text-white transition">Affiliate Program</a></li>
                    <li><a href="{{ $themeUrl('online_store/shop', ['collection' => 'sustainability']) }}" class="hover:text-white transition">Eco & E-Waste Recycling</a></li>
                </ul>
            </div>

            <!-- Col 5: Security & Guarantee -->
            <div>
                <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-4 font-heading">100% Guaranteed</h4>
                <div class="space-y-3 text-xs">
                    <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700">
                        <div class="font-bold text-white mb-1">🛡️ Official Brand Warranty</div>
                        <p class="text-[11px] text-slate-400">All devices come with 1-2 years manufacturer direct warranty.</p>
                    </div>
                    <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700">
                        <div class="font-bold text-white mb-1">🔒 256-Bit Encrypted Checkout</div>
                        <p class="text-[11px] text-slate-400">PCI-DSS Level 1 compliant secure payment gateway.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4 text-xs">
            <div class="text-slate-500">
                &copy; {{ date('Y') }} TechNova Electronics Inc. All rights reserved. Built for performance and innovation.
            </div>
            <div class="flex flex-wrap items-center gap-4 text-slate-400">
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'privacy']) }}" class="hover:text-white transition">Privacy Policy</a>
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'terms']) }}" class="hover:text-white transition">Terms of Service</a>
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'cookies']) }}" class="hover:text-white transition">Cookie Settings</a>
                <a href="{{ $themeUrl('online_store/shop', ['collection' => 'sitemap']) }}" class="hover:text-white transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
