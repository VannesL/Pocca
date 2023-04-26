@extends('layout')

@section('content')    
    <div class="container">
        <h3>Current Orders</h3>
        <div class="row">
            @if (!$orders->isEmpty())
                @foreach ($orders as $order)
                <a href="/order/{{$order->id}}" class="text-decoration-none">
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
                                @if ($order->type)
                                    <div class="mt-2">Type: Eat-In</div>
                                @else
                                    <div class="mt-2">Type: Takeout</div>
                                @endif   
                            </div>
                        </div>
                        @php
                            $color = "";

                            switch ($order->status->id) {
                            case 1:
                                $color = "warning";
                                break;
                            case 2:
                                $color = "secondary";
                                break;
                            case 3:
                                $color = "primary";
                                break;
                            case 4:
                                $color = "success";
                                break;
                            }
                        @endphp
                        <div class="card-footer text-bg-{{$color}} text-center fw-bold">
                            {{ $order->status->name }}
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <h2 class="mt-4 text-center text-wrap">There are no orders yet, check again later!</h2>
            @endif
        </div>
    </div>
@endsection