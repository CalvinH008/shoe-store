@extends('admin.layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto">

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            {{-- TITLE --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-800">Add Product</h2>
                <p class="text-sm text-slate-400">Fill product information</p>
            </div>

            <div x-data="productCreate">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        @foreach ($errors as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form @submit.prevent="submitForm()" enctype="multipart/form-data" class="space-y-5">

                    {{-- GRID --}}
                    <div class="grid md:grid-cols-2 gap-4">

                        {{-- CATEGORY --}}
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

                        {{-- NAME --}}
                        <div>
                            <label class="text-sm text-slate-500">Product Name</label>
                            <input type="text" x-model="form.name" @input="generateSlug()"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                        {{-- SLUG --}}
                        <div>
                            <label class="text-sm text-slate-500">Slug</label>
                            <input type="text" x-model="form.slug"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 bg-slate-50">
                        </div>

                        {{-- PRICE --}}
                        <div>
                            <label class="text-sm text-slate-500">Price</label>
                            <input type="text" x-model="form.price" min="0"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                        {{-- STOCK --}}
                        <div>
                            <label class="text-sm text-slate-500">Stock</label>
                            <input type="text" x-model="form.stock" min="0"
                                class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2">
                        </div>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div>
                        <label class="text-sm text-slate-500">Description</label>
                        <textarea x-model="form.description" class="mt-1 w-full border border-slate-300 rounded-lg px-3 py-2 min-h-[100px]"></textarea>
                    </div>

                    {{-- IMAGE --}}
                    <div>
                        <label class="text-sm text-slate-500">Product Images</label>

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
                            <div class="relative group">

                                <img :src="preview" class="w-24 h-24 object-cover rounded-lg border shadow-sm">

                                {{-- PRIMARY --}}
                                <div class="absolute bottom-1 left-1">
                                    <input type="radio" :value="index" x-model="form.primary_image"
                                        :id="'primary-' + index" class="hidden">

                                    <label :for="'primary-' + index"
                                        class="text-[10px] px-2 py-0.5 rounded text-white cursor-pointer"
                                        :class="form.primary_image === index ?
                                            'bg-[#1e3a5f]' :
                                            'bg-black/60 group-hover:bg-black/80'">
                                        Primary
                                    </label>
                                </div>

                            </div>
                        </template>
                    </div>

                    {{-- FOOTER --}}
                    <div class="flex justify-between items-center pt-4 border-t">

                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" x-model="form.is_active">
                            Produk Aktif
                        </label>

                        <button type="submit"
                            class="bg-[#1e3a5f] text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-[#162c47]"
                            :disabled="loading">
                            <span x-text="loading ? 'Menyimpan...' : 'Simpan Produk'"></span>
                        </button>

                    </div>

                    {{-- NOTIF --}}
                    <p x-show="message" x-text="message" class="text-sm mt-2 text-green-600">
                    </p>

                </form>
            </div>

        </div>

    </div>

@endsection
