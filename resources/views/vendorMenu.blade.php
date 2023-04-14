@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-6 p-2">
                    <div class="text-center m-1 h-100">
                        <img src="public/menus/{{$item->image}}" class="img-top" alt="public/menus/default.png">
                        <div class="body">
                            @php
                                $itemName = explode('_',$item->name)
                            @endphp
                            <h5 class="title h-100 mb-3">{{$itemName[1]}}</h5>
                            <div class="buttons position-relative mb-3">
                                <a href="/vendor-menu/edit/{{$item->id}}" class="btn btn-light border-dark">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="/vendor-menu/delete/{{$item->id}}" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div> 
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="addBtn text-center" style="position:absolute; bottom:20px; right:20px;">
            <a href="{{ url('/vendor-menu/add') }}" class="btn rounded btn-primary p-3">
                <i class="fa-solid fa-plus fa-2xl"></i>
            </a>
        </div>
    </div>
    
@endsection
