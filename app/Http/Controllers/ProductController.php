<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['search', 'category' . 'sort']);
            $products = $this->productService->getAll($filters);
            $categories = Category::all();
            return view('products.index', compact('products', 'categories'));
        } catch (\Exception $error) {
            abort(500, 'Failed To Load Product Page');
        }
    }
}
