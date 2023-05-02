@extends('layout')

@push('custom-js')
  <script type="text/javascript" src="{{ asset ('js/refreshOrderDetails.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        @error('reason')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror

        <h3 class="">Order for: {{ $order->customer->name }}</h3>
        <h6 class="mb-3">{{ $order->customer->phone_number }}</h6>

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
            case 5:
                $color = "dark";
                break;
            case 6:
                $color = "danger";
                break;
            }
        @endphp
        <div class="d-flex justify-content-between mb-2">
            <div id="orderStatus" class="text-bg-{{$color}} text-center fs-3 fw-bold px-2">
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
            

        <div class="container p-2 border border-dark bg-light">
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
                    <tr class="border-end-0">
                        <td class="col-md-1">{{ $orderItem->quantity }}x</td>
                        <td class="col-md-9">{{ $itemName[1] }}</td>
                        <td class="col-md-2">Rp. {{ $price }}</td>
                    </tr>
                    @if ($orderItem->notes != '')
                        <tr>
                            <td class="col-md-1"></td>
                            <td class="col-md-9 fst-italic pt-0">{{ $orderItem->notes }}</td>
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

        <div class=" container d-flex my-3 h-100 flex-column">
            @if ($order->payment_image != '')
                <img id = "paymentImg" src="{{ asset('storage/payments/'.$order->payment_image) }}" class="img-thumbnail border-0 mb-4 w-100" alt="image error" style="height: 250px; object-fit:contain;" data-bs-toggle="modal" data-bs-target="#imgPreview">
                <!-- Modal -->
                <div class="modal fade bg-transparent" id="imgPreview" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered bg-transparent" style="" role="document">
                        <div class="modal-body bg-transparent">
                            <img id = "paymentImg" src="{{ asset('storage/payments/'.$order->payment_image) }}" class="img-thumbnail border-0 mb-4 w-100 h-100" alt="image error" style="object-fit:contain;">
                        </div>
                    </div> 
                </div>
            @endif

            @switch($order->status->id)
                @case(1)
                    <div class="d-flex justify-content-around fw-bold w-100 mx-auto mt-2">
                        <a class="btn btn-danger w-50 me-1" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Reject</a>
                        <a href="/order/update-status/{{$order->id}}" class="btn btn-primary w-50 ms-1">Approve</a>
                    </div>
                    @break
                @case(2)
                    @if ($order->payment_image != '')
                        <div class="d-flex justify-content-around fw-bold w-75 mx-auto">
                            <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Reject</a>
                            <a href="/order/update-status/{{$order->id}}" class="btn btn-primary">Approve</a>
                        </div> 
                    @else
                    <div class="fw-bold text-center">Waiting for customer payment...</div>
                    @endif

                    @break
                @case(3)
                    <a href="/order/update-status/{{$order->id}}" class="btn btn-success fw-bold w-50 mx-auto">Finish Cooking</a>
                    @break
                @case(4)
                    <div class="fw-bold text-center">Waiting for customer pickup...</div>
                    @break
            @endswitch
            <!-- Modal -->
            <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="" role="document">
                <form method="POST" action="/order/reject/{{$order->id}}" class="modal-content">
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
        </div>
    </div>
@endsection