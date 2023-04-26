@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @if (!$items->isEmpty())
                @foreach ($items as $item)
                @php
                    $itemName = explode('_',$item->name)
                @endphp
                <div class="col-6 p-1">           
                    <div class="card border-white text-center h-100">
                        @if ($item->image != '')
                            <img src="{{ asset('storage/menus/'.$item->image) }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                        @else
                            <img src="{{ asset('storage/menus/default.jpg') }}" class="card-img-top img-thumbnail p-2 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 120px; object-fit:contain;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{$itemName[1]}}</h6>
                            <a href="/vendor-menu/edit/{{$item->id}}" class="btn btn-light border-dark me-3 mt-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a data-bs-toggle="modal" data-bs-target="#{{$item->id}}addToCart" class="btn btn-danger mt-2">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="{{$item->id}}addToCart" tabindex="-1" role="dialog" aria-hidden="true">
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

        <div class="addBtn text-center" style="position:absolute; bottom:20px; right:20px;">
            <a href="{{ url('/vendor-menu/add') }}" class="btn rounded btn-primary p-3">
                <i class="fa-solid fa-plus fa-2xl"></i>
            </a>
        </div>
    </div>
    
@endsection
