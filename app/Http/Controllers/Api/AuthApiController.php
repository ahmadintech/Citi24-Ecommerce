<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

class AuthApiController extends Controller
{

// User Registration
// public function register(Request $request)
// {
//     $validated = $request->validate([
//         'firstname' => 'required|max:255',
//         'lastname' => 'required|max:255',
//         'email' => 'required|email|unique:users',
//         'password' => 'required|confirmed',
//         'phone' => 'required|numeric', // Add validation for `phone`
//     ]);

//     $user = User::create([
//         'firstname' => $validated['firstname'],
//         'lastname' => $validated['lastname'],
//         'email' => $validated['email'],
//         'password' => Hash::make($validated['password']),
//         'phone' => $validated['phone'],
//         'is_verified' => 0, // Adjust field name
//     ]);

//     // Generate OTP and send verification email
//     $otp = rand(100000, 999999);
//     $user->update(['code' => $otp]);

//     // Use Mailtrap with proper email structure
//     $details = [
//         'subject' => 'Verify Your Account',
//         'body' => "
//             <h1>Hello {$user->firstname},</h1>
//             <p>Your OTP is: <strong>{$otp}</strong>. Please verify your account.</p>
//         ",
//     ];

//     Mail::send([], [], function ($message) use ($details, $user) {
//         $message->to($user->email)
//             ->subject($details['subject'])
//             ->html($details['body']);
//     });

//     return response()->json([
//         'message' => 'Registration successful! Please check your email to verify your account.',
//     ], 201);
// }

  public function register(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'firstname' => 'required|max:255',
        'lastname' => 'required|max:255',
        'email' => 'required|email',  // Remove unique rule for manual check
        'password' => 'required|confirmed',
        'phone' => 'required|numeric',
    ]);

    // Trim and normalize the email
    $email = trim($validated['email']);

    // Check if a user with the same email already exists
    $existingUser = User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();

    // If the user already exists, return a JSON response
    if ($existingUser) {
        return response()->json([
            'message' => 'User with this email already exists. Please log in.',
        ], 400);  // Use 400 status code for "Bad Request"
    }

    // Create a new user record if the email is unique
    $user = User::create([
        'firstname' => $validated['firstname'],
        'lastname' => $validated['lastname'],
        'email' => $email,
        'password' => Hash::make($validated['password']),
        'phone' => $validated['phone'],
        'is_verified' => 0,
    ]);

    // Generate OTP (One-Time Password) for email verification
    $otp = rand(100000, 999999);
    $user->update(['code' => $otp]);

    // Send OTP via email
    $details = [
        'subject' => 'Verify Your Account',
        'body' => "
            <h1>Hello {$user->firstname},</h1>
            <p>Your OTP is: <strong>{$otp}</strong>. Please verify your account.</p>
        ",
    ];

    Mail::send([], [], function ($message) use ($details, $user) {
        $message->to($user->email)
            ->subject($details['subject'])
            ->html($details['body']);
    });

    // Return JSON response indicating success
    return response()->json([
        'message' => 'Registration successful! Please check your email to verify your account.',
    ], 201);  // HTTP status 201 indicates resource created
}
    //Email Verification
    public function verifyEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || $user->code !== $validated['otp']) {
            return response()->json(['message' => 'Invalid OTP or email.'], 400);
        }

        $user->update(['is_verified' => 1, 'code' => null]);

        return response()->json(['message' => 'Email verified successfully!'], 200);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid email or password.'], 401);
    }

    if (!$user->is_verified) {
        return response()->json(['message' => 'Please verify your email to continue.'], 403);
    }
    Auth::login($user);
    $token = $user->createToken('API Token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful!',
        'token' => $token,
        'user' => $user,
    ]);
}



public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        $emailBody = "
            <h1>Password Reset</h1>
            <p>Passwor Reset Token:</p>
            <p>Your Token is: <strong>{$token}</strong>.</p>
            Password</a>
        ";

        dispatch(new SendEmail($request->email, $emailBody, 'Reset Password', 'admin@farmersmarketplace.ng'));

        return response()->json(['message' => 'Password reset link sent to your email.'], 200);
    }


    public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:users,email',
        'password' => 'required|confirmed|min:8',
    ]);

    // Find the token in the password reset table
    $passwordReset = DB::table('password_reset_tokens')->where([
        ['token', $request->token],
        ['email', $request->email],
    ])->first();

    if (!$passwordReset) {
        return response()->json(['message' => 'Invalid or expired token.'], 400);
    }

    // Check if the token has expired (e.g., 1 hour validity)
    if (Carbon::parse($passwordReset->created_at)->addHours(1)->isPast()) {
        return response()->json(['message' => 'Token has expired.'], 400);
    }

    // Update the user's password
    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the token after use
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return response()->json(['message' => 'Password has been reset successfully.'], 200);
}


  // Store a new address
    public function addAddress(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',  // Ensure the user exists
            'fullname' => 'required|max:255',
            'address' => 'required|max:255',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'phone' => 'required|numeric',
            'isPrimary' => 'required|boolean',  // Check if it is the primary address
        ]);

        // Create a new address
        $address = Address::create($validated);

        return response()->json(['message' => 'Address created successfully!', 'address' => $address], 201);
    }

    // Update address details
    public function updateAddress(Request $request, $id)
    {
        // Validate incoming request
        $validated = $request->validate([
            'fullname' => 'required|max:255',
            'address' => 'required|max:255',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'phone' => 'required|numeric',
            'isPrimary' => 'required|boolean',
        ]);

        // Find address
        $address = Address::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        // Update address with validated data
        $address->update($validated);

        return response()->json(['message' => 'Address updated successfully!', 'address' => $address], 200);
    }

    // Logout
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }







}

