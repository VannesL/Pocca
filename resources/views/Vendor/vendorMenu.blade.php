@extends('layout')

@section('content')
    <div class="container">
        @if(session()->has('Success'))
            <div class="alert alert-success">
                <strong>{{ session()->get('Success') }}</strong>
            </div>
        @endif
        @error('name')
            <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
        <form action="{{ url('/vendor-menu') }}" method="get" class="form-loading mb-3">
            @csrf
            <div class="input-group @error('search') has-error @enderror">
                <input name="search" type="text" value="{{ $search }}" class="form-control"
                            placeholder="Search" id="search">
                            @error('search')
                            <span class="form-text m-b-none text-danger">{{ $message }}</span>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-block btn_submit input-group-text"><i
                            class="fa fa-search"></i></button>
            </div>

        </form>
        <div class="container px-4" style="margin-bottom: 40%">
           
            @if (sizeof($menuByCat))
                @foreach ($menuByCat as $cat)
                    @php
                        $curr_cat = $categories[$loop->index];
                        $sizeofItem = $cat->count();
                    @endphp
                    <!-- Modal -->
                    @if ($curr_cat->vendor_id != null)  
                        <div class="modal fade" id="deleteCat{{$curr_cat->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="z-3 modal-dialog position-absolute mb-0 start-0 end-0 bottom-0 " style="" role="document">
                                <div class="modal-content" style="height: 500px">
                                    <div class="container">
                                        <div class="row">
                                            <a class="btn btn-plus rounded-0 btn-danger" data-bs-dismiss="modal">
                                                <i class="fa-solid fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="modal-header ">
                                        <h5 class="modal-title mx-auto" id="addToCartLabel">Do you want to delete {{$curr_cat->name}}?</h5>

                                    </div>
                                    <div class="modal-body">
                                        <div class="fs-5 mb-2">Select a new category for all your items:</div>
                                        <form action="{{url('/vendor-menu/deleteCategory/'.$curr_cat->id)}}" method="POST" name="deleteCat">
                                            @csrf
                                            <div class="form-outline mb-4 container d-flex flex-nowrap flex-row">
                                                <div class="col-6">
                                                    <div class="row h5 fw-medium">From</div>
                                                    <div class="row h-50 d-flex align-items-center p-2">
                                                        {{$curr_cat->name}} 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="row h5 fw-medium">To</div>
                                                    <div class="row">
                                                        <select class="form-select @error('selectCategory') is-invalid @enderror" id="selectCategory" name="selectCategory">
                                                            @foreach ($categories as $category)
                                                                @if ($curr_cat->id != $category->id)
                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="buttons row d-flex justify-content-around pt-1 mt-5">
                                                    <div class="btn btn-secondary col-3 m-2"  data-bs-dismiss="modal">
                                                        Cancel
                                                    </div>
                                                    <button href="{{url('/vendor-menu/deleteCategory/'.$curr_cat->id)}}" class="btn btn-danger btn-md w-100 col m-2" type="submit">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="container">
                        <div class="row mb-2 border-bottom">
                            <div class="col-8 ps-0">
                                <h3>{{$curr_cat->name.' ('.$sizeofItem.')'}}</h3>
                            </div>
                            <div class="col-4 text-end d-flex align-items-center justify-content-end">
                                @if ($curr_cat->vendor_id != null)
                                    <a href="" class="text-decoration-none fs-6 text-danger" data-bs-toggle="modal" data-bs-target="#deleteCat{{$curr_cat->id}}"><i class="fa-solid fa-trash-can"></i>  </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 px-2">
                    @foreach ($cat as $item)
                        @php
                            $itemName = explode('_',$item->name);

                            if($item->image == '') {
                                $image = "default.jpg";
                            } else {
                                $image = $item->image;
                            }
                        @endphp
                        
                        <div class="col-6 p-1" style="height:230px">           
                            
                            <a href="{{ url('/vendor-menu/edit/'.$item->id) }}" class="border-dark me-3 mt-2 text-decoration-none text-dark">
                            <div class="card border-white text-center h-100" style="box-shadow: 0px 2px 10px 2px #8b9ce936;">
                                    @if ($item->recommended)
                                        <span class="z-3 d-flex position-absolute translate-middle badge rounded-pill bg-warning text-center align-items-center" style="width:32px; height:32px; left:98%; top:5%;vertical-align: middle">
                                            <i class="fa-solid fa-thumbs-up fa-xl my-auto" style="color: #ffffff;"></i>
                                        </span>
                                    @endif
                                    <img src="{{ asset('storage/menus/'.$image) }}" class="card-img-top img-thumbnail p-0 border-0 @if (!$item->availability) opacity-50 @endif" alt="image error" style="height: 140px; object-fit:cover; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;">
                                    <div class="card-body p-2">
                                        <div class="h-50">
                                            <h6 class="card-title mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{$itemName[1]}}</h6>
                                        </div>
                                        <div class="h-50 pt-2">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </div> 
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    @endforeach
                
                    </div>
                @endforeach
            @else
                <h2 class="mt-4 text-center text-wrap">The menu is stil empty!</h2>
            @endif
            
        </div>

        <div class="text-center position-fixed z-3 dropup" style="bottom:60px; right:20px;">
            <button class="btn rounded-circle btn-primary rotate" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="false" style="width: 56px; height: 56px;">
                <i class="fa-solid fa-plus rotate fa-lg" id=""></i>
            </button>
            <ul class="dropdown-menu text-center mb-2 p-3" style="box-shadow: 0px 2px 10px 2px #8b9ce936;">
                <li><a href="{{ url('/vendor-menu/add') }}" class="text-decoration-none text-dark fw-medium">
                    Add Menu
                </a></li>
                <li class="px-2"><hr class="" style="border-top: 3px solid #000000"></li>
                <li><a href="" class="text-decoration-none text-dark fw-medium" data-bs-toggle="modal" data-bs-target="#categoryForm">
                    Add Category
                </a></li>
              </ul>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="categoryForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="z-3 modal-dialog position-absolute mb-0 start-0 end-0 bottom-0 " style="" role="document">
            <div class="modal-content" style="height: 500px">
                <div class="container">
                    <div class="row">
                        <a class="btn btn-plus rounded-0 btn-danger" data-bs-dismiss="modal">
                            <i class="fa-solid fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-header ">
                    <h5 class="modal-title mx-auto" id="addToCartLabel">New Category</h5>

                </div>
                <div class="modal-body">
                    <form action="{{url('/vendor-menu/addCategory')}}" method="POST">
                        @csrf
                        <div class="form-outline mb-4">
                            <input id="name" type="text" class="form-control form-control-md @error('name') is-invalid @enderror" name="name" placeholder="New Category"/>
                          </div>
                          <div class="container">
                              <div class="buttons row d-flex justify-content-around pt-1 mt-5">
                                <div class="btn btn-secondary col-3 m-2"  data-bs-dismiss="modal">
                                    Cancel
                                </div>
                                <button class="btn btn-primary btn-md w-100 col m-2" type="submit">Add</button>
                              </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset ('css/vendorMenu.css') }}">
    <link rel="stylesheet" href="{{ asset ('css/searchbar.css') }}">


    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script>
        $(".rotate").click(function(){
        $(this.children).toggleClass("down"); 
    });
    </script>
@endsection
