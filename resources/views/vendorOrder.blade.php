@extends('layout')

@section('content')    
    <div class="container">
        <h3>Current Orders</h3>
        <div class="row">
            @if (!$orders->isEmpty())
                @foreach ($orders as $order)
                    @if ($order->status_id == 1)  
                        <a href="/order/{{$order->id}}" class="text-decoration-none text-dark"> 
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
                                {{-- <div class="card-footer text-bg-warning text-center fw-bold">
                                    {{ $order->status->name }}
                                </div> --}}
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
                <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="" role="document">
                    <form method="POST" action="/order/vendor/delete/{{$order->id}}" class="modal-content">
                        @csrf
                        <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationLabel">Please enter rejection reason:</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-outline">
                                <textarea id="reason" type="textbox" class="form-control form-control-md" name="reason" placeholder="ex. Out of ingredients, fake payment..." rows="3" style="resize:none;"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around">  
                            <button type ="submit" class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">
                                Submit
                            </button>
                            <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">Cancel</button> 
                        </div>
                    </form>
                    </div> 
                </div>
            @else
                <h2 class="mt-4 text-center text-wrap">There are no orders yet, check again later!</h2>
            @endif
        </div>
    </div>
@endsection