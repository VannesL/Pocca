@extends('layout')

@section('content')    
    <div class="container">
        <h3>Order History</h3>
        <div class="row">
            @if (!$orders->isEmpty())
                @foreach ($orders as $order)
                <a href="{{ url('/order/'.$order->id) }}" class="text-decoration-none">
                    <div class="card mb-3 text-bg-light border-light" style="box-shadow: 0px 2px 10px 2px #8b9ce956;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $order->vendor->store_name }}</h5>
                            <div class="row card-text w-100">
                                @foreach ($order->orderItems as $orderItem)
                                    @php
                                        $itemName = explode('_',$orderItem->menu->name)
                                    @endphp
                                    <div class="col-2">{{ $orderItem->quantity }}x</div>
                                    @if ($orderItem->notes != '')
                                        <div class="col-9">
                                            <div>{{ $itemName[1] }}</div>
                                            <div class="fst-italic">{{ $orderItem->notes }}</div>
                                        </div>
                                    @else
                                        <div class="col-9">{{ $itemName[1] }}</div>
                                    @endif
                                @endforeach  
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                @if ($order->type)
                                    <div class="">Type: Eat-In</div>
                                @else
                                    <div class="">Type: Takeout</div>
                                @endif 
                                <div class="">{{ $order->date }}</div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="container d-flex align-items-center justify-content-center" style="height: 50vh">
                    <h2 class="text-center text-wrap">There are no orders yet, check again later!</h2>
                </div>
            @endif
        </div>
    </div>
@endsection