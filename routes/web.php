<?php

use App\Models\category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\productController;
use App\Http\Controllers\admin\sectionController;
use App\Http\Controllers\admin\categoryController;
use App\Http\Controllers\payment\PaymentController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/send-test-mail', function () {
//     Mail::to('ahmadintech1@gmail.com')->send(new TestMail());
//     return 'Test email sent successfully!';
// });

Auth::routes();


// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index2'])->name('home');

Route::get('/faq', [App\Http\Controllers\Shop\PageController::class, 'faq'])->name('faq');
Route::get('/return_policy', [App\Http\Controllers\Shop\PageController::class, 'return_policy'])->name('return_policy');
Route::get('/privacy_policy', [App\Http\Controllers\Shop\PageController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms_condition', [App\Http\Controllers\Shop\PageController::class, 'terms_condition'])->name('terms_condition');

Route::prefix('/admin')->namespace('admin')->group(function () {
    //All admin routes will be defined inside here
    Route::match(['get', 'post'], '/', [adminController::class, 'login']);

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', [adminController::class, 'dashboard']);
        Route::get('users', [adminController::class, 'users']);
        Route::get('manage_admins', [adminController::class, 'manageAdmins']);
        Route::get('add-admin', [adminController::class, 'addAdmin']);
        Route::post('add-new-admin', [adminController::class, 'addNewAdmin']);
        Route::get('delete-admin/{id}', [adminController::class, 'deleteAdmin']);

        Route::get('settings', [adminController::class, 'settings']);
        Route::get('logout', [adminController::class, 'logout']);
        Route::post('check-current-pwd', [adminController::class, 'checkCurrentPassword']);
        Route::post('update-current-pwd', [adminController::class, 'updateCurrentPassword']);
        Route::match(['get', 'post'], 'update-admin-details', [adminController::class, 'updateAdminDetails']);

        Route::get('shipping', [adminController::class, 'shipping']);
        Route::post('edit-shipping', [adminController::class, 'editShipping']);

        //categories route
        Route::get('categories', [categoryController::class, 'categories']);
        Route::post('update-category-status', [categoryController::class, 'updateCategoryStatus']);

        Route::match(['get', 'post'], 'add-edit-category/{id?}', [categoryController::class, 'addEditCategory']);

        Route::get('delete-category-image/{id}', [categoryController::class, 'deleteCategoryImage']);
        Route::post('append-categories-level', [categoryController::class, 'appendCategoryLevel']);
        Route::get('delete-category/{id}', [categoryController::class, 'deleteCategory']);

        //products route
        Route::get('products', [productController::class, 'products']);
        Route::post('update-product-status', [productController::class, 'updateProductStatus']);
        Route::get('delete-product/{id}', [productController::class, 'deleteProduct']);
        Route::match(['get', 'post'], 'add-edit-product/{id?}', [productController::class, 'addEditProduct']);
        Route::get('delete-product-image/{id}', [productController::class, 'deleteProductImage']);
        Route::get('delete-product-video/{id}', [productController::class, 'deleteProductVideo']);

        //Images route
        Route::match(['get', 'post'], 'add-images/{id}', [productController::class, 'addImages']);
        Route::get('delete-image/{id}', [productController::class, 'deleteImage']);

        //orders route
        Route::get('cart', [OrderController::class, 'cart']);
        Route::get('orders', [OrderController::class, 'orders']);
        Route::post('update-payment-status', [OrderController::class, 'updatePaymentStatus']);
        Route::post('update-order-status/{id}', [OrderController::class, 'updateOrderStatus']);

        //Sales route
        Route::get('sales', [OrderController::class, 'sales']);
    });
});

