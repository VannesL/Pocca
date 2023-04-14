<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function getVendorLogin()
    {
        return view('vendorLogin');
    }

    public function getVendorRegister()
    {
        $canteen = Canteen::all();
        $data = [
            'canteens' =>$canteen,
            'selected' => 0
        ];
        return view('vendorRegister',$data);
    }

    public function authenticate(Request $request)
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

    public function register(Request $request){
        $canteenId = $request->selectCanteen;
        
        Validator::make($request->all(),[
            'name'              => ['required', 'string'],
            'email'             => ['required', 'email' => 'email:rfc,dns','unique:vendors'],
            'password'          => ['required', 'min:8'],
            'passwordConfirm'   => ['required', 'same:password'],
            'phoneno'           => ['required', 'numeric', 'digits:12'],
            'selectCanteen'     => ['required'],
            'storeName'         => ['required', 'string', 'min:8'],
            'address'           => ['required', 'string', 'min: 8'],
            'desc'              => ['required', 'string', 'min: 8'],
            'profile'           => ['mimes:jpg,bmp,png'],
            'qris'              => ['required','mimes:jpg,bmp,png'],
        ])->sometimes('canteenName','required|string|min:8|unique:canteens,name',function($request){
            return $request->selectCanteen == -1;
        })->validate();
        
        // insert new canteen if create new canteen selected
        if ($canteenId==-1) {# code...
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
        $profile_ext='';
        if($request->profile){
            $profile_ext = $request->file('profile')->extension();
        }
        // encrypt image name based on email, cuz email unique so image will not overwrited if same name
        $imgName = md5($request->email);
        $qris_ext = $request->file('qris')->extension();

        // insert vendor 
        $vendor = new Vendor();
        $vendor->approved_by = 1; // admin cannot be null so need change in DB if want null
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
        
        if($profile_ext!=''){ //if profile exist
            $vendor->image = 'profile'.$imgName.'.'.$profile_ext;

            $profile = $request->file('profile');
            Storage::putFileAs('public/profiles',$profile,"$vendor->image");
        }
        $vendor->qris = 'qris'.$imgName.'.'.$qris_ext;

        $qris = $request->file('qris');
        Storage::putFileAs('public/qris',$qris,"$vendor->qris");

        $vendor->favorites = 0;   
        $vendor->save();

        

        if(!is_null($vendor)){
            return redirect('/vendor-login')->with('Success', "Account Registered");;
        }else{
            return back()->withErrors('Failed', "Sorry the account creation failed, plese check the data again");
        }
    }

    public function getVendorEditProfile(){
        $canteenId = auth()->guard('vendor')->user()->canteen_id;
        // dd($canteenId);
        $canteen =  Canteen::where('id', $canteenId)->first();

        $dataArray = array(
            'canteenName'   =>  $canteen->name
        );

        return view('vendorEditProfile', $dataArray);
    }

    public function updateVendorProfile(Request $request){
        Validator::make($request->all(),[
            'name'              => ['nullable', 'string'],
            'email'             => ['nullable', 'email' => 'email:rfc,dns','unique:vendors'],
            'password'          => ['nullable', 'min:8'],
            'passwordConfirm'   => ['sometimes', 'same:password'],
            'phone_number'      => ['nullable','numeric','regex:/(08)[0-9]{8,}$/',],
            'store_name'         => ['nullable', 'string', 'min:8'],
            'address'           => ['nullable', 'string', 'min: 8'],
            'description'       => ['nullable', 'string', 'min: 8'],
            'image'             => ['mimes:jpg,bmp,png'],
            'qris'              => ['mimes:jpg,bmp,png'],
        ])->validate();
       

        $user = auth()->guard('vendor')->user();
        // if ($request->name) {
        //     $user->name = $request->name;
        // }
        // if ($request->email) {
        //     $user->email = $request->email;
        // }
        // if ($request->password) {
        //     $user->password = $request->password;
        // }
        // if ($request->phone_number) {
        //     $user->phone_number = $request->phone_number;
        // }
        // if ($request->store_name) {
        //     $user->store_name = $request->store_name;
        // }
        // if ($request->address) {
        //     $user->address = $request->address;
        // }
        // if ($request->description) {
        //     $user->description = $request->description;
        // }
        $request['password'] = Hash::make($request->password);
        if ($request->qris && Storage::exists("public/qris/$user->qris")) { 
            Storage::delete("public/qris/$user->qris");
        }
        if ($request->image && Storage::exists("public/profiles/$user->image")){
            Storage::delete("public/profiles/$user->image");
        }
        $data = request()->collect()->filter(function($value) {
            return null !== $value;
        })->toArray();

        $user->fill($data);

        if ($request->qris){
            $imgName = md5($user->email);
            $qris_ext = $request->file('qris')->extension();
                
            $user->qris = 'qris'.$imgName.'.'.$qris_ext;
            $qris = $request->file('qris');
            Storage::putFileAs('public/qris',$qris,"$user->qris");
        }
        if ($request->image) {
            $img_ext = $request->file('image')->extension();
                
            $user->image = 'profile'.$imgName.'.'.$img_ext;
            $image = $request->file('image');
            Storage::putFileAs('public/profiles',$image,"$user->image");
        }
        $user->save();
        return redirect('/vendor-editProfile')->with('success','Profile Update Success');
        

    }

    public function deleteVendor(){
        $userid = auth()->guard('vendor')->user()->id;
        $user = Vendor::where('id', $userid)->first();

        Auth::logout();

        Storage::delete("public/profiles/$user->image");
        Storage::delete("public/qris/$user->qris");
        
        if ($user->delete()) {
            return redirect('/vendor-login');
        }
    }
    
}
