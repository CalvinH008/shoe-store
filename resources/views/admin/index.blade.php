@extends('layouts.admin')

@section('content')
    <div x-data="productManager()">
        <div x-show="message" x-text="message" :class="isError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'"
            style="padding:10px; margin-bottom:10px;">
        </div>
        <a href=" {{ route('admin.products.create') }} ">+ Add Product </a>
        <table border="1" cellpadding="8" style="width:100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td> {{ $product->name }} </td>
                        <td> {{ $product->category->name }} </td>
                        <td> {{ number_format($product->price, 0, ',', '.') }} </td>
                        <td> {{ $product->stock }} </td>
                        <td x-data=" { is_active: {{ $product->is_active ? 'true' : 'false' }} }">
                            <button
                                @click=" (async () => {
                            const result = await toggleActive({{ $product->id }}, is_active);
                            if (result !== undefined) is_active = result;
                        })
                        ()
">
                                <span x-text="is_active ? 'Aktif' : 'Nonaktif'"></span>
                            </button>
                        </td>
                        <td>
                            <a href=" {{ route('admin.products.edit', $product) }} ">Edit</a>
                            <button @click=" deleteProduct( {{ $product->id }}, $el.closest('tr') ) ">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Products Available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection
