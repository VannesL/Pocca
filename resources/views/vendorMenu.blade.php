@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-6">
                    <div class="h-100 text-center">
                        <img src="{{$item->image}}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{$item->name}}</h5>
                            <div class="buttons">
                                <a href="#" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div> 
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
@endsection
