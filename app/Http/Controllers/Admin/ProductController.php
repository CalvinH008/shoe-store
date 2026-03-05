<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private ProductService $productService) {}
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
            $data = $request->only('category_id', 'name', 'slug', 'price', 'stock', 'description', 'is_active');
            $images = $request->file('images');
            $primaryImage = (int) $request->primary_image;

            $product = $this->productService->store($data, $images, $primaryImage);
            // return json kalau berhasil
            return response()->json([
                'status' => true,
                'message' => 'Product Created Successfully',
                // load() untuk sertakan data image sekalian di response     
                'data' => $product->load('images')
            ], 201); // 201 http code "Created"
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Product Addition Failed',
                // getMessage() untuk menjelaskan apa errornya
                'error' => $e->getMessage()
            ], 500); // http code 500 yaitu status error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->only('category_id', 'name', 'slug', 'price', 'stock', 'description', 'is_active');
            $images = $request->file('images') ?? [];
            $primaryImage = $request->primary_image;
            $removedImages = $request->input('removed_images', []);

            $product = $this->productService->update($product, $data, $primaryImage, $removedImages, $images);

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
            $this->productService->destroy($product);

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
            $this->productService->toggleActive($product);

            return response()->json([
                'status' => true,
                'message' => !$product->is_active ? 'Product activated successfully!' : 'Product deactivated successfully!',
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
