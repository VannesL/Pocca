<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
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

//Customer Login
Route::get('/', [CustomerController::class, 'getCustomerLogin']);
Route::post('/login', [CustomerController::class, 'authenticate']);
Route::get('/register', [CustomerController::class, 'getCustomerRegister']);
Route::post('/register', [CustomerController::class, 'register']);
Route::get('/editProfile', [CustomerController::class, 'getCustomerEditProfile']);
Route::post('/editProfile', [CustomerController::class, 'updateProfile']);
Route::post('/deleteProfile', [CustomerController::class, 'deleteCustomer']);

//Vendor Login
Route::get('/vendor-login', [VendorController::class, 'getVendorLogin']);
Route::post('/vendor-login', [VendorController::class, 'authenticate']);
Route::get('/vendor-register', [VendorController::class, 'getVendorRegister']);
Route::post('/vendor-register', [VendorController::class, 'register']);
Route::get('/vendor-editProfile', [VendorController::class, 'getVendorEditProfile']);
Route::post('/vendor-editProfile', [VendorController::class, 'updateVendorProfile']);
Route::post('/vendor-deleteProfile', [VendorController::class, 'deleteVendor']);


//Admin Login
Route::get('/admin-login', [AdminController::class, 'getAdminLogin']);
Route::post('/admin-login', [AdminController::class, 'authenticate']);

Route::get('/admin-login', [AdminController::class, 'getAdminLogin']);

Route::get('/home', function () {
    return view('home');
});

//Logout
Route::get('/logout', [CustomerController::class, 'logout']);
