<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $query = $request->input('search');
        $categoryId = $request->input('category');


        $products = Product::with('category')
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', '%' . $query . '%');  // Added return
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                return $q->where('category_id', $categoryId);  // Added return
            })
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

    public function search(Request $request)
    {
        $query = $request->input('search'); // Get the 'search' query parameter

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required.',
            ], 400);
        }

        // Search in the 'name' or 'description' fields of the Product model

        $products = Product::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($products);

        return ProductResource::collection($products);
    }
}
