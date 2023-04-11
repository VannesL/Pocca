<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function getAdminLogin()
    {
        return view('adminLogin');
    }

    public function authenticate(Request $request)
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
}
