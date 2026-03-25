@extends('admin.layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            {{-- TITLE --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-800">Edit Product</h2>
                <p class="text-sm text-slate-400">Update product information</p>
            </div>

            <div x-data="productEdit()">

                <form @submit.prevent="submitForm()" enctype="multipart/form-data" class="space-y-5">

                    <div class="grid md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-slate-500">Category</label>
                            <select x-model="form.category_id"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">Product Name</label>
                            <input type="text" x-model="form.name" @input="generateSlug()"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">Slug</label>
                            <input type="text" x-model="form.slug"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 bg-slate-50">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">Price</label>
                            <input type="number" x-model="form.price" min="0"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                        <div>
                            <label class="text-sm text-slate-500">Stock</label>
                            <input type="number" x-model="form.stock" min="0"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                    </div>

                    <div>
                        <label class="text-sm text-slate-500">Description</label>
                        <textarea x-model="form.description" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 min-h-[100px]"></textarea>
                    </div>

                    {{-- EXISTING IMAGES (TIDAK DIUBAH LOGIC) --}}
                    <div>
                        <label class="text-sm text-slate-500">Current Images</label>

                        <div class="flex gap-3 flex-wrap mt-2">
                            <template x-for="(image, index) in existingImages" :key="image.id">
                                <div class="relative group">

                                    <img :src="image.url" class="w-24 h-24 object-cover rounded-lg border shadow-sm">

                                    <div class="mt-1">
                                        <input type="radio" :value="'existing-' + image.id" x-model="form.primary_image"
                                            :id="'existing-' + image.id">
                                        <label :for="'existing-' + image.id" class="text-xs">Primary</label>
                                    </div>

                                    <button type="button" @click="removeExistingImage(image.id)"
                                        class="text-red-500 text-xs mt-1">
                                        Remove
                                    </button>

                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- NEW IMAGE --}}
                    <div>
                        <label class="text-sm text-slate-500">Add New Images</label>

                        <div
                            class="mt-2 border-2 border-dashed border-slate-300 rounded-xl p-5 text-center cursor-pointer hover:bg-slate-50 transition">
                            <input type="file" multiple accept="image/*" @change="handleImages($event)" class="hidden"
                                x-ref="fileInput">

                            <p class="text-sm text-slate-400">Click to upload images</p>

                            <button type="button" @click="$refs.fileInput.click()"
                                class="mt-2 text-xs text-[#1e3a5f] font-medium">
                                Browse Files
                            </button>
                        </div>
                    </div>

                    {{-- PREVIEW --}}
                    <div class="flex gap-3 flex-wrap">
                        <template x-for="(preview, index) in previews" :key="index">
                            <div class="relative">

                                <img :src="preview" class="w-24 h-24 object-cover rounded-lg border shadow-sm">

                                <div class="mt-1">
                                    <input type="radio" :value="'new-' + index" x-model="form.primary_image"
                                        :id="'new-' + index">
                                    <label :for="'new-' + index" class="text-xs">Primary</label>
                                </div>

                            </div>
                        </template>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t">

                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" x-model="form.is_active">
                            Produk Aktif
                        </label>

                        <button type="submit"
                            class="bg-[#1e3a5f] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-[#162c47]"
                            :disabled="loading">
                            <span x-text="loading ? 'Saving...' : 'Update Product'"></span>
                        </button>

                    </div>

                    <div x-show="message" x-text="message" class="text-sm mt-2 text-green-600"></div>

                </form>

            </div>

        </div>

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
