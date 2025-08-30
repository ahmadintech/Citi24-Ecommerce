<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\product;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $review = Rating::where('user_id', auth()->user()->id)->orderBy("created_at", "desc")->paginate(10);

        $pageTitle = auth()->user()->firstname . " Reviews";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";

        return view('user.my_review', compact('review', 'pageTitle', 'pageDescription'));
    }

    public function rateProduct(Request $request, $order_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $order = Order::findOrFail($order_id);

        // Assuming you rate only one product per order (the first item, or pass item_id separately)
        $orderItem = $order->items()->firstOrFail();
        $product   = $orderItem->product;

        $currentRating   = $product->rating ?? 0;
        $numberOfRatings = $product->ratings()->count();

        // Calculate the new average rating
        $newRating = ($currentRating * $numberOfRatings + $request->input('rating')) / ($numberOfRatings + 1);

        // Update product rating
        $product->update([
            'rating' => $newRating,
        ]);

        // Save the rating record
        Rating::create([
            'product_id' => $product->id,
            'user_id'    => auth()->id(),
            'rating'     => $request->input('rating'),
            'comment'    => $request->input('comment') ?? "",
        ]);

        $order->update([
            'is_rated' => 1,
        ]);

        return redirect()->back()->with('success', 'Product rated successfully.');
    }
}
