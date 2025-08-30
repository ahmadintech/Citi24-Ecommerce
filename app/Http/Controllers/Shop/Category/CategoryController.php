<?php

namespace App\Http\Controllers\Shop\Category;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($name)
    {
        $category_id = category::where('name', $name)->value('id');
        $category = category::findOrFail($category_id);
        $categories = category::all();

        $products = product::where('category_id', $category_id)->get();
        $featuredProducts = product::where('is_featured', 'Yes')->take(4)->get();

        $pageTitle = $name. " Category";
        $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
         farm produce to individuals and businesses in our community.";
        return view('shop.category.index', compact('category', 'products', 'categories', 'featuredProducts', 'pageTitle', 'pageDescription'));
    }
}
