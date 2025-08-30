<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\ShippingPrice;
use Illuminate\Http\Request;

class ShippingController extends Controller
{

    public function getShippingPrice($location)
    {

        $shippingPrice = ShippingPrice::where('state', $location)->first();

        return response()->json(['price' => $shippingPrice->price]);

    }
}
