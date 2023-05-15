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
                                <div class="card-body py-2">
                                    <div class="row">
                                        <div class="col p-0 text-center">
                                            <img class="card-img" src="{{ asset('storage/profiles/' . $item->image) }}" alt="no image" style="height: 100px; width:100px; object-fit:cover;">
                                        </div>
                                        <div class="col-6 px-2">
                                            <h6 class="card-title">{{ $item->store_name }}</h6>                  
                                            <div class="container px-0 card-text" style="font-size: 0.875em;">
                                                <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->description }}</div>
                                                <div class="d-flex mt-2 text-start justify-content-between">
                                                    <div class="">
                                                        @if ($item->avg_rating)
                                                            {{ $item->avg_rating }} <i class="fa-solid fa-star me-1"></i>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                    <div class="">
                                                        @if ($item->priceRange)
                                                            {{ $item->priceRange->value }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 align-self-center text-center p-0">
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
                                @if ($type == 'menu_item')
                                    <ol class="list-group list-group-flush">
                                        @foreach ($item->menuItems->take(3) as $menu)
                                            @php
                                                $menuName = explode('_', $menu->name);
                                            @endphp
                                            <li class="list-group-item d-flex justify-content-between bg-light">
                                                <div class="col fw-semibold">
                                                    {{ $menuName[1] }}
                                                </div>
                                                <div class="col text-center fw-medium">
                                                    <small class="fw-normal">Rp. </small>{{ $menu->price }}
                                                </div>
                                            </li> 
                                        @endforeach
                                    </ol>
                                @endif
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
                                    <div class="card-body py-2">
                                        <div class="row">
                                            <div class="col p-0 text-center">
                                                <img class="card-img" src="{{ asset('storage/profiles/' . $item->image) }}" alt="no image" style="height: 100px; width:100px; object-fit:cover;">
                                            </div>
                                            <div class="col-6 px-2">
                                                <h6 class="card-title">{{ $item->store_name }}</h6>                  
                                                <div class="container px-0 card-text " style="font-size: 0.875em;">
                                                    <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $item->description }}</div>
                                                    <div class="d-flex mt-2 text-start justify-content-between">
                                                        <div class="">
                                                            @if ($item->avg_rating)
                                                                {{ $item->avg_rating }} <i class="fa-solid fa-star me-1"></i>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </div>
                                                        <div class="">
                                                            @if ($item->priceRange)
                                                                {{ $item->priceRange->value }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 align-self-center text-center p-0">
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
                                    @if ($type == 'menu_item')
                                        <ol class="list-group list-group-flush">
                                            @foreach ($item->menuItems->take(3) as $menu)
                                                @php
                                                    $menuName = explode('_', $menu->name);
                                                @endphp
                                                <li class="list-group-item d-flex justify-content-between bg-light">
                                                    <div class="col fw-semibold">
                                                        {{ $menuName[1] }}
                                                    </div>
                                                    <div class="col text-center fw-medium">
                                                        <small class="fw-normal">Rp. </small>{{ $menu->price }}
                                                    </div>
                                                </li> 
                                            @endforeach
                                        </ol>
                                    @endif
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
