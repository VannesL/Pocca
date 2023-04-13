@extends('layout')

@section('content')
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-item-center">
            <div class="col col-xl-10 mt-3">
                <div class="d-flex justify-content-end mb-2 pb-1">
                    <button class="btn btn-sm text-white btn-danger fw-light">Delete Account</button>
                </div>
                <div class="d-flex justify-content-center mb-3 pb-1">
                  <span class="h1 text-dark fw-bold">Edit Profile</span>
                </div>
                <div class="card border-rounded border-light shadow-lg mb-4">
                    <div class="row g-0">
                     
                      
                        <div class="card-body p-4 p-lg-5 text-black">
                          <form method="POST" action="#">
                            @csrf

                            <div class="form-outline mb-4">
                              <label for="name" class="h4 fw-bold">Name</label>
                              <div class="col-lg">

                              </div>
                              <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="" autocomplete="name" placeholder="{{auth()->guard('customer')->user()->name}}" readonly />
                              
                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="email" class="h4 fw-bold">Email</label>
                              <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="" autocomplete="email" placeholder="{{auth()->guard('customer')->user()->email}}" readonly />

                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="password" class="h4 fw-bold">Password</label>
                              <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password" readonly/>

                              @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            <div class="d-none form-outline mb-4">
                              <label for="passwordConfirm" class="h4 fw-bold">Confirm Password</label>
                              <input id="passwordConfirm" type="password" class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" name="passwordConfirm" autocomplete="new-password" placeholder="Confirm password"/>

                              @error('passwordConfirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="phoneno" class="h4 fw-bold">Phone Number</label>
                              <input id="phoneno" type="text" class="form-control form-control-lg @error('phoneno') is-invalid @enderror" name="phoneno" value="" autocomplete="phoneno" placeholder="{{auth()->guard('customer')->user()->phone_number}}" readonly />

                              @error('phoneno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outlin4">
                              <label for="dob" class="h4 fw-bold">Date of birth</label>
                              <input id="dob" type="date" class="form-control form-control-lg @error('dob') is-invalid @enderror" name="dob" value="{{auth()->guard('customer')->user()->dob}}" placeholder=""" readonly />
                                
                              @error('dob')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
  
                            <div class="d-flex justify-content-center pt-1 mt-3">
                              <button class="btn btn-dark btn-sm" type="submit">Save</button>
                            </div>

                          </form>
                        </div>
                    </div>
                  </div>
        </div>
    </div>
@endsection

<script>
    
</script>
