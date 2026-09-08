@php
    $previewParam = request('preview_theme') ? '?preview_theme=' . request('preview_theme') : '';
    $previewAmp = request('preview_theme') ? '&preview_theme=' . request('preview_theme') : '';
@endphp

<header class="sticky top-0 z-40 w-full transition-all shadow-md">

    <!-- 1. Top Yellow Announcement Bar -->
    <div class="bg-zanova-yellow text-zanova-navy text-xs font-bold py-2 px-4 sm:px-8 border-b border-amber-300">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2">
            <!-- Left Promo & CTA -->
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 font-extrabold text-[0.82rem]">
                    <span>🔥</span>
                    <span>Hot Summer Sale! Up to 70% OFF on selected items.</span>
                </span>
                <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
                   class="inline-flex items-center gap-1 px-3 py-1 bg-zanova-navy hover:bg-slate-900 text-white text-[0.7rem] font-black rounded-full transition-colors">
                    <span>Shop Now</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Right Utilities -->
            <div class="hidden md:flex items-center gap-5 text-[0.76rem] font-semibold text-zanova-navy/90">
                <a href="{{ url('/online_store/account/orders' . $previewParam) }}" class="hover:text-black transition-colors">Track Order</a>
                <span class="opacity-40">|</span>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-black transition-colors">Help & Support</a>
                <span class="opacity-40">|</span>
                <a href="{{ url('/online_store/contact' . $previewParam) }}" class="hover:text-black transition-colors">Find a Store</a>
                <span class="opacity-40">|</span>
                <div class="flex items-center gap-1 cursor-pointer hover:text-black">
                    <span>🇺🇸 EN</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                <div class="flex items-center gap-1 cursor-pointer hover:text-black">
                    <span>USD</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Deep Navy Header -->
    <div class="bg-zanova-navy text-white border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
            <div class="flex items-center justify-between gap-4 lg:gap-8">

                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <button type="button"
                            class="lg:hidden p-2 rounded-lg text-white hover:bg-slate-800 transition-colors"
                            @click="mobileMenu = true"
                            aria-label="Open mobile menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <a href="{{ url('/online_store' . $previewParam) }}" class="flex items-center gap-2.5 group">
                        <!-- Yellow Bag Emblem with Z -->
                        <div class="w-10 h-10 rounded-xl bg-zanova-yellow text-zanova-navy flex items-center justify-center font-black text-2xl shadow-md group-hover:scale-105 transition-transform">
                            Z
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-2xl tracking-tight text-white leading-none">ZANOVA</span>
                            <span class="text-[0.62rem] font-bold text-amber-400 tracking-wider mt-0.5 uppercase">Shop Beyond Limits</span>
                        </div>
                    </a>
                </div>

                <!-- Wide Center Search Bar with Categories Dropdown -->
                <div class="hidden md:flex flex-grow max-w-2xl mx-auto">
                    <form action="{{ url('/online_store/shop') }}" method="GET" class="w-full flex items-center bg-white rounded-xl overflow-hidden border-2 border-zanova-yellow shadow-inner">
                        @if(request('preview_theme'))
                            <input type="hidden" name="preview_theme" value="{{ request('preview_theme') }}">
                        @endif

                        <!-- Category Filter Dropdown -->
                        <div class="relative flex items-center bg-slate-50 border-r border-slate-200 px-3 py-2 text-xs font-bold text-slate-700">
                            <select name="category" class="bg-transparent text-xs font-bold text-slate-700 focus:outline-hidden cursor-pointer pr-4">
                                <option value="">All Categories</option>
                                <option value="electronics">Electronics</option>
                                <option value="fashion-apparel">Fashion & Apparel</option>
                                <option value="home-kitchen">Home & Kitchen</option>
                                <option value="beauty-personal-care">Beauty & Personal Care</option>
                                <option value="sports-outdoors">Sports & Outdoors</option>
                            </select>
                        </div>

                        <!-- Search Input -->
                        <input type="text"
                               name="q"
                               placeholder="Search for products, brands and more..."
                               class="flex-grow px-4 py-2.5 text-xs text-slate-900 placeholder-slate-400 focus:outline-hidden font-medium">

                        <!-- Yellow Search Submit Button -->
                        <button type="submit"
                                class="px-5 py-2.5 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy flex items-center justify-center transition-colors"
                                aria-label="Search">
                            <svg class="w-4 h-4 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Right Action Icons (Compare, Wishlist, Cart, Account) -->
                <div class="flex items-center gap-4 sm:gap-6" x-data="miniCart()">

                    <!-- Compare -->
                    <a href="{{ url('/online_store/shop' . $previewParam) }}" class="hidden xl:flex items-center gap-2 group text-slate-300 hover:text-zanova-yellow transition-colors">
                        <div class="relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold">Compare</span>
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}" class="flex items-center gap-2 group text-slate-300 hover:text-zanova-yellow transition-colors">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="absolute -top-1.5 -right-2 w-4 h-4 bg-zanova-yellow text-zanova-navy text-[0.62rem] font-black rounded-full flex items-center justify-center shadow-xs">
                                0
                            </span>
                        </div>
                        <span class="text-xs font-bold hidden sm:inline">Wishlist</span>
                    </a>

                    <!-- Cart / Bag with dynamic count -->
                    <a href="{{ url('/online_store/cart' . $previewParam) }}" class="flex items-center gap-2 group text-slate-300 hover:text-zanova-yellow transition-colors">
                        <div class="relative">
                            <svg class="w-6 h-6 text-white group-hover:text-zanova-yellow transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="absolute -top-1.5 -right-2 w-4 h-4 bg-zanova-yellow text-zanova-navy text-[0.62rem] font-black rounded-full flex items-center justify-center shadow-xs"
                                  x-text="count">
                                0
                            </span>
                        </div>
                        <span class="text-xs font-bold hidden sm:inline">Cart</span>
                    </a>

                    <!-- Account -->
                    <a href="{{ url('/online_store/account' . $previewParam) }}" class="flex items-center gap-2 group text-slate-300 hover:text-zanova-yellow transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-xs font-bold hidden sm:inline">Account</span>
                    </a>

                </div>
            </div>
        </div>
    </div>

    <!-- 3. Dark Navy Category & Navigation Bar (`#0F172A`) -->
    <div class="bg-zanova-dark border-b border-slate-800 text-white hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-12">

                <!-- Left: Shop By Categories Yellow Button -->
                <div class="relative w-64">
                    <a href="{{ url('/online_store/shop' . $previewParam) }}"
                       class="w-full py-2.5 px-4 bg-zanova-yellow hover:bg-zanova-yellowHover text-zanova-navy font-black text-xs uppercase tracking-wider rounded-t-lg flex items-center justify-between transition-colors shadow-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span>Shop By Categories</span>
                        </div>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Center: Navigation Links -->
                <nav class="flex items-center gap-7 text-xs font-bold">
                    <a href="{{ url('/online_store' . $previewParam) }}"
                       class="text-zanova-yellow border-b-2 border-zanova-yellow pb-0.5 flex items-center">
                        Home
                    </a>
                    <a href="{{ url('/online_store/shop' . $previewParam) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors">
                        Shop
                    </a>
                    <a href="{{ url('/online_store/shop?collection=mega-deals' . $previewAmp) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors flex items-center gap-1.5">
                        <span>Mega Deals</span>
                        <span class="px-1.5 py-0.5 bg-zanova-purple text-white text-[0.62rem] font-black rounded-sm shadow-xs">HOT</span>
                    </a>
                    <a href="{{ url('/online_store/shop?collection=top-brands' . $previewAmp) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors">
                        Top Brands
                    </a>
                    <a href="{{ url('/online_store/shop?collection=new-arrivals' . $previewAmp) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors">
                        New Arrivals
                    </a>
                    <a href="{{ url('/online_store/shop?collection=blog' . $previewAmp) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors">
                        Blog
                    </a>
                    <a href="{{ url('/online_store/contact' . $previewParam) }}"
                       class="text-slate-200 hover:text-zanova-yellow transition-colors">
                        Contact Us
                    </a>
                </nav>

                <!-- Right: Lightning Deals Purple Button -->
                <a href="{{ url('/online_store/shop?collection=lightning-deals' . $previewAmp) }}"
                   class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white text-xs font-black rounded-lg shadow-md flex items-center gap-1.5 transition-all">
                    <span class="text-amber-300">⚡</span>
                    <span>Lightning Deals</span>
                </a>

            </div>
        </div>
    </div>

</header>
