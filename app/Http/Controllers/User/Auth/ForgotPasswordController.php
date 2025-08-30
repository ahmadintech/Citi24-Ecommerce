<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {

        $pageTitle = "Forgeot Password";
        $pageDescription = "Our platform is dedicated to supporting and high-quality product to individuals and businesses in our community";

        return view('user.auth.forgot-password', compact('pageTitle', 'pageDescription'));
    }

    public function submitForgetPasswordForm(Request $request)
    {

        $customMessages = [
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'A link has been sent to your email alreay, please check and rest your password.',
        ];

        $request->validate([
            'email' => 'required|email|exists:users',
            'email' => 'unique:password_reset_tokens',
        ], $customMessages);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Send email to user
        $replyToEmail = 'innovatewithciti@gmail.com';
        $userEmail = $request->email;
        $subject = 'Reset Password';
        $body = "

        <h1>Hello</h1>
        <p> No need to worry, you can reset your password by clicking on the link below.</p>

        <a href='" . url('reset-password', $token) . "'>Reset Password</a>

        <p> if you did not reset password please contact us immediately</p>

        ";

        try {
            dispatch(new SendEmail($userEmail, $body, $subject, $replyToEmail));
        } catch (\Exception $ex) {
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token): View
    {

        $pageTitle = "Reset Password";
        $pageDescription = "Our platform is dedicated to supporting and high-quality product to individuals and businesses in our community";
        return view('user.auth.forgetPasswordLink',compact('pageTitle', 'pageDescription'), ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request): RedirectResponse
    {
        $request->validate([
            // 'email' => 'required|email|exists:users',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                // 'email' => $request->email,
                'token' => $request->token
            ])->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        // dd($updatePassword->email, $request->password);

        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $updatePassword->email])->delete();

        // Send email to user
        $replyToEmail = 'innovatewithciti@gmail.com';
        $userEmail = $updatePassword->email;
        $subject = 'Password changed';
        $body = "

        <h1>Your password has been changed</h1>
        <p> If you did not request a password reset, feel free to delete this email and enjoy your shopping!</p>
        ";

        try {
            dispatch(new SendEmail($userEmail, $body, $subject, $replyToEmail));
        } catch (\Exception $ex) {
        }

        return redirect()->route('user.login')->with('success', 'Your password has been changed! You can now login');
    }
}
