<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function vendorOrder(Request $request)
    {
        $orders = Order::where([
            ['vendor_id', auth()->guard('vendor')->user()->id],
            ['status_id', '<>', 5],
        ])->get();

        $data = [
            'orders' => $orders,
        ];

        return view('vendorOrder', $data);
    }

    public function vendorOrderHistory(Request $request)
    {
        $orders = Order::where([
            ['vendor_id', auth()->guard('vendor')->user()->id],
            ['status_id', '>=',  5],
        ])->orderBy('created_at', 'desc')->get();

        $data = [
            'orders' => $orders,
        ];

        return view('vendorOrderHistory', $data);
    }

    public function orderDetails(Request $request)
    {
        $order = Order::where([
            ['id', $request->orderid],
        ])->get()->first();

        $orderItems = OrderItems::where([
            ['order_id', $request->orderid],
        ])->get();

        $data = [
            'order' => $order,
            'orderItems' => $orderItems
        ];

        if (auth()->guard('customer')->check()) {
            return view('customerOrderDetails', $data);
        } else {
            return view('vendorOrderDetails', $data);
        }
    }

    public function orderUpdateStatus(Request $request)
    {
        $order = Order::where([
            ['id', $request->orderid],
        ])->get()->first();

        $order->status_id = $order->status_id + 1;
        $order->save();

        return redirect('/order/' . $order->id);
    }

    public function customerOrder(Request $request)
    {
        $orders = Order::where([
            ['customer_id', auth()->guard('customer')->user()->id],
            ['status_id', '<>', 5],
        ])->get();

        $data = [
            'orders' => $orders,
        ];

        return view('customerOrder', $data);
    }

    public function customerOrderHistory(Request $request)
    {
        $orders = Order::where([
            ['customer_id', auth()->guard('customer')->user()->id],
            ['status_id', '>=', 5],
        ])->orderBy('created_at', 'desc')->get();

        $data = [
            'orders' => $orders,
        ];

        return view('customerOrderHistory', $data);
    }

    public function orderPayment(Request $request)
    {
        Validator::make($request->all(), [
            'proof'             => ['required', 'mimes:jpg,bmp,png'],
        ])->validate();

        $order = Order::where('id', $request->orderid)->get()->first();

        $ext = $request->file('proof')->extension();
        $imgName = md5($request->proof);
        $order->payment_image = "payment_" . $order->id . "_" . $imgName . $ext;

        $image = $request->file('proof');
        Storage::putFileAs('public/payments', $image, "payment_" . $order->id . "_" . $imgName . $ext);

        $order->save();

        return redirect('/order/' . $request->orderid);
    }

    public function rejectOrder(Request $request)
    {
        Validator::make($request->all(), [
            'reason'             => ['required', 'string'],
        ])->validate();

        $order = Order::where([
            ['id', $request->orderid],
        ])->get()->first();

        $order->status_id = 6;
        $order->rejection_reason = $request->reason;
        $order->save();

        return redirect('/order/' . $order->id);
    }
}
