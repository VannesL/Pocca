<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Pocca</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/a18a7749d9.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container py-3">
            <div class="row flex-nowrap align-items-center">
                <div class="col-4">
                    <a href="{{ url('/logout') }}" class="btn btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </div>
                <div class="col-4 d-flex align-items-center justify-content-center text-center">
                    <h2 class="logo mb-0">POCCA</h2>
                </div>
                <div class="col-4 text-center d-flex justify-content-end">
                    @if (auth()->guard('customer')->check() || (auth()->guard('vendor')->check() && auth()->guard('vendor')->user()->approved_by != null))
                        <div class="btn btn-outline-dark rounded-circle">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="w-100">
            <nav class="nav navbar-light bg-light d-flex justify-content-evenly border-top border-bottom">
                @if (auth()->guard('customer')->check())
                    <a class="nav-link text-dark" href="#">Home<span class="sr-only"></a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark" href="#">Order</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark" href="#">History</a>
                @elseif (auth()->guard('vendor')->check() && auth()->guard('vendor')->user()->approved_by != null)
                    <a class="nav-link text-dark" href="#">Orders<span class="sr-only"></a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark" href="#">History</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark" href="#">Menu</a>
                    <div class="vr"></div>
                    <a class="nav-link text-dark" href="#">Sales</a>
                @endif
                
            </nav>
        </div>

        <div class="mt-3">
            @yield('content')
        </div>
    </body>
</html>