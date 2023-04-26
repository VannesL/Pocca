<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;

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

        return redirect('/vendor-order/' . $order->id);
    }

    public function vendorOrderHistory(Request $request)
    {
        $orders = Order::where([
            ['vendor_id', auth()->guard('vendor')->user()->id],
            ['status_id', 5],
        ])->get();

        $data = [
            'orders' => $orders,
        ];

        return view('vendorOrderHistory', $data);
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
            ['status_id', 5],
        ])->get();

        $data = [
            'orders' => $orders,
        ];

        return view('customerOrderHistory', $data);
    }
}
