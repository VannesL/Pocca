<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function getCustomerEditProfile(){
        return view('customerEditProfile');
    }

    public function updateProfile(Request $request){
        
        $user = auth()->guard('customer')->user();
        Validator::make($request->all(), [
            'name'              => ['nullable','string'],
            'email'             => ['nullable','email' => 'email:rfc,dns', 'unique:customers'],
            'password'          => ['nullable','min:8'],
            'passwordConfirm'   => ['sometimes','same:password'],
            'phone_number'           => ['nullable','numeric','regex:/(08)[0-9]{8,}$/',],
            'dob'               => ['nullable','date', 'before:tomorrow']
        ])->validate();
        
        //Hash password before inserting to DB
        $request['password'] = Hash::make($request->password);
        
        //
        $data = request()->collect()->filter(function($value) {
            return null !== $value;
        })->toArray();
        $user->fill($data)->save();
        
        $user->save();

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
