@extends('admin.layouts.app')

@section('content')
    <div x-data="productManager()" x-init="fetchProducts()" class="p-6">

        {{-- NOTIFICATION --}}
        <div x-show="message" :class="isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'"
            class="px-4 py-2 rounded-lg mb-4 text-sm font-medium" x-text="message">
        </div>

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>

            <a href="{{ route('admin.products.create') }}"
                class="bg-[#1e3a5f] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#162d4a] transition">
                + Add Product
            </a>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    <template x-for="product in products" :key="product.id">
                        <tr class="hover:bg-gray-50 transition">

                            {{-- IMAGE --}}
                            <td class="px-4 py-3">
                                <div class="w-20 h-20 rounded-lg overflow-hidden border bg-gray-100">
                                    <template x-if="product.primary_image">
                                        <img :src="product.primary_image.url"
                                            class="w-full h-full object-cover hover:scale-110 transition duration-200">
                                    </template>
                                    <template x-if="!product.primary_image">
                                        <div class="flex items-center justify-center w-full h-full text-gray-400 text-xs">
                                            No Image
                                        </div>
                                    </template>
                                </div>
                            </td>

                            {{-- NAME --}}
                            <td class="px-4 py-3 font-semibold text-gray-800" x-text="product.name"></td>

                            {{-- CATEGORY --}}
                            <td class="px-4 py-3 text-gray-600" x-text="product.category.name"></td>

                            {{-- PRICE --}}
                            <td class="px-4 py-3 font-medium text-gray-800"
                                x-text="'Rp ' + product.price.toLocaleString('id-ID')"></td>

                            {{-- STOCK --}}
                            <td class="px-4 py-3 text-gray-600" x-text="product.stock"></td>

                            {{-- STATUS --}}
                            <td class="px-4 py-3">
                                <button
                                    @click="toggleActive(product.id, product.is_active); product.is_active = !product.is_active"
                                    :class="product.is_active ?
                                        'bg-green-100 text-green-700' :
                                        'bg-gray-100 text-gray-600'"
                                    class="px-3 py-1 rounded-full text-xs font-semibold transition">
                                    <span x-text="product.is_active ? 'Active' : 'Inactive'"></span>
                                </button>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-4 py-3 text-right space-x-2">
                                <a :href="'/admin/products/' + product.id + '/edit'"
                                    class="text-blue-600 hover:underline text-sm">
                                    Edit
                                </a>

                                <button @click="deleteProduct(product.id, $el.closest('tr'))"
                                    class="text-red-500 hover:underline text-sm">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    </template>

                    {{-- EMPTY STATE --}}
                    <template x-if="products.length === 0">
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">
                                No Products Available
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-8">
            <div class="flex items-center gap-2">

                {{-- PREVIOUS --}}
                <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1"
                    class="w-10 h-10 flex items-center justify-center rounded-lg border text-gray-500 
                   disabled:opacity-40 hover:bg-gray-100 transition">
                    «
                </button>

                {{-- PAGE NUMBERS --}}
                <template x-for="page in lastPage" :key="page">
                    <button @click="changePage(page)"
                        :class="page === currentPage ?
                            'bg-[#1e3a5f] text-white border-[#1e3a5f]' :
                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'"
                        class="w-10 h-10 rounded-lg border flex items-center justify-center text-sm font-medium transition">
                        <span x-text="page"></span>
                    </button>
                </template>

                {{-- NEXT --}}
                <button @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage"
                    class="w-10 h-10 flex items-center justify-center rounded-lg border text-gray-500 
                   disabled:opacity-40 hover:bg-gray-100 transition">
                    »
                </button>

            </div>
        </div>

    </div>
@endsection
