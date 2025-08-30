<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'attributes', 'ratings'])
            ->with(['images' => function ($q) {
                $q->orderBy('id', 'asc')->limit(1); // fetch only the first image
            }])
            ->when($request->has('product_name'), function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->input('product_name') . '%');
            })
            ->get(); // you can paginate if needed

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

}
