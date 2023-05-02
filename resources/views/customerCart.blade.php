@extends('layout')

@section('content')
    @if (!is_null($cart))    
        <div class="container">
        
            <h1 class="fw-bolder mb-4">Cart Summary</h1>
            <form action="{{ url('/checkout') }}" method="post">
                @csrf
                <div class="d-flex justify-content-between mb-2">
                    <div id="orderStatus" class="align-self-end">
                        <h6>{{ $cart->vendor->canteen->name }}</h6>
                        <h3 class="">{{ $cart->vendor->store_name }}</h3>
                        <h6 class="">{{ $cart->vendor->phone_number }}</h6>
                    </div> 
                    <div class="align-self-end">
                        <select class="form-select form-select-sm" name='type'aria-label="Default select example">
                            <option selected value='1'>Eat-In</option>
                            <option value="0">Takeout</option>
                        </select>
                    </div>
                </div>
                <div class="container p-2 border border-dark bg-light mb-5">
                    <div class="header d-flex justify-content-between px-2 pt-2">
                        <div></div>
                        <div class="align-items-end">{{ $cart->updated_at->toDateString() }}</div>
                    </div>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                            @php
                                $itemName = explode('_',$cartItem->menu->name);
                                $price = $cartItem->quantity * $cartItem->menu->price;
                            @endphp
                            <tr class="border-end-0">
                                <td class="col-md-1">{{ $cartItem->quantity }}x</td>
                                <td class="col-md-9">{{ $itemName[1] }}</td>
                                <td class="col-md-2">Rp. {{ $price }}</td>
                            </tr>
                            @if ($cartItem->notes != '')
                                <tr>
                                    <td class="col-md-1"></td>
                                    <td class="col-md-9 fst-italic pt-0">{{ $cartItem->notes }}</td>
                                </tr>
                            @endif              
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="footer d-flex justify-content-between px-2">
                        <div>Total:</div>
                        <div class="h4">Rp. {{ $cart->total }}</div>
                    </div>
                </div>
                <div class="addBtn text-center position-fixed start-50 translate-middle z-3" style="bottom:20px">
                    <button class="btn rounded btn-primary p-3" type="submit">Confirm Order</button>
                </div>
            </form>
                
        </div>
    @else
    <div class="container h-100">

        <h2 class="position-absolute top-50 start-50 translate-middle text-center">Sorry your cart is still emtpy</h2>
    </div>
    @endif

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
    <script type="text/javascript">    
        function readURL(input) {
            if (input.files && input.files[0] && input.files[0].type) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#preview-image').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#proof").change(function(){
            readURL(this);
        });
    </script> --}}
@endsection