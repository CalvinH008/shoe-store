<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'primaryImage'])->latest()->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Data produk berhasil diambil',
            'data' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            // DB::transaction kalau saat transaksi ada yang gagal, batalkan semua rollback
            $product = DB::transaction(function () use ($request) {
                $product = Product::create([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'description' => $request->description,
                    'is_active' => $request->boolean('is_active', true)
                ]);


                // simpan semua foto
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    // Simpan di storage/app/public/products/
                    // Akses via: asset('storage/products/namafile.jpg')

                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === (int) $request->primary_image,
                    ]);
                }

                return $product;
            });

            // return json kalau berhasil
            return response()->json([
                'status' => true,
                'message' => 'Product Created Successfully',
                'data' => $product->load('images')
                // load() untuk sertakan data image sekalian di response     
            ], 201);

            // 201 http code "Created"
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product Addition Failed',
                'error' => $e->getMessage()
                // getMessage() untuk menjelaskan apa errornya
            ], 500);
            // http code 500 yaitu status error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $product->update([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'description' => $request->description,
                    'is_active' => $request->boolean('is_active', true)
                ]);

                if ($request->filled('removed_images')) {
                    $imagesToRemove = $product->images()->whereIn('id', $request->removed_images)->get();
                    foreach ($imagesToRemove as $image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $index => $image) {
                        $path = $image->store('products', 'public');
                        $product->images()->create([
                            'image_path' => $path,
                            'is_primary' => false,
                            'sort_order' => $product->images()->count() + $index
                        ]);
                    }
                }

                if ($request->filled('primary_image')) {
                    $product->images()->update(['is_primary' => false]);
                    $primaryValue = $request->primary_image;
                    if (str_starts_with($primaryValue, 'existing-')) {
                        $imageId = str_replace('existing-', '', $primaryValue);
                        $product->images()->where('id', $imageId)->update(['is_primary' => true]);
                    }
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully',
                'data' => $product->fresh()->load('images')
                // fresh() untuk mengambil data paling baru dari database setelah diupdate
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product Upload Failed',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $product->delete();
            });

            return response()->json([
                'status' => true,
                'message' => 'Product Deleted Successfully',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product Deletion Failed',
                'data' => null
            ], 500);
        }
    }

    public function toggleActive(Product $product)
    {
        try {
            $product->update([
                'is_active' => !$product->is_active
                // ubah nilai boolean true jadi false false jadi true 
            ]);

            return response()->json([
                'status' => true,
                'message' => $product->is_active ? 'Product activated successfully!' : 'Product deactivated successfully!',
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To update product status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
