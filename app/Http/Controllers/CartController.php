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
    public function addToCart(Request $request, Vendor $vendor, MenuItem $menuitem)
    {
        $user = auth()->guard('customer')->user();
        $cart = Cart::where('customer_id', $user->id)->first();
        if (!is_null($cart) && $cart->vendor_id != $vendor->id) {
            $cartItem = CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
        }

        if (is_null($cart)) {
            $cart = new Cart();
            $cart->vendor_id = $vendor->id;
            $cart->customer_id =  $user->id;
            $cart->total = 0;
            $cart->save();
        }

        $cartItem = CartItem::where([
            ['menu_id', $menuitem->id],
            ['cart_id', $cart->id],
        ])->get()->first();

        if (!$cartItem) {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->menu_id = $menuitem->id;
            //calulate total for cart
            $cart->total += ($request->quantity * $menuitem->price);
            $cart->save();
        } else {
            //calulate total for cart when cart exists
            $diff = $request->quantity - $cartItem->quantity;
            $cart->total = $cart->total + ($diff * $cartItem->menu->price);
            $cart->save();
        }

        $cartItem->quantity = $request->quantity;

        if (is_null($request->notes)) {
            $cartItem->notes = null;
        } else {
            $cartItem->notes = $request->notes;
        }
        $cartItem->save();


        return redirect('/home/' . $vendor->canteen->id . '/' . $vendor->id);
    }

    public function updateCart(Request $request)
    {
        $cartItem = CartItem::where('id', $request->cartItemid)->get()->first();
        $cart = Cart::where('id', $cartItem->cart_id)->get()->first();

        $diff = $request->quantity - $cartItem->quantity;
        $cart->total = $cart->total + ($diff * $cartItem->menu->price);
        $cart->save();

        $cartItem->notes = $request->notes;
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect('/customer-cart');
    }

    public function removeCartItem(Request $request)
    {
        $cartItem = CartItem::where('id', $request->cartItemid)->get()->first();
        $cart = Cart::where('id', $cartItem->cart_id)->get()->first();

        $cart->total = $cart->total - $cartItem->menu->price * $cartItem->quantity;
        $cart->save();

        $cartItem->delete();

        $cartItem = CartItem::where('cart_id', $cart->id)->get()->first();
        if (is_null($cartItem)) {
            $cart->delete();
        }
        return back();
    }

    public function cartPage()
    {
        $user = auth()->guard('customer')->user();

        $cart = Cart::where('customer_id', $user->id)->first();
        if (!is_null($cart)) {
            $cartItems = CartItem::where('cart_id', $cart->id)->get();

            return view('Customer/customerCart', ['cart' => $cart, 'cartItems' => $cartItems]);
        }
        return view('Customer/customerCart', ['cart' => $cart]);
    }

    public function checkout(Request $request)
    {
        $user = auth()->guard('customer')->user();
        // dd($request->type);
        $cart = Cart::where('customer_id', $user->id)->first();
        if ($cart) {
            $order = new Order();
            $order->customer_id = $cart->customer_id;
            $order->vendor_id = $cart->vendor_id;
            $order->total = $cart->total;
            $order->status_id = 1;
            $order->date = Carbon::now();
            $order->type = $request->type;
            $order->rejection_reason = null;
            $order->payment_image = "";
            $order->save();

            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItems();
                $orderItem->menu_id = $cartItem->menu_id;
                $orderItem->price = $orderItem->menu->price;
                $orderItem->order_id = $order->id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->notes = $cartItem->notes;
                $orderItem->save();
            }

            $cartItem = CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
            return redirect('/order/' . $order->id);
        }
        return redirect()->back();
    }
}
