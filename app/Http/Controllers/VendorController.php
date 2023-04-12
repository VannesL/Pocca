<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

class VendorController extends Controller
{
    public function getVendorRegister()
    {
        $canteen = Canteen::all();
        $data = [
            'canteens' => $canteen,
            'selected' => 0
        ];
        return view('vendorRegister', $data);
    }

    public function register(Request $request)
    {
        $canteenId = $request->selectCanteen;

        Validator::make($request->all(), [
            'name'              => ['required', 'string'],
            'email'             => ['required', 'email' => 'email:rfc,dns', 'unique:vendors'],
            'password'          => ['required', 'min:8'],
            'passwordConfirm'   => ['required', 'same:password'],
            'phoneno'           => ['required', 'numeric', 'digits:12'],
            'selectCanteen'     => ['required'],
            'storeName'         => ['required', 'string', 'min:8'],
            'address'           => ['required', 'string', 'min: 8'],
            'desc'              => ['required', 'string', 'min: 8'],
            'profile'           => ['mimes:jpg,bmp,png'],
            'qris'              => ['required', 'mimes:jpg,bmp,png'],
        ])->sometimes('canteenName', 'required|string|min:8|unique:canteens,name', function ($request) {
            return $request->selectCanteen == -1;
        })->validate();

        // insert new canteen if create new canteen selected
        if ($canteenId == -1) { # code...
            $canteen = new Canteen();
            $canteen->name = $request->canteenName;
            $canteen->address = $request->address;
            $canteen->approved_by = 1;
            $canteen->favorites = 0;
            $canteen->save();

            // change current canteen id for vendor into the newly created one
            $canteenId = $canteen->id;
        }

        // profile img check, img ext, and name
        $profile_ext = '';
        if ($request->profile) {
            $profile_ext = $request->file('profile')->extension();
        }
        // encrypt image name based on email, cuz email unique so image will not overwrited if same name
        $imgName = md5($request->email);
        $qris_ext = $request->file('qris')->extension();

        // insert vendor 
        $vendor = new Vendor();
        //$vendor->approved_by = null, value initialized as null, only set when admin finished approving
        $vendor->range_id = 1;    // price range cannot be null so need change in DB if want null
        $vendor->email = $request->email;
        $vendor->name = $request->name;
        $vendor->password = Hash::make($request->password);
        $vendor->store_name = $request->storeName;
        $vendor->canteen_id = $canteenId;
        $vendor->phone_number = $request->phoneno;
        $vendor->address = $request->address;
        $vendor->description = $request->desc;
        $vendor->image = '';

        if ($profile_ext != '') { //if profile exist
            $vendor->image = 'profile' . $imgName . '.' . $profile_ext;

            $profile = $request->file('profile');
            Storage::putFileAs('public/profiles', $profile, "$vendor->image");
        }
        $vendor->qris = 'qris' . $imgName . '.' . $qris_ext;

        $qris = $request->file('qris');
        Storage::putFileAs('public/qris', $qris, "$vendor->qris");

        $vendor->favorites = 0;
        $vendor->save();



        if (!is_null($vendor)) {
            return redirect('/vendor-login')->with('Success', "Account Registered");;
        } else {
            return back()->withErrors('Failed', "Sorry the account creation failed, plese check the data again");
        }
    }

    public function vendorDash(Request $request)
    {
        return view('home');
    }
}
