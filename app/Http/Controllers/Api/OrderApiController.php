<?php
namespace App\Http\Controllers\Api;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Addresses;
use Illuminate\Support\Str;
use Validator;

class OrderApiController extends Controller

{
   public function store(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'prod_id' => 'required|exists:products,id',
        'qty' => 'required|integer|min:1',
        'address_id' => 'required|exists:addresses,id',
        'payment_status' => 'required|string|in:paid,unpaid',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Get the authenticated user
    $user = $request->user();

    // Find the product and calculate the total price
    $product = Product::find($request->prod_id);
    $total_price = $product->price * $request->qty;

    // Check if the product has enough stock
    if ($product->quantity < $request->qty) {
        return response()->json(['message' => 'Insufficient stock available'], 400);
    }

    // Generate a unique order ID
    $order_id = 'ORD' . strtoupper(Str::random(6));

    // Create the order
    $order = Order::create([
        'user_id' => $user->id,             // Use the authenticated user's ID
        'prod_id' => $request->prod_id,
        'qty' => $request->qty,
        'total_price' => $total_price,     // Save total price
        'order_status' => 'pending',      // Default status
        'track_order' => 0,               // Initially not tracked
        'order_id' => $order_id,
        'payment_status' => $request->payment_status,
        'is_rated' => 0,                  // Not rated by default
    ]);

    // Decrement product quantity
    $product->decrement('quantity', $request->qty);

    // Respond with the created order details
    return response()->json([
        'message' => 'Order created successfully!',
        'order' => $order,
    ], 201);
}

    // Get all orders for a user
    public function index(Request $request)
    {
        $userId = $request->user()->id; // Assuming user is authenticated

        $orders = Order::where('user_id', $userId)->get();

        return response()->json($orders);
    }

    // Track an order by ID
    public function track($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['order' => $order]);
    }
}
