<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(private ProductService $productService) {}
    public function index()
    {
        return view('admin.index');
    }

    public function getData(): JsonResponse
    {
        $products = $this->productService->getAllForAdmin();

        return response()->json([
            'status'  => true,
            'message' => 'Products retrieved successfully.',
            'data'    => $products,
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
    public function store(StoreProductRequest $request): JsonResponse
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
                'data' => null
            ], 500); // http code 500 yaitu status error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            $data = $request->only('category_id', 'name', 'slug', 'price', 'stock', 'description', 'is_active');
            $images = $request->file('images') ?? [];
            $primaryImage = $request->primary_image ?? '';
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
                'message' => 'Product Update Failed',
                'data' => null
            ]);
        }
    }

    public function edit(Product $product){
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
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

    public function toggleActive(Product $product): JsonResponse
    {
        try {
            $this->productService->toggleActive($product);
            $fresh = $product->fresh();

            return response()->json([
                'status' => true,
                'message' => $fresh->is_active ? 'Product activated successfully!' : 'Product deactivated successfully!',
                'data' => $fresh
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To update product status',
                'data' => null
            ], 500);
        }
    }
}
