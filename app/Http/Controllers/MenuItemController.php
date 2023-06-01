<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\PriceRange;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class MenuItemController extends Controller
{
    public function vendorMenu(Request $request)
    {
        $user = auth()->guard('vendor')->user();
        $search =  $request->search;
        $categories = [];
        $menuByCat = [];
        $categories = Category::where('vendor_id', $user->id)
            ->orWhere('vendor_id', null)
            ->get();

        foreach ($categories as $category) {
            $item = MenuItem::where('vendor_id', $user->id)
                ->where([['category_id', $category->id], ['deleted_at', null]])
                ->when($search, function ($query, $search) {
                    return $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->get()
                ->sortByDesc('availability');
            $cat = $category->name;
            $menuByCat[$cat] = $item;
        }
        $data = [
            'categories' => $categories,
            'menuByCat' => $menuByCat,
            'search' => $request->search
        ];

        return view('Vendor/vendorMenu', $data);
    }

    public function addMenuForm(Request $request)
    {

        $user = auth()->guard('vendor')->user();
        $categories = Category::where('vendor_id', $user->id)
            ->orWhere('vendor_id', null)
            ->get();

        $data = [
            'categories' => $categories,
        ];

        return view('Vendor/addMenuForm', $data);
    }

    public function addMenu(Request $request)
    {
        //make session for last image to display
        Validator::make($request->all(), [
            'image'             => ['image'],
            'name'              => ['required', "regex:/^([^_]*)$/"],
            'description'       => ['string'],
            'selectCategory'    => ['required'],
            'price'             => ['required', 'numeric'],
            'cook'              => ['required', 'numeric'],
        ])->validate();

        //Check if duplicate new name
        $request->merge([
            'name' => auth()->guard('vendor')->user()->id . '_' . $request->name
        ]);
        Validator::make($request->all(), ['name' => 'unique:menu_items,name'])->validate();

        $menuItem = new MenuItem();
        $menuItem->category_id = $request->selectCategory;
        $menuItem->vendor_id = auth()->guard('vendor')->user()->id;
        $menuItem->name = $request->name;
        $menuItem->description = $request->description;
        $menuItem->price = $request->price;
        $menuItem->cook_time = $request->cook;
        $menuItem->availability = true;
        $menuItem->recommended = false;
        $menuItem->image = '';

        //Encrypt with vendor email and name with menu name
        if ($request->image) {
            $vendorEnc = md5(auth()->guard('vendor')->user()->email);
            $image_ext = $request->file('image')->extension();
            $menuItem->image = 'menu_' . $vendorEnc . '_' .  $menuItem->name . '.' . $image_ext;

            $image = $request->file('image');
            Storage::putFileAs('public/menus', $image, "$menuItem->image");
        }

        $menuItem->save();

        //Set price range
        $avgPrice = MenuItem::where([['vendor_id', auth()->guard('vendor')->user()->id]])
            ->avg('price');

        $avg = (int)$avgPrice;
        $priceRanges = PriceRange::get();
        $vendor = Vendor::where('id', auth()->guard('vendor')->user()->id)->get()->first();

        foreach ($priceRanges as $range) {
            //Set max value for highest price range
            if ($range->max == 0) {
                $range->max = $avg;
            }
            if ($avg >= $range->min && $avg <= $range->max) {
                $vendor->range_id = $range->id;
                $vendor->save();
                break;
            }
        }

        if (!is_null($menuItem)) {
            return redirect('/vendor-menu')->with('Success', "Successfully Added Item!");
        } else {
            return back()->withErrors('Failed', "There was an error adding the item!");
        }
    }

    public function editMenuForm(Request $request)
    {
        $user = auth()->guard('vendor')->user();
        $categories = Category::where('vendor_id', $user->id)
            ->orWhere('vendor_id', null)
            ->get();
        $item = MenuItem::find($request->menuid);

        $data = [
            'categories' => $categories,
            'item' => $item,
        ];

        return view('Vendor/editMenuForm', $data);
    }

    public function editMenu(Request $request)
    {
        $item = MenuItem::find($request->menuid);

        //General validation
        Validator::make($request->all(), [
            'image'             => ['image'],
            'name'              => ['required', "regex:/^([^_]*)$/"],
            'description'       => ['string'],
            'price'             => ['required', 'numeric'],
            'cook'              => ['required', 'numeric'],
        ])->validate();

        //Check if duplicate new name
        $request->merge([
            'name' => $item->vendor_id . '_' . $request->name
        ]);
        if ($request->name != $item->name) {
            Validator::make($request->all(), ['name' => 'unique:menu_items,name'])->validate();
        }

        $item->category_id = $request->category;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->cook_time = $request->cook;
        $item->availability = $request->has('availability');
        $item->recommended = $request->has('recommended');


        //Encrypt with vendor email and name with menu name
        if ($request->image) {
            if ($item->image) {
                Storage::delete('public/menus' . $item->image);
            }

            $vendorEnc = md5(auth()->guard('vendor')->user()->email);
            $image_ext = $request->file('image')->extension();
            $item->image = 'menu_' . $vendorEnc . '_' .  $item->name . '.' . $image_ext;

            $image = $request->file('image');
            Storage::putFileAs('public/menus', $image, "$item->image");
        }

        $item->save();

        //Set price range
        $avgPrice = MenuItem::where([['vendor_id', auth()->guard('vendor')->user()->id]])
            ->avg('price');

        $avg = (int)$avgPrice;
        $priceRanges = PriceRange::get();
        $vendor = Vendor::where('id', auth()->guard('vendor')->user()->id)->get()->first();

        foreach ($priceRanges as $range) {
            //Set max value for highest price range
            if ($range->max == 0) {
                $range->max = $avg;
            }
            if ($avg >= $range->min && $avg <= $range->max) {
                $vendor->range_id = $range->id;
                $vendor->save();
                break;
            }
        }

        return redirect('/vendor-menu/edit/' . $request->menuid)->with('Success', "Successfully Updated Item!");
    }

    public function deleteMenu(Request $request)
    {
        $item = MenuItem::where('id', $request->menuid)->first();

        if ($item->image) {
            Storage::delete('public/menus' . $item->image);
        }
        $item->name = $item->name . '_deleted@' . md5(Carbon::now());
        $item->save();
        $item->delete();

        $avgPrice = MenuItem::where([['vendor_id', auth()->guard('vendor')->user()->id], ['deleted', false]])
            ->avg('price');

        $avg = (int)$avgPrice;
        $priceRanges = PriceRange::get();
        $vendor = Vendor::where('id', auth()->guard('vendor')->user()->id)->get()->first();

        foreach ($priceRanges as $range) {
            //Set max value for highest price range
            if ($range->max == 0) {
                $range->max = $avg;
            }
            if ($avg >= $range->min && $avg <= $range->max) {
                $vendor->range_id = $range->id;
                $vendor->save();
                break;
            }
        }

        return redirect('/vendor-menu');
    }
}
