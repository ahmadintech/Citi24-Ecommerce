<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function faq()
    {
        $pageTitle = "FAQ";
        $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
        farm produce to individuals and businesses in our community";

        return view('shop.faq', compact('pageTitle', 'pageDescription'));
    }

    public function return_policy()
    {
        $pageTitle = "Return privacy";
        $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
        farm produce to individuals and businesses in our community";

        return view('shop.return_privacy', compact('pageTitle', 'pageDescription'));
    }

    public function privacy_policy()
    {
        $pageTitle = "Privacy policy";
        $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
        farm produce to individuals and businesses in our community";

        return view('shop.privacy_policy', compact('pageTitle', 'pageDescription'));
    }

    public function terms_condition()
    {
        $pageTitle = "Terms Condtion";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";

        return view('shop.terms_condition', compact('pageTitle', 'pageDescription'));
    }

}
