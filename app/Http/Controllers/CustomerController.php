<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function getCustomerLogin()
    {
        return view('customerLogin');
    }
    public function getCustomerRegister()
    {
        return view('customerRegister');
    }


    public function authenticate(Request $request)
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

    public function register(Request $request){
        Validator::make($request->all(),[
            'name'              => ['required', 'string'],
            'email'             => ['required', 'email' => 'email:rfc,dns','unique:customers'],
            'password'          => ['required', 'min:8'],
            'passwordConfirm'   => ['required', 'same:password'],
            'phoneno'           => ['required', 'numeric', 'digits:12'],
            'dob'               => ['required', 'date', 'before:tomorrow']
        ])->validate();

        $dataArray = array(
            "email"         =>      $request->email,
            "password"      =>      $request->password,
            "name"          =>      $request->name,
            "phone_number"  =>      $request->phoneno,
            "dob"           =>      $request->dob
        );

        $customer = Customer::create($dataArray);

        if(!is_null($customer)){
            return redirect('/')->with('Success', "Account Registered");;
        }else{
            return back()->withErrors('Failed', "Sorry the account creation failed, plese check the data again");
        }
        
    }
}