Route::prefix('shop')->group(function () {


    Route::get('/product', 'Shop\ProductController@index')->name('shop.product');
    Route::get('/product/single/{product_name}', 'Shop\ProductController@productDetails')->name('shop.product.details');

    // Search
    Route::get('/search/', 'Shop\ProductController@search')->name('shop.search');


    //category
    Route::get('/category/{name}', 'Shop\Category\CategoryController@index')->name('shop.category');

    //like product
    Route::post('/like-product', 'Shop\CartController@likeItem')->name('like.product');

    //add to cart
    Route::post('/add-to-cart', 'Shop\CartController@addToCart')->name('cart.add');

    //remove from cart
    Route::post('/remove-from-cart', 'Shop\CartController@removeFromCart')->name('cart.remove');

    //update item quantity
    Route::post('/update-item-quantity', 'Shop\CartController@updateQuantity')->name('cart.updateQuantity');
    Route::get('/cart', 'Shop\CartController@viewCart')->name('shop.cart');


    //checkout
    // Route::get('/checkout', 'Shop\CheckoutController@index')->name('checkout.index');
    // Route::post('/checkout/order/verify', 'Shop\CheckoutController@verifyPaystackTransaction')->name('checkout.verify');
    // Route::post('/checkout/order', 'Shop\CheckoutController@process')->name('checkout.order');
    // Route::post('/checkout/webhook', 'Shop\CheckoutController@callBack');

    Route::get('/checkout',     'Shop\CheckoutController@index')->name('checkout.index');
    Route::post('/checkout/order',    'Shop\CheckoutController@process')->name('checkout.order');
    Route::post('/checkout/verify',   'Shop\CheckoutController@verifyPaystackTransaction')->name('checkout.verify');


    Route::get('/payment/callback', 'Shop\CheckoutController@handleGatewayCallback');



    // shipping-price
    Route::post('/get-shipping-price', 'Shop\CheckoutController@setLocation');
    // Route::get('/get-shipping-price/{location}', 'Shop\CheckoutController@getShippingPrice');


    //thank you page
    Route::get('/checkout/thank-you', 'Shop\CheckoutController@thankyou')->name('checkout.thankyou');
});

//Email Verification
Route::get('/user/email-verificaton', 'Verification\EmailVerificationController@index')->name('email.verification');
Route::post('email-verification-action', 'Verification\EmailVerificationController@validateOtp')->name('user-email-action');
Route::get('/verification-successful', 'Verification\EmailVerificationController@verifiedSuccessfull')->name('user.verifiedSuccessfull');


//Password-rest
Route::get('forget-password', 'User\Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'User\Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');

Route::get('reset-password/{token}', 'User\Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'User\Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

// Register
Route::get('/user/register', 'User\Auth\RegisterController@showRegisterForm')->name('user.register');
Route::post('/user/register', 'User\Auth\RegisterController@RegisterAction')->name('user.register.action');

//Login
Route::get('/user/login', 'User\Auth\LoginController@showLoginForm')->name('user.login');
Route::post('/user/login', 'User\Auth\LoginController@loginAction')->name('user.login.action');


Route::prefix('user')->group(function () {
    //profile
    Route::get('/profile', 'User\ProfileController@index')->name('user.profile');

    //order
    Route::get('/order', 'User\OrderController@index')->name('user.order');

    //track my porduct
    Route::get('/track-my-order/{order_id}', 'User\TrackProductController@index')->name('user.track');

    //profile
    Route::get('/order', 'User\OrderController@index')->name('user.order');

    //rate my porduct
    Route::get('/my-review/', 'User\ReviewController@index')->name('user.review');
    Route::post('/review-my-order/{order_id}', 'User\ReviewController@rateProduct')->name('user.review.action');

    // edit profile
    Route::get('/profile-edit', 'User\ProfileController@edit')->name('user.edit');
    Route::post('/profile-edit', 'User\ProfileController@editAction')->name('user.edit.action');

    //changer password
    Route::post('/password/change', 'User\ProfileController@changePassword')->name('password.change');

    Route::get('/logout', 'User\Auth\LoginController@logout')->name('user.logout');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
