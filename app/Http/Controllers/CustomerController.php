<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\MenuItem;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $favorited_canteens = Canteen::whereHas('favorite_canteens')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $canteens = Canteen::whereDoesntHave('favorite_canteens')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        if ($request->search) {
            if ($request->type == 'canteen') {
                $canteens = Canteen::where('name', 'LIKE', '%' . $request->search . '%')
                    ->get()
                    ->sortByDesc('favorites');
            } elseif ($request->type == 'vendor') {
                $canteens = Vendor::where('name', 'LIKE', '%' . $request->search . '%')
                    ->get()
                    ->sortByDesc('favorites'); //->whereNotIn($favorites->id);
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
        return view('Customer/home', ['favorited_canteens' => $favorited_canteens, 'canteens' => $canteens, 'type' => $request->type, 'search' => $request->search]);
    }

    public function canteen(Request $request, Canteen $canteen)
    {
        $favorited_vendors = Vendor::where('canteen_id', $canteen->id)->whereHas('favorite_vendors')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $vendors = Vendor::where('canteen_id', $canteen->id)->whereDoesntHave('favorite_vendors')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        $vendor_ids = $vendors->pluck('id');

        if ($request->search) {
            if ($request->type == 'vendor') {
                $favorited_vendors = Vendor::whereHas('favorite_vendors')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites') //->whereNotIn($favorites->id);
                    ->get();
                $vendors = Vendor::whereDoesntHave('favorite_vendors')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->orderByDesc('favorites') //->whereNotIn($favorites->id);
                    ->get();
            } elseif ($request->type == 'menu_item') {
                $vendors = MenuItem::whereIn('vendor_id', $vendor_ids)->where('name', 'LIKE', '%' . $request->search . '%')
                    ->get();
            }
        }
        return view('Customer/canteen', ['canteen' => $canteen, 'favorited_vendors' => $favorited_vendors, 'vendors' => $vendors, 'type' => $request->type, 'search' => $request->search]);
    }

    public function vendor(Request $request, vendor $vendor)
    {
        $user = auth()->guard('customer')->user();
        $cart = Cart::where('customer_id', $user->id)->where('vendor_id', $vendor->id)->get()->first();
        $cartItems = collect();
        if ($cart) {
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
        }

        $categories = [];
        $menuByCat = [];

        if ($request->search) {
            $categories = MenuItem::where('vendor_id', $vendor->id)
                ->where('menu_items.name', 'LIKE', '%_' . $request->search . '%')
                ->join('categories', 'categories.id', '=', 'menu_items.category_id')
                ->select('categories.name AS category_name', 'categories.description AS category_desc', 'menu_Items.category_id')
                ->distinct()
                ->get();

            foreach ($categories as $category) {
                $item = MenuItem::where('vendor_id', $vendor->id)
                    ->where('menu_items.name', 'LIKE', '%' . $request->search . '%')
                    ->where('category_id', $category->category_id)
                    ->where('availability', true)   // the app will only show available menu if they search
                    ->get();
                $cat = $category->category_name;
                $menuByCat[$cat] = $item;
            }
        } else {

            $categories = MenuItem::where('vendor_id', $vendor->id)
                ->join('categories', 'categories.id', '=', 'menu_items.category_id')
                ->select('categories.name AS category_name', 'categories.description AS category_desc', 'menu_Items.category_id')
                ->distinct()
                ->get();
            foreach ($categories as $category) {
                $item = MenuItem::where('vendor_id', $vendor->id)  // does not filter the availibility because we will show all menu including not available one.
                    ->where('category_id', $category->category_id)
                    ->get()
                    ->sortByDesc('availability');
                $cat = $category->category_name;
                $menuByCat[$cat] = $item;
            }
            // get all recommended menu from the vendor
            $recommended = MenuItem::where('vendor_id', $vendor->id)
                ->where('recommended', true)
                ->where('availability', true)
                ->get();
            if (!$recommended->isEmpty()) { // if recommended is not empty
                // create new collection to prepend to categories for recommended category (ignore the intelephense cuz it works!!)
                $rec = collect();
                $rec->category_id = 0;
                $rec->category_name = 'Recommended';
                $rec->category_desc = 'Recommended menu by vendor';
                $categories->prepend($rec);

                // prepend  $recommended result to the menuByCat as a data for showing menu
                $menuByCat = Arr::prepend($menuByCat, $recommended, 'Recommended');
            }
        }

        return view('Customer/customerMenu', ['vendor' => $vendor, 'menuByCat' => $menuByCat, 'categories' => $categories, 'search' => $request->search,  'vendor' => $vendor, 'cartItems' => $cartItems]);
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
            return redirect(url('/home/' . $canteen->id));
        } elseif ($request->favorite == 1) {
            $vendor->favorite_vendors()->attach([$user->id] ?? []);
            $vendor->favorites += 1;
            $vendor->save();
            return redirect(url('/home/' . $canteen->id));
        };
    }


    public function getCustomerEditProfile()
    {
        return view('customerEditProfile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->guard('customer')->user();
        if ($request->email == $user->email) {
            $request['email'] = null;
        }

        Validator::make($request->all(), [
            'name'              => ['string'],
            'email'             => ['nullable', 'email' => 'email:rfc,dns', 'unique:customers'],
            'password'          => ['nullable', 'min:8'],
            'passwordConfirm'   => ['sometimes', 'same:password'],
            'phone_number'      => ['numeric', 'regex:/(08)[0-9]{8,}$/', 'digits_between:10,12'],
            'dob'               => ['date', 'before:tomorrow']
        ])->validate();


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
