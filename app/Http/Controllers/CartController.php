<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
        $cartItem->notes = $request->notes;
        $cartItem->save();
        //calulate total for cart
        $cart->total += ($request->quantity*$menuitem->price);
        $cart->save();

    }
}
