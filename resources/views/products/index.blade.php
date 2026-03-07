@extends('layouts.app')

@section('title', 'Product')

@section('content')

<nav>
    <form action=" {{route('logout')}} " method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</nav>
    {{-- form filter dan sort --}}
    <form method="GET" action="{{ route('products.index') }}">

        <input type="text" name="search" placeholder="Find Product..." value="{{ request('search') }}">

        <select name="category">
            <option value="">All Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="sort">
            <option value="">Sorting</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                Lowest Price
            </option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                Highest Price
            </option>
        </select>

        <button type="submit">Filter</button>

    </form>

    {{-- product list --}}
    <div id="product-list">
        @forelse ($products as $product)
            <div class="product-card">
                <h3>{{ $product->name }}</h3>
                <p>{{ number_format($product->price, 0, ',', '.') }}</p>
                <p>Stock: {{ $product->stock }}</p>

                <button class="btn-add-cart" data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}">
                    Add To Cart
                </button>
            </div>
        @empty
            <p>Products Not Found</p>
        @endforelse

        {{-- pagination --}}
        {{ $products->withQueryString()->links() }}
    </div>

@endsection

@push('scripts')
    <script>
        // ambil semua tombol add to cart
        const buttons = document.querySelectorAll('.btn-add-cart');

        // berikan event listener tiap button
        buttons.forEach(function(button) {
            button.addEventListener('click', async function() {
                // ambil product id dari attribute data-product-id
                const productId = this.getAttribute('data-product-id');

                console.log('tombol diklik, productId:', productId);
                // disable tombol saat proses agar tidak terjadi double click
                this.disabled = true;
                this.textContent = 'Adding...';

                // panggil fungsi addToCart dari cart.js
                await addToCart(productId, 1);

                // enable kembali setelah selesai
                this.disabled = false;
                this.textContent = 'Add To Cart';
            });
        });
    </script>
@endpush
