<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuItemController;
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
});

Route::group(['middleware' => ['web', 'redirect.guard:vendor']], function () {
    Route::get('/vendor-dash', [VendorController::class, 'vendorDash']);
    Route::get('/vendor-menu', [MenuItemController::class, 'vendorMenu']);
    Route::get('/vendor-menu/add', [MenuItemController::class, 'addMenuForm']);
    Route::post('/vendor-menu/add', [MenuItemController::class, 'addMenu']);
    Route::get('/vendor-menu/edit/{menuid}', [MenuItemController::class, 'editMenuForm']);
    Route::post('/vendor-menu/edit/{menuid}', [MenuItemController::class, 'editMenu']);
    Route::get('/vendor-menu/delete/{menuid}', [MenuItemController::class, 'deleteMenu']);
});

Route::group(['middleware' => ['web', 'redirect.guard:admin']], function () {
    Route::get('/admin-dash', [AdminController::class, 'adminDash']);
});
