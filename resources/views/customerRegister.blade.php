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
              <span class="h5 text-white fw-bold">POCCA</span>
            </div>
            <div class="container py-5 h-100"> 
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                  <div class="d-flex justify-content-center mb-3 pb-1">
                    <span class="h1 text-white fw-bold">Register</span>
                  </div>
                  <div class="card mb-5" style="border-radius: 1rem;">
                    <div class="row g-0">
                     
                      
                        <div class="card-body p-4 p-lg-5 text-black">
                          <form method="POST" action="{{ url('/register') }}">
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
                              <label for="phoneno" class="h4 fw-bold">Phone Number</label>
                              <input id="phoneno" type="number" class="form-control form-control-lg @error('phoneno') is-invalid @enderror" name="phoneno" value="{{ old('phoneno') }}" autocomplete="phoneno" placeholder="ex. 08XXXXXXXX"/>

                              @error('phoneno')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <label for="dob" class="h4 fw-bold">Date of birth</label>
                              <input id="dob" type="date" class="form-control form-control-lg @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" />

                              @error('dob')
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
    </body>
      
</html>
