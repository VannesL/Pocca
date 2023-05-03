<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Review;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

use function PHPUnit\Framework\containsEqual;

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
            'phoneno'           => ['required', 'numeric', 'regex:/(08)[0-9]{8,}$/', 'digits_between:10,12'],
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

    public function getVendorEditProfile()
    {
        $canteenId = auth()->guard('vendor')->user()->canteen_id;
        // dd($canteenId);
        $canteen =  Canteen::where('id', $canteenId)->first();

        $dataArray = array(
            'canteenName'   =>  $canteen->name
        );

        return view('vendorEditProfile', $dataArray);
    }

    public function updateVendorProfile(Request $request)
    { 
        $user = auth()->guard('vendor')->user();
        if ($request->email == $user->email) {
            $request['email'] = null;
            
        }
        Validator::make($request->all(), [
            'name'              => ['string'],
            'email'             => ['nullable', 'email' => 'email:rfc,dns', 'unique:vendors'],
            'password'          => ['nullable', 'min:8'],
            'passwordConfirm'   => ['sometimes', 'same:password'],
            'phone_number'      => [ 'numeric', 'regex:/(08)[0-9]{8,}$/', 'digits_between:10,12'],
            'store_name'         => [ 'string', 'min:8'],
            'address'           => [ 'string', 'min: 8'],
            'description'       => [ 'string', 'min: 8'],
            'image'             => ['mimes:jpg,bmp,png'],
            'qris'              => ['mimes:jpg,bmp,png'],
        ])->validate();
        


        $request['password'] = Hash::make($request->password);
        if ($request->qris && Storage::exists("public/qris/$user->qris")) {
            Storage::delete("public/qris/$user->qris");
        }
        if ($request->image && Storage::exists("public/profiles/$user->image")) {
            Storage::delete("public/profiles/$user->image");
        }
        $data = request()->collect()->filter(function ($value) {
            return null !== $value;
        })->toArray();

        $user->fill($data);
        $imgName = md5($user->email);
        if ($request->qris) {
            $qris_ext = $request->file('qris')->extension();

            $user->qris = 'qris' . $imgName . '.' . $qris_ext;
            $qris = $request->file('qris');
            Storage::putFileAs('public/qris', $qris, "$user->qris");
        }
        if ($request->image) {
            $img_ext = $request->file('image')->extension();

            $user->image = 'profile' . $imgName . '.' . $img_ext;
            $image = $request->file('image');
            Storage::putFileAs('public/profiles', $image, "$user->image");
        }
        $user->save();
        return redirect('/vendor-editProfile')->with('success', 'Profile Update Success');
    }

    public function deleteVendor()
    {
        $userid = auth()->guard('vendor')->user()->id;
        $user = Vendor::where('id', $userid)->first();

        auth()->logout();

        Storage::delete("public/profiles/$user->image");
        Storage::delete("public/qris/$user->qris");

        if ($user->delete()) {
            return redirect('/vendor-login');
        }
    }
    public function vendorDash(Request $request)
    {
        $userid = auth()->guard('vendor')->user()->id;
        $rating = 0;
        $rate = Review::where('vendor_id',$userid)
                    ->select(DB::raw('AVG(rating) as rating'))
                    ->get();
        if (!$rate->isEmpty()) {
            $rating = round($rate[0]->rating, 1);
        }

        $selectedDate = Carbon::today(); // initially todays date

        $curr_revOrd = DB::table('orders') // query get total revenue and order in current month
            ->select(DB::raw('SUM(total) AS revenue'), DB::raw('COUNT(id) AS total_order'))
            ->whereMonth('date', '=', $selectedDate->month)
            ->whereYear('date', '=', $selectedDate->year)
            ->get();

        $past_revOrd = DB::table('orders') // query get total revenue and order last month
            ->select(DB::raw('SUM(total) AS revenue'), DB::raw('COUNT(id) AS total_order'))
            ->whereMonth('date', '=', $selectedDate->month - 1)
            ->whereYear('date', '=', $selectedDate->year)
            ->get();

        // calculate the difference of revenue and total order between curr month and last month
        $revDiff = 100;
        $ordDiff = 100;
        if ($past_revOrd[0]->revenue) {
            $revDiff = ($curr_revOrd[0]->revenue - $past_revOrd[0]->revenue) * 100 / $past_revOrd[0]->revenue;
            $revDiff = round($revDiff, 2);
            $ordDiff = ($curr_revOrd[0]->total_order - $past_revOrd[0]->total_order) * 100 / $past_revOrd[0]->total_order;
        }


        $selectedDate = $selectedDate->toDateString(); //change to date string for passing value to input date in view
        if ($request->selectedDate) { // if the vendor request for past sales report
            $selectedDate = $request->selectedDate;
        }

        //query for sales report depend on the selected date
        $report = DB::table('orders')
           ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('menu_items', 'order_items.menu_id', '=', 'menu_items.id')
            ->select('menu_items.name', DB::raw('SUM(order_items.quantity) AS sold'), DB::raw('(SUM(order_items.quantity) * menu_items.price) AS profits'))
            ->where('orders.vendor_id', $userid)
            ->where('orders.date', $selectedDate)
            ->groupBy('menu_items.name')
            ->get(); 
        $totalProfits = $report->sum('profits');

        $data =  [
            'report' => $report, 
            'totalProfits' => $totalProfits, 
            'selectedDate' => $selectedDate, 
            'revenueOrders' => $curr_revOrd, 
            'revDiff' =>  $revDiff, 
            'ordDiff' => $ordDiff,
            'rating' => $rating
        ];

        return view('vendorDash', $data);
    }

    public function getReviews(){
        $userid = auth()->guard('vendor')->user()->id;
        $avgRating = 0;
        $avgRate = Review::where('vendor_id',$userid)
                    ->select(DB::raw('AVG(rating) as rating'))
                    ->get();
        if (!$avgRate->isEmpty()) {
            $avgRating = round($avgRate[0]->rating, 1);
        }

        $countPerRate = Review::where('vendor_id', $userid)
                        ->select(DB::raw('Count(rating) as rateCount'), 'rating')
                        ->groupBy('rating')
                        ->get();
        
        $reviews = Review::where('vendor_id',$userid)->get();

        $data = [
            'avgRating' => $avgRating,
            'countPerRate' => $countPerRate,
            'reviews' => $reviews
        ];
        // dd($data);
        return view('vendorReview', $data);
    }
}
