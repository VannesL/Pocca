@extends('layout')

@push('custom-js')
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset ('js/inputNumberWithButton.js') }}"></script>
@endpush

@section('content')
    @if (!is_null($cart))    
        <div class="container">
            <div class="d-flex justify-content-between mb-2">
                <div id="orderStatus" class="align-self-end">
                    <h6>{{ $cart->vendor->canteen->name }}</h6>
                    <h3 class="">{{ $cart->vendor->store_name }}</h3>
                    <h6 class="mb-0">{{ $cart->vendor->phone_number }}</h6>         
                </div> 
                <div class="align-self-end fw-medium">
                    {{ $cart->updated_at->toDateString() }}
                </div>
            </div>
            <div class="container p-2 border border-dark bg-light mb-3">
                <div class="header text-center px-2 pt-2">
                    <h4>Cart Summary</h4>
                </div>
                <hr>
                <table class="table table-borderless">
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                        @php
                            $itemName = explode('_',$cartItem->menu->name);
                            $price = $cartItem->quantity * $cartItem->menu->price;
                        @endphp
                        <tr class="border-end-0" data-bs-toggle="modal" data-bs-target="#{{$cartItem->menu->id}}addToCart">
                            <td class="col-1">{{ $cartItem->quantity }}x</td>
                            <td class="col-6">{{ $itemName[1] }}</td>
                            <td class="col-4">{{ rupiah($price ?? '',true) }}</td>
                            <td class="col-1"><i class="fa-solid fa-pen-to-square"></i></button></td>
                        </tr>
                            
                        @if ($cartItem->notes != '')
                            <tr data-bs-toggle="modal" data-bs-target="#{{$cartItem->menu->id}}addToCart">
                                <td class="col-md-1"></td>
                                <td class="col-md-11 fst-italic pt-0">{{ $cartItem->notes }}</td>
                            </tr>
                        @endif     

                        <!-- Modal -->
                        <div class="modal fade" id="{{$cartItem->menu->id}}addToCart" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class=" z-3 modal-dialog position-absolute  mb-0 start-0 end-0 bottom-0" style="max-height: 90%" role="document">
                                
                                <div class="modal-content" style="">
                                    <div class="container">
                                        <div class="row">
                                            <a class="btn btn-plus rounded-0 btn-danger" data-bs-dismiss="modal">
                                                <i class="fa-solid fa-times"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="modal-header">
                                        @if ($cartItem->menu->image != '')
                                            <img src="{{ asset('storage/menus/'.$cartItem->menu->image) }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$cartItem->menu->availability) opacity-50 @endif" alt="image error" style="" >
                                        @else
                                            <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$cartItem->menu->availability) opacity-50 @endif" alt="image error" style="" >
                                        @endif
                                    </div>
                                
                                    <div class="modal-body">     
                                        <div class="row px-2">
                                            <div class="col-8">
                                                <h5 class="text-break">{{$itemName[1]}}</h5>
                                                
                                            </div>
                                            <div class="col-4 text-end fw-medium"> 
                                                <p> <i class="fa-solid fa-hourglass-end me-1"></i> {{$cartItem->menu->cook_time}}  <span class="">min</span></p>
                                                
                                            </div>
                                        </div>
                                        <div class="row px-3"> 
                                            <p>{{$cartItem->menu->description}}</p>
                                        </div>
                                        <div class="row px-3 d-flex align-items-center flex-column">
                                            <form action="{{ url('update-cart/'.$cartItem->id) }}" method="post" class="form-loading mb-3">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="notes" class="form-label fw-medium" >Notes</label>
                                                    <textarea class="form-control" id="notes" name='notes' rows="3" placeholder="ex. Make it good!">{{ $cartItem->notes }}</textarea>
                                                </div>
                                                <div class="row mb-4 d-flex align-items-center">
                                                    <div class="col-6 fw-medium h4 mb-0">
                                                        {{rupiah($cartItem->menu->price ?? '',true)}}
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="input-group inline-group">
                                                            <div class="input-group-prepend">
                                                            <a class="btn btn-minus rounded-0 btn-secondary">
                                                                <i class="fa fa-minus"></i>
                                                            </a>
                                                            </div>
                                                            <input class="form-control quantity" min="1" name="quantity" value="{{$cartItem->quantity}}" type="number">
                                                            <div class="input-group-append">
                                                            <a class="btn btn-plus rounded-0 btn-secondary">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @if ($cartItem)
                                                        <div class="d-flex justify-content-around">
                                                            <a href="{{ url('remove-item/'.$cartItem->id) }}" class="btn btn-danger w-50 me-1">Remove Item</a>
                                                            <button class="btn btn-primary w-50 ms-1" type="submit">Update Item</button>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-primary w-100" type="submit">Save Changes</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    @endforeach
                        <tr>
                            <td colspan="4" class="text-center">
                                <a class="text-decoration-none fw-medium btn btn-outline-dark mt-2 w-100" href="{{ url('home/'.$cart->vendor->canteen->id.'/'.$cart->vendor->id ) }}">
                                    Add More <i class="fa-solid fa-plus"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class="footer d-flex justify-content-between px-2">
                    <div>Total:</div>
                    <div class="h4">{{ rupiah($cart->total ?? '',true) }}</div>
                </div>
            </div>
            <form action="{{ url('/checkout') }}" method="post">
                @csrf
                <div class="mb-5">
                    <select class="form-select form-select-sm" name='type'aria-label="Default select example">
                        <option selected value='1'>Eat-In</option>
                        <option value="0">Takeout</option>
                    </select>
                </div>
                <button class="btn rounded btn-primary w-100 ms-1 py-2 fw-medium" type="submit">Confirm Order</button>
            </form>
                
        </div>
    @else
    <div class="container h-100">

        <h2 class="position-absolute top-50 start-50 translate-middle text-center">Sorry your cart is still emtpy</h2>
    </div>
    @endif
@endsection