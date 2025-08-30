<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\EmailHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $pageTitle = "Register";
        $pageDescription = "Our platform is dedicated to supporting and high-quality product to individuals and businesses in our community";

        return view('user.auth.register', compact('pageTitle', 'pageDescription'));
    }

    public function RegisterAction(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => '',
            'password' => Hash::make($request->input('password')),
            'is_verified' => 0,
        ]);

        if ($user) {
            // Send email to user
            $replyToEmail = 'admin@farmersmarketplace.ng';
            $userEmail = $user->email;
            $subject = 'Account Created';
            $body = "<h1>Hi " . $user->firstname . ",</h1>
                          <p>
                          Your Account has been Created Successfully, please verify your account and login.<br><br>
                          </p>
                          <br>";

            try {
                dispatch(new SendEmail($userEmail, $body, $subject, $replyToEmail));
            } catch (\Exception $ex) {
            }


            $otp = Str::random(6);
            User::where('email', $user->email)->update(['code' => $otp]);

            $userEmail = $user->email;
            $body = "<h1>Hi " . $user->surname . " ,</h1>
                              <h1>One-Time Password</h1>
              <p>Your one-time password is: <strong> $otp</strong></p>
              <p>Please use this OTP to proceed with your action.</p>";
            $subject = 'Otp Verification';
            $replyToEmail = 'innovatewithciti@gmail.com';

            try {
                dispatch(new SendEmail($userEmail, $body, $subject, $replyToEmail));
            } catch (\Exception $ex) {
            }

            //   return view('user.auth.verification.email-verification');\
            return redirect()->route('email.verification')->with('success', 'Your account has been created successfully');
        }
    }
}
