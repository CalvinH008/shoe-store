{{-- NAVBAR --}}
    <nav x-data="{ open: false }" class="bg-[#1e3a5f] text-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <a href="/" class="text-xl font-bold tracking-wide hover:opacity-80 transition">
                👟 Shoe Store
            </a>

            {{-- Cart Button --}}
            <div class="relative">
                <button type="button" @click="open = !open"
                    class="flex items-center gap-2 bg-white text-[#1e3a5f] font-semibold px-4 py-2 rounded-full hover:bg-slate-100 transition">
                    🛒 Cart
                    <span id="cart-count" class="bg-[#1e3a5f] text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        0
                    </span>
                </button>

                {{-- Cart Dropdown --}}
                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-80 bg-white text-slate-800 rounded-xl shadow-xl z-50 p-4">
                    <p class="font-semibold text-slate-600 mb-3 border-b pb-2">Cart Preview</p>
                    <div id="cart-preview" class="space-y-2 text-sm">
                        <p class="text-slate-400">Items will appear here</p>
                    </div>
                </div>
            </div>

        </div>
    </nav>