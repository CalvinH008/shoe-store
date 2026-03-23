@extends('admin.layouts.app')

@section('content')
    <h2>Edit Product</h2>

    <div x-data="productEdit()">

        <form @submit.prevent="submitForm()" enctype="multipart/form-data">

            <div>
                <label>Category</label>
                <select x-model="form.category_id">
                    <option value="">Choose Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Product Name</label>
                <input type="text" x-model="form.name" @input="generateSlug()">
            </div>

            <div>
                <label>Slug</label>
                <input type="text" x-model="form.slug">
            </div>

            <div>
                <label>Price</label>
                <input type="number" x-model="form.price" min="0">
            </div>

            <div>
                <label>Stock</label>
                <input type="number" x-model="form.stock" min="0">
            </div>

            <div>
                <label>Description</label>
                <textarea x-model="form.description"></textarea>
            </div>

            {{-- Gambar existing --}}
            <div>
                <label>Current Images</label>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                    <template x-for="(image, index) in existingImages" :key="image.id">
                        <div style="position:relative;">
                            <img :src="image.url" style="width:100px; height:100px; object-fit:cover;">
                            <div>
                                <input type="radio" :value="'existing-' + image.id" x-model="form.primary_image"
                                    :id="'existing-' + image.id">
                                <label :for="'existing-' + image.id">Primary</label>
                            </div>
                            <button type="button" @click="removeExistingImage(image.id)" style="color:red;">Remove</button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Upload gambar baru --}}
            <div>
                <label>Add New Images</label>
                <input type="file" multiple accept="image/*" @change="handleImages($event)">
            </div>

            {{-- Preview gambar baru --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                <template x-for="(preview, index) in previews" :key="index">
                    <div style="position:relative;">
                        <img :src="preview" style="width:100px; height:100px; object-fit:cover;">
                        <div>
                            <input type="radio" :value="'new-' + index" x-model="form.primary_image"
                                :id="'new-' + index">
                            <label :for="'new-' + index">Primary</label>
                        </div>
                    </div>
                </template>
            </div>

            <div style="margin-top:10px;">
                <label>
                    <input type="checkbox" x-model="form.is_active"> Produk Aktif
                </label>
            </div>

            <button type="submit" :disabled="loading">
                <span x-text="loading ? 'Saving...' : 'Update Product'"></span>
            </button>

        </form>

        <div x-show="message" x-text="message" style="margin-top:10px;"></div>

    </div>
@endsection
@push('scripts')
    <script>
        function productEdit() {
            return {
                loading: false,
                message: "",
                images: [],
                previews: [],
                existingImages: @json($product->images ?? []),
                removedImages: [],

                form: {
                    category_id: "{{ $product->category_id }}",
                    name: "{{ $product->name }}",
                    slug: "{{ $product->slug }}",
                    price: "{{ $product->price }}",
                    stock: "{{ $product->stock }}",
                    description: "{!! addslashes($product->description) !!}",
                    is_active: {{ $product->is_active ? 'true' : 'false' }},
                    primary_image: "{{ optional($product->primaryImage)->id ? 'existing-' . $product->primaryImage->id : '' }}",
                },

                generateSlug() {
                    this.form.slug = this.form.name
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, "")
                        .replace(/\s+/g, "-")
                        .replace(/-+/g, "-");
                },

                handleImages(event) {
                    const files = Array.from(event.target.files);
                    this.images = files;
                    this.previews = files.map((file) => URL.createObjectURL(file));
                    // auto-select gambar baru pertama sebagai primary kalau belum ada primary
                    if (!this.form.primary_image) {
                        this.form.primary_image = 'new-0';
                    }
                },

                removeExistingImage(imageId) {
                    this.removedImages.push(imageId);
                    this.existingImages = this.existingImages.filter(img => img.id !== imageId);
                },

                async submitForm() {
                    this.loading = true;
                    const formData = new FormData();
                    formData.append("_method", "PUT");
                    formData.append("category_id", this.form.category_id);
                    formData.append("name", this.form.name);
                    formData.append("slug", this.form.slug);
                    formData.append("price", this.form.price);
                    formData.append("stock", this.form.stock);
                    formData.append("description", this.form.description);
                    formData.append("is_active", this.form.is_active ? 1 : 0);

                    if (this.form.primary_image) {
                        formData.append("primary_image", this.form.primary_image);
                    }

                    this.images.forEach((image) => {
                        formData.append("images[]", image);
                    });

                    this.removedImages.forEach((id) => {
                        formData.append("removed_images[]", id);
                    });

                    try {
                        const response = await axios.post("/admin/products/{{ $product->id }}", formData, {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            },
                        });
                        if (response.data.status) {
                            this.message = response.data.message;
                            setTimeout(() => {
                                window.location.href = "/admin/products";
                            }, 1000);
                        }
                    } catch (error) {
                        if (error.response?.status === 422) {
                            const errors = error.response.data.errors;
                            this.message = Object.values(errors).flat().join(", ");
                        } else {
                            this.message = error.response?.data?.message ?? "Something Went Wrong!";
                        }
                    }
                    this.loading = false;
                },
            };
        }
    </script>
@endpush
