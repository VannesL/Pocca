<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function vendorOrder(Request $request)
    {
        $orders = Order::where([
            ['vendor_id', auth()->guard('vendor')->user()->id],
            ['status_id', '<', 5],
        ])->orderBy('status_id', 'asc')->orderBy('created_at', 'asc')->get();

        $statuses = Status::all();

        $data = [
            'orders' => $orders,
            'statuses' => $statuses,
        ];

        return view('vendorOrder', $data);
    }

    public function refreshOrderPage(Request $request)
    {
        $orders = Order::where([
            ['vendor_id', auth()->guard('vendor')->user()->id],
            ['status_id', '<', 5],
        ])->get();

        if ($orders->count() > $request->count) {
            return true;
        }

        $order = $orders->find($request->orderId);
        $newUpdate = Carbon::parse($order->updated_at)->format('Y-m-d-H-i-s');

        if ($newUpdate > $request->datetime) {
            return true;
        };

        return false;
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

        $statuses = Status::all();

        $data = [
            'order' => $order,
            'orderItems' => $orderItems,
            'statuses' => $statuses,
        ];

        if (auth()->guard('customer')->check()) {
            return view('Customer/customerOrderDetails', $data);
        } else {
            // dd($order->status_id);
            return view('vendorOrderDetails', $data);
        }
    }

    public function refreshOrderDetails(Request $request)
    {
        $order = Order::where([
            ['id', $request->orderid],
        ])->get()->first();

        $newUpdate = Carbon::parse($order->updated_at)->format('Y-m-d-H-i-s');

        if ($newUpdate > $request->update) {
            return true;
        };

        return false;
    }

    public function orderUpdateStatus(Request $request)
    {
        $order = Order::where([
            ['id', $request->orderid],
        ])->get()->first();

        if ($order->status_id < 5) {
            $order->status_id = $order->status_id + 1;
        }

        if ($order->status_id == 4) {
            $order->finish_time = Carbon::now()->addMinutes(15);
        }

        $order->save();

        return redirect('/order/' . $order->id);
    }

    public function customerOrder(Request $request)
    {
        $orders = Order::where([
            ['customer_id', auth()->guard('customer')->user()->id],
            ['status_id', '<', 5],
        ])->orderBy('status_id', 'asc')->orderBy('created_at', 'asc')->get();

        $data = [
            'orders' => $orders,
        ];

        return view('Customer/customerOrder', $data);
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

        return view('Customer/customerOrderHistory', $data);
    }

    public function orderPayment(Request $request)
    {
        Validator::make($request->all(), [
            'image'             => ['required', 'mimes:jpg,bmp,png'],
        ])->validate();

        $order = Order::where('id', $request->orderid)->get()->first();

        $ext = $request->file('image')->extension();
        $imgName = md5($request->image);
        $order->payment_image = "payment_" . $order->id . "_" . $imgName . "." . $ext;

        $image = $request->file('image');
        Storage::putFileAs('public/payments', $image, "payment_" . $order->id . "_" . $imgName . "." . $ext);

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
