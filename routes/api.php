<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\CartApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Publicly accessible routes (no authentication required)
Route::get('/categories', [CategoryApiController::class, 'index']); // Get all categories
Route::get('/categories/{id}', [CategoryApiController::class, 'show']); // Get specific category with subcategories
Route::get('/products', [ProductApiController::class, 'index']); // Get all products with optional filters
Route::get('/products/{id}', [ProductApiController::class, 'show']); // Get single product details

// Authentication routes
Route::prefix('auth')->middleware('api')->group(function () {
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('verify-email', [AuthApiController::class, 'verifyEmail']);
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('forgot-password', [AuthApiController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthApiController::class, 'resetPassword']);
    Route::post('logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
     // Address management
    Route::post('/addresses', [AddressController::class, 'store']); // Create address
    Route::put('/addresses/{id}', [AddressController::class, 'update']); // Update address
});


Route::middleware(['auth:sanctum'])->group(function () {
    // Get user profile
    Route::get('/profile', [ProfileApiController::class, 'getProfile']);
    // Update profile
    Route::post('/profile/update', [ProfileApiController::class, 'updateProfile']);
    // Change password
    Route::post('/profile/change-password', [ProfileApiController::class, 'changePassword']);


    Route::get('/cart', [CartApiController::class, 'getCartItems']); // Get all cart items
    Route::post('/cart', [CartApiController::class, 'store']); // Add an item to the cart
    Route::get('/cart/{id}', [CartApiController::class, 'show']); // Show specific cart item
    Route::put('/cart/{id}', [CartApiController::class, 'update']); // Update cart item quantity
    Route::delete('/cart/{id}', [CartApiController::class, 'destroy']); // Remove an item from the cart
    // Route::delete('/cart/clear', [CartApiController::class, 'clearCart']); // Clear the cart
    // Route::get('/cart/total', [CartApiController::class, 'getCartTotal']); // Get total price of cart


    // Orders management
    Route::post('/orders', [OrderApiController::class, 'store']); // Create an order
    Route::get('/orders', [OrderApiController::class, 'index']); // Get all orders for a user
    Route::get('/orders/{id}', [OrderApiController::class, 'track']); // Track a specific order
    // Orders management

   
});


