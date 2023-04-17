@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('home') }}"method="get" class="form-loading">
                    @csrf
                    <div class="row">
                        <div class="col-md-11">
                            <div class="form-group @error('search') has-error @enderror">
                                <input name="search" type="text" value="{{ $search }}" class="form-control"
                                    placeholder="Search">
                                @error('search')
                                    <span class="form-text m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary btn-block btn_submit"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <hr>
                @foreach ($canteens as $canteen)
                    <a href="#" class="text-decoration-none">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <h5 class="card-title">{{ $canteen->name }}</h5>
                                        <p class="card-text">{{ $canteen->address }}</p>
                                    </div>
                                    <div class="col-1 align-self-center">
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
