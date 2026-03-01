@extends('layouts.admin')
@section('content')
    <h2>Add Product</h2>

    <div x-data="productCreate">
        @if ($errors->any())
            <div style="color: red;">
                @foreach ($errors as $error)
                    <p> {{ $error }} </p>
                @endforeach
            </div>
        @endif

        <form @submit.prevent="submitForm()" enctype="multipart/form-data">
            <div>
                <label for="">Category</label>
                <select x-model="form.category_id">
                    <option value="">Choose Catogory</option>
                    @foreach ($categories as $category)
                        <option value=" {{ $category->id }} "> {{ $category->name }} </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Product Name</label>
                <input type="text" x-model="form.nama" @input=" generateSlug() ">
            </div>

            <div>
                <label for="">Slug</label>
                <input type="text" x-model="form.slug">
            </div>

            <div>
                <label for="">Price</label>
                <input type="text" x-model="form.price" min="0">
            </div>

            <div>
                <label for="">Stock</label>
                <input type="text" x-model="form.stock" min="0">
            </div>

            <div>
                <label for="">Description</label>
                <textarea x-model="form.description"></textarea>
            </div>

            <div>
                <label for="">Product Image</label>
                <input type="file" multiple accept="image/*" @change="handleImages($event)">
            </div>

            {{-- Preview foto yang dipilih --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                <template x-for="(preview, index) in previews" :key="index">
                    <div style="position:relative;">
                        <img :src="preview" style="width:100px; height:100px; object-fit:cover;">

                        {{-- Radio pilih foto primary --}}
                        <div>
                            <input type="radio" :value="index" x-model="form.primary_image"
                                :id="'primary-' + index">
                            <label :for="'primary-' + index">Primary</label>
                        </div>
                    </div>
                </template>
            </div>

            <div style="margin-top:10px;">
                <label>
                    {{-- 
                    x-model pada checkbox → otomatis handle true/false
                --}}
                    <input type="checkbox" x-model="form.is_active"> Produk Aktif
                </label>
            </div>

            <button type="submit" :disabled="loading">
                <span x-text="loading ? 'Menyimpan...' : 'Simpan Produk'"></span>
            </button>
        </form>

        {{-- nofif --}}
        <div x-show="message" x-text="message" style="margin-top:10px;"></div>
    </div>
@endsection
