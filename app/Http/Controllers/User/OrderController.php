<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = auth()->id();

        // Orders with tracking status 1, 2, or 3 and completed
        $pending_order = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('order_status', 'completed')
            ->whereIn('track_order', [1, 2, 3])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending_page');

        // Completed and delivered orders
        $completed_order = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('order_status', 'completed')
            ->where('track_order', 4)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'completed_page');

        // Cancelled orders
        $cancelled_order = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('order_status', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'cancelled_page');

        $pageTitle = "Order History";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";

        return view('user.my_order', compact(
            'pending_order',
            'completed_order',
            'cancelled_order',
            'pageTitle',
            'pageDescription'
        ));
    }

}
