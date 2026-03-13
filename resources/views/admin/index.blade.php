@extends('layouts.admin')

@section('content')
    <div x-data="productManager()" x-init="fetchProducts()">

        <div x-show="message" x-text="message" style="padding:10px; margin-bottom:10px;"></div>

        <a href="{{ route('admin.products.create') }}">+ Add Product</a>

        <table border="1" cellpadding="8" style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="product in products" :key="product.id">
                    <tr :id="'product-row-' + product.id">
                        <td x-text="product.name"></td>
                        <td>
                            <template x-if="product.primary_image">
                                <img :src="product.primary_image.url" style="width:50px; height:50px; object-fit:cover;">
                            </template>
                            <template x-if="!product.primary_image">
                                <span>No Image</span>
                            </template>
                        </td>
                        <td x-text="product.category.name"></td>
                        <td x-text="'Rp ' + product.price.toLocaleString('id-ID')"></td>
                        <td x-text="product.stock"></td>
                        <td>
                            <button
                                @click="toggleActive(product.id, product.is_active); product.is_active = !product.is_active">
                                <span x-text="product.is_active ? 'Active' : 'Inactive'"></span>
                            </button>
                        </td>
                        <td>
                            <a :href="'/admin/products/' + product.id + '/edit'">Edit</a>
                            <button @click="deleteProduct(product.id, $el.closest('tr'))">Delete</button>
                        </td>
                    </tr>
                </template>
                <template x-if="products.length === 0">
                    <tr>
                        <td colspan="6">No Products Available</td>
                    </tr>
                </template>
            </tbody>
        </table>

        <div style="margin-top:10px;">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
            <span x-text="'Page ' + currentPage + ' of ' + lastPage"></span>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage">Next</button>
        </div>

    </div>
@endsection
