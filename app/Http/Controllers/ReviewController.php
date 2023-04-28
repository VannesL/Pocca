<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpg,bmp,png'],
        ])->validate();

        $review = Review::make();
        $review->order_id = $request->orderid;
        $review->vendor_id = $request->vendorid;
        $review->date = Carbon::now();
        $review->rating = $request->rating;
        $review->description = $request->description;
        $review->save();

        foreach ($request->reviewImg as $key => $value) {
            $reviewImage = ReviewImage::make();
        }

        $order = Order::where('id', $request->orderid)->get()->first();
        $order->reviewed = true;
        $order->save();

        return redirect('/order/' . $request->orderid);
    }
}
