@extends('layouts.app')

@section('content')
    <div id="product-list">
        @foreach ($products as $product)
            <div class="product-card">
                <h3> {{ $product->name }} </h3>
                <p> {{ number_format($product->price, 0, ',', '.') }} </p>
                <p>Stock: {{ $product->stock }} </p>

                <button class="btn-add-cart" data-product-id=" {{ $product->id }} "
                    data-product-name=" {{ $product->name }} ">Add To Cart</button>
            </div>
        @endforeach
    </div>
@endsection
@push('script')
    <script>
        {{-- ambil semua tombol add to cart --}}
        const buttons = document.querySelectorAll('.btn-add-cart');
        
        // berikan event listerner tiap button 
        button.forEach(function (button) => {
            button.addEventListener('click', async function(){
                // ambil product id dari attribut data-product-id
                const productId = this.getAttribute('data-product-id');

                // disable tombol saat proses agar ga terjadi double click
                this.disabled = true;
                this.textContent = 'Adding...';

                // panggil fungsi add to cart dari cart js
                await addToCart(productId, 1);

                // enable kembali setelah selesai
                this.disabled = false;
                this.textContent = 'Add To Cart';
            });
        });
    </script>
@endpush
