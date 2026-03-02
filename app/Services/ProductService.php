<?php

namespace App\Http\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data) {
        return Product::create($data);
    }
}
