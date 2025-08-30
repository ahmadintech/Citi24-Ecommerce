<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryApiResource;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::where('status', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }



public function show($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    return response()->json(new CategoryApiResource($category), 200);
}

}