<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\Rating;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featuredProducts = product::where('is_featured', 'Yes')->take(4)->get();
        $products = product::take(8)->get();
        $category = category::all();
        // dd($category);

        $pageTitle = "Products";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";
        return view('shop.product', compact('products', 'category', 'featuredProducts', 'pageTitle', 'pageDescription'));
    }

    public function productDetails($product_name)
    {

       // Eager-load images, attributes, ratings
        $product = Product::with(['images', 'attributes', 'ratings.user'])
            ->where('product_name', $product_name)
            ->firstOrFail();

        // Related products
        $related = Product::with('firstImage')
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->take(4)
        ->get(['id','product_name','price','rating']);


        // Paginate latest 5 reviews
        $reviews = Rating::with('user')
            ->where('product_id', $product->id)
            ->orderBy('created_at','desc')
            ->paginate(5);

        // Like count + whether current user liked
        $likes     = $product->orders()->count(); // or your likes table
        $likedByMe = auth()->check() && $product->orders()
            ->where('user_id', auth()->id())->exists();



        $pageTitle = $product_name . " Products";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";

        return view('shop.product_details', compact(
            'product','related','reviews','likes','likedByMe', 'pageTitle', 'pageDescription'
        ));
    }


    public function search(Request $request)
    {
        try {

            $products = product::where('product_name', 'like', '%' . $request->product . '%')->get();
            $category = category::all();
            $featuredProducts = product::where('is_featured', 'Yes')->take(4)->get();

            $pageTitle = "Products with " . $request;
            $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
             farm produce to individuals and businesses in our community.";

            return view('shop.include.search_bar_menu', compact('products', 'category', 'featuredProducts', 'pageTitle', 'pageDescription'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
