<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\addresses;
use App\Http\Resources\ProfileApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProfileApiController extends Controller
{
    /**
     * Middleware for API authentication
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Get user profile
     */
    public function getProfile()
{
    $user = Auth::user();
    return new ProfileApiResource($user);
}


public function updateProfile(Request $request)
{
    $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'state' => 'required|string|max:100',
        'city' => 'required|string|max:100',
    ]);

    DB::beginTransaction();

    try {
        $user = Auth::user();

        // Update user information
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
        ]);

        // Update or insert address
        addresses::updateOrInsert(
            ['user_id' => $user->id],
            [
                'fullname' => $user->firstname . ' ' . $user->lastname,
                'address' => $request->address,
                'state' => $request->state,
                'city' => $request->city,
                'phone' => $request->phone,
                'isPrimary' => 1,
            ]
        );

        DB::commit();

        // Retrieve updated user profile
        $updatedUser = $user->fresh();

        // Retrieve updated address
        $updatedAddress = addresses::where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully.',
            'data' => [
                'id' => $updatedUser->id,
                'firstname' => $updatedUser->firstname,
                'lastname' => $updatedUser->lastname,
                'email' => $updatedUser->email,
                'phone' => $updatedUser->phone,
                'address' => $updatedAddress->address ?? null,
                'state' => $updatedAddress->state ?? null,
                'city' => $updatedAddress->city ?? null,
                'is_primary' => $updatedAddress->isPrimary ?? false,
            ],
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update profile.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Change password
     */
    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required|string',
    //         'new_password' => 'required|string|confirmed|min:8',
    //     ]);

    //     try {
    //         $user = Auth::user();

    //         // Verify current password
    //         if (!Hash::check($request->current_password, $user->password)) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Current password is incorrect.',
    //             ], 400);
    //         }

    //         // Update password and log out from other devices
    //         $user->update(['password' => Hash::make($request->new_password)]);
    //         Auth::logoutOtherDevices($request->new_password);

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Password changed successfully.',
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to change password.',
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|confirmed|min:8',
    ]);

    try {
        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.',
            ], 400);
        }

        // Update password
        $user->update(['password' => Hash::make($request->new_password)]);

        // Logout user from all devices by deleting all personal access tokens
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully. Please log in again.',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to change password.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}