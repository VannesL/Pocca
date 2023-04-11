<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
    <body>
        <section class="vh-100" style="background: linear-gradient(257deg, rgba(9,9,121,1) 0%, rgba(0,212,255,1) 100%)">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                  <div class="card" style="border-radius: 1rem;">
                    <div class="row g-0">
                     
                      
                        <div class="card-body p-4 p-lg-5 text-black">
                          <form method="POST" action="{{ url('/login') }}">
                            @csrf

                            <div class="d-flex justify-content-center mb-3 pb-1">
                              <span class="h1 fw-bold">POCCA</span>
                            </div>
          
                            <div class="form-outline mb-4">
                              <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email"/>

                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>

                            <div class="form-outline mb-4">
                              <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password"/>

                              @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                            
                            <div class="form-outline mb-4 text-center">
                              <input  id="remember" type="checkbox" name="remember"/>
                              <label for="remember">Remember me</label>
                            </div>

                            <div class="d-flex justify-content-center pt-1 mb-4">
                              <button class="btn btn-dark btn-sm" type="submit">Login</button>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="{{ url('/admin-login') }}" class="mx-auto small text-muted" style="color: #393f81;">Are you an admin?</a>
                                <a href="{{ url('/vendor-login') }}" class="mx-auto small text-muted" style="color: #393f81;">Are you a vendor?</a>
                                <a href="#!" class="mx-auto small text-muted" style="color: #393f81;">Don't have account yet?</a>
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
