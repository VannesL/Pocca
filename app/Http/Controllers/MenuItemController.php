<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    public function vendorMenu(Request $request)
    {
        $items = DB::table('menu_items')
            ->where('vendor_id', auth()->guard('vendor')->user()->id)
            ->get();

        $data = [
            'items' => $items,
        ];

        return view('vendorMenu', $data);
    }

    public function addMenuForm(Request $request)
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];

        return view('menuForm', $data);
    }

    public function addMenu(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['image'],
            'name'              => ['required', 'string'],
            'description'       => ['string'],
            'selectCategory'          => ['required'],
            'price' => ['required', 'numeric'],
            'cook' => ['required', 'numeric'],
        ])->validate();

        $menuItem = new MenuItem();
        $menuItem->category_id = $request->selectCategory;
        $menuItem->vendor_id = auth()->guard('vendor')->user()->id;
        $menuItem->name = $request->name;
        $menuItem->description = $request->description;
        $menuItem->price = $request->price;
        $menuItem->cook_time = $request->cook;
        $menuItem->availability = true;
        $menuItem->image = '';

        //TODO: encrypt with vendor email instead of menu name
        if ($request->image) {
            $imgName = md5($request->name);
            $image_ext = $request->file('image')->extension();
            $menuItem->image = 'image' . $imgName . '.' . $image_ext;

            $image = $request->file('image');
            Storage::putFileAs('public/menus', $image, "$menuItem->image");
        }

        $menuItem->save();
        if (!is_null($menuItem)) {
            return redirect('/vendor-menu')->with('Success', "Item Added");;
        } else {
            return back()->withErrors('Failed', "There was an error adding the item!");
        }
    }

    public function editMenuForm(Request $request)
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];

        return view('editMenuForm', $data);
    }

    public function deleteMenu(Request $request)
    {
        $item = MenuItem::find($request->menuid);

        $item->delete();

        return redirect('/vendor-menu');
    }
}
