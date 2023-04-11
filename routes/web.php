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

//Vendor Login
Route::get('/vendor-login', [VendorController::class, 'getVendorLogin']);
Route::post('/vendor-login', [VendorController::class, 'authenticate']);

//Admin Login
Route::get('/admin-login', [AdminController::class, 'getAdminLogin']);
Route::post('/admin-login', [AdminController::class, 'authenticate']);

Route::get('/home', function () {
    return view('home');
});

//Logout
Route::get('/logout', [CustomerController::class, 'logout']);
