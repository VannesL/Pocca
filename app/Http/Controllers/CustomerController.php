<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Customer;
use App\Models\Vendor;
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
            'phoneno'           => ['required', 'numeric', 'regex:/(08)[0-9]{8,}$/', 'digits_between:10,12'],
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
        $canteens = Canteen::all()->sortByDesc('favorites'); //->whereNotIn($favorites->id);
        if ($request->search) {
            if ($request->type == 'canteen') {
                $canteens = Canteen::where('name', 'LIKE', '%' . $request->search . '%')
                    ->get()
                    ->sortByDesc('favorites');
            } elseif($request->type == 'vendor') {
                $canteens = Vendor::where('name', 'LIKE', '%' . $request->search . '%')
                ->get()
                ->sortByDesc('favorites'); //->whereNotIn($favorites->id);
            }
        }
        return view('home', ['canteens' => $canteens, 'search' => $request->search]);
    }

    public function canteen(Request $request, Canteen $canteen)
    {
        $vendors = Vendor::where('canteen_id', $canteen->id)->get()->sortByDesc('favorites'); //->whereNotIn($favorites->id);
        if ($request->search) {
            $vendors = Vendor::where('name', 'LIKE', '%' . $request->search . '%')
                ->get()
                ->sortByDesc('favorites'); //->whereNotIn($favorites->id);
        }
        return view('canteen', ['canteen' => $canteen, 'vendors' => $vendors, 'search' => $request->search]);
    }

    public function getCustomerEditProfile()
    {
        return view('customerEditProfile');
    }

    public function updateProfile(Request $request)
    {

        Validator::make($request->all(), [
            'name'              => ['nullable', 'string'],
            'email'             => ['nullable', 'email' => 'email:rfc,dns', 'unique:customers'],
            'password'          => ['nullable', 'min:8'],
            'passwordConfirm'   => ['sometimes', 'same:password'],
            'phone_number'      => ['nullable', 'numeric', 'regex:/(08)[0-9]{8,}$/', 'digits_between:10,12'],
            'dob'               => ['date', 'before:tomorrow']
        ])->validate();

        $user = auth()->guard('customer')->user();

        //Hash password before inserting to DB
        $request['password'] = Hash::make($request->password);

        //
        $data = request()->collect()->filter(function ($value) {
            return null !== $value;
        })->toArray();
        $user->fill($data)->save();


        return redirect('/editProfile')->with('success', 'Profile Update Success');
    }

    public function deleteCustomer()
    {
        $userid = auth()->guard('customer')->user()->id;
        $user = Customer::where('id', $userid)->first();

        auth()->logout();
        $del = $user->delete();
        if ($del) {
            return redirect('/');
        }
    }
}
