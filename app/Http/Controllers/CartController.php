<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class CartController extends Controller
{
    public function addToCart(Request $request, Vendor $vendor, MenuItem $menuitem){
        $user = auth()->guard('customer')->user();
        $cart = Cart::where('customer_id',$user->id)->first();
        // dd($request);
        if (!is_null($cart) && $cart->vendor_id != $vendor->id) {
            $cartItem = CartItem::where('cart_id',$cart->id)->delete();
            $cart->delete();
        }

        if (is_null($cart)) {
            $cart = new Cart();
            $cart->vendor_id = $vendor->id;
            $cart->customer_id =  $user->id;
            $cart->total = 0;
            $cart->save();
        }
            
        $cartItem = new CartItem();
        $cartItem->cart_id = $cart->id;
        $cartItem->menu_id = $menuitem->id;
        $cartItem->quantity = $request->quantity;
        if (is_null($request->notes)) {
            $cartItem->notes = '';
        }else{
            $cartItem->notes = $request->notes;
        }
        $cartItem->save();
        //calulate total for cart
        $cart->total += ($request->quantity*$menuitem->price);
        $cart->save();

        return redirect('/vendor/'.$vendor->id);

    }

    public function cartPage(){
        $user = auth()->guard('customer')->user();
        
        $cart = Cart::where('customer_id',$user->id)->first();
        if (!is_null($cart)) {
            $cartItems = CartItem::where('cart_id',$cart->id)->get();
    
            return view('customerCart',['cart'=>$cart, 'cartItems'=>$cartItems]);
        }
        return view('customerCart',['cart'=>$cart]);
    }

    public function checkout(Request $request){
        $user = auth()->guard('customer')->user();
        // dd($request->type);
        $cart = Cart::where('customer_id',$user->id)->first();
        $order = new Order();
        $order->customer_id = $cart->customer_id;
        $order->vendor_id = $cart->vendor_id;
        $order->total = $cart->total;
        $order->status_id = 1;
        $order->date = Carbon::now();
        $order->type = $request->type;
        $order->save();

        $cartItems = CartItem::where('cart_id',$cart->id)->get();
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItems();
            $orderItem->order_id = $order->id;
            $orderItem->menu_id = $cartItem->menu_id;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->notes = $cartItem->notes;
            $orderItem->save();
        }
        
        $cartItem = CartItem::where('cart_id',$cart->id)->delete();
        $cart->delete();
        dd($order);
    }
}
