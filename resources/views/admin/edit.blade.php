@extends('layouts.admim')

@section('content')
    <div x-data="productEdit({{ $product->id }}, {{ $product->toJson() }}, {{ $product->image->toJson() }})">
        @if ($errors->any())
            <div style="color:red">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form @submit.prevent="submitForm()" enctype="multipart/form-data">
            <div>
                <label for="">Category</label>
                <select x-model="form.category_id">
                    <option value="">Choose Category</option>
                    @foreach ($categories as $category)
                        <option value=" {{ $category->id }} "> {{ $category->name }} </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="">Product Name</label>
                <input type="text" x-model="form.name" @input=" generateSlug() ">
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
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <template x-for="(image, index) in existingImages" :key="image.id">
                        <div>
                            <img :src="'/storage/' + image.image_path" style="width:100px; height:100px; object-fit:cover;">
                            <button type="button" @click="removeExistingImage(image.id)">Hapus</button>
                            <div>
                                <input type="radio" :value="'existing-' + image.id" x-model="form.primary_image">
                                <label>Primary</label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <label for="">Post New Image</label>
                <input type="file" multiple accept="image/*" @change="handleImages($event)">
            </div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                <template x-for="(preview, index) in previews" :key="index">
                    <div>
                        <img :src="preview" style="width:100px; height:100px; object-fit:cover;">
                        <div>
                            <input type="radio" :value="'new-' + index" x-model="form.primary_image">
                            <label>Primary</label>
                        </div>
                    </div>
                </template>
            </div>

            <div>
                <label>
                    <input type="checkbox" x-model="form.is_active">Product Is Active
                </label>
            </div>

            <button type="submit" :disabled="loading">
                <span x-text="loading ? 'Saving Data...' : 'Update Product'"></span>
            </button>
        </form>
        <div x-show="message" x-text="message" style="margin-top:10px;"></div>
    </div>
@endsection
