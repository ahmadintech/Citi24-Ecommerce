<?php

use App\Models\ShippingPrice;



if (!function_exists('delivery_charge')) {
    function delivery_charge($state = null)
    {
        $dc = 0;
        if ($state != null) {
            $delivery_charge = ShippingPrice::where('state', $state)->first();
            if (!is_null($delivery_charge)) {
                $dc = $delivery_charge->price;
            }
        }
        return $dc;
    }

    if (!function_exists('generate_order_id')) {
        function generate_order_id($length = 8) {
            $characters = '0123456789';
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $randomString;
        }
    }
}
