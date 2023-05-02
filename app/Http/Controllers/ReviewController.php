<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function createReview(Request $request)
    {
        $review = Review::make();
        $review->order_id = $request->orderid;
        $review->vendor_id = $request->vendorid;
        $review->date = Carbon::now();
        $review->rating = $request->rating;
        if ($request->description) {
            $review->description = $request->description;
        } else {
            $review->description = "";
        }
        $review->save();

        $order = Order::where('id', $request->orderid)->get()->first();
        $order->reviewed = true;
        $order->save();

        $count = 1;
        if ($request->hasFile('reviewImg')) {
            foreach ($request->file('reviewImg') as $img) {
                $reviewImage = ReviewImage::make();
                $reviewImage->review_id = $review->id;

                //save img
                $imgName = $img->getClientOriginalName();
                $reviewImage->path = 'review_' . $review->id . '_' . $count . '_' . $imgName;

                $count = $count + 1;
                Storage::putFileAs('public/reviews', $img, 'review_' . $review->id . '_' . $count . '_' . $imgName);

                $reviewImage->save();
            }
        }


        return redirect('/order/' . $request->orderid);
    }
}
