@extends('layout')


@push('custom-js')
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="{{ asset ('js/toogleEditProfile.js') }}"></script>
@endpush



@section('content')
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-item-center">
            <div class="col col-xl-10 mt-3">
                <div class="d-flex justify-content-center pb-1">
                  <span class="h1 text-dark fw-bold">Edit Store Profile</span>
                </div>
                @if(session()->has('success'))
                  <div class="alert alert-success">
                      {{ session()->get('success') }}
                  </div>
                @endif

                <div class="card border-rounded border-light shadow-lg my-4">
                    <div class="row g-0">
                     
                      
                        <div class="card-body p-4 p-lg-5 text-black">
                          <form method="POST" action="{{url("/vendor-editProfile")}}"   enctype="multipart/form-data" autocomplete="off">
                            @csrf

                            <div class="form-outline mb-4">
                              <label for="canteenName" class="h4 fw-bold">Canteen Name</label>
                              <p id="canteenName" class="form-control form-control-md text-secondary" name="canteenName">{{$canteenName}}</p>
                            </div>

                            <div class="form-outline mb-4">
                              <label for="store_name" class="h4 fw-bold">Store Name</label>
                              <div class="d-flex col">
                                <input id="store_name" type="text" class="form-control form-control-md @error('store_name') is-invalid @enderror" name="store_name" value=""  placeholder="{{auth()->guard('vendor')->user()->store_name}}" readonly/>
                                
                                <button type="button" class="btn " name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                              </div>
                              @error('store_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="name" class="h4 fw-bold">Owner Name</label>
                              <div class="d-flex col">
                                  <input id="name" type="text" class="form-control form-control-md @error('name') is-invalid @enderror" name="name"  autocomplete="name" placeholder="{{auth()->guard('vendor')->user()->name}}" readonly />
                                  
                                  <button type="button" class="btn " name="edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                  </button>
                                </div>
                                @error('name')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="email" class="h4 fw-bold">Email</label>
                              <div class="d-flex col">
                                <input id="email" type="email" class="form-control form-control-md @error('email') is-invalid @enderror" name="email" placeholder="{{auth()->guard('vendor')->user()->email}}" readonly />
  
                                <button type="button" class="btn " name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                              </div>
                              @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="password" class="h4 fw-bold">Password</label>
                              <div class="d-flex col">
                                <input id="password" type="password" class="form-control form-control-md @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password" readonly/>
  
                          
                                <button type="button" class="btn " name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                              </div>
                              
                              @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror

                              @if(! $errors->has('password'))
                                @error('passwordConfirm')
                                  <span class="invalid-feedback d-block" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                 @enderror
                              @endif

                            </div>

                            <div class="form-outline mb-4" style="display: none">
                              <label for="passwordConfirm" class="h4 fw-bold">Confirm Password</label>
                              <input id="passwordConfirm" type="password" class="form-control form-control-md @error('passwordConfirm') is-invalid @enderror" name="passwordConfirm" autocomplete="new-password" placeholder="Confirm password"/>

                              @error('passwordConfirm')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="phone_number" class="h4 fw-bold">Phone Number</label>
                              <div class="d-flex col">
                                <input id="phone_number" type="number" class="form-control form-control-md @error('phoneno') is-invalid @enderror" name="phone_number" value="" autocomplete="phone_number" placeholder="{{auth()->guard('vendor')->user()->phone_number}}" readonly />
  
                                
                                <button type="button" class="btn " name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                              </div>
                              @error('phone_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          
                            <div class="form-outline mb-4">
                              <label for="address" class="h4 fw-bold">Address</label>
                              <div class="d-flex col">  
                                <textarea id="address" type="textbox"  rows="3" class="form-control form-control-md @error('address') is-invalid @enderror" name="address" style="height: 100px" value="" autocomplete="address" placeholder="{{auth()->guard('vendor')->user()->description}}" style="resize: none" readonly></textarea>
  
                                <button type="button" class="btn " name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                              </div>
                              @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="description" class="h4 fw-bold">Description</label>
                              <div class="d-flex col">
                                <textarea id="description" type="textbox"  rows="3" class="form-control form-control-md @error('description') is-invalid @enderror" name="description"  rows="4" value="" autocomplete="description" placeholder="{{auth()->guard('vendor')->user()->description}}"  style="resize: none" readonly ></textarea>
  
                                <button type="button" class="btn" name="edit">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                              </div>
                              @error('description')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="image" class="h4 fw-bold">Profile Image</label>
                              <img src="{{ asset('storage/profiles/'.auth()->guard('vendor')->user()->image) }}" class="img-fluid" alt="No image Included"> 
                              <input class="form-control form-control-sm" id="image" name="image" type="file">

                              @error('image')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="qris" class="h4 fw-bold">QRIS</label>
                              
                              <img src="{{ asset('storage/qris/'.auth()->guard('vendor')->user()->qris) }}" class="img-fluid" alt="No image Included">
                              <input class="form-control form-control-sm" id="qris" name="qris" type="file">

                              @error('qris')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="d-flex justify-content-center pt-1 mt-3">
                              <div class="buttons row d-flex justify-content-around pt-1 mt-4">
                                <div class="btn btn-danger col-3 m-2" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">
                                    <i class="fa-solid fa-trash-can"></i>
                                </div>
                                <button class="btn btn-primary btn-md w-100 col m-2" type="submit">Update</button>
                              </div>
            
                            </div>
                            
                          </form>
                          <!-- Modal -->
                          <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" style="" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteConfirmationLabel">Are you sure?</h5>
                                </div>
                                <div class="modal-body">
                                  This menu item will be deleted from the database.
                                </div>
                                <div class="modal-footer d-flex justify-content-around">
                                  <div class="col-3"></div>
                                  <form action="/vendor-deleteProfile" method="post">
                                  @csrf
                                  <button class="btn btn-danger col" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Yes</button>
                                  </form>
                                  <button type="button" class="btn btn-secondary col-6 me-1" data-bs-dismiss="modal">No</button> 
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
        </div>
    </div>
@endsection


