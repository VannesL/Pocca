<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function showForm(Request $request)
    {
        $order = Order::where('id', $request->orderid)->get()->first();

        $data = [
            'order' => $order,
        ];
        return view('reviewForm', $data);
    }
}
