<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Customer;
use App\Models\MenuItem;
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
        // dd($request);
        $favorited_canteens = Canteen::whereHas('favorite_canteens')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $canteens = Canteen::whereDoesntHave('favorite_canteens')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        if ($request->search) {
            if ($request->type == 'canteen') {
                $favorited_canteens = Canteen::whereHas('favorite_canteens')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites')
                    ->get();
                $canteens = Canteen::whereDoesntHave('favorite_canteens')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites')
                    ->get();
            } elseif ($request->type == 'vendor') {
                $favorited_canteens = Vendor::whereHas('favorite_vendors')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites') //->whereNotIn($favorites->id);
                    ->get();
                $canteens = Vendor::whereDoesntHave('favorite_vendors')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites') //->whereNotIn($favorites->id);
                    ->get();
            }
        }
        return view('home', ['favorited_canteens' => $favorited_canteens, 'canteens' => $canteens, 'search' => $request->search]);
    }

    public function canteen(Request $request, Canteen $canteen)
    {
        $favorited_vendors = Vendor::where('canteen_id', $canteen->id)->whereHas('favorite_vendors')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $vendors = Vendor::where('canteen_id', $canteen->id)->whereDoesntHave('favorite_vendors')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $vendor_ids = $vendors->pluck('id');

        if ($request->search) {
            if ($request->type == 'vendor') {
                $vendors = Vendor::where('canteen_id', $canteen->id)->where('name', 'LIKE', '%' . $request->search . '%')
                    ->get()
                    ->sortByDesc('favorites'); //->whereNotIn($favorites->id);
            } elseif ($request->type == 'menu_item') {
                $vendors = MenuItem::whereIn('vendor_id', $vendor_ids)->where('name', 'LIKE', '%' . $request->search . '%')
                    ->get();
            }
        }
        return view('canteen', ['canteen' => $canteen, 'favorited_vendors' => $favorited_vendors, 'vendors' => $vendors, 'search' => $request->search]);
    }

    public function updateFavoriteCanteen(Request $request, Canteen $canteen)
    {
        $user = auth()->guard('customer')->user();
        if ($request->favorite == 0) {
            $canteen->favorite_canteens()->detach([$user->id] ?? []);
            $canteen->favorites -= 1;
            $canteen->save();
            return redirect(url('/home'));
        } elseif ($request->favorite == 1) {
            $canteen->favorite_canteens()->attach([$user->id] ?? []);
            $canteen->favorites += 1;
            $canteen->save();
            return redirect(url('/home'));
        };
    }

    public function updateFavoriteVendor(Request $request, Canteen $canteen, Vendor $vendor)
    {
        $user = auth()->guard('customer')->user();
        if ($request->favorite == 0) {
            $vendor->favorite_vendors()->detach([$user->id] ?? []);
            $vendor->favorites -= 1;
            $vendor->save();
            return redirect(url('/home/'.$canteen->id));
        } elseif ($request->favorite == 1) {
            $vendor->favorite_vendors()->attach([$user->id] ?? []);
            $vendor->favorites += 1;
            $vendor->save();
            return redirect(url('/home/'.$canteen->id));
        };
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
