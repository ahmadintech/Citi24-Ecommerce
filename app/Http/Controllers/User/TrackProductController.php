<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;

class TrackProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index($order_number)
    {
        $userId = auth()->id();

        // 1) Fetch the order by its public order_number, verifying it belongs to this user,
        //    and eager-load items → product in one query.
        $order = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->where('order_number', $order_number)
            ->firstOrFail();

        // 2) SEO / page metadata
        $pageTitle       = auth()->user()->firstname . " - Track Order #" . $order->order_number;
        $pageDescription = "Track your order placed on " 
                         . $order->created_at->format('M d, Y') 
                         . ". Current status: " 
                         . ucfirst($this->statusLabel($order->track_order)) . ".";

        // 3) Render the view
        return view('user.track_order', [
            'track'           => $order,
            'pageTitle'       => $pageTitle,
            'pageDescription' => $pageDescription,
        ]);
    }

    /**
     * Convert track_order numeric code into human-readable label.
     */
    private function statusLabel(int $code): string
    {
        return match ($code) {
            1 => 'processing',
            2 => 'shipped',
            4 => 'delivered',
            default => 'unknown',
        };
    }
}

