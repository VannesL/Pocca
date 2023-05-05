@extends('layout')

@push('custom-js')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset ('js/updateOrderPage.js') }}"></script>
@endpush

@section('content')    
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Current Orders</h3>
            <a class="text-decoration-none text-reset" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-circle-info fa-lg"></i></a>
        </div>
        
        @php
            $guard = "vendor";
            $updateArr = array();
            $orderArr = array();
            $totalOrders = $orders->count();
        @endphp

        <div class="row">
            @if (!$orders->isEmpty())
                @foreach ($orders as $order)
                    @php
                        $updateTime = \Carbon\Carbon::parse($order->updated_at)->format('Y-m-d-H-i-s');
                        array_push($updateArr, $updateTime);
                        array_push($orderArr, $order->id);
                    @endphp
                    @if ($order->status_id == 1)  
                        <a id="{{$loop->index}}" href="/order/{{$order->id}}" class="text-decoration-none text-dark"> 
                            <div class="card mb-3 text-bg-light border-danger border-3 border-bg" style="box-shadow: 0px 2px 10px 2px #8b9ce956;">
                                <span class="position-absolute top-100 start-50 translate-middle badge rounded-pill bg-danger">
                                    NEW
                                </span>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Order for: {{ $order->customer->name }}</h5>
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
                            </div>
                        </a>
                    @endif
                @endforeach
                @foreach ($orders as $order)
                    @if ($order->status_id != 1)
                        <a href="/order/{{$order->id}}" class="text-decoration-none">
                            <div class="card mb-3 text-bg-light border-light" style="box-shadow: 0px 2px 10px 2px #8b9ce956;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Order for: {{ $order->customer->name }}</h5>
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

                                    switch ($order->status_id) {
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
                    @endif
                @endforeach
                <!-- Modal -->
                <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                    <div class="modal-dialog pt-2" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModalLabel">Types of Order Status!</h5>
                                <a data-bs-dismiss="modal" class="">
                                    <i class="fa fa-times fa-lg" style="color: #f70808;"></i>
                                </a>
                            </div>
                            <div class="modal-body">
                                @foreach ($statuses as $status)
                                    @php
                                        $color = "";

                                        switch ($status->id) {
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
                                        case 5:
                                            $color = "dark";
                                            break;
                                        case 6:
                                            $color = "danger";
                                            break;
                                        }
                                    @endphp
                                    <div class="mb-2">
                                        <div id="orderStatus" class="text-bg-{{$color}} text-center fs-4 fw-bold px-2 py-1">
                                            {{ $status->name }}
                                        </div> 
                                        <h6 class="px-2 mt-2 mb-4">{{ $status->description }}</h6>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h2 class="mt-4 text-center text-wrap">There are no orders yet, check again later!</h2>
            @endif

            <script>
                var guard = @json($guard);
                var updateArr = @json($updateArr);
                var orderArr = @json($orderArr);
                var totalOrders = @json($totalOrders);
            </script>
        </div>
    </div>
@endsection