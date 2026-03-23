<aside id="sidebar" :class="$store.sidebar.collapsed ? 'w-16' : 'w-64'"
    class="fixed top-0 left-0 h-screen bg-[#0f2744] text-white flex flex-col transition-all duration-300 z-40">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-4 py-5 border-b border-white/10">
        <a href="/" x-show="!$store.sidebar.collapsed" class="flex items-center gap-2">
            <span class="text-lg">👟</span>
            <span class="font-bold text-sm tracking-widest uppercase">
                Shoe Store
            </span>
        </a>

        <button @click="$store.sidebar.collapsed = !$store.sidebar.collapsed"
            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition ml-auto">
            <span x-text="$store.sidebar.collapsed ? '→' : '←'" class="text-sm"></span>
        </button>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 py-4 space-y-1 overflow-y-auto px-2">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition
            {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : '' }}">
            <span class="text-lg">📊</span>
            <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                Dashboard
            </span>
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition
            {{ request()->routeIs('admin.products*') ? 'bg-white/20' : '' }}">
            <span class="text-lg">👟</span>
            <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                Products
            </span>
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition
            {{ request()->routeIs('admin.orders*') ? 'bg-white/20' : '' }}">
            <span class="text-lg">📦</span>
            <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                Orders
            </span>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition
            {{ request()->routeIs('admin.users*') ? 'bg-white/20' : '' }}">
            <span class="text-lg">👥</span>
            <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                Users
            </span>
        </a>

    </nav>

    {{-- BOTTOM --}}
    <div class="border-t border-white/10 px-2 py-4 space-y-2">

        <a href="{{ route('products.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition">
            <span class="text-lg">🌐</span>
            <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                Website
            </span>
        </a>

        <div class="flex items-center gap-3 px-3 py-2.5">
            <span class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>

            <div x-show="!$store.sidebar.collapsed">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/50">Admin</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-500/20 text-red-400 transition">
                <span class="text-lg">🚪</span>
                <span x-show="!$store.sidebar.collapsed" class="text-sm font-medium">
                    Logout
                </span>
            </button>
        </form>

    </div>
</aside>
