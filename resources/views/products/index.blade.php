@extends('layouts.app')
@section('title', 'Products')
@section('content')

    {{-- TOP BAR --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Our Products</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-slate-500 hover:text-red-500 transition">
                Logout
            </button>
        </form>
    </div>

    {{-- FILTER FORM --}}
    <form method="GET" action="{{ route('products.index') }}"
        class="flex flex-wrap gap-3 mb-8 bg-white p-4 rounded-xl shadow-sm">
        <input type="text" name="search" placeholder="Find Product..." value="{{ request('search') }}"
            class="border border-slate-200 rounded-lg px-3 py-2 text-sm flex-1 min-w-[160px] focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]">
        <select name="category"
            class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]">
            <option value="">All Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select name="sort"
            class="border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]">
            <option value="">Sort By</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                Lowest Price
            </option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                Highest Price
            </option>
        </select>
        <button type="submit"
            class="bg-[#1e3a5f] text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-[#162d4a] transition">
            Filter
        </button>
    </form>

    {{-- PRODUCT GRID --}}
    <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4 flex flex-col gap-3">
                {{-- Product Image --}}
                <div class="bg-slate-100 rounded-lg h-40 flex items-center justify-center overflow-hidden">
                    @if ($product->primaryImage)
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}"
                            class="h-full w-full object-cover rounded-lg">
                    @else
                        <span class="text-4xl">👟</span>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="flex-1">
                    <h3 class="font-semibold text-slate-800 text-sm leading-tight line-clamp-2">
                        {{ $product->name }}
                    </h3>
                    <p class="text-[#1e3a5f] font-bold mt-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">Stock: {{ $product->stock }}</p>
                </div>

                {{-- Add to Cart Button --}}
                <button type="button" x-data="{ loading: false }"
                    @click="loading = true; addToCart({{ $product->id }}, 1).finally(() => loading = false)"
                    :disabled="loading"
                    class="w-full bg-[#1e3a5f] text-white text-sm font-semibold py-2 rounded-lg hover:bg-[#162d4a] transition disabled:opacity-50">
                    <span x-show="!loading">Add To Cart</span>
                    <span x-show="loading">Adding...</span>
                </button>
            </div>
        @empty
            <div class="col-span-4 text-center py-16 text-slate-400">
                <p class="text-4xl mb-3">🔍</p>
                <p>Products Not Found</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $products->withQueryString()->links() }}
    </div>

@endsection
