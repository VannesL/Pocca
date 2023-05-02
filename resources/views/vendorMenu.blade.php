@extends('layout')

@section('content')
    <div class="container">
        @if(session()->has('Success'))
            <div class="alert alert-success">
                {{ session()->get('Success') }}
            </div>
        @endif
        <div class="row mb-3">
            @if (!$items->isEmpty())
                @foreach ($items as $item)
                @php
                    $itemName = explode('_',$item->name)
                @endphp
                <div class="col-6 p-1">           
                    
                    <div class="card border-white text-center h-100" style="box-shadow: 0px 2px 10px 2px #8b9ce936;">
                        @if ($item->recommended)
                        <span class="z-2 d-flex position-absolute translate-middle badge rounded-pill bg-warning text-center align-items-center" style="width:32px; height:32px; left:98%; top:5%;vertical-align: middle">
                            <i class="fa-solid fa-thumbs-up fa-xl my-auto" style="color: #ffffff;"></i>
                        </span>
                        @endif
                        @if ($item->image != '')
                            <img src="{{ asset('storage/menus/'.$item->image) }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                        @else
                            <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                        @endif
                        <div class="card-body h-100">
                            <h6 class="card-title h-50">{{$itemName[1]}}</h6>
                            <div class="h-50 mb-3">
                                <a href="/vendor-menu/edit/{{$item->id}}" class="btn btn-light border-dark me-3 mt-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a data-bs-toggle="modal" data-bs-target="#{{$item->id}}" class="btn btn-danger mt-2">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>  
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addToCartLabel">Are you sure?</h5>
                        </div>
                        <div class="modal-body">
                            This menu item will be deleted from the database.
                        </div>
                        <div class="modal-footer d-flex justify-content-around">
                            <div class="col-3"></div>
                            <form method="POST" action="/vendor-menu/delete/{{$item->id}}">
                            @csrf
                            <button type ="submit" class="btn btn-danger col">
                                Yes
                            </button>
                            </form>
                            <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach 
            @endif
        </div>

        <div class="addBtn text-center position-fixed z-3" style="bottom:20px; right:20px;">
            <a href="{{ url('/vendor-menu/add') }}" class="btn rounded btn-primary p-3">
                <i class="fa-solid fa-plus fa-2xl"></i>
            </a>
        </div>
    </div>
    
@endsection
