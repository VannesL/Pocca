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
            <form class="form-horizontal" action="" id="addStar" method="POST">
                {{ csrf_field() }}
                <div class="form-group required">
                <div class="col-sm-12">
                    <input class="star star-5" value="5" id="star-5" type="radio" name="star"/>
                    <label class="star star-5" for="star-5"></label>
                    <input class="star star-4" value="4" id="star-4" type="radio" name="star"/>
                    <label class="star star-4" for="star-4"></label>
                    <input class="star star-3" value="3" id="star-3" type="radio" name="star"/>
                    <label class="star star-3" for="star-3"></label>
                    <input class="star star-2" value="2" id="star-2" type="radio" name="star"/>
                    <label class="star star-2" for="star-2"></label>
                    <input class="star star-1" value="1" id="star-1" type="radio" name="star"/>
                    <label class="star star-1" for="star-1"></label>
                    </div>
                </div>
            

                <div class="form-outline mb-4">
                    <label for="proof" class="h5 fw-bold">Review Images (jpg,bmp,png)</label>
                    <input class="proof form-control form-control-sm @error('proof') is-invalid @enderror" id="proof" name="proof" type="file">

                    @error('proof')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </form>

            <img id="preview-image" src="{{ asset('storage/payments/no-image.jpg') }}" alt="" class="img-thumbnail border-0 mb-4 w-100" style="height: 300px; object-fit:contain;">
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

        $('#addStar').change('.star', function(e) {
            $(this).submit();
        });
    </script>
@endsection