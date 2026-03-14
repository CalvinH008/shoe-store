<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request): JsonResponse{
        $filters = $request->only(['search', 'category', 'sort']);
        $products = $this->productService->getAll($filters);

        return response()->json([
            'status' => true,
            'message' => 'Product Retrieved Successfully',
            'data' => $products
        ]);
    }

    public function show(Product $product): JsonResponse{
        $product->load(['category', 'images']);

        return response()->json([
            'status' => 'true',
            'message' => 'Product Retrieved Successfully',
            'data' => $product
        ]);
    }
}
