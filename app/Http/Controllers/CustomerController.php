<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function getCustomerRegister()
    {
        return view('customerRegister');
    }

    public function register(Request $request)
    {
        Validator::make($request->all(), [
            'name'              => ['required', 'string'],
            'email'             => ['required', 'email' => 'email:rfc,dns', 'unique:customers'],
            'password'          => ['required', 'min:8'],
            'passwordConfirm'   => ['required', 'same:password'],
            'phoneno'           => ['required', 'numeric', 'digits:12'],
            'dob'               => ['required', 'date', 'before:tomorrow']
        ])->validate();

        $dataArray = array(
            "email"         =>      $request->email,
            "password"      =>      Hash::make($request->password),
            "name"          =>      $request->name,
            "phone_number"  =>      $request->phoneno,
            "dob"           =>      $request->dob
        );

        $customer = Customer::create($dataArray);

        if (!is_null($customer)) {
            return redirect('/')->with('Success', "Account Registered");;
        } else {
            return back()->withErrors('Failed', "Sorry the account creation failed, plese check the data again");
        }
    }

    public function home(Request $request)
    {
        return view('home');
    }

    public function getCustomerEditProfile(){
        return view('customerEditProfile');
    }

    public function updateProfile(Request $request){
        
        Validator::make($request->all(), [
            'name'              => ['nullable','string'],
            'email'             => ['nullable','email' => 'email:rfc,dns', 'unique:customers'],
            'password'          => ['nullable','min:8'],
            'passwordConfirm'   => ['sometimes','same:password'],
            'phone_number'      => ['nullable','numeric','regex:/(08)[0-9]{8,}$/',],
            'dob'               => ['date', 'before:tomorrow']
            ])->validate();
            
        $user = auth()->guard('customer')->user();
        
        //Hash password before inserting to DB
        $request['password'] = Hash::make($request->password);
        
        //
        $data = request()->collect()->filter(function($value) {
            return null !== $value;
        })->toArray();
        $user->fill($data)->save();
        

        return redirect('/editProfile')->with('success','Profile Update Success');
    }

    public function deleteCustomer(){
        $userid = auth()->guard('customer')->user()->id;
        $user = Customer::where('id', $userid)->first();

        Auth::logout();

        if ($user->delete()) {
            return redirect('/');
        }
    }
}
