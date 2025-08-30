<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1); // Default to 1 if quantity is not provided
            // $price = $request->input('price');

            // Retrieve the cart from the session
            $cart = $request->session()->get('cart', []);

            // Check if the product is already in the cart
            $existingProduct = collect($cart)->firstWhere('product_id', $productId);

            if ($existingProduct) {
                // If the product is already in the cart, increment the quantity
                $existingProduct['quantity'] += $quantity;
                $existingProduct['itemTotalPrice'] = $existingProduct['quantity'] * $existingProduct['price'];
            } else {
                // If the product is not in the cart, add a new item
                $product = Product::findOrFail($productId);
                $cart[] = [
                    'product_id'     => $productId,
                    'main_image'     => $product->main_image, // comes from accessor
                    'name'           => $product->product_name,
                    'price'          => $product->price,
                    'quantity'       => $quantity,
                    'itemTotalPrice' => $product->price * $quantity,
                ];


            }

            // Update the cart in the session
            $request->session()->put('cart', $cart);

            $cart = $request->session()->get('cart', []);

            // $cartCount = collect($cart)->count();
            $cartCount = sizeof($cart);
            // Update the cart count in the session
            session(['cartCount' => count($cart)]);

            if (auth()->check()) {
                $cartItem = Cart::where('user_id', auth()->id())
                                ->where('prod_id', $productId)
                                ->first();

                if ($cartItem) {
                    $cartItem->qty += $quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => auth()->id(),
                        'prod_id' => $productId,
                        'qty' => $quantity,
                    ]);
                }
            }

            // Calculate total cart price using query builder
            $totalCartPrice = $this->calculateTotalCartPrice($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Added to the cart.',
                'cartCount' => count($cart),
                'cartItems' => $this->renderCartItems($cart),
                'totalCartPrice' => $totalCartPrice
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function likeItem(Request $request)
    {
        try {
            $productId = $request->input('product_id');

            if (auth()->check()) {
                $existingRecord = DB::table('likes')->where('prod_id', $productId)->first();

                if ($existingRecord) {
                    // If a record exists, delete it
                    DB::table('likes')->where('prod_id', $productId)->delete();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Item unliked.',
                    ]);
                }

                if (!$existingRecord) {
                    // Insert the new record
                    DB::table('likes')->insert([
                        'user_id' => auth()->user()->id,
                        'prod_id' => $productId,
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Item liked.',
                    ]);
                }
            } else {
                // return response()->json([
                //     'status' => 'info',
                //     'message' => 'Login to like this product.',

                // ]);
                return response()->json(['status' => 'error', 'message' => 'Login to like']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    private function renderCartItems($cart)
    {
        $html = '';
        foreach ($cart as $item) {
            $html .= '<li>' . $item['name'] . ' - $' . $item['price'] . '</li>';
        }
        return $html;
    }

    public function viewCart(Request $request)
    {

        $cart = $request->session()->get('cart', []);

        $totalCartPrice = $this->calculateTotalCartPrice($cart);

        $pageTitle = "Cart";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge
        electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between
        global technology and local accessibility, offering a curated selection of premium devices from
        trusted manufacturers worldwide.";

        return view('shop.cart', compact('cart', 'totalCartPrice', 'pageTitle', 'pageDescription'));
    }

   public function removeFromCart(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $userId = Auth::id(); // ensure user is authenticated

            // Retrieve the cart from the session
            $cart = $request->session()->get('cart', []);

            // Find the index of the product in the cart
            $productIndex = collect($cart)->search(function ($item) use ($productId) {
                return $item['product_id'] == $productId;
            });

            if ($productIndex !== false) {
                // Remove the product from the cart
                unset($cart[$productIndex]);

                // Reset array keys after removing an item
                $cart = array_values($cart);

                // Update the cart in the session
                $request->session()->put('cart', $cart);

                // Update the cart count in the session
                session(['cartCount' => count($cart)]);

               // Remove from DB cart if user is logged in
                if (auth()->check()) {
                    $cartItem = Cart::where('user_id', auth()->id())
                                    ->where('prod_id', $productId)
                                    ->first();

                    if ($cartItem) {
                        $cartItem->delete();
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Item removed from the cart.',
                    'cartCount' => count($cart),
                    'cartItems' => $this->renderCartItems($cart),
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Item not found in the cart.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateQuantity(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity');

            // Retrieve the cart from the session
            $cart = $request->session()->get('cart', []);

            // Find the index of the product in the cart
            $productIndex = collect($cart)->search(function ($item) use ($productId) {
                return $item['product_id'] == $productId;
            });

            if ($productIndex !== false) {
                // Update the quantity for the product in the cart
                $cart[$productIndex]['quantity'] = $quantity;

                // Update the total price for the product in the cart
                $cart[$productIndex]['itemTotalPrice'] = $cart[$productIndex]['price'] * $quantity;

                // Update the cart in the session
                $request->session()->put('cart', $cart);

                $totalCartPrice = $this->calculateTotalCartPrice($cart);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Quantity updated successfully.',
                    'itemTotalPrice' => $cart[$productIndex]['itemTotalPrice'],
                    'totalCartPrice' => $totalCartPrice,
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in the cart.',
                'totalCartPrice' => 0, // Set a default value for totalCartPrice
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function calculateTotalCartPrice($cart)
    {
        $totalCartPrice = 0;

        foreach ($cart as $item) {
            $totalCartPrice += $item['itemTotalPrice'];
        }

        return $totalCartPrice;
    }
}
