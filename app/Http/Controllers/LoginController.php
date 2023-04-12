<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //Customer Login
    public function getCustomerLogin()
    {
        return view('customerLogin');
    }
    public function authenticateCustomer(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email' => 'email:rfc,dns'],
            'password' => ['required', 'min:8'],
        ])->validate();

        if (auth()->guard('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'Email and Password are incorrect or unregistered',
        ]);
    }

    //Vendor Login
    public function getVendorLogin()
    {
        return view('vendorLogin');
    }
    public function authenticateVendor(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email' => 'email:rfc,dns'],
            'password' => ['required', 'min:8'],
        ])->validate();

        if (auth()->guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'Email and Password are incorrect or unregistered',
        ]);
    }

    //Admin Login
    public function getAdminLogin()
    {
        return view('adminLogin');
    }
    public function authenticateAdmin(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email' => 'email:rfc,dns'],
            'password' => ['required', 'min:8'],
        ])->validate();

        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'Email and Password are incorrect or unregistered',
        ]);
    }

    public function logout(Request $request)
    {
        $url = '/';
        if (auth()->guard('vendor')->check()) {
            $url = '/vendor-login';
        } elseif (auth()->guard('admin')->check()) {
            $url = '/admin-login';
        }

        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($url);
    }
}
