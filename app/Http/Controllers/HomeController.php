<?php

namespace App\Http\Controllers;

use App\Models\Canteen;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){

        $canteens = Canteen::all();
        if ($request->search) {
            // dump($request->search);
            $canteens = Canteen::where('name', 'LIKE', '%' . $request->search . '%')->get();
            // dd($canteens);
        }
        return view('home', ['canteens' => $canteens, 'search' => $request->search]);
    }
}
