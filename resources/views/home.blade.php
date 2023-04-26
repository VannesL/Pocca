@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ url('/home') }}" method="get" class="form-loading">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group @error('type') has-error @enderror">
                                <select name="type" id="" class="form-control">
                                    <option value="canteen">Canteen</option>
                                    <option value="vendor">Vendor</option>
                                </select>
                                @error('type')
                                <span class="form-text m-b-none text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group @error('search') has-error @enderror">
                                <input name="search" type="text" value="{{ $search }}" class="form-control"
                                    placeholder="Search">
                                @error('search')
                                    <span class="form-text m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 ps-1">
                            <button type="submit" class="btn btn-primary btn-block btn_submit ms-0"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <hr>
                {{-- @foreach ($favorite as $item)
                    <a href="#" class="text-decoration-none">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h5 class="card-title">{{ $canteen->name }}</h5>
                                        <p class="card-text">{{ $canteen->address }}</p>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <button class="btn btn-block shadow-none"><i class="fa fa-heart fa-2xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach --}}
                @foreach ($canteens as $canteen)
                    <a href="{{ url('/canteen', $canteen->id) }}" class="text-decoration-none">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h5 class="card-title">{{ $canteen->name }}</h5>
                                        <p class="card-text">{{ $canteen->address }}</p>
                                    </div>
                                    <div class="col-3 align-self-center">
                                        <button class="btn btn-block shadow-none"><i class="fa fa-heart fa-2xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('i').click(function() {
                $(this).toggleClass('fa-heart fa-heart-o');
            });
        });
    </script>
@endpush
