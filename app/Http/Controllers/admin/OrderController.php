<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display all orders with user and order item data.
     */
    public function orders()
    {
        Session::put('page', 'orders');

        $orders = Order::with([
            'user.addresses',
            'items.product'
        ])->orderBy('created_at', 'desc')->get();

        return view('admin.orders', compact('orders'));
    }

    /**
     * Display all cart items (if applicable in admin context).
     */
    public function cart()
    {
        Session::put('page', 'cart');

        $cart = Cart::with(['product', 'user.addresses'])->get();

        return view('admin.cart', compact('cart'));
    }

    /**
     * Return sales where payment_status is 'paid'.
     */
    public function sales()
    {
        $sales = Order::where('payment_status', 'paid')->with(['user'])->get();

        return response()->json(['sales' => $sales]);
    }

    /**
     * Toggle payment status via AJAX.
     */
    public function updatePaymentStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $newStatus = $data['status'] === 'paid' ? 'unpaid' : 'paid';

            Order::where('id', $data['order_id'])->update(['payment_status' => $newStatus]);

            return response()->json([
                'status' => $newStatus,
                'order_id' => $data['order_id']
            ]);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    /**
     * Update order tracking and completion status.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $data = $request->all();
        $trackStatus = $data['order_status'];

        $order = Order::findOrFail($id);

        $order->track_order = $trackStatus;

        if ($trackStatus == '4') {
            $order->order_status = 'completed';
        }

        $order->save();

        Session::flash('Success_message', 'Order status updated successfully.');
        return redirect()->back();
    }
}
