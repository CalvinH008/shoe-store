@extends('layouts.app')
@section('title', 'Products')
@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16">

        {{-- HERO HEADER --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-slate-900 mb-4">
                Our Premium Collection
            </h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Discover exceptional quality products crafted with precision and care
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-12">

            {{-- SIDEBAR --}}
            <div class="lg:col-span-1">
                <div
                    class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow border border-white/30 sticky top-28 lg:top-32">
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">

                        {{-- SEARCH --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Search Products</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Type to search..."
                                    class="w-full pl-10 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-[#1e3a5f]/20 focus:border-[#1e3a5f] transition-all">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        {{-- CATEGORY --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Categories</label>
                            <div class="space-y-2">
                                <label
                                    class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 cursor-pointer transition">
                                    <input type="radio" name="category" value=""
                                        class="w-4 h-4 text-[#1e3a5f] border-slate-300 focus:ring-[#1e3a5f] rounded-full"
                                        {{ request('category') == '' ? 'checked' : '' }}>
                                    <span class="text-sm text-slate-700">All Categories</span>
                                </label>

                                @foreach ($categories as $category)
                                    <label
                                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 cursor-pointer transition {{ request('category') == $category->id ? 'bg-[#1e3a5f]/5 border border-[#1e3a5f]/20' : '' }}">
                                        <input type="radio" name="category" value="{{ $category->id }}"
                                            class="w-4 h-4 text-[#1e3a5f] border-slate-300 focus:ring-[#1e3a5f] rounded-full"
                                            {{ request('category') == $category->id ? 'checked' : '' }}>
                                        <span class="text-sm text-slate-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- SORT --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-3">Sort By</label>
                            <div class="space-y-2">
                                @php
                                    $sortOptions = [
                                        '' => 'Recommended',
                                        'price_asc' => 'Price: Low to High',
                                        'price_desc' => 'Price: High to Low',
                                    ];
                                @endphp

                                @foreach ($sortOptions as $value => $label)
                                    <label
                                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 cursor-pointer transition {{ request('sort') == $value ? 'bg-[#1e3a5f]/5 border border-[#1e3a5f]/20' : '' }}">
                                        <input type="radio" name="sort" value="{{ $value }}"
                                            class="w-4 h-4 text-[#1e3a5f] border-slate-300 focus:ring-[#1e3a5f] rounded-full"
                                            {{ request('sort') == $value ? 'checked' : '' }}>
                                        <span class="text-sm text-slate-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('products.index') }}"
                                class="px-4 py-2 text-white text-sm rounded-lg font-semibold bg-red-600 hover:bg-red-700 transition-all">
                                Reset
                            </a>

                            <button type="submit"
                                class="px-4 py-2 bg-[#1e3a5f] text-white text-sm rounded-lg font-semibold hover:bg-[#162d4a] transition-all">
                                Sort
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="lg:col-span-3">
                <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">

                    @forelse ($products as $product)
                        <div
                            class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/30 overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">

                            {{-- IMAGE --}}
                            <div class="relative overflow-hidden h-64 p-4 bg-slate-50 rounded-t-xl">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                        class="h-full w-full object-cover rounded-xl transition-transform duration-500 group-hover:scale-105"
                                        alt="{{ $product->name }}">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-4xl text-slate-300">👟
                                    </div>
                                @endif
                            </div>

                            {{-- CONTENT --}}
                            <div class="p-6">
                                <h3 class="font-semibold text-lg text-slate-900 line-clamp-2 mb-2">{{ $product->name }}
                                </h3>
                                <p class="text-xl font-bold text-[#1e3a5f] mb-4">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</p>

                                <button type="button" x-data="{ loading: false }"
                                    @click="loading = true; addToCart({{ $product->id }}, 1).finally(() => loading = false)"
                                    :disabled="loading"
                                    class="w-full bg-[#1e3a5f] text-white py-2 rounded-xl font-semibold hover:bg-[#162d4a] transition-colors">
                                    <span x-show="!loading">Add to Cart</span>
                                    <span x-show="loading">Adding...</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-24 text-slate-400">
                            <div
                                class="w-24 h-24 bg-white/50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow">
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-500 mb-2">No Products Found</h3>
                            <p class="text-lg">Try adjusting your search or filter criteria</p>
                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                @if ($products->hasPages())
                    <div class="mt-12 flex justify-center">
                        <nav class="inline-flex items-center space-x-2" role="navigation" aria-label="Pagination">
                            {{-- Previous Page --}}
                            @if ($products->onFirstPage())
                                <span
                                    class="px-3 py-1 rounded-lg bg-slate-200 text-slate-500 cursor-not-allowed">&laquo;</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}"
                                    class="px-3 py-1 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-[#1e3a5f]/5 transition-colors">&laquo;</a>
                            @endif

                            {{-- Page Links --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span
                                        class="px-3 py-1 rounded-lg bg-[#1e3a5f] text-white font-semibold">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-[#1e3a5f]/5 transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}"
                                    class="px-3 py-1 rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-[#1e3a5f]/5 transition-colors">&raquo;</a>
                            @else
                                <span
                                    class="px-3 py-1 rounded-lg bg-slate-200 text-slate-500 cursor-not-allowed">&raquo;</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
