<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        // dd($request);
        $user = auth()->guard('vendor')->user();

        Validator::make($request->all(), [
            'name'              => ['required', 'string', Rule::unique('categories')->where(function ($query) use ($user) {
                return $query->where('vendor_id', $user->id)->orWhere('vendor_id', null);
            })]
        ])->validate();

        $category = new Category();
        $category->name = $request->name;
        $category->vendor_id = $user->id;
        $category->save();
        return redirect('/vendor-menu');
    }

    public function deleteCategory(Request $request, Category $category)
    {
        $message = $category->name . ' category has been deleted successfully';

        $user = auth()->guard('vendor')->user();
        $menus = MenuItem::where('category_id', $category->id)
            ->update(['category_id' => $request->selectCategory]);
        $category->delete();
        return redirect('/vendor-menu')->with('Success', $message);
    }
}
