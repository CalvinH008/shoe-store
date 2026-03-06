<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function store(array $data, array $images, int $primaryImage)
    {
        // DB::transaction kalau saat transaksi ada yang gagal, batalkan semua rollback
        $product = DB::transaction(function () use ($data, $images, $primaryImage) {
            $product = Product::create([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => $data['slug'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'description' => $data['description'],
                'is_active' => $data['is_active'] ?? true
            ]);

            // simpan semua foto
            foreach ($images as $index => $image) {
                $path = $image->store('products', 'public');
                // Simpan di storage/app/public/products/
                // Akses via: asset('storage/products/namafile.jpg')

                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === $primaryImage,
                ]);
            }

            return $product;
        });
        return $product;
    }

    public function update(Product $product, array $data, string $primaryImage,  array $removedImages, array $images = [])
    {
        $product = DB::transaction(function () use ($data, $images, $primaryImage, $product, $removedImages) {
            $product->update([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => $data['slug'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'description' => $data['description'],
                'is_active' => $data['is_active'] ?? true
            ]);

            if (!empty($removedImages)) {
                $imagesToRemove = $product->images()->whereIn('id', $removedImages)->get();
                foreach ($imagesToRemove as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
            if (!empty($images)) {
                foreach ($images as $index => $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => false,
                        'sort_order' => $product->images()->count() + $index
                    ]);
                }
            }

            if (!empty($primaryImage)) {
                $product->images()->update(['is_primary' => false]);
                if (str_starts_with($primaryImage, 'existing-')) {
                    $imageId = str_replace('existing-', '', $primaryImage);
                    $product->images()->where('id', $imageId)->update(['is_primary' => true]);
                }
            }
            return $product;
        });
        return $product;
    }

    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $product->delete();
        });
    }

    public function toggleActive(Product $product)
    {
        $product->update([
            // ubah nilai boolean true jadi false false jadi true 
            'is_active' => !$product->is_active
        ]);
    }

    public function getAll(array $filters = []) {
        $query = Product::with(['category', 'primaryImage'])->where('is_active', true);

        if(!empty($filters['search'])){
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        };

        if(!empty($filters['category'])){
            $query->where('category' . $filters['search']);
        }

        if(!empty($filters['sort'])){
            match($filters['sort']){
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default => $query->latest()
            };
        }else{
            $query->latest();
        }

        return $query->paginate(12);
    }
}
