<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;




class CartApiController extends Controller
{
    // Get all items in the cart
    public function getCartItems()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return response()->json(['cartItems' => $cartItems]);
    }

    // Add a product to the cart
    public function store(Request $request)
    {
        $request->validate([
            'prod_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'prod_id' => $request->prod_id,
            ],
            [
                'qty' => $request->qty,
            ]
        );

        return response()->json(['message' => 'Product added to cart!', 'cart' => $cart]);
    }

    public function show($id)

    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json([
                'message' => 'Cart item not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Cart item retrieved successfully.',
            'cart_item' => $cartItem,
        ], 200);
    }


    // Update a cart item (change quantity)
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->update(['qty' => $request->qty]);

        return response()->json(['message' => 'Cart item updated!', 'cartItem' => $cartItem]);
    }

    // Remove an item from the cart
    public function destroy($id)

   

    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);

        if (!$cartItem) {
            return response()->json([
                'message' => 'Cart item not found.',
            ], 404);
        }


        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed!']);
}

    // // Clear all items from the cart
    // public function clearCart()
    // {
    //     Cart::where('user_id', Auth::id())->delete();

    //     return response()->json(['message' => 'Cart cleared successfully!']);
    // }

    // Get the total price of items in the cart
    // public function getCartTotal()
    // {
    //     $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
    //     $total = $cartItems->sum(function ($cartItem) {
    //         return $cartItem->product->price * $cartItem->qty;
    //     });

    //     return response()->json(['total' => $total]);
    // }
}
