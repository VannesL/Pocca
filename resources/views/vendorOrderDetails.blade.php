@extends('layout')

@section('content')
    <div class="container">
        <h3 class="">Order for: {{ $order->customer->name }}</h3>
        <h6 class="mb-3">{{ $order->customer->phone_number }}</h6>

        @php
            $color = "";

            switch ($order->status->id) {
            case 1:
                $color = "secondary";
                break;
            case 2:
                $color = "warning";
                break;
            case 3:
                $color = "primary";
                break;
            case 4:
                $color = "success";
                break;
            }
        @endphp
        <div class="d-flex justify-content-between mb-2">
            <div class="text-bg-{{$color}} text-center fs-3 fw-bold px-2">
                {{ $order->status->name }}
            </div>
            <div>
                @if ($order->type)
                    <div class="mt-2">Eat-In</div>
                @else
                    <div class="mt-2">Takeout</div>
                @endif   
            </div>
        </div>
            

        <div class="container p-2 border-dark bg-light">
            <div class="header d-flex justify-content-between px-2 pt-2">
                <div>OrderId: {{ $order->id }}</div>
                <div class="align-items-end">{{ $order->date }}</div>
            </div>
            <hr>
            <table class="table table-borderless">
                <tbody>
                    @foreach ($orderItems as $orderItem)
                    @php
                        $itemName = explode('_',$orderItem->menu->name);
                        $price = $orderItem->quantity * $orderItem->menu->price;
                    @endphp
                    @if ($orderItem->notes != '')
                        <tr class="border-end-0">
                            <td class="col-md-1">{{ $orderItem->quantity }}x</td>
                            <td class="col-md-9">{{ $itemName[1] }}</td>
                            <td class="col-md-2">Rp. {{ $price }}</td>
                        </tr>
                        <tr>
                            <td class="col-md-1"></td>
                            <td class="col-md-9 fst-italic">{{ $orderItem->notes }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="col-md-1">{{ $orderItem->quantity }}x</td>
                            <td class="col-md-9">{{ $itemName[1] }}</td>
                            <td class="col-md-2">Rp. {{ $price }}</td>
                        </tr>
                    @endif              
                @endforeach
                </tbody>
            </table>
            <hr>
            <div class="footer d-flex justify-content-between px-2">
                <div>Total:</div>
                <div class="h4">Rp. {{ $order->total }}</div>
            </div>
        </div>
    </div>
@endsection