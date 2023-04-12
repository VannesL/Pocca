<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
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

//Customer
Route::get('/', [LoginController::class, 'getCustomerLogin']);
Route::post('/login', [LoginController::class, 'authenticateCustomer']);
Route::get('/register', [CustomerController::class, 'getCustomerRegister']);
Route::post('/register', [CustomerController::class, 'register']);

//Vendor
Route::get('/vendor-login', [LoginController::class, 'getVendorLogin']);
Route::post('/vendor-login', [LoginController::class, 'authenticateVendor']);
Route::get('/vendor-register', [VendorController::class, 'getVendorRegister']);
Route::post('/vendor-register', [VendorController::class, 'register']);

//Admin
Route::get('/admin-login', [LoginController::class, 'getAdminLogin']);
Route::post('/admin-login', [LoginController::class, 'authenticateAdmin']);

Route::group(['middleware' => ['web']], function () {
    Route::get('/home', function () {
        return view('home');
    });
});


//Logout
Route::get('/logout', [LoginController::class, 'logout']);
