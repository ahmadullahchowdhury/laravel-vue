<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        
        $products = Product::with('category')
            ->latest()
            ->paginate(10);
            
        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->noContent();
    }
}