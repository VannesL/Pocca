@extends('layout')

{{-- @push('custom-js')
    <script type="text/javascript" src="{{ asset ('js/refreshOrderDetails.js') }}"></script>
@endpush --}}

@section('content')
    <div class="container">
        <h6>{{ $order->vendor->canteen->name }}</h6>
        <h3 class="">{{ $order->vendor->store_name }}</h3>
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
            @endif

            @switch($order->status->id)
                @case(1)
                    <div class="fw-bold text-center mt-3">Waiting for vendor confirmation...</div>
                    @break
                @case(2)
                    @if ($order->payment_image == '')
                        <form method="POST" action="{{ url('/order/customer/payment/'.$order->id) }}" enctype="multipart/form-data">
                        @csrf
                            <img src="{{ asset('storage/qris/'.$order->vendor->qris) }}" alt="qris not found" class="img-thumbnail border-0 mb-4 w-100" style="height: 300px; object-fit:contain;" data-bs-toggle="modal" data-bs-target="#imgPreview">
    
                            <div class="form-outline mb-4">
                                <label for="proof" class="h5 fw-bold">Proof of Payment (jpg,bmp,png)</label>
                                <input class="proof form-control form-control-sm @error('proof') is-invalid @enderror" id="proof" name="proof" type="file">
    
                                @error('proof')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
    
                            <img id="preview-image" src="{{ asset('storage/payments/no-image.jpg') }}" alt="" class="img-thumbnail border-0 mb-4 w-100" style="height: 300px; object-fit:contain;">
                            
                            <button class="btn btn-primary w-100 col m-2 fw-bold" type="submit">Submit Payment</button>   
                        </form>  
                    @else
                        <div class="fw-bold text-center mt-3">Waiting for vendor verification...</div>
                    @endif
                    @break
                @case(3)
                    <div class="fw-bold text-center">Making your food...</div>
                    @break
                @case(4)
                    <a href="/order/update-status/{{$order->id}}" class="btn btn-success fw-bold w-50 mx-auto" p->I got my order!</a>
                    @break
            @endswitch

            <!-- Modal -->
            <div class="modal fade bg-transparent" id="imgPreview" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered bg-transparent" style="" role="document">
                    <div class="modal-body bg-transparent">
                        @if ($order->status_id != 2) 
                            <img src="{{ asset('storage/payments/'.$order->payment_image) }}" class="img-thumbnail border-0 mb-4 w-100 h-100" alt="image error" style="object-fit:contain;">
                        @else
                            <img src="{{ asset('storage/qris/'.$order->vendor->qris) }}" class="img-thumbnail border-0 mb-4 w-100 h-100" alt="image error" style="object-fit:contain;">
                        @endif
                       
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 
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
    </script>
@endsection