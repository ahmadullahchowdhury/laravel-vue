<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
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

        return response()->json([
            'message' => 'Product created successfully',
            'success' => true
        ]);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }



    public function destroy(Product $product)
    {

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
            'success' => true
        ]);
    }

    public function edit(Product $product)
    {
        $product->load('category');
        $categories = Category::all();
        return response()->json([
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        try {

            $validatedData = $request->validated();
            $product->update($validatedData);
            
            return response()->json([
                'message' => 'Product updated successfully',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update product',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
