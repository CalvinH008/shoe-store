@extends('layouts.app')
@section('title', 'Products')
@section('content')

    <div class="max-w-7xl mx-auto px-4 pt-24 pb-10">

        {{-- TOP BAR --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Our Products</h1>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            {{-- SIDEBAR --}}
            <div class="lg:col-span-1">
                <form method="GET" action="{{ route('products.index') }}"
                    class="bg-white p-5 rounded-2xl shadow-sm space-y-6 sticky top-24">

                    {{-- SEARCH --}}
                    <div>
                        <p class="font-semibold text-sm mb-2">Search</p>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Find product..."
                            class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#1e3a5f]">
                    </div>

                    {{-- CATEGORY --}}
                    <div>
                        <p class="font-semibold text-sm mb-3">Category</p>
                        <div class="space-y-2 text-sm">

                            <label class="flex items-center gap-2">
                                <input type="radio" name="category" value=""
                                    {{ request('category') == '' ? 'checked' : '' }}>
                                All
                            </label>

                            @foreach ($categories as $category)
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="category" value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'checked' : '' }}>
                                    {{ $category->name }}
                                </label>
                            @endforeach

                        </div>
                    </div>

                    {{-- SORT --}}
                    <div>
                        <p class="font-semibold text-sm mb-3">Sort By</p>
                        <div class="space-y-2 text-sm">

                            <label class="flex items-center gap-2">
                                <input type="radio" name="sort" value=""
                                    {{ request('sort') == '' ? 'checked' : '' }}>
                                Default
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="sort" value="price_asc"
                                    {{ request('sort') == 'price_asc' ? 'checked' : '' }}>
                                Lowest Price
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="sort" value="price_desc"
                                    {{ request('sort') == 'price_desc' ? 'checked' : '' }}>
                                Highest Price
                            </label>

                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                        class="w-full bg-[#1e3a5f] text-white py-2 rounded-lg text-sm font-semibold hover:bg-[#162d4a] transition">
                        Sort
                    </button>

                </form>
            </div>

            {{-- PRODUCT GRID --}}
            <div class="lg:col-span-3">

                <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">

                    @forelse ($products as $product)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4 flex flex-col gap-3">

                            {{-- IMAGE --}}
                            <div class="bg-slate-100 rounded-lg h-40 flex items-center justify-center overflow-hidden">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <span class="text-4xl">👟</span>
                                @endif
                            </div>

                            {{-- INFO --}}
                            <div class="flex-1">
                                <h3 class="font-semibold text-sm line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[#1e3a5f] font-bold mt-1">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- BUTTON --}}
                            <button type="button" x-data="{ loading: false }"
                                @click="loading = true; addToCart({{ $product->id }}, 1).finally(() => loading = false)"
                                :disabled="loading"
                                class="w-full bg-[#1e3a5f] text-white text-sm py-2 rounded-lg hover:bg-[#162d4a] transition">
                                <span x-show="!loading">Add To Cart</span>
                                <span x-show="loading">Adding...</span>
                            </button>

                        </div>
                    @empty
                        <div class="col-span-3 text-center py-16 text-slate-400">
                            <p class="text-4xl mb-3">🔍</p>
                            <p>Products Not Found</p>
                        </div>
                    @endforelse

                </div>

                {{-- PAGINATION --}}
                <div class="mt-8">
                    {{ $products->withQueryString()->links() }}
                </div>

            </div>

        </div>

    </div>

@endsection
