@extends('layout')

@push('custom-js')
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset ('js/inputNumberWithButton.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        {{-- Vendor Header Design 1 --}}
        <div class="container mb-3 text-light rounded" style="background-image: url({{ asset('storage/profiles/'.$vendor->image) }}); background-size: cover;">
            <div class="row rounded p-3" style="background-color: rgba(0, 0, 0, 0.603); backdrop-filter: blur(1px);">
                <div class="col-10">
                    <div class="row"> <h4>{{$vendor->name}}</h4></div>
                    <div class="row"> <p>{{$vendor->description}}</p></div>
                    <div class="row "> 
                        <div class="col-3"><i class="fa-solid fa-star"></i>1</div>
                        <div class="col-9 ">Rp 10-30k</div>
                    </div>
                </div>
                <div class="col-2 align-self-center text-center">
                    <i class="fa fa-heart fa-2xl"></i>
                </div>
            </div>
        </div>
        {{-- Vendor Header Design 2 --}}
        <div class="row rounded p-3">
            <div class="col-3">
                @if ($vendor->image != '')
                    <img src="{{ asset('storage/profiles/'.$vendor->image) }}" class="" style="object-fit: cover; width:100%; height:100%" alt="...">
                @else
                    <img src="{{ asset('storage/profiles/default.jpg') }}" class="img-fluid " alt="...">
                @endif
            </div>
            <div class="col-7">
                <div class="row"> <h4>{{$vendor->name}}</h4></div>
                <div class="row"> <p>{{$vendor->description}}</p></div>
                <div class="row "> 
                    <div class="col-3"><i class="fa-solid fa-star"></i>1</div>
                    <div class="col-9">Rp 10-30k</div>
                </div>
            </div>
            <div class="col-2 align-self-center text-center">
                <i class="fa fa-heart fa-2xl"></i>
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
                                        $itemName = explode('_',$item->name)
                                        @endphp
                                        @if ($loop->index%2 ==0)
                                            <div class="col-md-4">
                                                <div class="row h-100">

                                        @endif
                                       
                                        <div class="col-6 p-1">
                                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#{{$item->id}}addToCart" href="">
                                                <div class="card  text-center h-100">
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
                                                            <p class="card-text">Rp {{$item->price}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>           
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="{{$item->id}}addToCart" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg  position-absolute w-100  mb-0 ms-0  bottom-0 start-50 translate-middle-x" style="max-height: 90%" role="document">
                                                
                                                <div class="modal-content" style="">
                                                    <div class="modal-header">
                                                            @if ($item->image != '')
                                                                <img src="{{ asset('storage/menus/'.$item->image) }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="" >
                                                            @else
                                                                <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="" >
                                                            @endif
                                                      </div>
                                                
                                                <div class="modal-body">     
                                                    <div class="row px-2">
                                                        <div class="col-9">
                                                            <h5 class="">{{$itemName[1]}}</h5>
                                                            
                                                        </div>
                                                        <div class="col-3 text-end"> 
                                                            <p><i class="fa-light fa-timer"></i> {{$item->cook_time}}  <span class="fw-medium">min</span></p>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="row px-3"> 
                                                        <p>{{$item->description}}</p>
                                                    </div>
                                                    <div class="row px-3">
                                                        <form action="{{url("/addToCart/$item->id")}}" method="post">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="notes" class="form-label" >Notes</label>
                                                                <textarea class="form-control" id="notes" rows="3" placeholder="notes"></textarea>
                                                            </div>
                                                            <div class="row mb-4">
                                                                <div class="col-6">
                                                                    Rp {{$item->price}}
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="input-group inline-group">
                                                                        <div class="input-group-prepend">
                                                                          <a class="btn btn-outline-light btn-minus btn-danger">
                                                                            <i class="fa fa-minus"></i>
                                                                          </a>
                                                                        </div>
                                                                        <input class="form-control quantity" min="0" name="quantity" value="1" type="number">
                                                                        <div class="input-group-append">
                                                                          <a class="btn btn-outline-light btn-plus btn-success">
                                                                            <i class="fa fa-plus"></i>
                                                                          </a>
                                                                        </div>
                                                                      </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <button class="btn btn-primary w-50 mx-auto" type="submit">Add Item</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                {{-- <div class="modal-footer d-flex justify-content-around">
                                                    <div class="col-3"></div>
                                                    <form method="POST" action="/vendor-menu/delete/{{$item->id}}">
                                                    @csrf
                                                    <button type ="submit" class="btn btn-danger col">
                                                        Yes
                                                    </button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                                                </div> --}}
                                                </div>
                                            </div>
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
                
            @endif
        </div>

        <div class="addBtn text-center position-fixed z-3" style="bottom:20px; right:20px;">
            <a href="{{ url('/vendor-menu/add') }}" class="btn rounded btn-primary p-3">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>
    
@endsection
