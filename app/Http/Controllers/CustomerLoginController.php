<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerLoginController extends Controller
{
    public function getCustomerLogin()
    {
        if (auth()->guard('customer')->user()) {
            return redirect()->route('home');
        }

        return view('customerLogin');
    }

    public function authenticate(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email' => 'email:rfc,dns'],
            'password' => ['required', 'min:8'],
        ]);
        $credentials->validate();

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect('home');
        }
    }
}
