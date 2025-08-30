<?php

namespace App\Http\Controllers;
use App\Models\Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    // Retrieve all addresses for a specific user
    public function index($user_id)
    {
        $addresses = Addresses::where('user_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'data' => $addresses,
        ]);
    }

    // Add a new address
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'fullname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'isPrimary' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }


        if ($request->isPrimary) {
         Addresses::where('user_id', $request->user_id)->update(['isPrimary' => false]);
     }


        // Create address
        $address = Addresses::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
            'data' => $address,
        ]);
    }
}
