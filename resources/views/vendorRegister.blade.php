<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POCCA</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
    <body style="background: linear-gradient(257deg, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%); background-repeat: no-repeat; background-attachment: fixed">
      

        <section class="vh-100" style="background: transparent">
            <div class="d-flex justify-content-start mx-2 mt-2">
              <span class="h5 text-white fw-bold" >POCCA</span>
            </div>
            <div class="container py-5 h-100"> 
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                  <div class="d-flex justify-content-center mb-3 pb-1">
                    <span class="h1 text-white fw-bold ">Register <sup class="position-relative" style="left: -1em; top: -1em">Vendor</sup> </span>
                  </div>
                  <div class="card mb-5" style="border-radius: 1rem;">
                    <div class="row g-0">
                     
                      
                        <div class="card-body p-4 p-lg-5 text-black">
                          <form method="POST" action="{{ url('/vendor-register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-outline mb-4">
                              <label for="name" class="h4 fw-bold">Name</label>
                              <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="ex. Pocky"/>

                              @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="email" class="h4 fw-bold">Email</label>
                              <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="ex. pocky@hotmail.com"/>

                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="password" class="h4 fw-bold">Password</label>
                              <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password"/>

                              @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="passwordConfirm" class="h4 fw-bold">Confirm Password</label>
                              <input id="passwordConfirm" type="password" class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" name="passwordConfirm" autocomplete="new-password" placeholder="Confirm password"/>

                              @error('passwordConfirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="selectCanteen" class="h4 fw-bold">Canteen Name</label>
                              <select class="form-select @error('selectCanteen') is-invalid @enderror" id="selectCanteen" name="selectCanteen">
                                <option selected value="">Select existing canteen</option>
                                @foreach ($canteens as $canteen)
                                  <option value="{{ $canteen->id }}">{{ $canteen->name }}</option>
                                @endforeach
                                <option value=-1 >Create new canteen </option>
                              </select>

                              @error('selectCanteen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4" style="display: none">
                              <label for="canteenName" class="h4 fw-bold">Canteen Name</label>
                              <input id="canteenName" type="text" class="form-control form-control-lg @error('canteenName') is-invalid @enderror" name="canteenName" value="{{ old('canteenName') }}" autocomplete="canteenName" placeholder="ex. Canteen Pocky"/>

                              @error('canteenName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>


                            <div class="form-outline mb-4">
                              <label for="storeName" class="h4 fw-bold">Store Name</label>
                              <input id="storeName" type="text" class="form-control form-control-lg @error('storeName') is-invalid @enderror" name="storeName" value="{{ old('storeName') }}" autocomplete="StoreName" placeholder="ex. Canteen Pocky"/>

                              @error('storeName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>


                            <div class="form-outline mb-4">
                              <label for="phoneno" class="h4 fw-bold">Phone Number</label>
                              <input id="phoneno" type="text" class="form-control form-control-lg @error('phoneno') is-invalid @enderror" name="phoneno" value="{{ old('phoneno') }}" autocomplete="phoneno" placeholder="ex. 08XXXXXXXX"/>

                              @error('phoneno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="address" class="h4 fw-bold">Address</label>
                              <textarea id="address" type="textbox" class="form-control form-control-lg @error('address') is-invalid @enderror" name="address" style="height: 100px" value="{{ old('address') }}" autocomplete="address" placeholder="ex. Best bakmie in town"></textarea>

                              @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="desc" class="h4 fw-bold">Description</label>
                              <textarea id="desc" type="textbox" class="form-control form-control-lg @error('desc') is-invalid @enderror" name="desc" style="height: 100px" value="{{ old('desc') }}" autocomplete="desc" placeholder="ex. Best bakmie in town"></textarea>

                              @error('desc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="profile" class="h4 fw-bold">Profile Image</label>
                              <input class="form-control form-control-sm" id="profile" name="profile" type="file">

                              @error('profile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            
                            <div class="form-outline mb-4">
                              <label for="qris" class="h4 fw-bold">QRIS</label>
                              <input class="form-control form-control-sm" id="qris" name="qris" type="file">

                              @error('qris')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="d-flex justify-content-center pt-1 my-4">
                              <button class="btn btn-dark btn-sm" type="submit">Register</button>
                            </div>

                          </form>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
          {{-- <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>  --}}
          {{-- <script type="text/javascript" src="{{ URL::asset('js/formShowhiddenField.js') }}"></script> --}}
          <script>
            const selectElement = document.querySelector("#selectCanteen");
 
            selectElement.addEventListener("change", (event) => {
              const field = document.querySelector("#canteenName");
              if (event.target.value== (-1)) {
                field.parentElement.style.display ='block';
              }else{
                field.parentElement.style.display ='none';
              }
            });

          </script>
    </body>
      
</html>
