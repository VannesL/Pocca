<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\MenuItem;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
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
        $userId = auth()->guard('customer')->user()->id;

        $items = Canteen::with('favoritedCustomers')->where('name', 'LIKE', '%' . $request->search . '%')->whereNotNull('approved_by')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        if ($request->search) {
            if ($request->type == 'vendor') {
                $items = Vendor::with('favoritedCustomers')->orderByDesc('favorites')
                    ->where('name', 'LIKE', '%' . $request->search . '%')
                    ->whereNotNull('approved_by')
                    ->orderByDesc('favorites') //->whereNotIn($favorites->id);
                    ->get();
            }
        }

        $customer = auth()->guard('customer')->user();
        $cartItems = collect();
        if ($customer->cart) {
            $cartItems = $customer->cart->cartItems;
        }

        $cartTotal = 0;
        foreach ($cartItems as $cartItem) {
            $cartTotal = $cartTotal + $cartItem->quantity;
        }

        $data = [
            'items' => $items,
            'userId' => $userId,
            'type' => $request->type,
            'search' => $request->search,
            'cartTotal' => $cartTotal,
        ];

        return view('Customer/customerHome', $data);
    }

    public function canteen(Request $request, Canteen $canteen)
    {

        $userId = auth()->guard('customer')->user()->id;
        $items = Vendor::with('favoritedCustomers')->where('canteen_id', $canteen->id)->where('name', 'LIKE', '%' . $request->search . '%')->whereNotNull('approved_by')->orderByDesc('favorites')->get(); //->whereNotIn($favorites->id);
        if ($request->search) {
            if ($request->type == 'menu_item') {
                $items = Vendor::with([
                    'favoritedCustomers',
                    'menuItems' => function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->search . '%');
                    }
                    ])
                    ->where('canteen_id', $canteen->id)
                    ->whereNotNull('approved_by')
                    ->whereHas('menuItems')
                    ->orderByDesc('favorites')->get();
                }
        }

        $customer = auth()->guard('customer')->user();
        $cartItems = collect();
        if ($customer->cart) {
            $cartItems = $customer->cart->cartItems;
        }

        $cartTotal = 0;
        foreach ($cartItems as $cartItem) {
            $cartTotal = $cartTotal + $cartItem->quantity;
        }

        $data = [
            'canteen' => $canteen,
            'items' => $items,
            'userId' => $userId,
            'type' => $request->type,
            'search' => $request->search,
            'cartTotal' => $cartTotal,
        ];

        return view('Customer/customerCanteenView', $data);
    }

    public function viewMenu(Request $request, Canteen $canteen, Vendor $vendor)
    {
        $user = auth()->guard('customer')->user();
        $userId = $user->id;
        $cart = Cart::where('customer_id', $user->id)->where('vendor_id', $vendor->id)->get()->first();
        $cartItems = collect();
        if ($cart) {
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
        }
        $rating = Review::where('vendor_id', $vendor->id)
            ->select(DB::raw('AVG(rating) as rating'))
            ->get();
        if (!$rating->isEmpty()) {
            $rating = round($rating[0]->rating, 1);
        }
        //add favorite

        $categories = [];
        $menuByCat = [];

        if ($request->search) {
            $categories = MenuItem::where('menu_items.vendor_id', $vendor->id)
                ->where('menu_items.name', 'LIKE', '%_' . $request->search . '%')
                ->join('categories', 'categories.id', '=', 'menu_items.category_id')
                ->select('categories.name AS category_name', 'menu_Items.category_id')
                ->distinct()
                ->get();

            foreach ($categories as $category) {
                $item = MenuItem::where('menu_items.vendor_id', $vendor->id)
                    ->where('menu_items.name', 'LIKE', '%' . $request->search . '%')
                    ->where('category_id', $category->category_id)
                    ->where('availability', true)   // the app will only show available menu if they search
                    ->get();
                $cat = $category->category_name;
                $menuByCat[$cat] = $item;
            }
        } else {

            $categories = MenuItem::where('menu_items.vendor_id', $vendor->id)
                ->join('categories', 'categories.id', '=', 'menu_items.category_id')
                ->select('categories.name AS category_name', 'menu_Items.category_id')
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

        $data = [
            'userId' => $userId,
            'vendor' => $vendor,
            'menuByCat' => $menuByCat,
            'categories' => $categories,
            'search' => $request->search,
            'vendor' => $vendor,
            'cartItems' => $cartItems,
            'rating' => $rating,
        ];

        return view('Customer/customerMenu', $data);
    }



    public function updateFavoriteCanteen(Request $request, Canteen $canteen)
    {
        $user = auth()->guard('customer')->user();
        if ($request->favorite == 0) {
            $canteen->favoritedCustomers()->detach([$user->id] ?? []);
            $canteen->favorites -= 1;
            $canteen->save();
            return redirect()->back();
        } elseif ($request->favorite == 1) {
            $canteen->favoritedCustomers()->attach([$user->id] ?? []);
            $canteen->favorites += 1;
            $canteen->save();
            return redirect()->back();
        };
    }

    public function updateFavoriteVendor(Request $request, Canteen $canteen, Vendor $vendor)
    {
        $user = auth()->guard('customer')->user();
        if ($request->favorite == 0) {
            $vendor->favoritedCustomers()->detach([$user->id] ?? []);
            $vendor->favorites -= 1;
            $vendor->save();
            return redirect()->back();
        } elseif ($request->favorite == 1) {
            $vendor->favoritedCustomers()->attach([$user->id] ?? []);
            $vendor->favorites += 1;
            $vendor->save();
            return redirect()->back();
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
