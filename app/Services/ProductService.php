<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function store(array $data, array $images, int $primaryImage): Product
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

            if (!empty($images)) {
                // simpan semua foto
                foreach ($images as $index => $image) {
                    $path = $image->store('products', 'public');
                    // Simpan di storage/app/public/products/
                    // Akses via: asset('storage/products/namafile.jpg')

                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === $primaryImage,
                        'sort_order' => $index
                    ]);
                }
            }

            return $product;
        });
        return $product;
    }

    public function update(Product $product, array $data, string $primaryImage,  array $removedImages, array $images = []): Product
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
                } elseif (str_starts_with($primaryImage, 'new-')) {
                    $newIndex = (int) str_replace('new-', '', $primaryImage);
                    $newImages = $product->images()->orderBy('sort_order', 'desc')->take(count($images))->get()->reverse()->values();
                    if (isset($newImages[$newIndex])) {
                        $newImages[$newIndex]->update(['is_primary' => true]);
                    }
                }
            }
            return $product;
        });
        return $product;
    }

    public function destroy(Product $product): void
    {
        DB::transaction(function () use ($product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            $product->delete();
        });
    }

    public function toggleActive(Product $product): void
    {
        $product->update([
            // ubah nilai boolean true jadi false false jadi true 
            'is_active' => !$product->is_active
        ]);
    }

    public function getAll(array $filters = []): LengthAwarePaginator
    {
        return Product::with(['category', 'primaryImage'])
            ->active()
            ->search($filters['search'] ?? null)
            ->filterByCategory($filters['category'] ?? null)
            ->sortBy($filters['sort'] ?? null)
            ->paginate(12);
    }

    public function getAllForAdmin(): LengthAwarePaginator
    {
        return Product::with([
            'category',
            'primaryImage'
        ])->latest()->paginate(10);
    }
}
