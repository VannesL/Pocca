@extends('layout')

@section('content')
    <div class="container mt-1">
        @if ($cartTotal > 0)
            <div class="addBtn text-center position-fixed z-3" style="bottom:20px; right:20px;">
                <a href="{{ url('/customer-cart') }}" class="btn rounded btn-primary p-3">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartTotal }}
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
                    <div class="input-group mb-3">
                        <select name="type" id="" class="input-group-text px-1">
                            <option value="vendor" {{ $type == 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="menu_item" {{ $type == 'menu_item' ? 'selected' : '' }}>Menu</option>
                        </select>
                        <input name="search" type="text" value="{{ $search }}" class="form-control"placeholder="Search" id="search">
                        <button type="submit" class="btn btn-primary btn-block btn_submit ms-0 input-group-text"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <hr>
                @foreach ($items as $item)
                    @if ($item->favoritedCustomers->contains('id', $userId))
                        @if ($type == 'menu_item' && $item->menuItems->count()<1)
                            
                        @else    
                            <a href="{{ url('/home/' . $item->canteen_id . '/' . $item->id) }}" class="text-decoration-none">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <h5 class="card-title">{{ $item->name }}</h5>
                                            @if ($type == 'menu_item')
                                                <p class="card-text">
                                                    @foreach ($item->menuItems->take(3) as $menuItem)
                                                        @php
                                                            $itemName = explode('_', $menuItem->name);
                                                        @endphp
                                                        {{ $itemName[1] }},
                                                    @endforeach
                                                </p>
                                            @else
                                                <p class="card-text">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <form
                                                action="{{ url('home/' . $canteen->id . '/update-favorite-vendor/' . $item->id) }}"
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
                    @endif
                @endforeach
                @foreach ($items as $item)
                    @if (!$item->favoritedCustomers->contains('id', $userId))
                        @if ($type == 'menu_item' && $item->menuItems->count()<1)
                        @else
                            <a href="{{ url('/home/' . $item->canteen_id . '/' . $item->id) }}" class="text-decoration-none">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9">
                                                <h5 class="card-title">{{ $item->name }}</h5>
                                                @if ($type == 'menu_item')
                                                    <p class="card-text">
                                                        @foreach ($item->menuItems->take(3) as $menuItem)
                                                            @php
                                                                $itemName = explode('_', $menuItem->name);
                                                            @endphp
                                                            {{ $itemName[1] }},
                                                        @endforeach
                                                    </p>
                                                @else
                                                    <p class="card-text">{{ $item->description }}</p>
                                                @endif
                                            </div>
                                            <div class="col-3 align-self-center">
                                                <form
                                                    action="{{ url('home/' . $canteen->id . '/update-favorite-vendor/' . $item->id) }}"
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
                    @endif
                @endforeach
            </div>
        </div>
    </div>
<link rel="stylesheet" href="{{ asset ('css/searchbar.css') }}">

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
