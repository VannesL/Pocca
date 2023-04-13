<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
