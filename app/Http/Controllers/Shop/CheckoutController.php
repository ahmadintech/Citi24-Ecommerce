<?php

namespace App\Http\Controllers\Shop;

use App\Jobs\SendEmail;
use App\Models\addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Unicodeveloper\Paystack\Facades\Paystack;

class CheckoutController extends Controller
{
    private $grand_total;

    public function index(Request $request)
    {
        $user = auth()->user();
        $addressExist = addresses::where('user_id', $user->id ?? '')->exists();
        if (!$addressExist) {
            return redirect()->route('user.edit')->with('message', 'Please update your profile with your address.');
        }
        // dd(addresses::get()->where('user_id', \App\Models\User::find(1)->id));
        // dd($request);
        $cart = $request->session()->get('cart', []);
        // dd($cart);
        $totalCartPrice = $this->calculateTotalCartPrice($cart);
        // $shipping_price = ShippingPrice::all();
        $shipping_price = DB::table('lagos_shipping')->get();

        // Retrieve the selected location from the session
        // $selectedLocation = $request->session()->get('selectedLocation');
        $selectedLocation = addresses::where('user_id', auth()->user()->id)->get();
        $selectedLocation = $selectedLocation[0]->city;
        // dd($selectedLocation[0]->city);

        // Use $selectedLocation to calculate the shipping price
        $shippingPrice = $this->getShippingPrice($selectedLocation);

        // Calculate the final price
        $finalPrice = $shippingPrice + $totalCartPrice;

        $pageTitle = "Checkout Page";
        $pageDescription = "Checkout Page";


        return view('shop.checkout', compact('cart', 'totalCartPrice', 'shipping_price', 'finalPrice', 'shippingPrice', 'pageTitle', 'pageDescription'));
    }


    public function handleGatewayCallback()
    {
        try {
            $paymentDetails = Paystack::getPaymentData();
            $orderNumber = session('order_number');

            // Update payment status of the main order
            Order::where('order_id', $orderNumber)
                ->update([
                    'order_status' => 'completed',
                    'payment_status' => 'paid',
                    'track_order' => '1'
                ]);

            // Send order confirmation email here (optional)

            // Clear session cart
            Session::forget('cart');
            Session::forget('cartCount');
            Session::forget('order_number');
            Session::forget('grand_total');

            return redirect()->route('checkout.thankyou')->with('success', 'Your order has been placed and payment confirmed!');
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Payment verification failed.');
        }
    }


public function verifyPaystackTransaction(Request $request)
{
    // 1) Verify paystack
    $resp = (new \GuzzleHttp\Client)->get(
      "https://api.paystack.co/transaction/verify/{$request->reference}",
      ['headers'=>[
         'Authorization'=> "Bearer ".env('PAYSTACK_SECRET_KEY'),
         'Accept'=> 'application/json',
      ]]
    );
    $data = json_decode($resp->getBody(), true)['data'] ?? null;
    if (!$data || $data['status']!=='success') {
        return response()->json(['status'=>'error','message'=>'Payment failed.']);
    }

    // 2) Grab from session
    $cart     = session('checkout.cart', []);
    $shipping = session('checkout.shipping', 0);
    $subtotal = $this->calculateTotalCartPrice($cart);
    $total    = $subtotal + $shipping;

    // 3) Create master order
    $order = Order::create([
      'user_id'        => auth()->id(),
      'order_number'   => 'CT-'.uniqid(),
      'shipping_charge'=> $shipping,
      'grand_total'    => $total,
      'order_status'   => 'completed',
      'payment_status' => 'paid',
      'track_order'    => '1',
    ]);

    // 4) Create line items
    foreach ($cart as $item) {
        OrderItem::create([
          'order_id' => $order->id,
          'prod_id'  => $item['product_id'],
          'qty'      => $item['quantity'],
          'price'    => $item['price'],
          'total'    => $item['itemTotalPrice'],
        ]);
    }

    // 5) Send email
    // dispatch(new SendEmail(
    //   auth()->user()->email,
    //   view('emails.order_placed', compact('order','cart','shipping','total'))->render(),
    //   'Order Confirmation',
    //   'info@citi24.com.ng'
    // ));

    // 6) Clear everything
    Session::forget('cart');
    Session::forget('cartCount');
    Session::forget('checkout.cart');
    Session::forget('checkout.shipping');
    Session::forget('checkout.meta');

    // 7) Tell JS where to go
    return response()->json([
      'status'       => 'success',
      'redirect_url' => route('checkout.thankyou'),
    ]);
}



public function process(Request $request)
{
    $data = $request->validate([
      'fullname'=>'required',
      'address'=>'required',
      'state'=>'required',
      'city'=>'required',
      'phone'=>'required',
    ]);

    addresses::updateOrInsert(
       ['user_id'=>auth()->id()],
       $data + ['additionalPhone'=>$request->additionalPhone,'isPrimary'=>1]
    );

    session([
      'checkout.cart'     => session('cart', []),
      'checkout.shipping' => $this->getShippingPrice($data['city']),
      'checkout.meta'     => $data + ['additionalPhone'=>$request->additionalPhone],
    ]);

    return response()->json([
      'publicKey'=>config('services.paystack.publicKey'),
      'email'    =>auth()->user()->email,
      'amount'   => (session('checkout.shipping') + $this->calculateTotalCartPrice(session('checkout.cart'))) * 100,
    ]);
}


    private function calculateTotalCartPrice($cart)
    {
        $totalCartPrice = 0;

        foreach ($cart as $item) {
            $totalCartPrice += $item['itemTotalPrice'];
        }

        return $totalCartPrice;
    }

    private function getShippingPrice($location)
    {
        // $shippingPrice = ShippingPrice::where('state', $location)->first();
        // return response()->json(['price' => $shippingPrice->price]);


        $shippingPrice = 0;
        if ($location != null) {
            // $shippingPriceData = ShippingPrice::where('state', $location)->first();
            $shippingPriceData = DB::table('lagos_shipping')->where('city', $location)->first();

            if (!is_null($shippingPriceData)) {
                $shippingPrice = $shippingPriceData->cost;
            }
        }
        // return response()->json(['price' => $shippingPrice]);
        return $shippingPrice;
    }

    public function setLocation(Request $request)
    {
        // Retrieve the data from the request
        $location = $request->input('selectedLocation');
        Session::put('selectedLocation', $location);

        $user = addresses::where('user_id', auth()->user()->id)->update(['city' => $location]);
        // $shippingPriceData = ShippingPrice::where('state', $location)->value('price');
        $shippingPriceData = DB::table('lagos_shipping')->where('city', $location)->value('cost');

        $cart = $request->session()->get('cart', []);
        $totalCartPrice = $this->calculateTotalCartPrice($cart);

        $selectedLocation = $request->session()->get('selectedLocation');
        $shippingPrice = $this->getShippingPrice($selectedLocation);

        // Calculate the final price
        $finalPrice = $shippingPrice + $totalCartPrice;
        return response()->json([
            'price' => $shippingPriceData,
            'totalCartPrice' => $finalPrice,
        ]);

        // return response()->json(['success' => true])->withCookie(cookie('laravel_session', session()->getId(), 60, '/', null, false, false));

    }

    public function thankyou()
    {
        $pageTitle = "Thank Page";
        $pageDescription = "Thank Page";
        return view('shop.thankyou', compact('pageTitle', 'pageDescription'));
    }
}
