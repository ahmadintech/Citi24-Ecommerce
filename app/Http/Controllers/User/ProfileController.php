<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\addresses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = auth()->user()->firstname . " Profile";
        $pageDescription = "CITi24 is revolutionizing tech commerce in Nigeria by delivering cutting-edge electronics and innovative gadgets directly to your doorstep within 24 hours. We bridge the gap between global technology and local accessibility, offering a curated selection of premium devices from trusted manufacturers worldwide.";

        return view('user.profile', compact('pageTitle', 'pageDescription'));
    }

    public function edit()
    {
        $pageTitle = "Edit" . auth()->user()->firstname . " Profile";
        $pageDescription = "Our marketplace is dedicated to supporting local agriculture and providing fresh, high-quality
        farm produce to individuals and businesses in our community";

        $shipping_price = DB::table('lagos_shipping')->get();
        return view('user.edit', compact('shipping_price', 'pageTitle', 'pageDescription'));
    }

    public function editAction(Request $request)
    {
        // dd($request);
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            // Add other validation rules as needed
        ]);

        $user = User::find(auth()->user()->id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->phone = $request->input('phone');
        $user->save();

        $address = addresses::updateorInsert(
            ['user_id' => auth()->user()->id],
            [
                'fullname' => auth()->user()->firstname . ' ' . auth()->user()->lastname,
                'address' => $request->input('address'),
                'state' => $request->input('state'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
                'isPrimary' => 1
            ]
        );

        $address->timestamps = true;

        return redirect()->back()->with('success', 'Profile data updated.');
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = auth()->user();
        // Check if the current password matches the one in the database
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the user's password
        $user = User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->password),
        ]);

        Auth::logout();
        return redirect()->route('user.login')->with('success', 'Password changed successfully.');
    }
}
