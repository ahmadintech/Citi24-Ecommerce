<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function showLoginForm()
    {

        $pageTitle = "Login";
        $pageDescription = "Our platform is dedicated to supporting and high-quality product to individuals and businesses in our community";
        return view('user.auth.login', compact('pageTitle', 'pageDescription'));
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        Session::put('url.intended', url()->previous());
        if(session()->get('url.intended') == route('user.login')){
            Session::forget('url.intended');
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            // Passwords match

            if(!$user->is_verified == 1){
                return redirect()->route('user.login')
                ->withErrors([
                    'email' => 'Your account is not yet verified please check your email and verify your account.',
                ]);
            }

            Auth::login($user); // Log the user in
            return redirect()->intended('/user/profile'); // Redirect to the intended URL or any default location
        } else {
            // Passwords do not match or user not found
            return redirect()->route('user.login')
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                    'password' => 'These password does not match our records.',
                ]);
            // ->with('error', 'Invalid credentials');
        }
    }

    protected function authenticated(Request $request, $user)
    {
        // Check if the user came from the login page (intended URL is not set)
        if (!$request->session()->has('url.intended')) {
            // Redirect to the dashboard or any other desired page
            return redirect()->route('dashboard');
        }

        return null; // Continue with the default behavior
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/user/login');
    }
}
