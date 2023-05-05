@extends('layout')

@push('custom-js')
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset ('js/imagePreviews.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('js/refreshOrderDetails.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <h3 class="">{{ $order->vendor->store_name }}</h3>
        <h6 class="mb-3">{{ $order->vendor->canteen->name }} • {{ $order->vendor->phone_number }}</h6>

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
            <div class="d-flex align-items-center">
                <div id="orderStatus" class="text-bg-{{$color}} text-center fs-3 fw-bold px-2">
                    {{ $order->status->name }}
                </div> 
                <a class="text-decoration-none text-reset ms-2" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-circle-info fa-lg"></i></a>
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
                        $price = $orderItem->quantity * $orderItem->price;
                    @endphp
                    <tr class="border-end-0">
                        <td class="col-md-1">{{ $orderItem->quantity }}x</td>
                        <td class="col-md-9">{{ $itemName[1] }}</td>
                        <td class="col-md-2">{{ rupiah($price ?? '',true) }}</td>
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
                <div class="h4">{{ rupiah($order->total ?? '', true) }}</div>
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
                                <label for="image" class="h5 fw-bold">Proof of Payment</label>
                                <input class="image form-control form-control-sm @error('image') is-invalid @enderror" id="image" name="image" type="file" accept="image/*">
    
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
    
                            <img id="preview-image" src="{{ asset('storage/payments/no-image.jpg') }}" alt="" class="img-thumbnail border-0 mb-4 w-100" style="height: 300px; object-fit:contain;">
                            
                            <button class="btn btn-primary w-100 col m-2 fw-bold" type="submit">Submit Payment</button>   
                        </form>  
                    @else
                        <div id="payed" class="fw-bold text-center mt-3">Waiting for vendor verification...</div>
                    @endif
                    @break
                @case(3)
                    <button href="/order/update-status/{{$order->id}}" class="btn btn-outline-dark fw-bold w-50 mx-auto" disabled>I got my order!</button>
                    @break
                @case(4)
                    <a href="/order/update-status/{{$order->id}}" class="btn btn-success fw-bold w-50 mx-auto" >I got my order!</a>
                    @break
                @case(5)
                    @if ($order->reviewed == false)
                        <a class="btn btn-white border-dark fw-bold w-50 mx-auto"  data-bs-toggle="modal" data-bs-target="#reviewForm" @if ($order->reviewed) disabled @endif>Leave a Review</a>
                    @endif
                    @break
                @case(6)
                    <form>
                        <fieldset disabled>
                            <div class="mb-3">
                            <label for="disabledTextInput" class="form-label fw-bold">Rejected for:</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="{{ $order->rejection_reason }}">
                            </div>
                        </fieldset>
                    </form>
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

            <div class="modal fade bg-transparent" id="reviewForm" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered bg-transparent" style="" role="document">
                    <form method="POST" action="/review/{{$order->id}}" class="modal-content" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewTitle">Write a Review!</h5>
                            <button type="button" class="btn btn-outline-transparent" data-bs-dismiss="modal">
                                <i class="fa fa-times fa-lg" style="color: #f70808;"></i>
                            </button> 
                        </div>
                        <div class="modal-body d-flex justify-content-center flex-column">
                            <div class="rate d-flex justify-content-center mb-3 flex-row-reverse">
                                <input type="radio" id="star5" class="rate" name="rating" value="5" checked/>
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" class="rate" name="rating" value="2">
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                <label for="star1" title="text">1 star</label>
                            </div>

                            <div class="form-outline">
                                <label id="reviewDesc" for="description" class="h6 fw-bold">Comments</label>
                                <textarea id="description" type="textbox" class="form-control form-control-md" name="description" placeholder="ex. Great food!" rows="3" style="resize:none;"></textarea>
                            </div>

                            <div class="form-outline my-4">
                                <label id="imgLabel" for="reviewImg" class="h6 fw-bold">Review Images</label>
                                <input class="reviewImg form-control form-control-sm @error('reviewImg') is-invalid @enderror" id="reviewImg" name="reviewImg[]" type="file" accept="image/*" multiple>
            
                                @error('reviewImg')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="container-fluid">
                                <div id="images" class="overflow-scroll row flex-row flex-nowrap">
                                    <img id="preview-image" src="{{ asset('storage/payments/no-image.jpg') }}" alt="" class="img-thumbnail border-0 mb-4 w-100" style="height: 300px; object-fit:contain;">
                                </div>
                            </div>
                        </div>
                        <input name="vendorid" type="hidden" value="{{$order->vendor->id}}">
                        <div class="modal-footer d-flex justify-content-around">  
                            <button type ="submit" class="btn btn-primary col">
                                Submit
                            </button>
                        </div>
                    </form>
                </div> 
            </div>

            <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                <div class="modal-dialog pt-1" role="document">
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
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset ('css/customerDetail.css') }}">
@endsection