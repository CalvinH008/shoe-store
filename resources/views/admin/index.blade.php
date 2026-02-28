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
                        <td> {{$product->stock}} </td>
                    </tr>
                @empty
                @endforelse

    </div>
@endsection
