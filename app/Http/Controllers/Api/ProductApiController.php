<?php

namespace App\Http\Controllers\Api;

use App\Models\product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductApiResource;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
//    public function index(Request $request)
// {
//     $products = product::with(['category', 'images', 'ratings'])
//         ->when($request->category_id, fn($query) => $query->where('category_id', $request->category_id))
//         ->when($request->search, fn($query) => $query->where('product_name', 'like', '%' . $request->search . '%'))
//         ->get();

//     return response()->json(ProductApiResource::collection($products), 200);
// }

public function index(Request $request)
    {
        // Retrieve products with their details
        $products = Product::select('id', 'product_name', 'price', 'product_discount', 'unit', 'product_weight', 'main_image', 'description', 'quantity', 'is_featured', 'rating', 'status')
                           ->where('status', 1) // You can filter active products if needed
                           ->get();

        // return response()->json($products);
        return response()->json(ProductApiResource::collection($products), 200);
    }

public function show($id)
{
    // $product = product::with(['category', 'images', 'ratings', 'attributes'])->find($id);
    $product = Product::select('id', 'product_name', 'price', 'product_discount', 'unit', 'product_weight', 'main_image', 'description', 'quantity', 'is_featured', 'rating', 'status')->find($id);
                            


    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json(new ProductApiResource($product), 200);
}



}
