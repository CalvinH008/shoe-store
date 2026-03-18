{{-- SEGMENTED NAVBAR DENGAN BACKGROUND SOLID --}}
<nav id="navbar" class="fixed top-0 left-0 w-full z-50 bg-[#1e3a5f] shadow-lg transition-all duration-300">
    <div class="max-w-7xl mx-auto px-8 flex items-center justify-between py-3">
        {{-- LOGO --}}
        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-5 py-2">
            <a href="/" class="flex items-center gap-2 text-white transition">
                <span class="text-xl">👟</span>
                <span class="font-display font-800 text-sm tracking-widest uppercase">
                    Shoe Store
                </span>
            </a>
        </div>

        {{-- MENU --}}
        <div
            class="flex items-center gap-1 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 absolute left-1/2 -translate-x-1/2">
            <a href="/"
                class="text-sm text-white hover:text-gray-200 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                HOME
            </a>
            <a href="#"
                class="text-sm text-white hover:text-gray-200 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                ABOUT
            </a>
            {{-- COLLECTION DROPDOWN --}}
            <div class="relative group">
                <button
                    class="text-sm text-white hover:text-gray-200 flex items-center gap-1 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                    COLLECTION
                    <span class="text-xs">▼</span>
                </button>
                {{-- Jembatan invisible agar dropdown tidak hilang saat cursor bergerak --}}
                <div class="absolute top-full left-1/2 -translate-x-1/2 pt-2 hidden group-hover:block w-52">
                    <div class="bg-white text-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                        <a href="{{ route('products.index') }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition border-b border-gray-100">
                            <span>🛍️</span> All Products
                        </a>
                        <a href="{{ route('products.index') }}?category=1"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition border-b border-gray-50">
                            <span>🏃</span> Running Shoes
                        </a>
                        <a href="{{ route('products.index') }}?category=2"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition border-b border-gray-50">
                            <span>🏀</span> Basketball Shoes
                        </a>
                        <a href="{{ route('products.index') }}?category=3"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition border-b border-gray-50">
                            <span>👟</span> Sneakers
                        </a>
                        <a href="{{ route('products.index') }}?category=4"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition border-b border-gray-50">
                            <span>💪</span> Training Shoes
                        </a>
                        <a href="{{ route('products.index') }}?category=5"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 text-sm transition">
                            <span>🥾</span> Outdoor Shoes
                        </a>
                    </div>
                </div>
            </div>
            <a href="#"
                class="text-sm text-white hover:text-gray-200 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                CONTACT US
            </a>
            <a href="#faq"
                class="text-sm text-white hover:text-gray-200 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                FAQ
            </a>
        </div>

        {{-- RIGHT ACTIONS --}}
        <div class="flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2">
            @auth
                {{-- Orders --}}
                <a href="{{ route('orders.index') }}"
                    class="text-sm text-white hover:text-gray-200 transition px-3 py-1.5 rounded-full hover:bg-white/10 flex items-center gap-1.5">
                    <span>📦</span> Orders
                </a>

                {{-- Cart --}}
                <a href="{{ route('cart.page') }}"
                    class="relative text-white hover:text-gray-200 transition px-3 py-1.5 rounded-full hover:bg-white/10 flex items-center">
                    <span class="text-lg">🛒</span>
                </a>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 text-sm text-white transition px-3 py-1.5 rounded-full hover:bg-white/10 border border-white/20">
                        <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        {{ auth()->user()->name }}
                        <span class="text-xs opacity-50">▾</span>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute right-0 mt-3 w-48 bg-white text-gray-700 rounded-2xl shadow-xl z-50 overflow-hidden border border-gray-100 py-1">

                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.products.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50 transition">
                                <span>🏪</span> Store Management
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1"></div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-slate-50 transition">
                                <span>🚪</span> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm text-white hover:text-gray-200 transition px-5 py-1.5 rounded-full hover:bg-white/10">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="bg-white text-[#1e3a5f] text-sm font-bold px-4 py-2 rounded-full hover:bg-gray-100 transition">
                    Get Started
                </a>
            @endauth
        </div>
    </div>
</nav>
