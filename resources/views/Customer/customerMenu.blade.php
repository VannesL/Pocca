@extends('layout')

@push('custom-js')
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset ('js/inputNumberWithButton.js') }}"></script>
@endpush

@section('content')
    @if ($cartItems->count()>0)    
        <div class="addBtn text-center position-fixed z-3" style="bottom:20px; right:20px;">
            <a href="{{ url('/customer-cart') }}" class="btn rounded btn-primary p-3">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{$cartItems->count()}}
                    <span class="visually-hidden">number of items</span>
                </span>
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    @endif
    <div class="container position-relative">
        {{-- Vendor Header Design --}}
        <div class="container mb-4 text-light rounded" style="background-image: url({{ asset('storage/profiles/'.$vendor->image) }}); background-size: cover;">
            <div class="row rounded p-3" style="background-color: rgba(0, 0, 0, 0.603); backdrop-filter: blur(1px);">
                <div class="col-10">
                    <div class="row"> <h4>{{$vendor->name}}</h4></div>
                    <div class="row"> <p>{{$vendor->description}}</p></div>
                    <div class="row "> 
                        <div class="col-3"><i class="fa-solid fa-star me-1"></i>{{$rating}}</div>
                        <div class="col-9 ">{{$vendor->priceRange->value}}</div>
                    </div>
                </div>
                {{-- Add favorite function --}}
                <div class="col-2 align-self-center text-center">
                    <i class="fa fa-heart fa-2xl"></i>
                </div>
            </div>
        </div>
        <form action="{{ url('/vendor',$vendor->id) }}" method="get" class="form-loading mb-3">
            @csrf
            <div class="row">
                <div class="col-10 ">
                    <div class="form-group @error('search') has-error @enderror">
                        <input name="search" type="text" value="{{ $search }}" class="form-control"
                            placeholder="Search">
                        @error('search')
                            <span class="form-text m-b-none text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-2 ps-1">
                    <button type="submit" class="btn btn-primary btn-block btn_submit text"><i
                            class="fa fa-search"></i></button>
                </div>
            </div>
            </div>
        </form>
        <div class="row px-3">
            @if (!$categories->isEmpty())
                @foreach ($menuByCat as $cat)
                    <div class="accordion accordion-flush mb-4" id="accordion{{$loop->index}}">
                        <div class="accordion-item ">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#{{$categories[$loop->index]->category_name}}" aria-expanded="true" aria-controls="collapseOne">
                                    {{$categories[$loop->index]->category_name}}
                                </button>
                            </h2>
                            <div id="{{$categories[$loop->index]->category_name}}" class="accordion-collapse collapse show " data-bs-parent="#accordion{{$loop->index}}">
                                <div class="accordion-body row">
                                    @foreach ($cat as $item)
                                        @php
                                            $itemName = explode('_',$item->name);

                                            $cartItemId = null;
                                            $notes = null;
                                            $quantity = 0;
                                            if ($cartItems) {
                                                foreach($cartItems as $cartItem) {
                                                    if ($item->id == $cartItem->menu_id){
                                                        $cartItemId = $cartItem->id;
                                                        $quantity = $cartItem->quantity;
                                                        if ($notes !== "") {
                                                            $notes = $cartItem->notes;
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if ($loop->index%2 ==0)
                                            <div class="col-md-4">
                                                <div class="row h-100">

                                        @endif
                                       
                                        <div class="col-6 p-1">
                                            @if ($item->availability)
                                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#{{$item->id}}addToCart" href="">
                                            @endif
                                                <div class="card  text-center h-100 border-white {{$item->availability? '' : 'opacity-25'}}" style="box-shadow: 0px 2px 10px 2px #8b9ce936;">
                                                    @if ($item->recommended)
                                                    <span class="z-2 d-flex position-absolute translate-middle badge rounded-pill bg-warning text-center align-items-center" style="width:30px; height:30px; left:95%; top:5%;vertical-align: middle">
                                                        <i class="fa-solid fa-thumbs-up fa-lg" style="color: #ffffff;"></i>
                                                    </span>
                                                    @endif
                                                    @if ($item->image != '')
                                                        <img src="{{ asset('storage/menus/'.$item->image) }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                                                    @else
                                                        <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                                                    @endif
                                                    <div class="card-body">
                                                        <div class="row h-75">
                                                            <h6 class="card-title ">{{$itemName[1]}}</h6>
                                                        </div>
                                                        <div class="row h-25">
                                                            <p class="card-text">{{rupiah($item->price ?? '', true)}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @if ($item->availability)
                                            </a>    
                                            <!-- Modal -->
                                            <div class="modal fade" id="{{$item->id}}addToCart" tabindex="-1"  aria-hidden="true">
                                                <div class="z-3 modal-dialog position-absolute mb-0 start-0 end-0 bottom-0 " style="max-height: 90%" >
                                                    
                                                    <div class="modal-content" style="">
                                                        <div class="container">
                                                            <div class="row">
                                                                <a class="btn btn-plus rounded-0 btn-danger" data-bs-dismiss="modal">
                                                                    <i class="fa-solid fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="modal-header">
                                                            @if ($item->image != '')
                                                                <img src="{{ asset('storage/menus/'.$item->image) }}" class="card-img-top img-thumbnail p-2 border-0 " alt="image error" style="" >
                                                            @else
                                                                <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0" alt="image error" style="" >
                                                            @endif
                                                        </div>
                                                    
                                                        <div class="modal-body">     
                                                            <div class="container">
                                                                <div class="row px-2">
                                                                    <div class="col-8">
                                                                        <h5 class="text-break">{{$itemName[1]}}</h5>
                                                                        
                                                                    </div>
                                                                    <div class="col-4 text-end fw-medium"> 
                                                                        <p> <i class="fa-solid fa-hourglass-end me-1"></i> {{$item->cook_time}}  <span class="">min</span></p>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row px-3"> 
                                                                    <p>{{$item->description}}</p>
                                                                </div>
                                                                <div class="row px-3 d-flex align-items-center flex-column">
                                                                    <form action="{{ url('/vendor/'.$vendor->id.'/addToCart/'.$item->id) }}" method="post" class="form-loading mb-3">
                                                                        @csrf
                                                                        <div class="mb-3">
                                                                            <label for="notes" class="form-label fw-medium" >Notes</label>
                                                                            <textarea class="form-control" id="notes" name='notes' rows="3" placeholder="ex. Make it good!">{{$notes ? $notes : ''}}</textarea>
                                                                        </div>
                                                                        <div class="row mb-4 d-flex align-items-center justify-content-between">
                                                                            <div class="col-6 fw-medium h4 mb-0">
                                                                                {{rupiah($item->price ?? '', true)}}
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="input-group inline-group">
                                                                                    <div class="input-group-prepend">
                                                                                    <a class="btn btn-minus rounded-circle btn-outline-dark">
                                                                                        <i class="fa fa-minus fa-sm"></i>
                                                                                    </a>
                                                                                    </div>
                                                                                    <input class="form-control quantity text-center border-0" min="1" max="99" name="quantity" value={{$quantity !== 0 ? $quantity : "1"}} type="number">
                                                                                    <div class="input-group-append">
                                                                                    <a class="btn btn-plus rounded-circle btn-outline-dark">
                                                                                        <i class="fa fa-plus fa-sm"></i>
                                                                                    </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            @if ($quantity > 0)
                                                                                <div class="d-flex justify-content-around">
                                                                                    <a href="{{ url('/remove-item/'.$cartItemId) }}" class="btn btn-danger w-50 me-1">Remove Item</a>
                                                                                    <button class="btn btn-primary w-50 ms-1" type="submit">Update Item</button>
                                                                                </div>
                                                                            @else
                                                                                <button class="btn btn-primary w-100" type="submit">Add Item</button>
                                                                            @endif
                                                                            
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                              
                                            @endif
                                            </a>           
                                        </div>
                                        
                                        @if($loop->index%2 !=0 || $loop->last)
                                            </div>
                                        </div>
                                        @endif
                
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    </div>            
                @endforeach 
            @else
            <h3 class="col p-5 text-center">Sorry the menu for this vendor is currently not available.</h3>    
            @endif
        </div>

    </div>
    
@endsection
