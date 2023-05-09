@extends('layout')

@section('content')
    <div class="container">
        @if ($cartTotal>0)
            <div class="addBtn text-center position-fixed z-3" style="bottom:20px; right:20px;">
                <a href="{{ url('/customer-cart') }}" class="btn rounded btn-primary p-3">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$cartTotal}}
                        <span class="visually-hidden">number of items</span>
                    </span>
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="row">
                        <div class="col-9">
                            <h5 class="card-title">{{ $canteen->name }}</h5>
                            <p class="card-text">{{ $canteen->address }}</p>
                        </div>
                        @if ($canteen->favoritedCustomers->contains('id', $userId))
                            <div class="col-3 align-self-center">
                                <form action="{{ url('home/update-favorite-canteen', $canteen->id) }}" method="post"
                                    class="form-loading">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="favorite" value="0">
                                    <button type="submit" class="btn btn-block shadow-none"><i
                                            class="fa fa-heart fa-2xl"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="col-3 align-self-center">
                                <form action="{{ url('home/update-favorite-canteen', $canteen->id) }}" method="post"
                                    class="form-loading">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="search" value="{{ $search }}">
                                    <input type="hidden" name="favorite" value="1">
                                    <button type="submit" class="btn btn-block shadow-none"><i
                                            class="fa fa-heart-o fa-2xl"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div><br>

                <form action="{{ url('/home', $canteen->id) }}" method="get" class="form-loading">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group @error('type') has-error @enderror">
                                <select name="type" id="" class="form-control">
                                    <option value="vendor" {{ $type == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                    <option value="menu_item" {{ $type == 'menu_item' ? 'selected' : '' }}>Menu Item
                                    </option>
                                </select>
                                @error('type')
                                    <span class="form-text m-b-none text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
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
                @foreach ($vendors as $vendor)
                    @if ($vendor->favoritedCustomers->contains('id', $userId))
                        <a href="" class="text-decoration-none">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <h5 class="card-title">{{ $vendor->name }}</h5>
                                            <p class="card-text">{{ $vendor->description }}</p>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <form
                                                action="{{ url('home/' . $canteen->id . '/update-favorite-vendor/' . $vendor->id) }}"
                                                method="post" class="form-loading">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="search" value="{{ $search }}">
                                                <input type="hidden" name="favorite" value="0">
                                                <button type="submit" class="btn btn-block shadow-none"><i
                                                        class="fa fa-heart fa-2xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
                @foreach ($vendors as $vendor)
                    @if (!$vendor->favoritedCustomers->contains('id', $userId))
                        <a href="" class="text-decoration-none">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <h5 class="card-title">{{ $vendor->name }}</h5>
                                            <p class="card-text">{{ $vendor->description }}</p>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <form
                                                action="{{ url('home/' . $canteen->id . '/update-favorite-vendor/' . $vendor->id) }}"
                                                method="post" class="form-loading">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="search" value="{{ $search }}">
                                                <input type="hidden" name="favorite" value="1">
                                                <button type="submit" class="btn btn-block shadow-none"><i
                                                        class="fa fa-heart-o fa-2xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
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
