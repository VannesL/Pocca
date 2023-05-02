<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

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

//Login & Register
Route::group(['middleware' => ['guest:customer,vendor,admin']], function () {
    Route::get('/', [LoginController::class, 'getCustomerLogin']);
    Route::get('/vendor-login', [LoginController::class, 'getVendorLogin']);
    Route::get('/admin-login', [LoginController::class, 'getAdminLogin']);
});
Route::post('/login', [LoginController::class, 'authenticateCustomer']);
Route::post('/vendor-login', [LoginController::class, 'authenticateVendor']);
Route::post('/admin-login', [LoginController::class, 'authenticateAdmin']);
Route::get('/register', [CustomerController::class, 'getCustomerRegister']);
Route::post('/register', [CustomerController::class, 'register']);
Route::get('/vendor-register', [VendorController::class, 'getVendorRegister']);
Route::post('/vendor-register', [VendorController::class, 'register']);

//Logout
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['web', 'redirect.guard:customer']], function () {
    Route::get('/home', [CustomerController::class, 'home']);
    Route::get('/canteen/{canteen}', [CustomerController::class, 'canteen']);
    //Profile
    Route::get('/editProfile', [CustomerController::class, 'getCustomerEditProfile']);
    Route::post('/editProfile', [CustomerController::class, 'updateProfile']);
    
    Route::post('/deleteProfile', [CustomerController::class, 'deleteCustomer']);
    //Order
    Route::get('/order/customer', [OrderController::class, 'customerOrder']);
    Route::get('/order/customer/history', [OrderController::class, 'customerOrderHistory']);
    Route::post('/order/customer/payment/{orderid}', [OrderController::class, 'orderPayment']);
    //Review
    Route::post('/review/{orderid}', [ReviewController::class, 'createReview']);
    
    Route::post('/vendor/{vendor}/addToCart/{menuitem}', [CartController::class, 'addToCart']);
    Route::get('/vendor/{vendor}', [CustomerController::class, 'vendor']);

    Route::get('/customer-cart',[CartController::class,'cartPage']);
    Route::post('/checkout',[CartController::class,'checkout']);

});
Route::group(['middleware' => ['web', 'redirect.guard:vendor']], function () {
    Route::get('/vendor-dash', [VendorController::class, 'vendorDash']);
    //Profile
    Route::get('/vendor-editProfile', [VendorController::class, 'getVendorEditProfile']);
    Route::post('/vendor-editProfile', [VendorController::class, 'updateVendorProfile']);
    Route::post('/vendor-deleteProfile', [VendorController::class, 'deleteVendor']);
    //Menu
    Route::get('/vendor-menu', [MenuItemController::class, 'vendorMenu']);
    Route::get('/vendor-menu/add', [MenuItemController::class, 'addMenuForm']);
    Route::post('/vendor-menu/add', [MenuItemController::class, 'addMenu']);
    Route::get('/vendor-menu/edit/{menuid}', [MenuItemController::class, 'editMenuForm']);
    Route::post('/vendor-menu/edit/{menuid}', [MenuItemController::class, 'editMenu']);
    Route::post('/vendor-menu/delete/{menuid}', [MenuItemController::class, 'deleteMenu']);
    //Order
    Route::get('/order/vendor', [OrderController::class, 'vendorOrder']);
    Route::get('/order/vendor/history', [OrderController::class, 'vendorOrderHistory']);
    // Sales Report
    Route::get('/vendor-home', [VendorController::class, 'getSalesReport']);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/order/{orderid}', [OrderController::class, 'orderDetails']);
    Route::get('/order/update-status/{orderid}', [OrderController::class, 'orderUpdateStatus']);
});

Route::group(['middleware' => ['web', 'redirect.guard:admin']], function () {
    Route::get('/admin-dash', [AdminController::class, 'adminDash']);
    Route::get('/admin-vendorDetails/{vendorid}', [AdminController::class, 'getVendorDetails']);
    Route::post('/admin-rejectVendor/{vendorid}', [AdminController::class, 'rejectVendor']);
    Route::post('/admin-acceptVendor/{vendorid}', [AdminController::class, 'acceptVendor']);
});
